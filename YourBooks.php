<?php
$db = new PDO('mysql:host=localhost;dbname=bookclub', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

session_start();
echo "Logged in as: ".$_SESSION["Login"];
$_SESSION["ID"]=$Email;

if($_SERVER['REQUEST_METHOD']=='POST'){
	$bookTitle=$_POST['bookID'];
	$returnID=$_POST['returnID'];
	
	if ($returnID == ""){
		$sql = "INSERT INTO booksborrowed (borrowedDate,Books_bookID) VALUES (CURRENT_TIMESTAMP,:bookID)";

		$stmt = $db-> prepare($sql);
		$stmt-> execute(['bookID'=>$bookTitle]);


		$sql2 = "UPDATE books SET bookBorrowed=1 where bookID = :bookID ";

		$stmt2 = $db-> prepare($sql2);
		$stmt2-> execute(['bookID'=>$bookTitle]);

		$bookTitle="";

		echo " Book has been Borrowed";
	}
	else{
		$sql2 = "UPDATE books SET bookBorrowed=0 where bookID = :returnID ";

		$stmt2 = $db-> prepare($sql2);
		$stmt2-> execute(['returnID'=>$returnID]);
		$returnID="";
		echo " Book has been returned";
	}
}

?><!-- End Php-->
<html>
<head>
	<link rel="stylesheet" href="StyleSheet1.css" />
</head>
<header>
	<h1 > List of Books</h1>
	<a href="AddComment.php">Add a comment </a>
	<header>
		<!-- End header-->

		<body>
			

			<!-- Table to show sports -->
			<table>

		
				<?php
				// Connects to database
				$db = new PDO('mysql:host=localhost;dbname=bookclub', 'root', 'root');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
				// Gets infromation from database
				$stmt = $db ->query('SELECT bookTitle,authorFirstname,authorLastname, publishedYear,bookBorrowed,bookCoverImage,bookID FROM books');
				$books=$stmt->fetchAll(PDO::FETCH_ASSOC);
				// Prints information taken from above

				foreach($books as $book){
					//echo $book['bookCoverImage
					echo "<div><h3>".$book['bookTitle']."[".$book['bookID']."]</h3> <p>". $book['authorFirstname']." ". $book['authorLastname']."<br> ".$book['publishedYear']."<br><img src=\"". $book['bookCoverImage'] ."\" style=\" width: 200px; height: 300px;\"><br>";


					//SELECT firstname FROM members WHERE memberID in (SELECT Members_memberID from bookreviews)
					$stmt2 = $db ->query('SELECT reviewComments, commentDateTime, Members_memberID, Books_bookID from BookReviews');
					$books2=$stmt2->fetchAll(PDO::FETCH_ASSOC);
					$stmt3 = $db ->query('SELECT firstname,memberID FROM members');
					$books3=$stmt3->fetchAll(PDO::FETCH_ASSOC);
					if($book['bookBorrowed']==0){

						echo ("Available");
					}
					else{
						echo ("Not Available");
					}
					echo "<h4> Comments </h4>";
					foreach($books2 as $book2){
						if ($book2['Books_bookID'] == $book['bookID']){
							foreach ($books3 as $book3){
								if($book3['memberID']==$book2['Members_memberID']){
									echo "<p>[".$book2['commentDateTime']."] ".$book3['firstname'].": ".$book2['reviewComments']."</p>";
								}

							}



						}

					}
					echo "</div>";

				}


				?>
			</table><!-- End table-->
			<form  method="post">

				<!-- New book-->
				<label for="bookID">Enter BookID to borrow Book:</label><br />
				<input type="text" id="bookID" name="bookID" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $bookID  ?>" /><br />

				<input type="submit" value="Submit" /><br />
			</form><!-- End form-->
			<form method="post">

				<!-- New book-->
				<label for="returnID">Enter BookID to Return Book:</label><br />
				<input type="text" id="returnID" name="returnID" value="<?php if ($_SERVER['REQUEST_METHOD']=='POST')echo $returnID  ?>" /><br />

				<input type="submit" value="Submit" /><br />
			</form><!-- End form-->
			<!--- Take in user email to check if already used-->
			<br /><label for="Book">Add Book:</label>
			<a href="NewBook.php">New Book </a>
			<br /><a href="index.php">Login </a>
		</body><!-- End body-->

</html><!-- End Html-->