<?php
    include("header.php");
    echo "<title>Your cart</title><h1>Cart Items</h1>";
    if(is_logged_in(true)){
        echo "<div>You are logged in</div>";
    }
    //if empty
    // your cart is empty :(
    //else
    //  here are the items in your cart:
    //      list
    //  purchase items (remove items from cart, add to orders table)
?>