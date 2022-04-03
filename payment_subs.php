<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 
?>

<body>
	<div class="container">
		<!-- HEADER AREA -->
		<?php include("others/header.php"); ?>
		
		<!-- BANNER AREA -->
		<div class="banner">

			<!-- SIDEBAR AREA -->
			<?php 
			$this_page = "profile";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2><a href='profile.php'>Subscription</a> <span>> Payment</span></h2>
						
						<form method="post">
							<div class="banner-section card">
								<ul>
									<li><h3>Subscription</h3></li>
									<li><h3>Type</h3></li>
									<li><h3>Cost</h3></li>
								</ul>
								<ul>
									<li>PH</li>
									<?php
									$type = "";
									$cost = 0;
									if(isset($_GET['monthly'])){
										echo "
										<li>monthly</li>
										<li>₱ 200.00</li>
										";
										$type = "monthly";
										$cost = 200;
									}
									else if(isset($_GET['yearly'])){
										echo "
										<li>yearly</li>
										<li>₱ 2,000.00</li>
										";
										$type = "yearly";
										$cost = 2000;
									}
									?>
								</ul>
								<div class='hr full-width'></div>
								<ul>
									<li></li>
									<li>Total Cost:</li>
									<?php
									
									if(isset($_GET['monthly'])){
										echo "
										<li><h3>₱ 200.00</h3></li>
										";
									}
									else if(isset($_GET['yearly'])){
										echo "
										<li><h3>₱ 2,000.00</h3></li>
										";
									}
									?>
								</ul>
							</div>
							<!-- CARD DETAILS -->
							<div class="banner-section details card">
								<h3>Card Details 
									<ul>
										<li><i class="fa-brands fa-cc-mastercard"></i></li>
										<li><i class="fa-brands fa-cc-amex"></i></li>
										<li><i class="fa-brands fa-cc-visa"></i></li>
									</ul>
								</h3>

								<div class="details-con">
									<div>
										<label for="label-name">Account Name <span>*<span></label>
										<input type="text" name="txtaccname">
									</div>
									<div>
										<label for="label-name">Card Number <span>*<span></label>
										<input type="text" name="txtcard" minlength='16' maxlength='16'>
									</div>
									<div>
										<label for="label-name">Expiration Date <span>*<span></label>
										<input type="month" name="mthexpiry">
									</div>
									<div>
										<label for="label-name">CVV <span>*<span></label>
										<input type="text" name="txtcvv" minlength='3' maxlength='3'>
									</div>
								</div>
							</div>

							<button type='submit' name='btnpay' class='btn'>Pay now!</button>

							<?php

							if(isset($_POST['btnpay'])){
								subs_payment($type, $cost);

								header("Location: thanks.php");
								exit;
							}

							?>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
