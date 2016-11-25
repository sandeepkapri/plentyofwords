<?php
if(isset($_GET['v1']) && isset($_GET['v2']))
{
	if($_GET['v1'] == 'category')
	{
		$categoryget = $_GET['v2'];
		require 'category-page.php';
	}
	elseif($_GET['v1'] == 'tags')
	{
		$tagsget = $_GET['v2'];
		require 'tags-page.php';
	}
	else
	{
		require '404.php';	
	}
	
}
elseif(isset($_GET['v1']))
{
	
	$post_get = $_GET['v1'];
	require 'post.php';
}
else
{
	require 'home.php';
}
?>