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
    <?php
		  $id = $_GET['id'];
		  $query="SELECT * FROM glasses where id = $id";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  $row = mysqli_fetch_array($result);
		  ?>

    <h1 class="pageTitle">
      <span><?php echo $row['name_en'];?></span>
    </h1>

    <div class="padding-1em">
    <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for="material">Frame Material:</label>
        <select class="" id="material" name="material">
         <option disabled selected>Material</option>
         <option>Plastic</option>
         <option>Metal</option>
		 </select>
         
         <label for="lens">Lenses:</label>
         <input type="checkbox" name="lens[]" value="Aspheric"> Aspheric <br>
         <input type="checkbox" name="lens[]" value="Polarized"> Polarized <br>
         <input type="checkbox" name="lens[]" value="Anti-reflective"> Anti-reflective <br>
         <input type="checkbox" name="lens[]" value="Scratch-resistant"> Scratch-resistant <br>
         <input type="checkbox" name="lens[]" value="UV protection"> UV protection <br>
        
         <label for="shape">Glasses Shape:</label>
        <select class="" id="shape" name="shape">
         <option disabled selected>Shape</option>
         <option>Geomateric</option>
         <option>Rounded</option>
         <option>Oval</option>
         <option>Navigator</option>
         <option>Square</option>
         <option>Aviator</option>
         <option>Rectangular</option>
		 </select>
         
         <label for="bridge">Size Lens-Bridge:</label>
         <select class="" id="bridge" name="bridge">
         <option disabled selected>Size</option>
         <?php
		 for ($i=14;$i<=24;$i++){
		 ?>
         <option><?php echo $i;?></option>
         <?php } ?>
		 </select>
         
         <label for="temple">Temple Length:</label>
         <select class="" id="temple" name="temple">
         <option disabled selected>Length</option>
         <?php
		 for ($x=120;$x<=150;$x++){
		 ?>
         <option><?php echo $x;?></option>
         <?php } ?>
		 </select>
         
        <input class="button expanded" type="submit" name="submit" value="Add Details">
      </form>
    </div>
    <!-- padding-1em -->

   

    
     <?php
	 if (isset($_POST['submit'])){
	   $material = $_POST['material'];
	   $lens = implode(',', $_POST['lens']);
	   $shape = $_POST['shape'];
	   $bridge = $_POST['bridge'];
	   $temple = $_POST['temple'];
	   
	   $query = mysqli_query($db_conn,"INSERT INTO details (glass_id,frame_material,lenses,shape,temple,bridge) VALUES ('$id','$material','$lens','$shape','$bridge','$temple')");
	   if ($query){
		   $message = "Details has been added.";
				echo "<script type='text/javascript'>alert('$message');</script>";
	   }
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
