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
			   $sql="SELECT  * FROM orders WHERE order_num LIKE '%" . $name .  "%' OR price LIKE '%" . $name ."%' OR status_ar LIKE '%" . $name ."%' OR status_en LIKE '%" . $name ."%'"; 
		  //-run  the query against the mysql query function 
		  $result=mysqli_query($db_conn,$sql); 
		  $count=mysqli_num_rows($result);
		  if ($count>0){
			  ?>
          <table width="100%">
          <thead>
              <th>Order Number</th>
              <th>السعر</th>
              <th>Status</th>
              <th>الحالة</th>
          </thead>
          <tbody>
        <?php
		  //-create  while loop and loop through result set 
		  while($row=mysqli_fetch_array($result)){ 
				  $id = $row['id'];
				  $order  = $row['order_num']; 
				  $price = $row['price']; 
				  $status_en = $row['status_en'];
				  $status_ar = $row['status_ar'];
				  //-display the result of the array 
				  	echo" <tr>";
					if ($name == $order)
						echo "<td><strong>$order</strong></td>";
					else echo "<td>$order</td>";
					if ($name == $price)
						echo "<td><strong>$price</strong></td>";
					else echo "<td>$price</td>";
					if ($name == $status_en)
						echo "<td><strong>$status_en</strong></td>";
					else echo "<td>$status_en</td>";
					if ($name == $status_ar)
						echo "<td><strong>$status_ar</strong></td>";
					else echo "<td>$status_ar</td>";
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
