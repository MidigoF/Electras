<?php
 include("includes/header.php");
?>
		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li><a href="index.php">Home</a></li>
						<li><a href="laptops.php">Laptops</a></li>
						<li><a href="smartphones.php">Smartphones</a></li>
						<li><a href="cameras.php">Cameras</a></li>
						<li class="active"><a href="accessories.php">Accessories</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Accessories</h3>
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active">Accessories</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class="col-md-3">
            <?php
              $product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE category='accessory' ORDER BY id ASC");
              if (!empty($product_array)) {
                foreach($product_array as $key=>$value){
            ?>
            <!-- product -->
            <div class="product">
              	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                <div class="product-img">
                  <img src="<?php echo $product_array[$key]["image"]; ?>" alt="">
                  <div class="product-label">

                  </div>
                </div>
                <div class="product-body">
                  <p class="product-category"><?php echo $product_array[$key]["category"]; ?></p>
                  <h3 class="product-name"><a href="product.php?code="+<?php echo $product_array[$key]["code"]; ?> ><?php echo $product_array[$key]["name"]; ?></a></h3>
                  <h4 class="product-price"><?php echo "KSH".$product_array[$key]["price"]; ?></h4>
                  <div class="product-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
                  <div class="product-btns">
                    <input type="text" class="add-to-wishlist" name="quantity" value="1" size="2" /><span class="tooltip">quantity</span></button>
                  </div>
                </div>
                <div class="add-to-cart">
                  <button type="submit" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                </div>
              </form>
            </div>
            <!-- /product -->
            <?php
                }
              }
              ?>
					</div>

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

	<?php
    include("includes/footer.php");
   ?>
