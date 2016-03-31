<?php

define('MAX_FILE_SIZE', 1000000);

/**
 * Class Validator
 * /F420/ & /F421/
 */
class Validator
{
	private $data;
	private $error;
	private $json;

	/**
	 * Validator constructor.
	 * set $data & error as object & get errorText by json file
	 */
	public function __construct()
	{
		$this->data = new stdClass();
		$this->error = new stdClass();
		$this->json = json_decode(file_get_contents("classes/json/errorText.json"), false);
	}

	/**
	 * Validator setData
	 * @param $data postdata save in data var
	 */
	public function setData($data)
	{
		$this->data = (object)$data;
	}

	/**
	 * Validator getData
	 * @return stdClass $data
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Validator getError
	 * @return stdClass $error
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Validator exist
	 * @param $elements key name of the post data to check if not empty
	 */
	public function exist($elements)
	{
		foreach($elements AS $element)
		{
			if(empty($this->data->$element))
			{
				$this->error->$element = 'empty';
			}
		}
	}

	/**
	 * Validator checkMail
	 * @param $element mail post key to check on valid syntax
	 */
	public function checkMail($element)
	{
		if (!filter_var($this->data->$element, FILTER_VALIDATE_EMAIL)) {
			$this->error->mail = 'syntax';
		}
	}

	/**
	 * Validator files
	 * @param $files check files to upload
	 */
	public function files($files)
	{
		$this->fileSize($files);
		$this->fileType($files);
	}

	/**
	 * Validator fileSize
	 * check if size not higher than MAX_FILE_SIZE
	 * @param $files
	 */
	private function fileSize($files)
	{
		foreach($files AS $key => $file)
		{
			if($file["size"] > MAX_FILE_SIZE) {
				$this->error->$key = 'size';
			}
		}
	}

	/**
	 * Validator fileType
	 * check if type pdf or zip
	 * @param $files
	 */
	private function fileType($files)
	{
		foreach($files AS $key => $file)
		{
			if(!empty($file["type"])) {
				if (strpos($file["type"], 'pdf') == false && strpos($file["type"], 'zip') == false) {
					$this->error->$key = 'type';
				}
			}
		}
	}

	/**
	 * Validator output
	 * @param $field name of input field
	 * @return string class error if unvalid & post data in value
	 */
	public function output($field)
	{
		$o = $this->errorClassOutput($field);
		$o .= $this->valueOutput($field);
		return $o;
	}

	/**
	 * Validator errorClassOutput
	 * @param $field
	 * @return string class error
	 */
	public function errorClassOutput($field)
	{
		if(isset($this->error->$field))
		{
			return 'class="error"';
		}
	}

	/**
	 * Validator valueOutput
	 * @param $field
	 * @return string value with post data
	 */
	public function valueOutput($field)
	{
		return 'value="' . $this->data->$field . '"';
	}

	/**
	 * Validator errorMsg
	 * @param $field
	 * @return mixed error Messages from json var
	 */
	public function errorMsg($field)
	{
		if(isset($this->error->$field)) {
			$status = $this->error->$field;
			return $this->json->$field->$status;
		}
	}

}


?>