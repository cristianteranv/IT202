<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/myjs.js"></script>
</head>
<?php
session_start();
?>
<header>
    <nav>
        <div id="menu">
            <ul>
                <li><a href="home.php">Home</a></li>
                <?php
                if (isset($_SESSION["user"])){
                    echo "<li><a href='create.php'>Create new product</a> </li>";
                    echo "<li><a href='search.php'>Search product</a> </li>";
                    echo "<li><a href='logout.php'>Logout</a></li>";
                }
                else{
                    echo "<li><a href='login.php'>Login</a></li>";
                    echo "<li><a href='register.php'>Register</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
</header>