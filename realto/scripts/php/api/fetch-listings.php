<?php
if(isset($_GET['variant'])) {
    $variant = $_GET['variant'];

    function getListings($query_util) {
        require_once 'database-connection.php';
        $baseQuery = "SELECT DISTINCT p.*, fs.*, l.date_listed, fr.price AS rent_price, fs.price AS sale_price, pi.image_name, d.district_name,

            CASE WHEN fr.property_id IS NOT NULL THEN 1
            ELSE 0
            END AS is_for_rent,

            CASE WHEN fs.property_id IS NOT NULL THEN 1
            ELSE 0
            END AS is_for_sale

            FROM
            properties AS p
            LEFT JOIN for_sale AS fs ON p.property_id = fs.property_id
            JOIN property_images AS pi ON p.main_image_id = pi.image_id
            JOIN districts AS d ON p.district_id = d.district_id
            JOIN listings AS l ON p.property_id = l.property_id
            LEFT JOIN for_rent AS fr ON p.property_id = fr.property_id
            {$query_util}
            LIMIT 10
            ";

        try {
            $query = $connection->prepare($baseQuery);

            if (!$query) {
                throw new Exception('Failed to prepare statement: ' . $connection->error);
            }

            $query->execute();
            $response = $query->get_result();
            $result = [];

            while($row = $response->fetch_assoc()) {
                $result[] = $row;
            }
                
            header('Content-Type: application/json');
            echo json_encode($result);
        }

        catch(Exception $exception) {
            http_response_code(500);
            echo json_encode(['error' => $exception->getMessage()]);
        }        
    }

    switch ($variant) {
        case 'family-houses':
            $query = 
            "WHERE p.bedrooms > 3 AND p.type_id = 1";
            getListings($query);
            break;
        case 'short-term-rentals':
            $query = 
            "WHERE fr.minimal_rent_time < 30";
            getListings($query);
            break;

        case 'affordable-apartments':
            $query = 'WHERE fs.price < 300000';
            getListings($query);
            break;

        case 'new-to-realto':
            $query = 'WHERE l.date_listed >= CURRENT_TIMESTAMP() - INTERVAL 100 DAY';
            getListings($query);
            break;

        case 'luxury-rentals':
            $query = 'WHERE fr.price > 2000';
            getListings($query);
            break;
        
        default:
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid variant specified']);
            break;
    }

    
}