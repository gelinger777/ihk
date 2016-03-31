<?php
	include 'classes/Database.php';

	$db = new Database();
	$titels = $db->read(['id, title']);

	include 'templates/header.html';
		/*
		 * /F210/
		 */
		if(isset($titels))
		{
			foreach($titels AS $title)
			{
				echo '<a href="job.php?jobid=' . $title['id'] . '"> ' . $title['title'] . '<br>';
			}
		}

	include 'templates/footer.html';

	?>

