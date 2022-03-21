<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$user = current_user();

	if(isset($_POST['btnupdate'])){
		change_password("seeker", $user["seeker_email"], $user["seeker_pass"]);
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
						<h2><a href="profile.php">Profile</a> <span>> Change Password</span></h2>
						<form class="profile column" method="post">
							<button class="btn-new" type="submit" name="btnupdate">Update</button>
							<div>
								<label for="label-name">Current Password</label>
								<input type="password" name="pw_cpass" id="label-name" required>
							</div>
							<div>
								<label for="label-name">New Password</label>
								<input type="password" name="pw_npass" id="label-name" required>
							</div>
							<div>
								<label for="label-name">Retype New Password</label>
								<input type="password" name="pw_rpass" id="label-name" required>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
