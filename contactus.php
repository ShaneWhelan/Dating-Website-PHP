<?php
//Sending mail is disabled on the college server
require 'core.inc.php';
require 'connect.inc.php';

?>
<!DOCTYPE html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="Thomas Ryan / Original design by tomtomwebdesign.com" />
	<link rel="stylesheet" type="text/css" href="style.css" title="Basic Noise" media="all" />
	<title>Contact Us - Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>
			<li><a  href="index.php">Home</a></li>
			<li><a class="current" href="contactus.php">Contact Us</a></li>
			<li><a href="aboutus.php">About Us</a></li>
			<?php
			if(cookielogin()){
				echo "<li><a href=\"logout.php\">Log out</a></li>";
			}
			?>
		</ul>
	</div>
	<div id="feature"><img src="zhomepic.png" alt="Sample header image" />
		<div id="main">
			<div id="content">
				<br>
				<div class="left">			
				<p>We are constantly striving to make Delightful Dates even more delightful for our users.</p>
				<p>We fully encourage all members to contact our customer support team if they have any issues, suggestions or questions in general. We believe that it is this approach to customer service that has made Delightful Dates the number one online dating service in the world. </p>
				<p>We look forward to hearing from you</p>
				</div>
				<div class="right">
					<form action="" method="POST">
					<br>
					Got a query? Send us a message
					<br>
					<input type="text" name="userfrom">
					<br>
					<br>
					Enter a subject
					<br>
					<input type="text" name="password">
					<br>
					<br>
					Write your message
					<br>
					<textarea name="messagetext" rows="10" cols="40"></textarea>
					<input type="submit" value="Send Message">
					</form>  
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
	</div>
	<div id="footer">
		
		<p>&copy;<?php 
		$copy_year = 2012; 
		$current_year = date('Y'); 
		if($copy_year == $current_year){
			echo $copy_year;
		}else{
			echo $copy_year .'-' . $current_year;
		}
		?> Group 5</p>
	</div>
</div>
</body>
</html>
