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
$delete = "DELETE FROM glasses WHERE id=$id";
$result= mysqli_query($db_conn, $delete) or die("Invalid query");
$del = "DELETE FROM images WHERE glass_id=$id";
$res= mysqli_query($db_conn, $del) or die("Invalid query");
if ($result && $res) header("Location: glasses.php");
			else echo "Error: " . $result . " or " . $res . "<br>" . mysqli_error($db_conn);
?>
</body>
</html>