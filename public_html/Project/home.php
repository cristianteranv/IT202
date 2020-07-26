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
    echo "<div style='font-size: 2vw'>Welcome, " . $_SESSION["user"]["email"] . "</div>";
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
    require("common.inc.php");
    $query = "SELECT * FROM Products WHERE " . ($search == "" ? "name" : $filter) .  " LIKE CONCAT('%', :product, '%')";
    if(isset($order)){
        $query = $query . " ORDER BY " . $order . " " . $sort;
    }

    echo "<div>this is the query: " . $query . "</div>";       //UNCOMMENT TO SHOW QUERY ON PAGE
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
        <li>
            <a href="?order=name&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Name</a>
            <a href="?order=price&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Cost</a>
            <a href="?order=category&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Category</a>
            <a href="?order=popularity&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Popularity</a>
            <a href="?order=date&&sort=<?php echo ($sort == "DESC"? "ASC": "DESC")?>">Date added</a>
        </li>
        <?php foreach($results as $row):?>
            <li>
                <a style="width: 50px"><?php echo get($row, "name")?></a>
                <a style="width: 100px"><?php echo get($row, "price")?></a>
                <a style="width: 100px"><?php echo get($row, "category")?></a>
                <a style="width: 100px">Popularity</a>
                <a style="width: 100px"><?php echo get($row, "created")?></a>
                <form method="post" style="width: 150px; height: 50px; padding: 3px; margin: 3px auto auto;">
                    <input type="number" name="purchaseQuantity" value="1" style="width: 50%">
                    <input type="submit" class="subCart" value="Add to cart" style="width: 100%; padding: 3px; margin: 2px;">
                </form>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>There are no products matching your search.</p>
<?php endif;?>
