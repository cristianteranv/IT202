<?php
include("header.php");

?>
<h1 align="center">Home</h1>
<a href="logout.php">Logout</a>
<?php echo "Welcome, " . $_SESSION["user"]["email"]; ?>