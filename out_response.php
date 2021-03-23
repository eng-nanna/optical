<?php
session_start();
include ("includes/config.php");

if (isset($_SESSION['user'])){
	$query="SELECT * FROM users where mail='$_SESSION[user]'";
	$result= mysqli_query($db_conn, $query) or die("Invalid query");
	$row = mysqli_fetch_array($result);
}

$id=$_REQUEST['id'];
if(!isset($_SESSION['user'])){
	$guest_id = session_id();
	$sql2 = mysqli_query($db_conn,"INSERT INTO cart (user_id,type,glass_id,quantity) 
						VALUES ('$guest_id','unregistered','$id','1')");
}else{
	$user_id = $row['id'];
	$sql2 = mysqli_query($db_conn,"INSERT INTO cart (user_id,type,glass_id,quantity) 
						VALUES ('$user_id','registered','$id','1')");
}

echo "item added to your cart"
?>
