<?php
include("header.php");
?>
<title>Registration</title>
<h1>Register</h1>
<form method="post">
	<label for="email">Email
	<input type="email" id="email" name="email"/>
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
#echo var_export($_GET, true);
#echo var_export($_POST, true);
#echo var_export($_REQUEST, true);
if(isset($_POST["register"])){
	if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$cpassword = $_POST["cpassword"];
		$email = $_POST['email'];
		if (!(empty($password) || empty($email) || empty($cpassword))){
            if ($password == $cpassword) {
                #echo "<div>Passwords Match </div>";
                #require("config.php");
                $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                try {
                    $db = new PDO($connection_string, $dbuser, $dbpass);
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
                    $stmt->execute(array(
                        ":email" => $email,
                        ":password" => $hash
                    ));
                    $e = $stmt->errorInfo();
                    if ($e[0] != "00000") {
                        echo "<div>An account has already been created with that email.</div>";
                    } else {
                        echo "<div>Succesfully registered</div>";
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