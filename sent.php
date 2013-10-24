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
	<title>Sent - Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>     
			
			<li><a  href="profile.php">Profile</a></li>
			<li><a  href="matches.php">Matches</a></li>
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
					<h3><a href="message.php">Compose</a></h3><br>
					<h3><a href="inbox.php">Inbox</a></h3><br>
					<h3><a class="selected" href="sent.php">Sent Messages</a></h3>	
				</div>

				<div class="right">
					<?php
					$username = $_COOKIE["user"];
					$query_inbox = "SELECT usernameto, messagetext FROM usermessages WHERE usernamefrom = '".mysql_real_escape_string($username)."'";
					$query_inbox_run = mysql_query($query_inbox);
					if(mysql_num_rows($query_inbox_run) > 0){
						while($query_inbox_array= mysql_fetch_assoc($query_inbox_run)){
							$usernameto = $query_inbox_array['usernameto'];
							$messagetext = $query_inbox_array['messagetext'];
							echo "<h2>$usernameto :</h2>$messagetext";
						}
					}else{
						echo '<font color="crimson">No messages</font>';
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