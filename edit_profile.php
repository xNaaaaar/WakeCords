<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$user = current_user();

	if(isset($_POST['btnsave'])){
		update_profile("seeker", $user["seeker_email"]);
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
						<form class="profile" method="post">
							<button class="btn-new" type="submit" name="btnsave">Save</button>
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
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
