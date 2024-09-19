<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/validator.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['sign-in-action'];
    $validator = new Validator();
    $email = $validator->validateEmail('email', $_POST['email']);
    $password = $validator->validateString('password', $_POST['password'], 6, 100);
    $userId = null;

    try {
        if($action) {
            if($action === 'log-in') {
                $userId = fetchData('SELECT user_id FROM users WHERE email = ?', ['s', $email], 'user_id');
                if(!$userId) {
                    throw new Exception('User doesn\'t exist');
                }
                $currentPassword = fetchData('SELECT password FROM users WHERE user_id = ?', ['i', $userId], 'password');
                if(!password_verify($password, $currentPassword)) {
                    throw new Exception('Incorrect password');
                }
                $response['success'] = true;
            }
            else if($action === 'sign-up'){
                $firstName = $validator->validateString('first name', $_POST['first-name'], 2, 50);
                $lastName = $validator->validateString('last name', $_POST['last-name'], 2, 50);
                if(!$firstName || !$lastName) {
                    throw new Exception('Invalid name/last name');
                }

                if(fetchData('SELECT email FROM users WHERE email = ?', ['s', $email], 'email')) {
                    throw new Exception('User exists');
                }
                $repeatPassword = $validator->validateString('repeated password', $_POST['repeat-password'], 6, 100);
                if($repeatPassword !== $password) {
                    throw new Exception('Passwords don\'t match');
                }
                $password = password_hash($password, PASSWORD_DEFAULT);
                insertData('INSERT INTO users(role_id, first_name, last_name, email, password) VALUES(?, ?, ?, ?, ?)', 
                ['issss', 1, $firstName, $lastName, $email, $password]);
                $userId = fetchData('SELECT user_id FROM users WHERE email = ?', ['s', $email], 'user_id');
            }
            else {
                throw new Exception('Invalid action');
            }
        }
        else {
            throw new Exception('Not defined action');
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/create-session.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/functions/signature.php';
        createSession($userId);
        returnData(['status' => true]);

    }
    catch(Exception $exception) {
        returnData(['status' => false, 'error' => $exception->getMessage()]);
    }
}