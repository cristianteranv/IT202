<?php
include("header.php");
$search = "";
$sort = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
if(isset($_POST["sort"])){
    $sort = $_POST["sort"];
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
<?php
if(isset($search)) {
    require("common.inc.php");
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
        echo "<div>Sort value is: None </div>";
    }
    else{
        echo "<div>Sort value is: " . $sort . ".</div>";
    }
    ?>
    <ul style="text-align: center">
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
        <?php foreach($results as $row):?>
            <li>
                <a style="width: 50px"><?php echo get($row, "id")?></a>
                <a style="width: 50px"><?php echo get($row, "name")?></a>
                <a style="width: 20px" href="edit.php?productId=<?php echo get($row, "id");?>">Edit</a>
                <a style="width: 20px" href="delete.php?productId=<?php echo get($row, "id");?>">Delete</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>There are no products matching your search.</p>
<?php endif;?>