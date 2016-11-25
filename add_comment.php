<?php
include 'DBCONNECT/connect.inc.php';
function get_client_ip() 
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
		$ipaddress = ip2long($ipaddress);
    	return $ipaddress;
	}
if(isset($_POST['commText']) && isset($_POST['commUsername']) && isset($_POST['commEmail']) && isset($_POST['pid']))
{
	if(!empty($_POST['commText']) && !empty($_POST['commUsername']) && !empty($_POST['commEmail'])&& !empty($_POST['pid']))
	{
		$email_valid = true;
		$name_valid = true;
		$comm_valid = true;
		if(filter_var($_POST['commEmail'],FILTER_VALIDATE_EMAIL) === false)
		{
			$email_valid = false;		
		}
		elseif(!preg_match('%^\S{1,40}$%',$_POST['commUsername']))
		{
			$name_valid = false;
		}
		elseif(!preg_match('%^\S{1,40}$%',$_POST['commText']))
		{
			$comm_valid = false;
		}
		
		if($email_valid == true && $name_valid == true && $comm_valid == true)
		{
			$commtext = $conn->real_escape_string($_POST['commText']);
			$commuser = $conn->real_escape_string($_POST['commUsername']);
			$commemail = $conn->real_escape_string($_POST['commEmail']);
			$pageid = $conn->real_escape_string($_POST['pid']);
			$ip_addr = get_client_ip();
			$ip_rem = $_SERVER['REMOTE_ADDR'];
			$ip_rem = ip2long($ip_rem);
			$insert = "INSERT INTO `blog_comment`(`page_id`, `comm_text`, `comm_user`, `comm_email`, `comm_date`, `comm_status`, `ip_remote`, `ip_addr`) VALUES (?,?,?,?,now(),1,?,?)";
			if($stmt = $conn->prepare($insert))
			{
				if($stmt->bind_param('ssssii',$pageid,$commtext,$commuser,$commemail,$ip_rem,$ip_addr))
				{
					if($stmt->execute())
					{
						echo '&emsp; Your comment has been added.';
						$stmt->close();
					}
				}
			}
			
		}
	}
}
?>