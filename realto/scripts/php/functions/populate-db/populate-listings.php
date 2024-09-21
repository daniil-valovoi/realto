<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$properties = fetchData('SELECT property_id, user_id, type_id, title FROM properties WHERE status_id = 1');

if (empty($properties)) {
    echo "No active properties found in database. Run populate-properties.php first.<br>\n";
    exit;
}

$rentCount = 0;
$saleCount = 0;
$bothCount = 0;
$skippedCount = 0;

$allowedRentTimes = [5, 10, 20, 25, 30, 60, 90, 180, 365];

echo "--- Populating Listings ---<br>\n";

foreach ($properties as $property) {
    $propertyId = $property['property_id'];
    $userId = $property['user_id'];
    $typeId = (int) $property['type_id'];

    // Check if property is already listed
    $existingListings = fetchData(
        'SELECT COUNT(listing_id) AS cnt FROM listings WHERE property_id = ?',
        ['i', $propertyId],
        'cnt'
    );

    if ((int) $existingListings > 0) {
        $skippedCount++;
        continue;
    }

    // Determine offer type distribution: 45% rent, 45% sale, 10% both
    $roll = rand(1, 100);
    $isRent = false;
    $isSale = false;

    if ($roll <= 45) {
        $isRent = true;
    } elseif ($roll <= 90) {
        $isSale = true;
    } else {
        $isRent = true;
        $isSale = true;
        $bothCount++;
    }

    $connection->begin_transaction();

    try {
        // Create Rent Listing
        if ($isRent) {
            $petFriendly = rand(0, 1);
            $rentPrice = ($typeId === 2) ? rand(12, 60) * 100 : rand(25, 95) * 100;
            $securityDeposit = (int) ($rentPrice * rand(1, 2));
            $minimalRentTime = $allowedRentTimes[array_rand($allowedRentTimes)];

            // Insert into listings (offer_type_id = 1 for rent)
            $listingRentQuery = "
                INSERT INTO listings (property_id, user_id, status_id, offer_type_id)
                VALUES (?, ?, 1, 1)
            ";
            $listingRentStmt = $connection->prepare($listingRentQuery);
            $listingRentStmt->bind_param('ii', $propertyId, $userId);
            $listingRentStmt->execute();
            $rentListingId = $connection->insert_id;

            // Insert into for_rent
            $forRentQuery = "
                INSERT INTO for_rent (
                    listing_id, property_id, user_id, pet_friendly, price,
                    security_deposit, minimal_rent_time, status_id
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, 1
                )
            ";
            $forRentStmt = $connection->prepare($forRentQuery);
            $forRentStmt->bind_param(
                'iiiiiii',
                $rentListingId,
                $propertyId,
                $userId,
                $petFriendly,
                $rentPrice,
                $securityDeposit,
                $minimalRentTime
            );
            $forRentStmt->execute();
            $rentCount++;
        }

        // Create Sale Listing
        if ($isSale) {
            $salePrice = ($typeId === 2) ? rand(18, 90) * 10000 : rand(35, 250) * 10000;

            // Insert into listings (offer_type_id = 2 for sale)
            $listingSaleQuery = "
                INSERT INTO listings (property_id, user_id, status_id, offer_type_id)
                VALUES (?, ?, 1, 2)
            ";
            $listingSaleStmt = $connection->prepare($listingSaleQuery);
            $listingSaleStmt->bind_param('ii', $propertyId, $userId);
            $listingSaleStmt->execute();
            $saleListingId = $connection->insert_id;

            // Insert into for_sale
            $forSaleQuery = "
                INSERT INTO for_sale (
                    listing_id, property_id, user_id, price, status_id
                ) VALUES (
                    ?, ?, ?, ?, 1
                )
            ";
            $forSaleStmt = $connection->prepare($forSaleQuery);
            $forSaleStmt->bind_param(
                'iiii',
                $saleListingId,
                $propertyId,
                $userId,
                $salePrice
            );
            $forSaleStmt->execute();
            $saleCount++;
        }

        $connection->commit();
        $label = ($isRent && $isSale) ? "Both (Rent & Sale)" : ($isRent ? "Rent" : "Sale");
        echo "Listed property ID {$propertyId} ('{$property['title']}') as [{$label}]<br>\n";

    } catch (Exception $e) {
        $connection->rollback();
        echo "Error listing property ID {$propertyId}: " . $e->getMessage() . "<br>\n";
    }
}

echo "<br>\nSummary: Created {$rentCount} rent listings, {$saleCount} sale listings ({$bothCount} dual-listed). Skipped {$skippedCount} already-listed properties.<br>\n";
