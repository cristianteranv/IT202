<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
include("header.php");
require("config.php");
session_start();
?>
<title>Simple Shop</title>
<?php
if (isset($_SESSION["user"])){
    echo "<div>Welcome, " . $_SESSION["user"]["email"] . "</div>";
}
?>