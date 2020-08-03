<?php
require ("config.php");
include("header.php");
?>
<style>
    input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
</style>
<title>Registration</title>
<h1>Register</h1>
<form method="post">
	<label for="email">Email
	<input type="email" id="email" name="email"/>
	</label>
    <label for="fname">First Name
        <input type="text" id="fname" name="fname"/>
    </label>
    <label for="lname">Last Name
        <input type="text" id="lname" name="lname"/>
    </label>
	<label for="p">Password
	<input type="password" id="p" name="password"/>
	</label>
	<label for="cp">Confirm Password
	<input type="password" id="cp" name="cpassword"/>
	</label>
	<input type="submit" name="register" value="Register"/>
</form>

<?php
if(isset($_POST["register"])){
	if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$cpassword = $_POST["cpassword"];
		$email = $_POST['email'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		if (!(empty($password) || empty($email) || empty($cpassword))){
            if ($password == $cpassword) {
                #echo "<div>Passwords Match </div>";
                #require("config.php");
                $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                try {
                    $db = new PDO($connection_string, $dbuser, $dbpass);
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $db->prepare("INSERT INTO Users (email, password, first_name, last_name) VALUES(:email, :password, :fname, :lname)");
                    $stmt->execute(array(
                        ":email" => $email,
                        ":password" => $hash,
                        ":fname" => $fname,
                        ":lname" => $lname
                    ));
                    $e = $stmt->errorInfo();
                    if ($e[0] != "00000") {
                        echo "<div>An account has already been created with that email.</div>";
                    } else {
                        echo "<div>Successfully registered</div>";
                    }
                } catch (Exception $e) {
                    echo "<div>An account has already been created with that email.</div>";
                }
            } else {
                echo "<div>Passwords do not match</div>";
            }
        }
		else{
		    echo "<div>You need to fill all the fields to register.</div>";
        }
	}
	else{
	    echo "<div>Either email, password or confirmation password variables are not set, sorry.</div>";
    }
}
?>