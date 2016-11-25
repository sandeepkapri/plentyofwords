<?php
include 'DBCONNECT/connect.inc.php';
$selct = "SELECT bp.page_heading, bp.post_content, bp.permalink, bp.created_date, bp.crop_img_url
		  FROM blog_post As bp
		  INNER JOIN home_listing As h
		  ON bp.page_id = h.page_id 
		  AND bp.publish = 1";
if($stmt = $conn->prepare($selct))
{
	if($stmt->execute())
	{
		$stmt->store_result();
		$stmt->bind_result($post_heading_f,$post_content_f,$post_perma_f,$post_date_f,$post_cropimg_f);
		while($stmt->fetch())
		{
			$post_heading[] = $post_heading_f;
			$post_date[] = strtotime($post_date_f);
			$clean_content = str_replace('&nbsp;',' ',strip_tags($post_content_f));
			$index_val = strpos($clean_content, ' ', 500);
			$post_content[] = substr($clean_content,0,$index_val);
			$post_perma[] = $post_perma_f;
			$post_cropimg[] = $post_cropimg_f;
		}
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Plentyofwords</title>
<meta name="description" content="Plentyofwords is a modern tech media platform which provides stories on startups, business, healthcare, books and other  indispensable things.">
<link rel="icon" href="/images/logo.png">
<meta name="theme-color" content="#000000" />
<?php include 'INCLUDES/stylesheet.php';?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-3961923193652221",
          enable_page_level_ads: true
     });
</script>
</head>
<body id="home">
	<?php include 'header.inc.php';?>
	<div class="swipe-to-slide"> &laquo; &nbsp; swipe &nbsp; &raquo;</div>
    <section class="post-slider" id="img-slider">
           <?php 
			if(isset($post_heading))
			{
				for($i = 0; $i < sizeof($post_heading); $i++)
				{
					echo '<article class="slider-tile-wrap" id="slide'.$i.'">';
					echo '<div class="post-tile">';
					echo '<div class="post-image"><img src="'.$post_cropimg[$i].'"></div>';
					echo '<div class="post-content">';
					echo '<h1>'.$post_heading[$i].'</h1>';
					echo '<time>'.date('M d, Y',$post_date[$i]).'</time>';
					echo '<p>'.$post_content[$i].' ...</p>';
					echo '<div class="rtp"><a href="'.$post_perma[$i].'">Read this post</a></div>';
					echo '</div></div>';
					echo ' </article>';
				}
			}
            ?>
        <div class="control-left" onClick="left()">&#9664;</div>
        <div class="control-right" onClick="right()">&#9654;</div>
        <!--img src="/images/arrows-1.png" class="control-right" width="30" height="50" alt="right-arrow-icon" title="Right" onClick="right()"-->
    </section>
        <div class="category-label">
     	<h1>Categories </h1>
        <p>Start reading from your favourite category.</p>
        <div class="triangle-tip"></div>
    </div>
    <section class="category">
    	 <a href="/category/startup-advice">
            <div class="tile">
                <div class="image-category image-1"></div>
                <h1>Startup Advice</h1>
            </div>
         </a>
         <a href="/category/technology">
            <div class="tile">
                <div class="image-category image-2"></div>
                <h1>Technology</h1>
            </div>
         </a>
         <a href="/category/billionarie">
            <div class="tile">
                <div class="image-category image-3"></div>
                <h1>Billionarie</h1>
            </div>
         </a>
         <a href="/category/automobile"> 
            <div class="tile">
                <div class="image-category image-4"></div>
                <h1>Automobile</h1>
            </div>
         </a>
        <a href="/category/healthcare">
            <div class="tile">
            <div class="image-category image-5"></div>
            <h1>HealthCare</h1>
        	</div>
        </a>
        <a href="/category/books">
            <div class="tile">
            <div class="image-category image-6"></div>
            <h1>Books</h1>
        	</div>
        </a>
        <a href="/category/quotes">
            <div class="tile">
            <div class="image-category image-7"></div>
            <h1>Quotes</h1>
        	</div>
        </a>
        <a href="/category/business">
            <div class="tile">
            <div class="image-category image-8"></div>
            <h1>Business</h1>
        	</div>
        </a>
        <a href="/category/trending">
            <div class="tile">
            <div class="image-category image-9"></div>
            <h1>Trending</h1>
        	</div>
        </a>      
    </section>
     <div id="nl-notify"></div>
    <?php include 'footer.inc.php'?>
<script> 
var totImg = document.getElementById('img-slider').getElementsByTagName('article').length;
var imgArray = [];
var even;
if((totImg % 2) == 0)
{
	even = true;
}
else
{
	even = false;
}
var imgMidVal = parseInt(totImg/2);

for(i = imgMidVal; i < totImg; i++)
{
  imgArray[i] = i - imgMidVal;	
}
for(i = 0; i < imgMidVal; i++)
{
  if(even == true)
  {
	imgArray[i] = imgMidVal + i;	
  }
  else
  {
	  imgArray[i] = imgMidVal + i + 1;	
  }
}
function right()
{
	for(i = imgMidVal; i < totImg; i++)
	{
	  if(i != imgArray[imgMidVal] || i != imgArray[imgMidVal+1])
		{
			var arraneImgId = 'slide'+(imgArray[i]);
			var arraneImg = document.getElementById(arraneImgId);
			arraneImg.style.transition = 'none';
			arraneImg.style.left = '100%';
		}
	}
	for(i = 0; i < imgMidVal; i++)
	{
	    if(i != imgArray[imgMidVal] || i != imgArray[imgMidVal+1])
		{
		var arraneImgId = 'slide'+(imgArray[i]);
		var arraneImg = document.getElementById(arraneImgId);
		arraneImg.style.transition = 'none';
		arraneImg.style.left = '-100%';
		}
	}
	var curImgId = 'slide' + imgArray[imgMidVal];
	var currentImg = document.getElementById(curImgId);
	var nextImgId = 'slide' + imgArray[imgMidVal + 1];
	var nextImg = document.getElementById(nextImgId);
	currentImg.style.transition = '.5s';
	currentImg.style.left = '-100%';
	nextImg.style.transition = '.5s';
	nextImg.style.left = 0;
	
	var temp1 = imgArray[0];
	for(i = 0; i < totImg-1; i++)
	{
		imgArray[i] = imgArray[i+1];//shifting	
	}
	imgArray[totImg-1] = temp1;
	
}
function left()
{	
	for(i = imgMidVal; i < totImg; i++)
	{
	  if(i != imgArray[imgMidVal] || i != imgArray[imgMidVal+1])
		{
			var arraneImgId = 'slide'+(imgArray[i]);
			var arraneImg = document.getElementById(arraneImgId);
			arraneImg.style.transition = 'none';
			arraneImg.style.left = '100%';
		}	
	}
	for(i = 0; i < imgMidVal; i++)
	{
	    if(i != imgArray[imgMidVal] || i != imgArray[imgMidVal+1])
		{
		var arraneImgId = 'slide'+(imgArray[i]);
		var arraneImg = document.getElementById(arraneImgId);
		arraneImg.style.transition = 'none';
		arraneImg.style.left = '-100%';		
		}
	}
	var curImgId = 'slide' + imgArray[imgMidVal];
	var currentImg = document.getElementById(curImgId);
	var preImgId = 'slide' + imgArray[imgMidVal - 1];
	var preImg = document.getElementById(preImgId);
	currentImg.style.transition = '.5s';
	currentImg.style.left = '100%';
	preImg.style.transition = '.5s';
	preImg.style.left = 0;
	var temp1 = imgArray[0];
	var temp2 = imgArray[totImg-1];
	for(i = totImg-1; i > 0; i--)
	{
		imgArray[i] = imgArray[i-1];//shifting		
	}
	imgArray[0] = temp2;
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
var dir,startX,startY,distX,distY,startTime,elapsedTime;
function onSwipe(e)
{
	var touchObj = e.changedTouches[0];
	distX = touchObj.pageX - startX;
	distY = touchObj.pageY - startY;
	elapsedTime = new Date().getTime() - startTime;
	if((Math.abs(distX) > Math.abs(distY)) && Math.abs(distX) > 60 && elapsedTime >100)
	{
		dir = (distX > 0)? 'left' : 'right';
		//console.log(dir+'-->'+elapsedTime);
		if(dir == 'left')
		{
			left();
		}
		if(dir == 'right')
		{
			right();
		}
	}
}
function onTouch(e)
{
	var touchObj = e.changedTouches[0];
	dist = 0;
	startX = touchObj.pageX;
	startY = touchObj.pageY;
	startTime = new Date().getTime();
}
var elSlider = document.getElementById('img-slider');//Slider Element
elSlider.addEventListener('touchend',onSwipe,false);
elSlider.addEventListener('touchstart',onTouch,false);
</script>
<?php include_once("analyticstracking.php") ?> 
</body>
</html>