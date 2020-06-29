<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>

<?php
if(isset($search)) {
    require("common.inc.php");
    try {
        $sort = $_POST["sort"];
        echo "This is the value of sort: " . $sort . "<br>";
        $stmt = getDB()->prepare("SELECT * FROM Products WHERE name LIKE CONCAT('%', :product, '%')");
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
<?php if(isset($results) && count($results) > 0):?>
    <p>Here are the search results.</p>
    <ul>
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "id")?>
                <?php echo get($row, "name");?>
                <a href="delete.php?productId=<?php echo get($row, "id");?>">Delete</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No product names match your search.</p>
<?php endif;?>