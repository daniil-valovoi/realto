<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/validator.php';

function displayProperty() {
    $validator = new Validator();
    $propertyId = $validator->validateNumeric('property id', $_GET['id']);
    if($propertyId) {
        try {
            $query = "SELECT p.*, l.listing_id, d.district_name, pi.image_name, pt.type_name, 
            u.last_name, u.first_name, u.profile_picture, u.email,
            fr.security_deposit, fr.minimal_rent_time, ps.status_name,
            fs.price AS sale_price, 
            fr.price AS rent_price, fr.pet_friendly, 
            CASE
                WHEN fs.property_id = p.property_id AND fr.property_id = p.property_id THEN 'both'
                WHEN fs.property_id = p.property_id THEN 'sale'
                WHEN fr.property_id = p.property_id THEN 'rent'
                ELSE 'none'
            END AS offer_type
            FROM properties AS p
            LEFT JOIN listings AS l ON p.property_id = l.property_id
            LEFT JOIN for_sale AS fs ON p.property_id = fs.property_id
            LEFT JOIN for_rent AS fr ON p.property_id = fr.property_id
            JOIN property_images AS pi ON p.main_image_id = pi.image_id
            JOIN districts AS d ON p.district_id = d.district_id
            JOIN property_types AS pt ON p.type_id = pt.type_id
            JOIN property_statuses AS ps ON p.status_id = ps.status_id
            JOIN users AS u ON p.user_id = u.user_id
            WHERE p.property_id = ?";
            $result = fetchData($query, ['i', $propertyId]);
            if(count($result) > 0) {
                return $result[0];
            }
            throw new Exception('Couldn\'t find a property');
        }
        catch(Exception $exception) {
            return ($exception->getMessage());
        }
    }
}

if(isset($_SERVER['HTTP_AJAX_REQUEST']) && $_SERVER['HTTP_AJAX_REQUEST'] === 'true') {
    $validator = new Validator();
    $query = 'SELECT image_name FROM property_images WHERE property_id = ?';
    $propertyId = $validator->validateNumeric('property id', $_GET['id']);
    $images = fetchData($query, ['s', $propertyId]);

    $query = 'SELECT pi.image_name FROM property_images AS pi
    JOIN properties AS p ON p.main_image_id = pi.image_id 
    WHERE p.property_id = ?
    ';
    $mainImage = fetchData($query, ['i', $propertyId], 'image_name');

    $imagesResponse = [
        'main_image' => $mainImage,
        'images' => $images
    ];
    returnData($imagesResponse);
}
