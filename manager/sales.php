<?php
session_start();
include ("../includes/config.php");
if(!isset($_SESSION["login_user"]))
{
    header("Location: index.php");
}

$query="SELECT * FROM sale";
$result= mysqli_query($db_conn, $query) or die("Invalid query");
while($row = mysqli_fetch_array($result)){
	$id = $row['id'];
	$sale_start = $row['start'];
	$sale_end = $row['end'];
	$current_date = date("Y-m-d");
	if($current_date<date("$sale_start")){
		$status_en = "Has not started Yet";
		$status_ar = "لم يبدأ";
	}elseif($current_date>date("$sale_end")){
		$status_en = "Sale is Over";
		$status_ar = "التخفيض انتهى";
	}else{
		$status_en = "On Sale";
		$status_ar = "تخفيضات حالية";
	}
	$query = mysqli_query($db_conn,"Update sale SET status_en='$status_en' ,status_ar='$status_ar' where id='$id'");
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
      <span>Discounts</span>
      <a data-open="addAdmin" class="button">Add Discount</a>
    </h1>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>Glass - النظارة</th>
          <th>Discount -  الخصم</th>
          <th>Sale Start - تاريخ بدء الخصم</th>
          <th>Sale End - تاريخ انتهاء الخصم</th>
          <th>Status - الحالة </th>
          <th class="text-center">Edit</th>
        </thead>
        <tbody>
        <?php
		  $query="SELECT * FROM sale";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
			  if($row['status_en'] == "Has not started Yet"){
		  ?>
          <tr style="color:green">
          <?php
			  }elseif($row['status_en'] == "Sale is Over"){
		  ?>
          <tr style="color:red">
          <?php
			  }else{
		  ?>
          <tr>
          <?php } ?>
            <td><?php echo $row['glass_name'];?></td>
            <td><?php echo $row['discount']. " %";?></td>
            <td><?php echo $row['start'];?></td>
            <td><?php echo $row['end'];?></td>
            <td><?php echo $row['status_en'];?></td>
            <td class="text-center editRow"><a href="update_sale.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
          </tr>
          <?php
                }
         ?>
        </tbody>
      </table>
    </div>

    <div class="reveal" id="addAdmin" data-reveal>
      <h3 class="">
        <span>Add Sale</span>
      </h3>      
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Choose how to filter :<select id="filter" name="filter">
                <option >-Select Your Filteration-</option>
                <option value="C">Category</option>
                <option value="B">Brands</option>
            </select>
                <div id="div1">
                    <select onchange="fetch_select(this.value);">
                    <option>Show All</option>
                     <?php
						$sql="SELECT * FROM category";
						$result=mysqli_query($db_conn,$sql);
						while($rows=mysqli_fetch_array($result)){
						$cat_en =  $rows['name_en'];
						$cat_ar =  $rows['name_ar'];
						?>
					<option value="<?php echo $cat_en; ?>"><?php echo $cat_en ." - " . $cat_ar; ?></option>
					<?php
						}
						?>
                    </select>
                </div>
                
                <div id="div2">
                    <select onchange="fetch_select(this.value);">
                    <option>Show All</option>
                     <?php
						$sql="SELECT * FROM brand";
						$result=mysqli_query($db_conn,$sql);
						while($rows=mysqli_fetch_array($result)){
						$brand_en =  $rows['brand_en'];
						$brand_ar =  $rows['brand_ar'];
						?>
					<option value="<?php echo $brand_en; ?>"><?php echo $brand_en ." - " . $brand_ar; ?></option>
					<?php
						}
						?>
                    </select>
               </div>
        </form>
        <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for="discount">Glass - النظارة:</label>
        <div id="DisplayDiv">
        <select name="glasses">
                    <option>Show All</option>
                     <?php
						$sql="SELECT * FROM glasses";
						$result=mysqli_query($db_conn,$sql);
						while($rows=mysqli_fetch_array($result)){
						$glass_en =  $rows['name_en'];
						$glass_ar =  $rows['name_ar'];
						?>
					<option value="<?php echo $glass_en; ?>"><?php echo $glass_en ." - " . $glass_ar; ?></option>
					<?php
						}
						?>
                    </select></div>
                
        <label for="discount">Discount - نسبة الخصم:</label>
        <input type="text" id="discount" name="discount" placeholder="Discount Percentage">
        <label for="start">Sale Start - بدء التخفيض:</label>
        <input type="text" id="datepicker1" name="start" placeholder="Sale Start">
        <label for="end">Sale end - انتهاء التخفيض:</label>
        <input type="text" id="datepicker2" name="end" placeholder="Sale end">
        <input class="button expanded" type="submit" name="submit" value="Add Discount">
      </form>
      <button class="close-button" data-close aria-label="Close reveal" type="button" name="submit">
        <span aria-hidden="true">&times;</span>
      </button>
    </div><!-- reveal -->
    
     <?php
	 if (isset($_POST['submit'])){
	   $glass = $_POST['glasses'];
	   $discount = $_POST['discount'];
	   $start = $_POST['start'];
	   $end = $_POST['end'];
	   $current_date = date("Y-m-d");
	   if($current_date<date("$start")){
	   		$status_en = "Has not started Yet";
			$status_ar = "لم يبدأ";
	   }elseif($current_date>date("$end")){
			$status_en = "Sale is Over";
			$status_ar = "التخفيض انتهى";
	   }else{
			$status_en = "On Sale";
			$status_ar = "تخفيضات حالية";
	   }
	   $query = mysqli_query($db_conn,"INSERT INTO sale (glass_name,discount,start,end,status_en,status_ar) 
			  VALUES ('$glass','$discount','$start','$end','$status_en','$status_ar')");
	   if ($query) echo "New Discount has been added.";
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
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js"></script>
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>

<script src="https://code.jquery.com/jquery-1.7.2.js"></script>
	<script type="text/javascript">
    $(document).ready(function() {
    $('#div1').hide();
	$('#div2').hide(); 
    $('#filter').change(function(){
        if($('#filter').val() == 'C') {
            $('#div1').show();
			$('#div2').hide(); 
        } else if ($('#filter').val() == 'B') {
			$('#div2').show();
            $('#div1').hide(); 
        }
    });
});
	</script>
    
<script>
	function fetch_select(val)
{
   $.ajax({
     type: 'post',
     url: 'test2.php',
     data: {
       selected:val
     },
     success: function (response) {
       document.getElementById("DisplayDiv").innerHTML=response; 
     }
   });
}
	</script>    
</body>
</html>
