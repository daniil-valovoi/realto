<?php
//session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';

function createSession($userId) {
    global $connection;

    $query = "SELECT * FROM users WHERE user_id = ?";
    $query = $connection->prepare($query);

    if (!$query) {
        throw new Exception("Database error: Unable to prepare statement");
    }

    $query->bind_param('i', $userId);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("User not found");
    }

    $user = $result->fetch_assoc();

    if($user['role_id'] === 2) {
        $role = 'admin';
    }
    else {
        $role = 'user';
    }

    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['profile_picture'] = $user['profile_picture'];
    $_SESSION['role'] = $role;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/functions/signature.php';
    createSignature($userId);
}
