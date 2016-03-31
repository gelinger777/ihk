<?php

define('HT', 'localhost');
define('DB', 'realitybytes');
define('US', 'rb_elu');
define('PW', '27mi4DD^H%j%52!$');
define('TB', 'Stellenausschreibungen');

class Database
{
	//db connection
	private $pdo;

	/**
	 * Database constructor.
	 * create pdo db connection
	 */
	public function __construct()
	{
		$this->pdo = new PDO('mysql:host='.HT.';dbname='.DB.';charset=utf8', US, PW);
	}

	/**
	 * Database read
	 * read db content by query
	 * @return db results
	 */
	public function read($rows, $pos = false)
	{
		$rows = implode(",",$rows);
		$sql    = "SELECT $rows FROM " . TB;

		if($pos)
		{
			$pos = implode(" AND ",$pos);
			$sql .= " WHERE $pos";
		}

		$stmt   = $this->pdo->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Database replace
	 * run methods: delete() & update()
	 * @param $arrays contain xml content
	 */
	public function replace($arrays)
	{
		$this->delete();
		$this->update($arrays);
	}

	/**
	 * Database delete
	 * truncate db 'Stellenausschreibung'
	 */
	private function delete()
	{
		$sql    = "TRUNCATE TABLE " . TB;
		$stmt   = $this->pdo->prepare($sql);
		$stmt->execute();
	}

	/**
	 * Database update
	 * @param $arrays contain xml content
	 */
	private function update($arrays)
	{
		$sql    = "INSERT INTO " . TB . " (title, description) VALUES ";

		$n = 0;
		$sqlQuery = [];
		$sqlData = [];

		foreach($arrays AS $array)
		{
			$obj = (object)$array;
			$sqlQuery[] = '(:title' . $n . ', :description' . $n . ')';
			$sqlData['title'. $n] = $obj->title;
			$sqlData['description'. $n] = $obj->description;
			$n++;
		}

		$sql .= implode(', ',$sqlQuery);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($sqlData);
	}

}

?>
