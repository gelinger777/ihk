<?php
include 'classes/Database.php';
include 'classes/UserFeatures.php';

//get job data
$id = (int)$_GET['jobid'];
$db = new Database();
$job = $db->read(['title, description'], ['id='.$id])[0];

//UserFeatures
$uf = new UserFeatures();

include 'templates/header.html';

/**
 * /F220/
 */
	if(isset($job))
	{
		echo $job['title'] . '<br>';
		echo $job['description'];
	}

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&pdf=true";

if(!empty($_GET['pdf']) && empty($_GET['loop']) )
{
	$uf->pdfGenerator($url);
}
else if(!empty($_GET['pdf']) && !empty($_GET['loop']) )
{
	exit;
}
?>

<br>
<a href="<?php echo $url ?>" target="_blank">Generate PDF</a>
<a href="bewerbung.php?jobid=<?php echo $id ?>" target="_blank">Bewerben</a>

<?php

include 'templates/footer.html';

?>