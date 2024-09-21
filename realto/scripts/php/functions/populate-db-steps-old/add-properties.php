<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$users = fetchData('SELECT user_id FROM users', [], 'user_id', false);

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
    'Inviting'
];

$nouns = [
    'apartment',
    'house',
    'villa',
    'studio',
    'flat'
];

$typeApartment = [
    'apartment',
    'studio',
    'flat'
];

$typeHouse = [
    'house',
    'villa'
];

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
    'Highland Avenue'
];

// Example image details
$image = 'default.jpg'; // Name of the image in your storage
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/realto/images/property-images/'; // Path to where images are stored

// Generate property records for each user
foreach ($users as $user) {
    $userId = $user;

    // Randomly generate property details
    $adjective = $adjectives[array_rand($adjectives)];
    $noun = $nouns[array_rand($nouns)];
    $title = "$adjective $noun";
    $description = "A $adjective $noun perfect for comfortable living.";
    $street = $streets[array_rand($streets)];
    $streetNumber = rand(1, 9999);
    $address = "$street $streetNumber";
    $zip = rand(33000, 33999);
    $districtId = rand(1, 10);
    $typeId = in_array($noun, $typeApartment) ? 2 : 1;
    $footage = rand(500, 5000);
    $bedrooms = rand(1, 10);
    $bathrooms = rand(1, 10);
    $floor = $typeId === 2 ? rand(1, 100) : null;
    $buildingFloors = $typeId === 2 ? rand(1, 100) : rand(1, 4);
    $lotSize = $typeId === 1 ? rand(1000, 40000) : null;
    $parkingSpots = rand(1, 10);
    $statusId = 1;

    // Start transaction
    $connection->begin_transaction();

    try {
        // Insert property into the database
        $propertyQuery = "
            INSERT INTO properties (
                user_id, title, description, address, zip, district_id, type_id,
                footage, bedrooms, bathrooms, floor, building_floors, lot_size,
                parking_spots, status_id, main_image_id
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )
        ";

        $propertyParams = [
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
            null // main_image_id
        ];

        $stmt = $connection->prepare($propertyQuery);
        $stmt->bind_param(
            'isssiiiiiiiiiiii',
            ...$propertyParams
        );
        $stmt->execute();

        // Get the last inserted property_id
        $propertyId = $connection->insert_id;

        // Copy the image and generate new unique names
        $newFileName = uniqid($userId . '_', false) . '.' . pathinfo($image, PATHINFO_EXTENSION);
        $newFilePath = $imagePath . $newFileName;

        if (!copy($imagePath . $image, $newFilePath)) {
            throw new Exception("Failed to duplicate the image.");
        }

        // Insert the image record into the property_images table
        $imageQuery = "
            INSERT INTO property_images (
                property_id, user_id, image_name, alt
            ) VALUES (
                ?, ?, ?, ?
            )
        ";

        $imageParams = [
            $propertyId,
            $userId,
            $newFileName,
            "Image for $title"
        ];

        $stmt = $connection->prepare($imageQuery);
        $stmt->bind_param('iiss', ...$imageParams);
        $stmt->execute();

        // Get the last inserted image_id
        $imageId = $connection->insert_id;

        // Update the properties table to set the main_image_id
        $updateQuery = "
            UPDATE properties
            SET main_image_id = ?
            WHERE property_id = ?
        ";

        $stmt = $connection->prepare($updateQuery);
        $stmt->bind_param('ii', $imageId, $propertyId);
        $stmt->execute();

        // Commit transaction
        $connection->commit();
    } catch (Exception $e) {
        // Rollback on error
        $connection->rollback();
        error_log("Error inserting property or image: " . $e->getMessage());
    }
}
