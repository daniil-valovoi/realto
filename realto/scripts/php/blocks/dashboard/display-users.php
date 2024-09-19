<?php
session_start();
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

try {
$displayPropertiesResponse = [
    'empty' => true
];
$userProperties = null;

if($_SESSION['role'] === 'admin') {
    $query = "SELECT u.*, 
    COUNT(DISTINCT p.property_id) AS property_count, 
    COUNT(DISTINCT l.listing_id) AS listing_count
    FROM users AS u
    LEFT JOIN properties AS p ON u.user_id = p.user_id
    LEFT JOIN listings AS l ON u.user_id = l.user_id
    GROUP BY u.user_id";

    $userProperties = fetchData($query);
}
if($userProperties) {
    foreach($userProperties as $property) {
        $displayPropertiesResponse['users'][] = $property;
    }
    $displayPropertiesResponse['empty'] = false;
}
returnData($displayPropertiesResponse);
}
catch(Exception $exception) {
    returnData($exception->getMessage());
}
