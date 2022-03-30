<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	## SUCCESSFULLY LOGIN
	if(isset($_GET['login'])) echo "<script>alert('Thank you for logging in!')</script>";

	## SUCCESSFULLY UPDATED
	if(isset($_GET['updated'])) echo "<script>alert('Updated successfully!')</script>";

	$user = current_user();
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
						<h2>Profile <mark class="btn status type"><?php echo user_type(); ?></mark></h2>
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
							if(user_type() == "admin") echo "<a class='btn' href=''><i class='fa-solid fa-plus'></i> Add Admin</a>";
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
							if(user_type() == "seeker"){
								$status = user_status();
								if($status != "")
									echo "<span class='btn status ".status_color()."'>".$status."</span>";
								echo "</h2>";
							
								if($status == "" || $status == "not verified"){	
									echo "
									<div class='note red'>Note: Please upload a clear copy of death certificate to proceed.</div>
									<a class='btn btn-link-absolute no-top' href='required.php'>Upload Requirement</a>
									"; 
								}
								## IF UPLOADED REQUIREMENT
								if($status != ""){
									$image_name = read("requirement", ["seeker_id"], [$user['seeker_id']]);
									$image_name = $image_name[0];
	
									echo "
									<figure>	
										<img src='images/".user_type()."s/".$user['seeker_id']."/".$image_name['req_img']."' alt=''>
										<figcaption>Death Certificate</figcaption>	
									</figure>";
								}
							}
						}
						?>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
