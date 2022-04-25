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
								## SEND EMAIL
								try {
									$read = read("seeker", ["seeker_id"], [$_SESSION['seeker']]);
									$read = $read[0];

									$subject = "Purchase Receipt";
									$txt = "Hi {$read['seeker_fname']} {$read['seeker_lname']},\nThank you for your purchase! Here's your receipt: ";
									$txt .= "\n\n\nBest regards,\nTeam Wakecords";
									
									// mail($read['seeker_email'], $subject, $txt);
								}
								catch (Exception $e) {
									echo "Error sending email! Error found: ".$e->getMessage();
								}
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
