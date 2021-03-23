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
      <span>Update Details</span>
    </h1>

    <div class="padding-1em">
     <?php
				$id = $_GET['id'];
				$query="SELECT * FROM sale where id=$id";
				$result= mysqli_query($db_conn, $query) or die("Invalid query");
				$row = mysqli_fetch_array($result);
			  ?>
				<form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
				<label for="glass">Glass - النظارة:</label>
				<input type="text" id="glass" name="glass" value="<?php echo $row['glass_name']; ?>">
				<label for="discount">Discount - نسبة الخصم:</label>
                <input type="text" id="discount" name="discount" value="<?php echo $row['discount']; ?>">
                <label for="start">Sale Start - بدء التخفيض:</label>
                <input type="text" id="datepicker1" name="start" value="<?php echo $row['start']; ?>">
                <label for="end">Sale end - انتهاء التخفيض:</label>
                <input type="text" id="datepicker2" name="end" value="<?php echo $row['end']; ?>">
				<input class="button expanded" type="submit" name="submit" value="UPDATE">
			  </form>
			</div>
		
			
			<?php
			 if (isset($_POST['submit'])){
			   $glass = $_POST['glass'];
			   $discount = $_POST['discount'];
			   $start = $_POST['start'];
			   $end = $_POST['end'];
			   $query = mysqli_query($db_conn,"Update sale SET glass_name='$glass' ,discount='$discount' ,start='$start' ,end='$end' where id='$id'");
			   if ($query) header("Location: sales.php");
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
