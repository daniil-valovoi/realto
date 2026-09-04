<?php
session_start();
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

try {
$displayPropertiesResponse = [
    'empty' => true
];
$userProperties = null;

$userId = $_SESSION['user_id'];
if($_SESSION['role'] === 'user') {
    $query = "SELECT p.*, pi.image_name, d.district_name, ps.status_name, l.listing_id,
    u.user_id, l.status_id AS listing_status, l.offer_type_id
    FROM
    properties AS p
    JOIN property_images AS pi ON p.main_image_id = pi.image_id
    JOIN districts AS d ON p.district_id = d.district_id
    JOIN property_statuses AS ps ON p.status_id = ps.status_id
    JOIN listings AS l ON l.property_id = p.property_id
    JOIN users AS u ON u.user_id = l.user_id
    WHERE p.user_id = ?";
    $userProperties = fetchData($query, ['i', $userId]);
}

if($_SESSION['role'] === 'admin') {
    $query = "SELECT p.*, pi.image_name, d.district_name, ps.status_name, l.listing_id, l.status_id AS listing_status, l.offer_type_id
    FROM
    properties AS p
    JOIN property_images AS pi ON p.main_image_id = pi.image_id
    JOIN districts AS d ON p.district_id = d.district_id
    JOIN property_statuses AS ps ON p.status_id = ps.status_id
    JOIN listings AS l ON l.property_id = p.property_id
    JOIN users AS u ON u.user_id = l.user_id";
    $userProperties = fetchData($query);
}
if($userProperties) {
    foreach($userProperties as $property) {
        $displayPropertiesResponse['listings'][] = $property;
    }
    $displayPropertiesResponse['empty'] = false;
}
returnData($displayPropertiesResponse);
}
catch(Exception $exception) {
    returnData($exception);
}
