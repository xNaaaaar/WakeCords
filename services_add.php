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
						// } else {
						## FOR ADDING SERVICES
						## DECLARING VARIABLES
						$edit = false;
						$desc = "";
						$width = "";

						if(isset($_GET['edit']) && service_is_booked($_GET['id'])) $edit = true;
						?>
						
						<form class="profile <?php echo ($edit) ? "column":""; ?>" method="post" enctype="multipart/form-data">
							<?php 
							## FOR EDITING SERVICES
							if(isset($_GET['edit'])){
								$edit = true;
								##
								$service = read("services", ["service_id"], [$_GET['id']]);
								$service = $service[0];
								##
								$type = read($service['service_type'], ["service_id"], [$_GET['id']]);
								$type = $type[0];
								##
								## PREVIEW IMAGE DIALOG
								echo "
								<dialog class='modal-img aspect-ratio' id='modal-img'>
									<button id='close-img'>+</button>
									<figure>
										<img src='images/providers/".$service['service_type']."/".$_SESSION['provider']."/".$service['service_img']."'>
									</figure>
								</dialog>
								";
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

							$others = "
							<label class='label-span'>Others <span>(please specify separated by comma)</span></label>
							<div>
								<input type='text' name='txtothers' placeholder='Sample#1, Sample#2, Sample#3' value='";
							$others .= ($edit) ? return_value("services", $_GET['id'], "others"):"";
							$others .= "' >
							</div>";
							## DO THIS IF SERVICE HAS NO BOOKING
							if((isset($_GET['edit']) && !service_is_booked($_GET['id'])) || $edit == false){

							echo "
							<div>
								<label>Image 
							"; 
								if($edit) echo "<mark class='mark-style' id='open-img'>preview</mark>"; ## ↑ 
							echo "
								</label>
								<input type='file' name='file_img' required>
							</div>
							";
							## SWITCH FOR DIFFERENT PROVIDER TYPE
							switch($user['provider_type']){
								## FOR FUNERAL SERVICES
								case "funeral":
									$desc = "please specify casket size and if for adult or child";
									$width = "style='width:24%;'";
									##
									echo "
									<div>
										<label>Service Name</label>
										<input type='text' name='txtsname' value='"; 
										echo ($edit) ? return_value("services", $_GET['id'], "name"):"";
										echo "' required>
									</div>
									<div style='width:100%;'>
										<label class='label-span'>Size Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #1'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #1"):"";
												echo ">
												<label>Size #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #2'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #2"):"";
												echo ">
												<label>Size #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #3'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #3"):"";
												echo ">
												<label>Size #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #4'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #4"):"";
												echo ">
												<label>Size #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #5'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #5"):"";
												echo ">
												<label>Size #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #6'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #6"):"";
												echo ">
												<label>Size #6</label>
											</div>
										</div>
										{$others}
									</div>
									<div>
										<label>Type</label>
										<select name='cbotype' required>
											<option value=''>BROWSE OPTIONS </option>
											<option value='traditional'";
											echo ($edit) ? return_value("services", $_GET['id'], "type", "traditional"):"";
											echo ">Traditional</option>
											<option value='cremation'";
											echo ($edit) ? return_value("services", $_GET['id'], "type", "cremation"):"";
											echo ">Cremation</option>
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
											<option value='granite'";
											echo ($edit) ? return_value("services", $_GET['id'], "type", "granite"):"";
											echo ">Granite</option>
											<option value='marbles'";
											echo ($edit) ? return_value("services", $_GET['id'], "type", "marbles"):"";
											echo ">Marbles</option>
											<option value='bronze'";
											echo ($edit) ? return_value("services", $_GET['id'], "type", "bronze"):"";
											echo ">Bronze</option>
											<option value='limestone'";
											echo ($edit) ? return_value("services", $_GET['id'], "type", "limestone"):"";
											echo ">Limestone</option>
										</select>
									</div>
									<div>
										<label>Headstone Kind</label>
										<select name='cbokind' required>
											<option value=''>BROWSE OPTIONS </option>
											<option value='flat'";
											echo ($edit) ? return_value("services", $_GET['id'], "kind", "flat"):"";
											echo ">Flat</option>
										</select>
									</div>
									<div>
										<label>Color</label>
										<div class='checkbox'>
											<div>
												<input type='radio' name='cbcolor' value='black'";
												echo ($edit) ? return_value("services", $_GET['id'], "color", "black"):"";
												echo " required>
												<label>Black</label>
											</div>
											<div>
												<input type='radio' name='cbcolor' value='gray'";
												echo ($edit) ? return_value("services", $_GET['id'], "color", "gray"):"";
												echo " required>
												<label>Gray</label>
											</div>
											<div>
												<input type='radio' name='cbcolor' value='white'";
												echo ($edit) ? return_value("services", $_GET['id'], "color", "white"):"";
												echo " required>
												<label>White</label>
											</div>
										</div>
									</div>
									<div>
										<label class='label-span'>Font Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #1'";
												echo ($edit) ? return_value("services", $_GET['id'], "font", "font #1"):"";
												echo ">
												<label>Font #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #2'";
												echo ($edit) ? return_value("services", $_GET['id'], "font", "font #2"):"";
												echo ">
												<label>Font #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #3'";
												echo ($edit) ? return_value("services", $_GET['id'], "font", "font #3"):"";
												echo ">
												<label>Font #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #4'";
												echo ($edit) ? return_value("services", $_GET['id'], "font", "font #4"):"";
												echo ">
												<label>Font #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #5'";
												echo ($edit) ? return_value("services", $_GET['id'], "font", "font #5"):"";
												echo ">
												<label>Font #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbfont[]' value='font #6'";
												echo ($edit) ? return_value("services", $_GET['id'], "font", "font #6"):"";
												echo ">
												<label>Font #6</label>
											</div>
										</div>
										{$others}
									</div>
									<div>
										<label class='label-span'>Size Available <span>(check all that applies)</span></label>
										<div class='checkbox'>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #1'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #1"):"";
												echo ">
												<label>Size #1</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #2'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #2"):"";
												echo ">
												<label>Size #2</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #3'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #3"):"";
												echo ">
												<label>Size #3</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #4'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #4"):"";
												echo ">
												<label>Size #4</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #5'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #5"):"";
												echo ">
												<label>Size #5</label>
											</div>
											<div>
												<input type='checkbox' name='cbsize[]' value='size #6'";
												echo ($edit) ? return_value("services", $_GET['id'], "size", "size #6"):"";
												echo ">
												<label>Size #6</label>
											</div>
										</div>
										<label class='label-span'>Others <span>(please specify separated by comma)</span></label>
										<div>
											<input type='text' name='txtothers1' placeholder='Sample#1, Sample#2, Sample#3' value='"; 
											echo ($edit) ? return_value("services", $_GET['id'], "others1"):"";
											echo "'>
										</div>
									</div>
									";
								break;
								## FOR CHURCH SERVICES
								case "church":
									echo "
									<div>
										<label>Priest</label>
										<input type='text' name='txtpriest' value='"; 
										echo ($edit) ? return_value("services", $_GET['id'], "priest"):"";
										echo "' required>
									</div>
									<div>
										<label>Church</label>
										<input type='text' name='txtsname' value='"; 
										echo ($edit) ? return_value("services", $_GET['id'], "name"):"";
										echo "' required>
									</div>
									<div>
										<label>Cemetery</label>
										<input type='text' name='txtcemetery' value='"; 
										echo ($edit) ? return_value("services", $_GET['id'], "cemetery"):"";
										echo "' required>
									</div>
									<div>
										<label>Date</label>
										<input type='date' name='date' value='"; 
										echo ($edit) ? return_value("services", $_GET['id'], "date"):"";
										echo "' required>
									</div>
									<div>
										<label>Address</label>
										<input id='address' class='' type='text' name='txtaddress' value='"; 
										echo ($edit) ? return_value("services", $_GET['id'], "address"):"";
										echo "' required>
										<div class='checkbox'>
											<div class='full'>
												<input id='profile-address' type='checkbox' name='cbaddress'>
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
										<label>Service Name</label>
										<input type='text' name='txtsname' value='' required>
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
										<label>Service Name</label>
										<input type='text' name='txtsname' value='' required>
									</div>
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
									<div>
										<label>Service Name</label>
										<input type='text' name='txtsname' value='' required>
									</div>
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
									<input type='number' name='numprice' placeholder='Ex. 50000 for 50k' value='";
									echo ($edit) ? return_value("services", $_GET['id'], "price"):"";
									echo "' required>
								</div>
								";
							}

							} ## END OF, IF SERVICE IS NOT BOOKED
							
							if($user['provider_type'] != "catering" && $user['provider_type'] != "church"){
								echo "
								<div {$width}>
									<label>Quantity</label>
									<input type='number' name='numqty' value='";
									echo ($edit) ? return_value("services", $_GET['id'], "qty"):"";
									echo "' required>
								</div>
								";
							}

							if($user['provider_type'] == "church"){
								echo "
								<div style='width:100%;'>
									<label class='label-span'>Time <span>(please follow time format, separated by comma)</span></label>
									<input type='text' name='txttime' value='";
									echo ($edit) ? return_value("services", $_GET['id'], "time"):"10:00am - 11:00am, 11:00am - 12:00nn, 12:00nn - 01:00pm, 01:00pm - 02:00pm, 02:00pm - 03:00pm";
									echo "' required>
								</div>
								";
							}
							## FOR DESCRIPTIONS WIDTH
							if(isset($_GET['edit']) && service_is_booked($_GET['id']) && $user['provider_type'] != "church") {
								$width = "width:49.3%;";
							}
							else {
								$width = "width:100%;";
							}
							?>

							<div style='<?php echo $width; ?>'>
								<label class='label-span'>Description <span><?php echo (!empty($desc)) ? "({$desc})":""; ?></span></label>
								<textarea name="txtdesc" placeholder='Write here...' required><?php echo ($edit) ? return_value("services", $_GET['id'], "desc"):""; ?></textarea>
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
	<script>
	<?php 
	## FOR MODAL
	if($edit) { ?>
		let img = document.querySelector('#modal-img');
		let open = document.querySelector('#open-img');
		let close = document.querySelector('#close-img');

		open.addEventListener('click', () => {
			img.showModal();
		})

		close.addEventListener('click', () => {
			img.close();
		})
	<?php 
	} 
	
	if($user['provider_type'] == "church") { ?>
		let p_address = document.getElementById('profile-address');
		let address = document.getElementById('address');

		p_address.addEventListener("click", () => {
			if(p_address.checked) {
				address.classList.add("readonly");
				address.readOnly = true;
				address.required = false;
			} else {
				address.classList.remove("readonly");
				address.readOnly = false;
				address.required = true;
			}
		})
	<?php
	} ?>
	</script>
</body>
</html>
