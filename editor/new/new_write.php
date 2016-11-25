<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['publish']) || isset($_POST['save_draft']))
	{
		//0->Draft
		//1 ->Publish
		if(isset($_POST['publish']))
		{
		  if($_POST['publish'] == 'publish')
		  {
			  $publish = 1; 	
		  }
		}
		if(isset($_POST['save_draft']))
		{
		  if($_POST['save_draft'] == 'save-draft')
		  {
			  $publish = 0;	
		  }	
		}
		$heading = $_POST['new_heading'];
		$editor_text = $_POST['editor'];	//'post_content'
		$img_link = $_POST['new_image'];	//'top_img_url'
		$cropped_link = $_POST['cropped'];
		$meta_desc = $_POST['meta_desc'];
		$permalink = $_POST['permalink'];
		$userid = $_SESSION['user_id'];
		$unique_id = md5(uniqid(rand(99,99999),true));	//'page_id'
		if(isset($_POST['new_cat']))
		{
			$cat = implode(',',$_POST['new_cat']);
		}
		else
		{
			$cat = "";
		}
		if(isset($_POST['new_tags']))
		{
			$tags = implode(',',$_POST['new_tags']);
		}
		else
		{
			$tags = "";
		}
		$insert = 'INSERT INTO `blog_post`(`page_id`, `user_id`, `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`, `category`,`tags`, `publish`, `created_date`, `counter_view`) VALUES (?,?,?,?,?,?,?,?,?,?,?,now(),0)';
		if($stmt = $conn->prepare($insert))
		{
			if($stmt->bind_param('ssssssssssi',$unique_id, $userid, $heading, $img_link, $cropped_link, $meta_desc, $permalink, $editor_text, $cat,$tags,$publish))
			{
				if($stmt->execute())
				{	
					header('Location:../edit/?pid='.$unique_id);
				}
			}
		}
	}
	elseif(isset($_POST['preview']))
	{
		//0->Draft
		//1 ->Publish
		$publish = 0;	
		$heading = $_POST['new_heading'];
		$editor_text = $_POST['editor'];	//'post_content'
		$img_link = $_POST['new_image'];	//'top_img_url'
		$cropped_link = $_POST['cropped'];
		$meta_desc = $_POST['meta_desc'];
		$permalink = $_POST['permalink'];
		$userid = $_SESSION['user_id'];
		$unique_id = md5(uniqid(rand(99,99999),true));	//'page_id'
		if(isset($_POST['new_cat']))
		{
			$cat = implode(',',$_POST['new_cat']);
		}
		else
		{
			$cat = "";
		}
		if(isset($_POST['new_tags']))
		{
			$tags = implode(',',$_POST['new_tags']);
		}
		else
		{
			$tags = "";
		}
		$insert = 'INSERT INTO `blog_post`(`page_id`, `user_id`, `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`, `category`,`tags`, `publish`, `created_date`, `counter_view`) VALUES (?,?,?,?,?,?,?,?,?,?,?,now(),0)';
		if($stmt = $conn->prepare($insert))
		{
			if($stmt->bind_param('ssssssssssi',$unique_id, $userid, $heading, $img_link, $cropped_link, $meta_desc, $permalink, $editor_text, $cat,$tags,$publish))
			{
				if($stmt->execute())
				{	
					
				}
			}
		}
	}
	 else
	{
		echo 'You are being watched.';	
	}
	
}
?>