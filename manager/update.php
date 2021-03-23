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
			if(isset($_GET['b_id'])){
				$id = $_GET['b_id'];
				$query="SELECT * FROM brand where id=$id";
				$result= mysqli_query($db_conn, $query) or die("Invalid query");
				$row = mysqli_fetch_array($result);
			  ?>
				<form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
				<label for="brand_en">Brand Name:</label>
				<input type="text" id="brand_en" name="brand_en" value="<?php echo $row['brand_en']; ?>">
				<label for="brand_ar">الموديل:</label>
				<input type="text" id="brand_ar" name="brand_ar"value="<?php echo $row['brand_ar']; ?>">
				<input class="button expanded" type="submit" name="submit" value="UPDATE">
			  </form>
			</div>
		
			
			<?php
			 if (isset($_POST['submit'])){
			   $brand_en = $_POST['brand_en'];
			   $brand_ar = $_POST['brand_ar'];
			   $query = mysqli_query($db_conn,"Update brand SET brand_en='$brand_en' ,brand_ar='$brand_ar' where id='$id'");
			   if ($query) header("Location: brand.php");
					else{
						$message = "Error: " . $query . "<br>" . mysqli_error($db_conn);
						echo "<script type='text/javascript'>alert('$message');</script>";
					}  
			 }
			}elseif (isset($_GET['c_id'])){
				$id = $_GET['c_id'];
				$query="SELECT * FROM category where id=$id";
				$result= mysqli_query($db_conn, $query) or die("Invalid query");
				$row = mysqli_fetch_array($result);
			  ?>
				<form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
				<label for="cat_en">Category Name:</label>
				<input type="text" id="vat_en" name="cat_en" value="<?php echo $row['name_en']; ?>">
				<label for="cat_ar">الموديل:</label>
				<input type="text" id="cat_ar" name="cat_ar"value="<?php echo $row['name_ar']; ?>">
				<input class="button expanded" type="submit" name="submit" value="UPDATE">
			  </form>
			</div>
		
			
			<?php
			 if (isset($_POST['submit'])){
			   $cat_en = $_POST['cat_en'];
			   $cat_ar = $_POST['cat_ar'];
			   $query = mysqli_query($db_conn,"Update category SET name_en='$cat_en' ,name_ar='$cat_ar' where id='$id'");
			   if ($query) header("Location: cat.php");
					else{
						$message = "Error: " . $query . "<br>" . mysqli_error($db_conn);
						echo "<script type='text/javascript'>alert('$message');</script>";
					}  
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
