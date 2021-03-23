<?php
session_start();
include ("includes/config.php");

if (isset($_SESSION['user'])){
	$query="SELECT * FROM users where mail='$_SESSION[user]'";
	$result= mysqli_query($db_conn, $query) or die("Invalid query");
	$row = mysqli_fetch_array($result);
}

$quantity = $_POST['quantity'];
$id = $_POST['glass_id'];
if(!isset($_SESSION['user'])){
	$guest_id = session_id();
	$sql2 = mysqli_query($db_conn,"INSERT INTO cart (user_id,type,glass_id,quantity) 
						VALUES ('$guest_id','unregistered','$id','$quantity')");
}else{
	$user_id = $row['id'];
	$sql2 = mysqli_query($db_conn,"INSERT INTO cart (user_id,type,glass_id,quantity) 
						VALUES ('$user_id','registered','$id','$quantity')");
}
?>

<h3 class="text-center"><i class="fa fa-shopping-bag"></i> My Orders</h3>
  <div class="table-of-orders">
    <table class="stack hover">
      <thead>
        <tr>
          <th class="text-center" width="100">Photo</th>
          <th>Title</th>
          <th class="text-center" width="65">Quantaty</th>
          <th class="text-center" width="65">Price</th>
        </tr>
      </thead>
      <tbody>
      <?php
	    if(!isset($_SESSION['user'])){
			$queries="SELECT * FROM cart WHERE user_id = '$guest_id'";
		}else{
			  $queries="SELECT * FROM cart WHERE user_id = '$row[id]'";
		}
	  $res= mysqli_query($db_conn, $queries) or die("Invalid query");
	  $total = 0;
	   while($temp = mysqli_fetch_array($res)){
							  $id = $temp['id'];
							  $qur="SELECT * FROM glasses WHERE id = '$temp[glass_id]'";
							  $resulting= mysqli_query($db_conn, $qur) or die("Invalid query");
							  $item = mysqli_fetch_array($resulting);
							  $sql="SELECT * FROM images where glass_id = $item[id] LIMIT 1";
							  $res1= mysqli_query($db_conn, $sql) or die("Invalid query");
							  $rowing1 = mysqli_fetch_array($res1);
							  $q="SELECT * FROM sale WHERE glass_name='$item[name_en]' AND status_en = 'On Sale'";
							$ans1= mysqli_query($db_conn, $q) or die("Invalid query");
							$count=mysqli_num_rows($ans1);
							$price = $item['price'];
							if ($count==1){
								$sale_row = mysqli_fetch_array($ans1);
								$old = $item['price'];
								$discount = $sale_row['discount'];
								$percentage = $old * $discount/100;
								$price = $old - $percentage;
							}
							  $total_price = $temp['quantity'] * $price;
							  $total += $total_price;
	  ?>
        <tr>
          <td>
            <a href="#"><img src="img/glasses/<?php echo $rowing1['img']; ?>" style="width:100px; height:80px" alt="item image"></a>
          </td>
          <td><a href="#"><?php echo $item['name_en']; ?></a></td>
          <td class="text-center"><?php echo $temp['quantity']; ?></td>
          <td class="text-center"><?php echo $total_price; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="total-price text-center">
      <a class="button hollow large">
        <strong><i class="fa fa-shopping-bag"></i> Total Price : </strong>
        <span><?php echo $total; ?> EGP</span>
      </a>
      <br>
      <div class="warning label">Shipping : +25 EGP</div>
    </div>
    <div class="text-center checkOut-aria">
      <a href="#" data-close class="hollow button">Continue Shoping</a>
      <a href="checkout.php" class="alert button">Checkout</a>
    </div>
  </div>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button> 
