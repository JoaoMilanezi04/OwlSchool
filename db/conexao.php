<?php
$servername = "localhost";   // ou 127.0.0.1
$username   = "root";        // usuário do MySQL Workbench
$password   = "AfonsoPTZ#6113";   // senha que você definiu no MySQL
$dbname     = "olwschool";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
