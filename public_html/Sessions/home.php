<?php
include("header.php");

?>
<h4>Home</h4>
<a href="logout.php">Logout</a>
<?php echo "Welcome, " . $_SESSION["user"]["email"]; ?>