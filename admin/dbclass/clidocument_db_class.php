<?php
class clidocumentDbquery extends Database
{
        function sql_select()
        {
          global $order;
          global $ordtype;
          global $filter;
          global $filterfield;
          global $wholeonly;
          global $access_file_level;
          global $access_file_level_lead;

            //get client code
            $typeapp = $_REQUEST['app'];
            $clientid = $_REQUEST['mid'];
            if($_REQUEST['app']==0)
            {
             $sql = "SELECT `id`, `catid`, `dmname`, `dmdescription`, `dmdate_published`, `dmowner`, `dmfilename`, `published`, `dmurl`, `dmcounter`, `checked_out`, `checked_out_time`, `approved`, `dmthumbnail`, `dmlastupdateon`, `dmlastupdateby`, `dmsubmitedby`, `dmmantainedby`, `dmlicense_id`, `access`, `attribs`, `dmndownload` FROM `jos_docman` where dmowner=$clientid AND catid=14 AND published=1 AND approved=1";
            }
            else {
             $sql = "SELECT `id`, `catid`, `dmname`, `dmdescription`, `dmdate_published`, `dmowner`, `dmfilename`, `published`, `dmurl`, `dmcounter`, `checked_out`, `checked_out_time`, `approved`, `dmthumbnail`, `dmlastupdateon`, `dmlastupdateby`, `dmsubmitedby`, `dmmantainedby`, `dmlicense_id`, `access`, `attribs`, `dmndownload` FROM `jos_docman` where dmowner=$clientid AND ( catid=13 OR catid=16)";
            }
             if (isset($order) && $order!='') $sql .= " order by `" .sqlstr($order) ."`";
              if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
            else $sql .= " order by dmdate_published desc";
              $res = mysql_query($sql) or die(mysql_error());
              return $res;
        }
        // count record
        function sql_getrecordcount()
        {
          global $order;
          global $ordtype;
          global $filter;
          global $filterfield;
          global $wholeonly;
          global $access_file_level;
          global $access_file_level_lead;

            //get client code
            $typeapp = $_REQUEST['app'];
            $clientid = $_REQUEST['mid'];
            if($_REQUEST['app']==0)
            {
             $sql = "SELECT COUNT(*) FROM(SELECT `id`, `catid`, `dmname`, `dmdescription`, `dmdate_published`, `dmowner`, `dmfilename`, `published`, `dmurl`, `dmcounter`, `checked_out`, `checked_out_time`, `approved`, `dmthumbnail`, `dmlastupdateon`, `dmlastupdateby`, `dmsubmitedby`, `dmmantainedby`, `dmlicense_id`, `access`, `attribs`, `dmndownload` FROM `jos_docman` where dmowner=$clientid AND catid=14 AND published=1 AND approved=1) subq";
            }
            else {
            $sql = "SELECT COUNT(*) FROM(SELECT `id`, `catid`, `dmname`, `dmdescription`, `dmdate_published`, `dmowner`, `dmfilename`, `published`, `dmurl`, `dmcounter`, `checked_out`, `checked_out_time`, `approved`, `dmthumbnail`, `dmlastupdateon`, `dmlastupdateby`, `dmsubmitedby`, `dmmantainedby`, `dmlicense_id`, `access`, `attribs`, `dmndownload` FROM `jos_docman` where dmowner=$clientid AND (catid=13 OR catid=16)) subq";
            }
             if (isset($order) && $order!='') $sql .= " order by `" .sqlstr($order) ."`";
              if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);

                $res = mysql_query($sql) or die(mysql_error());
              $row = mysql_fetch_assoc($res);
              reset($row);
              return current($row);
        }
        function sql_delete($id)
        {
           $sql = "delete from `jos_docman` where id='".$id."'";
           if(!mysql_query($sql))
                echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
         }

}
$clidocumentQuery = new clidocumentDbquery();
?>