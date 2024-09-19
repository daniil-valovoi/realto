<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/check-session.php';
restrictAccess();
function getUserData($column) {
    global $userId;
    global $connection;
    $query = "SELECT $column FROM users WHERE user_id = $userId";
    $query = $connection->prepare($query);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc()[$column];
}
$userId = $_SESSION['user_id'];
$pageUserName = getUserData('first_name') . ' ' . getUserData('last_name');
$pageUserId = getUserData('user_id');
$userRoleId = getUserData('role_id');
$pageUserProfilePicturePath = '/realto/images/user-images/profile-pictures/' . getUserData('profile_picture');

include_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/functions/check-role.php';
$pageUserRole = ucfirst(checkRole($userRoleId)['role_name']);