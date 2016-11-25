<?php 
include 'DBCONNECT/connect.inc.php';
if(isset($post_get))
{
	  $step1 = false;
	  $selct = "SELECT `page_id`,`page_heading`,`post_content`,`created_date`,`top_img_url`,`tags` FROM `blog_post` WHERE `permalink`=?";
	  $permalink = $conn->real_escape_string($post_get);
	  if($stmt = $conn->prepare($selct))
	  {
		  if($stmt->bind_param("s",$permalink))
		  {
				  if($stmt->execute())
				  {
					  $stmt->store_result();
					  $post_row = $stmt->num_rows;
					  $stmt->bind_result($pageid,$post_heading,$post_content,$post_date,$top_img,$post_tags);
					  $stmt->fetch();
					  $step1 = true;
					  $stmt->close();
				   }
				   if($post_row == 0)
				   {
					   header('Location:404.php');
				   }
		  }
	  }
	  if($step1 == true)
	  {
		  $select = "SELECT `comm_text`, `comm_user`, `comm_date` FROM `blog_comment` WHERE `page_id`= ? AND `comm_status` = 1 ORDER BY `comm_date` DESC";
		  if($stmt = $conn->prepare($select))
		  {
			  if($stmt->bind_param('s',$pageid))
			  {
				  if($stmt->execute())
				  {
					  $stmt->bind_result($commtext_c,$commuser_c,$commdate_c);
					  while($stmt->fetch())
					  {
						  $commtext[] = $commtext_c;
						  $commuser[] = $commuser_c;
						  $commdate[] = strtotime($commdate_c);
					  }
					  $stmt->close();
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
	}
	?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="og:url" content="http://www.plentyofwords.com/<?php if(isset($permalink)){echo $permalink;} ?>" />
<meta property="fb:app_id" content="930709117059784"/>
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php if(isset($post_heading)){echo $post_heading;} ?>" />
<meta property="og:description" content="<?php if(isset($post_content)){echo substr(str_replace('&nbsp;', ' ',strip_tags($post_content)),0,300);} ?>" />
<meta property="og:image" content="<?php if(isset($top_img)){echo $top_img;} ?>" />
<title><?php if(isset($post_heading)) echo $post_heading;?></title>
<link rel="icon" href="/images/logo.png">
<base href="/">
<?php include 'INCLUDES/stylesheet.php';?>
<style>
    .space-cor{
        margin-top:10%;
        
    }
</style>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-3961923193652221",
          enable_page_level_ads: true
     });
</script>
</head>
<body id="post">
	<?php include 'header.inc.php';?>
	<div class="space-cor"></div>
    <section class="post-sec">
    <?php
    if(isset($top_img) && !empty($top_img))
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
		echo '<div class="post-content">'.$post_content.'</div>';
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
				echo '<a href="/tags/'.$categoryget = str_replace(' ','-',strtolower($tgs)).'"><strong>'.$tgs.'</strong></a>';
			}
			echo '</span>';
		}
	}
	?>
    </section>
    <a href="#top" onclick="scrollToTop();return false" id="to-top">&uarr;</a>
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
    <div class="recommend-label">
     	<h1>comments</h1>
        <div class="triangle-tip"></div>
    </div>
    <section id="comment">
            <div id="write-comment">
                <textarea placeholder="Put a comment..." rows="4" id="comm-text"></textarea>
                <input type="text" name="comm_username" placeholder="Name" maxlength="40" id="comm-username">
                <input type="email" name="comm_email" placeholder="Email" maxlength="40" id="comm-email">
                <button onClick="addComment()" id="comment-button">Comment</button>
                <div id="comment-error"></div>
        	</div>
        	 <div id="comment-wrap">
                <?php
                if(isset($commuser))
				{
					if(sizeof($commuser) > 0)
					{
						for($i = 0; $i < sizeof($commuser); $i++)
						{
							echo '<div class="comment-tile">';
							echo '<div class="username">'.htmlspecialchars($commuser[$i]).'</div>';
							echo '<div class="comment-date">'.date('M d, Y',$commdate[$i]).'</div>';
							echo '<div class="comment-text">'.htmlspecialchars($commtext[$i]).'</div>';
							echo '</div>';	
						}
						if(sizeof($commuser) > 4)
						echo '<div class="view-all-btn"><span id="view-all" onClick="showComment()">View All Comments</span></div>';
					}
					else
					{
						echo '<p class="no-comment">No comments for this post.</p>';
					}
				}
                ?>
        </div>
    </section>
    <section class="social-icon">
    	 <a class="share-logo"><span></span></a>
    	<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.plentyofwords.com/<?php echo  $permalink; ?>" class="facebook-logo"><span></span></a>
        <a href="https://plus.google.com/share?url=http://www.plentyofwords.com/<?php echo  $permalink; ?>" class="gplus-logo"><span></span></a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=http://www.plentyofwords.com/<?php echo  $permalink; ?>&title=<?php echo $post_heading; ?>&summary=&source=" class="linkedin-logo"><span></span></a>    	
    </section>
    <div id="nl-notify"></div>
    <?php include 'footer.inc.php'?> 
    <script>
    var timeOut;
		function scrollToTop() 
		{
			if (document.body.scrollTop != 0 || document.documentElement.scrollTop != 0)
			{
				window.scrollBy(0,-50);
				timeOut = setTimeout('scrollToTop()',10);
			}
			else 
			{
				clearTimeout(timeOut);
			}
		}
	document.addEventListener('scroll',showToTop);
	function showToTop()
	{
		if (document.body.scrollTop < 400)
		{
			document.getElementById('to-top').style.display = 'none';
		}
		else
		{
			document.getElementById('to-top').style.display = 'inline-block';	
		}
	}
	function showComment()
	{
		document.getElementById('view-all').style.display = 'none';
		var commentObj = document.getElementById('comment');
		var commentTag = commentObj.getElementsByClassName('comment-tile');
		for(i = 2; i < commentTag.length ; i++)
		{
		commentTag.item(i).style.display = 'block';
		}
	}
	var errorVal;
	function validateData(val3)
	{
		var atpos = val3.indexOf("@");
    	var dotpos = val3.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= val3.length) 
		{
			errorVal = true;
		}
		else
		{
			errorVal = false;	
		}
	}
	function ajaxReq(v1,v2,v3)
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
				document.getElementById('comment-error').innerHTML = xhttp.responseText;
				var commentId = document.getElementById('comment-wrap');
				var commentTileDiv = document.createElement('div');
				var nameDiv = document.createElement('div');
				var dateDiv = document.createElement('div');
				var commentDiv = document.createElement('div');
				var nameTextNode = document.createTextNode(v2);
				var dateTextNode = document.createTextNode('22-5-2016');
				var commentTextNode = document.createTextNode(v1);
				commentTileDiv.className = 'comment-tile';
				nameDiv.className = 'username';
				dateDiv.className = 'comment-date';
				commentDiv.className = 'comment-text';
				nameDiv.appendChild(nameTextNode);
				dateDiv.appendChild(dateTextNode);
				commentDiv.appendChild(commentTextNode);
				commentTileDiv.appendChild(nameDiv);
				commentTileDiv.appendChild(dateDiv);
				commentTileDiv.appendChild(commentDiv);
				commentId.insertBefore(commentTileDiv,commentId.childNodes[1]);
				document.getElementById('comm-text').value = '';
				document.getElementById('comm-username').value = '';
				document.getElementById('comm-email').value = '';
				
			}
		}
		xhttp.open("POST","add_comment.php",true);
		var postData = "commText="+v1+"&commUsername="+v2+"&commEmail="+v3+"&pid=<?php if(isset($pageid)) echo $pageid ?>";
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send(postData);
	}
	function addComment()
	{
		var commentText = document.getElementById('comm-text').value;
		commentText = commentText.replace(/^\s+|\s+$/gm,'');
		var commentUsername = document.getElementById('comm-username').value;
		commentUsername = commentUsername.replace(/^\s+|\s+$/gm,'');
		var commentEmail = document.getElementById('comm-email').value;
		commentEmail = commentEmail.replace(/^\s+|\s+$/gm,'');
		if(commentText.length != 0 && commentText !=' ' && commentUsername.length != 0 && commentUsername != ' ' && commentEmail != 0)
		{
			validateData(commentEmail);
			if(errorVal != true)
			{
				ajaxReq(commentText,commentUsername,commentEmail);
				document.getElementById('comment-error').innerHTML = responseText;
				
			}
			else
			{
				document.getElementById('comment-error').innerHTML = '&emsp; Invalid Email-id.';
			}
		}
		else
		{
			document.getElementById('comment-error').innerHTML = '&emsp; Oops! It seems like you have missed something.';	
		}
		
	}
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
    <?php include_once("analyticstracking.php") ?> 
</body>
</html>