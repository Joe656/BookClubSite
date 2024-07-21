<?php
session_start();


// Connects to DB
$db = new PDO('mysql:host=localhost;dbname=bookclub', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
if($_SERVER['REQUEST_METHOD'] =='POST'){
	$Email= $_POST[ 'Email' ];
	
	$_SESSION["Login"]=$Email;
	$stmt=$db->prepare("SELECT * FROM membercredentials WHERE email=? ");
	$stmt->execute([$Email]);
	$info = $stmt->fetch();
	if($info){
		header("Location: YourBooks.php");
	}
	else{
		echo "That email was not found in the database";
	}
	
	
}
?>

<html>
<head>
<link rel="stylesheet" href="StyleSheet1.css" />
	<script>

					function validateForm() {
						let email = document.forms["login"]["Email"].value;
						let password = document.forms["login"]["Password"].value;
				
								
						var result = "";
						var first = -1;
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
	<header>

	<h1> Book Club</h1>
	</header><!-- End Header -->

	<body style=" text-align: center";><!-- Body of the Webpage-->
	<form name ="login" onsubmit="return validateForm()" action="" method="POST">
		<!--- Take in user email to check if already used-->
		<br /><label for="Email">Email:</label>
		<input type="text" id="Email" name="Email" /><br />

		<!--- Take in user Password to check if already used-->
		<br /><label for="Password">Password:</label>
		<input type="password" id="Password" name="Password" /><br />
		<br /><input type="submit" value="Login" /><br />
		
	</body><!-- End Body-->
 <a href="Registration Page.php"> Registration </a>
</html><!-- End Html-->
