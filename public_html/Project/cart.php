<?php
    include("header.php");
    require_once("common.inc.php");
    echo "<title>Your cart</title><h1>Cart Items</h1>";
    if(get($_SESSION,"user",false)){
        echo "<div>You are logged in</div>";
    }
    else{
        alert("You need to log in to see your cart.");
        header("login.php");
    }
    $userId = $_SESSION["user"]["id"];
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Carts WHERE userId = :userId");
    $stmt->execute(array("userId"=>$userId));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$results){
        echo "<div>Your cart is empty, time to do some shopping!</div>";
    }
    else{?>
        <ul><li><a>some item</a></li></ul>;
<?php
    }
    echo "<div>it works</div>";
?>
    //if empty
    // your cart is empty :(
    //else
    //  here are the items in your cart:
    //      list
    //  purchase items (remove items from cart, add to orders table)
