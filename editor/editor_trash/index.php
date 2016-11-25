<?php
include_once '../../INCLUDES/session.inc.php';
include '../../DBCONNECT/connect.inc.php';
if(isset($_GET['trash']))
	{
		if(!empty($_GET['trash']))
		{
			$step1 = false;
			$step2 = false;
			$trash = $conn->real_escape_string($_GET['trash']);
			$del_by = $_SESSION['user_id'];
			$select = 'SELECT `page_id`, `user_id`, `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`, `category`,`tags`,`publish`, `created_date`, `published_date`, `counter_view` FROM `blog_post` WHERE `page_id` = ?';
			if($stmt = $conn->prepare($select))
			{
				if($stmt->bind_param('s',$trash))
				{
					if($stmt->execute())
					{
						$stmt->bind_result($t_pageid, $t_userid, $t_pageheading, $t_topimg, $t_crop, $t_metadesc, $t_permalink, $t_postcontent, $t_category,$t_tags, $t_publish, $t_createddate, $t_publisheddate, $t_counterview);
						$stmt->fetch();
						$step1 = true;
						$stmt->close();
					}
				}
			}
			if($step1 == true)
			{
				$insert = "INSERT INTO `editor_trash`(`page_id`, `user_id`, `page_heading`, `top_img_url`, `crop_img_url`, `meta_desc`, `permalink`, `post_content`, `category`,`tags`, `publish`, `created_date`, `published_date`, `counter_view`,`del_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				if($stmt = $conn->prepare($insert))
				{
					if($stmt->bind_param('ssssssssssissis',$t_pageid, $t_userid, $t_pageheading, $t_topimg, $t_crop, $t_metadesc, $t_permalink, $t_postcontent, $t_category,$t_tags, $t_publish, $t_createddate, $t_publisheddate, $t_counterview,$del_by))
					{
						if($stmt->execute())
						{
							$step2 = true;
							$stmt->close();
						}
					}
					
				}
			}
			
			if($step2 == true)
			{
				$delete = "DELETE FROM `blog_post` WHERE `page_id` = ?";
				if($stmt = $conn->prepare($delete))
				{
					if($stmt->bind_param('s',$trash))
					{
						if($stmt->execute())
						{
							//echo '<p class="green">1 post has been deleted.</p>';
							header('Location:../');
						}
					}
					$stmt->close();
				}
			}
			
		}
	}
?>