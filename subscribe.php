<?php 
	include 'DBCONNECT/connect.inc.php';
	if(isset($_POST['nlEmail']))
	{
		if(!empty($_POST['nlEmail']))
		{
			$nl_email = $conn->real_escape_string($_POST['nlEmail']);
			$select = "SELECT `nl_email` FROM `blog_newsletter` WHERE `nl_email` = ?";
			if($stmt = $conn->prepare($select))
			{
				if($stmt->bind_param('s',$nl_email))
				{
					if($stmt->execute())
					{
						$stmt->store_result();
						$email_match = $stmt->num_rows;
						$stmt->close();
						
					}
				}
			}
			if($email_match > 0)
			{
				echo '<p>You are already subscribed to our newsletter.</p>';
			}
			else
			{
				$insert = "INSERT INTO `blog_newsletter`(`nl_email`, `nl_date`) VALUES (?,now())";
				if($stmt = $conn->prepare($insert))
				{
					if($stmt->bind_param('s',$nl_email))
					{
						if($stmt->execute())
						{
							echo '<p>Thanks for subscribing with us.</p>';
						}
					}
				}
			}
		}
	}
?>