<?php
require 'core.inc.php';
//Sets cookie to a time in the past so they cant access restricted pages.
setcookie("user", "", time()-3600);
//Redirect to login page.
header('Location: index.php');
?>