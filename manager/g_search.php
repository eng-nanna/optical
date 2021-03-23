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
              <?php include("../includes/navigator.html"); ?>
  </div><!-- subMenu -->
  <!-- ==== end nav ===== -->

  <!-- ==== Modules Contaner ==== -->
  <div class="medium-9 column moduleContainer">
    <div class="headerBtns">
      <a href="signout.php" class="button">logout</a>
    </div>

    <h1 class="pageTitle">
      <span>Search Results</span>
    </h1>

    <div class="padding-1em">
    <?php 
	  if(isset($_POST['submit'])){ 
			   $name=$_POST['name']; 
			   $sql="SELECT  * FROM glasses WHERE name_ar LIKE '%" . $name .  "%' OR name_en LIKE '%" . $name ."%' OR brand_ar LIKE '%" . $name ."%' OR brand_en LIKE '%" . $name ."%' OR category_en LIKE '%" . $name ."%' OR category_ar LIKE '%" . $name ."%' OR warranty LIKE '%" . $name ."%' OR price LIKE '%" . $name ."%' OR rate LIKE '%" . $name ."%'"; 
		  //-run  the query against the mysql query function 
		  $result=mysqli_query($db_conn,$sql); 
		  $count=mysqli_num_rows($result);
		  if ($count>0){
			  ?>
          <table width="100%">
          <thead>
              <th>Glass Name - اسم النظارة</th>
              <th>category  - الصنف</th>
              <th>brand - النوع</th>
              <th>warranty - الضمان</th>
              <th>price - السعر</th>
              <th>rate - التقييم</th>              
          </thead>
          <tbody>
        <?php
		  //-create  while loop and loop through result set 
		  while($row=mysqli_fetch_array($result)){ 
				  $name_ar = $row['name_ar'];
				  $name_en = $row['name_en'];
				  $cat_ar  = $row['category_ar']; 
				  $cat_en  = $row['category_en']; 
				  $brand_en = $row['brand_en'];
				  $brand_ar = $row['brand_ar'];
				  $warranty  = $row['warranty']; 
				  $price  = $row['price']; 
				  $rate  = $row['rate']; 				  
				  //-display the result of the array 
				  	echo" <tr>";
					if ($name == $name_ar || $name == $name_en)
						echo "<td><strong>$name_en - $name_ar</strong></td>";
					else echo "<td>$name_en - $name_ar</td>";
					if ($name == $cat_en || $name == $cat_ar)
						echo "<td><strong>$cat_en - $cat_ar</strong></td>";
					else echo "<td>$cat_en - $cat_ar</td>";
					if ($name == $brand_en || $name == $brand_en)
						echo "<td><strong>$brand_en - $brand_ar</strong></td>";
					else echo "<td>$brand_en - $brand_ar</td>";
					if ($name == $warranty)
						echo "<td><strong>$warranty</strong></td>";
					else echo "<td>$warranty</td>";
					if ($name == $price)
						echo "<td><strong>$price</strong></td>";
					else echo "<td>$price</td>";
					if ($name == $rate)
						echo "<td><strong>$rate</strong></td>";
					else echo "<td>$rate</td>";
					echo "</tr>"; 
			  }
		  }else echo "<strong>لا توجد نتائج مطابقة</strong> <br>";
	  }else{ 
	  echo  "<p>Please enter a search query</p>"; 
		  }
	?> 
    </tbody>
   </table>
    </div>

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
