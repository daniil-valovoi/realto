<?php
require_once './database-connection.php';

// Step 1: Add properties from the 'properties' table to 'for_sale' (property_id 81 to 108)
$selectForSale = $connection->prepare("SELECT * FROM properties WHERE property_id BETWEEN 81 AND 108");
$selectForSale->execute();
$propertiesForSale = $selectForSale->get_result();

// Debugging: Check if any properties were found
if ($propertiesForSale->num_rows > 0) {
    echo "Found " . $propertiesForSale->num_rows . " properties to transfer from properties to for_sale.<br>";
    foreach ($propertiesForSale as $property) {
        $insertForSale = $connection->prepare("INSERT INTO for_sale
        (property_id, user_id, title, description, price, status_id)
        VALUES (?, ?, ?, ?, ?, ?)
        ");
        $propertyId = $property['property_id'];
        $userId = $property['user_id'];
        $title = $property['title'];
        $description = $property['description'];
        $statusId = 1;

        $price = random_int(50, 400) * 10;
        $price = ceil($price / 100) * 100;
        $multiplicator = random_int(50, 500);
        $multiplicator = ceil($multiplicator / 100) * 100;
        $price = (int)$price * $multiplicator;

        if ($property['type_id'] == 2) {
            $price -= 120000;
            if ($price > 600000) {
                $price -= 140000;
            }
            if ($price < 120000) {
                $price += 70000;
            }
        }

        $insertForSale->bind_param(
            'iissii', 
            $propertyId, $userId, $title, $description, $price, $statusId
        );
        $insertForSale->execute();
    }
} else {
    echo "No properties found for for_sale between 81 and 108.<br>";
}

// Step 2: Add properties from the 'properties' table to 'for_rent' (property_id >= 109)
$selectForRent = $connection->prepare("SELECT * FROM properties WHERE property_id >= 109");
$selectForRent->execute();
$propertiesForRent = $selectForRent->get_result();

// Debugging: Check if any properties were found
if ($propertiesForRent->num_rows > 0) {
    echo "Found " . $propertiesForRent->num_rows . " properties to transfer from properties to for_rent.<br>";
    foreach ($propertiesForRent as $property) {
        $insertForRent = $connection->prepare("INSERT INTO for_rent
        (property_id, user_id, title, description, pet_friendly, price, security_deposit, minimal_rent_time, status_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $propertyId = $property['property_id'];
        $userId = $property['user_id'];
        $title = $property['title'];
        $description = $property['description'];
        $petFriendly = random_int(0, 1);
        $price = random_int(50, 400) * 10;
        $price = (int)ceil($price / 100) * 100;
        $securityDeposit = (int)$price * random_int(1, 3);
        $allowedRentTime = [7, 10, 15, 20, 30, 60, 90, 120];
        $minimalRentTime = $allowedRentTime[random_int(0, 7)];
        $statusId = 1;

        $insertForRent->bind_param(
            'iissiiiii', 
            $propertyId, $userId, $title, $description, $petFriendly, $price, $securityDeposit, $minimalRentTime, $statusId
        );
        $insertForRent->execute();
    }
} else {
    echo "No properties found for for_rent with property_id >= 109.<br>";
}

// Step 3: Move properties from for_sale (property_id 81 to 91) to for_rent
$selectForSale = $connection->prepare("SELECT * FROM for_sale WHERE property_id BETWEEN 81 AND 91");
$selectForSale->execute();
$propertiesForSale = $selectForSale->get_result();

// Debugging: Check if any properties were found
if ($propertiesForSale->num_rows > 0) {
    echo "Found " . $propertiesForSale->num_rows . " properties to transfer from for_sale to for_rent.<br>";
    foreach ($propertiesForSale as $property) {
        $insertForRent = $connection->prepare("INSERT INTO for_rent
        (property_id, user_id, title, description, pet_friendly, price, security_deposit, minimal_rent_time, status_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $propertyId = $property['property_id'];
        $userId = $property['user_id'];
        $title = $property['title'];
        $description = $property['description'];
        $petFriendly = random_int(0, 1);
        $price = random_int(50, 400) * 10;
        $price = (int)ceil($price / 100) * 100;
        $securityDeposit = (int)$price * random_int(1, 3);
        $allowedRentTime = [7, 10, 15, 20, 30, 60, 90, 120];
        $minimalRentTime = $allowedRentTime[random_int(0, 7)];
        $statusId = 1;

        $insertForRent->bind_param(
            'iissiiiii', 
            $propertyId, $userId, $title, $description, $petFriendly, $price, $securityDeposit, $minimalRentTime, $statusId
        );
        $insertForRent->execute();
    }
} else {
    echo "No properties found for for_sale between 81 and 91.<br>";
}

// Step 4: Move properties from for_rent (property_id 109 to 119) to for_sale
$selectForRent = $connection->prepare("SELECT * FROM for_rent WHERE property_id BETWEEN 109 AND 119");
$selectForRent->execute();
$propertiesForRent = $selectForRent->get_result();

// Debugging: Check if any properties were found
if ($propertiesForRent->num_rows > 0) {
    echo "Found " . $propertiesForRent->num_rows . " properties to transfer from for_rent to for_sale.<br>";
    foreach ($propertiesForRent as $property) {
        $insertForSale = $connection->prepare("INSERT INTO for_sale
        (property_id, user_id, title, description, price, status_id)
        VALUES (?, ?, ?, ?, ?, ?)
        ");
        $propertyId = $property['property_id'];
        $userId = $property['user_id'];
        $title = $property['title'];
        $description = $property['description'];
        $statusId = 1;

        $price = random_int(50, 400) * 10;
        $price = ceil($price / 100) * 100;
        $multiplicator = random_int(50, 500);
        $multiplicator = ceil($multiplicator / 100) * 100;
        $price = (int)$price * $multiplicator;

        if ($property['type_id'] == 2) {
            $price -= 120000;
            if ($price > 600000) {
                $price -= 140000;
            }
            if ($price < 120000) {
                $price += 70000;
            }
        }

        $insertForSale->bind_param(
            'iissii', 
            $propertyId, $userId, $title, $description, $price, $statusId
        );
        $insertForSale->execute();
    }
} else {
    echo "No properties found for for_rent between 109 and 119.<br>";
}
