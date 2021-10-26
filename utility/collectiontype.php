<?php
date_default_timezone_set("Asia/Jakarta");
$tgl =date("d-m-Y");

	$word="Label_".$tgl."";
	 header("Content-type: application/vnd.ms-word");
	 header("Content-Disposition: attachment;Filename=$word.doc"); 
	header('Cache-Control: public');

?>