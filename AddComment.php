<?php
session_start();
echo "Logged in as: ".$_SESSION["Login"];
// Connects to database
$db = new PDO('mysql:host=localhost;dbname=bookclub', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);


if($_SERVER['REQUEST_METHOD']=='POST'){
	$comment=$_POST['comment'];
	$bookID=$_POST['bookID'];
	$memberID=$_POST['memberID'];


	$sql = "INSERT INTO BookReviews (reviewComments,commentDateTime,Books_bookID,Members_memberID) VALUES (:comment,CURRENT_TIMESTAMP,:bookID,:memberID)";

	$stmt = $db-> prepare($sql);
	$stmt-> execute(['comment'=>$comment,'bookID'=>$bookID,'memberID'=>$memberID]);
	$comment="";
	$bookID="";
	$memberID="";
	echo "Comment has been added";
}

?><!-- End php-->

<html>
<head>
	<link rel="stylesheet" href="StyleSheet1.css" />
	<script>

					function validateForm() {
						let comment = document.forms["comment"]["comment"].value;
						let bookid = document.forms["comment"]["bookID"].value;
						let memberid = document.forms["comment"]["memberID"].value;
						var result = "";
						var first = -1;
						if (comment == "") {
							first++;
							if (first == 0) {
								result = result + "Comment";
							}
							else {
										result = result + ", comment";
							}

						}
								if (bookid == "") {
										 first++;
							if (first == 0) {
								result = result + "BookID";
							}
							else {
										result = result + ", bookID";
							}
						}
						if (memberid == "") {
										 first++;
							if (first == 0) {
								result = result + "MemberID";
							}
							else {
										result = result + ", memberID";
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
<form name="comment" onsubmit="return validateForm()" method="post">

	<!-- New book-->
	<label for="comment">Comment:</label><br />
	<input type="text" id="comment" name="comment" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $comment  ?>" /><br />

	<label for="bookID">Book ID:</label><br />
	<input type="text" id="bookID" name="bookID" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $bookID  ?>" /><br />

	<label for="memberID">Your ID:</label><br />
	<input type="text" id="memberID" name="memberID" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $memberID ?>" /><br />


	<!-- Button to submit form-->
	<input type="submit" value="Submit" /><br />
	<a href="YourBooks.php"> Book List </a>
</form><!-- End form-->
</html><!-- End html-->

