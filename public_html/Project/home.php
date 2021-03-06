<?php
include("header.php");
$search = "";
$sort = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
if(isset($_POST["filter"])){
    $filter = $_POST["filter"];
}
if(isset($_GET["order"])){
    $order = $_GET["order"];
}
if(isset($_GET["sort"])){
    $sort = $_GET["sort"];
}
else{
    $sort = "DESC";
}
?>
<title>Simple Shop</title>
<?php
if (isset($_SESSION["user"])){
    echo "<div style='font-size: 2vw'>Welcome, " . (empty($_SESSION["user"]["first_name"])? $_SESSION["user"]["email"] : $_SESSION["user"]["first_name"]) . "</div>";
}
?>

<form method="POST">
    <a>Filter: </a>
    <input type="text" name="search" placeholder="Search for product"
           value="<?php echo $search;?>"/>
    <a>By: </a>
    <input type="radio" name="filter" id="name" value="name" checked="checked"/>
    <label for="name">Name</label>
    <input type="radio" name="filter" id="category" value="category"/>
    <label for="category">Category</label>
    <input type="submit" value="Search"/>
</form>

<?php
if(isset($search)) {
    require("common.inc.php");
    $query = "SELECT * FROM Products WHERE " . ($search == "" ? "name" : $filter) .  " LIKE CONCAT('%', :product, '%')";
    if(isset($order)){
        $query = $query . " ORDER BY " . $order . " " . $sort;
    }

    //echo "<div>this is the query: " . $query . "</div>";       //UNCOMMENT TO SHOW QUERY ON PAGE
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
    <ul class="itemList">
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
        <li class="itemHeader">
            <a class="itemCell" href="?order=name&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Name</a>
            <a class="itemCell" href="?order=price&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Cost</a>
            <a class="itemCell" href="?order=category&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Category</a>
            <a class="itemCell" href="?order=popularity&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Popularity</a>
            <a class="itemCell" href="?order=created&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Date added</a>
        </li>
        <?php foreach($results as $row):?>
            <li class="itemListing">
                <a class="itemCell" style="width: 50px"><?php echo get($row, "name")?></a>
                <a class="itemCell" style="width: 100px"><?php echo get($row, "price")?></a>
                <a class="itemCell" style="width: 100px"><?php echo get($row, "category")?></a>
                <a class="itemCell" style="width: 100px">Popularity</a>
                <a class="itemCell" style="width: 100px"><?php echo get($row, "created")?></a>
                <form method="post" class="cartForm">
                    <input type="text" name="login" id="login" value="<?php echo (get($_SESSION, "user", false)?"true":"false"); ?>" hidden>
                    <input type="number" name="price" value="<?php echo get($row, "price")?>" hidden>
                    <input type="number" name="userId" value="<?php echo $_SESSION["user"]["id"]?>" hidden>
                    <input type="number" name="productId" value="<?php echo get($row, "id")?>" hidden>
                    <input type="number" name="purchaseQuantity" value="1" style="width: 30%" min="1">
                    <input type="submit" id="subCart" class="subCart" value="Add to cart" style="width: 70%; padding: 3px; margin: 2px;">
                </form>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>There are no products matching your search.</p>
<?php endif;?>
