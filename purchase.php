<!-- HEAD AREA -->
<?php 
	include("others/functions.php"); 
	include("others/head.php");

	if(isset($_GET['deleted']))
		echo "<script>alert('Successfully deleted purchase!')</script>";
		
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
						<h2>Transactions</h2>

						<?php
						## DISPLAY PAY AT ONCE IF THERE ARE TWO OR MORE TO PAY STATUS
						if(isset($_SESSION['seeker'])){
							$purchases = read('purchase', ["seeker_id"], [$_SESSION['seeker']]);
							$count_to_pay = 0;
							##
							foreach($purchases as $purchase){
								## COUNT TO PAY PURCHASE STATUS
								if($purchase['purchase_status'] == "to pay") $count_to_pay++;
							}
							## IF COUNT TO PAY IS MORE THAN ONE 
							if($count_to_pay > 1)
								echo "<a class='btn btn-link-absolute' href='payment.php'>Pay all at once</a>";	
						}
						?>
						
						<div class="banner-ratings purchases-lists">
							<div class="list">
								<div></div>
								<div>Status</div>
								<div>Requests</div>
							</div>
							<?php purchase_list(); ?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
