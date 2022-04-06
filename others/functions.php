<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	date_default_timezone_set('Asia/Manila');
	require_once("others/db.php");
	ob_start();
	
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
		$cart = DB::query("SELECT * FROM services s JOIN cart c ON s.service_id=c.service_id JOIN seeker skr ON skr.seeker_id=c.seeker_id JOIN funeral f ON f.service_id=s.service_id WHERE c.seeker_id=?", array($_SESSION['seeker']), "READ");
		
		// read("cart", ["seeker_id"], [$_SESSION['seeker']]);

		if(count($cart) > 0){
			$i = 0;
			foreach($cart as $results){
				$total_cost = $results['service_cost'] * $results['cart_qty'];
				echo "
				<div class='my-cart'>
					<figure>
						<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."' alt=''>
					</figure>
					<div class='my-cart-details'>
						<div class='my-cart-title'>
							<h3>".$results['funeral_name']."</h3>
							<p>".limit_text($results['service_desc'], 10)."</p>
						</div>
						<span class='qty'>x".$results['cart_qty']."</span>
						<h3>₱ ".number_format($total_cost,2,'.',',')."</h3>
					</div>
					<div class='my-cart-qty'><a href='deleting.php?table=cart&attr=cart_id&data=".$results['cart_id']."' onclick=\"return confirm('Are you sure you want to delete this to cart?');\"><i class='fa-solid fa-trash-can'></i></a></div>
				</div>
				";
				$i++;
			}

			echo "
			<form method='post'>
				<div class='hr full-width'></div>
				<div class='my-cart'>
					<div class='my-cart-form'>
						<div class='total-sub terms'>
							<input class='radio-terms' type='checkbox' name='radio' required>
							<p>By checking this you agree to our <a href=''>terms and conditions</a>.</p>
						</div>
						<button type='submit' name='btncheckout' class='btn'>Checkout</button>
					</div>
				</div>
			</form>
			";

			if(isset($_POST['btncheckout'])){
				$attr_list = ["seeker_id", "service_id", "purchase_total", "purchase_qty", "purchase_date", "purchase_status"];
				$cart_table = read("cart", ["seeker_id"], [$_SESSION['seeker']]);
				
				foreach($cart_table as $results){
					$service_ = read("services", ["service_id"], [$results["service_id"]]);
					$service_ = $service_[0];
					$per_cost = $service_["service_cost"] * $results['cart_qty'];

					$data_list = [$results['seeker_id'], $results['service_id'], $per_cost, $results['cart_qty'], date('Y-m-d'), "to pay"];
					## CREATE PURCHASE
					create("purchase", $attr_list, qmark_generator(count($attr_list)), $data_list);
				}
				## DELETE ALL DATA IN CART
				delete("cart", "seeker_id", $_SESSION['seeker']);

				header("Location: payment.php");
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
		if(service_type_exist_bool("funeral", $type_list) || service_type_exist_bool("church", $type_list) || service_type_exist_bool("headstone", $type_list)){
			$txtdeceasedname = trim(ucwords($_POST['txtdeceasedname']));
		}
		if(!service_type_exist_bool("church", $type_list)){
			$txtdeliveryadd = trim(ucwords($_POST['txtdeliveryadd']));
		}
		if(service_type_exist_bool("funeral", $type_list)){
			$dtburial = $_POST['dtburial'];
			$txtburialadd = trim(ucwords($_POST['txtburialadd']));

			## ERROR TRAP
			if(preg_match('/\d/', $txtdeceasedname)){
				echo "<script>alert('Deceased name cannot have a number!')</script>";
			}
			else {
				## INSERT DATA INTO FUNERAL
				foreach($purchase_list as $results){
					$attr_list = ["purchase_id", "deceased_name", "delivery_add", "burial_datetime", "burial_add"];
					$data_list = [$results['purchase_id'], $txtdeceasedname, $txtdeliveryadd, date("Y-m-d H:i:s", strtotime($dtburial)), $txtburialadd];
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
		if(service_type_exist_bool("headstone", $type_list)){
			$datebirth = $_POST['datebirth'];
			$datedeath = $_POST['datedeath'];
			$txtmsg = trim(ucwords($_POST['txtmsg']));
			$datedeliveryheadstone = $_POST['datedeliveryheadstone'];
		}
		if(service_type_exist_bool("catering", $type_list)){
			$dtdelivery = $_POST['dtdelivery'];
			$numpax = $_POST['numpax'];
		}
		if(service_type_exist_bool("church", $type_list)){
			$txtcemaddress = trim(ucwords($_POST['txtcemaddress']));
			## CHECK IF txtcemaddress IS EMPTY
		}
	}
	## PROVIDER'S SERVICES
	function provider_services($type=''){
		$provider = provider();
		$services = DB::query("SELECT * FROM services s JOIN funeral f ON s.service_id=f.service_id WHERE provider_id=? AND funeral_type=?", array($provider['provider_id'], $type), "READ");
		## DIFFER IN PROVIDER TYPE
		switch($provider['provider_type']){
			## FOR FUNERAL
			case "funeral":
			##
			if(count($services) > 0){
				foreach($services as $results){
					echo "
					<div class='card-0 no-padding'>
						<a href='funeral_tradition_this.php?service_id=".$results['service_id']."'>
							<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
							<h3>".$results['funeral_name']."
								<span>
									<i class='fa-solid fa-star'></i>
									<i class='fa-solid fa-star'></i>
									<i class='fa-solid fa-star'></i>
									<i class='fa-solid fa-star'></i>
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
						<a href='services_add.php?id=".$results['service_id']."&book=false&edit' class=''><i class='fa-solid fa-pen-to-square'></i></a>
						<a href='deleting.php?table=funeral&attr=service_id&data=".$results['service_id']."&url=services' onclick='return confirm(\"Are you sure you want to delete this coffin?\");'><i class='fa-solid fa-trash-can'></i></a>";
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

			case "church":
			##
			if(count($services) > 0){

			}
			else messaging("error", "No posted services yet!");
			break;
		}
		
		## IF FUNERAL, EITHER TRADITIONAL or CREMATION

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
		if(isset($_SESSION['seeker']))
			$list = read("purchase", ["seeker_id"], [$_SESSION['seeker']]);
		else
			$list = read('purchase');
		
		if(count($list)>0){
			foreach($list as $results){
				$service_ = read("services", ["service_id"], [$results['service_id']]);
				$service_ = $service_[0];

				$differ_ = service_type($service_['service_type'], $service_['service_id']);
				
				echo "
				<div class='list'>
					<div>
						<h3>".$differ_[1]." <mark class='btn status type'>".$service_['service_type']."</mark>
							<span>
								<!-- DATE -->
								on: ".date("F j, Y", strtotime($results['purchase_date']))."
							</span>
						</h3>
						<p>".limit_text($service_['service_desc'], 10)."</p>
					</div>
					<div>
						<span>".$results['purchase_status']."</span>
					</div>
					<div>
				";

				## STATUS IS PAID
				if($results['purchase_status'] == "paid")
					echo "<a href='status.php?purchaseid=".$results['purchase_id']."' class='status'>view</a>";

				if(isset($_SESSION['seeker'])){
					
					## STATUS IS TO PAY
					if($results['purchase_status'] == "to pay"){
						echo "<a href='payment.php?purchaseid=".$results['purchase_id']."' class='status'>pay</a>";
						echo "<a href='deleting.php?table=purchase&attr=purchase_id&data=".$results['purchase_id']."&url=purchase' class='status' onclick='return confirm(\"Are you sure you want to delete this purchase?\");'>delete</a>";
					}		
				}				

				echo "
					</div>
				</div>
				";
			}	
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
	## ADDING NEW SERVICE
	function service_adding(){
		## DECLARE VARIABLES
		$txtfn = trim(ucwords($_POST['txtfn']));
		$cbotype = $_POST['cbotype'];
		$numprice = $_POST['numprice'];
		$numqty = $_POST['numqty'];
		$txtdesc = trim($_POST['txtdesc']);

		$provider = provider();
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
					$attr_list = ["provider_id", "service_type", "service_name", "service_desc", "service_cost", "service_qty", "service_img", "service_status"];
					array_push($data_list, $provider['provider_id'], $provider['provider_type'], $provider['provider_company'], $txtdesc, $numprice, $numqty, $imageName, "active");
					## ADDED TO SERVICES
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);
					$service = read("services", ["service_img"], [$imageName]);
					$service = $service[0];
					## ADD TO SPECIFIC TYPE
					create("funeral", ["service_id", "funeral_name", "funeral_type"], qmark_generator(3), [$service['service_id'], $txtfn, $cbotype]);
					## 
					echo "<script>alert('Successfully added new service!')</script>";
				break;
			}
		}
	}
	## EDITING SERVICE
	function service_editing($id){
		$numqty = $_POST['numqty'];
		$txtdesc = $_POST['txtdesc'];

		update("services", ["service_qty", "service_desc"], [$numqty, $txtdesc, $id], "service_id");
		header("Location: services.php?updated");
		exit;
	}
	## SERVICE TYPE
	function service_type($type, $service_id){
		switch($type){
			case "funeral":
				$result = read($type, ["service_id"], [$service_id]);
				break;
			case "flower":
				break;
		}

		return $result[0];
	}
	## SERVICE TYPE EXISTS IN ARRAY BOOLEAN
	function service_type_exist_bool($type, $type_list){
		for($i=0;$i<count($type_list);$i++){
			if($type == $type_list[$i]) {
				return true;
			}
		}
		return false;
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
					$services = DB::query("SELECT * FROM services GROUP BY service_name", array(), "READ");

					if(count($services) > 0){
						foreach($services as $results){
							echo "
							<div class='card-0'>
								<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
								<h3>".$results['service_name']."
									<span>
										(5 reviews)
										<i class='fa-solid fa-star'></i>
										<i class='fa-solid fa-star'></i>
										<i class='fa-solid fa-star'></i>
										<i class='fa-solid fa-star'></i>
									</span>
								</h3>
								<p>
									".limit_text($results['service_desc'], 10)."
								</p>
								<a class='btn' href='funeral_tradition.php?service_name=".$results['service_name']."'>View</a>
							</div>
							";
						}
					}
					else messaging("error", "No funeral services posted!");
				}
				## DIFFERENTIATE BETWEEN FUNERAL TYPE 
				else {
					$services = DB::query("SELECT * FROM services s JOIN funeral f ON s.service_id = f.service_id WHERE service_name = ? AND funeral_type = ?", array($_SESSION['service_name'], $defer), "READ");

					if(count($services) > 0){
						foreach($services as $results){
							## VIEW ONLY FOR ADMIN
							if(user_type() == "admin"){
								echo "
								<div class='card-0 no-padding'>
									<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
									<h3>".$results['funeral_name']."
										<span>
											<i class='fa-solid fa-star'></i>
											<i class='fa-solid fa-star'></i>
											<i class='fa-solid fa-star'></i>
											<i class='fa-solid fa-star'></i>
										</span>
									</h3>
									<p>
										".limit_text($results['service_desc'], 10)."
									</p>
									<div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>
								</div>
								";
							}
							## FOR SEEKERS
							else {
								echo "
								<div class='card-0 no-padding'>
									<a href='funeral_tradition_this.php?service_id=".$results['service_id']."'>
										<img src='images/providers/".$results['service_type']."/".$results['provider_id']."/".$results['service_img']."'>
										<h3>".$results['funeral_name']."
											<span>
												<i class='fa-solid fa-star'></i>
												<i class='fa-solid fa-star'></i>
												<i class='fa-solid fa-star'></i>
												<i class='fa-solid fa-star'></i>
											</span>
										</h3>
										<p>
											".limit_text($results['service_desc'], 10)."
										</p>
										<div class='card-price'>₱ ".number_format($results['service_cost'], 2, '.', ',')."</div>
									</a>
								</div>
								";
							}
							
						}
					}
					else messaging("error", "No funeral services posted!");
				}
			break;

			## CANDLE SERVICES
			case "candle":
			break;

			## CHURCH SERVICES
			case "church":
			break;

			## FLOWER SERVICES
			case "flower":
			break;

			## FOOD CATERING SERVICES
			case "food_cater":
			break;

			## HEADSTONE SERVICES
			case "headstone":
			break;
		}	
	}
	## CHECK IF SPECIFIC SERVICE IS BOOKED
	function service_is_booked($service_id){
		$service = DB::query("SELECT * FROM services s JOIN purchase p ON s.service_id = p.service_id WHERE s.service_id=?", array($service_id), "READ");

		if(count($service) > 0)
			return true;
		return false;
	}
	## STATUS COLOR
	function status_color(){
		$status = user_status();

		if($status == "verified") return "green";
		elseif($status == "pending") return "blue";
		else return "red";
	}
	## PAYMENT FOR SUBSCRIPTION
	function subs_payment($type, $cost){
		$current = date("Y-m-d");
		$start_date = strtotime(date("Y-m-d"));
		$subs = "subscription";
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
		create($subs, $attr_list, qmark_generator(count($attr_list)), $data_list);
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
	## UPDATE FUNCTION
	function update($table, $attr_list, $data_list, $condition){
		## UPDATE organizer SET orga_company=?, orga_fname=?, orga_lname=?, orga_mi=?, orga_address=?, orga_phone=?, orga_email=? WHERE orga_id=?"
		DB::query("UPDATE ".$table." SET ".join("=?, ", $attr_list)."=? WHERE ".$condition."=?", $data_list, "UPDATE");
	}
	function update_details($type){
		$txtname = trim(ucwords($_POST['txtname']));
		$txtbdt = $_POST['txtbdt'];
		$txtbadd = trim(ucwords($_POST['txtbadd']));
		$txtdadd = trim(ucwords($_POST['txtdadd']));

		switch($type){
			case "funeral":
				## ERROR TRAPPING
				if(preg_match('/\d/', $txtname)){
					echo "<script>alert('Firstname cannot have a number!')</script>";
				}
				else {
					$table = "details";
					$attr_list = ["deceased_name","burial_datetime","burial_add","delivery_add"];
					$data_list = [$txtname, date("Y-m-d H:i:s", strtotime($txtbdt)), $txtbadd, $txtdadd, $_GET['purchaseid']];

					update($table, $attr_list, $data_list, "purchase_id");

					header("Location: status.php?purchaseid=".$_GET['purchaseid']."&updated");
					exit;
				}
			break;

			case "church":
			break;
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
		##
		if(user_type() == "admin"){
			$txtaddress = "";
			$txtphone = 0;
		}
		else {
			if(user_type() == "provider")
				$txtcn = trim(ucwords($_POST['txtcn']));

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
					$attr_list = ["seeker_fname", "seeker_mi", "seeker_lname", "seeker_address", "seeker_phone"];
					$condition = "seeker_email";

					array_push($data_list, $txtfn, $txtmi, $txtln, $txtaddress, $txtphone, $email);
					update($user, $attr_list, $data_list, $condition);

					break;

				case "provider":
					$attr_list = ["provider_company", "provider_fname", "provider_mi", "provider_lname", "provider_address", "provider_phone"];
					$condition = "provider_email";

					array_push($data_list, $txtcn, $txtfn, $txtmi, $txtln, $txtaddress, $txtphone, $email);
					update($user, $attr_list, $data_list, $condition);

					break;

				case "admin":
					$attr_list = ["admin_fname", "admin_mi", "admin_lname"];
					$condition = "admin_email";

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
					
					if(!empty($reqs)){
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

	
	
	