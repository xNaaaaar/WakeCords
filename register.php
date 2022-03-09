<!-- HEAD AREA -->
<?php 
	include("others/head.php"); 
	include("others/functions.php");

	if(isset($_POST['btnreg'])){
		createUser($_POST['cbouser']);
	}

?>

<body>
	<div class="form">
		<!-- REGISTER AREA -->
		<div class="form-img">
			<img src="images/banner-img.jpg" alt="">
		</div>
		
		<div class="form-con">
			<div class="form-logo">
				<img src="images/main-logo.png">
			</div>
			<form method="post">
				<input type="text" name="txtfn" placeholder="First Name" required>
				<input type="text" name="txtln" placeholder="Last Name" required>
				<select name="cbouser" onchange="is_orga(this);" required>
					<option value="">Select Option</option>
					<option value="seek">Seeker</option>
					<option value="orga">Organizer</option>
				</select>
				<select name="cboorga" id="for_orga">
					<option value="">Select Organizer Option</option>
					<option value="funeral">Funeral Homes</option>
					<option value="church">Church</option>
					<option value="candle">Candle Maker</option>
					<option value="headstone">Headstone Maker</option>
					<option value="flower">Flower Shop</option>
					<option value="food_cater">Food Catering</option>
				</select>
				<input type="email" name="emea" placeholder="Email Address" required>
				<input type="password" name="passpw" placeholder="Password" required>
				<p>
					Back to login? Click <a href="index.php">here</a>.
				</p>
				<button class="btn" type="submit" name="btnreg">Register</button>
			</form>
		</div>
	</div>

	<!-- FOOTER JS -->
	<?php include("others/footer-js.php"); ?>
</body>
</html>
