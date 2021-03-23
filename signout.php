<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>signing out</title>
</head>

<body>
<?php
include ("includes/config.php");
session_start();
if(session_destroy()) // Destroying All Sessions
{
	header("Location: index.php"); // Redirecting To Home Page
}
?>
</body>
</html>