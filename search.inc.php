<?php
include 'DBCONNECT/connect.inc.php';
if(isset($_POST['q']))
{
	  if(!empty($_POST['q']))
	  {
		  $selct = "SELECT `permalink`,`page_heading` FROM `blog_post` WHERE `page_heading` LIKE ?";
		  $pheading = $conn->real_escape_string($_POST['q']);
		  $pheading = '%'.$pheading.'%';
		  if($stmt = $conn->prepare($selct))
		  {
			  if($stmt->bind_param("s",$pheading))
			  {
					  if($stmt->execute())
					  {
						  $stmt->store_result();
						  $stmt->bind_result($permalink,$post_heading);
						  while($stmt->fetch())
						  {
							  if($post_heading != '')
							  {
							  	echo '<a href="/'.$permalink.'">'.$post_heading.'</a>';
							  }
							  else
							  {
								echo '<a>No Results.</a>';
							  }
						  }
						  
						  $stmt->close();
						  
					   }
			  }
		  }
	  }
}
?>