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
$query="SELECT * FROM images where id = $id";
$result= mysqli_query($db_conn, $query) or die("Invalid query");
$row = mysqli_fetch_array($result);
$glass_id = $row['glass_id'];
$delete = "DELETE FROM images WHERE id=$id";
$result= mysqli_query($db_conn, $delete) or die("Invalid query");
if ($result) header("Location: add_img.php?id=$glass_id");
			else echo "Error: " . $result . "<br>" . mysqli_error($db_conn);
?>
</body>
</html>