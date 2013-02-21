<?php
  
$filename = $_GET['filename'];
$path = "excel_file/$filename";
// fix for IE catching or PHP bug issue
header("Pragma: public");
header("Expires: 0"); // set expiration time
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

header("Content-Disposition: attachment; filename=".$filename.";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($path));

/*header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='".$filename.");
header('Cache-Control: max-age=0');*/

@readfile($path);

?>