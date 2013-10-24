<?php
require 'core.inc.php';
require 'connect.inc.php';
if(cookielogin()){
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" title="Basic Noise" media="all" />
	<title>Register Success - Delightful Dates</title>
</head>

<body>

<div id="container980">
<br<br><br>
	<div id="menu"> 
		<ul>
			<li><a href="index.php">Home</a></li>
		</ul>
	</div>

	<div id="feature"><img src="zhomepic.png" alt="Sample header image" />
		<div id="main">
			<div id="content">
					<h2>Registration Success!</h2><br>
					<h3>Now <a href="index.php">log in</a> and go to my account to fill out more info for your profile</h3>
					<br>
				<br>
				<div class="left">	 

				</div>
				<div class="right">
					<br>
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