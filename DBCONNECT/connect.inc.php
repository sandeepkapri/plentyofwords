<?php
$HOST='localhost';
$USER='**********';
$PASS='***********';
$DB='**********';
$conn=new mysqli($HOST,$USER,$PASS,$DB);
if($conn->connect_error)
{	
	
	//die();
}


?>