<?php
    include("header.php");
    echo "<title>Your cart</title><h1>Cart Items</h1>";
    if(!isset($_SESSION["user"])){
        flash("You must log in to see your cart.");
        getFlashMessages();
        header("login.php");
    }
    else{
        echo "<div>You are logged in</div>";
    }
    //if empty
    // your cart is empty :(
    //else
    //  here are the items in your cart:
    //      list
    //  purchase items (remove items from cart, add to orders table)
?>