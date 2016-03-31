<?php

include 'Database.php';

/**
 * Class RssFeed
 * /F100/
 */
class RssFeed
{

	//whole xml content
	private $rssContent = [];

	/**
	 * RssFeed load
	 * request at rss feed & save content in $rssContent
	 */
	public function load()
	{
		$url = 'https://recruitingapp-5238.de.umantis.com/RssFeed/70/rss.xml';

		$xml = @simplexml_load_file($url);

		//exit if xml file is empty
		if(empty($xml->channel))
		{
			return false;
		}

		$counter = 0;

		//pull xml content in rssContent array
		foreach ($xml->channel->item AS $value) {
			$this->rssContent[$counter++] = array('title' => (string)$value->title, 'description' => (string)$value->description);
		}

		$this->save();
	}

	/**
	 * RssFeed save
	 * reset db & save rss content in db
	 */
	private function save()
	{
		$db = new Database;
		$db->replace($this->rssContent);
	}
}


$rssfeed = new RssFeed();

$rssfeed->load();

?>