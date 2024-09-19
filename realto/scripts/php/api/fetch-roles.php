<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

function fetchRoles() {
    try {
        $roles = fetchData('SELECT * FROM roles');
        return $roles;
    }
    catch(Exception $exception) {
        throw new Exception('Failed to fetch roles: ' . $exception->getMessage());
    }
}