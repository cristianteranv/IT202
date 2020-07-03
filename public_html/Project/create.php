<?php
include("header.php");
require("common.inc.php");
$db = getDB();
?>
<style>
    label{
        width: 100px;
        display: inline-block;
        text-align: left;
    }
    div{
        padding: 2px;
    }
    input{
        width: 165px;
    }
    textarea{
        height: 100px;
        width: 165px;
        vertical-align: middle;
        resize: none;
    }
</style>
<form method="POST">
    <div><label for="product" >Product name</label><input type="text" id="product" name="product" width=""/></div>
    <div><label for="brand">Brand</label><input type="text" id="brand" name="brand"/></div>
    <div><label for="category">Category</label><input type="text" id="category" name="category"/></div>
    <div><label for="price">Price</label><input type="number" id="price" name="price"/></div>
    <div><label for="stock">Stock</label><input type="number" id="stock" name="stock" step=".01"/></div>
    <div><label for="description">Description</label><textarea id="description" name="description"></textarea></div>
    <div><input type="submit" name="created" value="Create Product"/></div>
</form>
<?php

if(isset($_POST["created"])){
    $product = $_POST["product"];
    $brand = $_POST["brand"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    if(!empty($brand) && !empty($product)){
        try {
            $stmt = $db->prepare("INSERT INTO Products(name, brand, category, price, stock, description) 
                                        VALUES(:product, :brand, :category, :price, :stock, :description)");
            $result = $stmt->execute(array(
                ":product" => $product,
                ":brand" => $brand,
                ":category" => $category,
                ":price" => $price,
                ":stock" => $stock,
                ":description" => $description
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                echo var_export($result, true);
                if ($result) {
                    echo "Succes inserting " . $product . " into the database!";
                } else {
                    echo "error while inserting record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "You need to fill the brand and product name fields.";
    }
}
?>
