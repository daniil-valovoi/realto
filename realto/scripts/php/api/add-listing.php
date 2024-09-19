<?php
session_start();

require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
restrictAccess();

$userId = $_SESSION['user_id'];

$query = "SELECT p.*, pi.image_name AS main_image, d.district_name, ps.status_name
FROM
properties AS p
JOIN property_images AS pi ON p.main_image_id = pi.image_id
JOIN districts AS d ON p.district_id = d.district_id
JOIN property_statuses AS ps ON p.status_id = ps.status_id
WHERE p.user_id = ? AND p.status_id = 1";
$userProperties = fetchData($query, ['i', $userId]);
$firstProperty = null;

if (!empty($userProperties)) {
        try {
            $displayPropertiesResponse = [
                'empty' => true
            ];
            foreach ($userProperties as $property) {
                $displayPropertiesResponse['properties'][] = $property;
            }
            $displayPropertiesResponse['empty'] = false;
            returnData($displayPropertiesResponse);
        } 
        catch (Exception $exception) {
            returnData($exception);
        }
} 
else {
    returnData('No active properties found');
}