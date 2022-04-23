<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$user = current_user();

	if(isset($_POST['btnsave'])){
		
		if(user_type() == "seeker")
			update_profile("seeker", $user["seeker_email"]);
		else if(user_type() == "provider")
			update_profile("provider", $user["provider_email"]);
		else 
			update_profile("admin", $user["admin_email"]);
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
			$this_page = "profile";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2><a href="profile.php">Profile</a> <span>> Edit Profile</span></h2>
						<form class="profile column" method="post" enctype="multipart/form-data">
							<?php
							## FOR ADMIN
							if(user_type() == "admin"){
							?>
								<div>
									<label for="label-name">First name</label>
									<input type="text" name="txtfn" id="label-name" value="<?php echo $user['admin_fname']; ?>" required>
								</div>
								<div>
									<label for="label-name">Middle initial</label>
									<input type="text" name="txtmi" id="label-name" value="<?php echo $user['admin_mi']; ?>" maxlength="1" required>
								</div>
								<div>
									<label for="label-name">Last name</label>
									<input type="text" name="txtln" id="label-name" value="<?php echo $user['admin_lname']; ?>" required>
								</div>
							<?php
							}
							else {
							## FOR NON-ADMIN
								if(user_type() == "provider"){
									$name = (empty($user['provider_company'])) ? 'required':'readonly';
									## TYPE [notify, success, error]
									messaging("error", "Note: You can only edit company name once and company logo is not required.");

									echo "
									<div>
										<label>Company logo</label>
										<input class='' type='file' name='file_logo'>
									</div>
									<div>
										<label>Company name</label>
										<input class='".$name."' type='text' name='txtcn' value='".$user['provider_company']."' ".$name.">
									</div>
									";
								}
							?>
								<div>
									<label for="label-name">First name</label>
									<input type="text" name="txtfn" id="label-name" value="<?php echo (user_type() == 'seeker')?$user['seeker_fname']:$user['provider_fname']; ?>" required>
								</div>
								<div>
									<label for="label-name">Middle initial</label>
									<input type="text" name="txtmi" id="label-name" value="<?php echo (user_type() == 'seeker')?$user['seeker_mi']:$user['provider_mi']; ?>" maxlength="1" required>
								</div>
								<div>
									<label for="label-name">Last name</label>
									<input type="text" name="txtln" id="label-name" value="<?php echo (user_type() == 'seeker')?$user['seeker_lname']:$user['provider_lname']; ?>" required>
								</div>
								<div>
									<label for="label-name">Address</label>
									<input type="text" name="txtaddress" id="label-name" value="<?php echo (user_type() == 'seeker')?$user['seeker_address']:$user['provider_address']; ?>" required>
								</div>
								<div>
									<label for="label-name">Phone</label>
									<input type="text" name="txtphone" id="label-name" value="<?php echo (user_type() == 'seeker')?$user['seeker_phone']:$user['provider_phone']; ?>" maxlength="11" placeholder="Ex. 09998765432" required>
								</div>
							<?php
							}
							?>
							<button class="btn btn-link-absolute higher-top" type="submit" name="btnsave">Save</button>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
