<?php 
include '../../DBCONNECT/connect.inc.php';
if(isset($_GET['pid']))
{
	if(!empty($_GET['pid']))
	{  
		$prev_get = $conn->real_escape_string($_GET['pid']);
		$selct = "SELECT `page_id`,`page_heading`,`post_content`,`created_date`,`top_img_url`,`tags` FROM `blog_post` WHERE `page_id`=?";
		$prev_pageid = $conn->real_escape_string($prev_get);
		if($stmt = $conn->prepare($selct))
		{
			if($stmt->bind_param("s",$prev_pageid))
			{
					if($stmt->execute())
					{
						$stmt->store_result();
						$post_row = $stmt->num_rows;
						$stmt->bind_result($pageid,$post_heading,$post_content,$post_date,$top_img,$post_tags);
						$stmt->fetch();
						$stmt->close();
						
					 }
					 if($post_row == 0)
					 {
						 header('Location:404.php');
					 }
			}
		}
	}
}
	
	?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" href="../../images/logo.png" type="image/png">
<title>Preview &lsaquo; Plentyofwords</title>
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
	width:100%;
	z-index:300;
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
header .option
{
	display:inline-block;
	width:85%;
	text-align:right;
}
header .option a:link
{
	color:#454545;
	padding:0 1%;
}
header .option a:visited
{
	color:#454545;
}
header .option a:hover
{
	color:#026CA7;
}
header .option a:active
{
	color:#454545;
}
header .option a:nth-last-child(2)
{
	color:#0073AA;
}
header #search-icon
{
	padding:.8% .5% .8% .7%;
	margin-right:1%;
	cursor:pointer;
	border-radius:2px;
}
header #search-icon:hover
{
	background:#E0E0E0;
}
header #search-icon img
{
	vertical-align:middle;
}
#search-close
{
	padding:0 .8%;
	display:none;
	cursor:pointer;
	font-size:18px;
}
#search-close:hover
{
	background:#E0E0E0;
}
#search-div
{
	position:absolute;
	top:100%;
	right:5%;
	background:#FFFFFF;
	width:25%;
	visibility:hidden;
}
#search-textbox
{
	padding:5%;
	outline:none;
	border:1px solid #0073AA;
	width:90%;
}
#search-result a:link
{
	color:#0073AA;
	padding:2%;
	display:block;
	border-bottom:1px solid #F0F0F0;
}
#search-result a:visited
{
	color:#0073AA;
	border-bottom:1px solid #F0F0F0;
}
#search-result a:hover
{
	color:#124964;
	border-bottom:1px solid #F0F0F0;
}
#search-result a:active
{
	color:#0073AA;
	border-bottom:1px solid #F0F0F0;
}
.post-sec
{
	margin:10%;
	padding-bottom:5%;
	background:#FFFFFF;
}
.post-img img
{
	width:100%;
}
.post-sec h1
{
	padding:3% 10% 0 10%;
	text-align:center;
	line-height:36px;
	font-size:26px;
}
.post-sec time
{
	padding:0 5%;
	text-align:center;
	font-size:16px;
	color:#979797;
	display:block;
	padding:1% 0 5%;
}
.post-sec p
{
	padding:0 10%;
	line-height:36px;
	font-size:17px;
	text-align:justify;
	color:#2E2E2E;
}
.tags-div
{
	display:block;
	margin: 5% 10%;
	font-size:20px
}
.tags-div a:link
{
	display:inline-block;
	padding:.5% 1%;
	margin:0 .5%;
	color:#FFFFFF;
	font-size:15px;
	background:#FF411E;
	border-radius:2px;
	cursor:pointer;	
}
.tags-div a:visited
{
	background:#FF411E;
	color:#FFFFFF;
}
.tags-div a:hover
{
	background:#B42E15;
	color:#FFFFFF;
}
.tags-div a:active
{
	background:#FF411E;
	color:#FFFFFF;
}
.recommend-label
{
	color:#FFFFFF;
	text-align:center;
	background:#0073AA;
	padding:1% 0;
	position:relative;
}
.recommend-label h1
{
	font-size:26px;
	line-height:36px;
	font-weight:600;
}
.recommend-label .triangle-tip
{
	background:#0073AA;
	width:20px;
	height:20px;
	transform:rotate(45deg);
	-webkit-transform:rotate(45deg);
	-moz-transform:rotate(45deg);
	-ms-transform:rotate(45deg);
	-o-transform:rotate(45deg);
	position:absolute;
	top:80%;
	left:48%;
}
.top-stories
{
	padding: 2% 6%;
	background:#2E2E2E;
}
.top-stories .tile
{
	background:#E9E9E9;
	width:23%;
	margin: 0 3%;
	display:inline-block;
	text-align:center;
	padding:2%;
	vertical-align:top;
}
.top-stories .tile img
{
	border:10px solid #E0E0E0;
	width:94%;
	margin-bottom:5%;
}
.top-stories .tile h1
{
	color:#333333;
	font-size:20px;
	font-weight:300;
	line-height:27px;
}
.top-stories .tile p
{
	color:#747474;
	font-size:16px;
	line-height:26px;
}
.top-stories .tile a
{
	color:#333333;
	font-size:14px;
	padding:2% 3%;
	border:1px solid #333333;
	border-radius:3px;
	font-weight:bold;
	margin:5% 0;
	display:inline-block;
}
.foot-top
{
	background:rgba(2,108,167,0.9);
	padding:2% 15%;
	color:#D9D9D9;
	font-size:16px;
	line-height:22px;
	
}
.foot-wrap-3-div
{
	border-bottom:1px solid rgba(2,108,167,0.7);
}
.foot-div-1
{
	display:inline-block;
	width:25%;
	padding:1%;
	vertical-align:top;
}
.foot-div-1 h1
{
	font-size:18px;
	padding:5% 0;
	color:#FFFFFF;
	
}
.foot-div-2
{
	display:inline-block;
	width:25%;
	padding:2%;
}
.foot-div-2 a
{
	display:block;
	width:90%;
	padding:1%;
	
}
.foot-div-3
{
	display:inline-block;
	width:40%;
	vertical-align:top;
}
.foot-div-3 h1
{
	padding:5% 0;
	font-size:18px;
	color:#FFFFFF;
}
.KMI-outer
{
	border: 1px solid #FFFFFF;
	border-radius:3px;
	margin:5% 0;
	overflow:hidden;
	padding:1%;
}
.kmi-wrap
{
	background:#FFFFFF;
}
.nl_email
{
	background:#FFFFFF;
	border:none;
	outline:none;
	color:#000000;
	width:56%;
	padding:2%;
}
.nl-button
{
	background:#033652;
	padding:1.2% 2%;
	color:#FFFFFF;
	border:none;
	cursor:pointer;
	float:right;
}
.nl-button img
{
	vertical-align:middle;
}
.nl-button:hover
{
	background-color:#005680;

}
.foot-bottom-text
{
	padding:2% 0;
	text-align:center;
}

</style>

</head>
<body>

	<header>
  <a href="/TEST/my-site"><img src="../../images/logo.png" id="logo"><span id="site-text"> Plenty<span id="bcolor">of</span>words</span></a>
  <div class="option">
      <a href="/Test/my-site/">Home</a>
      <a href="/TEST/my-site/category/startup-advice">Startup Advice</a>
      <a href="/TEST/my-site/category/technology">Technology</a>
      <a href="/TEST/my-site/category/healthcare">HealthCare</a>
      <a href="/TEST/my-site/category/books">Books</a>
      <a href="/TEST/my-site/category/quotes">Quotes</a>
      <a href="/TEST/my-site/write-for-us">Write for us (Paid)</a>
     <span id="search-icon"><img src="../../images/search.png" width="30" height="30" alt="search-icon" id="search-img" onClick="searchVis()"><span id="search-close" onClick="searchHide()">&times;</span></span> 
 </div>
 <div id="search-div">
 	<input type="text" name="search_textbox" id="search-textbox" onKeyUp="searchData()">
    <div id="search-result"></div>
 </div>
</header>
   <section class="post-sec">
    <?php
    if(isset($top_img))
	{
		echo '<div class="post-img"><img src="'.$top_img.'"></div>';
	}
    if(isset($post_heading))
	{
    	echo "<h1>$post_heading</h1>";
	}
    if(isset($post_date))
	{
		echo'<time>'.date('M d, Y',strtotime($post_date)).'</time>';
	}
	if(isset($post_content))
	{
		echo $post_content;
	}
	if(isset($post_tags))
	{
		if(!empty($post_tags))
		{
			$post_tags = explode(',',$post_tags);
			echo '<span class="tags-div">';
			echo '<strong>Tags:</strong>';
			foreach($post_tags as $tgs)
			{
				echo '<a href="tags/'.$categoryget = str_replace(' ','-',strtolower($tgs)).'"><strong>'.$tgs.'</strong></a>';
			}
			echo '</span>';
		}
	}
	?>
    </section>
    <div class="recommend-label">
     	<h1>Recommended For You</h1>
        <div class="triangle-tip"></div>
    </div>
    <section class="top-stories">
    	<span class="tile">
            <img src="../../images/uploads/medical-tourism-india.jpg">
            <h1>startup -advice</h1>
            <p>Lorem ipsum dolor sit amet, consequat sit bibendum, vel wisi metus orci. Vestibulum nam turpis eu ut ultricies.</p>
            <a href="">Learn More</a>
        </span>
        <span class="tile">
            <img src="../../images/uploads/medical-tourism-india.jpg">
            <h1>startup -advice</h1>
            <p>Lorem ipsum dolor sit amet, consequat sit bibendum, vel wisi metus orci. Vestibulum nam turpis eu ut ultricies.</p>
            <a href="">Learn More</a>
        </span>
        <span class="tile">
              <img src="../../images/uploads/medical-tourism-india.jpg">
              <h1>startup -advice</h1>
              <p>Lorem ipsum dolor sit amet, consequat sit bibendum, vel wisi metus orci. Vestibulum nam turpis eu ut ultricies.</p>
              <a href="">Learn More</a>
        </span>
        
    </section>

    <section class="footer">
	<div class="foot-top">
    	<div class="foot-wrap-3-div">
            <div class="foot-div-1">
                <h1>MedHalt</h1>
                <p>At MedHalt, our aim is to make quality and affordable medical treatment a reality for everyone.</p>
            </div>
            <div class="foot-div-2">
                <a>About Us</a>
                <a>Our Blog</a>
                <a>How It Works?</a>
                <a>Frequently Asked Questions</a>
                <a>Terms Of Service</a>
            </div>
            <div class="foot-div-3">
            <h1>The Med Letter</h1>
            <p>You can now make your medical trip worry-free! We will send reliable information on organizing your trip straight to your inbox!</p>
            <div class="KMI-outer">
                <div class="kmi-wrap">
                    <input type="text" class="nl_email" placeholder="Enter your e-mail...">
                    <button class="nl-button" name="newsletter"><img src="http://www.plentyofwords.com/images/contact.png" width="20" height="20" alt="">&nbsp; SUBSCRIBE</button>
                </div>
            </div>
            </div>
    	</div>
        <p class="foot-bottom-text">MedHalt Healthcare Services &copy; 2016</p>    
    </div>
    
</section> 
</body>
</html>