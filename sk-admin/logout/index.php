<?php
	require_once('../../INCLUDES/session.inc.php');
	session_destroy();
	header('Location:../login');	
?>