<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "playlist";
$conn = mysqli_connect($servername, $username, $password, $database)
or die("Connessione al database fallita: " . $conn->connect_error);
?>