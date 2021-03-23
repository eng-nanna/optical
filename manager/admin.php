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
      <span>Admins</span>
      <a data-open="addAdmin" class="button">add admin</a>
    </h1>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>Name</th>
          <th class="text-center">Edit</th>
          <th class="text-center">Delete</th>
        </thead>
        <tbody>
        <?php
		  $query="SELECT * FROM admins";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
          <tr>
            <td><?php echo $row['admin'];?></td>
            <td class="text-center editRow"><a href="update_admin.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i></a></td>
            <td class="text-center removeRow"><a href="delete_admin.php?id=<?php echo $row['id'];?>"><i class="fa fa-remove"></i></a></td>
          </tr>
          <?php
                }
         ?>
        </tbody>
      </table>
    </div>

    <div class="reveal" id="addAdmin" data-reveal>
      <h3 class="">
        <span>Add Admin</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for="addName">Username:</label>
        <input type="text" id="addName" name="addName" placeholder="Admin Name">
        <label for="password">Password:</label>
        <input type="password" id="password" name="addPass" placeholder="Admin Password">
        <input class="button expanded" type="submit" name="submit" value="Add Admin">
      </form>
      <button class="close-button" data-close aria-label="Close reveal" type="button" name="submit">
        <span aria-hidden="true">&times;</span>
      </button>
    </div><!-- reveal -->
    
     <?php
	 if (isset($_POST['submit'])){
	   $u_name = $_POST['addName'];
	   $pass = md5($_POST['addPass']);
	   $query = mysqli_query($db_conn,"INSERT INTO admins (admin,password) 
			  VALUES ('$u_name','$pass')");
	   if ($query) echo "New admin has been added.";
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
