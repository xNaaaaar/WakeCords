<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	if(isset($_POST['btnsend'])){
		if(isset($_SESSION['provider']))
			request("payout");
		if(isset($_SESSION['admin']))
			request("upload");
	}
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
						## FOR PROVIDER
						if(isset($_SESSION['provider'])){
							##
						?>
						<h2><a href="purchase.php">Transactions</a> <span>> Payout</span></h2>
						<form class="profile column" method="post">
							<div>
								<label>Payment Method</label>
								<select name="cbomethod" required>
									<option value="">BROWSE OPTIONS</option>
									<option value="card">Card</option>
									<option value="gcash">Gcash</option>
								</select>
							</div>
							<div>
								<label>Account No.</label>
								<input type="text" name="txtacc" required>
							</div>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnsend" onclick='return confirm("Are you sure the account number is correct? Press OK to send requests.");'>Send Requests</button>
						</form>

						<?php
						## FOR ADMIN
						} else if(isset($_SESSION['admin'])) {
							##
						?>
						<h2><a href="purchase.php">Transactions</a> <span>> Upload Proof</span></h2>
						<form class="profile column" method="post" enctype="multipart/form-data">
							<div class="banner-section card">
								<?php
								$payout = DB::query("SELECT * FROM payout a JOIN purchase b ON a.purchase_id = b.purchase_id JOIN services c ON b.service_id = c.service_id JOIN provider d ON c.provider_id = d.provider_id WHERE a.purchase_id = ?", array($_GET['id']), "READ");
								$payout = $payout[0];
								echo "
								<h3>Provider's {$payout["payout_method"]} details: </h3>
								<label>Account Name: </label>
								<input class='readonly' type='text' value='{$payout["provider_fname"]} {$payout["provider_lname"]}' readonly>
								<label>Account Number: </label>
								<input class='readonly' type='text' value='{$payout["payout_account"]}' readonly>
								";
								
								?>
							</div>
							<div>
								<label>Proof of Payment</label>
								<input type="file" name="file_img" required>
							</div>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnsend" onclick='return confirm("Are you sure you uploaded the correct proof of payment for this payout? Press OK to proceed.");'>Upload</button>
						</form>

						<?php
						}
						?>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
