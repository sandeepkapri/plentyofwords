<?php
include_once '../../INCLUDES/session.inc.php';
include '../../DBCONNECT/connect.inc.php';
if(!isset($_SESSION['user_id']))
{
	header('Location:../../sk-admin/login/');	
}
else if(!isset($_GET['pid']))
{
	header("Location:../");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
     <link rel="icon" href="../../images/logo.png" type="image/png">
	<title>Edit Post &lsaquo; Plentyofwords</title>
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
    .logo
    {
        margin:0 1%;
        width:60px;
        height:20px;
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
        width:13%;
        height:100%;
        display:inline-block;
        vertical-align:top;
        position:fixed;
        font-size:14px;
        margin-top:4%;
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
    .mid-div
    {
        display:inline-block;
        margin:4% 0 0 15%;
        width:60%;
        vertical-align:top;
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
    }
    .line-1 a
    {
        display:inline-block;
        padding:.5% 1%;
        color:#0073AA;
        background:rgba(255,255,255,1.00);
        box-shadow: 0 0 1px 1px #CCCCCC;
    }
    .line-1 a:hover
    {
        background:#0073AA;
        color:#FFFFFF;
        box-shadow:none;
    }
    .inp-heading
    {
        padding:1%;
        width:98%;
        margin:1% 0;
        border:none;
        box-shadow:0 0 1px 1px #DDDDDD;	
        font-size:18px;
    }
    .inp-heading1
    {
        padding:1%;
        width:47.5%;
        margin:1% 0;
        border:none;
        box-shadow:0 0 1px 1px #DDDDDD;	
        font-size:12px;
    }
    .right-div
    {
        width:22%;
        display:inline-block;
        margin:8.5% 0 0 2%;
    }
    .publish
    {
        background:#FFFFFF;
        box-shadow:0 0 1px 1px #DDDDDD;	
        margin-top:3%;
    }
    .publish h1
    {
        font-size:16px;
        line-height:20px;
        color:#23282D;
        padding:4%;
        box-shadow:0 0 1px 1px #DDDDDD;	
    }
    .dp-btn-row
    {
        padding:4%;	
    }
    .dp-btn-row button
    {
        background:#FAFAFA;
        padding:3% 5%;
        border:none;
        border-radius:2px;
        color:#23282D;
        box-shadow:0 0 1px 1px #CCCCCC;	
        outline:none;
        cursor:pointer;
    }
    .dp-btn-row button:hover
    {
        box-shadow:0 0 1px 1px #999999;
    }
	.dp-btn-row a
{
	float:right;
	background:#FAFAFA;
	padding:3% 5%;
	border:none;
	border-radius:2px;
	color:#23282D;
	box-shadow:0 0 1px 1px #CCCCCC;	
	outline:none;
	cursor:pointer;
}
.dp-btn-row a:link
{
	color:#23282D;
}
.dp-btn-row a:hover
{
	box-shadow:0 0 1px 1px #999999;
	color:#23282D;
}
.dp-btn-row a:active
{
	color:#23282D;
}
    .publish-status
    {
        color:#23282D;
        padding:5%;
    }
    .publish-btn
    {
        padding:3% 5%;
        background:#F5F5F5;
        box-shadow:0 0 1px 1px #DDDDDD;
        text-align:right;
    }
    .publish-btn button
    {
        color:#FFFFFF;
        background:#0085BA;
        border:none;
        outline:none;
        border-radius:2px;
        padding:3% 5%;
        cursor:pointer;
        border:1px solid #006799;
    }
    .publish-btn button:hover
    {
        background:#008EC2;
    }
.categories
{
	background:#FFFFFF;
	box-shadow:0 0 3px 1px #DDDDDD;	
	margin:10% 0;
	padding-bottom:4%;
}
.categories h1
{
	font-size:16px;
	line-height:20px;
	color:#23282D;
	padding:4%;
	box-shadow:0 0 1px 1px #DDDDDD;	
}
.add-cat-text
{
	display:inline-block;
	font-size:14px;
	color:#0073AA;
	text-decoration:underline;
	cursor:pointer;
	padding:3% 5%;
}
.add-cat-text:hover
{
	color:#124964;
}
.add-category
{
	padding:3% 5%;
	background:#FFFFFF;
	box-shadow:0 0 1px 1px #DDDDDD;
	display:none;
}
.add-category input
{
	width:96%;
	padding:2%;
	box-shadow:0 0 1px 1px #BFBFBF;	
	border:none;
	margin:5% 0;
}
.add-category div
{
	display:inline-block;
	color:#FFFFFF;
	background:#0085BA;
	border:none;
	outline:none;
	border-radius:2px;
	padding:2% 4%;
	cursor:pointer;
	border:1px solid #006799;
}
.add-category div:hover
{
	background:#0297D3;
}
    .cat-list
    {
        margin:10%;
        padding:2%;
        background:#FDFDFD;
        box-shadow:0 0 1px 1px #DDDDDD;
        max-height:250px;
        overflow:auto;
    }
    
    .cat-list ul
    {
        list-style:none;
        padding:2% 3%;
    }
    .cat-list ul li 
    {
        color:#0073AA;
        border:none;
        font-size:16px;
        line-height:32px;
    }
    .cat-list ul li input[type="checkbox"]
    {
        width:30px;
        color:#0073AA;
        vertical-align:middle;
    }
.tags
{
	background:#FFFFFF;
	box-shadow:0 0 3px 1px #DDDDDD;	
	margin:10% 0;
	padding-bottom:4%;
}
.tags h1
{
	font-size:16px;
	line-height:20px;
	color:#23282D;
	padding:4%;
	box-shadow:0 0 1px 1px #DDDDDD;	
}
.add-tags-text
{
	display:inline-block;
	font-size:14px;
	color:#0073AA;
	text-decoration:underline;
	cursor:pointer;
	padding:3% 5%;
}
.add-text-text:hover
{
	color:#124964;
}
.add-tags
{
	padding:3% 5%;
	background:#FFFFFF;
	box-shadow:0 0 1px 1px #DDDDDD;
	display:none;
}
.add-tags input
{
	width:96%;
	padding:2%;
	box-shadow:0 0 1px 1px #BFBFBF;	
	border:none;
	margin:5% 0;
}
.add-tags div
{
	display:inline-block;
	color:#FFFFFF;
	background:#0085BA;
	border:none;
	outline:none;
	border-radius:2px;
	padding:2% 4%;
	cursor:pointer;
	border:1px solid #006799;
}
.add-tags div:hover
{
	background:#0297D3;
}
    .tags-list
    {
        margin:10%;
        padding:2%;
        background:#FDFDFD;
        box-shadow:0 0 1px 1px #DDDDDD;
        max-height:250px;
        overflow:auto;
    }
    
    .tags-list ul
    {
        list-style:none;
        padding:2% 3%;
    }
    .tags-list ul li 
    {
        color:#0073AA;
        border:none;
        font-size:16px;
        line-height:32px;
    }
    .tags-list ul li input[type="checkbox"]
    {
        width:30px;
        color:#0073AA;
        vertical-align:middle;
    }
	.messages
	{
		margin:2% 0;
	}
     .messages .green
     {
        border-left:3px solid #118E23;
		color:#000000;
		background:#FFFFFF;
		padding:2%;
     }
     .post-del
     {
         cursor:pointer;
     }
     .post-del:hover
     {
         color:#0F84CF;
     }
    </style>
   
</head>
<body>
<header>
  <a href=""><img src="../../images/logo.png" alt="logo" id="logo"><span id="site-text"> Plenty<span id="bcolor">of</span>words</span></a>
  <?php if(isset($_SESSION['user_id']))echo '<a href="../sk-admin/logout/" class="logout">Log Out</a>';?>
</header>
<section class="left-div">
	<a href="../">All Posts</a>
    <a href="../new">Add New</a>
</section>
<form action="" method="post">
<section class="mid-div">
	<div class="messages"><?php include 'edit_write.php';include 'edit_read.php'; ?></div>
    <div class="line-1"><h1>Edit Post</h1><a href="../new">Add New</a></div></div>
    <input type="text" name="new_heading" placeholder="Heading..." class="inp-heading" autofocus value="<?php if(isset($r_heading)) echo $r_heading;?>"title="Heading">
   	<input type="text" name="new_image" placeholder="Top image URL..." class="inp-heading1" value="<?php if(isset($r_topimg)) echo $r_topimg;?>" title="Top Image URL">
    <input type="text" name="cropped" placeholder="Cropped image URL..." class="inp-heading1" value="<?php if(isset($r_cropped)) echo $r_cropped;?>" title="Cropped Image URL">
    <input type="text" name="meta_desc" placeholder="Meta Description..." class="inp-heading1" value="<?php if(isset($r_metadesc)) echo $r_metadesc;?>" title="Meta Description">
    <input type="text" name="permalink" placeholder="Permalink..." class="inp-heading1" value="<?php if(isset($r_perma)) echo $r_perma;?>" title="Permalink"><br><br>
    <textarea id="editor" name="editor" placeholder="content"><?php if(isset($r_content)) echo $r_content;?></textarea>
</section>
<section class="right-div">
	<div class="publish">
    	<h1>Publish</h1>
        <div class="dp-btn-row">
        	<?php 
			if(isset($r_publish))
			{
				if($r_publish == 0)
				{
					echo '<button name="save_draft" value="save-draft">Save Draft</button>';
				}
			}
			?>
            <a href="" class="preview-btn" target="_blank">Preview</a>
        </div>
        <div class="publish-status">Status:<strong>
       <?php 
	   		if(isset($r_publish))
			{
				if($r_publish == 1)
				{
					echo 'Published';
				}
				else
				{
					echo 'Draft';
				}
			}
			?>
        </strong></div>
         <?php 
			if(isset($r_publish))
			{
				if($r_publish == 1)
				{
					echo '<div class="publish-btn"><button name="update" value="update">Update</button></div>';
				}
				else
				{
					echo '<div class="publish-btn"><button name="publish" value="publish">Publish</button></div>';
				}
			}
			?>
    </div>
    <div class="categories">
    	<h1>Categories</h1>
        <div class="cat-list">
        	<ul>
            	<?php
                $selcat = "SELECT `cat` FROM `blog_cat`";
				if($res = mysqli_query($conn,$selcat))
				{
				while($row = $res->fetch_assoc())
				{
					 echo '<li><label><input type="checkbox" name="new_cat[]" value="'.$row['cat'].'"';
					 if(isset($r_cat))checkboxset($r_cat,$row['cat']);
					 echo '>'.$row['cat'].'</label></li>';
				}
				}
				else
				{
					echo 'No Categories';
				}
				?>
            </ul>
        </div>
        <span class="add-cat-text">+ Add New Category</span>
        <div class="add-category">
        <input type="text" name="addcat" class="addcat-inp">
        <div class="add-cat-btn">Add New Category</div>
        </div>
    </div>
    <div class="tags">
    	<h1>Tags</h1>
        <div class="tags-list">
        	<ul>
            	<?php
                $seltags = "SELECT `tags` FROM `blog_tags`";
				if($res = mysqli_query($conn,$seltags))
				{
					while($row = $res->fetch_assoc())
					{
						 echo '<li><label><input type="checkbox" name="new_tags[]" value="'.$row['tags'].'"';
						 if(isset($r_tags))checkboxset($r_tags,$row['tags']);
						 echo '>'.$row['tags'].'</label></li>';
					}
				}
				else
				{
					echo 'No Tags.';
				}
				?>
            </ul>
        </div>
        <span class="add-tags-text">+ Add New Tags</span>
        <div class="add-tags">
        <input type="text" name="addtags" class="addtags-inp">
        <div class="add-tags-btn">Add New Tags</div>
        </div>
    </div>
</section>
</form>
 <!--script src="https://code.jquery.com/jquery-2.2.2.min.js" integrity="sha256-36cp2Co+/62rEAAYHLmRCPIych47CvdM+uTBJwSzWjI=" crossorigin="anonymous"></script-->
    <script src="../../SCRIPTS/jquery.js"></script>  
	<script>
	$(document).ready(function(e) {
		$('.add-cat-text').click(function(e) {
          $('.add-category').toggle();  
        });
		$('.add-tags-text').click(function(e) {
          $('.add-tags').toggle();  
        });
        $('.add-cat-btn').click(function(e) {
			var cat = $('.addcat-inp').val();
       		 $.ajax({
				url:'add_cat.php',
				type:'POST',
				data:{cat:cat},
				success: function(result)
				{
					if(result != '-')
					{
						if(result == '--')
						{
							alert('Category already exist.');
						}
						else
						{
						var appText = '<li><label><input type="checkbox" checked name="new_cat[]" value="'+result+'">'+result+'</label></li>';
						alert('Category Added.');
						$('.cat-list ul').append(appText);
						$('.addcat-inp').val('');
						}
					}
				}
			});
    	});
		$('.add-tags-btn').click(function(e) {
			var tags = $('.addtags-inp').val();
       		 $.ajax({
				url:'add_tags.php',
				type:'POST',
				data:{tags:tags},
				success: function(result)
				{
					if(result != '-')
					{
						if(result == '--')
						{
							alert('Tag already exist.');
						}
						else
						{
						var appText = '<li><label><input type="checkbox" checked name="new_tags[]" value="'+result+'">'+result+'</label></li>';
						alert('Tag Added.');
						$('.tags-list ul').append(appText);
						$('.addtags-inp').val('');
						}
					}
				}
			});
    	});
    });
	</script> 
 <script src="../ck/ckeditor.js"></script>
 <script src="../ck/sample.js"></script>
<script>
	initSample();
</script>
</body>
</html>