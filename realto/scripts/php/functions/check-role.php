<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/fetch-roles.php';

function checkRole($roleId) {
    $roles = fetchRoles();
    foreach($roles as $role) {
        if($role['role_id'] === $roleId) {
            return $role;
        }
    }
    
    return null;
}