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
      <span>Orders</span>
    </h1>

    <div class="padding-1em">
    
    <!-- search box -->
        <form  method="post" action="search.php"  id="searchform">
        <div class="input-group">
        <input class="input-group-field" type="text" name="name"> 
        <div class="input-group-button">
        <input type="submit" class="button" value="Search" name="submit">
        </div>
        </div>
        </form> <!-- search box -->
 
      <table width="100%">
        <thead>
          <th><a href="orders.php?sort=num">Order Number</th>
          <th><a href="orders.php?sort=status">Status - الحالة</th>
          <th class="text-center">Edit</th>
        </thead>
        <tbody>
        <?php
		  $query="SELECT * FROM orders";
		  if (isset($_GET["sort"])){
			if ($_GET['sort'] == 'num'){
				$query .= " ORDER BY order_num";
			}
			elseif ($_GET['sort'] == 'status'){
				$query .= " ORDER BY status_ar";
			}
		  }
		  
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
          <tr>
            <td><a href="track.php?id=<?php echo $row['id'];?>"><?php echo "#".$row['order_num'];?></a></td>
            <td><?php echo $row['status_en'] ." - ". $row['status_ar'];?></td>
            <td class="text-center editRow"><a href="#" data-open="editForm" data-id="<?php echo $row['order_num'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
          </tr>
          <?php
                }
         ?>
        </tbody>
      </table>
    </div>
    
    <div class="reveal" id="editForm" data-reveal>
        <h3 class="">
          <span>Edit Form</span>
        </h3>
        <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
          <input type="hidden" id="id-value" name="order_num" value="">
          <label for="ststus">Status:</label>
         <select class="" id="status_en" name="status_en">
         <option disabled selected>Status</option>
         <option>being processed</option>
         <option>shipped</option>
         <option>out for delievery</option>
         <option>delievered</option>
		</select>
        
        <label for="ststus">الحالة:</label>
         <select class="" id="status_ar" name="status_ar">
         <option disabled selected>Status</option>
         <option>تحت الطلب</option>
         <option>تم الشحن</option>
         <option>مرحلة التوصيل</option>
         <option>تم التوصيل</option>
		</select>
          <input class="button expanded" type="submit" name="edit" value="UPDATE">
        </form>
        <button class="close-button" data-close aria-label="Close reveal" type="button">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- reveal -->
      
  </div> <!--moduleContainer -->
  <!-- ==== End Modules Contaner ==== -->

<?php
	 if (isset($_POST['edit'])){
	   $order_num = $_POST['order_num'];
	   $status_en = $_POST['status_en'];
	   $status_ar = $_POST['status_ar'];
	   $today = date("Y-m-d");
	   
	  $sql = mysqli_query($db_conn,"Update orders SET status_en='$status_en' ,status_ar='$status_ar' where order_num='$order_num'");
	  $sql2 = mysqli_query($db_conn,"Update order_details SET status_en='$status_en' ,status_ar='$status_ar' where order_num='$order_num'");
			  $sql11 = mysqli_query($db_conn,"INSERT INTO order_history (order_num,status_en,status_ar,date) 
			  				VALUES ('$order_num','$status_en','$status_ar','$today')");
			  
	   if ($query){
		   $message = "Order status has been updated. تم تعديل الحالة";
				echo "<script type='text/javascript'>alert('$message');</script>";
	   }
			else{
				$message = "Error: " . $query . "<br>" . mysqli_error($db_conn);
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
	 }
	 ?>  

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
