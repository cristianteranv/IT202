<?php
include("header.php");
$search = "";
$sort = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
if(isset($_GET["order"])){
    $order = $_POST["order"];
}
else{
    $order = "name";
}
if(isset($_GET["sort"])){
    $sort = $_POST["sort"];
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
    require("common.inc.php");
    $query = "SELECT * FROM Products WHERE name LIKE CONCAT('%', :product, '%')";
    if($sort == "DESC"){
        $query = $query . " ORDER BY " . $order . " " . $sort;
    }
    else{
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
            <a href="?order=name&&sort=<?php echo $sort?>">Name</a>
            <a href="?order=price&&sort=<?php echo $sort?>">Cost</a>
            <a href="?order=popularity&&sort=<?php echo $sort?>">Popularity</a>
            <a href="?order=date&&sort=<?php echo $sort?>">Date added</a>
        </li>
        <?php foreach($results as $row):?>
            <li>
                <a style="width: 50px"><?php echo get($row, "name")?></a>
                <a style="width: 100px"><?php echo get($row, "price")?></a>
                <a style="width: 100px">Popularity</a>
                <a style="width: 100px">Date</a>
                <a style="width: 100px">Add to cart</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>There are no products matching your search.</p>
<?php endif;?>
