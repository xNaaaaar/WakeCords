<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	date_default_timezone_set('Asia/Manila');
	require_once("others/db.php");
	ob_start();
	
	## ADD TO CART
	function add_to_cart(){
		
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

					array_push($data_list, $pw_npass, $email);
					update($user, $attr_list, $data_list, $condition);

					header('Location: profile.php?updated');
					exit;
					break;
					
				case "provider":
					break;
			}
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
		$cbouser = $_POST['cbouser'];
		$emea = trim($_POST['emea']);
		$passpw = md5($_POST['passpw']);

		$check_seeker_email = read("seeker", ["seeker_email"], [$emea]);
		$check_provider_email = read("provider", ["provider_email"], [$emea]);
		//$check_admin_email = read("admin", "admin_email", $emea);

		## CHECK IF EMAIL ALREADY EXIST
		//if(count($check_seeker_email)>0 || count($check_provider_email)>0 || count($check_admin_email)>0){
		if(count($check_seeker_email)>0 || count($check_provider_email)>0){
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
				}

				## SUCCESSFUL MESSAGE
				header("Location: index.php?success");
			}
		}	
	}
	## USER LOGIN ID
	function current_user(){
		if(isset($_SESSION['seeker'])){
			$seeker = read("seeker", ["seeker_id"], [$_SESSION['seeker']]);
			return $seeker[0];
		}
		else if(isset($_SESSION['provider'])){
			$provider = read("provider", ["provider_id"], [$_SESSION['provider']]);
			return $provider[0];
		}
		else {
			## TBD
		}
	}
	## DELETE FUNCTION
	function delete($table, $attr, $data){
		## DELETE FROM {table} WHERE {attr} = {data}
		return DB::query("DELETE FROM ".$table." WHERE ".$attr."=?", array($data), "DELETE");
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
		else echo "<script>alert('Email address or password is incorrect!')</script>";
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
							<input class='radio-terms' type='radio' required>
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
			}
		}
		else {
			echo "<span class='note red'>Cart is empty! <a href='funeral.php'>Add to cart now!</a></span>";
		}
	}
	## LIST OF PURCHASE
	function purchase_list(){
		$list = read("purchase", ["seeker_id"], [$_SESSION['seeker']]);
		
		if(count($list)>0){
			foreach($list as $results){
				$service_ = read("services", ["service_id"], [$results['service_id']]);
				$service_ = $service_[0];

				switch ($service_['service_type']){
					case "funeral":
						$differ_ = read("funeral", ["service_id"], [$service_['service_id']]);
						$differ_ = $differ_[0];
						break;
				}
				
				echo "
				<div class='list'>
					<div>
						<h3>".$differ_['funeral_name']."
							<span>
								<!-- DATE -->
								Purchased on: ".date("F j, Y", strtotime($results['purchase_date']))."
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
				if($results['purchase_status'] == "paid"){
					echo "<a href='status.php?purchaseid=".$results['purchase_id']."' class='status'>view</a>";
				}
				## STATUS IS TO PAY
				if($results['purchase_status'] == "to pay"){
					echo "<a href='payment.php?purchaseid=".$results['purchase_id']."' class='status'>pay</a>";
				}

				echo "
					</div>
				</div>
				";
			}	
		}
		else echo "<div class='note red'>You have no transaction yet!</div>";
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
	function read($table, $attr, $data){
		## SELECT * FROM joiner WHERE joiner_email=?
		if(count($attr) == 1){
			return DB::query("SELECT * FROM ".$table." WHERE ".$attr[0]."=?", array($data[0]), "READ");
		}
		else if(count($attr) == 2) {
			return DB::query("SELECT * FROM ".$table." WHERE ".$attr[0]."=? and ".$attr[1]."=?", array($data[0], $data[1]), "READ");
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
					else echo "<div class='note red'>No funeral services posted!</div>";
				}
				## DIFFERENTIATE BETWEEN FUNERAL TYPE 
				else {
					$services = DB::query("SELECT * FROM services s JOIN funeral f ON s.service_id = f.service_id WHERE service_name = ? AND funeral_type = ?", array($_SESSION['service_name'], $defer), "READ");

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
							</div>
							";
						}
					}
					else echo "<div class='note red'>No funeral services posted!</div>";
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
	## STATUS COLOR
	function status_color(){
		$status = user_status();

		if($status == "verified") return "green";
		elseif($status == "pending") return "blue";
		else return "red";
	}
	## UPDATE FUNCTION
	function update($table, $attr_list, $data_list, $condition){
		## UPDATE organizer SET orga_company=?, orga_fname=?, orga_lname=?, orga_mi=?, orga_address=?, orga_phone=?, orga_email=? WHERE orga_id=?"
		DB::query("UPDATE ".$table." SET ".join("=?, ", $attr_list)."=? WHERE ".$condition."=?", $data_list, "UPDATE");
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
		$txtaddress = trim(ucwords($_POST['txtaddress']));
		$txtphone = trim($_POST['txtphone']);
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
			echo "<script>alert('Lastname cannot have a number!')</script>";
		}
		else {
			$data_list = [];

			switch ($user){
				case "seeker":
					$attr_list = ["seeker_fname", "seeker_mi", "seeker_lname", "seeker_address", "seeker_phone"];
					$condition = "seeker_email";

					array_push($data_list, $txtfn, $txtmi, $txtln, $txtaddress, $txtphone, $email);
					update($user, $attr_list, $data_list, $condition);

					header('Location: profile.php?updated');
					exit;
					break;

				case "provider":
					break;
			}
		}
	}
	## UPLOAD REQUIREMENTS
	function upload_required($user, $user_id){
		$imageName = upload_image("file_req", "images/".$user."s/".$user_id."/");
		
		## ERROR TRAPPINGS
		if($imageName === 1){
			echo "<script>alert('An error occurred in uploading your image!')</script>";
		}
		else if($imageName === 2){
			echo "<script>alert('File type is not allowed!')</script>";
		}
		else {
			$data_list = [];

			switch ($user){
				case "seeker":
					$table = "requirement";
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
					
					header('Location: profile.php?updated');
					exit;
					break;
					
				case "provider":
					break;
			}
		}
	}
	## RETURN USER STATUS AFTER UPLOADING REQS
	function user_status(){
		$status = read("requirement", ["seeker_id"], [$_SESSION['seeker']]);
		$status = $status[0];

		return $status['req_status'];
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
		$status = $status[0];

		return ($status['req_status'] == "verified") ? true:false;
	}

	
	
	
