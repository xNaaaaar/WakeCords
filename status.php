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
			$this_page = "transact";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2><a href="purchase.php">Purchase</a> <span>> Status</span></h2>
						
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

								<div class="additional-info card">
									<h3>Additional details</h3>
									<?php
									##
									switch($purchase['service_type']){
										case "funeral":
											echo "
											<label>Deceased name</label>
											<input type='text' disabled value='".$details['deceased_name']."'>

											<label>Burial datetime</label>
											<input type='text' disabled value='".date("M j, Y - H:i:s", strtotime($details['burial_datetime']))."'>

											<label>Burial address</label>
											<input type='text' disabled value='".$details['burial_add']."'>

											<label>Delivery address</label>
											<input type='text' disabled value='".$details['delivery_add']."'>

											";
											break;
									}
									?>
									
									<a class='btn' href="">Update details</a>
								</div>
								<div class="receipt card">
									<figure>
										<img src="images/main-logo.png" alt="">
									</figure>
									<p>Thank you for purchasing!</p>
									<h3>Purchase Receipt</h3>

									

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
											<li>₱ <?php echo number_format($total,2,'.',',');?></li>
										</ul>
									</div>
								</div>
							</div>
							<div class='order_status'>
								<div class='<?php echo purchase_progress($purchase['purchase_progress'], 1); ?>'>
									<h3>Preparing the wake</h3>
									<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
								</div>
								<div class='<?php echo purchase_progress($purchase['purchase_progress'], 2); ?>'>
									<h3>Wake is ready</h3>
									<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
								</div>
								<div class='<?php echo purchase_progress($purchase['purchase_progress'], 3); ?>'>
									<h3>Wake is delivered (optional)</h3>
									<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
								</div>
								<div class='<?php echo purchase_progress($purchase['purchase_progress'], 4); ?>'>
									<h3>Service provider received payment</h3>
									<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
								</div>
								<div class='<?php echo purchase_progress($purchase['purchase_progress'], 5); ?>'>
									<h3>Done</h3>
									<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
