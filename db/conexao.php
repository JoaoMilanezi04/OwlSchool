<?php
$servername = "localhost";
$username   = "root";
$password   = "AfonsoPTZ#6113";
$dbname     = "owl_school";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
