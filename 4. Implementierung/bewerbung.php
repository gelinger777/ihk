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
?>

<html>
<head>
	<title>Bewerbung</title>
	<meta charset="UTF-8">
</head>
<body>

<hr>Bewerbung als <?php echo $title ?><br><br>

<!-- /F410/ -->
<form enctype="multipart/form-data" action="" method="POST">

	<input type="hidden" name="title" value="<?php echo $title ?>">

	<label for="firstname">Vorname*</label>
	<input name="firstname" type="text" <?php echo isset($val) ? $val->output('firstname') : false ?>><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('firstname') : false ?></div>

	<label for="lastname">Nachname*</label>
	<input name="lastname" type="text" <?php echo isset($val) ? $val->output('lastname') : false ?>><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('lastname') : false ?></div>

	<label for="street">Straße</label>
	<input name="street" type="text" <?php echo isset($val) ? $val->output('street') : false ?>><br>

	<label for="housnr">Hausnummer</label>
	<input name="housnr" type="text" <?php echo isset($val) ? $val->output('housnr') : false ?>><br>

	<label for="zip">PLZ</label>
	<input name="zip" type="text" <?php echo isset($val) ? $val->output('zip') : false ?>><br>

	<label for="place">Ort</label>
	<input name="place" type="text" <?php echo isset($val) ? $val->output('place') : false ?>><br>

	<label for="phone">Telefon*</label>
	<input name="phone" type="text" <?php echo isset($val) ? $val->output('phone') : false ?>><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('phone') : false ?></div>

	<label for="mail">E-Mail*</label>
	<input name="mail" type="text" <?php echo isset($val) ? $val->output('mail') : false ?>><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('mail') : false ?></div>

	<label for="web">Website</label>
	<input name="web" type="text" <?php echo isset($val) ? $val->output('web') : false ?>><br>

	<label for="birth">Geburtsdatum*</label>
	<input name="birth" type="date" <?php echo isset($val) ? $val->output('birth') : false ?>><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('birth') : false ?></div>

	<label for="enteringday">Mögliches Eintrittsdatum</label>
	<input name="enteringday" type="date" <?php echo isset($val) ? $val->output('enteringday') : false ?>><br>

	<label for="fileToUpload" class="button"></label>
	<input class="hidden" type="file" name="fileToUpload1" id="fileToUpload1"><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('fileToUpload1') : false ?></div>

	<label for="fileToUpload" class="button"></label>
	<input class="hidden" type="file" name="fileToUpload2" id="fileToUpload2"><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('fileToUpload2') : false ?></div>

	<label for="fileToUpload" class="button"></label>
	<input class="hidden" type="file" name="fileToUpload3" id="fileToUpload3"><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('fileToUpload3') : false ?></div>

	<label for="fileToUpload" class="button"></label>
	<input class="hidden" type="file" name="fileToUpload4" id="fileToUpload4"><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('fileToUpload4') : false ?></div>

	<label for="fileToUpload" class="button"></label>
	<input class="hidden" type="file" name="fileToUpload5" id="fileToUpload5"><br>
	<div class="errmsg"><?php echo isset($val) ? $val->errorMsg('fileToUpload5') : false ?></div>

	<input type="submit" class="button" value="Absenden" name="submit">
</form>
<?php

?>
<!--	<script>-->
<!--		var ele = document.getElementById('fileToUpload');-->
<!--		ele.addEventListener('change', function() {-->
<!--			var file = this.files[0];-->
<!--			console.log(file['name']);-->
<!--		});-->
<!--	</script>-->

</body>
</html>

<style>
	html,body
	{
		font-family: sans-serif;
	}
	.error
	{
		color: red;
		border: 2px solid red;
	}
	.errmsg
	{
		color: red;
	}
	label
	{
		display: inline-block;
		min-width: 300px;
		margin-top: 10px;
	}
	/**/
	/*.hidden*/
	/*{*/
		/*display: none;*/
	/*}*/

	/*.button*/
	/*{*/
		/*border: 1px solid gray;*/
		/*background-color: #eee;*/
		/*display: inline-block;*/
		/*padding: 1px 17px;*/
		/*margin-bottom: 5px;*/
		/*font-size: 13px;*/
		/*width: 100px;*/
		/*box-sizing: inherit;*/
		/*text-align: center;*/
	/*}*/
	/*.button:hover*/
	/*{*/
		/*background-color: #fff;*/
	/*}*/
</style>

