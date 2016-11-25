<?php
include_once '../INCLUDES/session.inc.php';
include '../DBCONNECT/connect.inc.php';
if(!isset($_SESSION['user_id']))
{
	header('Location:../sk-admin/login/');	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="icon" href="../images/logo.png">
	<title>Editor &lsaquo; Plentyofwords</title>
<style>
*
{
	margin:0;
	padding:0;
	text-decoration:none;
	font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	font-weight:normal;
}
body
{
	background:#F0F0F0;
}
header
{
	padding:1%;
	background:#FFFFFF;
	position:fixed;
	top:0;
	width:98%;
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
.logout
{
	color:#000000;
	float:right;
	
}
.logout:hover
{
	color:#007DAF;
}

.left-div
{
	background:#23282D;
	width:11%;
	height:100%;
	display:inline-block;
	vertical-align:top;
	position:fixed;
	font-size:14px;
	margin-top:1.5%;
}
.left-div a:link
{
	display:block;
	padding:7% 0;
	text-align:center;
	color:#FFFFFF;
	margin-bottom:1px;
}
.left-div a:visited
{
	background:#23282D;
	color:#FFFFFF;
	
}
.left-div a:hover
{
	background:#191E23;
	color:#00B9EB;
	
}
.left-div a:active
{
	background:#23282D;
	color:#FFFFFF;
	
}
.right-div
{
	display:inline-block;
	margin:3.5% 0 0 13%;
	width:85%;
}
.line-1
{
	padding:2% 0;
}
.line-1 h1
{
	display:inline-block;
	font-size:24px;
	margin-right:2%;
	color:#3A3A3A;
	font-weight:300;
}
.line-1 a
{
	display:inline-block;
	padding:.5% 1%;
	color:#0073AA;
	font-weight:300;
	box-shadow: 0 0 1px 1px #CCCCCC;
}
.line-1 a:hover
{
	background:#0073AA;
	color:#FFFFFF;
	box-shadow:none;
}
.line-2
{
	padding:1% 0;
	font-size:14px;
}
.line-2 a:link
{
	margin:0 1%;
	color:#0073AA;
}
.line-2 a:visited
{
	color:#0073AA;
}
.line-2 a:hover
{
	color:#00A0D2;
}
.line-2 a:active
{
	color:#0073AA;
}
table
{
	width:100%;
	border-collapse:collapse;
	font-size:14px;
	box-shadow:0 0 3px 1px #DFDFDF;
	margin-bottom:5%;
}
th
{
	background:#FFFFFF;
	color:#32373C;
	font-weight:normal;
	font-size:16px;
	text-align:left;
	padding:1% 2%;
}
th:nth-child(1){padding:0 3%;}
td
{
	border:none;
	margin:0;
	padding:1.5% 1.5% 0 1.5%;
	vertical-align:top;
}
td:nth-child(1){color:#0073AA;font-weight:300; font-size:16px; line-height:26px; padding:1% 3%;}
tr:hover td:nth-child(1) div
{
	visibility:visible;
}

td:nth-child(1) a:link
{
	color:#0073AA;
}
td:nth-child(1) a:visited
{
	color:#0073AA;
}
td:nth-child(1) a:hover
{
	color:#00A0D2;
}
td:nth-child(1) a:active
{
	color:#124964;
}
td:nth-child(1) div {font-size:13px; font-weight:normal;line-height:26px; visibility:hidden;}
td:nth-child(1) div a:nth-child(1)
{
	padding-right:5%;
}
td:nth-child(1) div a:nth-child(1n+2)
{
	padding:0 5%;
	border-left:1px solid #CCCCCC;
	
}
td:nth-child(1) div a:nth-child(3)
{
	color:#C70003;
}
td:nth-child(1) div a:nth-child(3):hover
{
	color:#FC4548;
}
td:nth-child(5){padding-left:3%;}
tr:nth-child(odd){background:#FFFFFF;}
tr:nth-child(1){border:1px solid #E1E1E1;}
 .messages .green
 {
	color:#000000;
	background:#FFFFFF;
	margin:2% 0;
	border-left:3px solid #008C51;
	padding:1%;
 }


</style>
</head>
<body>
<header>
    	<a href=""><img src="../images/logo.png" alt="logo" id="logo"><span id="site-text"> Plenty<span id="bcolor">of</span>words</span></a>
         <?php if(isset($_SESSION['user_id']))echo '<a href="../sk-admin/logout/" class="logout">Log Out</a>';?>
</header>
<div class="left-div">
<a href="">All Posts</a>
<a href="new">Add New</a>
</div>
<div class="right-div">
<div class="line-1"><h1>Posts</h1><a href="new">Add New</a></div>
<div class="messages">
<?php
	include 'editor_read.php';
?>
</div>

<div class="line-2"><a href="http://www.plentyofwords.com/editor/">All (<?php echo $tot_post;?>)</a>|<a href="?post_type=published">Published (<?php echo $pub;?>)</a>|<a href="?post_type=draft">Draft (<?php echo $draft;?>)</a></div>
<table>
<tr><th>Title</th><th>Author</th><th>Categories</th><th>Tags</th><th>Views</th><th>Status</th></tr>
<?php 
if(isset($ed_pageid))
for($i = 0;$i < sizeof($ed_pageid); $i++)
{
	if(!empty($ed_heading[$i]))
	{
		$title = $ed_heading[$i];
	}
	else
	{
		$title = 'No Title';
	}
	
		
	echo '<tr><td><a href="edit/?pid='.$ed_pageid[$i].'">'.$title.'</a><div><a href="edit/?pid='.$ed_pageid[$i].'">Edit</a><a href="editor_preview/?pid='.$ed_pageid[$i].'">Preview</a><a href="editor_trash/?trash='.$ed_pageid[$i].'">Trash</a></div></td><td>'.$ed_username[$i].'</td><td>'.$ed_cat[$i].'</td><td>'.$ed_tags[$i].'</td><td>'.$ed_view[$i].'</td><td>';
	if(isset($ed_publish[$i]))
	{
		if($ed_publish[$i] == 1) 
		echo 'Published'; 
		else 
		echo 'Draft'; 
	}
	echo '</td></tr>';
}
?>
</table>
</div>

</body>
</html>