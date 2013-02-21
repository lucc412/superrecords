<?php
  $file = $_GET['type'];
  $filename = "$file.xls";
  
  header('Content-type: application/vnd.ms-excel');

// It will be called downloaded.pdf
  header('Content-Disposition: attachment; filename="'.$filename.'"');
  
  // The PDF source is in original.pdf
  readfile("$filename");
  exit;

?>