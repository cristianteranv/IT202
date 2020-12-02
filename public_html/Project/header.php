<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/public_html/Project/myjs.js"></script>
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
        <div id="cartOrStore">
            <ul>
                <?php if(isset($_SESSION["user"])){
                    echo "<li>
                            <a href='profile.php'>Your profile</a>
                          </li>";
                }
                ?>
                <li>
                    <?php
                        if(isset($_SESSION["user"])){
                            echo "<a href='cart.php'>Cart</a>";
                        }
                        else{
                            echo "<a style='cursor: pointer' onclick='myFunction()'>Cart</a>";
                            echo "<script type='text/javascript'>function myFunction(){alert('You need to log in');window.location = 'https://online-store-ct.herokuapp.com/login.php';}</script>";
                        }

                    ?>
                </li>
            </ul>

        </div>
    </nav>
</header>
