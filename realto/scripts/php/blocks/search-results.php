<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/validator.php';

$validator = new Validator();

$propertyType = isset($_GET['property-type']) ? $validator->validateSelection('property type', $_GET['property-type'], ['houses', 'apartments', 'all']) : 'all';

// Check if 'offer-type' is set in the GET request
$offerType = isset($_GET['offer-type']) ? $validator->validateSelection('offer type', $_GET['offer-type'], ['for-sale', 'for-rent', 'all']) : 'all';

// Check if 'district' is set in the GET request
$allowedDistricts = fetchData('SELECT district_name FROM districts', null, 'district_name', false);
if (isset($_GET['district'])) {
    $district = $validator->validateSelection('district', $_GET['district'], $allowedDistricts);
}
else {
    $district = $allowedDistricts[0];
}


/*if($validator->hasErrors()) {
    returnData([$validator->getErrors(), $propertyType, $offerType]);
}*/

$query = "SELECT DISTINCT p.*, d.district_name, pi.image_name, pt.type_name, 
    fs.price AS sale_price, 
    fr.price AS rent_price,
    CASE
        WHEN fs.property_id = p.property_id AND fr.property_id = p.property_id THEN 'both'
        WHEN fs.property_id = p.property_id THEN 'sale'
        WHEN fr.property_id = p.property_id THEN 'rent'
        ELSE 'none'
    END AS offer_type,

    CASE WHEN fr.property_id IS NOT NULL THEN 1
        ELSE 0
        END AS is_for_rent,

    CASE WHEN fs.property_id IS NOT NULL THEN 1
        ELSE 0
        END AS is_for_sale

    FROM properties AS p
    JOIN listings AS l ON p.property_id = l.property_id
    LEFT JOIN for_sale AS fs ON p.property_id = fs.property_id
    LEFT JOIN for_rent AS fr ON p.property_id = fr.property_id
    JOIN property_images AS pi ON p.main_image_id = pi.image_id
    JOIN districts AS d ON p.district_id = d.district_id
    JOIN property_types AS pt ON p.type_id = pt.type_id"
;

$whereClauses = ['p.status_id = 1'];
$paramTypes = [];
$paramValues = [];

switch($propertyType) {
    case 'houses':
        $whereClauses[] ='p.type_id = 1';
        break;

    case 'apartments':
        $whereClauses[] ='p.type_id = 2';
        break;

    case 'all':
        break;
}

switch($offerType) {
    case 'for-sale':
        $whereClauses[] = 'l.offer_type_id = 2';
        break;

    case 'for-rent':
        $whereClauses[] = 'l.offer_type_id = 1';
        $offerType = 1;
        break;

    case 'all':
        break;
}

if($district) {
    $whereClauses[] = 'd.district_name = ?';
    $paramTypes[] = 's';
    $paramValues[] = $district; 
}

$response = [
    'empty' => true,
    'listings' => ''
];

$query = $query . ' WHERE ' . implode(' AND ', $whereClauses);
//returnData($query);
$listings = fetchData($query, [implode('', $paramTypes), implode(', ', $paramValues)]);

if(count($listings) > 0) {
    $response['empty'] = false;
    $response['listings'] = $listings;
}

returnData($response);
