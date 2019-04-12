<?php
 include("includes/header.php");
 require("vendor/autoload.php");


 $user_details = $db_handle->runQuery("SELECT * FROM tbluser WHERE userid='$active_user'");
 if (!empty($user_details)) {
   foreach($user_details as $key=>$value){
     $userid = $user_details[$key]["userid"];
     $fname = $user_details[$key]["fname"];
     $lname = $user_details[$key]["lname"];
     $email = $user_details[$key]["email"];
     $address = $user_details[$key]["address"];
     $city = $user_details[$key]["city"];
     $county = $user_details[$key]["county"];
     $zip = $user_details[$key]["zipcode"];
     $phone ="254".$user_details[$key]["telephone"];
     $hashedPass = $user_details[$key]["password"];
   }
}
//Mpesa payment
$showModal = false;
if(isset($_POST['place_order'])){
  $showModal = true;

$businessShortCode="174379";
 $LipaNaMpesaPasskey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
 $TransactionType="CustomerPayBillOnline";
 $Amount=$total_price;
 $PartyA=$phone;
 $PartyB="174379";
 $PhoneNumber=$phone;
 $CallBackURL= 'https://sacco.namwal.co.ke/callbacks/registration_fee/callback_url.php';
 $AccountReference="ELECTRAS ORDER";
 $TransactionDesc= "CustomerPayBillOnline";
 $Remark="paying of goods ordered";
 $timestamp=date('YmdHis');
 $password=base64_encode($businessShortCode.$lipaNaMpesaPasskey.$timestamp);

 $mpesa= new \Safaricom\Mpesa\Mpesa();

  $stkpush = $mpesa->STKPushSimulation($businessShortCode, $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remark);
  $checkoutRequestID = json_decode($stkpush)->CheckoutRequestID;
}
?>

    <div class='modal fade' data-backdrop='static' data-keyboard='false' id="confirmModal" tabindex='-1' role='dialog' aria-labelledby='modalTitle' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
          <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Waiting for payment</h5>
          </div>
          <div class="modal-body">
            Enter your pin in the Mpesa window of your phone
          </div>
          <div class="modal-footer">
            <form action="" method="post">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="confirm_payment" class="btn btn-primary" disabled>Confirm</button>
            </form>
          </div>
        </div>
      </div>
    </div>

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
						<li><a href="accessories.php">Accessories</a></li>
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
						<h3 class="breadcrumb-header">Checkout</h3>
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li class="active">Checkout</li>
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
					<div class="col-md-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Billing address</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="first-name" placeholder="First Name" value="<?php echo $fname; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="last-name" placeholder="Last Name" value="<?php echo $lname; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="address" placeholder="Address" value="<?php echo $address; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="city" placeholder="City" value="<?php echo $city; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="country" placeholder="Country" value="<?php echo $country; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="zip-code" placeholder="ZIP Code" value="<?php echo $zip; ?>" required>
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="tel" placeholder="Telephone" value="<?php echo $phone; ?>" required>
							</div>

							</div>
						</div>
						<!-- /Billing Details -->


					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Your Order</h3>
						</div>

						<div class="order-summary">
              <table>
  							<div class="order-col">
                  <tr>
    								<th><div><strong>PRODUCT</strong></div></th>
                    <th><div><strong>QUANTITY</strong></div></th>
    								<th><div><strong>TOTAL</strong></div></th>
                 </tr>
  							</div>
                  <?php
                  if(isset($_SESSION["cart_item"])){
                    $total_quantity = 0;
                    $total_price = 0;
                  ?>
  							<div class="order-products">
                  <?php
    								foreach ($_SESSION["cart_item"] as $item){
    										$item_price = $item["quantity"]*$item["price"];
    								?>
  								<div class="order-col">
                    <tr>
                      <td>
      									<div class="product-widget">
                          <div class="product-img">
                            <img src="<?php echo $item["image"]; ?>" alt="">
                          </div>
                          <br/><br/>
                          <h5 class=""><a href="#"><?php echo $item["name"]; ?></a></h5>
                        </div>
                      </td>
    									<td><div><?php echo $item["quantity"]; ?></div></td>
                      <td><div><?php echo $item_price; ?></div></td>
                    </tr>
  								</div>
                  <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["price"]*$item["quantity"]);
                    }
                  ?>
  							</div>
                <tr>
    							<div class="order-col">
                    	<td><div>Shiping</div></td>
      								<td><div><strong>FREE</strong></div></td>
    							</div>
                </tr>
                <tr>
    							<div class="order-col">
      								<td><div><strong>TOTAL</strong></div></td>
      								<td><div><strong class="order-total"><?php echo "KSH ".number_format($total_price, 2); ?></strong></div></td>
    							</div>
                </tr>
                <?php
                }
                ?>
              </table>
						</div>
						<div class="payment-method">
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-0">
								<label for="payment-0">
									<span></span>
									M-PESA
								</label>
								<div class="caption">
									<p>MPESA window will appear in your phone asking you for a pin once you click the place order button</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-1" disabled>
								<label for="payment-1">
									<span></span>
									Direct Bank Transfer
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-2" disabled>
								<label for="payment-2">
									<span></span>
									Cheque Payment
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-3">
								<label for="payment-3">
									<span></span>
									Paypal System
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="terms" required>
							<label for="terms">
								<span></span>
								I've read and accept the <a href="#">terms & conditions</a>
							</label>
						</div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <?php
                  if(isset($_SESSION['active_user'])){
                ?>
                  <button type="submit" class="primary-btn order-submit" name="place_order">Place order</button>
                <?php
              }else{
                 ?>
                    <button type="button" class="primary-btn order-submit" data-toggle="modal" data-target="#mustLogin">Place order</button>

                    <!-- Modal -->
                    <div class="modal fade" id="mustLogin" tabindex="-1" role="dialog"  aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" >You Must be Logged In to Place an Order</h5>
                          </div>
                          <div class="modal-body">
                            <a href="signup.php" class="primary-btn order-submit">Head to login page</a>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>

                        </div>
                      </div>
                    </div>
                  <?php
                }
                   ?>

            </form>
					</div>
					<!-- /Order Details -->

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

<?php
	include("includes/footer.php");
?>
