<!-- HEAD AREA -->
<?php include("others/head.php"); ?>

<body>
	<div class="container">
		<!-- HEADER AREA -->
		<?php include("others/header.php"); ?>
		
		<!-- BANNER AREA -->
		<div class="banner">

			<!-- SIDEBAR AREA -->
			<?php 
			$this_page = "transact";
			include("others/sidebar.php"); ?>

			<!-- BANNER CONTENT -->
			<section class="banner-con">
				<div class="wrapper">
					<div class="banner-div">
						<h2>Transactions</h2>

						<!-- TABS -->
						<?php
						$current_tab = "transact";
						$this_tab = "cart";
						include("others/tabs.php");?>

						
						<div class="my-cart">
							<div class="my-cart-con">
								<img src="images/candles.jpg" alt="">
								<h3>
									Title sa product
									<span>₱ 120,000.00 <q>Qty: <input type="text"></q></span>
								</h3>
							</div>
							<div class="my-cart-qty"><i class="fa-solid fa-trash-can"></i></div>
						</div>
						
						<div class="my-cart">
							<div class="my-cart-con">
								<img src="images/candles.jpg" alt="">
								<h3>
									Flowers
									<span>₱ 120,000.00 <q>Qty: <input type="text"></q></span>
								</h3>
							</div>
							<div class="my-cart-qty"><i class="fa-solid fa-trash-can"></i></div>
						</div>
						
						<div class="my-cart">
							<div class="my-cart-con">
								<img src="images/candles.jpg" alt="">
								<h3>
									Mr. Crabs Catering
									<span>₱ 120.00 <q>Qty: <input type="text"></q></span>
								</h3>
							</div>
							<div class="my-cart-qty"><i class="fa-solid fa-trash-can"></i></div>
						</div>
						<div class="hr full-width"></div>
						<div class="my-cart-con">
							<img class="none" src="">
							<div class="my-cart-total">
								<div class="total-sub">
									<p>Transaction fee:</p>
									<h3>₱ 300.00</h3>
								</div>
								<div class="total-sub">
									<p>Total:</p>
									<h3>₱ 333,300.00</h3>
								</div>
								<form action="">
									<div>
										<input class="radio-terms" type="radio" required>
										<p>By checking this you agree to our <a href="">terms and conditions</a>.</p>
									</div>
									<button class="btn">Checkout</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
