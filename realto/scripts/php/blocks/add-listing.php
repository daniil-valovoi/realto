<?php
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
function displayFirstProperty($userId) {
    $query = "SELECT p.*, pi.image_name AS main_image, d.district_name, ps.status_name
    FROM
    properties AS p
    JOIN property_images AS pi ON p.main_image_id = pi.image_id
    JOIN districts AS d ON p.district_id = d.district_id
    JOIN property_statuses AS ps ON p.status_id = ps.status_id
    WHERE p.user_id = ? AND p.status_id = 1";
    $userProperties = fetchData($query, ['i', $userId]);
    $firstProperty = null;

    if(!empty($userProperties)) {
        global $firstProperty;
        $firstProperty = $userProperties[0];
    }
    else {
        echo '<script>alert("You have no active properties. Create one, or activate existing properties.")</script>';
        echo '<script>setTimeout(function() { window.location.href = "/realto/pages/add-property.php"; }, 2000);</script>';
        exit;
    }
}
//restrictAccess();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $userId = $_SESSION['user_id'];
    require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/validator.php';
    $response = [
        'success' => 'false',
        'message' => 'null'
    ];
    $validator = new Validator();
    

    try{
        
        $userId = $validator->validateNumeric('user ID', $userId);
        
        $propertyId = $validator->validateSelection(
            'property-id',
            $_POST['property-id'],
            [fetchData('SELECT property_id FROM properties WHERE user_id = ?', ['i', $userId], 'property_id')]
        );

        if(!$propertyId) {
            throw new Exception('Invalid property selected');
            
        }

        $offerTypeId = null;

        $listingType = $validator->validateSelection(
            'listing-type',
            $_POST['listing-type'],
            ['rent', 'sale']
        );

        if(!$listingType) {
            throw new Exception('Invalid listing type');
            
        }

        if($listingType === 'rent') {
            $offerTypeId = 1;
            $count = fetchData('SELECT COUNT(listing_id) FROM listings WHERE property_id = ? AND offer_type_id = ?', ['ii', $propertyId, $offerTypeId], 'COUNT(listing_id)');
            if($count > 0) {
                throw new Exception('Listing for this property already exists');
            }

            $rentPrice = $validator->validateNumeric('price', $_POST['rent-price'], 100, 999999);
            if(!$rentPrice) {
                throw new Exception('Invalid rent price');
                
            }

            $securityDeposit = $validator->validateNumeric('security-deposit', $_POST['security-deposit'], 100, 999999);
            if(!$securityDeposit) {
                throw new Exception('Invalid security deposit');
                
            }

            $minimalRentTime = $validator->validateNumeric('minimal-rent-time', $_POST['minimal-rent-time'], 1, 1000);
            if(!$minimalRentTime) {
                throw new Exception('Invalid rent time');
            }
            
            $petFriendly = $validator->validateSelection(
                'pet-friendly',
                $_POST['pet-friendly'],
                ['yes', 'no']
            );
            if(!$petFriendly) {
                throw new Exception('Invalid pet-friendly field value');
            }

            if($petFriendly === 'yes') {
                $petFriendly = 1;
            }
            if($petFriendly === 'no') {
                $petFriendly = 0;
            }

        }

        if($listingType === 'sale') {
            $offerTypeId = 2;

            if(fetchData('SELECT COUNT(listing_id) FROM listings WHERE property_id = ? AND offer_type_id = ?', ['ii', $propertyId, $offerTypeId], 'COUNT(listing_id)') > 0) {
                throw new Exception('Listing for this property already exists');
            }

            $salePrice = $validator->validateNumeric('price', $_POST['sale-price'], 1000, 99999999);  
            if(!$salePrice) {
                throw new Exception('Invalid sale price');
                
            }
        }

        $statusId = null;

        $status = $validator->validateSelection('status', $_POST['status'], ['active', 'inactive']);
        if(!$status) {
            throw new Exception('Invalid status');
            
        }
        if($status === 'active') {
            $statusId = 1;
        }
        if($status === 'inactive') {
            $statusId = 2;
        }

        $query = 'INSERT INTO listings(property_id, status_id, offer_type_id, user_id) VALUES(?, ?, ?, ?)';
        $params = null;



        try {
            insertData($query, ['iiii', $propertyId, $statusId, $offerTypeId, $userId]);
            
            switch($listingType) {
                case 'rent':
                    $query = 'INSERT INTO for_rent(listing_id, property_id, user_id, pet_friendly, price, security_deposit, minimal_rent_time, status_id) VALUES(LAST_INSERT_ID(), ?, ?, ?, ?, ?, ?, ?)';
                    $params = ['iiiiiii', $propertyId, $userId, $petFriendly, $rentPrice, $securityDeposit, $minimalRentTime, $statusId];
                    break;

                case 'sale':
                    $query = 'INSERT INTO for_sale(listing_id, property_id, user_id, price, status_id) VALUES(LAST_INSERT_ID(), ?, ?, ?, ?)';
                    $params = ['iiii', $propertyId, $userId, $salePrice, $statusId];
                    break;
            }
            insertData($query, $params);
            $response['success'] = true;
            echo "<script>setTimeout(function() { window.location.href = '/realto/pages/property-page.php?id={$propertyId}'; }, 2000);</script>";
            echo '<script>alert("Listing successfully uploaded");</script>';
            exit;
        }
        catch(Exception $exception) {
            throw new Exception('Error inserting listing to the database');
        }
        
    }
    catch(Exception $exception) {
        $response['message'] = $exception->getMessage();
    }

    if($response['message']) {
        echo "<script>alert('{$response['message']}');
        window.history.back();
        </script>";
    }
}
