<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$response = ['success' => false, 'message' => null, 'action' => null];

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $response['message'] = 'Not logged in';
    returnData($response);
    exit;
}

$userId = $_SESSION['user_id'];
$listingId = isset($_POST['listing_id']) ? intval($_POST['listing_id']) : 0;

if (!$listingId) {
    $response['message'] = 'Invalid listing id';
    returnData($response);
    exit;
}

$existing = fetchData('SELECT favorite_id FROM favorites WHERE user_id = ? AND listing_id = ?', ['ii', $userId, $listingId]);

if ($existing) {
    deleteData('DELETE FROM favorites WHERE user_id = ? AND listing_id = ?', ['ii', $userId, $listingId]);
    $response['success'] = true;
    $response['action'] = 'removed';
} else {
    insertData('INSERT INTO favorites (user_id, listing_id) VALUES (?, ?)', ['ii', $userId, $listingId]);
    $response['success'] = true;
    $response['action'] = 'added';
}

returnData($response);
