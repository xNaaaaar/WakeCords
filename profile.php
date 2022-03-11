<!-- HEAD AREA -->
<?php 
	include("others/head.php"); 
	include("others/functions.php");

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
						<h2>Profile</h2>
						<form class="profile" method="post">
							<a class="btn-new" href="edit_profile.php">Update</a>
							<div>
								<label for="label-name">First name</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_fname']:$user['provider_fname']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Middle name</label>
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
							
						</form>
					</div>

					<div class="banner-div no-padding-top">
						<h2>Account</h2>
						<form class="profile" method="post">
							<a class="btn-new" href="change_pass.php">Change Password</a>
							<div>
								<label for="label-name">Email</label>
								<input type="text" name="" id="label-name" placeholder="<?php echo (user_type() == 'seeker')?$user['seeker_email']:$user['provider_email']; ?>" disabled>
							</div>
							<div>
								<label for="label-name">Password</label>
								<input type="text" name="" id="label-name" placeholder="********" disabled>
							</div>
						</form>
					</div>

					<div id="required" class="banner-div no-padding-top">
						<h2>Requirements</h2>
						<?php
							$exist = false;
							if(user_type() == "seeker"){
								$exist = read_bool("requirement", ["seeker_id"], [$user['seeker_id']]);
							}
							
							if ($exist){
								$image_name = read("requirement", ["seeker_id"], [$user['seeker_id']]);
								$image_name = $image_name[0];

								echo "
								<figure>	
									<img src='images/".user_type()."s/".$user['seeker_id']."/".$image_name['req_img']."' alt=''>
									<figcaption>Death Certificate</figcaption>	
								</figure>";
							}
							else {
								echo "
								<div class='note red'>Note: Please upload a death certificate to proceed.</div>
								<form class='profile' method='post'>
									<a class='btn-new' href='required.php'>Upload Requirement</a>
								</form>";
							}
						?>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
