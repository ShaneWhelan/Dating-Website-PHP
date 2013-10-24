<?php
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
	<title>About Us</title>
</head>

<body>

<div id="container980">
<br><br><br>
		<div id="menu"> 
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="contactus.php">Contact Us</a></li>
				<li><a class="current" href="aboutus.php">About Us</a></li>
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
				<div class="left">
				</div>

				<div class="right">	 
				</div>
			</div>
			<div class="clear">
			</div>
			
		</div>
			
	</div>
	<div id="footer">
		<p>&copy;
		<?php 
		$copy_year = 2012; 
		$current_year = date('Y'); 
		if($copy_year == $current_year){
			echo $copy_year;
		}else{
			echo $copy_year .'-' . $current_year;
		}
		?>
		Group 5</p>
	</div>
</div>
</body>
</html>