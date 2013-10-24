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
	<title>Account - Delightful Dates</title>
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
			<li><a class="current" href="account.php">My Acount</a></li>
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
					 <h3>Change/Update Details:</h3>
					<form action="account.php" method="POST" enctype = "multipart/form-data"><br>
						Upload Profile Picture(JPEG or PNG):<br> 
						<input type="file" name="file"><br><br>
						<input type="submit" value = "Upload">
					</form>
					<br>
					<?php
						if (@$_FILES["file"]["error"] > 0){
							echo '<font color="crimson">No File selected</font>';
						}else{
							if(isset($_FILES["file"]["name"])){
								if (((@$_FILES["file"]["type"] == "image/png" ) || (@$_FILES["file"]["type"] == "image/jpeg") 
								|| (@$_FILES["file"]["type"] == "image/pjpeg")) && (@$_FILES["file"]["size"] < 10485760)){
									$username = $_COOKIE["user"];
									$fileName = $_FILES["file"]["name"]; // image file name
									$tmpName = $_FILES["file"]["tmp_name"]; // name of the temporary stored file name
									$fileSize = $_FILES["file"]["size"]; // size of the uploaded file
									$fileType = $_FILES["file"]["type"]; // file type

									$fp = fopen($tmpName, 'r'); // open a file handle of the temporary file
									$imgContent  = fread($fp, filesize($tmpName)); // read the temp file
									$imgContent = addslashes($imgContent);
									fclose($fp); // close the file handle
									
									$query_check = "SELECT * FROM userimages WHERE username='$username'";
									$query_check_run = mysql_query($query_check);
									if(mysql_num_rows($query_check_run) == 0){
										$query_public = "INSERT INTO userimages (username, imagename, imagetype, imagesize, imagedata)
										VALUES ('$username', '$fileName', '$fileType', '$fileSize', '$imgContent')";
									}else{
										$query_public = "UPDATE userimages 
										SET imagename='$fileName', imagetype='$fileType', imagesize='$fileSize', imagedata='$imgContent'
										WHERE username = '$username'";
									}
									if($query_public_run = mysql_query($query_public)){
										echo '<font color="006600">Successfully uploaded</font>';
									}else{
										echo '<font color="crimson"><br>Fail</font>';
									}
								}else{
									echo '<font color="crimson">Invalid file must be JPEG or PNG</font>';
								}
							}
						}
						
						?>
						<h3>Delete Account?</h3>
						<form action="account.php" method="POST" enctype = "multipart/form-data">
						<select name="delete">
						<option value="">--</option>
						<option value="y">Yes</option>
						</select>
						<input type="submit" value = "Delete">
						</form>
						<br>
						<?php
						
						$username = $_COOKIE["user"];
						if(isset($_POST['delete'])){
							if(!empty($_POST['delete'])){
								$query_ban = "DELETE FROM userprivate WHERE username='".mysql_real_escape_string($username)."'";
								$query_ban_run = mysql_query($query_ban);
								if(mysql_affected_rows() == 1){
									header('Location: logout.php');
								}else{
									echo '<font color="crimson"><br>User not found!</font>';
								}
							}else{
								echo '<font color="crimson"><br>Nothing Selected!</font>';
							}
						}
							
							$query = "SELECT admin FROM userprivate where username='".mysql_real_escape_string($username)."'";
							if($query_run = mysql_query($query)){
									$data = mysql_result($query_run, 0);
									if($data == "t"){
									?>
									<h3>Administration:</h3>
									<form action="account.php" method="POST" enctype = "multipart/form-data"><br>
										Username to ban:<br> 
										<input type="text" name="ban"><br><br>
										Username to promote to moderator:<br> 
										<input type="text" name="promote"><br><br>
										<input type="submit" value = "Submit">
									</form>
									
									<?php
									}
							}else{
								echo mysql_error();
							}
						
						if(isset($_POST['ban']) && isset($_POST['promote'])){
							echo '<font color="crimson"><br>You cant delete a user and promote them in one go!</font>';
						}else{
							if(isset($_POST['ban'])){
								if(!empty($_POST['ban'])){
									$username = $_POST['ban'];
									$query_ban = "DELETE FROM userprivate WHERE username='".mysql_real_escape_string($username)."'";
									$query_ban_run = mysql_query($query_ban);
									if(mysql_affected_rows() == 1){
										echo '<font color="006600">Successfully Deleted</font>';
									}else{
										echo '<font color="crimson"><br>User not found!</font>';
									}
								}else{
									echo '<font color="crimson"><br>Nothing entered!</font>';
								}
							}
							if(isset($_POST['promote'])){
								if(!empty($_POST['promote'])){
									$username = $_POST['promote'];
									$query_promote = "UPDATE userprivate SET admin='t' WHERE username='".mysql_real_escape_string($username)."'";
									$query_promote_run = mysql_query($query_promote);
									if(mysql_affected_rows() == 1){
										echo '<font color="006600">Successfully promoted</font>';
									}else{
										echo '<font color="crimson"><br>User not found!</font>';
									}
								}else{
									echo '<font color="crimson"><br>Nothing entered!</font>';
								}
							}
						}
					?>
					
					<br><br>
					<form action="account.php" method="POST" enctype = "multipart/form-data"><br>
					<h3>Credit Card Info:</h3>
					<strong>Your card will be charged &euro;50 for 3 months membership</strong><br><br>
					Current membership status:
					<?php	
						$username = $_COOKIE["user"];
						//Checks if users membership fees are paid
						if(checkmembership($username) == 1){
							echo '<font color="006600">Active</font>';	
						}else{
							echo '<font color="crimson">Inactive</font>';
						}
					?>
					<br>
					Cardholder Firstname:	<br><input type="text" maxlength="16" name = "cfirstname"><br><br>
					Cardholder Lastname:	<br><input type="text" maxlength="16" name = "clastname"><br><br>
					Card Number				<br><input type="text" maxlength="16" name = "card_number"><br><br>
					Expiry Month:			<br><input type="text" maxlength="2" name = "expiry_month"><br><br>
					Expiry Year:			<br><input type="text" maxlength="2" name = "expiry_year"><br><br>
					CVV Security Code:		<br><input type="text" maxlength="3"name = "CVV"><br><br>
					<input type="submit" value = "Pay">
					</form>
					<?php
						if(isset($_POST['cfirstname']) 
						&& isset($_POST['clastname']) 
						&& isset($_POST['card_number']) 
						&& isset($_POST['expiry_month']) 
						&& isset($_POST['expiry_year']) 
						&& isset($_POST['CVV'])
						){
							$fName = $_POST['cfirstname'];
							$sName = $_POST['clastname'];
							$cCNumber = $_POST['card_number'];
							$expMonth = $_POST['expiry_month'];
							$expYear = $_POST['expiry_year'];
							$ccv = $_POST['CVV'];
							$euro = 50;
							$cent = 0;
							if(!empty($fName) 
							&& !empty($sName) 
							&& !empty($cCNumber) 
							&& !empty($expMonth) 
							&& !empty($expYear)
							&& !empty($ccv)){
								//Verify Card details
								$result = verify_card($fName, $sName, $cCNumber, $expMonth, $expYear, $ccv, $euro, $cent);
								if($result == 1){
									//Format date so it will submit to mysql
									$date_active = date("Y-m-d",time() + 2419200);
									$query_credit = "SELECT * FROM creditcardinfo WHERE username = '".mysql_real_escape_string($username)."'";
									$query_credit_run  = mysql_query($query_credit);
									if(mysql_num_rows($query_credit_run) == 0){
										$query_insert_credit = "INSERT INTO creditcardinfo (username, activeuntil) 
										VALUES ('".mysql_real_escape_string($username)."','".mysql_real_escape_string($date_active)."')";
										$query_insert_credit_run = mysql_query($query_insert_credit);
										}else{
										$query_insert_credit = "UPDATE creditcardinfo SET activeuntil = '".mysql_real_escape_string($date_active)."' 
										WHERE username = '".mysql_real_escape_string($username)."')";
										$query_insert_credit_run = mysql_query($query_insert_credit_run);
									}
									echo '<font color="006600">Successfully Paid, your subscription is active for 4 more weeks</font>';
								}else{
									echo '<font color="crimson">Card Declined</font>';
								}
							}else{
								echo '<font color="crimson"><br>Enter all fields!</font>';
							}
						}
					?>
					
				</div>
				<div class="right">
					<h3>Personal Questions</h3>
					<form action="account.php" method="POST" enctype = "multipart/form-data"><br>
					<br>
					<h3>Attriutes:</h3>

					<?php
						$query_questions = "SELECT * FROM attributequestions";
						$query_run_questions = mysql_query($query_questions);
						$countat = 0;
						while($query_row_questions = mysql_fetch_assoc($query_run_questions)){
							$question = $query_row_questions['aquestion'];
							$question_id[$countat] =  $query_row_questions['attributeid'];
							echo '<strong>'.$question.'</strong><br>';
							$attributeid = $query_row_questions['attributeid'];
							$query_answers = "SELECT * FROM attributeresponses r, attributequestions q 
							WHERE r.attributeid = q.attributeid 
							AND r.attributeid = '".mysql_real_escape_string($attributeid)."'";
							$query_run_answers = mysql_query($query_answers);
							echo '<select name="'.$attributeid.'"><option value="">Please Select</option>';
							while($query_row_answers = mysql_fetch_assoc($query_run_answers)){
								$ans = $query_row_answers['aresponse'];
								$id = $query_row_answers['aresponseid'];
								echo '<option value="'.$id.'">'.$ans.'</option>';
							}
							echo '</select><br><br>';
							$countat++;
						}
						$i = 0;
						while($i < $countat){
							$currentval = $question_id[$i];
							if(isset($_POST[$currentval])){
								$responseid = $_POST[$currentval];
								if(!empty($responseid)){
									$query_select = "SELECT * FROM userattributeanswers WHERE username = '".mysql_real_escape_string($username)."' 
									AND attributeid='".mysql_real_escape_string($currentval)."'";
									$query_run_select = mysql_query($query_select);
									if(mysql_num_rows($query_run_select) == 1){
										$query_update = "UPDATE userattributeanswers
										SET aresponseid='".mysql_real_escape_string($responseid)."'
										WHERE username='".mysql_real_escape_string($username)."' AND attributeid='".mysql_real_escape_string($currentval)."'";
										
										if($query_run_update = mysql_query($query_update)){
											echo '<font color="006600">Successfully updated</font><br>';
										}
									}else{
										$query_insert = "INSERT INTO userattributeanswers
										VALUES ('".mysql_real_escape_string($username)."','".mysql_real_escape_string($currentval)."','".mysql_real_escape_string($responseid)."')";
										if($query_run_insert = mysql_query($query_insert)){
											echo '<font color="006600">Successfully entered</font><br>';
										}
									}
								}else{
									$error_message = '<font color="crimson">Select an option!</font><br>';
								}
							}
							$i++;
						}
						?>
						<br>
						<h3>Interests:</h3>
						<?php
						
						$query_questions_interest = "SELECT * FROM interestquestions";
						$query_run_questions_interest = mysql_query($query_questions_interest);
						$count = 0;
						while($query_row_questions_interest = mysql_fetch_assoc($query_run_questions_interest)){
							$question_interest = $query_row_questions_interest['iquestion'];
							$question_id[$count] =  $query_row_questions_interest['interestid'];
							echo '<strong>'.$question_interest.'</strong><br>';
							$interestid = $query_row_questions_interest['interestid'];
							$query_answers_interest = "SELECT * FROM interestresponses r, interestquestions q 
							WHERE r.interestid = q.interestid 
							AND r.interestid = '".mysql_real_escape_string($interestid)."'";
							$query_run_answers_interest = mysql_query($query_answers_interest);
							echo '<select name="'.$interestid.'"><option value="">Please Select</option>';
							while($query_row_answers_interest = mysql_fetch_assoc($query_run_answers_interest)){
								$ans_interest = $query_row_answers_interest['iresponse'];
								$id_interest = $query_row_answers_interest['iresponseid'];
								echo '<option value="'.$id_interest.'">'.$ans_interest.'</option>';
							}
							echo '</select><br><br>';
							$count++;
						}
						$i = 50;
						$count = 50 + $count;
						while($i < $count){	
						$val = $i - 50;
						$currentval = $question_id[$val];
							if(isset($_POST[$currentval])){
								$responseid_interest = $_POST[$currentval];
								if(!empty($responseid_interest)){
									$query_select_interest = "SELECT * FROM userinterestanswers WHERE username = '".mysql_real_escape_string($username)."'
									AND interestid='".mysql_real_escape_string($currentval)."'";
									$query_run_select_interest = mysql_query($query_select_interest);
									if(mysql_num_rows($query_run_select_interest) == 1){
										$query_update_interest = "UPDATE userinterestanswers
										SET iresponseid='".mysql_real_escape_string($responseid_interest)."'
										WHERE username='".mysql_real_escape_string($username)."' AND interestid='".mysql_real_escape_string($currentval)."'";
										if($query_run_update_interest = mysql_query($query_update_interest)){
											echo '<font color="006600">Successfully updated</font><br>';
										}
									}else{
										$query_insert_interest = "INSERT INTO userinterestanswers
										VALUES ('".mysql_real_escape_string($username)."','".mysql_real_escape_string($currentval)."','".mysql_real_escape_string($responseid_interest)."')";
										if($query_run_insert_interest = mysql_query($query_insert_interest)){
											echo '<font color="006600">Successfully entered</font><br>';
										}
									}
								}else{
									$error_message = '<font color="crimson">Select an option!</font><br>';
								}
							}
							$i++;
						}
						echo $error_message;

					?>
					<input type="submit" value = "Submit">
					</form><br><br><br>
					
					<h3>Update Account info</h3>
					<form action="account.php" method="POST" enctype = "mutlipart/form-data">
					<h3>The information that will be public is in <font color="crimson"><strong>RED</strong></font></h3><br>
					Password:			<br><input type="password" maxlength="255" name="password"><br><br>
					Confirm Password:	<br><input type="password" maxlength="255" name="confirm_password"><br><br>
					<font color="crimson">Orientation: </font><br><select name="orientation">
					<option value="">Please Select</option>
					<option value="s">Straight</option>
					<option value="g">Gay</option>
					<option value="b">Anything Goes!</option>
					</select><br><br>
					Street Address:		<br><input type="text" name = "street_address" maxlength="30" value="<?php if(isset($street_address)){ echo $street_address;} ?>"><br><br>
					<font color="crimson">County: </font><br><select name="county">
					<option value="">Please Select</option>
					<option>Antrim</option>
					<option>Armagh</option>
					<option>Carlow</option>
					<option>Cavan</option>
					<option>Clare</option>
					<option>Cork</option>
					<option>Derry</option>
					<option>Donegal </option>
					<option>Down</option>
					<option>Dublin</option>
					<option>Fermanagh</option>
					<option>Galway</option>
					<option>Kerry</option>
					<option>Kildare</option>
					<option>Kilkenny</option>
					<option>Laois </option>
					<option>Leitrim</option>
					<option>Limerick</option>
					<option>Longford</option>
					<option>Louth</option>
					<option>Mayo</option>
					<option>Meath</option>
					<option>Monaghan</option>
					<option>Offaly</option>
					<option>Roscommon</option>
					<option>Sligo</option>
					<option>Tipperary</option>
					<option>Tyrone</option>
					<option>Waterford</option>
					<option>Westmeath</option>
					<option>Wexford </option>
					<option>Wicklow</option></select><br><br>
					
					<font color="crimson">Occupation: </font><br><select name="occupation">
					<option value="">Please Select</option>
					<option>Construction</option>
					<option>Engineering</option>
					<option>Science</option>
					<option>Health Care</option>
					<option>Public Service</option>
					<option>Tourist</option>
					<option>Entertainment</option>
					<option>Motor Industry</option>
					<option>Management</option>
					<option>Sales</option>
					<option>Marketing</option>
					<option>Other</option>
					</select><br><br>
					<font color="crimson">About you:	</font>	<br><input type="text" name = "about" maxlength="255" value="<?php if(isset($about)){ echo $about;} ?>"><br><br>
					Email:				<br><input type="text" name = "email" maxlength="255" value="<?php if(isset($email)){ echo $email;} ?>"><br><br>
					<input type="submit" value = "Update">
					</form>
					<?php
							if(isset($_POST['password']) 
							&& isset($_POST['confirm_password']) 
							&& isset($_POST['street_address'])
							&& isset($_POST['county'])
							&& isset($_POST['email'])
							&& isset($_POST['occupation'])
							&& isset($_POST['about'])
							&& isset($_POST['orientation'])){
								$password = $_POST['password'];
								$confirm_password = $_POST['confirm_password'];
								$street_address = $_POST['street_address'];
								$county = $_POST['county'];
								$email = $_POST['email'];	
								$occupation = $_POST['occupation'];
								$about = $_POST['about'];
								$orientation = $_POST['orientation'];
								if(!empty($password) 
								&& !empty($confirm_password) 
								&& !empty($street_address)
								&& !empty($county)
								&& !empty($email)
								&& !empty($occupation)
								&& !empty($about)
								&& !empty($orientation)
								){
									$username = $_COOKIE["user"];
									if($password != $confirm_password){
										$error_message_update = '<font color="crimson">Passwords do not match</font>';
									}else{
										$password_hash = md5($password);
										$query_update_private = "UPDATE userprivate SET streetaddress='".mysql_real_escape_string($street_address)."', 
										email='".mysql_real_escape_string($email)."' WHERE username='".mysql_real_escape_string($username)."'";
										$query_pass = "UPDATE authentication SET password = '".mysql_real_escape_string($password_hash)."'
										WHERE username = '".mysql_real_escape_string($username)."'";
										
										$query_public = "UPDATE userpublic SET county = '".mysql_real_escape_string($county)."',
										occupation='".mysql_real_escape_string($occupation)."',
										about = '".mysql_real_escape_string($about)."', orientation ='".mysql_real_escape_string($orientation)."'
										WHERE username='".mysql_real_escape_string($username)."'";
										if($query_run = mysql_query($query_update_private) && $query_pass_run = mysql_query($query_pass) && $query_public_run = mysql_query($query_public)){
												echo '<font color="006600">Sucessfuly Updated</font>';
										}else{
											$error_message_update = '<font color="crimson">Cannot be updated at this time</font>';
										}
									}
								}else{
									$error_message_update = '<font color="crimson">All fields are required</font>';
								}
							}
								echo $error_message_update;
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