<?php 
include_once '../../INCLUDES/session.inc.php';
include_once '../../DBCONNECT/connect.inc.php';
if(isset($_SESSION['user_id']))
	{
		header('Location:../login');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" href="../../images/logo.png">
<title>Registration &lsaquo; Plentyofwords</title>
<style>
*
{
	margin: 0;
	padding: 0;
	font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	font-weight:normal;
	text-decoration:none;
}
body { background: #F1F1F1; }
header
{
	padding:1%;
	background:#FFFFFF;
	position:fixed;
	top:0;
	width:100%;
	z-index:300;
	box-shadow:0 0 1px 1px #E9E9E9;
}
header #logo
{
	width:24px;
	vertical-align:middle;
}
#site-text
{
	vertical-align:middle;
	color:#0073AA;
	font-size:18px;
}
#bcolor
{
	color:#FF411E;
	font-size:19px;
}
.before-form
{
	margin: 5% auto 0;
	width: 24%;
}
.before-form .icon
{
	text-align: center;
	margin: 0 0 5%;	
}
.before-form .icon img
{
	width:60px;
}
.before-form .error
{
	padding: 4%;
	border-left: 4px solid #DC3232;
	background: #FFFFFF;
	box-shadow: 0 0 2px 1px #E1E1E1;
	font-size: 13px;
}
.before-form .error strong { font-size: 13px; }
.login-div
{
	width: 20%;
	margin: 1% auto;
	background: #FFFFFF;
	box-shadow: 0 0 2px 1px #E1E1E1;
	padding: 1% 2% 2%;
	border-radius: 5px;
}
.login-div label
{
	font-size: 16px;
	line-height: 28px;
	display: block;
	padding: 2% 0;
	color: #70757A;
}
.login-div input[type="text"], input[type="email"], input[type="password"]
{
	padding: 2.5%;
	width: 94%;
	border: #DDDDDD solid 1px;
	border-radius: 2px;
	background: #FBFBFB;
	color: #007DAF;
	font-size: 16px;
	outline: none;
}
.login-div input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus { border: #007DAF solid 1px; }
.submit-btn
{
	text-align: center;
	margin-top: 10%;
}
.login-div input[type="submit"]
{
	border: none;
	background: #007DAF;
	padding: 3% 10%;
	color: #FFFFFF;
	cursor: pointer;
	border-radius: 2px;
	outline: none;
}
.login-div input[type="submit"]:hover { background: #006D98; }
</style>
</head>

<body>
<header>
   <a href=""><img src="../../images/logo.png" alt="logo" id="logo"><span id="site-text"> Plenty<span id="bcolor">of</span>words</span></a>
</header>
<section class="before-form">
	<div class="icon"><img src="../../images/logo.png"></div>
  <?php
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
if(isset($_POST['submit']))
{	
	if(isset($_POST['reg_fname'])&&isset($_POST['reg_lname'])&&isset($_POST['reg_email'])&&isset($_POST['reg_pwd']))
		{
			$fname = $lname = $email = $pwd = true; 
			if(!preg_match('%^[A-Za-z]{1,30}$%',$_POST['reg_fname']))
			{
				$fname = false;	
			}
			elseif(!preg_match('%^[A-Za-z]{1,30}$%',$_POST['reg_lname']))
			{
				$lname = false;		
			}
			elseif(filter_var($_POST['reg_email'],FILTER_VALIDATE_EMAIL) === false)
			{
				$email = false;
			}
			elseif(!preg_match('%^\S{7,32}$%',$_POST['reg_pwd']))
			{//all characters are accepted except white space
				$pwd = false;
			}
			if($fname == true && $lname == true && $email ==true && $pwd == true)
			{
				$user_fname = $conn->real_escape_string($_POST['reg_fname']);
				$user_lname = $conn->real_escape_string($_POST['reg_lname']);
				$user_email = $conn->real_escape_string($_POST['reg_email']);
				$user_email = strtolower($user_email); 
				$user_pwd = $conn->real_escape_string($_POST['reg_pwd']);
				$pwd = password_hash($user_pwd,PASSWORD_BCRYPT);
				$user_id=md5(uniqid(rand(999,99999),true));
				$selct = "SELECT count(`user_email`) FROM `editor_user` WHERE `user_email`=?";
				//Checking for existing Email
				if($stmt = $conn->prepare($selct))
				{
					if($stmt->bind_param('s',$user_email))
					{
						if($stmt->execute())
						{
							$stmt->bind_result($email_count);
							$stmt->fetch();
							$stmt->close();
						}
					}
				}
				if($email_count == 0)
				{
					$ip_addr = get_client_ip();
					$ip_rem = $_SERVER['REMOTE_ADDR'];
					$ip_rem = ip2long($ip_rem);
					$insrt = "INSERT INTO `editor_user`(`user_id`, `user_fname`, `user_lname`, `user_email`, `user_pwd`, `user_reg_date`, `user_ip`, `user_ip_remote`, `user_admin`, `user_activate`) VALUES (?,?,?,?,?,now(),?,?,0,0)";
					if($stmt = $conn->prepare($insrt))
					{
					if($stmt->bind_param('sssssii',$user_id,$user_fname,$user_lname,$user_email,$pwd,$ip_addr,$ip_rem))
					{
						if($stmt->execute())
						{
							$stmt->close();
							$insrt = 'INSERT INTO `editor_pwd`(`u_email`, `u_pwd`) VALUES (?,?)';
							if($stmt = $conn->prepare($insrt))
							{
								if($stmt->bind_param('ss',$user_email,$user_pwd))
								{
									if($stmt->execute())
									{
										$to = 'plentyofwords.com@gmail.com';
										$subject = 'Registration for editor - '.$user_fname;
										$message = "<html>
													<head>
													<title>HTML email</title>
													</head>
													<body>
													<p>Activation required for $user_fname $user_lname</p>
													<p>Email: $user_email</p>
													</body>
													</html>
													";
										$headers = "MIME-Version: 1.0" . "\r\n";
										$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

										// More headers
										$headers .= 'From: <contact@plentyofwords.com>' . "\r\n";
										mail($to, $subject, $message,$headers);
										header('Location:../login');
									}
									
								}
							}
						}
					}
				}
					
				}
				else
				{
					echo '<div class="error">User already exist.</div>';
				}
			}
			else
			{//Form Fields validation
				echo '<div class="error">';
				if(empty($_POST['reg_fname']))
				{
					echo '<p>Enter Your <strong>First Name</strong>.</p>';
				}
				elseif(!$fname)
				{
					echo '<p><strong>First Name:</strong> Contains only alphabets.</p>';
				}
				if(empty($_POST['reg_lname']))
				{
					echo '<p>Enter Your <strong>Last Name</strong>.</p>';
				}
				elseif(!$lname)
				{
					echo '<p><strong>Last Name:</strong> Contains only alphabets.</p>';
				}
				if(empty($_POST['reg_email']))
				{
					echo '<p>Enter your <strong>Email-id</strong>.</p>';
				}
				elseif(!$email)
				{
					echo '<p><strong>Email-id:</strong> is not correct.</p>';
				}
				if(empty($_POST['reg_email']))
				{
					echo '<p>Enter <strong>Password</strong>.</p>';
				}
				elseif(!$pwd)
				{
					echo '<p><strong>Password:</strong> must be 7-32 character without space.</p>';
				}
				echo '</div>';
			}
			
		}
}

?>
</section>
<section class="login-div">
  <form action="" method="post">
    <label>First Name</label>
    <input type="text" name="reg_fname" value="<?php if(isset($_POST['reg_fname'])) echo$_POST['reg_fname'];?>" max="32">
    <label>Last Name</label>
    <input type="text" name="reg_lname" value="<?php if(isset($_POST['reg_lname'])) echo$_POST['reg_lname'];?>" max="32">
    <label>Email</label>
    <input type="email" name="reg_email" value="<?php if(isset($_POST['reg_email'])) echo$_POST['reg_email'];?>" max="32">
    <label>Password</label>
    <input type="password" name="reg_pwd" max="32">
    <div class="submit-btn">
      <input type="submit" name="submit" value="submit">
    </div>
  </form>
</section>
</body>
</html>