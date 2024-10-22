<?php

// Establim connexio amb la BBDD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "takeOutfit" ;

// Creem la connexio
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection (w3schools) verificaio
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Eliminamos las tablas si existeix
$sqlDrop = "DROP TABLE IF EXISTS categories;";
$sqlDrop = "DROP TABLE IF EXISTS sizes;";
$sqlDrop = "DROP TABLE IF EXISTS products;";

// Missatge de error
if ($conn->query($sqlDrop) === TRUE) {
    echo "<br>Taula elimanada si existia.<br>";
} else {
    echo "Error al elimminar la taula: " . $conn->error . "</br>";
}

// Creacio de las taulas
