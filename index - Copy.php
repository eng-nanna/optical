<?php
session_start();
include ("includes/config.php");
include ("includes/login.php");
include_once("facebook_login/config.php");
include_once("facebook_login/includes/functions.php");
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ezzat Ibrahim</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css"/>
  <link rel="stylesheet" href="css/app.min.css">
</head>
<body>

  <div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
     <?php include("includes/mob_nav.html"); ?>

      <div class="off-canvas-content" data-off-canvas-content>
        <!--
        ************************
          Laptop Header
        ************************
        -->
        <header class="large-screen-header show-for-large">
          <div class="row">

            <?php include("includes/nav.html"); ?>

            <div class="large-5 column large-wings">
              <div class="head-topside rightContent">
              <?php
			  if (isset($_SESSION['user'])){
						$query="SELECT * FROM users where mail='$_SESSION[user]'";
					    $result= mysqli_query($db_conn, $query) or die("Invalid query");
					    $row = mysqli_fetch_array($result);
						?>
						 <span id="hi-user">
                  <span id="hi-user"><a href="#" data-toggle="user-dashboard-panel"><i class="fa fa-user"></i> Hi, <strong><?php echo $row['f_name'];?></strong></a></span>
                  <div class="dropdown-pane bottom" data-options="closeOnClick: true;" id="user-dashboard-panel" data-dropdown>
                <ul class="menu vertical">
                  <li><a href="dashboard.php"><i class="fa fa-gears"></i> My account</a></li>
                  <li><a href="signout.php"><i class="fa fa-sign-out"></i> Log Out</a></li>
                </ul>
              </div>
                </span> 
                <?php
				}else{
			  ?>

                
                <span id="login-user">
                  <a href="#" title="login" data-toggle="login-dropdown"><i class="fa fa-sign-in"></i> Login</a>
                  <div class="dropdown-pane bottom" id="login-dropdown" data-options="closeOnClick: true;" data-dropdown data-auto-focus="true">

                    <div class="facebook-login">
                    <?php
					if(!$fbuser){
	$fbuser = null;
	$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
?>
                      <a href="<?php echo $loginUrl; ?>" class="button expanded"> <i class="fa fa-facebook"></i> Facebook Login</a>
                    </div>
                    <?php
					}else{
	$user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
	$user = new Users();
	$user_data = $user->checkUser('facebook',$user_profile['id'],$user_profile['first_name'],$user_profile['last_name'],$user_profile['email'],$user_profile['gender'],$user_profile['locale'],$user_profile['picture']['data']['url']);
	if(!empty($user_data)){
		$_SESSION['user'] = $user_profile['email'];
		header("Location: dashboard.php"); // Redirecting To SignUp Page
	}else{
		echo '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
}
?>

                    <span class="or"><strong>OR</strong></span>

                    <form name="login-form" action="<?php $_SERVER['PHP_SELF']?>" method="post" data-abide novalidate>
                      <div class="row">
                        <div class="small-12 columns">
                          <label for="login-username">
                            Email
                          </label>
                          <input id="login-username" type="email" name="mail" required pattern="email">
                          <span class="form-error">
                            Type Your Email
                          </span>
                        </div>

                        <div class="small-12 columns">
                          <label for="login-password">Password</label>
                          <input id="login-password" type="password" name="pass" required pattern="password">
                          <span class="form-error">
                            Type Your Password
                          </span>
                        </div>

                        <div class="small-6 column"><input type="submit" name="login" value="Login" class="button expanded"></div>
                        <div class="small-6 column"><input type="submit" name="signup" value="Register" class="button expanded secondary"></div>

                      </div>
                    </form>
                  </div>
                </span>
                <?php } ?>

                <span class="langSelect">
                  <i class="fa fa-globe"></i>
                  <select name="" id="">
                    <option value="english">English</option>
                    <!--<option value="arabic">عربي</option>-->
                  </select>
                </span>
              </div><!-- head-topside -->

              <div class="head-nav">
                <nav class="large-nav">
                  <ul class="menu">
                    <li>
                      <a href="#" class="cart-link" data-toggle="cart-content">
                      <?php
					if (isset($_SESSION['user'])){
						$query="SELECT * FROM users WHERE mail = '$_SESSION[user]'";
						$result= mysqli_query($db_conn, $query) or die("Invalid query");
						$row = mysqli_fetch_array($result);
						$queries="SELECT * FROM cart WHERE user_id = '$row[id]'";
						$res= mysqli_query($db_conn, $queries) or die("Invalid query");
						$count=mysqli_num_rows($res);
						?>
                        <i class="fa fa-shopping-bag largeHeadCart">
                          <span><?php echo $count; ?></span></i></a>
                          <div id="cart-content" class="dropdown-pane" data-options="closeOnClick: true;" data-dropdown data-hover="false">
                          <?php
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
						  ?>
                        <div class="cart-item">
                          <div class="c-img">
                            <img src="img/glasses/<?php echo $rowing1['img']; ?>" style="width:60px; height:60px" alt="cart item">
                          </div><!-- img -->
                          <div>
                            <h4><?php echo $item['name_en']; ?></h4>
                            <div class="price"><?php echo $total_price." EGP"; ?></div>
                            <a class="link-delete" href="#" data-delete-id="<?php echo $temp['id']; ?>">
                              <i class="fa fa-trash"></i>
                            </a>
                          </div>
                        </div><!-- cart-item -->
                        <?php } ?>
                       
                        <a href="checkout.php" class="button expanded">Checkout</a>
                      </div><!-- cart-content -->
                        <?php
		  }else{
						?>
                        <i class="fa fa-shopping-bag largeHeadCart">
                        </i></a>

                        <?php } ?>
                      
                    </li>
                    <li>
                      <a href="#" title="about"><i class="fa fa-info"></i> About</a>
                    </li>
                    <!--<li class="largeHeadForm">
                      <form action="index_submit" method="post" accept-charset="utf-8">
                        <i class="fa fa-search"></i>
                        <input type="search" placeholder="Search">
                      </form>
                    </li>-->
                   <script>
				  (function() {
					var cx = '016387424309634048089:8_jc_rv0yvm';
					var gcse = document.createElement('script');
					gcse.type = 'text/javascript';
					gcse.async = true;
					gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(gcse, s);
				  })();
				</script>
                <gcse:search></gcse:search>
                  </ul>
                </nav>
              </div><!-- left-head-nav -->
            </div><!-- large-wings -->

          </div>
          <!-- row -->
        </header>
        <!-- large-screen-header -->

        <!--
        ************************
             Mobile Header
        ************************
        -->

        <header class="mobile-header hide-for-large">
          <div class="menu-tregger">
            <a data-toggle="offCanvasleft"><i class="fa fa-navicon"></i><span>Menu</span></a>
          </div>
          <!-- m-tregger -->

          <div class="m-logo">
            <a href="#">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 198 133" xml:space="preserve">
                <style type="text/css">
                  .st0{opacity:0.75;}
                  .st1{fill:#D20101;}
                  .st2{fill:#FFFFFF;}
                  .st3{fill:none;stroke:#FFFFFF;stroke-miterlimit:10;}
                </style>
                <path id="logo-shadow" class="st0" d="M198 131.1c0 0-21.3-5.3-94.5-5.3S0 131.1 0 131.1v-5.3h198V131.1z"/>
                <rect id="logo-rect" class="st1" width="198" height="126.5"/>
                <path id="logo-glass" class="st2" d="M58.9 74.8C43.3 74.5 34 65.2 29.4 50.7c-0.9-3-1.1-6.1-2-9.1 -0.8-2.7-2.8-5-3.6-7.6 -2.1-7.1 6-9.1 11.6-11.1 14.1-5.3 29.5-7.9 43.7-1.5 7.2 3.2 12.4 3.6 20.2 3.6 8.2-0.1 12.6-1.2 19.9-4.3 14.6-6.1 30-2.2 44.2 2.9 5 1.8 11.6 3.7 9.9 10.1 -0.7 2.7-2.9 4.9-3.7 7.8 -1.1 4.3-1.5 8.4-3.2 12.7 -5.6 14.2-15.6 21.6-31 20.5 -15.6-1.1-25.8-12.4-29.5-26.9 -1.5-5.9 0.9-14.5-6.7-15.3 -8.6-0.9-6.4 8-7.9 14C87.1 63.5 76.6 73.1 58.9 74.8 53.3 74.7 60.1 74.7 58.9 74.8zM58.6 21c-11.7-0.3-25.1 3.1-26.1 16.8 -1.1 15.4 6.8 30.6 22.7 33.4 15.6 2.8 28.2-10.2 31.9-24.4C92.2 27.3 75.6 20.1 58.6 21 51.3 20.8 63.5 20.7 58.6 21zM139.7 21c-13-0.2-31 2.3-30.7 18.6 0.3 13.6 10.6 29.8 24.8 31.8 15.5 2.2 27-8.7 29.9-23C167.3 31.1 157.8 19.9 139.7 21 131.5 20.8 143.5 20.7 139.7 21z"/>
                <path id="logo-text" class="st2" d="M26.6 90.9h7.7v0.7h-6.9v5.9h5.8v0.7h-5.8v6.3h6.9v0.7h-7.7V90.9zM37.7 90.9h8.4v1.5L38.4 104v0.5h7.7v0.7h-8.4v-1.5l7.7-11.6v-0.5h-7.7V90.9zM49.5 90.9h8.4v1.5L50.2 104v0.5h7.7v0.7h-8.4v-1.5l7.7-11.6v-0.5h-7.7V90.9zM65.2 90.9H67l4.1 14.2h-0.7l-1.3-4.4H63l-1.3 4.4H61L65.2 90.9zM63.2 100.1h5.7l-2.5-8.5h-0.8L63.2 100.1zM72.6 90.9h9.2v0.7h-4.2v13.5h-0.7V91.6h-4.3V90.9zM85.3 91.2h2.3v13.9h-2.3V91.2zM97.6 91.2c2.8 0 4.2 1 4.2 3.6 0 1.7-0.5 2.5-1.6 3.1 1.2 0.5 2 1.3 2 3.2 0 2.8-1.7 3.9-4.4 3.9h-5.4V91.2H97.6zM94.6 93.2v4h3c1.4 0 2-0.7 2-2 0-1.3-0.7-1.9-2.1-1.9H94.6zM94.6 99.1v4.1h3.1c1.4 0 2.2-0.4 2.2-2.1 0-1.6-1.2-2-2.3-2H94.6zM108.6 100.2v5h-2.3V91.2h5.3c3.1 0 4.7 1.3 4.7 4.4 0 2-0.8 3.3-2.3 4l2.3 5.5h-2.5l-2-5H108.6zM111.7 93.2h-3v5.1h3.1c1.7 0 2.4-1.1 2.4-2.6C114.1 94.1 113.3 93.2 111.7 93.2zM122.7 91.2h4.5l3.4 13.9h-2.3l-0.8-3h-5.3l-0.8 3h-2.3L122.7 91.2zM122.7 100.2h4.4l-1.7-7h-1L122.7 100.2zM142.5 99.1h-6v6h-2.3V91.2h2.3v5.9h6v-5.9h2.3v13.9h-2.3V99.1zM149.5 91.2h2.3v13.9h-2.3V91.2zM156.6 91.2h3.9l3.1 10.9 3.1-10.9h3.9v13.9h-2.3V93.7h-0.3l-3.3 10.8h-2.4l-3.3-10.8h-0.3v11.4h-2.3V91.2z"/>
                <line id="logo-line" class="st3" x1="25" y1="83.5" x2="171" y2="83.5"/>
              </svg>
            </a>
          </div>
          <!-- m-logo -->

          <div class="m-miniMenu">
            <a href="#" class="cart-link">
              <i class="fa fa-shopping-bag">
                <span>8</span>
              </i>
            </a>

            <a id="mainSearch" data-open="searchFormReveal"><i class="fa fa-search"></i></a>
            <a data-open="offCanvasRight"><i class="fa fa-sign-in"></i></a>
          </div>
          <!-- m-miniMenu -->
        </header>
        <!-- mobile-header -->

        <!--
        ************************
              Main Slider
        ************************
        -->

        <section class="main-slider-container">

          <div class="main-slider">
            <?php
		  $query="SELECT * FROM slider";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
            <div>
              <a><img data-interchange="[img/slider/<?php echo $row['mob_pic'];?>, small], [img/slider/<?php echo $row['pic'];?>, medium]"></a>
            </div>
             <?php
                }
         ?>
          </div>
          <!-- main-slider -->
        </section>
        <!-- main-slider-container -->

        <!--
        ************************
          Best-Selling-Slider
        ************************
        -->
        <section class="best-selling show-for-medium">
          <div class="row">
            <div class="medium-2 column">
              <div class="bs-title">
                <span>Best Selling</span>
                <span>Brands</span>
              </div><!-- bs-title -->
            </div>
            <div class="medium-10 column">
              <div class="brands-logos">
                <?php
				$sql1="SELECT order_details.glass_id
    ,SUM('order_details.quantity')
	,brand.pic
	,brand.brand_en
FROM order_details
INNER JOIN glasses
    on order_details.glass_id = glasses.id
INNER JOIN brand
    on brand.brand_en = glasses.brand_en
	group by brand.brand_en order by COUNT('brand.brand_en') DESC LIMIT 5;";
		  $result= mysqli_query($db_conn, $sql1) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
		  ?>
                <div><a href="brand.php?brand=<?php echo $row['brand_en']; ?>"><img src="img/brands/<?php echo $row['pic']; ?>" width="138" height="80" alt=""></a></div>
                 <?php
                }
         ?>
              </div>
            </div><!-- brands-slider -->
          </div>
        </section><!-- best-selling -->


        <!--
        ************************
              Home Items
        ************************
        -->

        <section class="home-items">

          <div class="row">
            <div class="small-12 column">
              <h1 class="main-title">
                <span><i class="fa fa-star"></i> Last Added</span>
              </h1>
            </div>
          </div>

          <div class="row">

            <div class="small-12 column show-for-small-only">
              <nav>
                <form name="brandSelect" action="brands.php" method="get" accept-charset="utf-8">
                  <select name="brands">
                  <option selected disabled>Brands</option>
                   <?php
					  $query="SELECT * FROM brand";
					  $result= mysqli_query($db_conn, $query) or die("Invalid query");
					  while($row = mysqli_fetch_array($result)){
					  ?>
                    <option><?php echo $row['brand_en']; ?></option>
                    <?php }?>
                  </select>
                </form>
              </nav>
            </div><!-- show-for-small-only -->

            <div class="medium-2 column homeBrandList show-for-medium">
              <nav>
                <ul class="menu vertical">
                  <li><h4>Brands</h4></li>
                  <?php
					  $query="SELECT * FROM brand";
					  $result= mysqli_query($db_conn, $query) or die("Invalid query");
					  while($row = mysqli_fetch_array($result)){
					  ?>
                  <li><a href="brand.php?brand=<?php echo $row['brand_en']; ?>" title="<?php echo $row['brand_en']; ?>"><?php echo $row['brand_en']; ?></a></li>
                   <?php }?>
                </ul>
              </nav>
            </div><!-- left -->

            <div class="small-12 medium-10 column">
              <div class="row">
              <?php
					  $query="SELECT * FROM glasses Where quantity <> 0 ORDER BY id DESC LIMIT 3";
					  $result= mysqli_query($db_conn, $query) or die("Invalid query");
					  while($row = mysqli_fetch_array($result)){
						  $glass_id = $row['id'];
						  $glass_name = $row['name_en'];
						  $sql="SELECT * FROM images where glass_id = $glass_id LIMIT 1";
						  $res= mysqli_query($db_conn, $sql) or die("Invalid query");
						  $rowing = mysqli_fetch_array($res);
					  ?>
                <div class="small-6 medium-4 large-4 columns">
                  <div class="item-glasses">
                    <figure>
                      <a href="preview.php?id=<?php echo $glass_id; ?>"><img style="width:275px; height:175px" src="img/glasses/<?php echo $rowing['img']; ?>"  alt="sunglasses"></a>
                    </figure>

                    <div class="badgeswrapper">
                    <?php
					  $q="SELECT * FROM sale WHERE glass_name='$glass_name' AND status_en = 'On Sale'";
					  $res= mysqli_query($db_conn, $q) or die("Invalid query");
					  $count=mysqli_num_rows($res);
					  if ($count==1){
					  $sale_row = mysqli_fetch_array($res);
					  ?>
                      <div class="badges">
                        <i class="fa fa-certificate"></i><?php echo "sale " .$sale_row['discount']."%"; ?>
                      </div>
                      <?php } ?>
                    </div><!-- badgeswrapper -->

                    <h3><a href="preview.php?id=<?php echo $glass_id; ?>"><?php echo $row['name_en']; ?> - <?php echo $row['color_en']; ?></a></h3>
                    <div class="stars-rate">
                    <?php
					  $rate="SELECT AVG(rate) AS average FROM rate WHERE glass_id = '$glass_id' ";
					  $rate_result= mysqli_query($db_conn, $rate) or die("Invalid query");
					  $rate_row = mysqli_fetch_array($rate_result);
					  if ($rate_row['average'] != 0){
					  for($i=1;$i<=$rate_row['average'];$i++){
			  ?>
                      <i class="fa fa-star"></i>
                      <?php }
					  $real_part = floor($rate_row['average']);
					  $fraction = $rate_row['average'] - $real_part;
					  if ($fraction >= 0.5){
					  ?>
                      <i class="fa fa-star-half"></i>
                      <?php } ?>
                      <small><?php echo number_format($rate_row['average'], 1, '.', ''); ?>/5</small>
                      <?php } ?>
                    </div><!-- stars-rate -->
                    <div class="price">
                    <?php
					  $q="SELECT * FROM sale WHERE glass_name='$glass_name' AND status_en = 'On Sale'";
					  $res= mysqli_query($db_conn, $q) or die("Invalid query");
					  $count=mysqli_num_rows($res);
					  if ($count==1){
					  $sale_row = mysqli_fetch_array($res);
					  
					  $old = $row['price'];
					  $discount = $sale_row['discount'];
					  $percentage = $old * $discount/100;
					  $new = $old - $percentage;
					?>
                      <span class="now"><?php echo $new; ?> <small>EGP</small></span>
                      <span class="was"><?php echo $row['price']; ?> <small>EGP</small></span>
                      <?php
					  }else{
						  ?>
                          <span class="now"><?php echo $row['price']; ?> <small>EGP</small></span>
                          <?php } ?>
                    </div>
                    <div class="buttons hide-for-small-only">
                      <a href="preview.php?id=<?php echo $glass_id; ?>" class="button">Details</a>
                      <a href="preview.php?id=<?php echo $glass_id; ?>" class="button"><i class="fa fa-cart-plus"></i> Add To Cart</a>
                    </div><!-- buttons -->
                  </div><!-- item-glasses -->
                </div><!-- item-glasses-item -->
                <?php } ?>

              </div><!-- row -->
            </div><!-- right -->

          </div><!-- row -->
        </section>
        <!-- home-items -->

        <!--
        ************************
          Best-Selling-section
        ************************
        -->

        <section class="bestSelling">
          <div class="row">
            <div class="small-12 column">
              <h1 class="main-title">
                <span><i class="fa fa-heart"></i> Most Selling</span>
              </h1>
            </div>
          </div> <!-- row -->
          <div class="row">
           <?php
		  $query="SELECT glass_id,COUNT('glass_id') FROM order_details
				GROUP BY glass_id ORDER BY COUNT('glass_id') DESC
				LIMIT 3";
		  $result= mysqli_query($db_conn, $query) or die("Invalid query");
		  while($row = mysqli_fetch_array($result)){
			  $query1="SELECT * FROM glasses WHERE id= $row[glass_id] AND quantity <> 0";
		  	  $result1= mysqli_query($db_conn, $query1) or die("Invalid query1");
			  $row1 = mysqli_fetch_array($result1);
			  if($row1['quantity'] <> 0){
			  $sql="SELECT * FROM images where glass_id = $row1[id] LIMIT 1";
			  $res= mysqli_query($db_conn, $sql) or die("Invalid query");
			  $rowing = mysqli_fetch_array($res);
		  ?>
                <div class="small-6 medium-4 large-4 columns">
                  <div class="item-glasses">
                    <figure>
                      <a href="preview.php?id=<?php echo $row['glass_id']; ?>"><img style="width:275px; height:175px" src="img/glasses/<?php echo $rowing['img']; ?>" alt="sunglasses"></a>
                    </figure>

                    <div class="badgeswrapper">
                       <?php
					  $q="SELECT * FROM sale WHERE glass_name='$row1[name_en]' AND status_en = 'On Sale'";
					  $res= mysqli_query($db_conn, $q) or die("Invalid query");
					  $count=mysqli_num_rows($res);
					  if ($count==1){
					  $sale_row = mysqli_fetch_array($res);
					  ?>
                      <div class="badges">
                        <i class="fa fa-certificate"></i><?php echo "sale " .$sale_row['discount']."%"; ?>
                      </div>
                      <?php } ?>
                    </div><!-- badgeswrapper -->

                    <h3><a href="preview.php?id=<?php echo $row['glass_id']; ?>"><?php echo $row1['name_en']; ?> - <?php echo $row1['color_en']; ?></a></h3>
                    <div class="stars-rate">
                       <?php
					  $rate="SELECT AVG(rate) AS average FROM rate WHERE glass_id = '$row[glass_id]' ";
					  $rate_result= mysqli_query($db_conn, $rate) or die("Invalid query");
					  $rate_row = mysqli_fetch_array($rate_result);
					  if ($rate_row['average'] != 0){
					  for($i=1;$i<=$rate_row['average'];$i++){
			  ?>
                      <i class="fa fa-star"></i>
                      <?php }
					  $real_part = floor($rate_row['average']);
					  $fraction = $rate_row['average'] - $real_part;
					  if ($fraction >= 0.5){
					  ?>
                      <i class="fa fa-star-half"></i>
                      <?php } ?>
                      <small><?php echo number_format($rate_row['average'], 1, '.', ''); ?>/5</small>
                      <?php } ?>
                    </div><!-- stars-rate -->
                    <div class="price">
                       <?php
					  $q="SELECT * FROM sale WHERE glass_name='$row1[name_en]' AND status_en = 'On Sale'";
					  $res= mysqli_query($db_conn, $q) or die("Invalid query");
					  $count=mysqli_num_rows($res);
					  if ($count==1){
					  $sale_row = mysqli_fetch_array($res);
					  
					  $old = $row1['price'];
					  $discount = $sale_row['discount'];
					  $percentage = $old * $discount/100;
					  $new = $old - $percentage;
					?>
                      <span class="now"><?php echo $new; ?> <small>EGP</small></span>
                      <span class="was"><?php echo $row1['price']; ?> <small>EGP</small></span>
                      <?php
					  }else{
						  ?>
                          <span class="now"><?php echo $row1['price']; ?> <small>EGP</small></span>
                          <?php } ?>
                    </div>
                    <div class="buttons hide-for-small-only">
                      <a href="preview.php?id=<?php echo $row['glass_id']; ?>" class="button">Details</a>
                      <a href="preview.php?id=<?php echo $row['glass_id']; ?>" class="button"><i class="fa fa-cart-plus"></i> Add To Cart</a>
                    </div><!-- buttons -->
                  </div><!-- item-glasses -->
                </div><!-- item-glasses-item -->
                <?php } } ?>
          </div><!-- row -->
        </section><!-- bestSelling -->

        <!--
        ************************
              Main Footer
        ************************
        -->

        <footer class="main-footer">

          <div class="sunglassSvgCont">

            <svg id="sunglass-line" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
              viewBox="0 0 1300 61.2" style="enable-background:new 0 0 1300 61.2;" xml:space="preserve">

              <style type="text/css">
                .sunGlasses-line{fill:none;stroke:#000;stroke-width:4;stroke-miterlimit:10;}
              </style>

              <path id="XMLID_27_" class="sunGlasses-line" d="M0,12.9h552.9c4.6,0,8-1.9,8-1.9s13.8-2.4,21.2-5.2c7.5-2.8,17.5-4.4,29.8-2.7s20.1,2.8,24,8.3
              s2.5,13.9,2.5,13.9s-0.8,21.9-16,29.7c0,0-6.6,4.6-19.2,4.3c-12.6-0.3-24.3-4.5-28.3-16.9s-4.2-20.9-3-26.4S580.1-0.6,609.3,3
              s29.4,6.5,41.1,6.5c11.8,0,11.9-2.8,41.1-6.5s36.3,7.2,37.5,12.8s1,14-3,26.4s-15.7,16.6-28.3,16.9c-12.6,0.3-19.2-4.3-19.2-4.3
              c-15.3-7.9-16-29.8-16-29.8s-1.3-8.5,2.5-13.9s11.7-6.7,24-8.4c12.3-1.7,22.3-0.4,29.8,2.4C726.3,8,740,11,740,11s3,1.9,8,1.9h552"/>

            </svg>
          </div><!-- sunglassSvgCont -->

          <div class="row">

            <div class="medium-7 show-for-medium column">
              <div class="row">
                <div class="medium-6 column">
                  <nav class="footer-links">
                    <h4>About Us</h4>
                    <ul class="menu vertical">
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                    </ul>
                  </nav>
                </div>
                <div class="medium-6 column">
                  <nav class="footer-links">
                    <h4>Extras</h4>
                    <ul class="menu vertical">
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                      <li><a href="#" title=""><i class="fa fa-angle-right"></i> Careers</a></li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div><!-- col -->

            <div class="small-12 medium-5 column">

              <div class="newsletters">
                <h4>Don't Miss Out</h4>

                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua.
                </p>

                <form class="newsletters" action="" method="post" data-abide>
                  <div class="input-group">
                    <input required pattern="email" placeholder="Your Email" class="input-group-field" type="email">
                    <div class="input-group-button">
                      <input type="submit" class="button" value="Sign Up">
                    </div>
                  </div><!-- input-group -->
                </form>

              </div><!-- newsletters -->

            </div> <!-- col -->
          </div><!-- row -->

      </footer>
      <!-- main-footer -->

      <div class="copyright">
          <i class="fa fa-copyrigh"></i>
          <strong>EZZAT IBRAHIM<strong> All Rights Reserved
      </div>


    </div>
    <!-- canvas-content -->
  </div>
  <!-- wrapper-inner -->
</div>
<!-- off-canvas-wrapper -->

<!-- search-reveal -->
<!--
  ************************
      Search Reveal
  ************************
-->
<div class="reveal" id="searchFormReveal" data-close-on-click="true" data-reveal data-animation-in="scale-in-up" data-animation-out="scale-out-down">
  <h4>Looking For Something ?</h4>
  <form action="index_submit" method="get" accept-charset="utf-8">
    <input type="text" placeholder="Search">
    <input type="submit" class="button expanded" value="Search" />
  </form>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<script src="js/vendor.min.js"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>
<script src="js/app.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#cart').click(function(){
            $.ajax( {
                type: "POST",
                url: 'out_response.php',
                data: $('#cart-form').serialize(),
            } );
        });
    });
</script>

<script>
$(".link-delete").click(function(){
 var deleteid = $(this).data("delete-id");
 //big snip
 $.ajax({
    url : "del_temp.php?id="+deleteid,
    //big snip
  });
});
</script>
</body>
</html>
