<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	if(isset($_POST['btnadd'])){
		service_adding();
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
			$this_page = "services";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2><a href="services.php">Services</a> <span>> Add Services</span></h2>
						
						<form class="profile" method="post" enctype="multipart/form-data">
							<div>
								<label >Image</label>
								<input type="file" name="file_img" required>
							</div>	
							<div>
								<label >Funeral name</label>
								<input type="text" name="txtfn" required>
							</div>
							<div>
								<label >Funeral type</label>
								<select name="cbotype" style="border:1px solid #000;" required>
									<option value="traditional">Traditional</option>
									<option value="cremation">Cremation</option>
								</select>
							</div>
							<div>
								<label >Price</label>
								<input type="number" name="numprice" placeholder="Ex. 80000" required>
							</div>
							<div>
								<label >Quantity</label>
								<input type="number" name="numqty" required>
							</div>
							<div>
								<label >Description</label>
								<input type="text" name="txtdesc" required>
							</div>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnadd">Add</button>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
