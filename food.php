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
			$this_page = "services";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2>Services</h2>
						
						<!-- TABS -->
						<?php
						$current_tab = "services";
						$this_tab = "food";
						include("others/tabs.php");?>

						<div class="banner-cards">
							<?php
							messaging("error", "Food catering services is currently not available!");
							?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
