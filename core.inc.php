<?php
ob_start();
$current_file = $_SERVER['SCRIPT_NAME'];
if(isset($_SERVER['SCRIPT_NAME']) && !empty($_SERVER['SCRIPT_NAME'])){
	$http_referer = $_SERVER['HTTP_REFERER'];
}

//Checks if user has logged in
function cookielogin(){
	if (isset($_COOKIE["user"]) && !empty($_COOKIE["user"])){
		return true;
	}else{
		return false;
	}
}

// This function needs to be modified to take the parameters for each of the fields.
// This example will work, and will show you how to build up the query to the server
// The function will need to take all the credit card details
function verify_card($fName, $sName, $cCNumber, $expMonth, $expYear, $ccv, $euro, $cent){
	// Curl is a command for reading a URL
	// Notice that we use the GET method to pass the parameters names
	// and values
	$ch = curl_init("http://amnesia.csisdmz.ul.ie/4313/Code/ccserv.php?fname=$fName&sname=$sName&number=$cCNumber&month=$expMonth&year=$expYear&ccv=$ccv&euro=$euro&cent=$cent");
	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	// $output contains the output string 
	$output = curl_exec($ch); 
	
	// close curl resource to free up system resources 
	curl_close($ch);      
	return ($output); // 1 for accept or 0 for decline
}

//Checks if membership is active
function checkmembership($username){
	$today = date("Y-m-d", time());
	$query = "SELECT * FROM creditcardinfo WHERE activeuntil > '$today' AND username = '".mysql_real_escape_string($username)."'";
	$query_run = mysql_query($query);
	if(mysql_num_rows($query_run) > 0){
		return 1;
	}else{
		return 0;
	}
}

?>