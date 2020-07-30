<?php
    $price = $_POST["price"];
    $userId = $_POST["userId"];
    $productId = $_POST["productId"];
    $quantity = $_POST["purchaseQuantity"];
    echo "Price: " . $price . "\nUserId: " . $userId. "\nProductId: " . $productId . "\nQuantitiy: " .$quantity;
?>