<?php
session_start();
require_once '../api/api-functions.php';
restrictAccess();
try{
    $userId = $_SESSION['user_id'];
} catch (Exception $exception) {
    
}

require_once './validator.php';
require_once '../api/database-connection.php';
require_once '../api/fetch-districts.php';
require_once '../api/fetch-statuses.php';
require_once '../api/fetch-types.php';
require_once '../api/api-functions.php';

$validator = new Validator();

$response = [
    'success' => false,
    'message' => null
];

$title = $validator->validateString('title', $_POST['title'], 0, 75, false);
$description = $validator->validateString('description', $_POST['description'], 0, 5000, false);
$allowedTypes = array_column(fetchTypes($connection), 'type_name');
$type = $validator->validateSelection('property type', $_POST['type'], $allowedTypes);
$footage = $validator->validateNumeric('footage', $_POST['footage'], 100, 999999);
$bedrooms = $validator->validateNumeric('bedrooms', $_POST['bedrooms'], 0, 50);
$bathrooms = $validator->validateNumeric('bathrooms', $_POST['bathrooms'], 0, 50);
$buildingFloors = $validator->validateNumeric('house floors', $_POST['building-floors'], 1, 199);
$floor = null;
$lotSize = null;

if($type === 'house') {
    $lotSize = $validator->validateNumeric('lot size', $_POST['lot-size'], 320, 999999);
}
else {
    $floor = $validator->validateNumeric('floor', $_POST['floor'], 1, 199);
}

$parkingSpots = $validator->validateNumeric('parking spots', $_POST['parking-spots'], 0, 99);
$allowedStatuses = array_column(fetchStatuses($connection), 'status_name');
$status = $validator->validateSelection('status', $_POST['status'], $allowedStatuses);
$allowedDistricts = array_column(fetchDistricts($connection), 'district_name');
$district = $validator->validateSelection('district', $_POST['district'], $allowedDistricts);
$zip = $validator->validateNumeric('zip', $_POST['zip'], 33000, 33999); //example postal codes
$address = $validator->validateString('address', $_POST['address'], 5, 255);

$allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
$images = $validator->validateFiles('property images', $_FILES['images'], 1, 10, $allowedImageTypes, 7);

if ($validator->hasErrors()) {
    $errors = $validator->getErrors();
    $response['message'] = reset($errors);
    die;

}

function getId($element, $table, $value, $connection) {
    $allowedTables = ['property_types', 'property_statuses', 'districts'];
    $allowedElements = ['type', 'status', 'district'];

    if (!in_array($table, $allowedTables) || !in_array($element, $allowedElements)) {
        $response['message'] = 'Invalid table or column';
        die;
    }
    $getIdQuery = $connection->prepare("SELECT {$element}_id FROM {$table} WHERE {$element}_name = ?");
    if($getIdQuery === false) {
        $response['message'] =  "Error retrieving {$element} id";
        die;
    }
    $getIdQuery->bind_param('s', $value);
    $getIdQuery->execute();
    $elementId = $getIdQuery->get_result()->fetch_assoc()["{$element}_id"];
    return $elementId;

}

$typeId = getId('type', 'property_types', $type, $connection);
$statusId = getId('status', 'property_statuses', $status, $connection);
$districtId = getId('district', 'districts', $district, $connection);

$connection->begin_transaction();

try {

    $insertProperty = $connection->prepare("INSERT INTO properties (title, description, address, zip, user_id, district_id, type_id, lot_size, floor, footage, bedrooms, bathrooms, building_floors, parking_spots, status_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($insertProperty === false) {
        throw new Exception("Error preparing query to insert property.");
    }
    $insertProperty->bind_param('sssiiiiiiiiiiii', $title, $description, $address, $zip, $userId, $districtId, $typeId, $lotSize, $floor, $footage, $bedrooms, $bathrooms, $buildingFloors, $parkingSpots, $statusId);
    $insertProperty->execute();
    $propertyId = $connection->insert_id;



    $imagesDirectory = $_SERVER['DOCUMENT_ROOT'] . "/realto/images/property-images/";
    if (!is_dir($imagesDirectory) || !is_writable($imagesDirectory)) {
        throw new Exception("Image directory does not exist or is not writable.");
    }

    $mainImageId = null;
    $mainImageIndex = (int) $_POST['main-image'];
    if (!isset($mainImageIndex) || !isset($images[$mainImageIndex])) {
        throw new Exception("Invalid or missing main image index.");
    }     

    $uploadedImages = [];
    foreach ($images as $index => $tmpName) {
        if (!isset($tmpName)) {
            throw new Exception("Temporary file for image $index is missing or invalid.");
        }
                
        $imageExtension = strtolower(pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($imageExtension, $allowedExtensions)) {
            throw new Exception("Invalid image extension: $imageExtension");
        }
        $imageFileName = uniqid($userId . '_', false) . '.' . $imageExtension;
        $imageUrl = $imagesDirectory . $imageFileName;

        if(move_uploaded_file($tmpName, $imageUrl)) {
            $uploadedImages[] = $imageUrl;
            $insertImage = $connection->prepare("INSERT INTO property_images (property_id, user_id, image_name) VALUES (?, ?, ?)");
            $insertImage->bind_param('iis', $propertyId, $userId, $imageFileName);

            if($insertImage->execute()) {

                if($index === $mainImageIndex) {
                    $mainImageId = $connection->insert_id;
                }

            }
            else {
                throw new Exception("Failed insertng image URL to the database");
            }

        }
        else {
            throw new Exception("Failed uploading image to the server.");
        }
    }


    if ($mainImageId !== null) {
        $attachMainImage = $connection->prepare("UPDATE properties SET main_image_id = ? WHERE property_id = ?");
        $attachMainImage->bind_param('ii', $mainImageId, $propertyId);
        $attachMainImage->execute();

    } else {
        throw new Exception('No main image chosen.');
    }

    $connection->commit();
    $response['success'] = true;
}

catch(Exception $exception) {
    $connection->rollback();
    $response['message'] = "Operation failed" . $exception->getMessage();
    die;
    if(!empty($uploadedImages)) {
        foreach ($uploadedImages as $uploadedImage) {
            if (file_exists($uploadedImage)) {
                unlink($uploadedImage);
            }
        }
    }
}

if($response['success'] == true) {
    echo '<script>
    alert("Property successfully added");
    location.href = "/realto/pages/dashboard.php";
    </script>';
}

else {
    echo '<script>
    alert("Error uploading property");
    history.back();
    </script>';
}

