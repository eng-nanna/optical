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
      <span>Glasses - النظارات</span>
      <a data-open="addUser" class="button">add glasses - أضف نظارة</a>
    </h1>

    <div class="padding-1em">
    <!-- search box -->
        <form  method="post" action="g_search.php"  id="searchform">
        <div class="input-group">
        <input class="input-group-field" type="text" name="name"> 
        <div class="input-group-button">
        <input type="submit" class="button" value="Search" name="submit">
        </div>
        </div>
        </form> <!-- search box -->
        
      <table width="100%">
        <thead>
          <th><a href="glasses.php?sort=name">Glass Name - الاسم</th>
          <th><a href="glasses.php?sort=price">Price -السعر</th>
          <th><a href="glasses.php?sort=cat">category - النوع</th>
          <th><a href="glasses.php?sort=brand">Brand - الموديل</th>
          <th class="text-center">Add details</th>
          <th class="text-center">Add image</th>
          <th class="text-center">Edit</th>
          <th class="text-center">Delete</th>
        </thead>
        <tbody>
        <?php
		  $num_rec_per_page=10;
		  if (isset($_GET["page"])){
		      $page  = $_GET["page"];
		  }else{
			  $page=1;
		  } 
		  $start_from = ($page-1) * $num_rec_per_page;
		  
		  $query="SELECT * FROM glasses";
		  if (isset($_GET["sort"])){
			if ($_GET['sort'] == 'name'){
				$query .= " ORDER BY name_ar";
			}
			elseif ($_GET['sort'] == 'price'){
				$query .= " ORDER BY price";
			}
			elseif ($_GET['sort'] == 'cat'){
				$query .= " ORDER BY category_ar";
			}
			elseif($_GET['sort'] == 'brand'){
				$query .= " ORDER BY brand_ar";
			}
		  }
		  
		  $query .=" LIMIT $start_from, $num_rec_per_page";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
          <tr>
            <td><?php echo $row['name_en']." - ".$row['name_ar'];?></td>
            <td><?php echo $row['price'];?></td>
            <td><?php echo $row['category_en']." - ".$row['category_ar'];?></td>
            <td><?php echo $row['brand_en']." - ".$row['brand_ar'];?></td>
            <td class="text-center addImg"><a href="details.php?id=<?php echo $row['id'];?>"><i class="fa fa-plus"></i></a></td>
            <td class="text-center addImg"><a href="add_img.php?id=<?php echo $row['id'];?>"><i class="fa fa-file-image-o"></i></a></td>
            <td class="text-center editRow"><a href="update_glasses.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
            <td class="text-center removeRow"><a href="delete_glasses.php?id=<?php echo $row['id'];?>"><i class="fa fa-remove"></i></a></td>
          </tr>
          <?php
                }
         ?>
        </tbody>
      </table>
    </div>
    <!-- padding-1em -->

    <ul class="pagination" role="navigation" aria-label="Pagination">
		<?php 
    $sql = "SELECT * FROM glasses"; 
    $rs_result = mysqli_query($db_conn, $sql); //run the query
    $total_records = mysqli_num_rows($rs_result);  //count number of records
    $total_pages = ceil($total_records / $num_rec_per_page); 
    
    echo "<li class='pagination-previous disabled'><a href='glasses.php?page=1'>".'First'."</a><span class='show-for-sr'>page</span></li> "; // Goto 1st page  
    
    for ($i=1; $i<=$total_pages; $i++) { 
                echo "<li><a href='glasses.php?page=".$i."'>".$i."</a></li> "; 
    }; 
    echo "<li class='pagination-next'><a href='glasses.php?page=$total_pages'>".'Last'."</a><span class='show-for-sr'>page</span></a></li> "; // Goto last page
    ?>
    </ul>

    <div class="reveal"  id="addUser" data-reveal>
      <h3 class="">
        <span>Add Glasses</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for="glassName">Glass name:</label>
        <input type="text" id="glass_en" name="name_en" value="" placeholder="Glass Name">
        <label for="glassName">اسم النظارة:</label>
        <input type="text" id="glass_ar" name="name_ar" value="" placeholder="الاسم">
        
        <label for="brand">Brand:</label>
        <select class="" id="brand_en" name="brand_en">
         <option disabled selected>Brand</option>
                      <?php
						$querys="SELECT * FROM brand";
						$results= mysqli_query($db_conn, $querys) or die("Invalid query");
						while($rowing = mysqli_fetch_array($results)){
						?>
                        <option><?php echo $rowing['brand_en'];?></option>
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
                        <option><?php echo $rowing['brand_ar'];?></option>
                        <?php
                }
         ?>
		</select>
        
         <label for="color">Color:</label>
         <select class="" id="color_en" name="color_en">
         <option disabled selected>Color</option>
         <option>Black</option>
         <option>White</option>
         <option>Blue</option>
         <option>Red</option>
         <option>Green</option>
         <option>Silver</option>
         <option>Brown</option>
         <option>Yellow</option>
         <option>Multicolor</option>
		</select>
         <label for="color">اللون:</label>
         <select class="" id="color_ar" name="color_ar">
         <option disabled selected>Color</option>
         <option>أسود</option>
         <option>أبيض</option>
         <option>أزرق</option>
         <option>أحمر</option>
         <option>أخضر</option>
         <option>فضي</option>
         <option>بني</option>
         <option>أصفر</option>
         <option>متعدد الألوان</option>
		</select>
        
         <label for="cat">Category:</label>
        <select class="" id="cat_en" name="cat_en">
         <option disabled selected>Category</option>
                      <?php
						$querys="SELECT * FROM category";
						$results= mysqli_query($db_conn, $querys) or die("Invalid query");
						while($rowing = mysqli_fetch_array($results)){
						?>
                        <option><?php echo $rowing['name_en'];?></option>
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
                        <option><?php echo $rowing['name_ar'];?></option>
                        <?php
                }
         ?>
		</select>
        
        <label for="desc">Description:</label>
        <textarea id="desc_en" name="desc_en" rows="5" cols="50" placeholder="Description"></textarea>
        <label for="desc">الوصف:</label>
        <textarea id="desc_ar" name="desc_ar" rows="5" cols="50" placeholder="الوصف"></textarea>
        
        <label for="warranty">Warranty/الضمان:</label>
        <select class="" id="warranty" name="warranty">
         <option disabled selected>warranty - الضمان</option>
         <option value="no">No warranty - بدون ضمان </option>
         <option value="6">6 months - 6 شهور</option>
         <option value="12">12 months - 12 شهر</option>
         <option value="18">18 months - 18 شهر</option>
         <option value="24">24 months - 24 شهر</option>
		</select>
        
        <label for="quantity">Quantity - الكمية:</label>
        <input type="number" id="quantity" name="quantity" value="" placeholder="Quantity">
        
        <label for="price">Price - السعر:</label>
        <input type="text" id="price" name="price" value="" placeholder="Price">
        
        <input class="button expanded" type="submit" name="submit" value="Add Glasses">
      </form>
      <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div><!-- reveal -->
    
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
	   $quantity = $_POST['quantity'];
	   $warranty = $_POST['warranty'];
	   $price = $_POST['price'];
	   
	   $query = mysqli_query($db_conn,"INSERT INTO glasses (name_en,name_ar,brand_en,brand_ar,color_en,color_ar,category_en,category_ar,description_en,description_ar,quantity,warranty,price) 
			  VALUES ('$name_en','$name_ar','$brand_en','$brand_ar','$color_en','$color_ar','$cat_en','$cat_ar','$desc_en','$desc_ar','$quantity','$warranty','$price')");
	   if ($query){
		   $message = "New Glass has been added. تم إضافة نظارة جديدة";
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
