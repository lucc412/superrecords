<?php
class staffDbquery extends Database
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
          if (!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
          $sql = "SELECT * FROM (SELECT t1.`stf_Code`, t1.`stf_CCode`, CONCAT_WS(' ',lp1.`con_Firstname`,lp1.`con_Lastname`) AS `lp_stf_CCode`, t1.`stf_AccessType`, lp2.`aty_Description` AS `lp_stf_AccessType`, t1.`stf_Login`, t1.`stf_Password`, t1.`stf_Createdby`, t1.`stf_Createdon`, t1.`stf_Lastmodifiedby`, t1.`stf_Lastmodifiedon`, t1.`stf_Disabled`, t1.`stf_Viewall`, t1.`stf_Upload`, t1.`stf_LoginStatus` FROM `stf_staff` AS t1 LEFT OUTER JOIN `con_contact` AS lp1 ON (t1.`stf_CCode` = lp1.`con_Code`) LEFT OUTER JOIN `aty_accesstype` AS lp2 ON (t1.`stf_AccessType` = lp2.`aty_Code`) where lp2.`aty_Description` not like 'Super Administrator') subq";
          if (isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
            $sql .= " where " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";
          } elseif (isset($filterstr) && $filterstr!='') {
            $sql .= " where (`stf_Code` like '" .$filterstr ."') or (`lp_stf_CCode` like '" .$filterstr ."') or (`lp_stf_AccessType` like '" .$filterstr ."') or (`stf_Login` like '" .$filterstr ."') or (`stf_Password` like '" .$filterstr ."') or (`stf_Createdby` like '" .$filterstr ."') or (`stf_Createdon` like '" .$filterstr ."') or (`stf_Lastmodifiedby` like '" .$filterstr ."') or (`stf_Lastmodifiedon` like '" .$filterstr ."')";
          }
          if (isset($order) && $order!='') $sql .= " order by `" .$commonUses->sqlstr($order) ."`";
          if (isset($ordtype) && $ordtype!='') $sql .= " " .$commonUses->sqlstr($ordtype);
          $res = mysql_query($sql) or die(mysql_error());
          return $res;
        }
        function sql_insert()
        {
          global $_POST;
          global $commonUses;
          
          $stf_Createdon=date( 'Y-m-d H:i:s' );
          $stf_Disabled = "";
          $loginname = ltrim($_POST["stf_Login"]);
              $sql = "insert into `stf_staff` ( `stf_CCode`, `stf_AccessType`, `stf_Login`, `stf_Password`, `stf_Createdby`, `stf_Createdon`, `stf_Disabled`, `stf_Viewall`, `stf_Upload`, `stf_LoginStatus`) values (" .$commonUses->sqlvalue(@$_POST["stf_CCode"], false).", " .$commonUses->sqlvalue(@$_POST["stf_AccessType"], false).", " .$commonUses->sqlvalue($loginname, true).", " .$commonUses->sqlvalue(@$_POST["stf_Password"], true).", '" . $_SESSION['user']."', '" .$stf_Createdon."', '".@$_POST["chkDisabled"]."', '".@$_POST["chkViewall"]."', '".@$_POST["chkUpload"]."', '".@$_POST["chkLoginStatus"]."')";
                $inresult = mysql_query($sql) or die(mysql_error());
                   $result = (mysql_query ('SELECT LAST_INSERT_ID() FROM stf_staff'));
                   $row=mysql_fetch_row($result);
                   $stf_lastid = $row[0];
                        foreach($_POST['id'] as $id)
                        {
                                if($_POST["stf_View".$id]=="" )
                                {
                                if(($_POST["stf_Add".$id]=="Y" || $_POST["stf_Edit".$id]=="Y" || $_POST["stf_Delete".$id]=="Y") && $_POST["stf_View".$id]=="")
                                {
                                $_POST["stf_View".$id]="Y";
                                }
                                else
                                {
                                $_POST["stf_View".$id]='N';
                                }
                                }
                                if($_POST["stf_Add".$id]=="" )
                                {
                                $_POST["stf_Add".$id]='N';
                                }
                                if($_POST["stf_Edit".$id]=="" )
                                {
                                $_POST["stf_Edit".$id]='N';
                                }
                                if($_POST["stf_Delete".$id]=="" )
                                {
                                $_POST["stf_Delete".$id]='N';
                                }
                        if($_POST['stf_AccessType']==2)
                        {
                $sql = "insert into `stf_staffforms` (`stf_SCode`, `stf_FormCode`,`stf_View`,`stf_Add`,`stf_Edit`,`stf_Delete`) values (" .$commonUses->sqlvalue($stf_lastid, false).", " .$commonUses->sqlvalue($id, false).",'Y','Y','Y','Y')";
                        }
                        else
                        {
                $sql = "insert into `stf_staffforms` (`stf_SCode`, `stf_FormCode`,`stf_View`,`stf_Add`,`stf_Edit`,`stf_Delete`) values (" .$commonUses->sqlvalue($stf_lastid, false).", " .$commonUses->sqlvalue($id, false).",'".$_POST["stf_View".$id]."','".$_POST["stf_Add".$id]."','".$_POST["stf_Edit".$id]."','".$_POST["stf_Delete".$id]."')";
                        }
                  @mysql_query($sql);

                }
                //insert aty_Description table
                 $access_query = "SELECT aty_Description from aty_accesstype where aty_Code=".$_POST['stf_AccessType'];
                  $res_query = mysql_query($access_query);
                   $accessType = @mysql_fetch_array($res_query);
                   $staffType = $accessType['aty_Description'];
                    $usertype = "Administrator";
                    $gid = "24";
                    $regdate = date( 'Y-m-d H:i:s' );
                    $loginname = ltrim($_POST["stf_Login"]);
                    //get contact email
                    $mail_query = "select con_Email from con_contact where con_Code=".$_POST["stf_CCode"];
                    $resquey = mysql_query($mail_query);
                    $mail = @mysql_fetch_array($resquey);
                    $email = $mail['con_Email'];
                    $salt = $this->genRandomPassword();
                    $pass = md5(stripslashes($_POST['stf_Password']).$salt) .':'.$salt;
                    /*$sql = "insert into `jos_users` ( `username`, `email`, `password`, `usertype`, `gid`, `sendEmail`, `registerDate`) values (" .$commonUses->sqlvalue($loginname, true).", " .$commonUses->sqlvalue($email, true).", " .$commonUses->sqlvalue(@$pass, true).", '" .$usertype."', '".$gid."', '".$stf_lastid."', '" .$regdate."')";
                    @mysql_query($sql) or die(mysql_error());
                    //insert jos_core_acl_aro table
                    $sesvalue = "users";
                   $result = (mysql_query ('SELECT LAST_INSERT_ID() FROM jos_users'));
                   $row=mysql_fetch_row($result);
                   $valueid = $row[0];
                    $sql = "insert into `jos_core_acl_aro` ( `section_value`, `value`) values ('".$sesvalue."', " .$commonUses->sqlvalue(@$valueid, true).")";
                    @mysql_query($sql) or die(mysql_error());
                    //insert jos_core_acl_groups_aro_map table
                   $result = (mysql_query ('SELECT LAST_INSERT_ID() FROM jos_core_acl_aro'));
                   $row=mysql_fetch_row($result);
                   $aroid = $row[0];
                    $sql = "insert into `jos_core_acl_groups_aro_map` ( `group_id`, `aro_id`) values (24, " .$commonUses->sqlvalue($aroid, false).")";
                    @mysql_query($sql) or die(mysql_error());*/
            }
			function sql_update()
			{
				global $_POST;
				global $commonUses;
                  
				$stf_Lastmodifiedon=date( 'Y-m-d H:i:s' );
				$updatesql = "UPDATE `stf_staff` 
							SET `stf_AccessType`=" .$commonUses->sqlvalue(@$_POST["stf_AccessType"], false).", `stf_Login`=" .$commonUses->sqlvalue(@$_POST["stf_Login"], true).", `stf_Password`=" .$commonUses->sqlvalue(@$_POST["stf_Password"], true).", `stf_Lastmodifiedby`='" . $_SESSION['user']."', `stf_Lastmodifiedon`='".$stf_Lastmodifiedon."', `stf_Disabled`='".@$_POST["chkDisabled"]."', `stf_Viewall`='".@$_POST["chkViewall"]."', `stf_Upload`='".@$_POST["chkUpload"]."', `stf_LoginStatus`='".@$_POST["chkLoginStatus"]."' where " .$this->primarykeycondition();
				$updateResult = mysql_query($updatesql) or die(mysql_error());

                foreach($_POST['stf_Code'] as $id) {
					if($_POST["stf_View".$id]!="") {
						$sql2 = "UPDATE `stf_staffforms` 
								SET `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_View`='".$_POST["stf_View".$id]."' 
								WHERE stf_Code=".$id;
					}
                    else if($_POST["stf_Add".$id]=="Y" || $_POST["stf_Edit".$id]=="Y" || $_POST["stf_Delete".$id]=="Y") {
						$sql2 = "UPDATE `stf_staffforms` 
						SET `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_View`='Y' 
						WHERE stf_Code=".$id;
					}
                    else {
						$sql2 = "UPDATE `stf_staffforms` 
						SET `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_View`='N' 
						WHERE stf_Code=".$id;
                    }
					mysql_query($sql2) or die(mysql_error());
                }

                foreach($_POST['stf_Code'] as $id) {
					if($_POST["stf_Add".$id]!="") {
						$sql3 = "UPDATE `stf_staffforms` SET `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_Add`='".$_POST["stf_Add".$id]."' where stf_Code=".$id;
						
						mysql_query($sql3) or die(mysql_error());
					}
                    else {
						$sql3 = "UPDATE `stf_staffforms` SET `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_Add`='N' where stf_Code=".$id;
						
						mysql_query($sql3) or die(mysql_error());
					}
                }

                foreach($_POST['stf_Code'] as $id) {
					if($_POST["stf_Edit".$id]!="") {
						$sql4 = "update `stf_staffforms` set `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_Edit`='".$_POST["stf_Edit".$id]."' where stf_Code=".$id;
                    
						mysql_query($sql4) or die(mysql_error());
					}
					else {
						$sql4 = "update `stf_staffforms` set `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_Edit`='N' where stf_Code=".$id;

						mysql_query($sql4) or die(mysql_error());
                    }
                }

                foreach($_POST['stf_Code'] as $id) {
					if($_POST["stf_Delete".$id]!="") {
						$sql5 = "update `stf_staffforms` set `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_Delete`='".$_POST["stf_Delete".$id]."' where stf_Code=".$id;
                    
						mysql_query($sql5) or die(mysql_error());
					}
                    else {
						$sql5= "update `stf_staffforms` set `stf_SCode`=" .$commonUses->sqlvalue(@$_POST["xstf_Code"], false).", `stf_FormCode`=" .$commonUses->sqlvalue(@$_POST["stf_FormCode".$id], false).", `stf_Delete`='N' where stf_Code=".$id;
                    
						mysql_query($sql5) or die(mysql_error());
					}
                }

                //update aty_Description table
                $access_query = "SELECT aty_Description 
								FROM aty_accesstype 
								WHERE aty_Code=".$_POST['stf_AccessType'];

				$res_query = mysql_query($access_query);
				$accessType = @mysql_fetch_array($res_query);
				$staffType = $accessType['aty_Description'];

				$salt = $this->genRandomPassword();
				$pass = md5(stripslashes($_POST['stf_Password']).$salt) .':'.$salt;
				/*$sqlqry = "UPDATE `jos_users` 
							SET `username`=" .$commonUses->sqlvalue(@$_POST["stf_Login"], true).", `password`=" .$commonUses->sqlvalue(@$pass, true)." 
							WHERE sendEmail=".$_POST["xstf_Code"];
                $user_result = mysql_query($sqlqry) or die(mysql_error());
                $update_result = mysql_affected_rows();*/
        }
        function sql_delete($id)
        {
               global $commonUses;
               $sql = "delete from `stf_staff` where stf_Code='".$id."'";
              if(!mysql_query($sql))
            echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";

               $sql = "delete from `stf_staffforms` where stf_SCode='".$id."'";
              if(!mysql_query($sql))
            echo "<script language=\"JavaScript\">alert(\"" . mysql_error() . "\");</script>";
               /*$sql = "delete from `jos_users` where sendEmail='".$id."'";
              @mysql_query($sql);*/
         }
        function primarykeycondition()
        {
          global $_POST;
          global $commonUses;

          $pk = "";
          $pk .= "(`stf_Code`";
          if (@$_POST["xstf_Code"] == "") {
            $pk .= " IS NULL";
          }else{
          $pk .= " = " .$commonUses->sqlvalue(@$_POST["xstf_Code"], false);
          };
          $pk .= ")";
          return $pk;
        }
        function genRandomPassword($length = 32)
	{
		$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = strlen($salt);
		$makepass = '';
		mt_srand(10000000 * (double) microtime());

		for ($i = 0; $i < $length; $i ++) {
			$makepass .= $salt[mt_rand(0, $len -1)];
		}

		return $makepass;
	}

}
$staffQuery = new staffDbquery();
?>