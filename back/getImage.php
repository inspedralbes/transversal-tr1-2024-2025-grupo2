<?php

$json = file_get_contents('data.json');
$productsArray = json_decode ($json, true);

foreach($productsArray['products'] as $product) {
    echo "ID: ".$product['id']."<br>" ;
    echo "Title: ".$product['title']."<br>";
    echo "Description: ".$product['description']."<br>";
    echo "<img src='" .$product['image']. "' style= 'width: 200px;'> <br>";
    echo "Price: ".$product['price']." € <br>";
    echo "Category: ".$product['category']."<br>";
    echo "Size: ".$product['size']."<br><br>";
}

?> 