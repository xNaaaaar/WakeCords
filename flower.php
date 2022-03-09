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
						<h2>Services</h2>
						
						<!-- TABS -->
						<?php
						$current_tab = "services";
						$this_tab = "flower";
						include("others/tabs.php");?>

						<div class="banner-cards">
							<div class="card-0">
								<a href="">
									<img src="images/coffin.png" alt="">
									<h3>Title</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!</p>
								</a>
							</div>
							<div class="card-0">
								<a href="">
									<img src="images/coffin.png" alt="">
									<h3>Title Title</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, </p>
								</a>
							</div>
							<div class="card-0">
								<a href="">
									<img src="images/coffin.png" alt="">
									<h3>Title</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. </p>
								</a>
							</div>
							<div class="card-0">
								<a href="">
									<img src="images/coffin.png" alt="">
									<h3>Title Title</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti, vitae inventore. Tempore quod fugit commodi!</p>
								</a>
							</div>
							<div class="card-0">
								<a href="">
									<img src="images/coffin.png" alt="">
									<h3>Title TitleTitle</h3>
									<p>Lorem ipsum dolor,  adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!</p>
								</a>
							</div>
							<div class="card-0">
								<a href="">
									<img src="images/coffin.png" alt="">
									<h3>Title</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, fugit commodi!</p>
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
