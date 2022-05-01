<!-- HEAD AREA -->
<?php 
	include("others/functions.php"); 
	include("others/head.php");

	if(isset($_GET['deleted']))
		echo "<script>alert('Successfully deleted purchase!')</script>";

	if(isset($_GET['canceled']))
		echo "<script>alert('Successfully canceled purchase!')</script>";

	if(isset($_GET['requests']))
		echo "<script>alert('Request payout sent! Please wait admin to process your request.')</script>";

	if(isset($_GET['uploaded']))
		echo "<script>alert('Successfully uploaded proof of payment!')</script>";

	if(isset($_POST['btnresched'])) {
		$numid = $_POST['numid'];
		$cbotime = $_POST['cbotime'];
		##
		update("purchase", ["purchase_sched_time", "purchase_progress"], [$cbotime, 1, $numid], "purchase_id");
		echo "<script>alert('Rescheduled successfully!')</script>";
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
								echo "<a class='btn btn-link-absolute' href='payment.php' onclick='return confirm(\"Are you sure you want to pay all purchases at once?\")'>Pay all at once</a>";	
							
							## TABS
							$current_tab = "transact";
							$this_tab = "purchase";
							include("others/tabs.php");
						}
						?>
						
						<div class="banner-ratings purchases-lists">
							<?php purchase_list(); ?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script>
		// FOR RESCHED MODAL
		function open_modal($id){
			let resched = document.querySelector('#modal-resched'+$id);
			//let open_resched = document.querySelector('#open-resched');
			let close_resched = document.querySelector('#close-resched'+$id);

			resched.showModal();

			close_resched.addEventListener('click', () => {
				resched.close();
			})
		}
	</script>
</body>
</html>
