<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
session_start();
?>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="register.php">Register</a></li>
        <?php
        if (isset($_SESSION["user"])){
            echo "<li><a href='create.php'>Create new product</a> </li>";
            echo "<li><a href='edit.php'>Edit product</a> </li>";
            echo "<li><a href='search.php'>Delete product</a> </li>";
        }
        else{
            echo "<li><a href='login.php'>Login</a></li>";
        }
        ?>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>