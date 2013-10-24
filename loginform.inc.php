<!DOCTYPE html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" title="Basic Noise" media="all" />
	<title>Login - Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>
			<li><a  href="index.php">Home</a></li>
			<li><a  href="contactus.php">Contact Us</a></li>
			<li><a href="aboutus.php">About Us</a></li>
		</ul>
	</div>
	
	<div id="feature"><img src="zhomepic.png" alt="Sample header image" />
		<div id="main">
			<div id="content">
				<br>


				<div class="left">			
					<form action="<?php echo $current_file; ?>" method="POST">
					Username: <br><input type="text" name ="username"> <br><br>
					Password: <br><input type="password" name="password"><br><br>
					<input type="submit" value="Log in">
					</form>
					<br>
					<br>
					<?php
					if(isset($_POST['username']) && isset($_POST['password']) ){
						$username = $_POST['username'];
						$password = $_POST['password'];
						$password_hash = md5($password);
						if(!empty($username) && !empty($password)){
								$query = "SELECT username FROM authentication WHERE username='".mysql_real_escape_string($username)."' AND password='".mysql_real_escape_string($password_hash)."'";
								if($query_run = mysql_query($query)){
									$query_num_rows = mysql_num_rows($query_run);
									if($query_num_rows == 0){
										echo '<font color="crimson">Username or Password not recognised</font>';
									}else if($query_num_rows == 1){
										$username = mysql_result($query_run, 0, 'username');
										$expire=time()+60*60*24*30;
										setcookie("user", $username, $expire);
										header('Location: index.php');
									}
								}
						}else{
							echo '<font color="crimson">No user or pass given</font>';
						}
					}
					?>
				
				</div>

				<div class="right">
					<br><br>Not a member? <a href="register.php">Register</a>
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