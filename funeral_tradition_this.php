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
						<?php
							## NAME BASED ON SERVICE PROVIDER
							echo "
							<h2><a href='funeral.php'>Services</a> <span>> <a href='funeral_tradition.php?service_name={$_SESSION['service_name']}'>{$_SESSION['service_name']}</a> > Ngan sa lungon</span></h2>
							";
						?>
						 
						<div class="banner-cards trad">
							<?php
								$service = DB::query("SELECT * FROM services s JOIN funeral f ON s.service_id = f.service_id WHERE s.service_id=?", array($_GET['service_id']), "READ");
								$service = $service[0];

								echo "
								<img class='card-img' src='images/providers/".$service['service_type']."/".$service['provider_id']."/".$service['service_img']."'>
								<div class='card-div'>
									<div>
										<h3>".$service['service_name']."
											<span>
												<i class='fa-solid fa-star'></i>
												<i class='fa-solid fa-star'></i>
												<i class='fa-solid fa-star'></i>
												<i class='fa-solid fa-star'></i>
											</span>
										</h3>
										<p>
											".$service['service_desc']."
										</p>
										<div class='card-price trad'>₱ ".number_format($service['service_cost'], 2, '.', ',')."</div>
										<button class='btn trad'>Add to Cart</button>
									</div>
								</div>
								";
							?>
							
						</div>
						<div class="banner-ratings">
							<h2>Reviews</h2>
							<div class="rate">
								<h3>Name sa nag rate
									<span>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
									</span>
									<span>
										<!-- DATE -->
										02/22/2022
									</span>
								</h3>
								<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!</p>
							</div>
							<div class="hr"></div>
							<div class="rate">
								<h3>Name sa nag rate
									<span>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
									</span>
									<span>
										<!-- DATE -->
										02/22/2022
									</span>
								</h3>
								<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!</p>
							</div>
							<div class="hr"></div>
							<div class="rate">
								<h3>Name sa nag rate
									<span>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
										<i class="fa-solid fa-star"></i>
									</span>
									<span>
										<!-- DATE -->
										02/22/2022
									</span>
								</h3>
								<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!</p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
