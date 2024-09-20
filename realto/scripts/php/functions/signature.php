<?php
$secretKey = 'qwerty123';
function createSignature($userId)
{
    global $secretKey;
    $signature = hash_hmac('sha256', $userId, $secretKey);
    $token = $userId . '_' . $signature;
    setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/', '', false, true);
}
function checkSignature($userId)
{
    global $secretKey;
    return hash_hmac('sha256', $userId, $secretKey);
}