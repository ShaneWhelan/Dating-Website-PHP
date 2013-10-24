<?php
require 'core.inc.php';
require 'connect.inc.php';
if(!cookielogin()){
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" title="Basic Noise" media="all" />
	<title>Messages - Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>     
			<li><a href="profile.php">Profile</a></li>
			<li><a href="matches.php">Matches</a></li>
			<li><a href="allusers.php">All Users</a></li>
			<li><a href="search.php">Search</a></li>
			<li><a class="current" href="message.php">Message</a></li>
			<li><a href="account.php">My Acount</a></li>
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
				<h3><a class="selected" href="message.php">Compose</a></h3><br>
				<h3><a href="inbox.php">Inbox</a></h3><br>
				<h3><a href="sent.php">Sent Messages</a></h3>
				</div>
				<div class="right">
					<form action="message.php" method="POST">
						<br>
						<?php
						if(isset($_GET['usernameto'])){
							$usernameto = $_GET['usernameto'];
						}
						
						?>
						<h2>Recipient:</h2>
						<input type="text" name="usernameto" maxlength="10" value="<?php echo $usernameto; ?>">
						<br><br>
						<h2>Message:</h2>
						(255 characters max)
						<textarea name="message" rows="7" cols="40" maxlength="255"></textarea>
						<input type="submit" value="Send Message">
					</form>   
					<?php
						//Checks if the fields have been set and if the user isnt sending a message to themselves.
						if(isset($_POST['usernameto']) && isset($_POST['message'])){
							$username = $_COOKIE["user"];
							$usernameto = $_POST['usernameto'];
							if($usernameto != $username){
								$query_username = "SELECT * from userprivate where username = '".mysql_real_escape_string($usernameto)."'";
								$query_username_run = mysql_query($query_username);
								if(mysql_num_rows($query_username_run) > 0){
									$message = $_POST['message'];
									if(!empty($usernameto) && !empty($message) && $usernameto != $username){
										$query = "INSERT INTO usermessages (messagetext, usernamefrom, usernameto)
										VALUES ('".mysql_real_escape_string($message)."','".mysql_real_escape_string($username)."','".mysql_real_escape_string($usernameto)."')";
										if($query_run = mysql_query($query)){
											echo '<font color="006600">Message Sent!</font>';
										}else{
											echo '<font color="crimson"><br>Message not sent</font>';
										}
									}else{
										
									}
								}else{
									echo '<font color="crimson"><br>Fields are empty</font>';
								}
							}else{
								echo '<font color="crimson"><br>Ah now, you can\'t sent a message to yourself!</font>';
							}
						}
					?>
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