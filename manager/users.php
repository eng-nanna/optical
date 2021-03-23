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
      <span>clients - العملاء</span>
    </h1>

    <div class="padding-1em">
    <!-- search box -->
        <form  method="post" action="u_search.php"  id="searchform">
        <div class="input-group">
        <input class="input-group-field" type="text" name="name"> 
        <div class="input-group-button">
        <input type="submit" class="button" value="Search" name="submit">
        </div>
        </div>
        </form> <!-- search box -->
        
      <table width="100%">
        <thead>
          <th><a href="users.php?sort=name">Name - الاسم</a></th>
          <th><a href="users.php?sort=mail">E-mail - البريد الاليكتروني</a></th>
          <th><a href="users.php?sort=adrs">Address - العنوان</a></th>
          <th><a href="users.php?sort=status">Status - الحالة</a></th>
          <th class="text-center">Edit</th>
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
		  
		  $query="SELECT * FROM users";
		  if (isset($_GET["sort"])){
			if ($_GET['sort'] == 'name'){
				$query .= " ORDER BY f_name";
			}
			elseif ($_GET['sort'] == 'mail'){
				$query .= " ORDER BY mail";
			}
			elseif ($_GET['sort'] == 'adrs'){
				$query .= " ORDER BY area";
			}
			elseif($_GET['sort'] == 'status'){
				$query .= " ORDER BY status_ar";
			}
		  }
		  
		  $query .=" LIMIT $start_from, $num_rec_per_page";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
          <tr>
            <td><?php echo $row['f_name']." ".$row['l_name'];?></td>
            <td><?php echo $row['mail'];?></td>
            <td><?php echo $row['area']. " - " . $row['street']. " - " . $row['building'];?></td>
            <td><?php echo $row['status_en']. " - " . $row['status_ar'];?></td>
            <td class="text-center editRow"><a href="user_status.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
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
    $sql = "SELECT * FROM users"; 
    $rs_result = mysqli_query($db_conn, $sql); //run the query
    $total_records = mysqli_num_rows($rs_result);  //count number of records
    $total_pages = ceil($total_records / $num_rec_per_page); 
    
    echo "<li class='pagination-previous disabled'><a href='users.php?page=1'>".'First'."</a><span class='show-for-sr'>page</span></li> "; // Goto 1st page  
    
    for ($i=1; $i<=$total_pages; $i++) { 
                echo "<li><a href='users.php?page=".$i."'>".$i."</a></li> "; 
    }; 
    echo "<li class='pagination-next'><a href='users.php?page=$total_pages'>".'Last'."</a><span class='show-for-sr'>page</span></a></li> "; // Goto last page
    ?>
    </ul>


  </div> <!--moduleContainer -->
  <!-- ==== End Modules Contaner ==== -->


</div>

<?php
              include("includes/footer.html");
   ?>

<script src="js/vendor.min.js"></script>
<script src="js/app.js"></script>
<script>
$(document).foundation();
</script>
</body>
</html>
