<?php

// Connects to database
$db = new PDO('mysql:host=localhost;dbname=bookclub', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


if($_SERVER['REQUEST_METHOD']=='POST'){
	
	$Email= $_POST[ 'email' ];
	
	$stmt=$db->prepare("SELECT * FROM membercredentials WHERE email=?");
	
	$stmt->execute([$Email]);
	
	$info = $stmt->fetch();
	
	
	if($info){
		echo "That Email is already in use";
	}
	
	else{
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$email=$_POST['email'];
		$password=$_POST['password'];


		$memberID= "SELECT memberID from members ORDER BY memberID desc limit 1";
		$id = $db->prepare($memberID);
		$id->execute();
		$something = $id->fetchColumn(0);
		$something = $something+1;



		$sql = " INSERT INTO members (firstname,lastname) VALUES (:firstname,:lastname) ";
		$stmt = $db-> prepare($sql);
		$stmt-> execute(['firstname'=>$firstname,'lastname'=>$lastname]);



		$sql1 = " INSERT INTO membercredentials (email,password,Members_memberID) VALUES (:email,:password,:something) ";

		$stmt1 = $db-> prepare($sql1);

		$stmt1-> execute(['email'=>$email,'password'=>$password, 'something'=>$something]);



		$firstname="";
		$lastname="";
		$email="";
		$password="";

		echo "Registration Successful";
	}

}

?><!-- End php-->

<html>
<head>
	<link rel="stylesheet" href="StyleSheet1.css" />
	<script>

					function validateForm() {
						let fname = document.forms["register"]["firstname"].value;
						let lname = document.forms["register"]["lastname"].value;
						let email = document.forms["register"]["email"].value;
						let password = document.forms["register"]["password"].value;
								
						var result = "";
						var first = -1;
						if (fname == "") {
							first++;
							if (first == 0) {
								result = result + "First name";
							}
							else {
										result = result + ", first name";
							}
								 
						}
								if (lname == "") {
										 first++;
							if (first == 0) {
								result = result + "Last name";
							}
							else {
										result = result + ", last name";
							}
						}
								if (email == "") {
										 first++;
							if (first == 0) {
								result = result + "Email";
							}
							else {
										result = result + ", email";
							}
						}	 
								if (password == "") {
										first++;
							if (first == 0) {
								result = result + "Password";
							}
							else {
										result = result + ", password";
							}
						}
						if (first != -1) {
							result = result + " is/are missing fields";
							alert(result);
							return false;
						}
						
					}



	</script>
</head>

<form name="register" action="" onsubmit="return validateForm()" method="POST">

	<!-- First Name-->
	<label for="firstname">First Name:</label><br />
	<input type="text" id="firstname" name="firstname" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $firstname  ?>" /><br />

	<!-- Last Name-->
	<label for="lastname">Last Name:</label><br />
	<input type="text" id="lastname" name="lastname" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $lastname  ?>" /><br />

	<!-- Email Name-->
	<label for="email">Email:</label><br />
	<input type="text" id="email" name="email" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $email  ?>" /><br />

	<!-- Password Name-->
	<label for="password">Password:</label><br />
	<input type="password" id="password" name="password" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $password  ?>" /><br />


	<!-- Button to submit form-->
	<input type="submit" value="Submit" /><br />
	<a href="index.php"> Login </a>
</form><!-- End form-->
</html><!-- End html-->

