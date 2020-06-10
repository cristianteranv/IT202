<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
<?php
    require("config.php");
    session_start();
?>