<?php
require 'connect.inc.php';
require 'core.inc.php';
if(!cookielogin()){
	header('Location: index.php');
}
if (isset($_GET['username'])){
	if(!empty($_GET['username'])){
		$username = $_GET['username'];
	}
}
?>

<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" title="Basic Noise" media="all" />
	<title>Profile - Delightful Dates</title>
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
			<h2><?php echo $username;?></h2>
			<div id="content">
				<br>
				<div class="left">
					<br>
					<?php
						echo '<img src="imagefinder.php?username='.$username.'" height="50%" width="50%" style="float:left;"/>';
						//echo '<img src="profile.jpg" height="50%" width="50%" style="float:left;"/>';
					?>
					<br><br><br><br><br><br><br><br><br><br><br><br><br>
					<?php
						echo '<h3><a class="selected" href="message.php?usernameto='.$username.'" style="float:left;">Message '.$username.'</a></h3>';
					?>
				</div>

				<div class="right">
					<h3>Basic Details:</h3>
					<br>
					<strong>Firstname:</strong>
					<?php
						//Display users basic details.
						$query = "SELECT * FROM userpublic where username='".mysql_real_escape_string($username)."'";
						$query_run = mysql_query($query);
						//Get all users info and store in an associative array.
						while($query_data = mysql_fetch_assoc($query_run)){
							$firstname = $query_data['firstname'];
							$gender = $query_data['gender'];
							$orientation = $query_data['orientation'];
							$about = $query_data['about'];
							$county = $query_data['county'];
							$occupation = $query_data['occupation'];
						}
						echo $firstname;
					?>
					
					<br>
					<strong>Gender:</strong>
					<?php
						if($gender == 'm'){
							echo 'Male';
						}else{
							echo 'Female';
						}
					?>
					<br>
					<strong>Orientation:</strong>
					<?php
						if($orientation == 's'){
							echo 'Straight';
						}else if($orientation == 'g'){
							echo 'Gay';
						}else{
							echo 'Anything Goes!';
						}
					?>
					<br>
					<strong>About Me:</strong>
					<?php
						echo $about;
					?>
					<br>
					<strong>County:</strong>
					<?php
						echo $county;
					?>
					<br>
					<strong>Occupation:</strong>
					<?php
						echo $occupation;
					?>
					<br><br>
					<h3>Attriutes:</h3>
					<?php
						//Load in list of Attribute Questions and Answers.
						$query_questions = "SELECT * FROM attributequestions";
						$query_run_questions = mysql_query($query_questions);
						while($query_row_questions = mysql_fetch_assoc($query_run_questions)){
							$question = $query_row_questions['aquestion'];
							echo '<br><strong>'.$question.'</strong><br>';
							$attributeid = $query_row_questions['attributeid'];
							$query_answers = "SELECT a.aresponse FROM attributeresponses a, userattributeanswers u
							WHERE u.username = '".mysql_real_escape_string($username)."' AND a.attributeid='".mysql_real_escape_string($attributeid)."' AND a.aresponseid=u.aresponseid";
							$query_run_answers = mysql_query($query_answers);
							while($query_row_answers = mysql_fetch_assoc($query_run_answers)){
								echo $query_row_answers['aresponse'];
							}
						}
					?>
					
					<br><br>
					<h3>Interests:</h3>
					<?php
						//Load in list of Interest Questions and Answers.
						$query_questions_interest = "SELECT * FROM interestquestions";
						$query_run_interest = mysql_query($query_questions_interest);
						while($query_row_questions_interest = mysql_fetch_assoc($query_run_interest)){
							$question_interest = $query_row_questions_interest['iquestion'];
							echo '<br><strong>'.$question_interest.'</strong><br>';
							$interestid_interest = $query_row_questions_interest['interestid'];
							$query_answers_interest = "SELECT a.iresponse FROM interestresponses a, userinterestanswers u
							WHERE u.username = '".mysql_real_escape_string($username)."' AND a.interestid='".mysql_real_escape_string($interestid_interest)."' AND a.iresponseid=u.iresponseid";
							$query_run_answers_interest = mysql_query($query_answers_interest);
							while($query_row_answers_interest = mysql_fetch_assoc($query_run_answers_interest)){
								echo $query_row_answers_interest['iresponse'];
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