<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
require("config.php");
session_start();
?>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="logout.php">Logout</a></li>
        <?php
        if (isset($_SESSION["user"])){
            echo "<li><a href='create.php'>Create new product</a> </li>";
        }
        ?>
    </ul>
</nav>