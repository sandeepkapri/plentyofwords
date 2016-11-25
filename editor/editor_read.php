<?php 

if(isset($_GET['post_type']))
{
	$pub = 0;
	$mine = 0;
	$tot_post = 0;
	$uid =$_SESSION['user_id'];
	$sel_all_query = "SELECT `user_id`,`publish` FROM `blog_post` WHERE `user_id` = '$uid' ";
	$result = mysqli_query($conn,$sel_all_query);
		while($row = $result->fetch_assoc())
		{
			$tot_post++;
			if($row['publish'] == 1)
			{
				$pub++;
			}
			if($row['user_id'] == $_SESSION['user_id'])
			{
				$mine++;
			}
			
		}
	$draft = $tot_post - $pub;
	
	
	if($_GET['post_type'] == 'published')
	{
		$post_type_user = $conn->real_escape_string($_SESSION['user_id']);
		$select = "SELECT b.user_id, b.page_id, b.page_heading, b.category,b.tags, b.publish, b.published_date, b.counter_view, e.user_fname FROM `blog_post` b INNER JOIN `editor_user` e ON b.user_id = e.user_id WHERE b.user_id = ? AND b.publish = 1 " ;
if($stmt = $conn->prepare($select))
{
	if($stmt->bind_param('s',$post_type_user))
	{
		if($stmt->execute())
		{
			$stmt->bind_result($e_user,$e_pageid,$e_heading,$e_cat,$e_tags,$e_publish,$e_pdate,$e_view,$e_username);
			while($stmt->fetch())
			{
				$ed_user[] = $e_user;
				$ed_pageid[] = $e_pageid;
				$ed_heading[] = $e_heading;
				$ed_cat[] = $e_cat;
				$ed_tags[] = $e_tags;
				$ed_publish[] = $e_publish;
				$ed_pdate[] = $e_pdate;
				$ed_view[] = $e_view;
				$ed_username[] = $e_username;
			}
			
		}
	}
	$stmt->close();
}
	}
	elseif($_GET['post_type'] == 'draft')
	{
		$post_type_user = $conn->real_escape_string($_SESSION['user_id']);
		$select = "SELECT b.user_id, b.page_id, b.page_heading, b.category,b.tags, b.publish, b.published_date, b.counter_view, e.user_fname FROM `blog_post` b INNER JOIN `editor_user` e ON b.user_id = e.user_id WHERE b.user_id = ? AND b.publish = 0" ;
if($stmt = $conn->prepare($select))
{
	if($stmt->bind_param('s',$post_type_user))
	{
		if($stmt->execute())
		{
			$stmt->bind_result($e_user,$e_pageid,$e_heading,$e_cat,$e_tags,$e_publish,$e_pdate,$e_view,$e_username);
			while($stmt->fetch())
			{
				$ed_user[] = $e_user;
				$ed_pageid[] = $e_pageid;
				$ed_heading[] = $e_heading;
				$ed_cat[] = $e_cat;
				$ed_tags[] = $e_tags;
				$ed_publish[] = $e_publish;
				$ed_pdate[] = $e_pdate;
				$ed_view[] = $e_view;
				$ed_username[] = $e_username;
			}
			
		}
	}
	$stmt->close();
}
	}
	else
	{
		$post_type_user = $conn->real_escape_string($_SESSION['user_id']);
		$select = "SELECT b.user_id, b.page_id, b.page_heading, b.category,b.tags, b.publish, b.published_date, b.counter_view, e.user_fname FROM `blog_post` b INNER JOIN `editor_user` e ON b.user_id = e.user_id WHERE b.user_id = ?" ;
if($stmt = $conn->prepare($select))
{
	if($stmt->bind_param('s',$post_type_user))
	{
		if($stmt->execute())
		{
			$stmt->bind_result($e_user,$e_pageid,$e_heading,$e_cat,$e_tags,$e_publish,$e_pdate,$e_view,$e_username);
			while($stmt->fetch())
			{
				$ed_user[] = $e_user;
				$ed_pageid[] = $e_pageid;
				$ed_heading[] = $e_heading;
				$ed_cat[] = $e_cat;
				$ed_tags[] = $e_tags;
				$ed_publish[] = $e_publish;
				$ed_pdate[] = $e_pdate;
				$ed_view[] = $e_view;
				$ed_username[] = $e_username;
			}
			
		}
	}
	$stmt->close();
}
	}

}
else
{
	$pub = 0;
	$mine = 0;
	$uid =$_SESSION['user_id'];
	$sel_all_query = "SELECT user_id, publish FROM blog_post WHERE `user_id` = '$uid' ";
	$result = mysqli_query($conn,$sel_all_query);
	$tot_post = $result->num_rows;
	if($tot_post > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if($row['publish'] == 1)
			{
				$pub++;
			}
			if($row['user_id'] == $_SESSION['user_id'])
			{
				$mine++;
			}
			
		}
	}
	$draft = $tot_post - $pub;
	$post_type_user = $conn->real_escape_string($_SESSION['user_id']);
	$select = "SELECT b.user_id, b.page_id, b.page_heading, b.category,b.tags, b.publish, b.published_date, b.counter_view, e.user_fname FROM `blog_post` b INNER JOIN `editor_user` e ON b.user_id = e.user_id WHERE b.user_id = ?" ;
if($stmt = $conn->prepare($select))
{
	if($stmt->bind_param('s',$post_type_user))
	{
		if($stmt->execute())
		{
			$stmt->bind_result($e_user,$e_pageid,$e_heading,$e_cat,$e_tags,$e_publish,$e_pdate,$e_view,$e_username);
			while($stmt->fetch())
			{
				$ed_user[] = $e_user;
				$ed_pageid[] = $e_pageid;
				$ed_heading[] = $e_heading;
				$ed_cat[] = $e_cat;
				$ed_tags[] = $e_tags;
				$ed_publish[] = $e_publish;
				$ed_pdate[] = $e_pdate;
				$ed_view[] = $e_view;
				$ed_username[] = $e_username;
			}
			
		}
	}
	$stmt->close();
}
}

?>