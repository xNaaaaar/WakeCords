<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$user = provider();

	echo "";
	## 
	if(isset($_POST['btnadd'])) {
		service_adding();
	}
	## UPDATE FOR NO BOOKING
	if(isset($_POST['btn_upd0'])){
		service_adding();
		header("Location: deleting.php?table={$user['provider_type']}&attr=service_id&data=".$_GET['id']."&url=services&update");
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
						
						<em style='color:#ccc;'> Service: <?php echo ucwords($user['provider_type']); ?> </em>
						
						<?php
						// if(isset($_GET['edit'])){
						// 	## FOR EDITING SERVICES
						// 	$service = read("services", ["service_id"], [$_GET['id']]);
						// 	$service = $service[0];

						// 	$type = read($service['service_type'], ["service_id"], [$_GET['id']]);
						// 	$type = $type[0];
						?>

						<!-- <form class="profile column" method="post" enctype="multipart/form-data">
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
								echo "<button class='btn btn-link-absolute higher-top' type='submit' name='btn_upd1'>Update Service</button>";
							}
							?>
							<div>
								<label >Quantity</label>
								<input type="number" name="numqty" value="<?php echo $service['service_qty']; ?>" required>
							</div>
							<div>
								<label >Description (please specify casket size and if for adult/child)</label>
								<textarea name="txtdesc" placeholder='Please specify casket size and if for adult/child..'><?php echo $service['service_desc']; ?></textarea>
							</div>
						</form> -->

						<?php
						// } else {
							## FOR ADDING SERVICES
							## DECLARING VARIABLES
							$edit = false;
							$desc = "";
							$width = "";
							$others = "
							<label class='label-span'>Others <span>(please specify separated by comma)</span></label>
							<div>
								<input type='text' name='txtothers' placeholder='Sample#1, Sample#2, Sample#3'>
							</div>
							";
						?>
						
						<form class="profile" method="post" enctype="multipart/form-data">
							<?php 
							## FOR EDITING SERVICES
							if(isset($_GET['edit'])){
								$service = read("services", ["service_id"], [$_GET['id']]);
								$service = $service[0];
								$edit = true;
	
								$type = read($service['service_type'], ["service_id"], [$_GET['id']]);
								$type = $type[0];
								## NO ONE BOOKED
								if(isset($_GET['book'])){
									echo "<button class='btn btn-link-absolute higher-top' type='submit' name='btn_upd0'>Update Service</button>";
								## WITH BOOKING
								} else {
									echo "<button class='btn btn-link-absolute higher-top' type='submit' name='btn_upd1'>Update Service</button>";
								}
							## FOR ADDING SERVICES
							} else {
								echo "<button class='btn btn-link-absolute higher-top' type='submit' name='btnadd'>Add Service</button>";
							}

							echo "
							<div>
								<label>Image</label>
								<input type='file' name='file_img' required>
							</div>
							";

							if($user['provider_type'] != "headstone"){
								echo "
								<div>
									<label>Service Name</label>
									<input type='text' name='txtsname' required>
								</div>
								";
							}
							## SWITCH FOR DIFFERENT PROVIDER TYPE
							switch($user['provider_type']){
								## FOR FUNERAL SERVICES
								case "funeral":
									$desc = "please specify casket size and if for adult or child";
									$width = "style='width:24%;'";
									##
									echo "
									<div style='width:100%;'>
										<label class='label-span'>Size Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #1' checked>
												<label>Size #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #2'>
												<label>Size #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #3'>
												<label>Size #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #4'>
												<label>Size #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #5'>
												<label>Size #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #1'>
												<label>Size #6</label>
											</div>
										</div>
										{$others}
									</div>
									<div>
										<label>Type</label>
										<select name='cbotype' required>
											<option value=''>BROWSE OPTIONS </option>
											<option value='traditional'>Traditional</option>
											<option value='cremation'>Cremation</option>
										</select>
									</div>
									";
								break;
								## FOR HEADSTONE SERVICES
								case "headstone":
									## HEADSTONE NAME IS A COMBINATION OF COLOR AND TYPE
									echo "
									<div>
										<label>Stone Type</label>
										<select name='cbotype' required>
											<option value=''>BROWSE OPTIONS </option>
											<option value='granite'>Granite</option>
											<option value='marbles'>Marbles</option>
											<option value='bronze'>Bronze</option>
											<option value='limestone'>Limestone</option>
										</select>
									</div>
									<div>
										<label>Headstone Kind</label>
										<select name='cbokind' required>
											<option value=''>BROWSE OPTIONS </option>
											<option value='flat'>Flat</option>
										</select>
									</div>
									<div>
										<label>Color</label>
										<div class='checkbox'>
											<div>
												<input type='radio' name='cbcolor' value='black' required>
												<label>Black</label>
											</div>
											<div>
												<input type='radio' name='cbcolor' value='gray' required>
												<label>Gray</label>
											</div>
											<div>
												<input type='radio' name='cbcolor' value='white' required>
												<label>White</label>
											</div>
										</div>
									</div>
									<div>
										<label class='label-span'>Font Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Font #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Font #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Font #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #4'>
												<label>Font #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #5'>
												<label>Font #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Font #6</label>
											</div>
										</div>
										{$others}
									</div>
									<div>
										<label class='label-span'>Size Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #1'>
												<label>Size #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #2'>
												<label>Size #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #3'>
												<label>Size #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #4'>
												<label>Size #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #5'>
												<label>Size #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #1'>
												<label>Size #6</label>
											</div>
										</div>
										<label class='label-span'>Others <span>(please specify separated by comma)</span></label>
										<div>
											<input type='text' name='txtothers1' placeholder='Sample#1, Sample#2, Sample#3'>
										</div>
									</div>
									";
								break;
								## FOR CHURCH SERVICES
								case "church":
									echo "
									<div>
										<label>Date</label>
										<input type='date' name='txtfn' required>
									</div>
									<div>
										<label>Cemetery</label>
										<input type='text' name='txtfn' required>
									</div>
									<div style='width:100%;'>
										<label>Address</label>
										<input type='text' name='txtfn' required>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label class='label-span'><span>Check to use address in Profile.</span></label>
											</div>
										</div>
									</div>
									";
								break;
								## FOR CANDLE SERVICES
								case "candle":
									$width = "style='width:24%;'";
									##
									echo "
									<div>
										<label class='label-span'>Color Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Color #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Color #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Color #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #4'>
												<label>Color #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #5'>
												<label>Color #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Color #6</label>
											</div>
										</div>
										{$others}
									</div>
									<div>
										<label class='label-span'>Size Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Size #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Size #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Size #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #4'>
												<label>Size #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #5'>
												<label>Size #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Size #6</label>
											</div>
										</div>
										<label class='label-span'>Others <span>(please specify separated by comma)</span></label>
										<div>
											<input type='text' name='txtothers1' placeholder='Sample#1, Sample#2, Sample#3'>
										</div>
									</div>
									<div>
										<label>Candle Type</label>
										<select name='cbotype' required>
											<option value=''>BROWSE OPTIONS </option>
											<option value='flat'>Box</option>
											<option value='flat'>Cylinder</option>
										</select>
									</div>
									";
								break;
								## FOR FLOWER SERVICES
								case "flower":
									$width = "style='width:24%;'";
									##
									echo "
									<div>
										<label class='label-span'>Flower Type <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Flower Type #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Flower Type #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Flower Type #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Flower Type #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Flower Type #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Flower Type #6</label>
											</div>
										</div>
										{$others}
									</div>
									<div>
										<label class='label-span'>Color Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Color #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Color #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Color #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #4'>
												<label>Color #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #5'>
												<label>Color #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Color #6</label>
											</div>
										</div>
										<label class='label-span'>Others <span>(please specify separated by comma)</span></label>
										<div>
											<input type='text' name='txtothers1' placeholder='Sample#1, Sample#2, Sample#3'>
										</div>
									</div>
									<div>
										<label>Flower</label>
										<input type='text' name='txtfn' required>
									</div>
									";
								break;
								## FOR CATERING SERVICES
								case "catering":
									echo "
									<div style='width:100%;'>
										<label class='label-span'>Food Package <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='food #1'>
												<label>Lechon Baboy</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'>
												<label>Food #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'>
												<label>Food #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #4'>
												<label>Food #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #5'>
												<label>Food #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'>
												<label>Food #5</label>
											</div>
										</div>
										{$others}
									</div>
									";
								break;
							}

							if($user['provider_type'] != "church"){
								echo "
								<div {$width}>
									<label>Price</label>
									<input type='number' name='numprice' placeholder='Ex. 50000 for 50k' required>
								</div>
								";
							}
							
							if($user['provider_type'] != "catering" && $user['provider_type'] != "church"){
								echo "
								<div {$width}>
									<label>Quantity</label>
									<input type='number' name='numqty' required>
								</div>
								";
							}
							?>

							<div style='width:100%'>
								<label class='label-span'>Description <span><?php echo (!empty($desc)) ? "({$desc})":""; ?></span></label>
								<textarea name="txtdesc" placeholder='Write here...' required></textarea>
							</div>
						</form>
						<?php
						// }
						?>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
