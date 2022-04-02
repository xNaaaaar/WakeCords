<?php
	include("others/functions.php");

	## DELETE IN DATABASE
	if(isset($_GET['table']) && isset($_GET['attr']) && isset($_GET['data'])) 
		delete($_GET['table'], $_GET['attr'], $_GET['data']);

	if(isset($_GET['url'])){
		header("Location: ".$_GET['url'].".php?deleted");
	}
	else {
		header("Location: cart.php?cart_deleted");
	}