<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';
setcookie('test', 'testtest', 0, '/', '');


$sessionCheckResponse = [
    'logged_in' => false
];

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    setFullUserData();
}

elseif (isset($_COOKIE['user_token'])) {
    $userToken = $_COOKIE['user_token'];
    list($userId, $signature) = explode('_', $userToken);

    require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/functions/signature.php';
    $expectedSignature = checkSignature($userId); 

    if ($signature === $expectedSignature) {
        // Signature is valid, set session variables
        $query = "SELECT * FROM users WHERE user_id = ?";
        $query = $connection->prepare($query);
        $query->bind_param('i', $userId);
        $query->execute();
        $userResult = $query->get_result();

        if ($userResult->num_rows > 0) {
            $user = $userResult->fetch_assoc();

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_picture'] = '/realto/images/user-images/profile-pictures/' . $user['profile_picture'];
            $roleId = $user['role_id'];
            $_SESSION['role'] = fetchData('SELECT role_name FROM roles WHERE role_id = ?', ['i', $roleId], 'role_name');


            setFullUserData();
        }
    }
    else {
        returnData(['signature doesnt match, ->', $expectedSignature, $signature]);
    }
}
else {
    returnData('user token is not set');
}

returnJsonOnly($sessionCheckResponse);

function setFullUserData() {
    global $sessionCheckResponse;
    $sessionCheckResponse['logged_in'] = true;
    $sessionCheckResponse['user'] = [
        'first_name' => $_SESSION['first_name'],
        'last_name' => $_SESSION['last_name'],
        'name' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
        'id' => $_SESSION['user_id'],
        'profile_picture' => $_SESSION['profile_picture'],
        'email' => $_SESSION['email'],
        'role' => $_SESSION['role']
    ];
}

/*function restrictAccess() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
        echo '<script>alert("Not authorized session");</script>';
        echo '<script>setTimeout(function() { window.location.href = "/realto/pages/home.php"; }, 2000);</script>';
        exit;
    }
}*/
