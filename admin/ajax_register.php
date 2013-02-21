<?php
session_start();

if($_SESSION['securimage_code_value'] == strtolower($_GET['code']))
  echo "1";
else
  echo "0";

?>