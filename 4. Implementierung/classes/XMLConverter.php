<?php

/**
 * Class XMLConverter
 * /F440/
 */
class XMLConverter
{
	//build xml doc
	private $doc;

	/**
	 * XMLConverter constructor.
	 * init new xml
	 */
	public function __construct()
	{
		$this->doc = new DOMDocument('1.0', 'UTF-8');
		$this->doc->formatOutput = true;
	}

	/**
	 * XMLConverter add
	 * create tag, contents & add it $doc
	 * @param $e elementTag
	 * @param $c content in the elementTag
	 */
	public function add($e, $c)
	{
		$tmp = $this->doc->createElement($e, $c);
		$this->doc->appendChild($tmp);
	}

	/**
	 * XMLConverter save
	 * save the $doc as file
	 */
	public function save()
	{
		$xml = $this->doc->saveXML();
		$this->doc->save('xml/'.time().'_Bewerber.xml');
	}
}