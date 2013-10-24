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
	<title>Matches - Delightful Dates</title>
</head>

<body>
<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>
			<li><a href="profile.php">Profile</a></li>
			<li><a class="current" href="matches.php">Matches</a></li>
			<li><a href="allusers.php">All Users</a></li>
			<li><a href="search.php">Search</a></li>
			<li><a href="message.php">Message</a></li>
			<li><a  href="account.php">My Acount</a></li>
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

					<?php
						
						$username = $_COOKIE["user"];
						$orientation_query = "SELECT orientation, gender FROM userpublic WHERE
						username='".mysql_real_escape_string($username)."'";
						$orientation_query_run = mysql_query($orientation_query);
						$orientation_array= mysql_fetch_assoc($orientation_query_run);
						$orientation = $orientation_array['orientation'];
						$gender = $orientation_array['gender'];	
						//Now that we have the current users gender, lets match them only to people they would be interested in.
						if($orientation == 's' && $gender == 'm'){
							$query_answers_interest = "SELECT * 
							FROM userinterestanswers a, userinterestanswers b, userpublic c
							WHERE a.interestid=b.interestid AND a.iresponseid = b.iresponseid 
							AND a.username = '".mysql_real_escape_string($username)."' AND NOT b.username='".mysql_real_escape_string($username)."' 
							AND c.gender = 'f' AND b.username = c.username AND (c.orientation = 's' OR c.orientation = 'b')
							ORDER BY b.username";
						}else if ($orientation == 's' && $gender == 'f'){
							$query_answers_interest = "SELECT * 
							FROM userinterestanswers a, userinterestanswers b, userpublic c
							WHERE a.interestid=b.interestid AND a.iresponseid = b.iresponseid  
							AND a.username = '".mysql_real_escape_string($username)."' AND NOT b.username='".mysql_real_escape_string($username)."' 
							AND c.gender = 'm' AND b.username = c.username AND (c.orientation = 's' OR c.orientation = 'b')
							ORDER BY b.username";
						}else if ($orientation == 'g' && $gender == 'm'){
							$query_answers_interest = "SELECT * 
							FROM userinterestanswers a, userinterestanswers b, userpublic c
							WHERE a.interestid=b.interestid AND a.iresponseid = b.iresponseid 
							AND a.username = '".mysql_real_escape_string($username)."' AND NOT b.username='".mysql_real_escape_string($username)."' 
							AND c.gender = 'm' AND b.username = c.username AND (c.orientation = 'g' OR c.orientation = 'b')
							ORDER BY b.username";
						}else if ($orientation == 'g' && $gender == 'f'){
							$query_answers_interest = "SELECT * 
							FROM userinterestanswers a, userinterestanswers b, userpublic c
							WHERE a.interestid=b.interestid AND a.iresponseid = b.iresponseid 
							AND a.username = '".mysql_real_escape_string($username)."' AND NOT b.username='".mysql_real_escape_string($username)."' 
							AND c.gender = 'f' AND b.username = c.username AND (c.orientation = 'g' OR c.orientation = 'b')
							ORDER BY b.username";
						}else if($orientation == 'b' && $gender == 'f'){
							$query_answers_interest = "SELECT * 
							FROM userinterestanswers a, userinterestanswers b, userpublic c
							WHERE a.interestid = b.interestid
							AND a.iresponseid = b.iresponseid
							AND a.username =  '".mysql_real_escape_string($username)."'
							AND NOT b.username =  '".mysql_real_escape_string($username)."'
							AND b.username = c.username
							AND	((c.gender =  'f' AND (	c.orientation =  'g' OR c.orientation =  'b'))
							OR (c.gender =  'm' AND (c.orientation =  's' OR c.orientation =  'b'))) ORDER BY b.username";
						}else if($orientation == 'b' && $gender == 'm'){
							$query_answers_interest = "SELECT * 
							FROM userinterestanswers a, userinterestanswers b, userpublic c
							WHERE a.interestid = b.interestid
							AND a.iresponseid = b.iresponseid
							AND a.username =  '".mysql_real_escape_string($username)."'
							AND NOT b.username = '".mysql_real_escape_string($username)."'
							AND b.username = c.username
							AND	((c.gender =  'f' AND (	c.orientation =  's' OR c.orientation =  'b'))
							OR (c.gender =  'm' AND (c.orientation =  'g' OR c.orientation =  'b'))) ORDER BY b.username";
						}
						
						$query_run_answers_interest = mysql_query($query_answers_interest);
						if(mysql_num_rows($query_run_answers_interest) > 0){
						?>
						<h3>The best matches we found for you:</h3>
						<?php
							//Count variable keeps track of the number of matches
							$count = 1;
							$search_query = array();
							//Loop through array of results from the query for users to match.
							while($query_row_answers_interest = mysql_fetch_assoc($query_run_answers_interest)){
								$username_matched = $query_row_answers_interest['username'];
								if(array_key_exists($username_matched, $search_query)){
									$count++;
								}else{
									$count = 1;
								}
								// ${$username_matched.$count} = $query_row_answers_interest;
								$search_query[$username_matched] = $count;
								$reason_matched[] = $query_row_answers_interest['interestid'];
								//$reason_matched_response[]= $query_row_answers_interest['iresponseid'];
							}						
							$questionnum = 0;
							$reason_index = 0;
							//Loop through list of Usernames (Keys) and the number of questions matched (Values).
							foreach($search_query as $key => $value){
								$username = $key;
								//Total number of questions
								$questionnum = $value + $questionnum;									
								if($search_query[$username_matched] > 1){
									echo '<strong>Matched based on your answers for '.$search_query[$username_matched].' questions:</strong><br>';
								}else{
									echo '<strong>Matched based on your answer for '.$search_query[$username_matched].' question:</strong><br>';
								}
								while($reason_index < $questionnum){
									$query_questions = "SELECT iquestion FROM interestquestions WHERE interestid = '".mysql_real_escape_string($reason_matched[$reason_index])."'";
									$query_run_questions = mysql_query($query_questions);
									while($query_row_questions = mysql_fetch_assoc($query_run_questions)){
										$question = $query_row_questions['iquestion'];
										echo $question.'<br>';
									}
									$reason_index++;
								}
								$reason_index = $questionnum;
								echo '<a href="dynamicprofile.php?username='.$username.'"><img src="imagefinder.php?username='.$username.'" height="100" width="100" style="float:left;" /></a><br>';
								//echo '<a href="dynamicprofile.php?username='.$username.'"><img src="profile.jpg" height="100" width="100" style="float:left;" /></a><br>';
								echo '<br><br><br><br><br><br><a href="dynamicprofile.php?username='.$username.'">'.$username.'</a><br><br>';
									// }
								// }
							}
						}else{
					?>
					<h3>Fill out info in <strong><a href="account.php">My Account</a></strong> if you want to be matched to a potiental soulmate, We couldnt match you to anyone.</h3>
					<?php
						}
					?>
					<br>
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
