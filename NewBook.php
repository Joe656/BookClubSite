<?php
session_start();
echo "Logged in as: ".$_SESSION["Login"];
// Connects to database
$db = new PDO('mysql:host=localhost;dbname=bookclub', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


if($_SERVER['REQUEST_METHOD']=='POST'){
	$bookTitle=$_POST['bookTitle'];
	$authorFirstname=$_POST['authorFirstname'];
	$authorLastname=$_POST['authorLastname'];
    $publishedYear=$_POST['publishedYear'];
    $Members_memberID=$_POST['Members_memberID'];
	$bookCoverImage=$_POST['bookCoverImage'];

	$sql = "INSERT INTO books (bookTitle,authorFirstname,authorLastname,publishedYear,Members_memberID,bookBorrowed,bookCoverImage) VALUES (:bookTitle,:authorFirstname,:authorLastname,:publishedYear,:Members_memberID,0,:bookCoverImage)";

	$stmt = $db-> prepare($sql);
	$stmt-> execute(['bookTitle'=>$bookTitle,'authorFirstname'=>$authorFirstname,'authorLastname'=>$authorLastname,'publishedYear'=>$publishedYear,'Members_memberID'=>$Members_memberID,'bookCoverImage'=>$bookCoverImage]);

	$bookTitle="";
	$authorFirstname="";
	$authorLastname="";
    $publishedYear="";
    $Members_memberID="";
	echo "Book has been added";
}

?><!-- End php-->

<html>
<head>
	<link rel="stylesheet" href="StyleSheet1.css" />
	<script>

					function validateForm() {
						let book = document.forms["newBook"]["bookTitle"].value;
						let authorfname = document.forms["newBook"]["authorFirstname"].value;
						let auhtorlname = document.forms["newBook"]["authorLastname"].value;
						let pubyear = document.forms["newBook"]["publishedYear"].value;
						let memberID = document.forms["newBook"]["Members_memberID"].value;
						let coverimage = document.forms["newBook"]["bookCoverImage"].value;

						var result = "";
						var first = -1;
						if (book == "") {
							first++;
							if (first == 0) {
								result = result + "Book";
							}
							else {
										result = result + ", book";
							}

						}
								if (authorfname == "") {
										 first++;
							if (first == 0) {
								result = result + "Author First name";
							}
							else {
										result = result + ", author first name";
							}
						}
								if (auhtorlname == "") {
										 first++;
							if (first == 0) {
								result = result + "Author Last name";
							}
							else {
										result = result + ", auhtor last name";
							}
						}
								if (pubyear == "") {
										first++;
							if (first == 0) {
								result = result + "Publication Year";
							}
							else {
										result = result + ", publication year";
							}
						}
								if (memberID == "") {
										first++;
							if (first == 0) {
								result = result + "MemberID";
							}
							else {
										result = result + ", memberID";
							}
						}
								if (coverimage == "") {
										first++;
							if (first == 0) {
								result = result + "CoverImage";
							}
							else {
										result = result + ", coverimage";
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
<form name="newBook" onsubmit="return validateForm()"  method="post" >

	<!-- New book-->
	<label for="book">Book:</label><br />
	<input type="text" id="bookTitle" name="bookTitle" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $bookTitle  ?>" /><br />

	<label for="authorFirstname">Author FirstName:</label><br />
	<input type="text" id="authorFirstname" name="authorFirstname" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $authorFirstname  ?>" /><br />

	<label for="authorLastname">Author LastName:</label><br />
	<input type="text" id="authorLastname" name="authorLastname" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $authorLastname  ?>" /><br />

	<label for="publishedYear">Publication Year:</label><br />
	<input type="text" id="publishedYear" name="publishedYear" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $publishedYear  ?>" /><br />

	<label for="Members_memberID">Member ID:</label><br />
	<input type="text" id="Members_memberID" name="Members_memberID" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $Members_memberID  ?>" /><br />

	<label for="bookCoverImage">Cover image:</label><br />
	<input type="file" id="bookCoverImage" name="bookCoverImage" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $bookCoverImage  ?>" /><br />

	<!-- Button to submit form-->
	<input type="submit" value="Submit" /><br />
	<a href="YourBooks.php"> Book List </a>
</form><!-- End form-->
</html><!-- End html-->

