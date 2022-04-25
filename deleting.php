<?php
	include("others/functions.php");

	## DELETE IN DATABASE
	if(isset($_GET['table']) && isset($_GET['attr']) && isset($_GET['data'])) {
		if($_GET['table'] == "funeral" || $_GET['table'] == "headstone" || $_GET['table'] == "church"){
			## DELETE IN FUNERAL TABLE
			delete($_GET['table'], $_GET['attr'], $_GET['data']);
			## 
			$service = read("services", ["service_id"], [$_GET['data']]);
			$service = $service[0];
			## DELETE THE IMAGE FILE
			$path = "images/providers/".$service['service_type']."/".$_SESSION['provider']."/".$service["service_img"];
			if(!unlink($path)) echo "<script>alert('An error occurred in deleting image!')</script>";
			## DELETE IN SERVICES
			delete("services", $_GET['attr'], $_GET['data']);
		}
		else {
			delete($_GET['table'], $_GET['attr'], $_GET['data']);
		}
		
	}

	if(isset($_GET['url']) && isset($_GET['update'])){
		header("Location: ".$_GET['url'].".php?updated");
	}
	else if(isset($_GET['url'])){
		header("Location: ".$_GET['url'].".php?deleted");
	}
	else {
		header("Location: cart.php?cart_deleted");
	}