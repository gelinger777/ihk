<?php

include 'classes/Database.php';
include 'classes/Validator.php';
include 'classes/UserFeatures.php';
include 'classes/Mail.php';
include 'classes/XMLConverter.php';

if(isset($_POST['submit']))
{

	function success($val)
	{
		//upload files
		$uf = new UserFeatures();
		$uf->uploadFiles((object)$_FILES);

		//send infomail
		$m = new Mail();
		$m->send('eduard.luft@reality-bytes.com', 'Bewerber', 'Eine neue Bewerbung ist eingegangen.');

		//save data in xml file
		$xml = new XMLConverter();

		foreach($val->getData() AS $key => $value)
		{
			$xml->add($key, $value);
		}

		foreach((object)$_FILES AS $key => $value)
		{
			$xml->add($key, $value['name']);
		}
		$xml->save();

		header('Location: erfolgreich.php');
	}

	//validation
	$val = new Validator();
	$val->setData($_POST);
	$val->checkMail('mail');
	$val->exist(['firstname', 'lastname', 'phone', 'mail', 'birth']);
	$val->files((object)$_FILES);

	$error = $val->getError();

	//continue process if no error
	if(count((array)$error) === 0){
		success($val);
	}
}

//get title by id or post
if(!isset($_POST['title']))
{
	//get job data
	$id = (int)$_GET['jobid'];
	$db = new Database();
	$job = $db->read(['title'], ['id='.$id])[0];
	$title = $job['title'];
}
else
{
	$title = $_POST['title'];
}

include 'templates/header.html';
include 'templates/form.html';
include 'templates/footer.html';