<!-- HEAD AREA -->
<?php 
	include("others/functions.php");
	include("others/head.php"); 

	$user = current_user();

	if(isset($_POST['btnupdate'])){
		upload_required("seeker", $user['seeker_id']);
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
						<h2><a href="profile.php">Profile</a> <span>> Requirements</span></h2>
						<form enctype="multipart/form-data" class="profile column" method="post">
							<button class="btn-new" type="submit" name="btnupdate">Upload</button>
							<div>
								<label for="label-name">Upload An Image</label>
								<input type="file" name="file_req" id="label-name" required>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
