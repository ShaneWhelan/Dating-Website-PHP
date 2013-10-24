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
	<title>All Users- Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="matches.php">Matches</a></li>
			<li><a class="current" href="allusers.php">All Users</a></li>
			<li><a href="search.php">Search</a></li>
			<li><a href="message.php">Message</a></li>
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
				<div class="left">	
					<h3>List of all Users</h3>
					<br>
					<?php
						$username = $_COOKIE["user"];
						$query = "SELECT username FROM userpublic WHERE NOT username = '".mysql_real_escape_string($username)."'";
						$query_run = mysql_query($query);
						$query_num_rows = mysql_num_rows($query_run);
						//Display a list of all users.
						if($query_num_rows > 1){
							echo '<font color="006600">'.$query_num_rows.' results found:</font><br><br>';
							while($query_row = mysql_fetch_assoc($query_run)){
								$username = $query_row['username'];
								echo '<a href="dynamicprofile.php?username='.$query_row['username'].'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
								//echo '<a href="dynamicprofile.php?username='.$query_row['username'].'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
								echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$query_row['username'].'">'.$query_row['username'].'</a><br><br>';
							}
						}else if($query_num_rows == 1){
							echo '<font color="006600">'.$query_num_rows.' result found:</font><br>';
							while($query_row = mysql_fetch_assoc($query_run)){
								$username = $query_row['username'];
								echo '<a href="dynamicprofile.php?username='.$query_row['username'].'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
								//echo '<a href="dynamicprofile.php?username='.$query_row['username'].'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
								echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$query_row['username'].'">'.$query_row['username'].'</a><br>';
							}
						}else{
							echo '<font color="crimson">No results found</font>';
						}
					?>
					
					<br><br><br><br><br><br><br><br><br>
				</div>
				<div class="right">
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