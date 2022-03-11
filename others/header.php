<div class="header">
	<button class="header-btn" data-menu-icon>
		<i class="fa-solid fa-bars"></i>
	</button>
	<picture>
		<?php
			if(isset($_SESSION['seeker'])){
		?>
			<div>
				<a href="cart.php">
					<i class="fa-solid fa-cart-shopping"></i>
					<?php
						echo "
						<span>".count(read('cart', ['seeker_id'], [$_SESSION['seeker']]))."</span>
						";
					?>
				</a>
			</div>
		<?php
			}
		?>
		<img class="header-logo" src="images/main-logo.png" alt="">	
		<div>Wakecords</div>
	</picture>	
</div>