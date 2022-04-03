<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	if(isset($_POST['btnadd'])){
		service_adding();
	}

	## UPDATE FOR NO BOOKING
	if(isset($_POST['btn_upd0'])){
		service_adding();
		header("Location: deleting.php?table=funeral&attr=service_id&data=".$_GET['id']."&url=services&update");
		exit;
	}

	## UPDATE WITH BOOKING
	if(isset($_POST['btn_upd1'])){
		service_editing($_GET['id']);
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
						<h2><a href="services.php">Services</a> <span>> <?php echo (isset($_GET['edit'])) ? "Edit":"Add"; ?> Services</span></h2>
						
						<?php
						if(isset($_GET['edit'])){
							## FOR EDITING SERVICES
							$service = read("services", ["service_id"], [$_GET['id']]);
							$service = $service[0];

							$type = read($service['service_type'], ["service_id"], [$_GET['id']]);
							$type = $type[0];
						?>
						<form class="profile column" method="post" enctype="multipart/form-data">
							<?php
							if(isset($_GET['book'])){
								## NO ONE BOOKED BUTTON
							?>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btn_upd0">Update Service</button>
							<div>
								<label >Image</label>
								<input type="file" name="file_img" required>
							</div>	
							<div>
								<label >Service name</label>
								<input type="text" name="txtfn" value="<?php echo $type['funeral_name']; ?>" required>
							</div>
							<div>
								<label >Type</label>
								<select name="cbotype" style="border:1px solid #000;" required>
									<option value="traditional" <?php echo ($type['funeral_type'] == "traditional") ? "selected":""; ?>>Traditional</option>
									<option value="cremation" <?php echo ($type['funeral_type'] == "cremation") ? "selected":""; ?>>Cremation</option>
								</select>
							</div>
							<div>
								<label >Price</label>
								<input type="number" name="numprice" placeholder="Ex. 80000" value="<?php echo $service['service_cost']; ?>" required>
							</div>

							<?php
							} else {
								## WITH BOOK BUTTON
							?>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btn_upd1">Update Service</button>
							<?php
							}
							?>
							<div>
								<label >Quantity</label>
								<input type="number" name="numqty" value="<?php echo $service['service_qty']; ?>" required>
							</div>
							<div>
								<label >Description</label>
								<input type="text" name="txtdesc" value="<?php echo $service['service_desc']; ?>" required>
							</div>
						</form>
						<?php
						} else {
							## FOR ADDING SERVICES
						?>
						<form class="profile" method="post" enctype="multipart/form-data">
							<div>
								<label >Image</label>
								<input type="file" name="file_img" required>
							</div>	
							<div>
								<label >Service name</label>
								<input type="text" name="txtfn" required>
							</div>
							<div>
								<label >Type</label>
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
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnadd">Add Service</button>
						</form>
						<?php
						}
						?>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
