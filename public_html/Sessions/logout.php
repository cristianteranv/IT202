<?php
include("header.php");
#session_start();
session_unset();
session_destroy();
echo "You have logged out";
echo var_export($_SESSION, true);
#up to here, we get session and then delete/clear it
if (ini_get("session.use_cookies")){
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}
?>