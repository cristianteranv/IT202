<?php
include("header.php");
require ("common.inc.php");
$search = "";
$sort = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
if(isset($_POST["sort"])){
    $sort = $_POST["sort"];
}
?>
<?php
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));

                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productByCode[0]["code"] == $k) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for product"
               value="<?php echo $search;?>"/>
        <input type="radio" name="sort" id="asc" value="asc"/>
        <label for="asc">Ascending</label>
        <input type="radio" name="sort" id="desc" value="desc"/>
        <label for="desc">Descending</label>
        <input type="submit" value="Search"/>
    </form>
    <style>
        li{
            display: table-row;
            height: 30px;
            margin: 10px;
            vertical-align: middle;
        }
        li a {
            display:table-cell;
            vertical-align: middle;
            height:10px;
        }
        ul{
            display: table;
            text-align: center;
            margin: 10px auto;
        }
    </style>
<?php
if(isset($search)) {
    $query = "SELECT * FROM Products WHERE name LIKE CONCAT('%', :product, '%')";
    if (!empty($sort)){
        if($sort == "asc"){
            $query = $query . " ORDER BY name ASC";
        }
        else{
            $query = $query . " ORDER BY name DESC";
        }
    }
    #echo "<div>this is the query: " . $query . "</div>";       UNCOMMENT TO SHOW QUERY ON PAGE
    try {
        $stmt = getDB()->prepare($query);
        //Note: With a LIKE query, we must pass the % during the mapping
        $stmt->execute([":product"=>$search]);
        //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
    <!--This part will introduce us to PHP templating,
    note the structure and the ":" -->
    <!-- note how we must close each check we're doing as well-->
<?php if(isset($results) && count($results) > 0):
    if (empty($sort)){
        echo "<div style='text-align: center; margin: 10px'>Sort value is: None </div>";
    }
    else{
        echo "<div style='text-align: center; margin: 10px'>Sort value is: " . $sort . "</div>";
    }
    ?>
    <ul style="text-align: center">
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
        <li><a>ID</a><a>Name</a><a> </a><a> </a></li>
        <?php foreach($results as $row):?>
            <li>
                <a style="width: 50px"><?php echo get($row, "id")?></a>
                <a style="width: 100px"><?php echo get($row, "name")?></a>
                <a><?php echo get($row, "price")?></a>
                <input type="number" id="purchaseQuantity" value="1"/>
                <input type="submit" value="Add to cart">
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>There are no products matching your search.</p>
<?php endif;?>