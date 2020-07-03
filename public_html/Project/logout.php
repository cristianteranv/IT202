<?php
require ("config.php");
include("header.php");
#session_start();
session_unset();
session_destroy();
#up to here, we get session and then delete/clear it
if (ini_get("session.use_cookies")){
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}
header("Location: login.php");
?>