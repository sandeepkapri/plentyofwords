<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['publish']) || isset($_POST['save_draft']))
	{
		if(isset($_GET['pid']))
		{
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
				$pid = $conn->real_escape_string($_GET['pid']); 
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
				$update = 'UPDATE `blog_post` SET `page_heading`=?, `top_img_url`=?, `crop_img_url`=?, `meta_desc`=?, `permalink`=?, `post_content`=?, `category`=?,`tags`=?, `publish`=? WHERE `page_id`=?';
				if($stmt = $conn->prepare($update))
				{
					if($stmt->bind_param('ssssssssis',$heading, $img_link, $cropped_link, $meta_desc, $permalink, $editor_text, $cat,$tags, $publish, $pid))
					{
						if($stmt->execute())
						{	
							echo '<p class="green">Post edited Successfully.</p>';
							$stmt->close();
						}
					}
				}
				$insert = "INSERT INTO `edited_data`(`page_id`, `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`, `category`,`tags`, `publish`, `modified_userid`, `modified_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,now())";
				if($stmt = $conn->prepare($insert))
				{
					if($stmt->bind_param('sssssssssis',$pid, $heading, $img_link, $cropped_link, $meta_desc, $permalink, $editor_text, $cat,$tags, $publish,$userid))
					{
						if($stmt->execute())
						{	
							$stmt->close();
						}
						
					}
				}
			}
		}
	}
	elseif(isset($_POST['update']))
	{
		if(isset($_GET['pid']))
		{
			//0->Draft
			//1 ->Publish
			$publish = 1;	
			$heading = $_POST['new_heading'];
			$editor_text = $_POST['editor'];	//'post_content'
			$img_link = $_POST['new_image'];	//'top_img_url'
			$cropped_link = $_POST['cropped'];
			$meta_desc = $_POST['meta_desc'];
			$permalink = $_POST['permalink'];
			$userid = $_SESSION['user_id'];
			$pid = $conn->real_escape_string($_GET['pid']); 
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
			$update = 'UPDATE `blog_post` SET `page_heading`=?, `top_img_url`=?, `crop_img_url`=?, `meta_desc`=?, `permalink`=?, `post_content`=?, `category`=?,`tags`=?, `publish`=? WHERE `page_id`=?';
			if($stmt = $conn->prepare($update))
			{
				if($stmt->bind_param('ssssssssis',$heading, $img_link, $cropped_link, $meta_desc, $permalink, $editor_text, $cat,$tags, $publish, $pid))
				{
					if($stmt->execute())
					{	
						echo '<p class="green">Post edited Successfully.</p>';
						$stmt->close();
					}
					
				}
			}
			$insert = "INSERT INTO `edited_data`(`page_id`, `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`, `category`,`tags`, `publish`, `modified_userid`, `modified_date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,now())";
			if($stmt = $conn->prepare($insert))
			{
				if($stmt->bind_param('sssssssssis',$pid, $heading, $img_link, $cropped_link, $meta_desc, $permalink, $editor_text, $cat,$tags, $publish,$userid))
				{
					if($stmt->execute())
					{	
						$stmt->close();
					}
					
				}
			}
		}
	}
	else
	{
		echo '<p class="green">No Such Page Exists.</p>';
	}
}
?>