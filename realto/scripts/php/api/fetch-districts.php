<?php
require_once "database-connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/database-connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

if(isset($_SERVER['HTTP_AJAX_REQUEST']) && $_SERVER['HTTP_AJAX_REQUEST'] === 'true') {
    try {
        returnData(fetchData('SELECT * FROM districts'));
    }

    catch(Exception $exception) {
        returnData($exception->getMessage());
    }
}

else {
    function fetchDistricts($connection) {
        try {
            $query = $connection->prepare("SELECT * FROM districts");
            $query->execute();
            $response = $query->get_result();
            $result = [];
    
            while($row = $response->fetch_assoc()) {
                $result[] = $row;
            }
    
            //$connection->close();
            return $result;            
        }
    
        catch(Exception $exception) {
            die('fetching districts failed,' . ['error' => $exception->getMessage()]);
        }


    }
}

