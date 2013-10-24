<?php
//Connection File to connect to database. Should be required on each page.
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
//$mysql_user = 'group05';
//$mysql_pass = 'bzY5J9W9hWbwGLDX';
$conn_error = 'Could not connect to database';
$mysql_db = 'group05';
$connection = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
if(!$connection || !mysql_select_db($mysql_db)){
	die($conn_error);
}
?>