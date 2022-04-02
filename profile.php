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
								if(user_type() == "seeker")
									echo "<div class='note red'><i class='fa-solid fa-circle-exclamation'></i> Note: Please upload a clear copy of death certificate to proceed.</div>";
								else 
									echo "<div class='note red'><i class='fa-solid fa-circle-exclamation'></i> Note: Please upload a clear copy of business permit to proceed.</div>";
								echo "
								<a class='btn btn-link-absolute no-top' href='required.php'>Upload Requirement</a>
								"; 
							}
							## IF UPLOADED REQUIREMENT
							if($status != ""){
								if(user_type() == "seeker")
									$image_name = read("requirement", ["seeker_id"], [$user['seeker_id']]);
								else
									$image_name = read("requirement", ["provider_id"], [$user['provider_id']]);
								
								$image_name = $image_name[0];

								if($status == "pending")
									echo "<div class='note blue'><i class='fa-solid fa-circle-info'></i> Note: Please wait for admin's verification.</div>";

								echo "
								
								<figure>
									<figcaption>Click to view <mark id='open-img'>".$image_name['req_type']."</mark>.</figcaption>	
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
					?>
				</div>
			</section>
		</div>
	</div>
	<script>
		let img = document.querySelector('#modal-img');
		let open = document.querySelector('#open-img');
		let close = document.querySelector('#close-img');

		open.addEventListener('click', () => {
			img.showModal();
		})

		close.addEventListener('click', () => {
			img.close();
		})
	</script>
</body>
</html>
