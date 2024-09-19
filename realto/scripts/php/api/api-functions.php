<?php
$defaultProfilePictureName = 'default.png';

function returnData($data) {
    if (isset($_SERVER['HTTP_AJAX_REQUEST']) && $_SERVER['HTTP_AJAX_REQUEST'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    return $data;
}

function returnJsonOnly($data) {
    if (isset($_SERVER['HTTP_AJAX_REQUEST']) && $_SERVER['HTTP_AJAX_REQUEST'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

function updateData($query, $params = []) {
    global $connection;
    $query = $connection->prepare($query);
    $query->bind_param(...$params);
    if($query->execute()) {
        return true;
    }
    else {
        return false;
    }
}

function fetchData($query, $params = [], $singleColumn = null, $singleResult = true) {
    global $connection;
    $query = $connection->prepare($query);
    if ($params) {
        $query->bind_param(...$params);
    }
    $query->execute();
    $result = $query->get_result();
    if ($singleColumn) {
        if($singleResult) {
            $data = $result->fetch_assoc();
            return $data ? $data[$singleColumn] : null;
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
        $data[] = $row[$singleColumn];
        }
        return $data; 

    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; 
    }

    return $data;
}

function deleteData($query, $params = []) {
    global $connection;
    $query = $connection->prepare($query);
    if ($params) {
        $query->bind_param(...$params);
    }
    if($query->execute()) {
        return true;
    }
    else {
        return null;
    }
}

function insertData($query, $params = []) {
    global $connection;

    $query = $connection->prepare($query);

    if ($params) {
        $query->bind_param(...$params);
    }

    $query->execute();

    if ($query->error) {
        throw new Exception("Error executing query: " . $query->error);
    }

    // Return the last inserted ID (useful for INSERT queries)
    return $connection->insert_id;
}

function moveFile($validatedFile, $destinationPath, $userId) {
    if (!is_dir($destinationPath) || !is_writable($destinationPath)) {
        throw new Exception("The destination path does not exist or is not writable.");
    }

    $tmpName = $validatedFile['tmp_name'];
    $originalName = $validatedFile['name'];

    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $newFileName = uniqid($userId . '_', false) . '.' . $fileExtension;

    $destinationFile = $destinationPath . $newFileName;

    if (!move_uploaded_file($tmpName, $destinationFile)) {
        throw new Exception("Failed to move the uploaded file to the destination.");
    }

    return $newFileName;
}

/*function setFullUserData() {
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
}*/

function restrictAccess() {
    if(!isset($_SERVER['HTTP_AJAX_REQUEST'])) {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
            echo '<script>alert("Not authorized session");</script>';
            echo '<script>setTimeout(function() { window.location.href = "/realto/pages/home.php"; }, 2000);</script>';
            exit;
        }
    }
}

function restrictAdminAccess() {
    if(!isset($_SERVER['HTTP_AJAX_REQUEST'])) {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['user_role'] != 'admin') {
            echo '<script>alert("Admin access only");</script>';
            echo '<script>setTimeout(function() { window.location.href = "/realto/pages/home.php"; }, 2000);</script>';
            exit;
        }
    }
}



