<?php
function checkboxset($param1,$param2)
{
	if(isset($param1))
	{
		if(in_array($param2,$param1))
		{
			echo 'checked';
		}
	}	
}
if(isset($_GET['pid']))
{
	$pid = $conn->real_escape_string($_GET['pid']);
	$select = "SELECT `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`,`category`, `tags`,`publish`,`published_date` FROM `blog_post` WHERE `page_id` = ?";
	//$stmt->close();
	if($stmt = $conn->prepare($select))
	{	
	if($stmt->bind_param('s',$pid))
	{
		if($stmt->execute())
		{
			$stmt->bind_result($r_heading,$r_topimg,$r_cropped,$r_metadesc,$r_perma,$r_content,$r_cat,$r_tags,$r_publish,$r_pdate);
			$stmt->fetch();
			$r_cat = explode(",",$r_cat);
			$r_tags = explode(",",$r_tags);
			$stmt->close();
			
			
		}
	}
}
}

?>