<?php
  include '../common/class.Database.php';
  $conn = new Database();
$aInfo = array();
########SERVER DETAILS##########
$input = strtolower($_REQUEST['input']);
$got = array();
$recid = array();
 $i=1;
 $query_rsLimited = "SELECT cli_Code,name FROM jos_users ORDER BY name ASC";
 $rsLimited = mysql_query($query_rsLimited) or die(mysql_error());
 while ($row = mysql_fetch_array($rsLimited)) {
    $recid[]=$row[0];
    $got[]=$row[1];
    $count= $i++;
  }
################################
	$len = strlen($input);
	$aResults = array();
	if ($len)
	{
		for ($i=0;$i<$count;$i++)
		{
			if (strtolower(substr(utf8_decode($got[$i]),0,$len)) == $input)
				$aResults[] = array( "id"=>htmlspecialchars($recid[$i]) ,"value"=>htmlspecialchars($got[$i]), "info"=>htmlspecialchars($aInfo[$i]) );
		}
	}
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?> <results>";
		for ($i=0;$i < count($aResults);$i++)
		{
			echo "<rs id=\"".$aResults[$i]['id']."\" info=\"".$aResults[$i]['info']."\">".html_entity_decode($aResults[$i]['value'])."</rs>";
		}
		echo "</results>";
	}
?>