<?php
$r="";

if ($_GET["username"])

{

	//include_once( 'globals.php' );
	require_once( '../configuration.php' );
	//require_once( $mosConfig_absolute_path . '/includes/joomla.php' );
    $db_conn=mysql_connect($mosConfig_host, $mosConfig_user, $mosConfig_password);
    if ($db_conn)
    //$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
    {
    	$db_open=mysql_select_db($mosConfig_db,$db_conn);
        if ($db_open)
        {

            $result=mysql_query("SELECT email FROM ".$mosConfig_dbprefix."users WHERE email='".$_GET["username"]."'",$db_conn);
            if (mysql_affected_rows()>0)
            	$r="<img src=\"".$mosConfig_live_site."/images/stop.png\" /> This email already exists! Please choose another.";
            else
               	$r="<img src=\"".$mosConfig_live_site."/images/tick.png\" />";

            mysql_free_result($result);
        }
        else
        	$r="Bad database";
    	mysql_close($db_conn);
    }
    else $r="Bad databse";
}
echo $r;
return;
?>