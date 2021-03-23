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
      <span>Update Glasses Details</span>
    </h1>

    <div class="padding-1em">
     <?php
			$id = $_GET['id'];
			$query="SELECT * FROM glasses where id=$id";
			$result= mysqli_query($db_conn, $query) or die("Invalid query");
			$row = mysqli_fetch_array($result);
	  ?>
		<form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for="glassName">Glass name:</label>
        <input type="text" id="glass_en" name="name_en" value="<?php echo $row['name_en']; ?>">
        <label for="glassName">اسم النظارة:</label>
        <input type="text" id="glass_ar" name="name_ar" value="<?php echo $row['name_ar']; ?>">
        
        <label for="brand">Brand:</label>
        <select class="" id="brand_en" name="brand_en">
         <option disabled selected>Brand</option>
                      <?php
						$querys="SELECT * FROM brand";
						$results= mysqli_query($db_conn, $querys) or die("Invalid query");
						while($rowing = mysqli_fetch_array($results)){
						?>
                        <option <?php if ($row['brand_en'] == $rowing['brand_en']) echo 'selected="selected"' ?>><?php echo $rowing['brand_en'];?></option>
                        <?php
                }
         ?>
		</select>
         <label for="brand">الموديل:</label>
        <select class="" id="brand_ar" name="brand_ar">
         <option disabled selected>الموديل</option>
                      <?php
						$querys="SELECT * FROM brand";
						$results= mysqli_query($db_conn, $querys) or die("Invalid query");
						while($rowing = mysqli_fetch_array($results)){
						?>
                        <option <?php if ($row['brand_ar'] == $rowing['brand_ar']) echo 'selected="selected"' ?>><?php echo $rowing['brand_ar'];?></option>
                        <?php
                }
         ?>
		</select>
        
        <label for="color">Color:</label>
        <select class="" id="color_en" name="color_en">
         <option disabled selected>Color</option>
          <option <?php if("Black" == $row['color_en']) echo 'selected="selected"' ?>>Black</option>
          <option <?php if("White" == $row['color_en']) echo 'selected="selected"' ?>>White</option>
          <option <?php if("Blue" == $row['color_en']) echo 'selected="selected"' ?>>Blue</option>
          <option <?php if("Red" == $row['color_en']) echo 'selected="selected"' ?>>Red</option>
          <option <?php if("Green" == $row['color_en']) echo 'selected="selected"' ?>>Green</option>
          <option <?php if("Silver" == $row['color_en']) echo 'selected="selected"' ?>>Silver</option>
          <option <?php if("Brown" == $row['color_en']) echo 'selected="selected"' ?>>Brown</option>
          <option <?php if("Yellow" == $row['color_en']) echo 'selected="selected"' ?>>Yellow</option>
          <option <?php if("Multicolor" == $row['color_en']) echo 'selected="selected"' ?>>Multicolor</option>
		</select>
         <label for="color">اللون:</label>
        <select class="" id="color_ar" name="color_ar">
         <option disabled selected>اللون</option>
         <option <?php if("أسود" == $row['color_ar']) echo 'selected="selected"' ?>>أسود</option>
         <option <?php if("أبيض" == $row['color_ar']) echo 'selected="selected"' ?>>أبيض</option>
         <option <?php if("أزرق" == $row['color_ar']) echo 'selected="selected"' ?>>أزرق</option>
         <option <?php if("أحمر" == $row['color_ar']) echo 'selected="selected"' ?>>أحمر</option>
         <option <?php if("أخضر" == $row['color_ar']) echo 'selected="selected"' ?>>أخضر</option>
         <option <?php if("فضي" == $row['color_ar']) echo 'selected="selected"' ?>>فضي</option>
         <option <?php if("بني" == $row['color_ar']) echo 'selected="selected"' ?>>بني</option>
         <option <?php if("أصفر" == $row['color_ar']) echo 'selected="selected"' ?>>أصفر</option>
         <option <?php if("متعدد الألوان" == $row['color_ar']) echo 'selected="selected"' ?>>متعدد الألوان</option>
		</select>
        
        
         <label for="cat">Category:</label>
        <select class="" id="cat_en" name="cat_en">
         <option disabled selected>Category</option>
                      <?php
						$querys="SELECT * FROM category";
						$results= mysqli_query($db_conn, $querys) or die("Invalid query");
						while($rowing = mysqli_fetch_array($results)){
						?>
                        <option <?php if ($row['category_en'] == $rowing['name_en']) echo 'selected="selected"' ?>><?php echo $rowing['name_en'];?></option>
                        <?php
                }
         ?>
		</select>
        <label for="cat">الصنف:</label>
        <select class="" id="cat_ar" name="cat_ar">
         <option disabled selected>الصنف</option>
                      <?php
						$querys="SELECT * FROM category";
						$results= mysqli_query($db_conn, $querys) or die("Invalid query");
						while($rowing = mysqli_fetch_array($results)){
						?>
                        <option <?php if ($row['category_ar'] == $rowing['name_ar']) echo 'selected="selected"' ?>><?php echo $rowing['name_ar'];?></option>
                        <?php
                }
         ?>
		</select>
        
        <label for="desc">Description:</label>
        <textarea id="desc_en" name="desc_en" rows="5" cols="50"><?php echo $row['description_en']; ?></textarea>
        <label for="desc">الوصف:</label>
        <textarea id="desc_ar" name="desc_ar" rows="5" cols="50"><?php echo $row['description_ar']; ?></textarea>
        
        <label for="warranty">Warranty/الضمان:</label>
        <select class="" id="warranty" name="warranty">
         <option disabled selected>warranty - الضمان</option>
         <option value="no" <?php if ($row['warranty'] == "no") echo 'selected="selected"' ?>>No warranty - بدون ضمان </option>
         <option value="6" <?php if ($row['warranty'] == "6") echo 'selected="selected"' ?>>6 months - 6 شهور</option>
         <option value="12" <?php if ($row['warranty'] == "12") echo 'selected="selected"' ?>>12 months - 12 شهر</option>
         <option value="18" <?php if ($row['warranty'] == "18") echo 'selected="selected"' ?>>18 months - 18 شهر</option>
         <option value="24" <?php if ($row['warranty'] == "24") echo 'selected="selected"' ?>>24 months - 24 شهر</option>
		</select>
        
        <label for="price">Price - السعر:</label>
        <input type="text" id="price" name="price" value="<?php echo $row['price']; ?>">
        <input class="button expanded" type="submit" name="submit" value="UPDATE">
      </form>
    </div>

    
    <?php
	if (isset($_POST['submit'])){
	   $name_en = $_POST['name_en'];
	   $name_ar = $_POST['name_ar'];
	   $brand_en = $_POST['brand_en'];
	   $brand_ar = $_POST['brand_ar'];
	   $color_en = $_POST['color_en'];
	   $color_ar = $_POST['color_ar'];
	   $cat_en = $_POST['cat_en'];
	   $cat_ar = $_POST['cat_ar'];
	   $desc_en = $_POST['desc_en'];
	   $desc_ar = $_POST['desc_ar'];
	   $warranty = $_POST['warranty'];
	   $price = $_POST['price'];
	   
	   $query = mysqli_query($db_conn,"Update glasses SET name_en='$name_en' ,name_ar='$name_ar' ,brand_en='$brand_en' ,brand_ar='$brand_ar' ,color_ar='$color_ar' ,color_en='$color_en' ,category_en='$cat_en' ,category_ar='$cat_ar' ,description_en='$desc_en' ,description_ar='$desc_ar' ,warranty='$warranty' ,price='$price' where id='$id'");
	   if ($query) header("Location: glasses.php");
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
