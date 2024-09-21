<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

// Fetch all properties
$saleQuery = "SELECT property_id, user_id, listing_id FROM listings WHERE offer_type_id = 1";
$saleQuery = $connection->prepare($saleQuery);
$saleQuery->execute();
$result = $saleQuery->get_result();
$listings = $result->fetch_all(MYSQLI_ASSOC);
$listings = array_slice($listings, 0, count($listings)/2);

try {
    $connection->begin_transaction();
    foreach($listings as $listing) {
        $listingId = $listing['listing_id'];
        $userId = $listing['user_id'];
        $propertyId = $listing['property_id'];
        $price = random_int(70000, 1000000);

        $query = 'INSERT INTO for_sale(listing_id, user_id, property_id, price, status_id)
        VALUES(?, ?, ?, ?, ?)';
        insertData($query, ['iiiii', $listingId, $userId, $propertyId, $price, 1]);
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