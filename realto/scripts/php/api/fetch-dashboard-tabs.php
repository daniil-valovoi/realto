<?php
$tabName = $_GET['tab'];
function sendDashboardTab($tabName) {
    $existingTabs = [
        'profile-and-settings',
        'manage-listings',
        'manage-properties',
        'manage-users',
        'listings',
        'properties',
        'liked-listings',
        'messages',
        'logout',
        'delete-account'
    ];
    $adminTabs = [
        'manage-users',
        'manage-listings',
        'manage-properties'
    ];

    if(in_array($tabName, $existingTabs)) {
        try {
            $path = $_SERVER['DOCUMENT_ROOT'] . '/realto/pages/dashboard/' . $tabName . '.php';
            if(in_array($tabName, $adminTabs)) {
                $path = $_SERVER['DOCUMENT_ROOT'] . '/realto/pages/dashboard/admin/' . $tabName . '.php';
            }
            ob_start();
            require_once $path;
            $tabContent = ob_get_clean();
            if($tabContent && $tabContent!== null && $tabContent!== '') {
                header('Content-Type: application/json');
                echo json_encode(['content' => $tabContent]);
            }
            else {
                throw new Exception("Empty response");
                
            }
        }
        catch(Exception $exception) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $exception->getMessage()]);
        }
    }

    else {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['error' => 'Tab doesn\'t exist']);
    }
}
if($tabName && $tabName!==null && $tabName!=='') {
    sendDashboardTab($tabName);
}
else {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['error' => 'Tab doesn\'t exist/bad request']); 
}