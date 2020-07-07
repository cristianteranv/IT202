<?php
include ("header.php");
require("common.inc.php");
$db = getDB();
$productId = -1;
if(isset($_GET["productId"])){
    $productId = $_GET["productId"];
    $stmt = $db->prepare("SELECT * FROM Products WHERE id = :id");
    $stmt->execute([":id"=>$productId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "<div>No productId provided in URL. Need one in order for the form to function properly.</div>";
}
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
    <div><label for="product">Product name</label><input type="text" id="product" name="product" value="<?php echo get($result, "name"); ?>"/></div>
    <div><label for="brand">Brand</label><input type="text" id="brand" name="brand" value="<?php echo get($result, "brand"); ?>"/></div>
    <div><label for="category">Category</label><input type="text" id="category" name="category" value="<?php echo get($result, "category"); ?>"/></div>
    <div><label for="price">Price</label><input type="number" id="price" name="price" step="0.01" value="<?php echo get($result, "price"); ?>"/></div>
    <div><label for="stock">Stock</label><input type="number" id="stock" name="stock" value="<?php echo get($result, "stock"); ?>"/></div>
    <div><label for="description">Description</label><textarea id="description" name="description"><?php echo get($result, "description"); ?></textarea></div>
    <div><input type="submit" name="updated" value="Update Product"/></div>
</form>
<?php

if(isset($_POST["updated"])){
    $product = $_POST["product"];
    $brand = $_POST["brand"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    if(!empty($brand) && !empty($product)){
        try {
            $stmt = $db->prepare("UPDATE Products 
            SET name = :product, brand = :brand, category = :category, price = :price, stock = :stock, description = :description
            WHERE id= :id");
            $result = $stmt->execute(array(
                ":product" => $product,
                ":brand" => $brand,
                ":category" => $category,
                ":price" => $price,
                ":stock" => $stock,
                ":description" => $description,
                ":id" => $productId
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                echo var_export($result, true);
                if ($result) {
                    echo "Success updating " . $product . " in the database!";
                } else {
                    echo "Error while updating record";
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
