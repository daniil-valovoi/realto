<?php
$sekretKey = 'qwerty123';
function createSignature($userId) {
    global $sekretKey;
    $signature = hash_hmac('sha256', $userId, $sekretKey);  
    $token = $userId . '_' . $signature;
    setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
}
function checkSignature($userId) {
    global $sekretKey;
    return hash_hmac('sha256', $userId, $sekretKey);  
}