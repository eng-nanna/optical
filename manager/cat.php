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
      <span>Categories</span>
      <a data-open="addUser" class="button">add Category</a>
    </h1>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>Category Name</th>
          <th>اسم الصنف</th>
          <th class="text-center">Edit</th>
          <th class="text-center">Delete</th>
        </thead>
        <tbody>
         <?php
		  $query="SELECT * FROM category";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
          <tr>
            <td><?php echo $row['name_en'];?></td>
            <td><?php echo $row['name_ar'];?></td>
            <td class="text-center editRow"><a href="update.php?c_id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
                  
            <td class="text-center removeRow"><a href="delete_cat.php?id=<?php echo $row['id'];?>"><i class="fa fa-remove"></i></a></td>
          </tr>
          <?php
                }
         ?>
        </tbody>
      </table>
    </div>

    <div class="reveal" id="addUser" data-reveal>
      <h3 class="">
        <span>Add Category</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <label for="addName">Category:</label>
        <input type="text" id="cat_en" name="cat_en" value="" placeholder="Category Name">
        <input type="text" id="cat_ar" name="cat_ar" value="" placeholder="اسم الصنف">
        <input class="button expanded" type="submit" name="submit" value="Add Category">
      </form>
      <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div><!-- reveal -->
    
    <?php
        if (isset($_POST['submit'])){
            $cat_en = $_POST['cat_en'];
			$cat_ar = $_POST['cat_ar'];
			/***************************************/
			$result = mysqli_query($db_conn,"INSERT INTO category (name_en,name_ar) VALUES ('$cat_en','$cat_ar')");
			if ($result){
				$message = "New category has been added. تم إضافة صنف جديد";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			else{
				$message = "Error: " . $result . "<br>" . mysqli_error($db_conn);
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
