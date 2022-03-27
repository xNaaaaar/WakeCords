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
						
						<form method="post">
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

									$type_list = [];
		
									if(count($list)>0){
										$total = 0;
										$service_fee = 500;
										foreach($list as $results){
											$service_ = read("services", ["service_id"], [$results['service_id']]);
											$service_ = $service_[0];

											$differ_ = service_type($service_['service_type'], $service_['service_id']);

											array_push($type_list, $service_['service_type']);

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
								<div class="note blue"><i class="fa-solid fa-circle-question"></i> Take note that you can always update this data inputted later.</div>
								
								<?php
								## DECEASE NAME FOR FUNERAL, CHURCH, HEADSTONE
								if(service_type_exist_bool("funeral", $type_list) || service_type_exist_bool("church", $type_list) || service_type_exist_bool("headstone", $type_list)) {
									echo "
									<div class='details-con no-padding'>
										<div class='single'>
											<label>Deceased name <span>*<span></label>
											<input type='text' name='txtdeceasedname' required>
										</div>
									</div>
									";
								}
								## DELIVERY ADDRESS INPUT FOR ALL SERVICES EXCEPT CHURCH
								if(!service_type_exist_bool("church", $type_list)){
									echo "
									<div class='details-con no-padding'>
										<div class='single'>
											<label>Delivery address <span>*<span></label>
											<input type='text' name='txtdeliveryadd' required>
										</div>
									</div>
									";
								}
								if(service_type_exist_bool("funeral", $type_list)){
									echo "
									<h5>Funeral</h5>
									<div class='details-con'>
										<div>
											<label>Burial date & time <span>*<span></label>
											<input type='datetime-local' name='dtburial' required>
										</div>
										<div>
											<label>Burial address <span>*<span></label>
											<input type='text' name='txtburialadd' required>
										</div>
									</div>
									";
								}

								if(service_type_exist_bool("candle", $type_list)){
									echo "
									<h5>Candle</h5>
									<div class='details-con'>
										<div>
											<label>Delivery date <span>*<span></label>
											<input type='date' name='datedeliverycandle' required>
										</div>
									</div>
									";
								}

								if(service_type_exist_bool("flower", $type_list)){
									echo "
									<h5>Flowers</h5>
									<div class='details-con'>
										<div>
											<label>Delivery date <span>*<span></label>
											<input type='date' name='datedeliveryflower' required>
										</div>
										<div>
											<label>Ribbon Message <span>*<span></label>
											<input type='text' name='txtribbonmsg' required>
										</div>
									</div>
									";
								}

								if(service_type_exist_bool("headstone", $type_list)){
									echo "
									<h5>Headstone</h5>
									<div class='details-con'>
										<div>
											<label>Date of birth <span>*<span></label>
											<input type='date' name='datebirth' required>
										</div>
										<div>
											<label>Date of death <span>*<span></label>
											<input type='date' name='datedeath' required>
										</div>
										<div>
											<label>Message <span>*<span></label>
											<input type='text' name='txtmsg' placeholder='Write a message here for the deceased.' required>
										</div>
										<div>
											<label>Delivery date <span>*<span></label>
											<input type='date' name='datedeliveryheadstone' required>
										</div>
									</div>
									";
								}

								if(service_type_exist_bool("catering", $type_list)){
									echo "
									<h5>Catering</h5>
									<div class='details-con'>
										<div>
											<label>Delivery date & time <span>*<span></label>
											<input type='datetime-local' name='dtdelivery' required>
										</div>
										<div>
											<label>Number of pax <span>*<span></label>
											<input type='number' name='numpax' required>
										</div>
									</div>
									";
								}

								if(service_type_exist_bool("church", $type_list)){
									echo "
									<h5>Church</h5>
									<div class='details-con'>
										<div>
											<label>Cemetery address with plan (optional)</label>
											<input type='text' name='txtcemaddress'>
										</div>
									</div>
									";
								}
								
								?>

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
								pay_purchase($type_list, $list);

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
