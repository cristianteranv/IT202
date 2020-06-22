<?php
require("common.inc.php");
$db = getDB();
$thingId = -1;
if(isset($_GET["thingId"])){
    $thingId = $_GET["thingId"];
    $stmt = $db->prepare("SELECT * FROM Products WHERE id = :id");
    $stmt->execute([":id"=>$thingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "<div>No thingId provided in URL. Need one in order for the form to function properly</div>";
}
?>
<form method="POST">
    <div><label for="product">Product name<input type="text" id="product" name="product" value="<?php echo get($result, "name"); ?>"/> </label></div>
    <div><label for="brand">Brand <input type="text" id="brand" name="brand" value="<?php echo get($result, "brand"); ?>"/> </label></div>
    <div><label for="category">Category <input type="text" id="category" name="category" value="<?php echo get($result, "category"); ?>"/> </label></div>
    <div><label for="price">Price <input type="number" id="price" name="price" value="<?php echo get($result, "price"); ?>"/> </label></div>
    <div><label for="stock">Stock <input type="number" id="stock" name="stock" value="<?php echo get($result, "stock"); ?>"/> </label></div>
    <div><label for="description">Description <input type="text" id="description" name="description" value="<?php echo get($result, "description"); ?>"/> </label></div>
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
                ":id" => $thingId
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
