<?php
require 'core.inc.php';
require 'connect.inc.php';
if(!cookielogin()){
	header('Location: index.php');
}
//Gets a users profile picture from the database and returns image data
if(isset($_GET['username'])){
	if(!empty($_GET['username'])){
		$username = $_GET['username'];
		$query = "SELECT * FROM userimages where username='".mysql_real_escape_string($username)."'";
		if($query_run = mysql_query($query)){
			if(mysql_num_rows($query_run) == NULL){
				echo 'No Profile Pic Uploaded';
			}else{
				$row = mysql_fetch_array($query_run);
				$data = $row['imagedata'];
				$type = $row['imagetype'];
				header('Content-type: $type');
				echo $data;
			}
		}else{
		echo mysql_error();	
		}
	}
}
?>