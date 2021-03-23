<?php
session_start();
include ("../includes/config.php");
if(!isset($_SESSION["login_user"]))
{
    header("Location: index.php");
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin CPanel</title>
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" href="css/fonts/opensans_regular/stylesheet.css" />
  <link rel="stylesheet" href="css/fonts/opensans_bold/stylesheet.css" />
  <link rel="stylesheet" href="css/icons-style/font-awesome.min.css" />

  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <!--<header class="mainHeader">
  <div class="row">
  <div class="medium-3 column logoSection">logo</div>
  <div class="medium-9 column headerBtns">login</div>
</div>
</header> mainHeader -->



<div class="row">
  <!-- nav section -->
  <div class="medium-3 column subMenuContainer">
    <div class="logo-container">
      <a href="#"><img src="../img/logo.png" alt=""></a>
    </div>
    <nav>
      <?php include("../includes/navigator.html"); ?>
    </nav>
  </div><!-- subMenu -->
  <!-- ==== end nav ===== -->

  <!-- ==== Modules Contaner ==== -->
  <div class="medium-9 column moduleContainer">
    <div class="headerBtns">
      <a href="signout.php" class="button">logout</a>
    </div>

    <h1 class="pageTitle">
      <span>Update Contact Details</span>
    </h1>

    <div class="padding-1em">
     <?php
			$id = $_GET['id'];
			$query="SELECT * FROM contact where id=$id";
			$result= mysqli_query($db_conn, $query) or die("Invalid query");
			$row = mysqli_fetch_array($result);
	  ?>
		<form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for="adrs">Address:</label>
        <textarea name="adrs" id="adrs" cols="50" rows="3"><?php echo $row['adrs']; ?></textarea>
        <label for="tel">Telephone:</label>
        <input type="text" id="tel" name="tel" value="<?php echo $row['tel']; ?>">
        <input class="button expanded" type="submit" name="submit" value="UPDATE">
      </form>
    </div>

    
    <?php
	 if (isset($_POST['submit'])){
	   $adrs = $_POST['adrs'];
	   $tel = $_POST['tel'];
	   $query = mysqli_query($db_conn,"Update contact SET adrs='$adrs' ,tel='$tel' where id='$id'");
	   if ($query) echo "Details has been updated";
			else{
				$message = "Error: " . $query . "<br>" . mysqli_error($db_conn);
				echo "<script type='text/javascript'>alert('$message');</script>";
			}  
	 }
	 ?>  

  </div> <!--moduleContainer -->
  <!-- ==== End Modules Contaner ==== -->


</div>

<?php
              include("../includes/footer.html");
   ?>

<script src="js/vendor.min.js"></script>
<script src="js/app.js"></script>
<script>
$(document).foundation();
</script>
</body>
</html>
