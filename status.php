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
						<h2>Order Status</h2>
						
						<div class='order_status'>
							<div class='done'>
								<h3>Preparing the wake</h3>
								<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
							</div>
							<div>
								<h3>Wake is ready</h3>
								<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
							</div>
							<div>
								<h3>Wake is delivered (optional)</h3>
								<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
							</div>
							<div>
								<h3>Service provider received payment</h3>
								<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
							</div>
							<div>
								<h3>Done</h3>
								<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae, nemo.</p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
