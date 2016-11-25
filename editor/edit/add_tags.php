<?php
include_once '../../INCLUDES/session.inc.php';
include '../../DBCONNECT/connect.inc.php'; 
if(isset($_POST['tags']))
{
	if(!empty($_POST['tags']))
	{
	$ac_userid = $conn->real_escape_string($_SESSION['user_id']);
	$ac_tags = $conn->real_escape_string($_POST['tags']);
	$query = "SELECT `tags` FROM `blog_tags`";
	if($res = mysqli_query($conn,$query))
	{
		while($row = $res->fetch_assoc())
		{
			$ac_tags_arr[] = $row['tags'];
		}
		if(!in_array($ac_tags,$ac_tags_arr))
		{
			if($res->num_rows >= 0)
			{
				
				$insert = "INSERT INTO `blog_tags`(`tags`, `user_id`) VALUES (?,?)";
				if($stmt = $conn->prepare($insert))
				{
					
					if($stmt->bind_param('ss',$ac_tags,$ac_userid))
					{
						if($stmt->execute())
						{
							echo $ac_tags; 
						}
					}
				}
			}
		}
	}
	else
	{
		echo '#';
	}
	
}
	else
	{
		echo '-';
	}
}
?>