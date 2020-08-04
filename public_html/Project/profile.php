<?php
    include("header.php");
    require("common.inc.php");
    $userId = $_SESSION["user"]["id"];
    $stmt = getDB()->prepare("SELECT first_name, last_name, email FROM Users WHERE id = :userId");
    $stmt->execute(array(":userId"=>$userId));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <h1>Edit info</h1>
    <form method="POST">
        <div><label for="fname">First name</label><input type="text" name="fname" value="<?php echo get($result, "first_name"); ?>"/></div>
        <div><label for="lname">Last name</label><input type="text" name="lname" value="<?php echo get($result, "last_name"); ?>"/></div>
        <div><label for="email">Email</label><input type="email" name="email" value="<?php echo get($result, "email"); ?>"/></div>
        <div><label for="password">Password</label><input type="password" name="password" value=""/></div>
        <div><input type="submit" name="editInfo" value="Save changes"/></div>
    </form>
<?php
    if(isset($_POST["editInfo"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = getDB()->prepare("UPDATE Users SET first_name = :fname, last_name = :lname, email = :email, password = :password WHERE id = :userId");
        $stmt->execute(array(
            ":fname" => $fname,
            ":lname" => $lname,
            ":email" => $email,
            ":password" => $hash,
            ":userId" => $userId
        ));
        $e = $stmt->errorInfo();
        if($e[0] != "00000"){
            echo "<div>Something went wrong:\n". var_export($e) ."</div>";
        }
        else{
            echo "<div>Successfully updated</div>";
        }
    }
?>
<h1>Your past orders</h1>
<?php
    $stmt = getDB()->prepare("SELECT DISTINCT orderDate FROM Orders WHERE userId = :userId");
    $stmt->execute(array(":userId"=>$userId));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($results)>0){
        echo "<ul>";
        foreach($results as $row):
            echo "<li>" . get($row, "orderDate") . "</li>";
        endforeach;
        echo "</ul>";
    }
    else{
        echo "<div>You haven't placed any orders. Time to do some shopping!</div>";
    }
?>
