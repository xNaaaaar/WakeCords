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
									<option value="card">Card</option>
									<option value="gcash">Gcash</option>
								</select>
							</div>
							<div>
								<label>Account No.</label>
								<input type="text" name="txtacc" required>
							</div>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnsend">Send Requests</button>
						</form>

						<?php
						## FOR ADMIN
						} else if(isset($_SESSION['admin'])) {
							##
						?>
						<h2><a href="purchase.php">Transactions</a> <span>> Upload Proof</span></h2>
						<form class="profile column" method="post" enctype="multipart/form-data">
							<div>
								<label>Proof of Payment</label>
								<input type="file" name="file_img" required>
							</div>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnsend">Upload</button>
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
