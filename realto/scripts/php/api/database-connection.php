<?php
$database_host = "localhost";
$database_login = "root";
$database_password = "root";
$database_name = "realto";

$connection = new mysqli($database_host, $database_login, $database_password, $database_name);
if ($connection->connect_error) {
    die($connection->connect_error);
}