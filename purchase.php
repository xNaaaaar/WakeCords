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
						$this_tab = "purchase";
						include("others/tabs.php");?>
						
						<div class="banner-ratings purchases-lists">
							<div class="list">
								<div></div>
								<div>Status</div>
								<div>Requests</div>
							</div>
							<div class="list">
								<div>
									<h3>Name sa nag rate
										<span>
											<!-- DATE -->
											Purchased on: 02/22/2022
										</span>
									</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit...</p>
								</div>
								<div>
									<span>canceled</span>
								</div>
								<div>
									<button class="status">refund</button>
									<button class="status">cancel</button>
								</div>
							</div>
							<div class="list">
								<div>
									<h3>Name sa nag rate
										<span>
											<!-- DATE -->
											Purchased on: 02/22/2022
										</span>
									</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit...</p>
								</div>
								<div></div>
								<div></div>
							</div>
							<div class="list">
								<div>
									<h3>Name sa nag rate
										<span>
											<!-- DATE -->
											Purchased on: 02/22/2022
										</span>
									</h3>
									<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit...</p>
								</div>
								<div></div>
								<div></div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html>
