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
							<dialog>
								<h3>asdasd</h3>
								<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus, soluta!</p>
							</dialog>
							<!-- PURCHASE DETAILS -->
							<div class="banner-section card">
								<ul>
									<li><h3>Purchases</h3></li>
									<li><h3>Qty</h3></li>
									<li><h3>Cost</h3></li>
								</ul>
								<?php
									if($single_payment) $list = read("purchase", ["seeker_id", "purchase_id", "purchase_status"], [$_SESSION['seeker'], $_GET['purchaseid'], "to pay"]);
									else $list = read("purchase", ["seeker_id", "purchase_status"], [$_SESSION['seeker'], "to pay"]);
		
									if(count($list)>0){
										$total = 0;
										$service_fee = 500;
										foreach($list as $results){
											$service_ = read("services", ["service_id"], [$results['service_id']]);
											$service_ = $service_[0];

											$differ_ = service_type($service_['service_type'], $service_['service_id']);

											echo "
											<ul>
												<li>".$differ_[1]."</li>
												<li>x".$results['purchase_qty']."</li>
												<li>₱ ".number_format($results['purchase_total'],2,'.',',')."</li>
											</ul>
											";
											$total += $results['purchase_total'];
										}
										$total += $service_fee;
									}
								?>
								
								<div class='hr full-width'></div>
								<ul>
									<li></li>
									<li>Service Fee:</li>
									<li>₱ <?php echo number_format($service_fee,2,'.',','); ?></li>
								</ul>
								<ul>
									<li></li>
									<li>Total Cost:</li>
									<li>₱ <?php echo number_format($total,2,'.',','); ?></li>
								</ul>
							</div>
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

							<button class='btn'>Pay now!</button>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
