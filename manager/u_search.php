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
			   $sql="SELECT  * FROM users WHERE f_name LIKE '%" . $name .  "%' OR l_name LIKE '%" . $name ."%' OR mail LIKE '%" . $name ."%' OR area LIKE '%" . $name ."%' OR street LIKE '%" . $name ."%' OR building LIKE '%" . $name ."%' OR status_en LIKE '%" . $name ."%' OR status_ar LIKE '%" . $name ."%'";  
		  //-run  the query against the mysql query function 
		  $result=mysqli_query($db_conn,$sql); 
		  $count=mysqli_num_rows($result);
		  if ($count>0){
			  ?>
          <table width="100%">
          <thead>
          <th>Name - الاسم</th>
          <th>E-mail - البريد الاليكتروني</th>
          <th>Address - العنوان</th>
          <th>Status - الحالة</th>
          </thead>
          <tbody>
        <?php
		  //-create  while loop and loop through result set 
		  while($row=mysqli_fetch_array($result)){ 
				  $first  = $row['f_name']; 
				  $last = $row['l_name'];
				  $mail = $row['mail'];
				  $area = $row['area'];
				  $street = $row['street'];
				  $build = $row['building']; 
				  $status_en = $row['status_en'];
				  $status_ar = $row['status_ar'];
				  //-display the result of the array 
				  	echo" <tr>";
					if ($name == $first || $name == $last)
						echo "<td><strong>$first $last</strong></td>";
					else echo "<td>$first $last</td>";
					if ($name == $mail)
						echo "<td><strong>$mail</strong></td>";
					else echo "<td>$mail</td>";
					if ($name == $area || $name == $street || $name == $build)
						echo "<td><strong>$area - $street - $build</strong></td>";
					else echo "<td>$area - $street - $build</td>";
					if ($name == $status_en || $name == $status_ar)
						echo "<td><strong>$status_en - $status_ar</strong></td>";
					else echo "<td>$status_en - $status_ar</td>";
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
