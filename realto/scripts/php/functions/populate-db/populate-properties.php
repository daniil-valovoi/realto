<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$users = fetchData('SELECT user_id FROM users', [], 'user_id', false);

if (empty($users)) {
    echo "No users found in database. Run populate-users.php first.<br>\n";
    exit;
}

$adjectives = [
    'Spacious',
    'Cozy',
    'Comfortable',
    'Modern',
    'Elegant',
    'Stylish',
    'Bright',
    'Charming',
    'Luxurious',
    'Inviting',
    'Sunny',
    'Quiet',
    'Stunning',
    'Contemporary',
    'Peaceful'
];

$nouns = [
    'apartment',
    'house',
    'villa',
    'studio',
    'flat'
];

$typeApartment = ['apartment', 'studio', 'flat'];
$typeHouse = ['house', 'villa'];

$streets = [
    'Main St',
    'Park Avenue',
    'Broadway',
    'Elm Street',
    'Maple Drive',
    'Oak Lane',
    'Pine Road',
    'Sunset Boulevard',
    'Cedar Court',
    'Highland Avenue',
    'Ocean Drive',
    'Collins Avenue',
    'Biscayne Blvd',
    'Coral Way',
    'Brickell Ave'
];

// Ensure property-images directory exists
$imageDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/realto/images/property-images/';
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
}

// Load default pool of images
$defaultImagesDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/realto/images/property-images/default-images/';
$availableImages = [];

if (is_dir($defaultImagesDir)) {
    $files = scandir($defaultImagesDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $filePath = $defaultImagesDir . $file;
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (is_file($filePath) && in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $availableImages[] = $filePath;
        }
    }
}

// Fallback if default-images folder is empty
if (empty($availableImages)) {
    $fallbackImage = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/realto/images/website-images/default-property.jpg';
    if (file_exists($fallbackImage)) {
        $availableImages[] = $fallbackImage;
    }
}

$createdCount = 0;
echo "Populating Properties<br>\n";

foreach ($users as $userId) {
    // Generate 1 to 2 properties per user
    $propertiesPerUser = rand(1, 2);

    for ($p = 0; $p < $propertiesPerUser; $p++) {
        $adjective = $adjectives[array_rand($adjectives)];
        $noun = $nouns[array_rand($nouns)];
        $title = "$adjective $noun";
        $description = "A $adjective $noun perfect for comfortable living in a prime location.";
        $street = $streets[array_rand($streets)];
        $streetNumber = rand(10, 9999);
        $address = "$streetNumber $street";
        $zip = rand(33101, 33199);
        $districtId = rand(1, 10);
        $typeId = in_array($noun, $typeApartment) ? 2 : 1;
        $footage = rand(500, 4500);
        $bedrooms = rand(1, 6);
        $bathrooms = rand(1, 5);
        $floor = ($typeId === 2) ? rand(1, 35) : null;
        $buildingFloors = ($typeId === 2) ? rand(5, 40) : rand(1, 3);
        $lotSize = ($typeId === 1) ? rand(1500, 25000) : null;
        $parkingSpots = rand(1, 4);
        $statusId = 1;

        $connection->begin_transaction();

        try {
            $insertPropertyQuery = "
                INSERT INTO properties (
                    user_id, title, description, address, zip, district_id, type_id,
                    footage, bedrooms, bathrooms, floor, building_floors, lot_size,
                    parking_spots, status_id, main_image_id
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )
            ";

            $stmt = $connection->prepare($insertPropertyQuery);
            $mainImagePlaceholder = null;
            $stmt->bind_param(
                'isssiiiiiiiiiiii',
                $userId,
                $title,
                $description,
                $address,
                $zip,
                $districtId,
                $typeId,
                $footage,
                $bedrooms,
                $bathrooms,
                $floor,
                $buildingFloors,
                $lotSize,
                $parkingSpots,
                $statusId,
                $mainImagePlaceholder
            );
            $stmt->execute();
            $propertyId = $connection->insert_id;

            // Pick a random quantity of random images in random order
            $mainImageId = null;

            if (!empty($availableImages)) {
                $shuffledImages = $availableImages;
                shuffle($shuffledImages);

                $maxImages = min(count($shuffledImages), 6);
                $minImages = min(2, $maxImages);
                $imageQuantity = rand($minImages, $maxImages);
                $selectedImages = array_slice($shuffledImages, 0, $imageQuantity);

                foreach ($selectedImages as $sourceImagePath) {
                    $extension = pathinfo($sourceImagePath, PATHINFO_EXTENSION);
                    $uniqueImageName = uniqid($userId . '_', false) . '.' . $extension;
                    $destinationPath = $imageDir . $uniqueImageName;

                    if (copy($sourceImagePath, $destinationPath)) {
                        $imageQuery = "
                            INSERT INTO property_images (property_id, user_id, image_name, alt)
                            VALUES (?, ?, ?, ?)
                        ";
                        $imageStmt = $connection->prepare($imageQuery);
                        $altText = "Image for $title";
                        $imageStmt->bind_param('iiss', $propertyId, $userId, $uniqueImageName, $altText);
                        $imageStmt->execute();
                        $insertedImageId = $connection->insert_id;

                        if ($mainImageId === null) {
                            $mainImageId = $insertedImageId;
                        }
                    }
                }
            }

            // Link first image as main image
            if ($mainImageId !== null) {
                $updateMainImageQuery = "UPDATE properties SET main_image_id = ? WHERE property_id = ?";
                $updateStmt = $connection->prepare($updateMainImageQuery);
                $updateStmt->bind_param('ii', $mainImageId, $propertyId);
                $updateStmt->execute();
            }

            $connection->commit();
            $createdCount++;
            echo "Added property ID {$propertyId}: '{$title}' for user ID {$userId}<br>\n";

        } catch (Exception $e) {
            $connection->rollback();
            echo "Error inserting property for user ID {$userId}: " . $e->getMessage() . "<br>\n";
        }
    }
}

echo "<br>\nSummary: Successfully created {$createdCount} properties.<br>\n";
