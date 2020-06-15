<?php
include("header.php");

?>
<h1>Home</h1>
<a href="logout.php">Logout</a>
<?php echo "Welcome, " . $_SESSION["user"]["email"]; ?>