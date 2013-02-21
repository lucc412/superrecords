<?php
class emailDetails extends Database
{
        function sql_select()
        {
          global $order;
          global $ordtype;
          global $filter;
          global $filterfield;
          global $wholeonly;
          global $commonUses;

          $filterstr = $commonUses->sqlstr($filter);
          if($filterfield!="email_order") {
            if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
          }
          $sql = "SELECT `email_id`, `email_shortname`, `email_name`, `email_value`, `email_template`, `email_comments`, `email_content`, `email_order` FROM `email_options`";
          if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
            if($filterfield=="email_order") $sql .= " where " .$commonUses->sqlstr($filterfield) ." = '" .$filterstr ."'";
              else $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
          } elseif (isset($filterstr) && $filterstr!='') {
            $sql .= " where (`email_order` = '" .$filterstr ."') or (`email_name` like '" .$filterstr ."') or (`email_value` like '" .$filterstr ."') or (`email_shortname` like '" .$filterstr ."') or (`email_template` like '" .$filterstr ."')";
          }
          if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
          else $sql .= " order by email_order";
          if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
          $res = mysql_query($sql) or die(mysql_error());
          return $res;
        }

        function sql_insert()
        {
          global $_POST;
          global $commonUses;

          $sql = "insert into `email_options` (`email_shortname`, `email_name`, `email_value`, `email_template`, `email_comments`, `email_order`) values ('" .str_replace("'","''",stripslashes(@$_POST["email_shortname"]))."', '" .str_replace("'","''",stripslashes(@$_POST["email_name"]))."', " .$commonUses->sqlvalue(@$_POST["email_value"], true).", '" .str_replace("'","''",stripslashes(@$_POST["email_template"]))."', '" .str_replace("'","''",stripslashes(@$_POST["email_comments"]))."', '" .$_POST["email_order"]."')";
          mysql_query($sql) or die(mysql_error());
        }

        function sql_update()
        {
          global $_POST;
          global $commonUses;

             $sql = "update `email_options` set  `email_shortname`='".str_replace("'","''",stripslashes(@$_POST['email_shortname']))."', `email_name`='".str_replace("'","''",stripslashes(@$_POST['email_name']))."', `email_value`=" .$commonUses->sqlvalue(@$_POST["email_value"], true).", `email_comments`=" .$commonUses->sqlvalue(@$_POST["email_comments"], true)." where " .$this->primarykeycondition();
          mysql_query($sql) or die(mysql_error());
        }

        function sql_delete($id)
        {

           $sql = "delete from `email_options` where email_id =".$id;
           if(!mysql_query($sql))
          echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
        }
        function primarykeycondition()
        {
          global $_POST;
          global $commonUses;
          
          $pk = "";
          $pk .= "(`email_id`";
          if (@$_POST["xemail_id"] == "") {
            $pk .= " IS NULL";
          }else{
          $pk .= " = " .$commonUses->sqlvalue(@$_POST["xemail_id"], false);
          };
          $pk .= ")";
          return $pk;
        }

}
	$emailDbcontent = new emailDetails();
?>

