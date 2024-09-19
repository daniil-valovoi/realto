<?php
require_once "database-connection.php";

function fetchStatuses($connection) {
    $query = $connection->prepare("SELECT * FROM property_statuses 
    WHERE status_name = 'active' 
    OR status_name = 'inactive'");
    $query->execute();
    $response = $query->get_result();
    $result = [];

    while($row = $response->fetch_assoc()) {
        $result[] = $row;
    }

    //$query->close();  
    return $result;
}

if (isset($_SERVER['HTTP_AJAX_REQUEST']) && $_SERVER['HTTP_AJAX_REQUEST'] === 'true') {
    try {
        $result = fetchStatuses($connection);
        header('Content-Type: application/json');
        echo json_encode($result);
    } 
    catch (Exception $exception) {
        http_response_code(500);
        echo json_encode(['error' => $exception->getMessage()]);
    }
}
