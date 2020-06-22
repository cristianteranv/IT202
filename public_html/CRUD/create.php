<?php
require("common.inc.php");
?>
<form method="POST">
    <label for="product">Product name<input type="text" id="product" name="product"/> </label>
    <label for="brand">Brand <input type="text" id="brand" name="brand"/> </label>
    <label for="category">Category <input type="text" id="category" name="category"/> </label>
    <label for="price">Price <input type="number" id="price" name="price"/> </label>
    <label for="stock">Stock <input type="number" id="stock" name="stock"/> </label>
    <label for="description">Description <input type="text" id="description" name="description"/> </label>
    <input type="submit" name="created" value="Create Product"/>
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
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Products(name, brand, category, price, stock, description) 
                                        VALUES(:product, :brand, :category, :price, :stock, :description)");
        $result = $stmt->execute(array(
            ":product" => $product,
            ":brand" => $brand,
            ":category" => $category,
            ":price" => $price,
            ":stock" => $stock,
            ":description" => $description,
        ));
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            echo var_export($e, true);
        }
        else{
            echo var_export($result, true);
            if($result){
                echo "Succes inserting " . $product . "into the database!";
            }
            else{
                echo "error while inserting record";
            }
        }
    }
    else{
        echo "You need to fill the brand, product name and description fields.";
    }
}
?>
