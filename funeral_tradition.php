<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$_SESSION['service_name'] = $_GET['service_name'];
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
						<h2><a href="funeral.php">Services</a> <span>> <?php echo $_SESSION['service_name']; ?></span></h2> <!-- NAME BASED ON SERVICE PROVIDER -->
						
						<!-- TABS -->
						<?php
						echo "
							<ul>
								<li><a class='active' href='funeral_tradition.php?service_name={$_SESSION['service_name']}' >Traditional</a></li>
								<li><a class='' href='funeral_cremate.php?service_name={$_SESSION['service_name']}'>Cremation</a></li>
							</ul>
						";
						?>
						
						<div class="banner-cards">
							<?php
								services("funeral", "traditional");
							?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>