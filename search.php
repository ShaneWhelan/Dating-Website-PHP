<?php
require 'connect.inc.php';
require 'core.inc.php';
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
	<title>Search - Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>     
			<li><a  href="profile.php">Profile</a></li>
			<li><a  href="matches.php">Matches</a></li>
			<li><a href="allusers.php">All Users</a></li>
			<li><a class="current" href="search.php">Search</a></li>
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
					<h3>Search by Username</h3>
					<form action = "search.php" method = "POST">
					<input type="text" name="search_query" />
					<br>
					<input type="submit" value="Search">
					</form>
					<br>

					<?php
						$your_username = $_COOKIE["user"];
						if(isset($_POST['search_query'])){
							$search_query = $_POST['search_query'];
							if(!empty($search_query)){
								if(strlen($search_query) >= 3){
									$query = "SELECT username FROM userpublic where username LIKE '%".mysql_real_escape_string($search_query)."%' AND username <> '$your_username'";
									$query_run = mysql_query($query);
									$query_num_rows = mysql_num_rows($query_run);
									if($query_num_rows > 1){
										echo '<font color="006600">'.$query_num_rows.' results found:</font><br><br>';
										//Loop through array of users.
										while($query_row = mysql_fetch_assoc($query_run)){
											$username = $query_row['username'];
											echo '<a href="dynamicprofile.php?username='.$username.'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
											//echo '<a href="dynamicprofile.php?username='.$username.'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
											echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$username.'">'.$username.'</a><br><br>';
										}
									}else if($query_num_rows == 1){
										echo '<font color="006600">'.$query_num_rows.' result found:</font><br>';
										while($query_row = mysql_fetch_assoc($query_run)){
											$username = $query_row['username'];
											echo '<a href="dynamicprofile.php?username='.$username.'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
											//echo '<a href="dynamicprofile.php?username='.$username.'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
											echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$username.'">'.$username.'</a><br>';
										}
									}else{
										echo '<font color="crimson">No results found</font>';
									}
								}else{
									echo '<font color="crimson">Your keyword must be 3 characters or more</font>';
								}
							}else{
								echo '<font color="crimson">Enter a search term</font>';
							}
						}
						
					?>
					<br><br><br><br><br><br><br><br><br>
				</div>
				<div class="right">
				<h3>Search by Age</h3>
					<form action = "search.php" method = "POST">
					<select name="search_query_age">
					<option value="">Please Select</option>
					<option value="18">Ages 18 to 23</option>
					<option value="23">Ages 23 to 28</option>
					<option value="28">Ages 28 to 33</option>
					<option value="33">Ages 33 to 38</option>
					<option value="38">Ages 38 to 43</option>
					<option value="43">Ages 43 to 48</option>
					<option value="50">Ages 50+</option>		
					</select>
					<br>
					<input type="submit" value="Search">
					</form>
					<?php
						if(isset($_POST['search_query_age'])){
							$query_age = $_POST['search_query_age'];
							if(!empty($query_age)){
								if($query_age == 50){
									$query_age_five  = 90;
								}else{
									$query_age_five  = $query_age + 5;
								}
								$date_lower = date("Y-m-d",time() - ($query_age_five * 365 * 24 * 60 * 60));
								$date_upper = date("Y-m-d",time() - ($query_age * 365 * 24 * 60 * 60));
								$query = "SELECT username FROM userprivate WHERE dob >= '$date_lower' AND dob <= '$date_upper'  AND username <> '$your_username'";
								$query_run = mysql_query($query);
								$query_num_rows = mysql_num_rows($query_run);
								if($query_num_rows > 1){
									$current_year = date("Y");
									echo '<font color="006600">'.$query_num_rows.' results found:</font><br><br>';
									while($query_row = mysql_fetch_assoc($query_run)){											
										$username = $query_row['username'];
										echo '<a href="dynamicprofile.php?username='.$username.'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
										//echo '<a href="dynamicprofile.php?username='.$username.'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
										echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$username.'">'.$username.'</a><br><br>';
									}
								}else if($query_num_rows == 1){
									echo '<font color="006600">'.$query_num_rows.' result found:</font><br>';
									while($query_row = mysql_fetch_assoc($query_run)){
										$username = $query_row['username'];
										echo '<a href="dynamicprofile.php?username='.$username.'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
										//echo '<a href="dynamicprofile.php?username='.$username.'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
										echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$username.'">'.$username.'</a><br>';
									}
								}else{
									echo '<font color="crimson">No results found</font>';
								}
							}else{
								echo '<font color="crimson">Enter a search term</font>';
							}
						}
					?>
					<br><br><br><br><br>
					
					<h3>Search by Interest</h3>
					<form action = "search.php" method = "POST">
					<input type="text" name="search_interest" />
					<br>
					<input type="submit" value="Search">
					</form>
					<br>

					<?php
						if(isset($_POST['search_interest'])){
							$search_interest = $_POST['search_interest'];
							if(!empty($search_interest)){
								if(strlen($search_interest) >= 2){
									$query_interest = "SELECT DISTINCT username FROM interestresponses a, userinterestanswers b 
									WHERE a.iresponse LIKE '%".mysql_real_escape_string($search_interest)."%' AND a.iresponseid = b.iresponseid  AND username <> '$your_username'";
									$query_run_interest = mysql_query($query_interest);
									$query_num_rows_interest = mysql_num_rows($query_run_interest);
									if($query_num_rows_interest > 1){
										echo '<font color="006600">'.$query_num_rows_interest.' results found:</font><br><br>';		
									}else if($query_num_rows_interest == 1){
										echo '<font color="006600">'.$query_num_rows_interest.' result found:</font><br>';
									}else{
										echo '<font color="crimson">No results found</font>';
									}
									
									while($query_row_interest = mysql_fetch_assoc($query_run_interest)){
										$username_found = $query_row_interest['username'];
										echo '<a href="dynamicprofile.php?username='.$username_found.'"><img src="imagefinder.php?username='.$username_found.'" height="100" width="100" style="float:left;" /></a><br>';
										//echo '<a href="dynamicprofile.php?username='.$username_found.'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
										echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$username_found.'">'.$username_found.'</a><br><br>';
									}
								}else{
									echo '<font color="crimson">Your keyword must be 2 characters or more</font>';
								}
							}else{
								echo '<font color="crimson">Enter a search term</font>';
							}
						}
					?>
					<br><br><br><br><br><br><br><br><br>
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