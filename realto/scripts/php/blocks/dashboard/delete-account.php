<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$response = [
    'success' => false,
    'message' => null
];

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    $response['message'] = 'No user logged in.';
    returnData($response); // Return response if no user is logged in
    exit;
}

$userId = $_SESSION['user_id'];

// Check if the user exists in the database
$userExists = fetchData('SELECT COUNT(user_id) FROM users WHERE user_id = ?', ['i', $userId], 'COUNT(user_id)');

if ($userExists == 1) {
    // Proceed with deleting the user
    try {
        // Perform the delete operation
        $deleteResult = deleteData('DELETE FROM users WHERE user_id = ?', ['i', $userId]);

        if ($deleteResult) {
            // Clear all cookies
            foreach ($_COOKIE as $cookie_name => $cookie_value) {
                setcookie($cookie_name, '', time() - 3600, '/');  // Expire each cookie
            }

            // Clear the session cookie by expiring it
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }

            // Destroy the session
            session_destroy();

            // Return success and redirect with an alert
            echo '<script>alert("User successfully deleted."); location.href = "/realto/pages/home.php";</script>';
            exit;
        } else {
            throw new Exception("Failed to delete the user from the database.");
        }
    } catch (Exception $exception) {
        // If an error occurs during the deletion, provide feedback
        $response['message'] = 'Error: ' . $exception->getMessage();
        returnData($response);  // Return error message
        exit;
    }
} else {
    $response['message'] = 'User does not exist or has already been deleted.';
    returnData($response);  // Return error message if user is not found
    exit;
}
?>
