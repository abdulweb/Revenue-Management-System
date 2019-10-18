<?php
session_start();
error_reporting(0);
/**
* 
*/
class user extends dbh
{

	

	
	// function __construct(argument)
	// {
	// 	# code...
	// }


	public function login($username, $password)
	{
		$hashPassword = md5($password);
		if($username == 'admin@admin.com' && $password == 'passw0rd')
		{
			$_SESSION['user'] = $username;
			$_SESSION['usertype'] = 'superAdmin';
			$error = 0;
			header('location:admin/index.php');
		}
		else{

			$stmt = "SELECT * from users where email = '$username' && password = '$hashPassword'";
			$result = $this->connect()->query($stmt);
			$numberrows = $result->num_rows;
			if ($numberrows > 0 ) 
			{
				$rows= $result->fetch_assoc();
				if ($rows['active'] == 1) 
				{
					# code...
					$userType = $rows['user_type'];
					if($userType == 'SD')
					{	
						// $get_image = "SELECT * FROM application_document where user_id = '$rows['user_id']'";
					// 	$result = $this->connect()->query($get_image)->fetch_assoc();
						$_SESSION['user'] = $username;
						$_SESSION['usertype'] = $userType;
						$_SESSION['user_id'] = $rows['id'];
						$error = 0;
						header('location:salesDirector/index.php');
					}
					elseif($userType == 'Shop Owner' || $userType == 'Driver')
					{
						$_SESSION['user'] = $username;
						$_SESSION['usertype'] = $userType;
						$_SESSION['user_id'] = $rows['id'];
						$error = 0;
						header('location:payer/index.php');
					}
					else
					{
						$error = 1;
						$oldmail = $username;
						//return $oldmail;
						echo  $this->messages($error);	
					}

				}
				else
				{
					// $error = 3;
					// echo $this->messages($error);
					echo '<div class ="alert alert-danger">'.$rows['message'].'</div>';
				}	
				
			}
			else{
				$error = 2;
				echo $this->messages($error);
			}
		}
		
	}

	public function messages($message)
	{
		if ($message == 1) {
			return '<div class ="alert alert-danger"> Wrong username and password </div>';
		}
		if($message == 2)
		{
			return '<div class ="alert alert-danger"> Attension!!! Unthorize user </div>';
		}
		if($message == 3)
		{
			return '<div class ="alert alert-danger"> User account has been revorked.. Please Contact system Administrator for help </div>';
		}
	}

	public function sessioncheck($sess)
	{
		if ($sess =='' or empty($sess) or $sess == null) 
		{
			header('location:..\index.php');
		}
		else{
			//return $sess;
		}
	}
	public function emptysession ($set){
		unset($set);
		header('location:..\index.php');
	}

	public function getSaleDirectors(){
		$stmt = "SELECT * FROM users where user_type = 'SD'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}

	public function getUserName($id)
	{
		$stmt = "SELECT fullname FROM profile where user_id = '$id'";
		$result= $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$data = $result->fetch_assoc();
			$string = implode('|',$data);
			return $string;
		}
		else{

		}
	}

	public function insertSd($name,$email,$phone){
		if (empty($this->checkUser($email))) 
		{
			$password = md5($phone);
			$date = date('Y-m-d');
			$insert = "INSERT INTO users(email,phone,password,active,date_add,user_type)Values('$email','$phone','$password','1','$date','SD')";
			$stmt = $this->connect()->query($insert);
			if (!$stmt) {
				echo '<div class ="alert alert-danger"> <strong> Error Occured !!! Please Try Again </strong> </div>';
			}
			else
			{
				$this->insertname($email,$name);
				
			}

		}
		else{
			echo $this->checkUser($email);
		}
	}

	public function insertname($email,$name)
	{
		$stmty = "SELECT id from users where email = '$email'";
		$result = $this->connect()->query($stmty);
		$data =   $result->fetch_assoc();
		$id =      $data['id'];
		$insert = "INSERT INTO profile(fullname,user_id) Values('$name','$id')";
		$occ = 	$this->connect()->query($insert);
		if ($occ) 
		{

			echo '<div class ="alert alert-success"> <strong> New Sales Director  Added Successfully  </strong> </div>';
		}
		else
		{
			print_r($data);
			echo '<div class ="alert alert-danger"> <strong> Error Occured !!! Please Try Again!!! </strong> </div>';
		}
	}
	public function deleteSd($id)
	{
		$stmt = "DELETE FROM profile where user_id = '$id'";
		$result = $this->connect()->query($stmt);
		if ($result) {
			$stmtx = "DELETE FROM users where id = '$id'";
			$resultx = $this->connect()->query($stmtx);
			if ($resultx) {
				echo "success";
			}
			else{
				echo '<script>alert("Please Try Agin. Error Occured")</script>';
			}
		}
		else{
			echo '<script>alert("Please Try Agin. Error Occured")</script>';
		}
	}

	

	public function checkUser($email){

		$stmt = "SELECT * FROM users where email = '$email' ";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows; 
		if (($numberrows)> 0) {
			return '<div class ="alert alert-danger"> <strong> Sorry !!! User  Already Exist  </strong> </div>';
			 
		}
		else{

		}
	}

	public function update_sd($fullname,$email,$phone,$identType,$identNo,$id){

	 $stmt = "UPDATE users set email = '$email', phone = '$phone' where id = '$id'";
	 $stmt2 = "UPDATE profile set fullname = '$fullname', identification_type = '$identType', identification_no = '$identNo' where user_id = '$id'";
	 $result = $this->connect()->query($stmt);
	 $result2 = $this->connect()->query($stmt2);
	 if($result & $result2)
	 {
	 	echo "success";
	 }
	 else{
	 	echo '<script>alert("Please Try Agin. Error Occured")</script>';
	 }
	 	
	 exit();

	}

	// sd functions

	public function getRevnuePayer(){
		$stmt = "SELECT * FROM users where user_type != 'SD' ORDER By id DESC";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}

	public function getOneUser($userID){
		$stmt = "SELECT * FROM users where id ='$userID'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}

	public function getPassport($userID){
		$stmt = "SELECT passport FROM profile where user_id ='$userID'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}

	public function getprofile($id)
	{
		$stmt = "SELECT * FROM profile where user_id = '$id'";
		$result= $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}

	public function revorkUser($id, $message)
	{
		$stmt = "UPDATE users set active = '0', message = '$message' where id = '$id'";
		 $result = $this->connect()->query($stmt);
		 if($result)
		 {
		 	echo "success";
		 }
		 else{
		 	echo '<script>alert("Please Try Agin. Error Occured")</script>';
		 }
		 	
		 exit();

	}

	public function unrevorkUser($id)
	{
		$stmt = "UPDATE users set active = '1' where id = '$id'";
		 $result = $this->connect()->query($stmt);
		 if($result)
		 {
		 	echo "success";
		 }
		 else{
		 	echo '<script>alert("Please Try Agin. Error Occured")</script>';
		 }
		 	
		 exit();

	}

	public function insertUser($fullname,$email,$phone,$identificationNo,$identificationType)
	{
		if  (!empty($this->checkUser($email)))
		{
			echo '<div class ="alert alert-danger"> <strong> Sorry !!! User  Already Exist  </strong> </div>';
		}
		else
		{
			if (empty($email)  || empty($phone)) 
			{
				echo '<div class ="alert alert-danger"> <strong> Sorry !!! User  Already Exist  </strong> </div>';
			}
			else
			{
				$password = md5($phone);$date_add = date('Y-m-d');
				$target_dir = "uploads/";
	                    $target_file1 = $target_dir . basename($_FILES["passport"]["name"]);
	                    $uploadOk = 1;
	                    $imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		                $check = getimagesize($_FILES["passport"]["tmp_name"]);
	                    if($check !== false) 
	                    {
	                        //echo "File is an image - " . $check["mime"] . ".";
	                        $uploadOk = 1;
	                    } 
	                    else {
	                    	echo '<div class ="alert alert-danger"> <strong> Sorry !!! Passport is not an image. Please select Image file !  </strong> </div>';
	                        $uploadOk = 0;
	                    }
	                    // check passport
	                    if ($_FILES["passport"]["size"] > 5000000) 
		                  {
		                  	echo '<div class ="alert alert-danger"> <strong> Sorry, your Passport file is too large. Must not be more than 5MB  </strong> </div>';
		                      $uploadOk = 0;
		                  }

	                      // Allow certain file formats
	                     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
	                      {
	                      	echo '<div class ="alert alert-danger"> <strong> Sorry, only JPG, JPEG, PNG  format is allowed for Passport.</strong> </div>';
	                          $uploadOk = 0;
	                      }
	                      if ($uploadOk == 0) 
	                      {
	                      	echo '<div class ="alert alert-danger"> <strong> Sorry, your file was not uploaded. Please retry.</strong> </div>';
	                            

	                      // if everything is ok, try to upload file
	                      }
		              else
		              {
		              	if ( (move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file1)))
		              	{
    
	              		$stmt = "INSERT INTO users(email,password,phone,user_type,date_add,active) values('$email','$password','$phone','$identificationType','$date_add','1')";
	              		if ($this->connect()->query($stmt)) 
	              		{
	              			$get = $this->connect()->query("SELECT id from users where email = '$email'");
	              			$data =   $get->fetch_assoc();
							$id =      $data['id'];
	              			$stmtx = "INSERT INTO profile(fullname,identification_type,identification_no,passport,user_id) values('$fullname','$identificationType','$identificationNo','$target_file1','$id') ";
	              			if ($this->connect()->query($stmtx)) {
	              				echo '<div class ="alert alert-success"> <strong> New User Submitted Successfully.</strong> </div>';
	              			}
	              			else
							{
								echo '<div class ="alert alert-danger"> <strong> Error occured Please try again !.</strong> </div>';
							}
	              			
						}
						else
						{
							echo '<div class ="alert alert-danger"> <strong> Error occured Please try again !.</strong> </div>';
						}
				

              	}
              	else{
              		echo '<div class ="alert alert-danger"> <strong> Error occured Please Contact Admin for help !.</strong> </div>';
              	}
              	
              }
			}
		}
	}

	public function UpdateUser($fullname,$userID,$identificationNo,$identificationType)
	{
		$stmt = "UPDATE profile set fullname = '$fullname', identification_type = '$identificationType', identification_no = '$identificationNo' WHERE user_id = '$userID'";
		$result = $this->connect()->query($stmt);
		if ($result) {
			echo '<div class ="alert alert-success">User info Updated Successfully</div>';
		}
		else{
			echo '<div class ="alert alert-danger">error Occured</div>';
		}
	}

	// ###################  Payer/users registration ##########################
	public function insertPayer($fullname,$email,$phone,$identificationNo,$identificationType,$secret)
	{
		if  (!empty($this->checkUser($email)))
		{
			echo '<div class ="alert alert-danger"> <strong> Sorry !!! User  Already Exist  </strong> </div>';
		}
		else
		{
			if (empty($email)  || empty($phone)) 
			{
				echo '<div class ="alert alert-danger"> <strong> Sorry !!! Email or phone is required  </strong> </div>';
			}
			else
			{
				$password = md5($secret);$date_add = date('Y-m-d');
				$target_dir = "salesDirector/uploads/";
	                    $target_file1 = $target_dir . basename($_FILES["passport"]["name"]);
	                    $uploadOk = 1;
	                    $imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
		                $check = getimagesize($_FILES["passport"]["tmp_name"]);
	                    if($check !== false) 
	                    {
	                        //echo "File is an image - " . $check["mime"] . ".";
	                        $uploadOk = 1;
	                    } 
	                    else {
	                    	echo '<div class ="alert alert-danger"> <strong> Sorry !!! Passport is not an image. Please select Image file !  </strong> </div>';
	                        $uploadOk = 0;
	                    }
	                    // check passport
	                    if ($_FILES["passport"]["size"] > 5000000) 
		                  {
		                  	echo '<div class ="alert alert-danger"> <strong> Sorry, your Passport file is too large. Must not be more than 5MB  </strong> </div>';
		                      $uploadOk = 0;
		                  }

	                      // Allow certain file formats
	                     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
	                      {
	                      	echo '<div class ="alert alert-danger"> <strong> Sorry, only JPG, JPEG, PNG  format is allowed for Passport.</strong> </div>';
	                          $uploadOk = 0;
	                      }
	                      if ($uploadOk == 0) 
	                      {
	                      	echo '<div class ="alert alert-danger"> <strong> Sorry, your file was not uploaded. Please retry.</strong> </div>';
	                            

	                      // if everything is ok, try to upload file
	                      }
		              else
		              {
		              	if ( (move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file1)))
		              	{
    
	              		$stmt = "INSERT INTO users(email,password,phone,user_type,date_add,active,message) values('$email','$password','$phone','$identificationType','$date_add','0','Account not actived yet')";
	              		if ($this->connect()->query($stmt)) 
	              		{
	              			$get = $this->connect()->query("SELECT id from users where email = '$email'");
	              			$data =   $get->fetch_assoc();
							$id =      $data['id'];
							$picx = substr($target_file1, 14);
	              			$stmtx = "INSERT INTO profile(fullname,identification_type,identification_no,passport,user_id) values('$fullname','$identificationType','$identificationNo','$picx','$id') ";
	              			if ($this->connect()->query($stmtx)) {
	              				echo '<div class ="alert alert-success"> <strong> Account creation Successfully.</strong> Kindly Wait to active your account before login </div>';
	              			}
	              			else
							{
								echo '<div class ="alert alert-danger"> <strong> Error occured Please try again !.</strong> </div>';
							}
	              			
						}
						else
						{
							echo '<div class ="alert alert-danger"> <strong> Error occured Please try again !.</strong> </div>';
						}
				

              	}
              	else{
              		echo '<div class ="alert alert-danger"> <strong> Error occured Please Contact Admin for help !.</strong> </div>';
              	}
              	
              }
			}
		}
	}

	public function month(){
		echo '<option>January</option>
			 <option>February</option>
			 <option>March</option>
			 <option>April</option>
			 <option>May</option>
			 <option>June</option>
			 <option>July</option>
			 <option>August</option>
			 <option>September</option>
			 <option>October</option>
			 <option>November</option>
			 <option>December</option>
				';
	}
	public function payRevenue($amount,$userID,$month)
	{
		if($this->checkPayment($month,$userID) == 'error')
		{
			echo '<div class ="alert alert-danger"> <strong> You have paid for the month selected.</strong> </div>'; 
		}
		else
		{
			$now = new DateTime();
			$date_paid = $now->format("Y-m-d");
			$stmt = "INSERT INTO payment(user_id,amount,month_paid,date_paid) values('$userID','$amount','$month','$date_paid')";
		  	$result = $this->connect()->query($stmt);
		  	if($result)
		  	{
		  		echo '<div class ="alert alert-success"> <strong> payment Successfully!. Kindly wait for your payment to be verify</strong> </div>';
		  	}
		  	else{
		  		echo '<div class ="alert alert-danger"> <strong> Error occured Please Contact Admin for help !.</strong> </div>';
		  	}
		}
  	}
  	public function checkPayment($month,$userID)
  	{
  		$stmt = "SELECT * FROM payment where user_id = $userID";
		$result = $this->connect()->query($stmt);
		$row = $result->fetch_assoc();
		if (trim($row['month_paid']) == trim($month)) {
			return 'error';
		}
		else
		{
			return 'success';
		}
  	}

	  function previousYear($vardate,$added)
	{
	$data = explode("-", $vardate);
	$date = new DateTime();            
	$date->setDate($data[0], $data[1], $data[2]);
	$date->modify("".$added."");
	$day= $date->format("Y-m-d");
	return $day;    
	}

// ###################

	public function update_row($productName,$productPrice,$productQuantity,$id){

	 $upper_productName = strtoupper($productName);
	 $stmt = "UPDATE product set productName = '$upper_productName', productPrice = '$productPrice', quantity ='$productQuantity' where id = '$id'";
	 $result = $this->connect()->query($stmt);
	 if($result)
	 {
	 	echo "success";
	 }
	 else{
	 	echo '<script>alert("Please Try Agin. Error Occured")</script>';
	 }
	 	
	 exit();

	}

	public function productCategory(){
		$stmt = "SELECT * FROM categories";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}

	public function storeCategory($catName){
		if (empty($this->checkCategory($catName))) 
		{
			$storecatName = strtoupper($catName);
			$date = date('Y-m-d');
			$insert = "INSERT INTO categories(name,date_add)Values('$storecatName','$date')";
			$stmt = $this->connect()->query($insert);
			if (!$stmt) {
				echo '<div class ="alert alert-danger"> <strong> Error Occured !!! Please Try Again </strong> </div>';
			}
			else
			{
				echo '<div class ="alert alert-success"> <strong> New category Added Successfully  </strong> </div>';
			}

		}
		else{
			echo $this->checkCategory($catName);
		}
	}

	public function checkCategory($catName){
		$storecatName = strtoupper($catName);
		$stmt = "SELECT * FROM categories where name = '$storecatName' ";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows; 
		if (($numberrows)> 0) {
			return '<div class ="alert alert-danger"> <strong> Sorry !!! category  Already Exist  </strong> </div>';
			 
		}
		else{

		}
	}

	public function update_cat($name,$id){
	 $upname = strtoupper($name);
	 $stmt = "UPDATE categories set name = '$upname' where id = '$id'";
	 $result = $this->connect()->query($stmt);
	 if($result)
	 {
	 	echo "success";
	 }
	 else{
	 	
	 }
	 	
	 exit();

	}

	public function delete_cat($id)
	{
		$stmt = "DELETE FROM categories where id = '$id'";
		$result = $this->connect()->query($stmt);
		if ($result) {
			echo "success";
		}
		else{
			echo '<script>alert("Please Try Agin. Error Occured")</script>';
		}
	}

	public function delete_product($id)
	{
		$stmt = "DELETE FROM product where id = '$id'";
		$result = $this->connect()->query($stmt);
		if ($result) {
			echo "success";
		}
		else{
			echo '<script>alert("Please Try Agin. Error Occured")</script>';
		}
	}
	

	public function getAllCustomers()
	{
		$stmt = "SELECT * FROM customers";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			while ($rows= $result->fetch_assoc()) {
				$row_date [] = $rows;
		}
		 return $row_date;
			
		}
		else{
			return '';
		}
	}
	
	public function storeCustomer($name,$phoneNo,$email,$address){
		if (empty($this->checkCustomer($phoneNo,$email))) 
		{
			$date = date('Y-m-d');
			$insert = "INSERT INTO customers(fullName,phoneNo,address,email,date_add)Values('$name','$phoneNo','$address','$email','$date')";
			$stmt = $this->connect()->query($insert);
			if (!$stmt) {
				echo '<div class ="alert alert-danger"> <strong> Error Occured !!! Please Try Again </strong> </div>';
			}
			else
			{
				echo '<script type="text/javascript">';
				echo 'setTimeout(function () { swal("Congratulation!","New customer Added Successfully !","success");';
				echo '}, 1000);</script>';
			}

		}
		else{
			echo $this->checkCustomer($phoneNo,$email);
		}
	}

	public function checkCustomer($phoneNo,$email){

		$stmt = "SELECT * FROM customers where phoneNo = '$phoneNo' OR email = '$email' ";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows; 
		if (($numberrows)> 0) {
			return '<div class ="alert alert-danger"> <strong> Sorry !!! customer  Already Exist  </strong> </div>';
			 
		}
		else{

		}
	}

	public function cart($quantity){
		$stmt = "INSERT into customer_cart(quantity,custID,prdID)Values('$quantity','1','1')";
		$result = $this->connect()->query($stmt);
		if ($result) {
			echo "success";
		}
		else{
			echo "Error Occured!!!";
		}
	}
	public function getCart($custID)
	{
		$stmt = "SELECT * from customer_cart where custID = '$custID'";
		$result = $this->connect()->query($stmt);
		if ($result->num_rows > 0) {
			while ($rows = $result->fetch_assoc()) {
				$data[] = $rows;
			}
			return $data;
		}
		else{
			return '';
		}
	}

	public function getCartProduct($id)
	{
		$stmt = "SELECT * from product where id = '$id'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) 
		{
			$data = $result->fetch_assoc();
			return $data;
		}
		else{
			return '';
		}
	}

	public function storetoCart($id,$quantitys,$date,$custName,$custNumber,$custAddress,$transcationID)
	{
		$smtm = "INSERT INTO customer_cart(prdID,quantity,date_add,customerName,customerNumber,customerAddress,transcationID) VALUES('$id','$quantitys','$date','$custName','$custNumber','$custAddress','$transcationID') ";
      	$result = $this->connect()->query($smtm);
      	if ($result) 
      	{
      		$stmt = "SELECT * from product where id = '$id'";
      		$checkresult = $this->connect()->query($stmt);
      		$fetech_data = $checkresult->fetch_assoc();
      		$productid =   $fetech_data['id'];
      		$newQuantity = ($fetech_data['quantity']) - ($quantitys);
      		$newUpdate = $this->connect()->query("UPDATE product set quantity = '$newQuantity' where id = $productid");

      	}
      	else{
        $_SESSION['errorMes'] = 'Error Ocurred';
        header('location:suppliers.php');
      }
	}

	public function sales(){
		$stmt = "SELECT * FROM customer_cart";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows >0) {
			$counter = 1;
			while ($rows= $result->fetch_assoc()) {
				// $data[] = $rows;
				if (substr($rows['date_add'], 8,2) == date('d')) {
					
					$data[] = $rows;
				}
				else{

				}
			}
			return $data;
			
		}
	}

	public function saless($report){
			if ($report =='daily') {
				// daily code
				return $this->sales();

			}
			elseif ($report =='weekly') {
				// weekly code
				$stmt = "SELECT * FROM customer_cart";
				$result = $this->connect()->query($stmt);
				$numberrows = $result->num_rows;
				if ($numberrows >0) {
					$counter = 1;
					while ($rows= $result->fetch_assoc()) {
						// $data[] = $rows;
						if ($this->weekOfMonth($rows['date_add']) == $this->weekOfMonth(date('Y-m-d'))) {
							
							$data[] = $rows;
						}
						else{

						}
					}
					return $data;
					
				}

			}
			elseif ($report == 'monthly') {
				//monthly code...
				$stmt = "SELECT * FROM customer_cart";
				$result = $this->connect()->query($stmt);
				$numberrows = $result->num_rows;
				if ($numberrows >0) {
					$counter = 1;
					while ($rows= $result->fetch_assoc()) {
						// $data[] = $rows;
						if (substr($rows['date_add'], 5,2) == date('m') && substr($rows['date_add'], 0,4) == date('Y')) {
							
							$data[] = $rows;
						}
						else{

						}
					}
					return $data;
					
				}
			}
			else{
				$date = date('Y-m-d');
				$stmt = "SELECT * FROM customer_cart where date_add = '$date'";
				$result = $this->connect()->query($stmt);
				$numberrows = $result->num_rows;
				if ($numberrows >0) {
					$counter = 1;
					while ($rows= $result->fetch_assoc()) {
						$data[] = $rows;
					}
					return $data;
					
				}
			}
	}

	  function weekOfMonth($qDate) {
	    $dt = strtotime($qDate);
	    $day  = date('j',$dt);
	    $month = date('m',$dt);
	    $year = date('Y',$dt);
	    $totalDays = date('t',$dt);
	    $weekCnt = 1;
	    $retWeek = 0;
	    for($i=1;$i<=$totalDays;$i++) {
	        $curDay = date("N", mktime(0,0,0,$month,$i,$year));
	        if($curDay==7) {
	            if($i==$day) {
	                $retWeek = $weekCnt+1;
	            }
	            $weekCnt++;
	        } else {
	            if($i==$day) {
	                $retWeek = $weekCnt;
	            }
	        }
	    }
	    return $retWeek;
}

	public function getCustomerName($id){
		$stmt = "SELECT fullName from customers where id = '$id'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$data = $result->fetch_assoc();
			$string = implode('|',$data);
			return $string;
		}
		else{
			return '';
		}
	}

	public function getCustomerdeatils($id){
		$stmt = "SELECT * from customer_cart where transcationID = '$id'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			//$data = $result->fetch_assoc();
			while ($data = $result->fetch_assoc()) {
				$datas [] = $data;
			}
			return $datas;
		}
		else{
			return '';
		}
	}

	public function getProductName($id){
		$stmt = "SELECT productName from product where id = '$id'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$data = $result->fetch_assoc();
			$string = implode('|',$data);
			return $string;
		}
		else{
			return '';
		}
	}

	public function getTotal($prodID,$quantity)
	{
		$prod = $this->getCartProduct($prodID);
		// $fetch = $prod->fetch_assoc();
		$productPrice = $prod['productPrice'];
		$sum = $productPrice * $quantity;
		return $sum;
		// return $fetch['id'];
	}
	public function customerCart()
	{
		$stmt = "SELECT * FROM customer_cart";
				$result = $this->connect()->query($stmt);
				$numberrows = $result->num_rows;
				if ($numberrows >0) {
					$counter = 1;
					while ($rows= $result->fetch_assoc()) 
					{
						$data[] = $rows;
					}
					return $data;
				}
	}

	public function checkProductQuantity($id){
		$stmt = "SELECT quantity from product where id = '$id'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$data = $result->fetch_assoc();
			$string = implode('|',$data);
			return $string;
		}
		
		else{
			return '';
		}
	}

	public function salesReport(){
		$stmt = "SELECT * from customer_cart WHERE transcationID IS NOT NULL ORDER BY id";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$datas  = [];
			while($data = $result->fetch_assoc())
			{
				if(count($datas) > 0) {
					if(array_search($data['transcationID'], $datas) ==  false ) 
					{
					 	array_push($datas, $data);
					}
					else
					{
						//array_push($new_data, $data);
					}
				}
				else{
					array_push($datas, $data);
				}

			}
			return $datas;

		}
		
		else{
			return '';
		}
	}

	public function getProductPrice($id)
	{
		$stmt = "SELECT productPrice FROM product where id = '$id'";
		$result= $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$data = $result->fetch_assoc();
			$string = implode('|',$data);
			return $string;
		}
		else{

		}
	}

	public function getParticularCustomer($id){
		$stmt = "SELECT * from customer_cart where transcationID = '$id'";
		$result = $this->connect()->query($stmt);
		$numberrows = $result->num_rows;
		if ($numberrows > 0) {
			$data = $result->fetch_assoc();
			return $data;
		}
		else{
			return '';
		}
	}


/* ===================================================================*/
}
// end of class
$object = new user();