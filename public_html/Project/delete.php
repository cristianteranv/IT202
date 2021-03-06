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
    echo "<div>No productId provided in URL. Need one in order for the form to function properly</div>";
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
    <div><label for="product">Product name</label><input type="text" id="product" readonly name="product" value="<?php echo get($result, "name"); ?>"/></div>
    <div><label for="brand">Brand</label><input type="text" id="brand" readonly name="brand" value="<?php echo get($result, "brand"); ?>"/></div>
    <div><label for="category">Category</label><input type="text" id="category" readonly name="category" value="<?php echo get($result, "category"); ?>"/></div>
    <div><label for="price">Price  </label><input type="number" id="price" readonly name="price" value="<?php echo get($result, "price"); ?>"/></div>
    <div><label for="stock">Stock  </label><input type="number" id="stock" readonly name="stock" value="<?php echo get($result, "stock"); ?>"/></div>
    <div><label for="description">Description</label><textarea id="description" name="description" readonly><?php echo get($result, "description"); ?></textarea></div>
    <div><input type="submit" name="deleted" value="Delete Product"/></div>
</form>
<?php

if(isset($_POST["deleted"])){
    $product = $_POST["product"];
    $brand = $_POST["brand"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    if($productId > 0 && get($result, "name")){
        try {
                $stmt = $db->prepare("DELETE FROM Products WHERE id=:id");
                $result = $stmt->execute(array(
                    ":id" => $productId
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    echo var_export($result, true);
                    if ($result) {
                        echo "Successfully deleted " . $product . " from the database!";
                    } else {
                        echo "Error while deleting record";
                    }
                }

        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else if ($productId > 0){
        echo "Can't perform deletion because there is no product in the database with the id that was provided.";
    }
    else{
        echo "Can't perform deletion because no productId was provided in URL.";
    }
}
?>
