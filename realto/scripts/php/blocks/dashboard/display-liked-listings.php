<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$response = ['empty' => true];

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    returnData($response);
    exit;
}

$userId = $_SESSION['user_id'];

$listings = fetchData(
    "SELECT l.listing_id, p.title, p.address, p.zip, d.district_name, pi.image_name,
        fs.price AS sale_price, fr.price AS rent_price,
        CASE WHEN fr.property_id IS NOT NULL THEN 1 ELSE 0 END AS is_for_rent,
        CASE WHEN fs.property_id IS NOT NULL THEN 1 ELSE 0 END AS is_for_sale,
        p.property_id
    FROM favorites AS fav
    JOIN listings AS l ON fav.listing_id = l.listing_id
    JOIN properties AS p ON l.property_id = p.property_id
    JOIN property_images AS pi ON p.main_image_id = pi.image_id
    JOIN districts AS d ON p.district_id = d.district_id
    LEFT JOIN for_sale AS fs ON p.property_id = fs.property_id
    LEFT JOIN for_rent AS fr ON p.property_id = fr.property_id
    WHERE fav.user_id = ?",
    ['i', $userId]
);

if ($listings) {
    $response['empty'] = false;
    $response['listings'] = $listings;
}

returnData($response);
