<?php 
include_once '../../INCLUDES/session.inc.php';
include_once '../../DBCONNECT/connect.inc.php';
if(isset($_SESSION['user_id']))
	{
		header('Location:../../editor');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" href="/images/logo.png">
<title>Login  &lsaquo; Plentyofwords</title>
<style>
*
{
	margin:0;
	padding:0;
	font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	font-weight:normal;
	text-decoration:none;
}
body
{
	background:#F1F1F1;
}
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
	margin:5% auto 0;
	width:24%;
}
.before-form .icon
{
	text-align:center;
	margin:0 0 5%;		
}
.before-form .icon img
{
	width:60px;
}
.before-form .error
{
	padding:4%;
	border-left:4px solid #DC3232;
	background:#FFFFFF;
	box-shadow:0 0 2px 1px #E1E1E1;
	font-size:13px;
}
.before-form .error strong
{
	font-size:13px;
}
.login-div
{
	width:20%;
	margin:2% auto;
	background:#FFFFFF;
	box-shadow:0 0 2px 1px #E1E1E1;
	padding:2% 2% 5%;
	border-radius:5px;
}

.login-div label
{
	
	font-size:16px;
	line-height:28px;
	display:block;
	padding:2% 0;
	color:#70757A;
}
.login-div input[type="email"] , input[type="password"]
{
	padding:2.5%;
	width:94%;
	border:#DDDDDD solid 1px;
	border-radius:2px;
	background:#FBFBFB;
	color:#007DAF;
	font-size:16px;
	outline:none;
}
.login-div input[type="email"]:focus , input[type="password"]:focus
{
	border:#007DAF solid 1px;
}
.form-submit
{
	padding:10% 0 0;
}
.form-submit a:link
{
	color:#4C4C4C;
	font-size:14px;
	text-decoration:none;
}
.form-submit a:visited
{
	color:#4C4C4C;
}
.form-submit a:hover
{
	color:#007DAF;
}
.form-submit a:active
{
	color:#4C4C4C;
}
.login-div input[type="submit"]
{
	border:none;
	background:#007DAF;
	padding:3% 10%;
	color:#FFFFFF;
	cursor:pointer;
	float:right;
	border-radius:2px;
	outline:none;
}
.login-div input[type="submit"]:hover
{
	background:#006D98;
}
</style>
</head>

<body>
<header>
    	<a href=""><img src="/images/logo.png" alt="logo" id="logo"><span id="site-text"> Plenty<span id="bcolor">of</span>words</span></a>
</header>
<section class="before-form">
	<div class="icon"><img src="/images/logo.png"></div>
<?php
if(isset($_POST['submit']))
{
	
	if(isset($_POST['login_email']) && isset($_POST['login_pwd']))
		{	
			if(!empty($_POST['login_email']) && !empty($_POST['login_pwd']))
			{
				$user_email = $conn->real_escape_string($_POST['login_email']);
				$user_email = strtolower($user_email);
				$user_pwd = $conn->real_escape_string($_POST['login_pwd']);
				$selct = "SELECT `user_id`, `user_email`, `user_pwd`, `user_activate` FROM `editor_user` WHERE `user_email`= ?";
				if($stmt = $conn->prepare($selct))
				{
					if($stmt->bind_param('s',$user_email))
					{
						if($stmt->execute())
						{
									
										$stmt->store_result();
										$query_num_rows=$stmt->num_rows;		
										$stmt->bind_result($var_id,$var_email,$var_pwd,$activate);
										$stmt->fetch();
										if($query_num_rows==0)
										{
											echo '<div class="error"><strong>ERROR: </strong>Email-id is not registered.</div>';
										}
										else if($query_num_rows==1)
										{									 
											if($activate==1)
											{
												if(password_verify($user_pwd,$var_pwd))
												{
													$_SESSION['user_id']=$var_id;
													header('Location:../../editor');									 	
												}
												else
												{
													echo '<div class="error"><strong>ERROR: </strong>Incorrect Password.</div>';
												}
											}
											else
											{
												echo '<div class="error"><strong>ERROR: </strong>Account is not activated.<br/>Please contact administrator.</div>';
											}
										}
										
									
								}
					}
				}
			}
			else
			{	
				echo '<div class="error">';
				if(empty($_POST['login_email']))
				{
					echo '<p>Enter your <strong>Email-id</strong>.</p>';
				}
				if(empty($_POST['login_pwd']))
				{
					echo '<p>Enter <strong>Password</strong>.</p>';
				}
				echo '</div>';
			}
			
		}
}
?>	
</section>
<section class="login-div">
<form action="" method="post">
<label>Username or email</label>
<input type="email" name="login_email" value="<?php if(isset($_POST['login_email'])) echo $_POST['login_email'];?>">
<label>Password</label>
<input type="password" name="login_pwd">
<div class="form-submit">
    <a href="../register">Create an account</a>
    <input type="submit" name="submit" value="submit">
</div>
</form>
</section>
</body>
</html>