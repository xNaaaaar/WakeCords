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
			$this_page = "profile";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div thank-you">
						<div class="thanks">
							<i class="fa-solid fa-circle-check"></i>	
							<?php
							if(user_type() == "seeker"){
								echo "
								<h2>Thank you for purchasing!</h2>

								<p>You can also browse more services or check your purchases:</p>
								<ol>
									<li><a href='funeral.php'>Services</a></li>
									<li><a href='purchase.php'>Purchases</a></li>
								</ol>
								";
							}
							else if(user_type() == "provider"){
								echo "
								<h2>Thank you for subscribing!</h2>

								<p>You can also browse profile or check your services purchases:</p>
								<ol>
									<li><a href='profile.php'>Profile</a></li>
									<li><a href='purchase.php'>Purchases</a></li>
								</ol>
								";
							}
							?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
