<!-- HEAD AREA -->
<?php 
	include("others/functions.php"); 
	include("others/head.php");

	$single_payment = (isset($_GET['purchaseid'])) ? true:false;
?>

<body>
	<div class="container">
		<!-- HEADER AREA -->
		<?php include("others/header.php"); ?>
		
		<!-- BANNER AREA -->
		<div class="banner">

			<!-- SIDEBAR AREA -->
			<?php 
			$this_page = "transact";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2>
							<?php
								echo ($single_payment) ? "<a href='purchase.php'>Purchase</a>":"<a href='cart.php'>Transactions</a>";
							?>
						<span>> Payment</span></h2>
						
						<form action="post">
							
							<!-- ADDITIONAL DETAILS -->
							<div class="banner-section details card">
								<h3>Additional Details</h3>

								<div class="details-con">
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
								</div>
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
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
									<div>
										<label for="label-name">First name</label>
										<input type="text" name="" id="label-name" placeholder="">
									</div>
								</div>
							</div>
							<!-- PURCHASE DETAILS -->
							<div class="banner-section card">
								<ul>
									<li><h3>Purchases</h3></li>
									<li><h3>Qty</h3></li>
									<li><h3>Cost</h3></li>
								</ul>
								<ul>
									<li>Title</li>
									<li>x2</li>
									<li>220,000.00</li>
								</ul>
								<ul>
									<li>Title</li>
									<li>x2</li>
									<li>220,000.00</li>
								</ul>
								<ul>
									<li>Title</li>
									<li>x2</li>
									<li>220,000.00</li>
								</ul>
								<div class='hr full-width'></div>
								<ul>
									<li></li>
									<li>Total Cost:</li>
									<li>220,000.00</li>
								</ul>
							</div>

							<button class='btn'>Pay now!</button>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
