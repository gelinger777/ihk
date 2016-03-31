<?php

include 'lib/mpdf60/mpdf.php';



class UserFeatures
{

	private $mpdf;

	/**
	 * UserFeatures constructor.
	 * init mpdf
	 */
	public function __construct()
	{
		$this->mpdf = new mPDF();
	}

	/**
	 * /F310/ & /F311/
	 * UserFeatures pdfGenerator
	 * read url content and generate pdf
	 * @param $url
	 */
	public function pdfGenerator($url)
	{
		$url .= "&loop=true";
		$html = file_get_contents($url);
		$this->mpdf->WriteHTML($html);
		$this->mpdf->Output();
	}

	/**
	 * /F430/
	 * UserFeatures uploadFiles
	 * upload all files
	 * @param $files
	 */
	public function uploadFiles($files)
	{
		foreach($files AS $key => $file) {
			if (!empty($file["size"])) {
				$target_dir = "uploads/";
				$target_file = $target_dir . time() . '_' .basename($_FILES[$key]["name"]);
				if (move_uploaded_file($_FILES[$key]["tmp_name"], $target_file)) {
					echo "The file " . basename($_FILES[$key]["name"]) . " has been uploaded.";
				}
			}
		}
	}

}

?>