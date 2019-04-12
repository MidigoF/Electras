<?php
session_start();

$name =   $_SESSION['loggedInUser'];
$active_user = $_SESSION['active_user'];
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));

			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;
}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content="Electras - Electrical Gadgets Shop">
  	<meta name="keywords" content="Electras, Electrical Gadgets Shop, best electronic shop in kenya, affordable electricals, pocket friendly electronic shop in Kenya, cheap laptops in kenya, electrical shops in kenya, top 10 electronic shops in kenya, original electronics in kenya, original gadgets">

		<title>Electras</title>

 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

 		<!-- Font Awesome Icon -->
 		<link rel="stylesheet" href="css/font-awesome.min.css">

 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>

 		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
 		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
 		<!--[if lt IE 9]>
 		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
 		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 		<![endif]-->

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +254-790-000-000</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> contact@electras.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> Masinde Muliro</a></li>
					</ul>
					<ul class="header-links pull-right">
              <?php
                if(isset($_SESSION['loggedInUser'])){
              ?>
              <li class="btn-group">
                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-user-o"></i>Welcome <?php echo $name; ?> </a>
                <ul class="dropdown-menu dropdown">
	                 <li><a href="#">Profile</a></li>
	                  <li><a href="#">Orders</a></li>
	                  <li><a href="logout.php">Log out</a></li>
                </ul>
              </li>
              <?php
            }else{
              ?>
					    <li><a href="signup.php"><i class="fa fa-user-o"></i> signup/Register</a></li>
            <?php } ?>
          </ul>

				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<select class="input-select">
										<option value="0">All Categories</option>
										<option value="1">Laptops</option>
										<option value="2">Smartphones</option>
										<option value="3">Cameras</option>
										<option value="4">Accessories</option>
									</select>
									<input class="input" placeholder="Search here">
									<button class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">2</div>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">

										<div class="cart-dropdown">
											<?php
												if(isset($_SESSION["cart_item"])){
														$total_quantity = 0;
														$total_price = 0;
											?>
											<div class="cart-list">
											<?php
												foreach ($_SESSION["cart_item"] as $item){
										        $item_price = $item["quantity"]*$item["price"];
												?>
												<div class="product-widget">
													<div class="product-img">
														<img src="<?php echo $item["image"]; ?>" alt="">
													</div>
													<div class="product-body">
														<h3 class="product-name"><a href="#"><?php echo $item["name"]; ?></a></h3>
														<h4 class="product-price"><span class="qty"><?php echo $item["quantity"]; ?>x</span><?php echo "KSH ".$item["price"]; ?></h4>
													</div>
												 <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=remove&code=<?php echo $item["code"]; ?>" class="delete"><i class="fa fa-close"></i></a>
												</div>
												<?php
															$total_quantity += $item["quantity"];
															$total_price += ($item["price"]*$item["quantity"]);
													}
												?>

											</div>
											<div class="cart-summary">
												<small><?php echo $total_quantity; ?> Item(s) selected</small>
												<h5>SUBTOTAL: <?php echo "KSH ".number_format($total_price, 2); ?></h5>
											</div>
											<div class="cart-btns">
												<a href="#">View Cart</a>
												<a href="checkout.php">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
											</div>
												<?php
											}else{
												$total_quantity = 0;
												 ?>
												 <div class="product-body">Your Cart is Empty</div>
												 <?php
												 }
												 ?>
										</div>
										<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
											<i class="fa fa-shopping-cart"></i>
											<span>Your Cart</span>
											<div class="qty"><?php echo $total_quantity; ?></div>
										</a>
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->
