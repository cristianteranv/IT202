<?php
include("header.php");
require("common.inc.php");
session_start();
?>
<title>Simple Shop</title>
<?php
if (isset($_SESSION["user"])){
    echo "<div>Welcome, " . $_SESSION["user"]["email"] . "</div>";

}
?>