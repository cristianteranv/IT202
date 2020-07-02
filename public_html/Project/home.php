<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
require("config.php");
session_start();
?>
<title>Simple Shop</title>
<h1 align="center">Home</h1>
<?php echo "Welcome, " . $_SESSION["user"]["email"]; ?>
<nav>
    <ul>
        <?php
        if (isset($_SESSION["user"])){
            echo "<li><a href='create.php'>Create new product</a> </li>";
            echo "<li><a href='edit.php'>Edit product</a> </li>";
            echo "<li><a href='search.php'>Delete product</a> </li>";
            echo '<li><a href="logout.php">Logout</a></li>';
        }
        else{
            echo "<li><a href=\'register.php\'>Register</a></li>";
            echo "<li><a href='login.php'>Login</a></li>";
        }
        ?>

    </ul>
</nav>