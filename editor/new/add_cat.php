<?php
include_once '../../INCLUDES/session.inc.php';
include '../../DBCONNECT/connect.inc.php'; 
if(isset($_POST['cat']))
{
	if(!empty($_POST['cat']))
	{
	$ac_userid = $conn->real_escape_string($_SESSION['user_id']);
	$ac_cat = $conn->real_escape_string($_POST['cat']);
	$query = "SELECT `cat` FROM `blog_cat`";
	$res = mysqli_query($conn,$query);
	while($row = $res->fetch_assoc())
	{
		$ac_cat_arr[] = $row['cat'];
	}
	if(!in_array($ac_cat,$ac_cat_arr))
	{
		if($res->num_rows >= 0)
		{
			
			$insert = "INSERT INTO `blog_cat`(`cat`, `user_id`) VALUES (?,?)";
			if($stmt = $conn->prepare($insert))
			{
				
				if($stmt->bind_param('ss',$ac_cat,$ac_userid))
				{
					if($stmt->execute())
					{
						echo $ac_cat; 
					}
				}
			}
		}
	}
	else
	{
		echo '--';
	}
	
}
	else
	{
		echo '-';
	}
}
?>