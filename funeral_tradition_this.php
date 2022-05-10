<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$provider = read("provider", ["provider_id"], [$_GET['id']]);
	$provider = $provider[0];

	if(isset($_GET['rated']))
		echo "<script>alert('Thank you for your feedback!')</script>";
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
							$service_type = read("services", ["service_id"], [$_GET['service_id']]);
							$service_type = $service_type[0];
							##
							$service = DB::query("SELECT * FROM services a JOIN {$service_type['service_type']} b ON a.service_id = b.service_id WHERE a.service_id=?", array($_GET['service_id']), "READ");
							$service = $service[0];
							
							if(isset($_SESSION['provider'])){
								$service_link = "services.php";
								$a_link = "services.php";
							}
							else if(isset($_SESSION['seeker'])){
								## FOR FUNERAL
								if($service_type['service_type'] == "funeral") {
									$service_link = "funeral.php";
									$a_link = "funeral_tradition.php";
								}
								## FOR CHURCH
								else if($service_type['service_type'] == "church") {
									$service_link = "church.php";
									$a_link = "church.php";
								}
								## FOR HEADSTONE
								else if($service_type['service_type'] == "headstone") {
									$service_link = "headstone.php";
									$a_link = "headstone.php";
								}
							}
							else {
								$service_link = "funeral.php";
								$a_link = "funeral_tradition.php";
							}
							## DECLARE ARRAYS
							$size_array = array();
							$font_array = array();
							$qty_array = array();
							for($i=1; $i<=$service['service_qty']; $i++) array_push($qty_array, $i);

							## NAME BASED ON SERVICE PROVIDER
							switch($service_type['service_type']){
								case "funeral":
									$size_array = explode(",",$service['funeral_size']);
									echo "
									<h2><a href='{$service_link}'>Services</a> <span>> <a href='{$a_link}?id={$provider['provider_id']}'>{$provider['provider_company']}</a> > {$service['funeral_name']}</span></h2>
									";
									## SERVICE NAME
									$service_name = $service['funeral_name'];
								break;

								case "headstone":
									$size_array = explode(",",$service['stone_size']);
									$font_array = explode(",",$service['stone_font']);
									## SERVICE NAME
									$service_name = $service['stone_color']." ".$service['stone_kind']." ".$service['stone_type'];
									$service_name = ucwords($service_name);
									##
									echo "
									<h2><a href='{$service_link}'>Services</a> <span>> <a href='{$a_link}'>{$provider['provider_company']}</a> > {$service_name}</span></h2>
									";
								break;

								case "church":
									echo "
									<h2><a href='{$service_link}'>Services</a> <span>> <a href='{$a_link}'>{$provider['provider_company']}</a> > {$service['church_church']}</span></h2>
									";
									## SERVICE NAME
									$service_name = $service['church_church'];
								break;
							}
							
						?>
						 
						<div class="banner-cards trad">
							<?php
								echo "
								<img class='card-img' src='images/providers/".$service['service_type']."/".$service['provider_id']."/".$service['service_img']."'>
								<div class='card-div'>
									<div>
										<h3>".$service_name."
											<span>
												".ratings($service['service_id'], true)."
												<i class='fa-solid fa-star'></i>
												(".ratings_count($service['service_id'], true).")
											</span>
										</h3>
										<p>
											".$service['service_desc']."
										</p>	
								";
								if($service_type['service_type'] != "church")
									echo "<div class='card-price trad'>₱ ".number_format($service['service_cost'], 2, '.', ',')."</div>";
								## CHECK IF SERVICE QTY IS 0
								$qty_status = "";
								if($service_type['service_qty'] == 0) $qty_status = "Out of Stock";
								##
								if(isset($_SESSION['seeker']) && !isset($_GET['rate']) && !isset($_GET['rated'])){
								echo "
								<form method='post'>
									<div class='selection-con'>";
									if($service_type['service_type'] != "church") {
								
										## SELECT TAG FOR SIZES
										if(count($size_array) > 0 && $size_array[0] != NULL) {
											select_array($size_array, "sizes");
									 	} 
										## SELECT TAG FOR FONTS
										if(count($font_array) > 0 && $font_array[0] != NULL) {
											select_array($font_array, "fonts");
										}
										## SELECT TAG FOR QTY
										echo "
										<div>
											<label>Quantity: <span style='color:red;'>{$qty_status}</span></label>
											<select name='cboquantity' required>
												<option value=''>BROWSE OPTIONS</option>";
												for($i=1; $i<=$service_type['service_qty']; $i++) 
													echo "<option value='".$i."'>".$i."</option>";
										echo "
											</select>
										</div>";
								 
									## FOR CHURCH
									} else {

								echo "	<div>
											<label>Time: </label>
											<select name='cbotime' required>
												<option value=''>BROWSE OPTIONS</option>"; 
												echo time_available($service['church_mass_time'], $_GET['service_id']);
								echo "		</select>
										</div>";
									}
								echo "
									</div>	
										<button type='submit' name='btnadd' class='btn trad' onclick=\"return confirm('Confirm booking?');\">Book</button>
								</form>";
								}
								else {
									if($service_type['service_type'] != "church")
										echo "<h4 style='color:gray'>QUANTITY: x{$service['service_qty']}</h4>";
								}
								echo "
									</div>
								</div>";
								##
								if(isset($_POST['btnadd'])){
									switch($service_type['service_type']){
										## FOR FUNERAL
										case "funeral":
											$cbomaxqty = $_POST['cboquantity'];
											$cbosize = $_POST['cbosizes'];
											$attr_list = ["service_id", "seeker_id", "cart_qty", "cart_size"];
											$data_list = [$service['service_id'], $_SESSION['seeker'], $cbomaxqty, $cbosize];
										break;
										## FOR CHURCH
										case "church":
											$cbotime = $_POST['cbotime'];
											$attr_list = ["service_id", "seeker_id", "cart_sched_time"];
											$data_list = [$service['service_id'], $_SESSION['seeker'], $cbotime];
										break;
										## FOR HEADSTONE
										case "headstone":
											$cbomaxqty = $_POST['cboquantity'];
											$cbosize = $_POST['cbosizes'];
											$cbofont = $_POST['cbofonts'];
											$attr_list = ["service_id", "seeker_id", "cart_qty", "cart_size", "cart_font"];
											$data_list = [$service['service_id'], $_SESSION['seeker'], $cbomaxqty, $cbosize, $cbofont];
										break;
									}
									
									##
									create("cart", $attr_list, qmark_generator(count($attr_list)), $data_list);

									header("Location: cart.php?cart_success");
									exit;
								}
							?>
							
						</div>
						<div class="banner-ratings" id="ratings">
							<h2>Reviews</h2>
								
							<?php
							## BUTTON REVIEW IS CLICKED
							if(isset($_POST['btnrev'])) rate();

							if(isset($_GET['rate'])){
								messaging("notify", "Leave a review below by clicking <mark class='mark-style' id='open-subs'>here</mark>");
							}
							?>
							<!-- DIALOG FOR LEAVING A REVIEW -->
							<dialog class='modal-img' id='modal-subs'>
								<button id='close-subs'>+</button>
								<form class="feedback" method='post'>
									<h2>Leave a Review</h2>
									<p>Thank you!</p>
									<div class="rating-con">
										<div class="rating">
											<input type="radio" id="star5" name="star" value="5" required><label for="star5" title='Excellent'></label>
											<input type="radio" id="star4" name="star" value="4" required><label for="star4" title='Very Good'></label>
											<input type="radio" id="star3" name="star" value="3" required><label for="star3" title='Good'></label>
											<input type="radio" id="star2" name="star" value="2" required><label for="star2" title='Bad'></label>
											<input type="radio" id="star1" name="star" value="1" required><label for="star1" title='Very Bad'></label>
										</div>
										<textarea name="txtrev" placeholder='Leave a comment (optional)'></textarea>
										<button type='submit' name='btnrev' class="btn trad">Review</button>
									</div>
								</form>
							</dialog>

							<div class="ratings-con">
							<?php
							$ratings = read("feedback", ["service_id"], [$_GET['service_id']]);
							
							if(count($ratings)>0){
								foreach($ratings as $result){
									$seeker = read("seeker", ["seeker_id"], [$result['seeker_id']]);
									$seeker = $seeker[0];
									$days = (strtotime(date('Y-m-d')) - strtotime(date($result['feedback_date']))) /60/60/24;
									
									echo "
									<div class='rate'>
									";
									##
									if($days == 0) {
										echo "
										<span>
											<mark class='mark-style no-cursor'>new ratings</mark>	
										</span>
										";
									}
									else {
										echo "
										<span class='gray-italic'>
											rated ".$days." days ago
										</span>
										";
									}
									##
									echo "
										<h3>{$seeker['seeker_fname']} {$seeker['seeker_lname']}
											<span>
												".display_stars($result['feedback_star'])."
											</span>
										</h3>
										<p>{$result['feedback_comments']}</p>
									</div>
									";
								}
							}
							else messaging("notify", "No reviews yet!");
							?>

							</div>
							
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script>
	<?php if(isset($_GET['rate'])) { ?>
		// FOR REVIEW MODAL
		let review = document.querySelector('#modal-subs');
		let open_review = document.querySelector('#open-subs');
		let close_review = document.querySelector('#close-subs');

		review.showModal();

		open_review.addEventListener('click', () => {
			review.showModal();
		})

		close_review.addEventListener('click', () => {
			review.close();
		})
	<?php } ?>
	</script>
<!-- FOOTER JS -->
<?php include("others/footer-js.php"); ?>
