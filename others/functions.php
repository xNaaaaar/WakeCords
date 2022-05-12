<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	date_default_timezone_set('Asia/Manila');
	require_once("others/db.php");
	## require_once('vendor/autoload.php');

	ob_start();
	
	## ARRAY ID OF QUERY
	function id_array_of_query($table){
		$ids_array = array();
		$ids = read($table);
		
		switch($table) {
			case "purchase":
				foreach($ids as $id) {
					array_push($ids_array, $id["purchase_id"]);
				}
			break;
		}

		return $ids_array;
	}
	## UPDATE PASSWORD
	function change_password($user, $email, $password){
		$pw_cpass = trim(md5($_POST['pw_cpass']));
		$pw_npass = trim(md5($_POST['pw_npass']));
		$pw_rpass = trim(md5($_POST['pw_rpass']));
		
		if($pw_cpass != $password){
			echo "<script>alert('Current password do not match!')</script>";
		}
		else if($pw_npass != $pw_rpass){
			echo "<script>alert('New password must match retype password!')</script>";
		}
		else {
			$data_list = [];

			switch ($user){
				case "seeker":
					$attr_list = ["seeker_pass"];
					$condition = "seeker_email";
					break;
					
				case "provider":
					$attr_list = ["provider_pass"];
					$condition = "provider_email";
					break;

				case "admin":
					$attr_list = ["admin_pass"];
					$condition = "admin_email";
					break;
			}
			array_push($data_list, $pw_npass, $email);
			update($user, $attr_list, $data_list, $condition);

			header('Location: profile.php?updated');
			exit;
		}
	}
	##
	function check_having_enough_qty($service_id, $qty){
		$total_qty = $qty;
		## CHECK CART QTY OF SPECIFIC SERVICE BOOKED
		$cart_services = read("cart", ["service_id"], [$service_id]);

		$services = read("services", ["service_id"], [$service_id]);
		$services = $services[0];
		##
		if(count($cart_services) > 0){
			foreach($cart_services as $cart_service){
				if(!empty($cart_service['cart_qty'])){
					$total_qty += $cart_service['cart_qty'];
				}
			}
		}
		if($services['service_qty'] - $total_qty < 0) return false;
		return true; 
	}
	## CREATE FUNCTION
	function create($table, $attr_list, $qmark_list, $data_list){
		## INSERT INTO seeker(seeker_fname, seeker_mi, seeker_lname) VALUES(?,?,?)
		DB::query("INSERT INTO ".$table."(".join(", ",$attr_list).") VALUES(".join(", ",$qmark_list).")", $data_list, "CREATE");
	}	
	## CREATE USER SEEKER OR PROVIDER
	function createUser($user){
		$txtfn = trim(ucwords($_POST['txtfn']));
		$txtln = trim(ucwords($_POST['txtln']));
		$emea = trim($_POST['emea']);
		$passpw = md5($_POST['passpw']);

		$check_seeker_email = read("seeker", ["seeker_email"], [$emea]);
		$check_provider_email = read("provider", ["provider_email"], [$emea]);
		$check_admin_email = read("admin", ["admin_email"], [$emea]);

		## CHECK IF EMAIL ALREADY EXIST
		if(count($check_seeker_email)>0 || count($check_provider_email)>0 || count($check_admin_email)>0){
			echo "<script>alert('Email address already exists!')</script>";
		}
		else {
			if(preg_match('/\d/', $txtfn)){
				echo "<script>alert('Firstname cannot have a number!')</script>";
			}
			else if(preg_match('/\d/', $txtln)){
				echo "<script>alert('Lastname cannot have a number!')</script>";
			}
			else {
				$table = "";
				$data_list = [];

				switch ($user){
					case "seek":
						$table = "seeker";
						$attr_list = ["seeker_fname", "seeker_lname", "seeker_status", "seeker_email", "seeker_pass"];
						array_push($data_list, $txtfn, $txtln, "inactive", $emea, $passpw);

						create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);

						## GET THE SEEKER ID
						$userid = read("seeker", ["seeker_email"], [$emea]);

						## CHECK EXISTING EMAIL
						if(count($userid)>0){
							$userid = $userid[0];
							$ratePathImages = 'images/seekers/'.$userid['seeker_id'];
							## CREATE A FOLDER FOR UPLOADING DEATH CERT
							if(!file_exists($ratePathImages)) mkdir($ratePathImages,0777,true);
						}

						break;

					case "orga":
						$cboorga = $_POST['cboorga'];
						$table = "provider";
						$attr_list = ["provider_fname", "provider_lname", "provider_type", "provider_email", "provider_pass"];
						array_push($data_list, $txtfn, $txtln, $cboorga, $emea, $passpw);

						create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);

						## GET THE PROVIDER ID
						$userid = read("provider", ["provider_email"], [$emea]);

						## CHECK EXISTING EMAIL
						if(count($userid)>0){
							$userid = $userid[0];
							$ratePathImages = 'images/providers/'.$userid['provider_type'].'/'.$userid['provider_id'];
							## CREATE A FOLDER FOR UPLOADING DEATH CERT
							if(!file_exists($ratePathImages)) mkdir($ratePathImages,0777,true);
						}

						break;
					
					case "admin":
						$txtmi = ucwords($_POST['txtmi']);
						$table = "admin";
						$attr_list = ['admin_fname', 'admin_mi', 'admin_lname', 'admin_email', 'admin_pass'];
						array_push($data_list, $txtfn, $txtmi, $txtln, $emea, $passpw);

						create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);

						## GET THE PROVIDER ID
						$userid = read("admin", ["admin_email"], [$emea]);

						## CHECK EXISTING EMAIL
						if(count($userid)>0){
							$userid = $userid[0];
							$ratePathImages = 'images/admins/payout/';
							## CREATE A FOLDER FOR UPLOADING DEATH CERT
							if(!file_exists($ratePathImages)) mkdir($ratePathImages,0777,true);
						}
						break;
				}

				## SUCCESSFUL MESSAGE
				if($user == "admin")
					echo "<script>alert('Admin new account successfully created!')</script>";
				else
					header("Location: index.php?success");
			}
		}	
	}
	## USER LOGIN ID
	function current_user(){
		if(isset($_SESSION['seeker'])){
			$user = read("seeker", ["seeker_id"], [$_SESSION['seeker']]);
		}
		else if(isset($_SESSION['provider'])){
			$user = read("provider", ["provider_id"], [$_SESSION['provider']]);
		}
		else {
			$user = read("admin", ["admin_id"], [$_SESSION['admin']]);	
		}

		return $user[0];
	}
	## DELETE FUNCTION
	function delete($table, $attr, $data){
		## DELETE FROM {table} WHERE {attr} = {data}
		return DB::query("DELETE FROM ".$table." WHERE ".$attr."=?", array($data), "DELETE");
	}
	## DISPLAY STARS
	function display_stars($stars){
		$text = "";
		while($stars > 0){
			$text .= "<i class='fa-solid fa-star stars'></i>";
			$stars--;
		}
		return $text;
	}
	## CREATING EWALLET SOURCE
	function ewallet_create_source($method, $amount){
		$client = new \GuzzleHttp\Client();

		$response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
		'body' => '{
			"data":
			{
				"attributes":
				{
					"amount":'.$amount.',
					"redirect":
					{
						"success":"http://localhost:8080/Capstone/WakeCords/thanks.php?success",
						"failed":"http://localhost:8080/Capstone/WakeCords/thanks.php?failed"},
						"type":"'.$method.'",
						"currency":"PHP"
					}
				}
			}',
		'headers' => [
			'Accept' => 'application/json',
			'Authorization' => 'Basic cGtfdGVzdF93RlNlWFZUZ2R5NXZ0NGVUdFJ3U1g3YVg6c2tfdGVzdF9MMm1ManEzcFQxVGltTnNnamgzZzFoREw=',
			'Content-Type' => 'application/json',
		],
		]);

		// echo $response->getBody();
		$json_object = json_decode($response);
		$redirect_url = $json_object->data->attributes->redirect->checkout_url;
		$_SESSION['source_id'] = $json_object->data->id;
		##
		header("Location: ".$redirect_url);
	}
	## GETTING EWALLET SOURCE
	function ewallet_source($method, $amount){
		$curl = curl_init();

		curl_setopt_array($curl, [
		CURLOPT_URL => 'https://api.paymongo.com/v1/sources',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => "{
			\"data\":
			{
				\"attributes\":
				{
					\"amount\":".$amount.",
					\"redirect\":
					{
						\"success\":\"http://localhost/WakeCords/thanks.php?success\",
						\"failed\":\"http://localhost/WakeCords/thanks.php?failed\"},
						\"type\":\"".$method."\",
						\"currency\":\"PHP\"
					}
				}
			}",
		CURLOPT_HTTPHEADER => [
			"Accept: application/json",
			"Authorization: Basic cGtfdGVzdF93RlNlWFZUZ2R5NXZ0NGVUdFJ3U1g3YVg6",
			"Content-Type: application/json"
		],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
			$json_object = json_decode($response);
			$redirect_url = $json_object->data->attributes->redirect->checkout_url;
			$_SESSION['source_id'] = $json_object->data->id;
			##
			header("Location: ".$redirect_url);
			// echo $response;
		}
	}
	## SUBSCRIBED PROVIDER
	function is_subscribed(){
		$provider = read("subscription", ["provider_id"], [$_SESSION['provider']]);
		if(count($provider) > 0){
			$provider = $provider[0];

			if(date("Y-m-d") <= $provider['subs_description'])
				return true;
		}
		return false;
	}
	## GET THE LAST ID INSERT IN SQL
	function last_created_id($table, $ids_array){
		$id = "";
		$rows = read($table);

		switch($table){
			case "purchase":
				foreach($rows as $row){
					if(!in_array($row['purchase_id'], $ids_array)){
						$id = $row['purchase_id'];
						break;
					}
				}
			break;
		}

		return $id;
	}
	## LIMIT DISPLAY TEXT
	function limit_text($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos   = array_keys($words);
			$text  = substr($text, 0, $pos[$limit]) . '...';
		}
		return $text;
	}
	## LOGIN USER
	function loginUser(){
		$emuser = trim($_POST['emuser']);
		$passpw = trim(md5($_POST['passpw']));

		$seeker_acc = read("seeker", ["seeker_email", "seeker_pass"], [$emuser, $passpw]);
		$provider_acc = read("provider", ["provider_email", "provider_pass"], [$emuser, $passpw]);
		$admin_acc = read("admin", ["admin_email", "admin_pass"], [$emuser, $passpw]);

		## SEEKER ACCOUNT
		if(count($seeker_acc)>0){
			$seeker = $seeker_acc[0];
			$_SESSION['seeker'] = $seeker['seeker_id'];

			header('Location: profile.php?login');
			exit;
		}
		## PROVIDER ACCOUNT
		else if(count($provider_acc)>0){
			$provider_acc = $provider_acc[0];
			$_SESSION['provider'] = $provider_acc['provider_id'];

			header('Location: profile.php?login');
			exit;
		}
		## ADMIN ACCOUNT
		else if(count($admin_acc)>0){
			$admin_acc = $admin_acc[0];
			$_SESSION['admin'] = $admin_acc['admin_id'];

			header('Location: profile.php?login');
			exit;
		}
		else echo "<script>alert('Email address or password is incorrect!')</script>";
	}
	## TYPE [notify, success, error]
	function messaging($type, $msg){
		switch($type){
			case "notify":
				echo "<div class='note blue'><i class='fa-solid fa-circle-info'></i> ".$msg."</div>";
			break;
			##
			case "success":
				echo "<div class='note green'><i class='fa-solid fa-circle-check'></i> ".$msg."</div>";
			break;
			##
			case "error":
				echo "<div class='note red'><i class='fa-solid fa-circle-xmark'></i> ".$msg."</div>";
			break;
		}
	}
	## DISPLAY CART
	function my_cart(){
		$all_cart = DB::query("SELECT * FROM cart a JOIN services b ON a.service_id = b.service_id WHERE seeker_id=?", array($_SESSION['seeker']), "READ");

		if(count($all_cart) > 0){
			$i = 0;
			foreach($all_cart as $results){
				$cart = DB::query("SELECT * FROM services s JOIN cart c ON s.service_id=c.service_id JOIN seeker skr ON skr.seeker_id=c.seeker_id JOIN {$results['service_type']} f ON f.service_id=s.service_id WHERE c.cart_id=?", array($results['cart_id']), "READ");
				$cart = $cart[0];
				##
				switch($results['service_type']){
					## FOR FUNERAL
					case "funeral":
						$total_cost = $cart['service_cost'] * $cart['cart_qty'];
						echo "
						<div class='my-cart'>
							<figure>
								<img src='images/providers/".$cart['service_type']."/".$cart['provider_id']."/".$cart['service_img']."' alt=''>
							</figure>
							<div class='my-cart-details'>
								<div class='my-cart-title'>
									<h3>".$cart['funeral_name']."
										<span>".$cart['cart_size']."</span>
									</h3>
									<p>".limit_text($cart['service_desc'], 10)."</p>
								</div>
								<span class='qty'>x".$cart['cart_qty']."</span>
								<h3>₱ ".number_format($total_cost,2,'.',',')."</h3>
							</div>
							<div class='my-cart-qty'><a href='deleting.php?table=cart&attr=cart_id&data=".$cart['cart_id']."' onclick=\"return confirm('Are you sure you want to delete this to cart?');\"><i class='fa-solid fa-trash-can'></i></a></div>
						</div>
						";
						$i++;
					break;
					## FOR CHURCH
					case "church":
						echo "
						<div class='my-cart'>
							<figure>
								<img src='images/providers/".$cart['service_type']."/".$cart['provider_id']."/".$cart['service_img']."' alt=''>
							</figure>
							<div class='my-cart-details'>
								<div class='my-cart-title'>
									<h3>".$cart['church_church']."</h3>
									<p>".limit_text($cart['service_desc'], 10)."</p>
								</div>
								<div>
									<p>Scheduled time:</p>
									<p style='color:#aaa;'>{$cart['cart_sched_time']}</p>
								</div>
							</div>
							<div class='my-cart-qty'><a href='deleting.php?table=cart&attr=cart_id&data=".$cart['cart_id']."' onclick=\"return confirm('Are you sure you want to delete this to cart?');\"><i class='fa-solid fa-trash-can'></i></a></div>
						</div>
						";
						$i++;
					break;
					## FOR HEADSTONE
					case "headstone":
						$total_cost = $cart['service_cost'] * $cart['cart_qty'];
						echo "
						<div class='my-cart'>
							<figure>
								<img src='images/providers/".$cart['service_type']."/".$cart['provider_id']."/".$cart['service_img']."' alt=''>
							</figure>
							<div class='my-cart-details'>
								<div class='my-cart-title'>
									<h3>".ucwords($cart['stone_color'])." ".ucwords($cart['stone_kind'])." ".ucwords($cart['stone_type'])."
										<span>(".$cart['cart_font'].")</span> <span>".$cart['cart_size']."</span>
									</h3>
									<p>".limit_text($cart['service_desc'], 10)."</p>
								</div>
								<span class='qty'>x".$cart['cart_qty']."</span>
								<h3>₱ ".number_format($total_cost,2,'.',',')."</h3>
							</div>
							<div class='my-cart-qty'><a href='deleting.php?table=cart&attr=cart_id&data=".$cart['cart_id']."' onclick=\"return confirm('Are you sure you want to delete this to cart?');\"><i class='fa-solid fa-trash-can'></i></a></div>
						</div>
						";
						$i++;
					break;
					## FOR HEADSTONE
					case "headstone":
					break;
					## FOR HEADSTONE
					case "headstone":
					break;
					## FOR HEADSTONE
					case "headstone":
					break;

				}
			}

			echo "
			<a style='display:block;width:95%;text-align:right;margin-bottom:.5em;' href='funeral.php'>Browse More Services &#187; </a>
			<div class='hr full-width'></div>
			<form method='post'>
				<div class='my-cart'>
					<div class='my-cart-form'>
						<div class='total-sub terms'>
							<input class='radio-terms' type='checkbox' name='radio' required>
							<p>By checking this you agree to our <a href=''>terms and conditions</a>.</p>
						</div>
						<button type='submit' name='btncheckout' class='btn' onclick='return confirm(\"Confirm checkout?\");'>Checkout</button>
					</div>
				</div>
			</form>
			";

			if(isset($_POST['btncheckout'])){
				$table = "purchase";
				$attr_list = ["seeker_id", "service_id", "purchase_total", "purchase_qty", "purchase_size", "purchase_date", "purchase_sched_time", "purchase_status", "purchase_progress"];
				$cart_table = read("cart", ["seeker_id"], [$_SESSION['seeker']]);
				$checker = false;
				
				foreach($cart_table as $results){
					$service_ = read("services", ["service_id"], [$results["service_id"]]);
					$service_ = $service_[0];

					switch($service_['service_type']){
						##
						case "funeral":
							$per_cost = $service_["service_cost"] * $results['cart_qty'];

							$data_list = [$results['seeker_id'], $results['service_id'], $per_cost, $results['cart_qty'], $results['cart_size'], date('Y-m-d'), NULL, "to pay", 0];
						break;
						##
						case "church":
							$checker = true;
							$data_list = [$results['seeker_id'], $results['service_id'], NULL, NULL, NULL, date('Y-m-d'), $results['cart_sched_time'], "scheduled", 0];
						break;
						##
						case "headstone":
							$per_cost = $service_["service_cost"] * $results['cart_qty'];
							array_push($attr_list, "purchase_font");

							$data_list = [$results['seeker_id'], $results['service_id'], $per_cost, $results['cart_qty'], $results['cart_size'], date('Y-m-d'), NULL, "to pay", 0, $results['cart_font']];
						break;
					}
					## GET ALL IDS BEFORE CREATING
					$ids_array = id_array_of_query($table);
					## CREATE PURCHASE
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);

					## ADD TO DETAILS FOR CHURCH
					if($service_['service_type'] == "church") {
						## GET THE LAST CREATED ID
						$purchase_id = last_created_id($table, $ids_array);
						##
						$attr_list = ["purchase_id"];
						create("details", $attr_list, qmark_generator(count($attr_list)), [$purchase_id]);
					}
				}
				## DELETE ALL DATA IN CART
				delete("cart", "seeker_id", $_SESSION['seeker']);

				($checker) ? header("Location: purchase.php") : header("Location: payment.php");
				exit;
			}
		}
		else {
			echo messaging("error", "Your cart is empty! <a href='funeral.php'>Click here to add to cart!");
		}
	}
	## NOT SUBSCRIBED OR EXPIRED
	function not_subs($msg){
		echo "
		<figure>
			<figcaption>Click to <mark id='open-subs'>subscribe</mark></figcaption>	
		</figure>

		<dialog class='modal-img' id='modal-subs'>
			<button id='close-subs'>+</button>
			<div class='subscription'>
				<div class='month'>
					<h2>PH</h2>
					<h3>200 / month</h3>
					<p>".$msg."</p>
					<a href='payment_subs.php?monthly' class='btn'>Subscribe Now</a>
				</div>
				<div class='year'>
					<h2>PH</h2>
					<h3>2000 / year</h3>
					<mark>save 20%</mark>
					<p>".$msg."</p>
					<a href='payment_subs.php?yearly' class='btn'>Subscribe Now</a>
				</div>
			</div>
		</dialog>
		";
	}
	function password_generator(){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
   		##
		for ($i = 0; $i < 8; $i++) $randomString = $randomString . $characters[rand(0, $charactersLength - 1)];
		##
        return $randomString;
	}
	## NECESSARY UPDATE AFTER PAYING
	function pay_purchase($type_list, $purchase_list){
		## DECLARE DATA
		if(service_type_exist_bool("funeral", $type_list) || service_type_exist_bool("headstone", $type_list)){
			$cbomethod = $_SESSION['field_array'][0];
			$txtdeceasedname = $_SESSION['field_array'][1];
			## SESSIONS ARE LOCATED IN payment.php
			if(service_type_exist_bool("funeral", $type_list)){
				$dtburial = $_SESSION['field_array_funeral'][0];
				$txtburialadd = $_SESSION['field_array_funeral'][1];
			}
			## SESSIONS ARE LOCATED IN payment.php
			if(service_type_exist_bool("headstone", $type_list)){
				$datebirth = $_SESSION['field_array_headstone'][0];
				$datedeath = $_SESSION['field_array_headstone'][1];
				$datedeliveryheadstone = $_SESSION['field_array_headstone'][2];
				$txtmsg = $_SESSION['field_array_headstone'][3];
			}
			## SESSIONS ARE LOCATED IN payment.php
			if($cbomethod == "gcash") {
				$acc_name = $_SESSION['field_array'][2];
				$acc_num = $_SESSION['field_array'][3];
			}
			## ERROR TRAP
			if(preg_match('/\d/', $txtdeceasedname)){
				echo "<script>alert('Deceased name cannot have a number!')</script>";
			}
			else {
				## INSERT DATA INTO FUNERAL
				foreach($purchase_list as $results){
					$attr_list = ["purchase_id", "deceased_name"];
					$data_list = [$results['purchase_id'], $txtdeceasedname];
					## FOR FUNERAL
					if(service_type_exist_bool("funeral", $type_list)){
						array_push($attr_list, "burial_datetime", "burial_add");
						array_push($data_list, date("Y-m-d H:i:s", strtotime($dtburial)), $txtburialadd);
					}
					## FOR HEADSTONE
					if(service_type_exist_bool("headstone", $type_list)){
						array_push($attr_list, "birth_date", "death_date", "delivery_date", "message");
						array_push($data_list, $datebirth, $datedeath, $datedeliveryheadstone, $txtmsg);
					}
					##
					create("details", $attr_list, qmark_generator(count($attr_list)), $data_list);

					## PURCHASE STATUS 'to pay' TO 'paid'
					update("purchase", ["purchase_status"], ["paid", $results['purchase_id']], "purchase_id");

					## UPDATE SERVICE REMAINING QTY
					$service = read("services", ["service_id"], [$results['service_id']]);
					$service = $service[0];

					$update_qty = $service['service_qty'] - $results['purchase_qty'];
					update("services", ["service_qty"], [$update_qty, $results['service_id']], "service_id");

					## IF SERVICE QTY = 0, UPDATE SERVICE STATUS TO INACTIVE
					$service_ = read("services", ["service_id"], [$results['service_id']]);
					$service_ = $service_[0];

					if($service_['service_qty'] == 0){
						update("services", ["service_status"], ["inactive", $results['service_id']], "service_id");
					}

					## CREATE PAYMENT TABLE
					$attr_list = ["purchase_id", "payment_method", "account_name", "account_number", "payment_datetime"];
					$data_list = [$results['purchase_id'], $cbomethod, $acc_name, $acc_num, date("Y-m-d H:i:s")];

					create("payment", $attr_list, qmark_generator(count($attr_list)), $data_list);
				}		
			}			
		}
		if(service_type_exist_bool("candle", $type_list)){
			$datedeliverycandle = $_POST['datedeliverycandle'];
		}
		if(service_type_exist_bool("flower", $type_list)){
			$datedeliveryflower = $_POST['datedeliveryflower'];
			$txtribbonmsg = trim(ucwords($_POST['txtribbonmsg']));
		}
		if(service_type_exist_bool("catering", $type_list)){
			$dtdelivery = $_POST['dtdelivery'];
			$numpax = $_POST['numpax'];
		}
	}
	## CHECKS PURCHASE PROGRESS IF LIMIT
	function progress_limits($id){
		## LIMITATIONS
		$church = $candle = $headstone = $flower = $catering = 4;
		$funeral = 5;

		$purchase = DB::query("SELECT * FROM purchase a JOIN services b ON a.service_id = b.service_id WHERE purchase_id = ?", array($id), "READ");
		$purchase = $purchase[0];

		switch($purchase['service_type']){
			case "funeral":
				if($purchase['purchase_progress'] == $funeral) return true;
			break;

			case "church":
				if($purchase['purchase_progress'] == $church) return true;
			break;

			case "headstone":
				if($purchase['purchase_progress'] == $headstone) return true;
			break;

			case "candle":
				if($purchase['purchase_progress'] == $candle) return true;
			break;

			case "flower":
				if($purchase['purchase_progress'] == $flower) return true;
			break;

			case "catering":
				if($purchase['purchase_progress'] == $catering) return true;
			break;
		}

		return false;
	}
	## PROVIDER'S SERVICES
	function provider_services($type=''){
		$provider = provider();
		
		## DIFFER IN PROVIDER TYPE
		switch($provider['provider_type']){
			## FOR FUNERAL SERVICES
			case "funeral":
				$services = DB::query("SELECT * FROM services s JOIN funeral f ON s.service_id=f.service_id WHERE provider_id=? AND funeral_type=?", array($provider['provider_id'], $type), "READ");
			break;
			## FOR CHURCH SERVICES
			case "church":
				$services = DB::query("SELECT * FROM services s JOIN church f ON s.service_id=f.service_id WHERE provider_id=?", array($provider['provider_id']), "READ");
			break;
			## FOR HEADSTONE SERVICES
			case "headstone":
				$services = DB::query("SELECT * FROM services s JOIN headstone f ON s.service_id=f.service_id WHERE provider_id=?", array($provider['provider_id']), "READ");
			break;
		}
		
		## DIFFER IN PROVIDER TYPE
		switch($provider['provider_type']){
			## FOR FUNERAL
			case "funeral":
				##
				if(count($services) > 0){
					foreach($services as $results){
						echo "
						<div class='card-0 no-padding'>
							<a href='funeral_tradition_this.php?service_id=".$results['service_id']."&id={$results['provider_id']}'>
								<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
								<h3>".$results['funeral_name']."
									<span>
										".ratings($results['service_id'], true)."
										<i class='fa-solid fa-star'></i>
										(".ratings_count($results['service_id'], true).")
									</span>
								</h3>
								<p>
									".limit_text($results['service_desc'], 10)."
								</p>
								<div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>
							</a>
							<div class='buttons'>	
						"; 

						if(!service_is_booked($results['service_id'])){
							echo "
							<a href='services_add.php?id=".$results['service_id']."&book&edit' class=''><i class='fa-solid fa-pen-to-square'></i></a>
							<a href='deleting.php?table={$results['service_type']}&attr=service_id&data=".$results['service_id']."&url=services' onclick='return confirm(\"Are you sure you want to delete this service?\");'><i class='fa-solid fa-trash-can'></i></a>";
						}
						else {
							echo "<a href='services_add.php?id=".$results['service_id']."&edit' class=''><i class='fa-solid fa-pen-to-square'></i></a>";
						}

						echo "
							</div>
						</div>
						";
					}
				}
				else messaging("error", "No posted services yet!");
			break;
			## FOR CHURCH
			case "church":
				##
				if(count($services) > 0){
					foreach($services as $results){
						echo "
						<div class='card-0 no-padding'>
							<a href='funeral_tradition_this.php?service_id=".$results['service_id']."&id={$results['provider_id']}'>
								<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
								<h3>".$results['church_church']."
									<span class='gray-italic inline'>({$results['church_cemetery']})</span>
									<span>
										".ratings($results['service_id'], true)."
										<i class='fa-solid fa-star'></i>
										(".ratings_count($results['service_id'], true).")
									</span>
								</h3>
								<p>
									".limit_text($results['service_desc'], 10)."
								</p>
								<p>Priest: <b>{$results['church_priest']}</b></p>
							</a>
							<div class='buttons'>	
						"; 
						// <div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>

						if(service_is_booked($results['service_id'])){
							echo "<a href='services_add.php?id=".$results['service_id']."&edit' class=''><i class='fa-solid fa-pen-to-square'></i></a>";
						}
						else {
							echo "
							<a href='services_add.php?id=".$results['service_id']."&book=false&edit' class=''><i class='fa-solid fa-pen-to-square'></i></a>
							<a href='deleting.php?table={$results['service_type']}&attr=service_id&data=".$results['service_id']."&url=services' onclick='return confirm(\"Are you sure you want to delete this service?\");'><i class='fa-solid fa-trash-can'></i></a>";
						}

						echo "
							</div>
						</div>
						";
					}
				}
				else messaging("error", "No posted services yet!");
			break;
			## FOR HEADSTONE
			case "headstone":
				##
				if(count($services) > 0){
					foreach($services as $results){
						$_SESSION['headstone_name'] = ucwords($results['stone_color'])." ".ucwords($results['stone_kind'])." ".ucwords($results['stone_type'])." Headstone";
						echo "
						<div class='card-0 no-padding'>
							<a href='funeral_tradition_this.php?service_id=".$results['service_id']."&id={$results['provider_id']}'>
								<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
								<h3>".$_SESSION['headstone_name']."
									<span>
										".ratings($results['service_id'], true)."
										<i class='fa-solid fa-star'></i>
										(".ratings_count($results['service_id'], true).")
									</span>
								</h3>
								<p>
									".limit_text($results['service_desc'], 10)."
								</p>
								<div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>
							</a>
							<div class='buttons'>	
						"; 

						if(!service_is_booked($results['service_id'])){
							echo "
							<a href='services_add.php?id=".$results['service_id']."&book=false&edit'><i class='fa-solid fa-pen-to-square'></i></a>
							<a href='deleting.php?table={$results['service_type']}&attr=service_id&data=".$results['service_id']."&url=services' onclick='return confirm(\"Are you sure you want to delete this service?\");'><i class='fa-solid fa-trash-can'></i></a>";
						}
						else {
							echo "<a href='services_add.php?id=".$results['service_id']."&edit'><i class='fa-solid fa-pen-to-square'></i></a>";
						}

						echo "
							</div>
						</div>
						";
					}
				}
				else messaging("error", "No posted services yet!");
			break;
		}
	}
	## PROVIDER'S TYPE
	function provider($id=0){
		if($id == 0) 
			$type = read("provider", ["provider_id"], [$_SESSION['provider']]);
		else
			$type = read("provider", ["provider_id"], [$id]);
		
		return $type[0];
	}
	## LIST OF PURCHASE
	function purchase_list(){
		$is_church = false;
		if(isset($_SESSION['seeker']))
			$list = read("purchase", ["seeker_id"], [$_SESSION['seeker']]);
		else if(isset($_SESSION['provider'])){
			$list = DB::query("SELECT * FROM purchase a JOIN services b ON a.service_id = b.service_id WHERE provider_id = ?", array($_SESSION['provider']), "READ");
			
			$provider = provider();
			if($provider['provider_type'] == "church") $is_church = true;
		}
		else $list = read('purchase');
		
		if(count($list)>0){
			echo "
			<div class='list'>
				<div></div>
				"; 
				echo ($is_church) ? "<div>Time</div>":"";
				echo "
				<div>Status</div>
				<div>Requests</div>
			</div>
			";
			## DECLARATION FOR PAGINATION
			$result = 5;
			$total_results = count($list);
			$page_numbers = ceil($total_results / $result);

			## PAGINATION CURRENT PAGES
			if(!isset($_GET['page'])) $current_page = 1;
			else $current_page = $_GET['page'];
			##
			for($i=1; $i<=$page_numbers; $i++){
				if($current_page == $i){
					## 5 * 2 = 10
					$per_page = $result * $current_page;
					## 10 - 5 = 5
					$starting_point = $per_page - $result;
					##
					for($j=$starting_point; $j<$per_page; $j++){
						if(!empty($list[$j])){

				##
				$service_ = read("services", ["service_id"], [$list[$j]['service_id']]);
				$service_ = $service_[0];

				$differ_ = service_type($service_['service_type'], $service_['service_id']);
				$name = $differ_[1];

				if($service_['service_type'] == "headstone") {
					$headstone = read("headstone", ["service_id"], [$list[$j]['service_id']]);
					$headstone = $headstone[0];

					$name = $headstone["stone_color"]." ".$headstone["stone_kind"]." ".$headstone["stone_type"];
					$name = ucwords($name);
				} 
				
				echo "
				<div class='list'>
					<div>
						<h3>{$name} <mark class='btn status type'>".$service_['service_type']."</mark>
							<span>
								<!-- DATE -->
								on: ".date("F j, Y", strtotime($list[$j]['purchase_date']))."
							</span>
						</h3>
						<p>".limit_text($service_['service_desc'], 10)."</p>
					</div>";
					##  
					if($is_church) {
						echo "<div><span style='display:flex;align-items:center;justify-content:center;gap:0 5px;'>{$list[$j]['purchase_sched_time']}</span></div>";
					}
				echo "
					<div>
						<span style='display:flex;align-items:center;justify-content:center;gap:0 5px;'>"; 
						
						if($service_['service_type'] == "funeral" && $list[$j]['purchase_status'] != "to pay") {
							echo "<a style='color:var(--blue);font-size:18px;' href='' title='Covered by no cancellation policy.'><i class='fa-solid fa-circle-question'></i></a>";
						}

						if($service_['service_type'] == "church" && $list[$j]['purchase_status'] == "re-schedule") {
							echo "<a style='color:var(--blue);font-size:18px;' href='' title='Church provider changed time availability.'><i class='fa-solid fa-circle-question'></i></a>";
						}
						
				echo $list[$j]['purchase_status']; 
				##
				$payout = read("payout", ["purchase_id"], [$list[$j]['purchase_id']]);

				if(count($payout) == 1){
					$payout = $payout[0];

					if($payout['payout_image'] == NULL) {
						if(isset($_SESSION['provider'])){
							echo ", pending payout requests";
						}
					}
					else {
						if(!isset($_SESSION['seeker'])){
							echo ", uploaded proof";
						}
					}	
				}

				echo "	</span>
					</div>
					<div>
				";

				## ALL STATUS
				if($list[$j]['purchase_status'] == "paid" || $list[$j]['purchase_status'] == "done" || $list[$j]['purchase_status'] == "rated" || $list[$j]['purchase_status'] == "scheduled") {
					echo "<a href='status.php?purchaseid=".$list[$j]['purchase_id']."' class='status'>view</a>";
				}
					
				## STATUS IS TO PAY
				if($list[$j]['purchase_status'] == "to pay"){
					## FOR SEEKER
					if(isset($_SESSION['seeker'])){
						echo "<a href='payment.php?purchaseid=".$list[$j]['purchase_id']."' class='status' onclick='return confirm(\"Proceed to payment?\");'>pay</a>";
						echo "<a href='deleting.php?table=purchase&attr=purchase_id&data=".$list[$j]['purchase_id']."&url=purchase' class='status' onclick='return confirm(\"Confirm deletion?\");'>delete</a>";
					}
				}

				## STATUS IS DONE OR RATED
				if($list[$j]['purchase_status'] == "done" || $list[$j]['purchase_status'] == "rated"){
					## FOR SEEKER
					if(isset($_SESSION['seeker']) && $list[$j]['purchase_status'] == "done"){
						echo "<a href='funeral_tradition_this.php?service_id={$list[$j]['service_id']}&id={$service_['provider_id']}&p_id={$list[$j]['purchase_id']}&rate#ratings' class='status' onclick='return confirm(\"Are you sure you want to rate this purchase?\")'>rate now</a>";
					}

					if(isset($_SESSION['seeker']) && $list[$j]['purchase_status'] == "rated"){
						echo "<a href='funeral_tradition_this.php?service_id={$list[$j]['service_id']}&id={$service_['provider_id']}&rated#ratings' class='status'>view rate</a>";
					}

					## FOR PROVIDER
					if(isset($_SESSION['provider'])){
						$payout = read("payout", ["purchase_id"], [$list[$j]['purchase_id']]);

						if(count($payout) == 0){
							echo "<a href='payout.php?id={$list[$j]['purchase_id']}' class='status' onclick='return confirm(\"Confirm request payout?\")'>payout</a>";
						}
						else if(count($payout) == 1) {
							$payout = $payout[0];
							if($payout['payout_image'] != NULL) {
								echo "<a href='images/admins/payout/{$payout['payout_image']}' download='payment_proof_{$list[$j]['purchase_id']}' class='status'>download proof</a>";
							}
						}
					}

					## FOR ADMIN
					if(isset($_SESSION['admin'])){
						$payout = read("payout", ["purchase_id"], [$list[$j]['purchase_id']]);

						if(count($payout) == 1){
							$payout = $payout[0];

							if($payout['payout_image'] == NULL){
								echo "<a href='payout.php?id={$list[$j]['purchase_id']}' class='status'>upload proof</a>";
							}
						}	
					}
				}

				## STATUS IS SCHEDULED / RE-SCHEDULE - WHEN CHURCH UPDATE MASS TIME WHERE SEEKER BOOKED
				if(($list[$j]['purchase_status'] == "scheduled" || $list[$j]['purchase_status'] == "re-schedule") && $list[$j]['purchase_progress'] == 0 && isset($_SESSION['seeker'])){
					## RESCHED BUTTON
					echo "<mark class='status' id='open-resched' onclick='open_modal({$list[$j]['purchase_id']});'>resched</mark>";
					##
					$days_remaining = (strtotime(date($differ_['church_mass_date'])) - strtotime(date("Y-m-d"))) /60/60/24;
					## CAN CANCEL IF MORE THAN 3 DAYS REMAINING BEFORE SERVICE DATE
					if($days_remaining > 3) {
						echo "<a class='status' href='deleting.php?table=purchase&attr=purchase_id&data=".$list[$j]['purchase_id']."&url=purchase' onclick='return confirm(\"Confirm cancellation?\");'>cancel</a>";
					}
					##
					$time_available = time_available($differ_['church_mass_time'], $list[$j]['service_id']);

					echo "
					<dialog class='modal-img' id='modal-resched{$list[$j]['purchase_id']}'>
						<button id='close-resched{$list[$j]['purchase_id']}'>+</button>";
						## 
						if(empty($time_available)) {
							echo "<div class='note red' style='width:fit-content;'><i class='fa-solid fa-circle-info'></i> Fully booked pamisa's schedules.</div>";
						}
						else {
							echo "
							<h2>Reschedule Church Pamisa</h2>
							<div class='note blue'><i class='fa-solid fa-circle-info'></i> Note: You can only reschedule once.</div>
							<form method='post' style='text-align:left;margin-block:1.5em;'>
								<input type='hidden' name='numid' value='{$list[$j]['purchase_id']}'></input>
								<label>Time Available on ".date("M j, Y", strtotime($differ_['church_mass_date']))."</label>
								<select name='cbotime' required>
									<option value=''>BROWSE OPTIONS</option>
									{$time_available}
								</select>
								<button class='btn' type='submit' name='btnresched'>Reschedule</button>
							</form>";
						}
					echo "	
					</dialog>";
				}

				echo "
					</div>
				</div>
				";
						}
						else break;
					}
				}
				else continue;
			}	
			## PAGINATION
			echo "
			<div class='pagination'>
				<ul>";
					## FOR PREV PAGE
					$prev_page = $current_page - 1;
					if($prev_page >= 1) echo "<li><a href='?page={$prev_page}'><i class='fa-solid fa-angles-left'></i></a></li>";
					else echo "<li><a style='pointer-events:none;color:gray;'><i class='fa-solid fa-angles-left'></i></a></li>";

					## LOOP ALL PAGE NUMBERS
					for($i=1; $i<=$page_numbers; $i++){
						$is_active = "";
			
						if($i == $current_page) $is_active = "class='hovered'";
						else $is_active = "";
						##
						echo "<li><a {$is_active} href='?page={$i}'>{$i}</a></li>";
					}
					## FOR NEXT PAGE
					$next_page = $current_page + 1;
					if($next_page <= $page_numbers) echo "<li><a href='?page={$next_page}'><i class='fa-solid fa-angles-right'></i></a></li>";
					else echo "<li><a style='pointer-events:none;color:gray;'><i class='fa-solid fa-angles-right'></i></a></li>";
			echo "
				</ul>
			</div>";
		}
		else messaging("error", "You have no transactions yet!");
	}
	## PURCHASE PROGRESS
	function purchase_progress($status, $num){
		return ($status >= $num) ? 'done':'';
	}
	## GENERATE QUESTION MARK
	function qmark_generator($arr_length){
		$arr = [];
		while($arr_length > 0){
			array_push($arr, "?");
			$arr_length--;
		}

		return $arr;
	}
	## RATE A PURCHASE DONE
	function rate(){
		$star = $_POST['star'];
		$txtrev = trim($_POST['txtrev']);
		$date = date("Y-m-d");

		## CREATE A FEEDBACK
		$table = "feedback";
		$attr_list = ["seeker_id", "service_id", "feedback_star", "feedback_comments", "feedback_date"];
		$data_list = [$_SESSION['seeker'], $_GET['service_id'], $star, $txtrev, $date];

		create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
	
		## UPDATE PURCHASE STATUS
		$table1 = "purchase";
		$attr_list1 = ["purchase_status"];
		$data_list1 = ["rated", $_GET['p_id']];
		$condition = "purchase_id";

		update($table1, $attr_list1, $data_list1, $condition);

		header("Location: funeral_tradition_this.php?service_id={$_GET['service_id']}&id={$_GET['id']}&rated");
		exit;
	}
	## RATINGS TO A CERTAIN PURCHASE / WITH PROVIDER
	function ratings($id, $service = true){
		## 
		$avg_stars = 0;
		
		if($service)
			$feedback = read("feedback", ["service_id"], [$id]);
		else {
			$feedback = DB::query("SELECT * FROM feedback a JOIN services b ON a.service_id = b.service_id WHERE provider_id = ?", array($id), "READ");
		}

		##
		if(count($feedback) > 0){
			foreach($feedback as $result){
				$avg_stars += $result['feedback_star'];
			}
			$avg_stars /= count($feedback);
		}
		else return $avg_stars;

		return number_format((float)$avg_stars,1,".","");
	}
	## COUNT THE RATINGS OF EACH PURCHASE
	function ratings_count($id, $service = true){
		if($service)
			$feedback = read("feedback", ["service_id"], [$id]);
		else {
			$feedback = DB::query("SELECT * FROM feedback a JOIN services b ON a.service_id = b.service_id WHERE provider_id = ?", array($id), "READ");
		}

		return (count($feedback) > 1) ? count($feedback)." reviews" : count($feedback)." review";
	}
	## READ FUNCTION
	function read($table, $attr=[], $data=[]){
		## SELECT * FROM joiner WHERE joiner_email=?
		if(count($attr) == 1){
			return DB::query("SELECT * FROM ".$table." WHERE ".$attr[0]."=?", array($data[0]), "READ");
		}
		else if(count($attr) == 2) {
			return DB::query("SELECT * FROM ".$table." WHERE ".$attr[0]."=? and ".$attr[1]."=?", array($data[0], $data[1]), "READ");
		}
		else if(count($attr) == 3) {
			return DB::query("SELECT * FROM ".$table." WHERE ".$attr[0]."=? and ".$attr[1]."=? and ".$attr[2]."=?", array($data[0], $data[1], $data[2]), "READ");
		}
		else {
			return DB::query("SELECT * FROM ".$table, array(), "READ");
		}	
	}
	## BOOLEAN READ FUNCTION
	function read_bool($table, $attr, $data){
		## SELECT * FROM joiner WHERE joiner_email=?
		if(count(DB::query("SELECT * FROM ".$table." WHERE ".$attr[0]."=?", array($data[0]), "READ")) > 0){
			return true;
		}
		return false;	
	}
	## REQUEST PAYOUT
	function request($type){
		switch($type){
			case "payout":
				$cbomethod = $_POST['cbomethod'];
				$acc_name = trim(ucwords($_POST['acc-name']));
				$acc_num = trim($_POST['acc-num']);

				if(!is_numeric($acc_num)){
					echo "<script>alert('Invalid account number!')</script>";
				}
				else {
					##
					$table = "payout";
					$attr_list = ["purchase_id", "payout_method", "account_name", "account_number", "payout_datetime"];
					$data_list = [$_GET['id'], $cbomethod, $acc_name, $acc_num, date("Y-m-d H:i:s")];
					##
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
					
					## SEND EMAIL | PROVIDER
					$provider = read("provider", ["provider_id"], [$_SESSION['provider']]);
					$provider = $provider[0];
					## SEND EMAIL | SEND TO EMAIL
					$to = $provider['provider_email'];
					## SEND EMAIL | SUBJECT
					$subject = "Request Payout";
					## SEND EMAIL | MESSAGE
					$txt = "Hi {$provider['provider_fname']},\n\nPlease be advise that you must wait for admin to upload proof of payment for your request.\nThank you for choosing us!";
					$txt .= "\n\n\nBest regards,\nTeam Wakecords";

					mail($to, $subject, $txt);

					## REDIRECTING
					header("Location: purchase.php?requests");
					exit;
				}
			break;

			case "upload":
				$imageName = upload_image("file_img", "images/admins/payout/");
				## ERROR TRAPPINGS
				if($imageName === 1){
					echo "<script>alert('An error occurred in uploading your image!')</script>";
				}
				else if($imageName === 2){
					echo "<script>alert('File type is not allowed!')</script>";
				}
				else {
					##
					$table = "payout";
					$attr_list = ["payout_image"];
					$data_list = [$imageName, $_GET['id']];
					$condition = "purchase_id";
					##
					update($table, $attr_list, $data_list, $condition);
					
					## SEND EMAIL | PROVIDER
					$provider = DB::query("SELECT * FROM payout a JOIN purchase b ON a.purchase_id = b.purchase_id JOIN services c ON b.service_id = c.service_id JOIN provider d ON c.provider_id = d.provider_id WHERE a.purchase_id = ?", array($_GET['id']), "READ");
					$provider = $provider[0];
					## SEND EMAIL | SEND TO EMAIL
					$to = $provider['provider_email'];
					## SEND EMAIL | SUBJECT
					$subject = "Payout Proof of Payment";
					## SEND EMAIL | MESSAGE
					$txt = "Hi {$provider['provider_fname']},\n\nPlease be advise that admin has paid and uploaded proof of payment.\nThank you for your service!";
					$txt .= "\n\n\nBest regards,\nTeam Wakecords";

					mail($to, $subject, $txt);
					## REDIRECTING
					header("Location: purchase.php?uploaded");
					exit;
				}
			break;
		}
	}
	## RETURN SPECIFIC VALUE
	function return_value($table, $id, $attr, $value=""){
		## CHECK WHAT TABLE IN DATABASE
		switch($table){
			case "services":
				$service = read($table, ["service_id"], [$id]);
				$service = $service[0];

				$type = read($service['service_type'], ["service_id"], [$id]);
				$type = $type[0];
			break;
		}
		$naming = "";
		$list = [];
		##
		if($service['service_type'] == "funeral") {
			$naming = "funeral_size";
			$list = ["size #1", "size #2", "size #3", "size #4", "size #5", "size #6"];
		}
		else if($service['service_type'] == "headstone") {
			if($attr == "font" || $attr == "others") {
				$naming = "stone_font";
				$list = ["font #1", "font #2", "font #3", "font #4", "font #5", "font #6"];
			}
			else if($attr == "size" || $attr == "others1") {
				$naming = "stone_size";
				$list = ["size #1", "size #2", "size #3", "size #4", "size #5", "size #6"];
			}
		}
		##
		switch($attr){
			## FOR SERVICE NAME
			case "name":
				if($service['service_type'] == "funeral") return $type["funeral_name"];
				if($service['service_type'] == "church") return $type["church_church"];
			break;
			## FOR PRIEST NAME
			case "priest":
				if($service['service_type'] == "church") return $type["church_priest"];
			break;
			## FOR CEMETERY
			case "cemetery":
				if($service['service_type'] == "church") return $type["church_cemetery"];
			break;
			## FOR DATE
			case "date":
				if($service['service_type'] == "church") return $type["church_mass_date"];
			break;
			## FOR ADDRESS
			case "address":
				if($service['service_type'] == "church") return $type["church_address"];
			break;
			## FOR SOME TYPE
			case "type":
				if($service['service_type'] == "funeral") {
					if($type['funeral_type'] == $value) return "selected";
				}
				else if($service['service_type'] == "headstone") {
					if($type['stone_type'] == $value) return "selected";
				}
			break;
			## FOR SOME KIND
			case "kind":
				if($service['service_type'] == "headstone") {
					if($type['stone_kind'] == $value) return "selected";
				}
			break;
			## FOR SOME COLOR
			case "color":
				if($service['service_type'] == "headstone") {
					if($type['stone_color'] == $value) return "checked";
				}
			break;
			## FOR SOME SIZE
			case "size":
			case "font":
				if($naming != "" && $type[$naming] != NULL){
					$var = explode(",",$type[$naming]);
					##
					if(in_array($value, $var)) return "checked";
				}
			break; 
			## FOR SOME OTHERS
			case "others":
			case "others1":
				if($naming != "" && $type[$naming] != NULL){
					$array = explode(",",$type[$naming]);
					#
					for($i=0; $i<=count($array); $i++) {
						if(in_array($array[$i], $list))
							unset($array[$i]);
					}

					return implode(",",$array);
				}
			break;
			## FOR TIME
			case "time":
				return $type["church_mass_time"];
			break;
			## FOR PRICE / COST
			case "price":
				return number_format($service["service_cost"],0,"","");
			break; 
			## FOR QUANTITY
			case "qty":
				return $service["service_qty"];
			break;
			## FOR DESCRIPTION
			case "desc":
				return $service["service_desc"];
			break;
		}
		
		return "";
	}
	## CONVERT ARRAY INTO SELECT TAG
	function select_array($array, $type){
		echo "
		<div>
			<label>".ucwords($type).": </label>
			<select name='cbo{$type}' required>
				<option value=''>BROWSE OPTIONS</option>";
				for($i=0; $i<count($array)-1; $i++) 
					echo "<option value='".$array[$i]."'>".$array[$i]."</option>";
		echo "
			</select>
		</div>";
	}
	## DISPLAY FUNERAL SERVICES
	function services($type, $defer=NULL){
		// $services = read("services", ["service_type"], ["funeral"]);
		$services = "";

		switch ($type){
			## FUNERAL SERVICES
			case "funeral":
				## DISPLAY ALL
				if ($defer == NULL) {
					$provider = read("provider", ["provider_type"], [$type]);

					if(count($provider) > 0){
						foreach($provider as $result){
							echo "
							<div class='card-0 no-padding'>
								<img src='images/providers/".$result['provider_type']."/".$result['provider_id']."/".$result['provider_logo']."'>
								<h3>".$result['provider_company']."
									<span>
										".ratings($result['provider_id'], false)."
										<i class='fa-solid fa-star'></i>
										(".ratings_count($result['provider_id'], false).")
									</span>
								</h3>
								<p>
									".limit_text($result['provider_desc'], 10)."
								</p>
								<div class='buttons'>
									<a href='funeral_tradition.php?id=".$result['provider_id']."' title='View'><i class='fa-solid fa-eye'></i></a>
								</div>
							</div>
							";
						}
					}
					else messaging("error", "No funeral services posted!");
				}
				## DIFFERENTIATE BETWEEN FUNERAL TYPE 
				else {
					$services = DB::query("SELECT * FROM services s JOIN funeral f ON s.service_id = f.service_id WHERE provider_id = ? AND funeral_type = ?", array($_GET['id'], $defer), "READ");

					if(count($services) > 0){
						foreach($services as $results){
							## CHECK IF SERVICE QTY IS 0
							$qty_status = "";
							if($results['service_qty'] == 0) {
								$qty_status = "Out of Stock";
							}
							## FOR USERS
							echo "
							<div class='card-0 no-padding'>
								<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
								<h3>".$results['funeral_name']."
									<span>
										".ratings($results['service_id'], true)."
										<i class='fa-solid fa-star'></i>
										(".ratings_count($results['service_id'], true).")
									</span>
								</h3>
								<p>
									".limit_text($results['service_desc'], 10)."
								</p>
								<div style='color:red;text-align:center;'>{$qty_status}</div>
								<div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>
								<div class='buttons'>
									<a title='View' href='funeral_tradition_this.php?service_id=".$results['service_id']."&id={$results['provider_id']}'><i class='fa-solid fa-eye'></i></a>
								</div>
							</div>
							";
						}
					}
					else messaging("error", "No funeral services posted!");
				}
			break;

			## CHURCH SERVICES
			case "church":
				$services = DB::query("SELECT * FROM services s JOIN church f ON s.service_id=f.service_id", array(), "READ");

				if(count($services) > 0){
					foreach($services as $results){
						echo "
						<div class='card-0 no-padding'>
							
							<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
							<h3>".$results['church_church']."
								<span class='gray-italic inline'>({$results['church_cemetery']})</span>
								<span>
									".ratings($results['service_id'], true)."
									<i class='fa-solid fa-star'></i>
									(".ratings_count($results['service_id'], true).")
								</span>
							</h3>
							<p>
								".limit_text($results['service_desc'], 10)."
								<span class='gray-italic' style='display:block;'>on ".date("M j, Y", strtotime($results['church_mass_date']))."</span>
							</p>
							<p>Priest: <b>{$results['church_priest']}</b></p>
							<div class='buttons'>
								<a title='View' href='funeral_tradition_this.php?service_id=".$results['service_id']."&id={$results['provider_id']}'><i class='fa-solid fa-eye'></i></a>
								<a title='Donate' href='#'><i class='fa-solid fa-circle-dollar-to-slot'></i></a>
							</div>
						</div>
						";
					}
				}
				else messaging("error", "No church services posted!");
			break;

			## HEADSTONE SERVICES
			case "headstone":
				$services = DB::query("SELECT * FROM services a JOIN headstone b ON a.service_id = b.service_id", array(), "READ");

					if(count($services) > 0){
						foreach($services as $results){
							$_SESSION['headstone_name'] = ucwords($results['stone_color'])." ".ucwords($results['stone_kind'])." ".ucwords($results['stone_type'])." Headstone";
							## FOR USERS
							echo "
							<div class='card-0 no-padding'>
								<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
								<h3>{$_SESSION['headstone_name']}
									<span>
										".ratings($results['service_id'], true)."
										<i class='fa-solid fa-star'></i>
										(".ratings_count($results['service_id'], true).")
									</span>
								</h3>
								<p>
									".limit_text($results['service_desc'], 10)."
								</p>
								<div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>
								<div class='buttons'>
									<a title='View' href='funeral_tradition_this.php?service_id=".$results['service_id']."&id={$results['provider_id']}'><i class='fa-solid fa-eye'></i></a>
								</div>
							</div>
							";
						}
					}
					else messaging("error", "No headstone services posted!");
			break;

			## FLOWER SERVICES
			case "flower":
			break;

			## FOOD CATERING SERVICES
			case "food_cater":
			break;

			## CANDLE SERVICES
			case "candle":
			break;
		}	
	}
	## ADDING NEW SERVICE
	function service_adding(){
		## DECLARE VARIABLES
		$provider = provider();
		## 
		if($provider['provider_type'] != "headstone")
			$txtsname = trim(ucwords($_POST['txtsname']));
		##
		if($provider['provider_type'] != "church"){
			$txtothers = trim($_POST['txtothers']);
			$numprice = $_POST['numprice'];
		}	
		##
		if($provider['provider_type'] != "catering" && $provider['provider_type'] != "church")
			$numqty = $_POST['numqty'];
		##
		$txtdesc = trim($_POST['txtdesc']);
		$imageName = upload_image("file_img", "images/providers/".$provider['provider_type']."/".$_SESSION['provider']."/");
		## ERROR TRAPPINGS
		if($imageName === 1){
			echo "<script>alert('An error occurred in uploading your image!')</script>";
		}
		else if($imageName === 2){
			echo "<script>alert('File type is not allowed!')</script>";
		}
		else {
			$data_list = [];
			$table = "services";

			switch ($provider['provider_type']){
				case "funeral":
					$cbotype = $_POST['cbotype'];
					$cbsize = implode(",", $_POST['cbsize']);
					$cbsize .= ",".$txtothers;
					##
					$attr_list = ["provider_id", "service_type", "service_desc", "service_cost", "service_qty", "service_img", "service_status"];
					array_push($data_list, $provider['provider_id'], $provider['provider_type'], $txtdesc, $numprice, $numqty, $imageName, "active");
					## ADDED TO SERVICES
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
					$service = read("services", ["service_img"], [$imageName]);
					$service = $service[0];	
					## ADD TO SPECIFIC TYPE
					$attr_list = ["service_id", "funeral_name", "funeral_type", "funeral_size"];
					$data_list = [$service['service_id'], $txtsname, $cbotype, $cbsize];
					
				break;

				case "headstone":
					$cbotype = $_POST['cbotype'];
					$cbokind = $_POST['cbokind'];
					$cbcolor = $_POST['cbcolor'];
					$txtothers1 = trim($_POST['txtothers1']);
					$cbfont = implode(",", $_POST['cbfont']);
					$cbfont .= ",".$txtothers;
					$cbsize = implode(",", $_POST['cbsize']);
					$cbsize .= ",".$txtothers1;
					##
					$attr_list = ["provider_id", "service_type", "service_desc", "service_cost", "service_qty", "service_img", "service_status"];
					array_push($data_list, $provider['provider_id'], $provider['provider_type'], $txtdesc, $numprice, $numqty, $imageName, "active");
					## ADDED TO SERVICES
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
					$service = read("services", ["service_img"], [$imageName]);
					$service = $service[0];	
					## ADD TO SPECIFIC TYPE
					$attr_list = ["service_id", "stone_kind", "stone_type", "stone_color", "stone_size", "stone_font"];
					$data_list = [$service['service_id'], $cbokind, $cbotype, $cbcolor, $cbsize, $cbfont];
					
				break;

				case "church":
					$txtpriest = trim(ucwords($_POST['txtpriest']));
					$date = $_POST['date'];
					$txtcemetery = trim(ucwords($_POST['txtcemetery']));
					$txttime = trim($_POST['txttime']);
					## $cbtime = "10:00am - 11:00am, 11:00am - 12:00nn, 12:00nn - 01:00pm, 01:00pm - 02:00pm, 02:00pm - 03:00pm";
					$checked = false;
					##
					if(!isset($_POST['cbaddress'])) {
						$txtaddress = trim(ucwords($_POST['txtaddress']));
					}
					else $checked = true;
					##
					$attr_list = ["provider_id", "service_type", "service_desc", "service_img", "service_status"];
					array_push($data_list, $provider['provider_id'], $provider['provider_type'], $txtdesc, $imageName, "active");
					## ADDED TO SERVICES
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
					$service = read("services", ["service_img"], [$imageName]);
					$service = $service[0];	
					## ADD TO SPECIFIC TYPE
					$attr_list = ["service_id", "church_church", "church_cemetery", "church_priest", "church_mass_date", "church_mass_time", "church_address"];
					$data_list = [$service['service_id'], $txtsname, $txtcemetery, $txtpriest, $date, $txttime];
					##
					if($checked) array_push($data_list, $provider['provider_address']);
					else array_push($data_list, $txtaddress);
					
				break;

				case "church":

				break;
			}
			##
			create($provider['provider_type'], $attr_list, qmark_generator(count($attr_list)), $data_list);
			## 
			echo "<script>alert('Successfully added new service!')</script>";
		}
	}
	## EDITING SERVICE
	function service_editing($id){
		$services = read("services", ["service_id"], [$id]);
		$services = $services[0];
		## DECLARING
		$txtdesc = $_POST['txtdesc'];
		$attr_list = ["service_desc"];
		$data_list = [$txtdesc];
		##
		switch($services['service_type']){
			case "church":
				array_push($data_list, $id);
				## UPDATE SERVICE DESCRIPTION
				update("services", $attr_list, $data_list, "service_id");
				## REFRESH LIST
				$attr_list = [];
				$data_list = [];
				## READ CHURCH SERVICES
				$church = read("church", ["service_id"], [$id]);
				$church = $church[0];
				## 
				$txttime = trim($_POST['txttime']);
				array_push($attr_list, "church_mass_time");
				array_push($data_list, $txttime, $id);
				## UPDATE CHURCH SERVICE MASS TIME
				update("church", $attr_list, $data_list, "service_id");
				## UPDATE PURCHASE STATUS IF PURCHASE TIME DOES NOT EXIST IN CHURCH MASS TIME
				$mass_time = explode(",",$txttime);
				$purchases = read("purchase", ["service_id"], [$id]);

				if(count($purchases) > 0) {
					foreach($purchases as $purchase) {
						if(!in_array($purchase['purchase_sched_time'], $mass_time))
							update("purchase", ["purchase_status", "purchase_progress"], ["re-schedule", 0, $purchase['purchase_id']], "purchase_id");
					}
				}
				
			break;
			default:
				$numqty = $_POST['numqty'];
				array_push($attr_list, "service_qty");
				array_push($data_list, $numqty, $id);

				update("services", $attr_list, $data_list, "service_id");
			break;
		}
		
		
		header("Location: services.php?updated");
		exit;
	}
	## CHECK IF SPECIFIC SERVICE IS BOOKED
	function service_is_booked($service_id){
		$service = DB::query("SELECT * FROM services s JOIN purchase p ON s.service_id = p.service_id WHERE s.service_id=?", array($service_id), "READ");

		if(count($service) > 0)
			return true;
		return false;
	}
	## SERVICE TYPE
	function service_type($type, $service_id){
		$result = read($type, ["service_id"], [$service_id]);
		return $result[0];
	}
	## SERVICE TYPE EXISTS IN ARRAY BOOLEAN
	function service_type_exist_bool($type, $type_list){
		for($i=0;$i<count($type_list);$i++){
			if($type == $type_list[$i]) return true;
			continue;
		}
		return false;
	}
	## STATUS COLOR
	function status_color(){
		$status = user_status();

		if($status == "verified") return "green";
		elseif($status == "pending") return "blue";
		else return "red";
	}
	## DETERMINE IF THIS SUBSCRIPTION IS A MONTH OR YEAR
	function subscription(){
		$subs = read("subscription", ["provider_id"], [$_SESSION['provider']]);
		$subs = $subs[0];

		$date_started = strtotime($subs['subs_startdate']);
		$date_ended = strtotime($subs['subs_duedate']);
		$diff = ($date_ended - $date_started)/60/60/24;

		if($diff >= 28 && $diff <= 31)
			return "monthly";
		else if($diff == 365)
			return "yearly";
	}
	## IF SUBSCRIPTION IS EXPIRED
	function subscription_expired($subs_list){
		$expired = false;
		foreach($subs_list as $result){
			if(date("Y-m-d") >= date("Y-m-d", strtotime($result['subs_duedate'])))
				$expired = true;
			else 
				$expired = false;
		}
		return $expired;
	}
	## PAYMENT FOR SUBSCRIPTION
	function subscription_payment($type, $cost){
		$table = "subscription";
		$current = date("Y-m-d");
		$start_date = strtotime($current);
		##
		$attr_list = ["provider_id","subs_startdate","subs_duedate","subs_description","subs_cost"];
		$data_list = [$_SESSION['provider'], $current];
		##
		if($type == "monthly"){
			$end_date = date("Y-m-d", strtotime("+1 month", $start_date));
		}
		else if($type == "yearly"){
			$end_date = date("Y-m-d", strtotime("+1 year", $start_date));
		}
		##
		array_push($data_list, $end_date, $_SESSION['subs_desc'], $cost);
		create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
	}
	## AVAILABLE TIME FOR CHURCH
	function time_available($time_string, $service_id){
		##
		$time = $time_available = "";
		$results = [];
		$time_booked = read("purchase", ["service_id"], [$service_id]);
		##
		if(count($time_booked) > 0) {
			foreach($time_booked as $result) {
				$time .= $result['purchase_sched_time'].",";
			}
		}
		## CHECK CURRENT SCHEDULED TIME
		$time_list = explode(",",$time_string);
		$time = explode(",",$time);
		## GET ALL AVAILABLE TIME
		$results = array_diff($time_list, $time);
		##
		if(!empty($results)) {
			foreach($results as $result) {
				$time_available .= "<option value='{$result}'>{$result}</option>";
			}
		}
		
		return $time_available;
		## IF RESULT IS EQUALS TO ""
		## DISPLAY FULLY BOOKED
	}
	## UPDATE FUNCTION
	function update($table, $attr_list, $data_list, $condition){
		## UPDATE organizer SET orga_company=?, orga_fname=?, orga_lname=?, orga_mi=?, orga_address=?, orga_phone=?, orga_email=? WHERE orga_id=?"
		DB::query("UPDATE ".$table." SET ".join("=?, ", $attr_list)."=? WHERE ".$condition."=?", $data_list, "UPDATE");
	}
	## UPDATE FUNERAL ADDITIONAL DETAILS
	function update_details($type){
		$txtname = trim(ucwords($_POST['txtname']));
		##
		if($type == "funeral" || $type == "church") {
			$txtbdt = $_POST['txtbdt'];
			$txtbadd = trim(ucwords($_POST['txtbadd']));
		}
		## ERROR TRAPPING
		if(preg_match('/\d/', $txtname)){
			echo "<script>alert('Firstname cannot have a number!')</script>";
		}
		else {
			$table = "details";
			##
			if($type == "funeral" || $type == "church") {
				$attr_list = ["deceased_name","burial_datetime","burial_add"];
				$data_list = [$txtname, date("Y-m-d H:i:s", strtotime($txtbdt)), $txtbadd];
			}
			switch($type){
				case "funeral":
					$txtdadd = trim(ucwords($_POST['txtdadd']));
					array_push($attr_list, "delivery_add");
					array_push($data_list, $txtdadd, $_GET['purchaseid']);
				break;
	
				case "church":
					array_push($data_list, $_GET['purchaseid']);
				break;

				case "headstone":
					$dbirth = $_POST['dbirth'];
					$ddeath = $_POST['ddeath'];
					$ddeliver = $_POST['ddeliver'];
					$txtdadd = trim(ucwords($_POST['txtdadd']));
					$txtmsg = trim(ucwords($_POST['txtmsg']));
					
					$attr_list = ["deceased_name", "birth_date", "death_date", "delivery_date", "delivery_add", "message"];
					$data_list = [$txtname, date("Y-m-d", strtotime($dbirth)), date("Y-m-d", strtotime($ddeath)), date("Y-m-d", strtotime($ddeliver)), $txtdadd, $txtmsg, $_GET['purchaseid']];
				break;
			}
			## UPDATE DETAILS TABLE
			update($table, $attr_list, $data_list, "purchase_id");
			header("Location: status.php?purchaseid=".$_GET['purchaseid']."&updated");
			exit;
		}		
	}
	## UPLOAD SINGLE IMAGE
	function upload_image($name, $target){
		$allowedType = array('jpg','jpeg','png','pdf');
		$file = $_FILES[$name];
		
		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileError = $file['error'];
		
		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
		## RETURN 2 MEANS FILE TYPE IS NOT ALLOWED!
		if(!in_array($fileType, $allowedType)) return 2;
		## RETURN 1 MEANS THERE IS AN ERROR IN UPLOADING IMAGE!
		if(!$fileError === 0) return 1;
		## ASSIGN UNIQUE NAME AND FILE LOCATION
		$fileNewName = uniqid('', true).".".$fileType;
		$fileLocation = $target.$fileNewName;
		## UPLOADS
		@move_uploaded_file($fileTmpName, $fileLocation);

		return $fileNewName;
	}
	## UPDATE PROFILE
	function update_profile($user, $email){
		$txtfn = trim(ucwords($_POST['txtfn']));
		$txtmi = trim(ucwords($_POST['txtmi']));
		$txtln = trim(ucwords($_POST['txtln']));
		$provider = provider();
		##
		if(user_type() == "admin"){
			$txtaddress = "";
			$txtphone = 0;
		}
		else {
			if(user_type() == "provider"){
				$txtcn = trim(ucwords($_POST['txtcn']));
				$image = $_FILES['file_logo'];

				if($image['size'] != 0){
					if(!empty($provider['provider_logo'])){
						## DELETE THE IMAGE FILE
						$path = "images/providers/".$provider['provider_type']."/".$provider['provider_id']."/{$provider['provider_logo']}";
						if(!unlink($path)) echo "<script>alert('An error occurred in deleting image!')</script>";
					}
					##
					$imageName = upload_image("file_logo", "images/providers/".$provider['provider_type']."/".$_SESSION['provider']."/");
				}	
			}	

			$txtaddress = trim(ucwords($_POST['txtaddress']));
			$txtphone = trim($_POST['txtphone']);
		}
		## ERROR TRAP
		if(preg_match('/\d/', $txtfn)){
			echo "<script>alert('Firstname cannot have a number!')</script>";
		}
		else if(preg_match('/\d/', $txtmi)){
			echo "<script>alert('Middle name cannot have a number!')</script>";
		}
		else if(preg_match('/\d/', $txtln)){
			echo "<script>alert('Lastname cannot have a number!')</script>";
		}
		else if(!preg_match('/\d/', $txtphone)){
			echo "<script>alert('Phone cannot have a letter!')</script>";
		}
		else {
			$data_list = [];

			switch ($user){
				case "seeker":
					$condition = "seeker_email";
					$attr_list = ["seeker_fname", "seeker_mi", "seeker_lname", "seeker_address", "seeker_phone"];

					array_push($data_list, $txtfn, $txtmi, $txtln, $txtaddress, $txtphone, $email);
					update($user, $attr_list, $data_list, $condition);

					break;

				case "provider":
					$condition = "provider_email";
					$attr_list = ["provider_company", "provider_fname", "provider_mi", "provider_lname", "provider_address", "provider_phone"];
					array_push($data_list, $txtcn, $txtfn, $txtmi, $txtln, $txtaddress, $txtphone, $email);
					##
					if(isset($imageName)){
						array_unshift($attr_list, "provider_logo");
						array_unshift($data_list, $imageName);
					}
					##
					update($user, $attr_list, $data_list, $condition);

					break;

				case "admin":
					$condition = "admin_email";
					$attr_list = ["admin_fname", "admin_mi", "admin_lname"];

					array_push($data_list, $txtfn, $txtmi, $txtln, $email);
					update($user, $attr_list, $data_list, $condition);

					break;
			}

			header('Location: profile.php?updated');
			exit;
		}
	}
	## UPLOAD REQUIREMENTS
	function upload_required($user, $user_id){
		if($user == "seeker")
			$imageName = upload_image("file_req", "images/".$user."s/".$user_id."/");
		else {
			$provider = read("provider", ["provider_id"], [$_SESSION['provider']]);
			$provider = $provider[0];
			$imageName = upload_image("file_req", "images/".$user."s/".$provider['provider_type']."/".$user_id."/");
		}

		## ERROR TRAPPINGS
		if($imageName === 1){
			echo "<script>alert('An error occurred in uploading your image!')</script>";
		}
		else if($imageName === 2){
			echo "<script>alert('File type is not allowed!')</script>";
		}
		else {
			$data_list = [];
			$table = "requirement";

			switch ($user){
				case "seeker":
					$attr_list = ["seeker_id", "req_type", "req_img", "req_status"];
					## CHECK IF ALREADY UPLOADED REQS
					$update_img = read($table, ["seeker_id"], [$user_id]);
					array_push($data_list, $user_id, "death certificate", $imageName, "pending");

					if(count($update_img) > 0){
						$update_img = $update_img[0];
						## DELETE THE IMAGE FILE
						$path = "images/".$user."s/".$user_id."/".$update_img["req_img"];
						if(!unlink($path)) echo "<script>alert('An error occurred in deleting image!')</script>";
						
						array_push($data_list, $update_img['req_id']);
						update($table, $attr_list, $data_list, "req_id");
					}
					else create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
					
					break;
					
				case "provider":
					$attr_list = ["provider_id", "req_type", "req_img", "req_status"];
					## CHECK IF ALREADY UPLOADED REQS
					$update_img = read($table, ["provider_id"], [$user_id]);
					array_push($data_list, $user_id, "business permit", $imageName, "pending");

					if(count($update_img) > 0){
						$update_img = $update_img[0];
						## DELETE THE IMAGE FILE
						$path = "images/".$user."s/".$provider['provider_type']."/".$user_id."/".$update_img["req_img"];
						if(!unlink($path)) echo "<script>alert('An error occurred in deleting image!')</script>";
						
						array_push($data_list, $update_img['req_id']);
						update($table, $attr_list, $data_list, "req_id");
					}
					else create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);

					break;
			}

			header('Location: profile.php?updated');
			exit;
		}
	}
	## DISPALY ALL USERS
	function users($user_type){
		if($user_type == "seeker"){
			$user = read($user_type);
			$count = 0;
			##
			if(count($user)>0){
				foreach($user as $results){
					$reqs = read("requirement", ["seeker_id"], [$results['seeker_id']]);
					echo "
						<div class='list data'>
							<div>".$results['seeker_id']."</div>
							<div>".$results['seeker_fname']." ".$results['seeker_lname']."</div>
							<div>".$results['seeker_address']."</div>
							<div>".$results['seeker_phone']."</div>
							<div>".$results['seeker_email']."</div>";
					
					if(!empty($reqs)){
						$count++;
						$reqs = $reqs[0];
						echo "
							<div>".$reqs['req_status']."</div>
							<div>
								<a href='admin_users.php?id=".$count."' onclick='open_modal();' class='img-link'>
									<figure>
										<img src='images/seekers/".$results['seeker_id']."/".$reqs['req_img']."'>
									</figure>
								</a>
							</div>
						";

						if($reqs['req_status'] == "pending"){
							echo "
							<div>
								<a href='admin_users.php?verify=".$reqs['req_id']."' class='verify btn status' onclick='return confirm(\"Are you sure you want to verify this requirement?\");'>verify</a>
								<a href='admin_users.php?reject=".$reqs['req_id']."' class='verify btn status' onclick='return confirm(\"Are you sure you want to reject this requirement?\");'>reject</a>
							</div>
							";
						} else echo "<div> — </div>";

						echo "
						</div>

						<dialog class='modal-img' id='modal-img".$count."'>
							<button onclick='close_modal();'>+</button>
							<figure class='open-image'>
								<img src='images/seekers/".$results['seeker_id']."/".$reqs['req_img']."'>
							</figure>
						</dialog>
						";
					}
					else {
						echo "
							<div> — </div>
							<div> — </div>
							<div> — </div>
						</div>
						";
					}
				}
			}
		}
		## FOR PROVIDER
		else if($user_type == "provider") {
			$user = read($user_type);
			$count = 0;
			##
			if(count($user)>0){
				foreach($user as $results){
					$reqs = read("requirement", ["provider_id"], [$results['provider_id']]);
					echo "
						<div class='list data'>
							<div>".$results['provider_id']."</div>
							<div>".$results['provider_company']."</div>
							<div>".$results['provider_fname']." ".$results['provider_lname']."</div>
							<div>".$results['provider_type']."</div>
							<div>".$results['provider_address']."</div>
							<div>".$results['provider_phone']."</div>
							<div>".$results['provider_email']."</div>";
					
					if(count($reqs) > 0){
						$count++;
						$reqs = $reqs[0];
						echo "
							<div>".$reqs['req_status']."</div>
							<div>
								<a href='admin_users_provider.php?id=".$count."' onclick='open_modal();' class='img-link'>
									<figure>
										<img src='images/providers/".$results['provider_type']."/".$results['provider_id']."/".$reqs['req_img']."'>
									</figure>
								</a>
							</div>
						";

						if($reqs['req_status'] == "pending"){
							echo "
							<div>
								<a href='admin_users_provider.php?verify=".$reqs['req_id']."' class='verify btn status' onclick='return confirm(\"Are you sure you want to verify this requirement?\");'>verify</a>
								<a href='admin_users_provider.php?reject=".$reqs['req_id']."' class='verify btn status' onclick='return confirm(\"Are you sure you want to reject this requirement?\");'>reject</a>
							</div>
							";
						} else echo "<div> — </div>";

						echo "
						</div>

						<dialog class='modal-img' id='modal-img".$count."'>
							<button onclick='close_modal();'>+</button>
							<figure class='open-image'>
								<img src='images/providers/".$results['provider_type']."/".$results['provider_id']."/".$reqs['req_img']."'>
							</figure>
						</dialog>
						";
					}
					else {
						echo "
							<div> — </div>
							<div> — </div>
							<div> — </div>
						</div>
						";
					}
				}
			}
		}
		
	}
	## RETURN USER STATUS AFTER UPLOADING REQS
	function user_status(){
		if(isset($_SESSION['seeker']))
			$status = read("requirement", ["seeker_id"], [$_SESSION['seeker']]);
		else if(isset($_SESSION['provider']))
			$status = read("requirement", ["provider_id"], [$_SESSION['provider']]);

		if(count($status)>0){
			$status = $status[0];
			return $status['req_status'];
		}

		return "";
	}
	## USER LOGIN TYPE
	function user_type(){
		if(isset($_SESSION['seeker'])){
			return "seeker";
		}
		else if(isset($_SESSION['provider'])){
			return "provider";
		}
		return "admin";
	}
	## CHECK IF USER IS VERIFIED
	function verified_bool(){
		$status = read("requirement", ["seeker_id"], [$_SESSION['seeker']]);
		
		if(count($status)>0){
			$status = $status[0];

			return ($status['req_status'] == "verified") ? true:false;
		}
		else return false;
	}