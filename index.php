<?php
require 'core.inc.php';
require 'connect.inc.php';
//If logged in go to profile else go to login form
if(cookielogin()){
	header('Location: profile.php');
}else{
	include 'loginform.inc.php';
}
?>