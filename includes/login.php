<?php
if (isset($_POST['login'])){
					$username = $_POST['mail'];
					$password = md5($_POST['pass']);
					////////////////////////////////////////////////////////////
					$result=mysqli_query($db_conn,"SELECT * FROM users WHERE mail='$username' and password='$password'");
					$count=mysqli_num_rows($result);
					if ($count==1){
						// Initializing Session
						$_SESSION['user'] = $username;
						$query="SELECT * FROM users where mail='$username'";
					    $result= mysqli_query($db_conn, $query) or die("Invalid query");
					    $row = mysqli_fetch_array($result);
					}
					else echo "invalid username or password";
				}

if (isset($_POST['signup'])){
				$username = $_POST['mail'];
				header("Location: signup.php?user=$username"); // Redirecting To SignUp Page

}
?>