<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/validator.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

$response = [
    'success' => null,
    'error' => null
];

$validator = new Validator();

$userId = $_SESSION['user_id'];
$action = $_POST['form-destination'];

if($action === 'general-information') {
    try {
        $name = $validator->validateString('name', $_POST['name'], 2, 75, false);
        $lastName = $validator->validateString('last name', $_POST['last-name'], 2, 75, false);
        //$phoneNumber = $validator->validateNumeric('phone number', $_POST['phone-number'], 1000000, 10000000000, false);
        $newProfilePicture = $validator->validateFile('profile picture', $_FILES['new-profile-picture'], null);
        $deleteProfilePicture = $_POST['delete-profile-picture'] ?? null;


        if($name) {
            updateData('UPDATE users SET first_name = ? WHERE user_id = ?', ['si', $name, $userId]);
        }

        if($lastName) {
            updateData('UPDATE users SET last_name = ? WHERE user_id = ?', ['si', $lastName, $userId]);
        }

        /*if($phoneNumber) {
            updateData('phone', $phoneNumber);
        }*/

        $newProfilePictureName = null;

        if($newProfilePicture) {
            $path = $_SERVER['DOCUMENT_ROOT'] . '/realto/images/user-images/profile-pictures/';
            $newProfilePictureName = moveFile($newProfilePicture, $path, $userId);
            updateData('UPDATE users SET profile_picture = ? WHERE user_id = ?', ['si', $newProfilePictureName, $userId]);
        }

        if($deleteProfilePicture) {
            updateData('UPDATE users SET profile_picture = ? WHERE user_id = ?', ['si', $defaultProfilePictureName, $userId]);
        }
        $response['success'] = true;
    }
    catch(Exception $exception) {
        $response['error'] = $exception->getMessage();
    }
}

if($action === 'login-and-security') {
    try {
        $email = $validator->validateEmail('email', $_POST['email'], false);
        $password = $validator->validateString('password', $_POST['password'],6, 100, false);
        $oldPassword = $validator->validateString('old password', $_POST['old-password'],6, 100, false);
        $newPassword = $validator->validateString('password', $_POST['new-password'], 6, 100, false);
        $repeatNewPassword = $validator->validateString('password', $_POST['repeat-new-password'], 6, 100, false);

        if($email) {
            try {
                if(!$password) {
                    throw new Exception('Invalid password');
                    
                }
                $currentPassword = fetchData('SELECT password FROM users WHERE user_id =?', ['s', $userId], 'password');
                if(!$currentPassword) {
                    throw new Exception('User doesn\'t exist');
                }
                if(!password_verify($password, $currentPassword)) {
                    throw new Exception('Wrong password');
                };
                updateData('UPDATE users SET email = ? WHERE user_id = ?', ['si', $email, $userId]);
                $response['success'] = true;
            }
            catch(Exception $exception) {
                $response['error'] = $exception->getMessage();
            }
        }

        if($newPassword) {
            try {
                if(!$oldPassword) {
                    throw new Exception('Invalid current password');
                }
                if(!$repeatNewPassword || $newPassword!== $repeatNewPassword) {
                    throw new Exception('Passwords dont\' match');
                }
                $currentPassword = fetchData('SELECT password FROM users WHERE user_id =?', ['s', $userId], 'password');
                if(!password_verify($oldPassword, $currentPassword)) {
                    throw new Exception('Wrong password');
                }
                updateData('UPDATE users SET password = ? WHERE user_id = ?', ['si', password_hash($newPassword, PASSWORD_DEFAULT), $userId]);
                $response['success'] = true;
            }
            catch (Exception $exception) {
                $response['error'] = $exception->getMessage();
            }
        }
    }
    catch(Exception $exception) {
        $response['error'] = $exception->getMessage();
    }
}




returnData($response);
