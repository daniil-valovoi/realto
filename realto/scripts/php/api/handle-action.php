<?php
session_start();
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/validator.php';
restrictAccess();

$validator = new Validator();

$response = [
    'success' => false,
    'message' => null
];

$userId = $_SESSION['user_id'];
$element = $validator->validateSelection('element', $_POST['target-type'], ['user', 'listing', 'property']);
$elementId = $validator->validateNumeric('element id', $_POST['target-id']);
$action = $validator->validateSelection('action', $_POST['action'], ['delete', 'deactivate', 'activate']);


if($validator->hasErrors()) {
    $errors = $validator->getErrors();
    $response['message'] = reset($errors);
    returnData($response);
}

$query = null;
$column = null;
$table = null;

switch($element) {
    case 'user':
        $column = 'user_id';
        $table = 'users';
        break;

    case 'property':
        $column = 'property_id';
        $table = 'properties';
        break;

    case 'listing':
        $column = 'listing_id';
        $table = 'listings';
        break;

    default:
        $response['message'] = 'Invalid element type';
        returnData($response);
        break;
}
if($_SESSION['role'] === 'user') {
    switch($action) {
        case 'deactivate':
            $query = "UPDATE {$table} SET status_id = 2 WHERE {$column} = ? AND user_id = ?";
            break;

        case 'delete':
            $query = "DELETE FROM {$table} WHERE {$column} = ? AND user_id = ?";
            break;

        case 'activate':
            $query = "UPDATE {$table} SET status_id = 1 WHERE {$column} = ? AND user_id = ?";
            break;

        default:
            $response['message'] = 'Invalid action';
            returnData($response);
            break;
    }
}

if($_SESSION['role'] === 'admin') {
    switch($action) {
        case 'deactivate':
            $query = "UPDATE {$table} SET status_id = 2 WHERE {$column} = ?";
            break;

        case 'delete':
            $query = "DELETE FROM {$table} WHERE {$column} = ?";
            break;

        case 'activate':
            $query = "UPDATE {$table} SET status_id = 1 WHERE {$column} = ?";
            break;

        default:
            $response['message'] = 'Invalid action';
            returnData($response);
            break;
    }
}
if($_SESSION['role'] === 'user') {
    try {
        if(fetchData("SELECT * FROM {$table} WHERE user_id = ? AND {$column} = ?", ['ii', $userId, $elementId])) {
            if($action === 'delete') {
                if(deleteData($query, ['ii', $elementId, $userId])) {
                    $response['success'] = true;
                    returnData($response);
                }
                else {
                    throw new Exception("Failed to delete {$element}");
                }
            }
            else if($action === 'deactivate' || $action === 'activate'){
                if(updateData($query, ['ii', $elementId, $userId])) {
                    $response['success'] = true;
                    returnData($response);
                }
                else {
                    throw new Exception("Error changing {$element} status");
                }
            }
        }
        else {
            throw new Exception("{$element} doesn't exist / invalid operation");
        }
    }
    catch(Exception $exception) {
        $response['message'] = $exception->getMessage();
        returnData($response);
    }
}

if($_SESSION['role'] === 'admin') {
    try {
        if(fetchData("SELECT * FROM {$table} WHERE {$column} = ?", ['i', $elementId])) {
            if($action === 'delete') {
                if(deleteData($query, ['i', $elementId])) {
                    $response['success'] = true;
                    returnData($response);
                }
                else {
                    throw new Exception("Failed to delete {$element}");
                }
            }
            else if($action === 'deactivate' || $action === 'activate'){
                if(updateData($query, ['i', $elementId])) {
                    $response['success'] = true;
                    returnData($response);
                }
                else {
                    throw new Exception("Error changing {$element} status");
                }
            }
        }
        else {
            throw new Exception("{$element} doesn't exist / invalid operation");
        }
    }
    catch(Exception $exception) {
        $response['message'] = $exception->getMessage();
        returnData($response);
    }
}
