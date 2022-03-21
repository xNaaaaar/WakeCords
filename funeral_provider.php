<!-- HEAD AREA -->
<?php include("others/head.php"); ?>

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
						<h2><a href="funeral.php">Services</a> <span>> St. Peter</span></h2> <!-- NAME BASED ON SERVICE PROVIDER -->
						
						<!-- TABS -->
						<?php
						$current_tab = "funeral_provider";
						$this_tab = "traditional";
						include("others/tabs.php");?>

						<div class="banner-cards">
							<div class="card-0">
								<a href="funeral_provider_trad.php">
									<img src="images/coffin.png" alt="">
									<h3>Ngan sa lungon
										<span>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
										</span>
									</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!</p>
									<div class="card-price">₱ 120,000.00</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
