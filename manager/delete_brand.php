<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
session_start();
include ("../includes/config.php");
if(!isset($_SESSION["login_user"]))
{
    header("Location: index.php");
}
$id=$_GET['id'];
$delete = "DELETE FROM brand WHERE id=$id";
$result= mysqli_query($db_conn, $delete) or die("Invalid query");
if ($result) header("Location: brand.php");
			else echo "Error: " . $result . "<br>" . mysqli_error($db_conn);
?>
</body>
</html>