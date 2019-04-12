<?php
 include("includes/header.php");
 include('includes/functions.php');

  echo $loginError;
   if(isset($_SESSION['active_user'])){
     header("Location: index.php");
   }


 if(isset($_POST['login'])){
   $formEmail = $_POST['email'];
   $formPass = validateFormData( $_POST['password'] );

   $user_details = $db_handle->runQuery("SELECT * FROM tbluser WHERE email='$formEmail'");
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
       $phone = $user_details[$key]["telephone"];
       $hashedPass = $user_details[$key]["password"];
     }

     // verify hashed password with submitted password
        if( password_verify( $formPass, $hashedPass ) ) {
          header( "Location: index.php" );
            // correct login details!
            // store data in SESSION variables
            $_SESSION['loggedInUser'] = $fname;
            $_SESSION['active_user'] = $userid;
            // redirect user to home page

        } else { // hashed password didn't verify

            // error message
            $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again.</div>";
        }

   }else{
     // there are no results in database
       // error message
       $loginError = "<div class='alert alert-danger'>No such user in database. Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
   }
 }

 if(isset($_POST['createAccount'])){
   $fname = $_POST['first-name'];
   $lname = $_POST['last-name'];
   $email = $_POST['email'];
   $address = $_POST['address'];
   $city = $_POST['city'];
   $country = $_POST['country'];
   $zip = $_POST['zip-code'];
   $phone = $_POST['tel'];
   $tempPass =  $_POST["password"];
   $hashedPass = password_hash( $tempPass, PASSWORD_DEFAULT );
   $register = $db_handle->runQuery("INSERT INTO tbluser(fname, lname, email, address, city, country, zipcode, telephone, password) VALUES('$fname', '$lname', '$email', '$address', '$city', '$country', '$zip', '$phone', '$hashedPass')");


  echo "<div class='alert alert-success'>Congratulations  $fname !! you have successfully registered</div>";

 }

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

						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li >Laptops</li>
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
          <!-- login -->
          <div class="col-md-4">
            <?php echo $loginError;
              if(!isset($_SESSION['active_user'])){
                header("Location: index.php");

            ?>
            <p class="lead">Log in to your account.</p>


            <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                <div class="form-group">
                    <label for="login-email" class="sr-only">Email</label>
                    <input type="text" class="form-control" id="login-email" placeholder="email" name="email" value="<?php echo $formEmail; ?>" required>
                </div>
                <div class="form-group">
                    <label for="login-password" class="sr-only">Password</label>
                    <input type="password" class="form-control" id="login-password" placeholder="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="login">Login</button>
                <button type="submit" class="btn btn-danger" name="forgot-pass">Forgot Password?</button>
            </form>
          </div>
          <!-- /login -->
          <div class="col-md-offset-2 col-md-6">
            <p class="lead">Register an account.</p>
              <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
    							<div class="form-group">
    								<input class="input" type="text" name="first-name" placeholder="First Name" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="text" name="last-name" placeholder="Last Name" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="email" name="email" placeholder="Email" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="text" name="address" placeholder="Address" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="text" name="city" placeholder="City" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="text" name="country" placeholder="Country" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="text" name="zip-code" placeholder="ZIP Code" required>
    							</div>
    							<div class="form-group">
    								<input class="input" type="tel" name="tel" placeholder="Telephone" required>
    							</div>
                  <div class="form-group">
                    	<input class="input" type="password" name="password" placeholder="Enter Your Password" required>
                  </div>
                   <button type="submit" class="btn btn-primary" name="createAccount">Create Account</button>
              </form>
            <?php   } ?>

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
