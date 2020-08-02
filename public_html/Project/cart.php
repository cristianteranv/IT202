<?php
    include("header.php");
    require_once("common.inc.php");
    echo "<title>Your cart</title><h1>Cart Items</h1>";
    if(isset($_SESSION["user"])){
        echo "<div>You are logged in</div>";
    }
    else{
        echo "<div>you are not logged in</div>";
        flash("You must log in to see your cart.");
        getFlashMessages();
        header("login.php");
    }
    /*if(!isset($_SESSION["user"])){
        echo "<div>you are not logged in</div>";
        flash("You must log in to see your cart.");
        getFlashMessages();
        header("login.php");
    }
    else{
        echo "<div>You are logged in</div>";
    }*/
    //if empty
    // your cart is empty :(
    //else
    //  here are the items in your cart:
    //      list
    //  purchase items (remove items from cart, add to orders table)
?>