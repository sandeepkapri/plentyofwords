<?php 
include 'DBCONNECT/connect.inc.php';
if(isset($tagsget))
		{
		$selct = "SELECT `page_heading`,`post_content`,`permalink`,`created_date`,`tags`,`crop_img_url` FROM `blog_post` WHERE `tags` LIKE ? AND `publish` = 1";
		$tagsget = str_replace('-',' ',$tagsget);
		$tgs= '%'.$conn->real_escape_string($tagsget).'%';
		if($stmt = $conn->prepare($selct))
		{
			if($stmt->bind_param("s",$tgs))
			{
					if($stmt->execute())
					{
						$stmt->store_result();
						$stmt->bind_result($post_heading_f,$post_content_f,$post_perma_f,$post_date_f,$post_tags_f,$post_cropimg_f);
						$exp = true;
						$row = 0;
						while($stmt->fetch())
						{
							if($exp == true)
							{
								$post_tags_f = explode(',',strtolower($post_tags_f));
							}
							if(in_array($tagsget,$post_tags_f))
							{
								$row++;
								$post_heading[] = $post_heading_f;
								$post_date[] = strtotime($post_date_f);
								$post_content[] = str_replace('&nbsp;',' ',strip_tags(substr($post_content_f,0,600)));
								$post_perma[] = $post_perma_f;
								$post_cropimg[] = $post_cropimg_f;
							}
							if($row == 0)
							{
								header('Location:../404.php');
							}
							$exp = false;
						}
						
					 }
			}
		}
			//recommended
		  $recom_select = "SELECT `page_heading`,`crop_img_url`,`permalink`,`category` FROM `blog_post` WHERE `publish`= 1 ORDER BY RAND() LIMIT 3";
		  if($stmt = $conn->prepare($recom_select))
		  {
			if($stmt->execute())
			{
				$stmt->bind_result($recom_heading_t,$recom_cropimg_t,$recom_permalink_t,$recom_cat_t);
				while($stmt->fetch())
				{
					$recom_heading[] = $recom_heading_t;
					$recom_cropimg[] = $recom_cropimg_t;
					$recom_permalink[]	= $recom_permalink_t;
					$recom_cat[] = explode(',',$recom_cat_t);
				}
				$stmt->close();
			}
		  }
	}
	?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php if(isset($tagsget)) echo ucwords(str_replace('-',' ',$tagsget));?></title>
<link rel="icon" href="images/logo.png">
<base href="/">
<link rel="stylesheet" type="text/css" href="CSS/tags.css">
</head>
<body>
	<?php include 'header.inc.php';?>
    <section class="post-sec">
        <div class="post-tile">
       <?php 
			if(isset($post_heading))
			{
				for($i = 0; $i < sizeof($post_heading); $i++)
				{
					echo '<div class="post-image"><img src="'.$post_cropimg[$i].'"></div>';
					echo '<div class="post-content">';
					echo '<h1>'.$post_heading[$i].'</h1>';
					//echo strtotime($post_date[$i]);
					echo '<time>'.date('M d, Y',$post_date[$i]).'</time>';
					echo '<p>'.$post_content[$i].'...</p>';
					echo '<div class="rtp"><a href="'.$post_perma[$i].'">Read this post</a></div>';
				}
			}
         ?>
        </div>
    </section>
    <div class="recommend-label">
     	<h1>Recommended For You</h1>
        <div class="triangle-tip"></div>
    </div>
    <section class="top-stories">
     <?php
    	for($i = 0; $i < 3; $i++)
		{
			if(!empty($recom_heading[$i]))
			{
				echo '<div class="tile">';
				echo '<img src="'.$recom_cropimg[$i].'">';
				echo ' <h1>'.$recom_cat[$i][0].'</h1>';
				echo ' <p>'.$recom_heading[$i].'</p>';
				echo '<a href="/'.$recom_permalink[$i].'">Read this post</a></div>';
			}
		}
	?>
    </section>
    <div id="nl-notify"></div>
    <?php include 'footer.inc.php'?>
    <script>
    function searchVis()
	{
		document.getElementById('search-div').style.visibility = 'visible';
		document.getElementById('search-img').style.display = 'none';
		document.getElementById('search-close').style.display = 'inline-block';
		document.getElementById('search-textbox').focus();
	}
	function searchHide()
	{
		document.getElementById('search-div').style.visibility = 'hidden';
		document.getElementById('search-img').style.display = 'inline-block';
		document.getElementById('search-close').style.display = 'none';
	}
	function searchData()
	{
		var searchStr = document.getElementById('search-textbox').value;
		if(searchStr.length == 0 )
		{
			document.getElementById('search-result').innerHTML = '';
		}
		else if(searchStr.length >= 1 )
		{
			var xhttp;
			var search_str = "q="+searchStr;
			if(window.XMLHttpRequest)
			{
				xhttp = new XMLHttpRequest();
			}
			else
			{
				xhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			xhttp.onreadystatechange = function()
			{
				
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById('search-result').innerHTML = xhttp.responseText;
				}
			}
			xhttp.open("POST","search.inc.php",true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(search_str);
		}
	}
	function newsletter()
	{
		var nl_email = document.getElementById('nl-email').value;
		var nl_atpos = nl_email.indexOf("@");
    	var nl_dotpos = nl_email.lastIndexOf(".");
		if (nl_atpos < 1 || nl_dotpos < nl_atpos + 2 || nl_dotpos + 2 >= nl_email.length) 
		{
			document.getElementById('nl-notify').style.display = 'block';
			document.getElementById('nl-notify').innerHTML = '<p>Not a valid email.</p>';
			var nl = setInterval(function(){document.getElementById('nl-notify').style.display = 'none';clearInterval(nl)},3000);
				
		}
		else
		{	
			
			var xhttp;
			if(window.XMLHttpRequest)
			{
				xhttp = new XMLHttpRequest();
			}
			else
			{
				xhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById('nl-notify').style.display = 'block';
					document.getElementById('nl-notify').innerHTML = xhttp.responseText;
					var nl = setInterval(function(){document.getElementById('nl-notify').style.display = 'none';clearInterval(nl)},3000);
					document.getElementById('nl-email').value = '';
					
				}
			}
			xhttp.open("POST","subscribe.php",true);
			var nl_text = "nlEmail="+nl_email;
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(nl_text);
			
		}
	}
	function headerToggle(opt)
	{
		if(opt == 'show')
		{
			document.getElementById('option').style.display = "block";
			document.getElementById('toggle').style.display = "none";
			document.getElementById('close-toggle').style.display ="block";
		}
		else
		{
			document.getElementById('close-toggle').style.display ="none";
			document.getElementById('option').style.display = "none";
			document.getElementById('toggle').style.display = "block";
		}
	}
    </script>
</body>
<?php include_once("analyticstracking.php") ?> 
</html>