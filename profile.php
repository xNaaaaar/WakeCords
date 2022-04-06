<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	## SUCCESSFULLY LOGIN
	if(isset($_GET['login'])) echo "<script>alert('Thank you for logging in!')</script>";

	## SUCCESSFULLY UPDATED
	if(isset($_GET['updated'])) echo "<script>alert('Updated successfully!')</script>";

	$user = current_user();

	## SUBSCRIPTION DESCRIPTION
	$_SESSION['subs_desc'] = "Provider can post and boost their service in an affordable amount.";
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
					<div class="banner-div">
						<h2>Profile</h2>
						<a class="btn btn-link-absolute" href="edit_profile.php">Update</a>

						<form class="profile" method="post">
							
							<?php
								if(user_type() != "admin"){
									if(user_type() == "provider"){
										echo "
										<div>
											<label for='label-name'>Company name</label>
											<input type='text' id='label-name' placeholder='".$user["provider_company"]."' disabled>
										</div>
										";
									}
							?>
							<div>
								<label for="label-name">First name</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_fname']:$user['provider_fname']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Middle initial</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_mi']:$user['provider_mi']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Last name</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_lname']:$user['provider_lname']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Address</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_address']:$user['provider_address']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Phone</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_phone']:$user['provider_phone']; ?>" disabled>
							</div>

							<?php
								} else {
								## FOR ADMIN
							?>
							
							<div>
								<label for="label-name">First name</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo $user['admin_fname']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Middle initial</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo $user['admin_mi']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Last name</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo $user['admin_lname']; ?>" disabled>
							</div>

							<?php
								}
							?>
							
						</form>
					</div>

					<div class="banner-div no-padding-top">
						<h2>Account</h2>
						<div class="links">
							<?php
							if(user_type() == "admin") echo "<a class='btn' href='admin_add.php'><i class='fa-solid fa-plus'></i> Add Admin</a>";
							?>
							<a class="btn margin-inline-0" href="change_pass.php">Change Password</a>
						</div>

						<form class="profile" method="post">
							<?php
							if(user_type() != "admin"){
							## FOR USER
							?>
							<div>
								<label for="label-name">Email</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_email']:$user['provider_email']; ?>" disabled>
							</div>
							<?php
							} else {
							## FOR ADMIN
							?>
							<div>
								<label for="label-name">Email</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo $user['admin_email']; ?>" disabled>
							</div>
							<?php
							}
							?>
							<div>
								<label for="label-name">Password</label>
								<input type="text" name="" id="label-name" placeholder="********" disabled>
							</div>
						</form>
					</div>
					
					<?php 
					## FOR NON-ADMIN
					if(user_type() != "admin"){ ?>
					<div id="required" class="banner-div no-padding-top">	
						<h2>Requirements
						<?php
						## USER STATUS [VERIFIED, NOT VERIFIED, PENDING]
						$exist = false;
						if(user_type() == "seeker" || user_type() == "provider"){
							$status = user_status();
							if($status != "")
								echo "<span class='btn status ".status_color()."'>".$status."</span>";
							echo "</h2>";
						
							if($status == "" || $status == "not verified"){	
								if(user_type() == "seeker"){
									## TYPE [notify, success, error]
									messaging("error", "Note: Please upload a clear copy of death certificate to proceed.");
								}
								else {
									## TYPE [notify, success, error]
									messaging("error", "Note: Please upload a clear copy of business permit to proceed.");
								}

								echo "<a class='btn btn-link-absolute no-top' href='required.php'>Upload Requirement</a>"; 
							}
							## IF UPLOADED REQUIREMENT
							if($status != ""){
								if(user_type() == "seeker")
									$image_name = read("requirement", ["seeker_id"], [$user['seeker_id']]);
								else
									$image_name = read("requirement", ["provider_id"], [$user['provider_id']]);
								
								$image_name = $image_name[0];

								if($status == "pending") {
									## TYPE [notify, success, error]
									messaging("notify", "Note: Please wait for admin's verification.");
								}

								echo "
								
								<figure>
									<figcaption>Click to view <mark id='open-img'>".$image_name['req_type']."</mark></figcaption>	
								</figure>
								
								<dialog class='modal-img' id='modal-img'>
									<button id='close-img'>+</button>
									<figure class='open-image'>
								";
									if(user_type() == "seeker")
										echo "<img src='images/".user_type()."s/".$user['seeker_id']."/".$image_name['req_img']."'>";
									else 
										echo "<img src='images/".user_type()."s/".$user['provider_type']."/".$user['provider_id']."/".$image_name['req_img']."'>";
								echo "
									</figure>
								</dialog>
								";
							}
						}

						?>
					</div>
					<?php
					## FOR ADMIN
					} else {
						$admin = read("admin");
						echo "
						<div class='banner-ratings profile-lists'>
							<h2>Admins</h2>
							<div class='list'>
								<div>ID#</div>
								<div>Name</div>
								<div>Email Address</div>
							</div>
						";

						foreach($admin as $results){
							echo "
							<div class='list data'>
								<div>".$results['admin_id']."</div>
								<div>".$results['admin_fname']." ".$results['admin_mi'].". ".$results['admin_lname']."</div>
								<div>".$results['admin_email']."</div>
							</div>
							";
						}

						echo"
						</div>
						";
					}

					## FOR PROVIDER ONLY
					if(user_type() == "provider" && $status == "verified"){
					?>
					<div class="banner-div no-padding-top" style="padding-top:var(--size-6);">
						
						<?php
						if(is_subscribed()){
							$subs = read("subscription", ["provider_id"], [$_SESSION['provider']]);
							
							if(count($subs) > 0){
								## IF SUBSCRIPTION IS EXPIRED 
								$latest_sub = $subs[count($subs)-1];
								if(date("Y-m-d") >= date("Y-m-d", strtotime($latest_sub['subs_duedate']))){
									echo "<h2>Subscription <mark class='btn status type' style='background-color:var(--red);'>expired</mark></h2>";
									not_subs($_SESSION['subs_desc']);
								}
								else 
									echo "<h2>Subscription <mark class='btn status type'>".subscription()."</mark></h2>";
								##
								echo "
								<div class='hr full-width' style='margin-top:10px;margin-bottom:20px;'></div>
								<div class='banner-ratings profile-lists'>
									<div class='list' >
										<div>Start Date</div>
										<div>Expiry Date</div>
										<div>Paid</div>
									</div>
								";
								##
								foreach($subs as $result){
									echo "
									<div class='list data' style='margin-bottom:0;'>
										<div>".date("M j, Y", strtotime($result['subs_startdate']))."</div>
										<div>".date("M j, Y", strtotime($result['subs_duedate']))."</div>
										<div>₱ ".number_format($result['subs_cost'],2,'.',',')."</div>
									</div>
									";
								}
								##
								echo "</div>";
							}
						}
						else {
							echo "<h2>Subscription</h2>";
							not_subs($_SESSION['subs_desc']);
						}
						?>
					</div>
					<?php
					}
					?>
				</div>
			</section>
		</div>
	</div>
	<script>
		// FOR REQUIREMENTS MODAL
		let img = document.querySelector('#modal-img');
		let open = document.querySelector('#open-img');
		let close = document.querySelector('#close-img');

		open.addEventListener('click', () => {
			img.showModal();
		})

		close.addEventListener('click', () => {
			img.close();
		})
		
		// FOR SUBSCRIPTION MODAL
		let subs = document.querySelector('#modal-subs');
		let open_subs = document.querySelector('#open-subs');
		let close_subs = document.querySelector('#close-subs');

		open_subs.addEventListener('click', () => {
			subs.showModal();
		})

		close_subs.addEventListener('click', () => {
			subs.close();
		})
	</script>
</body>
</html>
