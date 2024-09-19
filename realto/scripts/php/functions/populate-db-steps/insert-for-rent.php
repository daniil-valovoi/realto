<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

// Fetch all properties
$rentQuery = "SELECT property_id, user_id, listing_id FROM listings WHERE offer_type_id = 1";
$rentQuery = $connection->prepare($rentQuery);
$rentQuery->execute();
$result = $rentQuery->get_result();
$listings = $result->fetch_all(MYSQLI_ASSOC);

try {
    $connection->begin_transaction();
    foreach($listings as $listing) {
        $listingId = $listing['listing_id'];
        $userId = $listing['user_id'];
        $propertyId = $listing['property_id'];
        $petFriendly = rand(0, 1);
        $price = rand(500, 10000);
        $securityDeposit = rand(500, 10000);
        $minimalRentTime = rand(1, 1000);

        $query = 'INSERT INTO for_rent(listing_id, user_id, property_id, pet_friendly, price, security_deposit, minimal_rent_time, status_id)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        insertData($query, ['iiiiiiii', $listingId, $userId, $propertyId, $petFriendly, $price, $securityDeposit, $minimalRentTime, 1]);
        $connection->commit();
    }
}

catch(Exception $exception) {
    $connection->rollback();
    echo $exception->getMessage();
}


/*try {
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
}*/