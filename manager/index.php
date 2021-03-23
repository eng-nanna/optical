<?php
session_start();
include ("../includes/config.php");
if (isset($_POST['submit'])){
	$username = $_POST['admin'];
	$password = md5($_POST['pass']);
	////////////////////////////////////////////////////////////
	$result=mysqli_query($db_conn,"SELECT * FROM admins WHERE admin='$username' and password='$password'");
	$count=mysqli_num_rows($result);
	if ($count==1){
		// Initializing Session
		$_SESSION['login_user'] = $username;
		header("Location: admin.php"); // Redirecting To Home Page
	}
	else echo "invalid username or password";
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

  <div class="row login-container">
    <div class="login-form">
      <div class="form-logo">
        <a href="#">
          <img src="../img/logo.png" alt="logo" width="230">
        </a>
      </div><!-- form-logo -->
      <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <label for=""> <i class="fa fa-user"></i> Username<input type="text" name="admin"></label>
        <label for=""><i class="fa fa-key"></i> Password<input type="password" name="pass"></label>
        <input type="submit" class="success button expanded" value="Login" name="submit">
      </form>
    </div>
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
