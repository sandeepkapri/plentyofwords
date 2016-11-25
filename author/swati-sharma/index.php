<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Swati Sharma - Plentyofwords</title>
<link rel="icon" href="../../images/logo.png">

<style>

@media only screen and (min-width:1101px)
{
.not-found
{
	padding:5%;
	margin-top:5%;
	text-align:center;
}
.not-found h1
{
	font-size:96px;
}
.not-found p
{
	font-size:36px;
}
}
@media only screen and (max-width:1100px)
{
.not-found
{
	padding:5%;
	margin:30% 0;
	text-align:center;
}
.not-found h1
{
	font-size:96px;
}
.not-found p
{
	font-size:36px;
}
}
@media only screen and (max-width:320px)
{
#nl-email
{
	width:45%;
}
}
@media only screen and (min-width:530px) and (max-width:1100px)
{
#nl-email
{
	padding:1.7%;
}
}
</style>
</head>
<body>
	<?php include '../../header.inc.php';?>
   	<section class="not-found">
    	<h1>Swati Sharma</h1>
    	<p>Former Content Writer</p><br><br>
        <p>You are viewing alpha version of this page. Rest of the content is not available for General Public.</p><br><br>
   	</section>
        <div class="category-label">
     	<h1>Categories </h1>
        <p>This will make your search easy.</p>
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
    <?php include '../../footer.inc.php'?>
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
		else if(searchStr.length >= 3 )
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
</html>