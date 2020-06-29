<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
if(isset($_POST["sort"])){
    $sort = $_POST["sort"];
}
?>

<?php
if(isset($search)) {
    require("common.inc.php");
    try {
        $stmt = getDB()->prepare("SELECT * FROM Products WHERE name LIKE CONCAT('%', :product, '%')");
        //Note: With a LIKE query, we must pass the % during the mapping
        $stmt->execute([":product"=>$search]);
        //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results["status"] = 200;
        $results["results"] = $results;
        $results["sort"] = $sort;
    } catch (Exception $e) {
        $results["status"] = 400;
        $results["error"] = $e->getMessage();
    }
    echo json_encode($results);
}
?>