<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
session_start();
include ("includes/config.php");

$id=$_REQUEST['id'];
$delete = "DELETE FROM cart WHERE id=$id";
$result= mysqli_query($db_conn, $delete) or die("Invalid query");
if ($result) header('Location: ' . $_SERVER['HTTP_REFERER']);
else echo "Error: " . $result . "<br>" . mysqli_error($db_conn);
?>
</body>
</html>