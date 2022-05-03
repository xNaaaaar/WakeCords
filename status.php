<!-- HEAD AREA -->
<?php 
	include("others/functions.php"); 
	include("others/head.php");

	if(isset($_GET['updated']))
		echo "<script>alert('Successfully updated!')</script>";

	if(isset($_SESSION['provider'])) $provider = provider();
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
						<?php
						##
						if(isset($_SESSION['seeker'])){
							echo "<h2><a href='purchase.php'>Purchase</a> <span>> Status</span></h2>";
						}
						else {
							echo "<h2><a href='purchase.php'>Transactions</a> <span>> Status</span></h2>";
						}
						## UPDATE PROGRESS STATUS FOR PROVIDER
						if(isset($_SESSION['provider']) && !progress_limits($_GET['purchaseid']) && $provider['provider_type'] != "church") {
							echo "<a class='btn btn-link-absolute' href='updating.php?id=".$_GET['purchaseid']."&purchase' onclick='return confirm(\"Are you sure you want to update purchase progress?\");'>Update Progress</a>";
						}?>

						<div class="order-con">
							<div class="order-info">
								<?php
								##
								$purchase = DB::query("SELECT * FROM purchase p JOIN seeker see ON p.seeker_id = see.seeker_id JOIN services ser ON p.service_id = ser.service_id WHERE purchase_id = ?", array($_GET['purchaseid']), "READ");
								$purchase = $purchase[0];

								$service = read($purchase['service_type'], ["service_id"], [$purchase['service_id']]);
								$service = $service[0];

								$details = read("details", ["purchase_id"], [$purchase['purchase_id']]);
								$details = $details[0];

								$total = $purchase['purchase_total'] + 500;
								?>

								<div class="additional-info collapse">
									<h3><?php echo (isset($_SESSION['seeker'])) ? "Additional":"Contact"; ?> Details <span class="shake-x" onclick="toggleCollapse('collapse-info', 'collapse-info-icon')"><i class="fa-solid fa-chevron-down front" id="collapse-info-icon"></i><i class="fa-solid fa-chevron-up"></i></span></h3>
									
									<div class="display-none" id="collapse-info">
										<div class='hr full-width'></div>
										<?php
										## TYPE [notify, success, error]
										if(isset($_SESSION['seeker'])) messaging("notify", "Note: ");
										echo "
										<label>".$purchase['seeker_fname']." ".$purchase['seeker_lname']."</label>
										<label><strong>".$purchase['seeker_phone']."</strong></label>";
										##
										switch($purchase['service_type']){
											## FOR FUNERAL
											case "funeral":
												echo "
												<div class='hr full-width'></div>
												
												<label>Deceased name</label>
												<input type='text' disabled value='".$details['deceased_name']."'>

												<label>Burial datetime</label>
												<input type='text' disabled value='".date("M j, Y - h:i a", strtotime($details['burial_datetime']))."'>

												<label>Burial address</label>
												<input type='text' disabled value='".$details['burial_add']."'>

												<label>Delivery address</label>
												<input type='text' disabled value='".$details['delivery_add']."'>
												";
											break;
											## FOR CHURCH
											case "church":
												$burial_dt = date("M j, Y - h:i a", strtotime($details['burial_datetime']));
												if(empty($details['burial_datetime'])){
													$burial_dt = date("M j, Y - h:i a");
												}
												echo "
												<label>Scheduled on: <em class='gray-italic'>".$purchase['purchase_sched_time']."</em><label>
												<div class='hr full-width'></div>
												
												<label>Deceased name</label>
												<input type='text' disabled value='".$details['deceased_name']."'>

												<label>Burial datetime</label>
												<input type='text' disabled value='".$burial_dt."'>

												<label>Burial address</label>
												<input type='text' disabled value='".$details['burial_add']."'>
												";
											break;
											## FOR HEADSTONE
											case "headstone":
												echo "
												<div class='hr full-width'></div>
												
												<label>Deceased name</label>
												<input type='text' disabled value='".$details['deceased_name']."'>

												<label>Birth date</label>
												<input type='text' disabled value='".date("M j, Y", strtotime($details['birth_date']))."'>

												<label>Death date</label>
												<input type='text' disabled value='".date("M j, Y", strtotime($details['death_date']))."'>

												<label>Delivery date</label>
												<input type='text' disabled value='".date("M j, Y", strtotime($details['delivery_date']))."'>

												<label>Delivery address</label>
												<input type='text' disabled value='".$details['delivery_add']."'>

												<label>Headstone message</label>
												<input type='text' disabled value='".$details['message']."'>
												";
											break;
										}

										if(isset($_SESSION['seeker'])){
											if($purchase['purchase_progress'] == 0){
												echo "<a class='btn' href='status_details.php?purchaseid=".$_GET['purchaseid']."'>Update details</a>";
											}
											else if($purchase['purchase_progress'] == 1 && $purchase['service_type'] == "church"){
												echo "<a class='btn' href='status_details.php?purchaseid=".$_GET['purchaseid']."'>Update details</a>";
											}
										}
											
										?>
									</div>
								</div>
								<?php
								## DISPLAY THIS IF NOT CHURCH
								if($purchase['service_type'] != "church") {
								?>
								<div class="additional-info collapse">
									<h3>Purchase Receipt <span class="shake-x delay-1" onclick="toggleCollapse('collapse-receipt', 'collapse-receipt-icon')"><i class="fa-solid fa-chevron-down front" id="collapse-receipt-icon"></i><i class="fa-solid fa-chevron-up"></i></span></h3>

									<div class="display-none receipt" id="collapse-receipt">
										<figure>
											<img src="images/main-logo.png" alt="">
										</figure>
										<p>Thank you for purchasing!</p>
										
										<div class="receipt-details">
											<?php
											echo "
											<h3>Seeker's Details</h3>
											<h5>".$purchase['seeker_fname']." ".$purchase['seeker_lname']." <em>purchase on ".date("M j, Y", strtotime($purchase['purchase_date']))."</em></h5>
											<p></p>
											<p>".$purchase['seeker_address']."</p>
											<p>".$purchase['seeker_email']."</p>
											";
											?>
										</div>
										<div class="table">
											<ul class='head'>
												<li>Item</li>
												<li>Qty</li>
												<li>Cost</li>
												<li>Total Cost</li>
											</ul>
											<?php
											##
											echo "
											<ul>
												<li>".$service[1]."</li>
												<li>".$purchase['purchase_qty']."</li>
												<li>₱ ".number_format($purchase['service_cost'],2,'.',',')."</li>
												<li>₱ ".number_format($purchase['purchase_total'],2,'.',',')."</li>
											</ul>
											";
											?>
											<div class="hr full-width"></div>
											<ul>
												<li></li>
												<li></li>
												<li>Service Fee:</li>
												<li>₱ 500.00</li>
											</ul>
											<ul>
												<li></li>
												<li></li>
												<li><h3>Total:</h3></li>
												<li><h3>₱ <?php echo number_format($total,2,'.',',');?></h3></li>
											</ul>
										</div>
									</div>
								</div>
								<?php
								}
								?>
							</div>
							<div class='order_status'>
								<?php 
								$payout = read("payout", ["purchase_id"], [$_GET['purchaseid']]);

								if(count($payout)>0 && !isset($_SESSION['seeker'])){
									$payout = $payout[0];
									if($payout['payout_image'] != NULL) {
										echo "
									<p>Download proof of payment by clicking <a href='images/admins/payout/{$payout['payout_image']}' download='payment_proof_{$payout['purchase_id']}' class='status'>here</a>.</p>
									";
									}
								}
								## SERVICES
								switch($purchase['service_type']){
									## FOR FUNERAL
									case "funeral":
										echo "
										<div class='".purchase_progress($purchase['purchase_progress'], 1)."'>
											<h3>Preparing wake</h3>
											<p>Funeral Home is now processing the wake.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 2)."'>
											<h3 >Wake is ready</h3>
											<p >Funeral Home has now prepared the wake and is ready for delivery.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 3)."'>
											<h3>Wake is delivered (optional)</h3>
											<p>Funeral Home has delivered the wake in the location and is ready for viewing.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 4)."'>
											<h3>Wake is ready for viewing</h3>
											<p>Wake is available for visitation.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 5)."'>
											<h3>Done</h3>
											<p>Transaction successfully completed.</p>
										</div>
										";
									break;
									## FOR CHURCH
									case "church":
									break;
									## FOR HEADSTONE
									case "headstone":
										echo "
										<div class='".purchase_progress($purchase['purchase_progress'], 1)."'>
											<h3>Headstone creation</h3>
											<p>Headstone is now being customized.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 2)."'>
											<h3>Headstone is ready</h3>
											<p>Headstone has been successfully crafted and is ready to be delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 3)."'>
											<h3>Headstone in transit</h3>
											<p>Headstone is currently being delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 4)."'>
											<h3>Headstone delivered succesfully</h3>
											<p>Transaction successfully completed.</p>
										</div>
										";
									break;
									## FOR FLOWER
									case "flower":
										echo "
										<div class='".purchase_progress($purchase['purchase_progress'], 1)."'>
											<h3>Preparing flower</h3>
											<p>Flower is now being customized.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 2)."'>
											<h3>Flower is ready</h3>
											<p>Flower has been successfully prepared and is ready to be delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 3)."'>
											<h3>Flower in transit</h3>
											<p>Flower is currently being delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 4)."'>
											<h3>Flower delivered succesfully</h3>
											<p>Transaction successfully completed.</p>
										</div>
										";
									break;
									## FOR CATERING
									case "catering":
										echo "
										<div class='".purchase_progress($purchase['purchase_progress'], 1)."'>
											<h3>Preparing your order</h3>
											<p>Foods are being prepared.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 2)."'>
											<h3>Food is ready</h3>
											<p>Food has been successfully prepared and is ready to be delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 3)."'>
											<h3>Food in transit</h3>
											<p>Food is currently being delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 4)."'>
											<h3>Food delivered succesfully</h3>
											<p>Transaction successfully completed.</p>
										</div>
										";
									break;
									## FOR CATERING
									case "candle":
										echo "
										<div class='".purchase_progress($purchase['purchase_progress'], 1)."'>
											<h3>Preparing candles</h3>
											<p>Candles are being prepared.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 2)."'>
											<h3>Candle is ready</h3>
											<p>Candle has been successfully prepared and is ready to be delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 3)."'>
											<h3>Candle in transit</h3>
											<p>Candle is currently being delivered.</p>
										</div>
										<div class='".purchase_progress($purchase['purchase_progress'], 4)."'>
											<h3>Candle delivered succesfully</h3>
											<p>Transaction successfully completed.</p>
										</div>
										";
									break;
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script>
		function toggleCollapse(con, icon){
			// const openCollapse = document.getElementById("open-collapse")
			const collapseCon = document.getElementById(con);
			const collapseIcon = document.getElementById(icon);

			collapseCon.classList.toggle('display-none');

			collapseIcon.classList.toggle('front');
		}
	</script>
</body>
</html>
