<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	date_default_timezone_set('Asia/Manila');
	require_once("others/db.php");
	
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
	## CREATE FUNCTION
	function create($table, $attr_list, $qmark_list, $data_list){
		## INSERT INTO seeker(seeker_fname, seeker_mi, seeker_lname) VALUES(?,?,?)
		DB::query("INSERT INTO ".$table."(".join(", ",$attr_list).") VALUES(".join(", ",$qmark_list).")", $data_list, "CREATE");
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
	## UPDATE FUNCTION
	function update($table, $attr_list, $data_list, $condition){
		## UPDATE organizer SET orga_company=?, orga_fname=?, orga_lname=?, orga_mi=?, orga_address=?, orga_phone=?, orga_email=? WHERE orga_id=?"
		DB::query("UPDATE ".$table." SET ".join("=?, ", $attr_list)."=? WHERE ".$condition."=?", $data_list, "UPDATE");
	}
	## DELETE FUNCTION
	function delete(){

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
					$attr_list = ["seeker_id", "req_type", "req_img"];

					array_push($data_list, $user_id, "death certificate", $imageName);
					create($table, $attr_list, qmark_generator(count($attr_list)), $data_list);

					header('Location: profile.php?updated');
					exit;
					break;
					
				case "provider":
					break;
			}
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
	## LIMIT DISPLAY TEXT
	function limit_text($text, $limit) {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos   = array_keys($words);
			$text  = substr($text, 0, $pos[$limit]) . '...';
		}
		return $text;
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
									<h3>".$results['funeral_type']."
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
