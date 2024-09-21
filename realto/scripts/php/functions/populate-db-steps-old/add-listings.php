<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$users = fetchData('SELECT user_id FROM users', [], 'user_id', false);

// Fetch all properties
$propertiesQuery = "SELECT property_id, user_id FROM properties";
$propertiesQuery = $connection->prepare($propertiesQuery);
$propertiesQuery->execute();
$propertiesResult = $propertiesQuery->get_result();
$properties = $propertiesResult->fetch_all(MYSQLI_ASSOC);

try {
    $connection->begin_transaction();
    for($i = 0; $i < count($properties); $i++) {
        $property = $properties[$i];
        if($i <= count($properties)/2) { //for rent
            $offerTypeId = 1;
        }
        else {
            $offerTypeId = 2;
        }
        $query = 'INSERT INTO listings(property_id, user_id, status_id, offer_type_id) 
        VALUES(?, ?, ?, ?)';
        insertData($query, ['iiii', $property['property_id'], $property['user_id'], 1, $offerTypeId]);
        $connection->commit();
    }
}

catch(Exception $exception) {
    $connection->rollback();
    echo $exception->getMessage();
}