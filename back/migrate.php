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
$sqlCreate= "CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$sqlCreate= "CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(500) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";


$sqlCreate= "CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `size` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";


$sqlAlter= "ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`)";

$sqlAlter= "ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`category_id`),
  ADD KEY `products_ibfk_2` (`size_id`)";

$sqlAlter= "ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`)";

$sqlAlter= "ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";

$sqlAlter= "ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";


$sqlAlter= "ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";

$sqlAlter= "ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT";
