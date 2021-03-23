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
      <span>Brands</span>
      <a data-open="addUser" class="button">add Brand</a>
    </h1>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>Brand Name</th>
          <th>اسم الموديل</th>
          <th>الصورة</th>
          <th class="text-center">Edit</th>
          <th class="text-center">Delete</th>
        </thead>
        <tbody>
         <?php
		  $query="SELECT * FROM brand";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
          <tr>
            <td><?php echo $row['brand_en'];?></td>
            <td><?php echo $row['brand_ar'];?></td>
            <td><img src="../img/brands/<?php echo $row['pic'];?>" style="height:100px; width:200px" alt="brand"></td>
            <td class="text-center editRow"><a href="update.php?b_id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
            <td class="text-center removeRow"><a href="delete_brand.php?id=<?php echo $row['id'];?>"><i class="fa fa-remove"></i></a></td>
          </tr>
          <?php
                }
         ?>
        </tbody>
      </table>
    </div>

    <div class="reveal" id="addUser" data-reveal>
      <h3 class="">
        <span>Add Brand</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <label for="addName">Brand:</label>
        <input type="text" id="brand_en" name="brand_en" value="" placeholder="Brand Name">
        <input type="text" id="brand_ar" name="brand_ar" value="" placeholder="اسم الموديل">
        <input type="file" name="file1" id="file" class="inputfile" />
        <label for="file">Choose Image</label>
        <input class="button expanded" type="submit" name="submit" value="Add Brand">
      </form>
      <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div><!-- reveal -->
    
    <?php
		$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
        $min_file_h = 70;
		$max_file_h = 90;
		$min_file_w = 130;
		$max_file_w = 150;
        $path = "../img/brands/"; // Upload directory
		/*****************************************************/
        if (isset($_POST['submit'])){
            $brand_en = $_POST['brand_en'];
			$brand_ar = $_POST['brand_ar'];
			/***************************************/
			$img1 = $_FILES['file1']['name'];
				if ($_FILES['file1']['error'] == 4) {
                continue; // Skip file if any error found
            }	       
            if ($_FILES['file1']['error'] == 0) {
                list($width,$height) = getimagesize($_FILES["file1"]["tmp_name"]);	           
                if ($height < $min_file_h || $width < $min_file_w) {
					$message = "$img1 is too small!.";
					echo "<script type='text/javascript'>alert('$message');</script>";
                }elseif ($height > $max_file_h || $width > $max_file_w) {
					$message = "$img1 is too big!.";
					echo "<script type='text/javascript'>alert('$message');</script>";
                }
                elseif( ! in_array(pathinfo($img1, PATHINFO_EXTENSION), $valid_formats) ){
					$message = "$img1 is not a valid format";
					echo "<script type='text/javascript'>alert('$message');</script>";
                    }
            else{ // No error found! Move uploaded files 
                  if(move_uploaded_file($_FILES["file1"]["tmp_name"], $path.$img1)) {
			$result = mysqli_query($db_conn,"INSERT INTO brand (brand_en,brand_ar,pic) VALUES ('$brand_en','$brand_ar', '$img1')");
			if ($result){
				$message = "New Brand has been added.تم إضافة موديل جديد";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			else{
				$message = "Error: " . $result . "<br>" . mysqli_error($db_conn);
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			}  
			else {
				// Failure
				$message = "Try again";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}        
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
