<?php
	include 'classes/Database.php';

	$db = new Database();
	$titels = $db->read(['id, title']);
?>

<html>
<head>
	<title>Übersichtsseite</title>

	<meta charset="UTF-8">
</head>
<body>
	<?php

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

	?>
</body>
</html>

