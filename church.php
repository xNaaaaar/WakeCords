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
						$this_tab = "church";
						include("others/tabs.php");?>

						<div class="banner-cards">
							<div class="card-0">		
								<img class="no-padding" src="images/sto-rosario.jpg" alt="">
								<h3>Santo Rosario
									<span>on March 15, 2023 @02:30pm</span>
								</h3>
								<p>
									<?php
										$text = "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!";
										echo limit_text($text, 10);
									?>
								</p>
								<p><b>Carreta Cemetery</b></p>
								<a class="btn" href="">View</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
