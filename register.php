<?php

require 'core.inc.php';
require 'connect.inc.php';
$error_message = "";
if(!cookielogin()){
	if(isset($_POST['username']) 
	&& isset($_POST['password']) 
	&& isset($_POST['confirm_password']) 
	&& isset($_POST['firstname']) 
	&& isset($_POST['lastname']) 
	&& isset($_POST['street_address'])
	&& isset($_POST['county'])
	&& isset($_POST['email'])
	&& isset($_POST['txtDate'])
	&& isset($_POST['occupation'])
	&& isset($_POST['about'])
	&& isset($_POST['gender'])
	&& isset($_POST['orientation'])
	){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$street_address = $_POST['street_address'];
		$county = $_POST['county'];
		$email = $_POST['email'];
		$year = substr($_POST['txtDate'], 6);
		$month = substr($_POST['txtDate'], 0 , 2);
		$day = substr($_POST['txtDate'], 3, 2);
		$dob = $year.'-'.$month.'-'.$day;		
		$occupation = $_POST['occupation'];
		$about = $_POST['about'];
		$gender = $_POST['gender'];
		$orientation = $_POST['orientation'];
		if(!empty($username) 
		&& !empty($password) 
		&& !empty($confirm_password) 
		&& !empty($firstname) 
		&& !empty($lastname)
		&& !empty($street_address)
		&& !empty($county)
		&& !empty($email)
		&& !empty($dob)
		&& !empty($occupation)
		&& !empty($about)
		&& !empty($gender)
		&& !empty($orientation)
		){
			// if(!strlen($username) > 10 ||
			// !strlen($password) > 255 || 
			// !strlen($confirm_password) > 255|| 
			// !strlen($firstname) > 16 || 
			// !strlen($lastname) > 16 || 
			// !strlen($street_address) > 30 || 
			// !strlen($county) > 32 || 
			// !strlen($email) > 255 || 
			// !strlen($dob) > 10 || 
			// !strlen($occupation) > 16 || 
			// !strlen($about) > 255
			//){			
				if($password != $confirm_password){
					$error_message = '<font color="crimson">Passwords do not match</font>';
				}else{
					$password_hash = md5($password);
					$query = "SELECT username FROM userprivate WHERE username = '$username'";
					$query_run = mysql_query($query);
					if(mysql_num_rows($query_run) == 1){
						$error_message = '<font color="crimson">Username already exists</font>';
					}else{
						$query = "INSERT INTO userprivate (username, streetaddress, email, dob, lastname)
						VALUES('".mysql_real_escape_string($username)."',
						'".mysql_real_escape_string($street_address)."',
						'".mysql_real_escape_string($email)."',
						'".mysql_real_escape_string($dob)."',
						'".mysql_real_escape_string($lastname)."')";
						
						$query_pass = "INSERT INTO authentication VALUES ('".mysql_real_escape_string($username)."',
						'".mysql_real_escape_string($password_hash)."')";
						$query_public = "INSERT INTO userpublic (username, firstname, county, occupation, about, gender, orientation) 
						VALUES ('".mysql_real_escape_string($username)."',
						'".mysql_real_escape_string($firstname)."',
						'".mysql_real_escape_string($county)."',
						'".mysql_real_escape_string($occupation)."',
						'".mysql_real_escape_string($about)."',
						'".mysql_real_escape_string($gender)."',
						'".mysql_real_escape_string($orientation)."'						
						)";
						if($query_run = mysql_query($query) && $query_pass_run = mysql_query($query_pass) && $query_public_run = mysql_query($query_public)){
								header('Location: register_success.php');
						}else{
							$error_message = '<font color="crimson">Cannot be Registered at this time</font>';
						}
					}
				}
			//}
		}else{
			$error_message = '<font color="crimson">All fields are required</font>';
		}
	}	
?>

<!DOCTYPE html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" title="Basic Noise" media="all" />
	<title>Register - Delightful Dates</title>
	<script type="text/javascript">
	//Code taken and altered from http://www.redips.net/javascript/date-validation/
		function checkDate(){
		// define date string to test
		var txtDate = document.getElementById('txtDate').value;
		// check date and print message
		if (isDate(txtDate)) {
			
		}
		else {
			alert('Invalid date format!');
			return false;
		}
		}
			
		function isDate(txtDate) {
		var objDate,  // date object initialized from the txtDate string
			mSeconds, // txtDate in milliseconds
			day,      // day
			month,    // month
			year;     // year
		// date length should be 10 characters (no more no less)
		if (txtDate.length !== 10) {
			return false;
		}
		// third and sixth character should be '/'
		if (txtDate.substring(2, 3) !== '/' || txtDate.substring(5, 6) !== '/') {
			return false;
		}
		// extract month, day and year from the txtDate (expected format is mm/dd/yyyy)
		// subtraction will cast variables to integer implicitly (needed
		// for !== comparing)
		month = txtDate.substring(0, 2) - 1; // because months in JS start from 0
		day = txtDate.substring(3, 5) - 0;
		year = txtDate.substring(6, 10) - 0;
		// test year range
		if (year < 1000 || year > 3000) {
			return false;
		}
		// convert txtDate to milliseconds
		mSeconds = (new Date(year, month, day)).getTime();
		// initialize Date() object from calculated milliseconds
		objDate = new Date();
		objDate.setTime(mSeconds);
		// compare input date and parts from Date() object
		// if difference exists then date isn't valid
		if (objDate.getFullYear() !== year ||
			objDate.getMonth() !== month ||
			objDate.getDate() !== day) {
			return false;
		}
		// otherwise return true
		return true;
		}
</script>
</head>

<body>

<div id="container980">
<br><br><br>
	<div id="menu"> 
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="contactus.php">Contact Us</a></li>
			<li><a href="aboutus.php">About Us</a></li>
		</ul>
	</div>
	<div id="feature"><img src="zhomepic.png" alt="Sample header image" />
		<div id="main">
			<div id="content">
				<br>
				<div class="left">	 
					<form action="register.php" method="POST" enctype = "mutlipart/form-data" onsubmit=" return checkDate()">
					<h3>The information that will be public is in <font color="crimson"><strong>RED</strong></font></h3><br>
					<font color="crimson">Username: </font>		<br><input type="text" name="username" maxlength="10" value="<?php if(isset($username)){ echo $username;} ?>"><br><br>
					Password:			<br><input type="password" maxlength="255" name="password"><br><br>
					Confirm Password:	<br><input type="password" maxlength="255" name="confirm_password"><br><br>
					<font color="crimson">Firstname: </font>	<br><input type="text" name = "firstname" maxlength="16" value="<?php if(isset($firstname)){ echo $firstname;} ?>"><br><br>
					Lastname:			<br><input type="text" name = "lastname" maxlength="16" value="<?php if(isset($lastname)){ echo $lastname;} ?>"><br><br>
					<font color="crimson">Gender: </font><br><select name="gender">
					<option value="">Please Select</option>
					<option value="m">Male</option>
					<option value="f">Female</option>
					</select><br><br>
					<font color="crimson">Orientation: </font><br><select name="orientation">
					<option value="">Please Select</option>
					<option value="s">Straight</option>
					<option value="g">Gay</option>
					<option value="b">Anything Goes!</option>
					</select><br><br>
					Date of Birth (mm/dd/yyyy): <br>
					<input name="txtDate" id="txtDate" type="text" size="10" maxlength="10" value="04/03/2012"/><br><br>
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
					<font color="crimson">About you:	</font>	<br><textarea name="about" rows="7" cols="40" maxlength="255" value="<?php if(isset($about)){ echo $about;} ?>"></textarea><br><br>
					Email:				<br><input type="text" name = "email" maxlength="255" value="<?php if(isset($email)){ echo $email;} ?>"><br><br>
					<input type="submit" value = "Register">
					</form>
					<br>
					<?php echo $error_message; ?>
					<br>
				</div>
				<div class="right">
				</div>
			</div>
			<div class="clear">
			</div>
		</div>

	</div>
	
			<div id="credits">
				<p><br>
				<span class="small"></span></p>
				<p></p><p></p> 
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
<?php
}else if(cookielogin()){
	header('Location: index.php');
}
mysql_close($connection);
?>

