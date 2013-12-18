<?php 
include ("includes/class.Database.php");
include ('includes/varDeclare.php');
include ('includes/commonFunctionExtends.php');
include_once(MAIL);

class commonUse extends Database
{
				
            function checkDuplicate($table,$field,$postvalue)
            {
                    $query="select ".$field." from ".$table." where ".$field."='".$postvalue."'";
                    $result=mysql_query($query);
                    return @mysql_num_rows($result);
            }
            function checkDuplicateMultiple($table,$fields,$postvalue,$where)
            {
                    $query="select ".implode(",",$fields)." from ".$table.$where;
                    $result=mysql_query($query);
                    return @mysql_num_rows($result);
            }
            function sqlvalue($val, $quote)
            {
              if ($quote)
                $tmp = $this->sqlstr($val);
              else
                $tmp = $val;
              if ($tmp == "")
                $tmp = "NULL";
              elseif ($quote)
                $tmp = "'".$tmp."'";
              return $tmp;
            }
            function sqlstr($val)
            {
              return str_replace("'", "''", $val);
            }
            function getDateFormat($dateVal, $flTime=NULL)
            {
                    // date with time case
                    if(!empty($flTime)) {
                        $arrDateParts = explode(' ', $dateVal);
                        $strDate = $arrDateParts[0];
                        $strTime = $arrDateParts[1];
                    }
                    // only date case
                    else {
                        $strDate = $dateVal;
                    }
                    
                    // convert date into mysql format
                    $arrDate = explode("/",$strDate);
                    $year=$arrDate[2];
                    $month=$arrDate[1];
                    $day=$arrDate[0];
                    $convertedDate = $year."-".$month."-".$day;
                    
                    // append time string if available
                    if(!empty($strTime)) $convertedDate .= ' '.$strTime;
                    
                    return $convertedDate;
            }
            function showGridDateFormat($dateformat)
            {
                $dateformat=substr($dateformat,0,10);
                if(($dateformat!="0000-00-00") && $dateformat!="")
                return (date("d/M/Y",strtotime($dateformat)));
            }
			// This function is used to display calendar
			function showCalendar($textBoxId, $textBoxVal=NULL) {
				   $returnStr = '<input type="text" name="'. $textBoxId .'" id="'. $textBoxId .'" value="'. $textBoxVal .'"/>&nbsp;<a href="javascript:NewCal(\''.$textBoxId.'\',\'ddmmyyyy\',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>';
				
				return $returnStr;
			}
            function getProcessCycleDescription($Processid)
            {
                if($Processid!=0)
                {
                    $query="select prc_Description from prc_processcycle where prc_Code=".$Processid;
                    $result=@mysql_query($query);
                    $ProcessCycleDescription=@mysql_result( $result,0,'prc_Description') ;
                }
                return $ProcessCycleDescription;
            }
            function getIndiamanagerId($cli_code)
            {
                //get india manage id
                $ind_query = "SELECT cli_Assignedto FROM jos_users where cli_Code=".$cli_code;
                $res_query = mysql_query($ind_query);
                $ind_id = mysql_fetch_array($res_query);
                return $ind_id['cli_Assignedto'];
            }
            function getClientType($Typeid)
            {
                if($Typeid!=0)
                $query="SELECT cty_Description FROM `cty_clienttype` where cty_Code=".$Typeid;
                $result=@mysql_query($query);
                $clienttypedesc=@mysql_result( $result,0,'cty_Description') ;
                return $clienttypedesc;
            }
            function getSubActivities($Actid)
            {
                if($Actid!=0)
                $query="SELECT sub_Description FROM `sub_subactivity` where sub_Code=".$Actid;
                $result=@mysql_query($query);
                $subactdesc=@mysql_result( $result,0,'sub_Description') ;
                return $subactdesc;
            }
            function getTimesheetStatus($Statusid)
            {
                if($Statusid!=0)
                $query="select * from `tst_timesheetstatus` where  tst_Code=".$Statusid;
                $result=@mysql_query($query);
                $timesheetstatusdesc=@mysql_result( $result,0,'tst_Description') ;
                return $timesheetstatusdesc;
            }
            function getWorksheetStatus($Statusid)
            {
                if($Statusid!=0)
                $query="select * from `wst_worksheetstatus` where  wst_Code=".$Statusid;
                $result=@mysql_query($query);
                $worksheetstatusdesc=@mysql_result( $result,0,'wst_Description') ;
                return $worksheetstatusdesc;
            }
            function getAccessTypeDescription($Typeid)
            {
                $query="SELECT aty_Description FROM `aty_accesstype` where aty_Code=".$Typeid;
                $result=@mysql_query($query);
                $accesstypedesc=@mysql_result( $result,0,'aty_Description') ;
                return $accesstypedesc;
            }
            function getFormCode($FormDesc)
            {
                $query="SELECT frm_Code FROM `frm_forms` where frm_Description='".$FormDesc."'";
                $result=@mysql_query($query);
                $formcode=@mysql_result($result,0,'frm_code') ;
                return $formcode;
            }
            function checkFileAccess($staffcode,$formcode)
            {
                $query="select stf_View,stf_Add,stf_Edit,stf_Delete from stf_staffforms where stf_SCode=".$staffcode. " and stf_FormCode=" .$formcode;
                $result=@mysql_query($query);
                $row=@mysql_fetch_array($result);
                if($row["stf_View"]=="N" && $row["stf_Add"]=="N" && $row["stf_Edit"]=="N" && $row["stf_Delete"]=="N")
                {
                    $access_level=0;
                    return $access_level;
                }
                else
                {
                    return $row;
                }
            }
            function checkSubMenuAccess($staffcode,$formcode,$menucode)
            {
                $query2="select stf_View,stf_Add,stf_Edit,stf_Delete from stf_staffforms where stf_SCode=".$staffcode. " and stf_FormCode=" .$formcode;
                $result2=@mysql_query($query2);
                $row2=@mysql_fetch_array($result2);
                if($row2["stf_View"]=="N" && $row2["stf_Add"]=="N" && $row2["stf_Edit"]=="N" && $row2["stf_Delete"]=="N")
                {
                     $access_level2=0;
                     return $access_level2;
                }
                else
                {
                    return $row2;
                }
            }
            function checkMenuAccess($staffcode,$formcode)
            {
                $query3="select stf_View,stf_Add,stf_Edit,stf_Delete from stf_staffforms where stf_SCode=".$staffcode. " and stf_FormCode in (" .$formcode." )";
                $result3=@mysql_query($query3);
                while ($row3=@mysql_fetch_array($result3))
                {
                    $view[]=$row3['stf_View'];
                    $add[]=$row3["stf_Add"];
                    $edit[]=$row3["stf_Edit"];
                    $delete[]=$row3["stf_Delete"];
                }
                if(@in_array("Y",$view)==1 || @in_array("Y",$add)==1 || @in_array("Y",$edit)==1 || @in_array("Y",$delete)==1)
                {
                    return "true";
                }
                else
                {
                    return "false";
                }
            }
            function getFirstLastName($ClientCode)
            {
                if($ClientCode!=0)
                $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname
                FROM `stf_staff` t1
                LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code
                LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code
                WHERE stf_Code = $ClientCode
                ORDER BY stf_Code";
                $result=@mysql_query($staff_query);
                $firstname=@mysql_result( $result,0,'con_Firstname') ;
                $lastname=@mysql_result( $result,0,'con_Lastname') ;
                return $firstname." ".$lastname;
            }
            function getRepeatTypeDesc($id,$row,$simple = false)
            {
                  $type = $row["rpt_type"];
                  $end = $row["rpt_end"];
                  $endtime = $row["rpt_endtime"];
                  $interval = $row["rpt_frequency"];
                  $day = $row["rpt_days"];

                  $bymonth = $row["rpt_bymonth"];
                  $bymonthday = $row["rpt_bymonthday"];
                  $byday = $row["rpt_byday"];
                  $bysetpos = $row["rpt_bysetpos"];
                  $byweekno = $row["rpt_byweekno"];
                  $byyearday = $row["rpt_byyearday"];
                  $wkst = $wkst2 = $row["rpt_wkst"];
                  $cal_count = $row["rpt_count"];

                  $rrule = '';

                  if ( ! $simple )
                    $rrule = 'RRULE:';
                  else {
                    if ( ! empty ( $byday ))
                            {
                      $bydayArr = explode ( ',', $byday );
                      foreach ( $bydayArr as $bydayIdx )
                              {
                        $bydayOut[] = substr ( $bydayIdx, 0, strlen ( $bydayIdx ) -2 ).substr ( $bydayIdx, -2 );
                      }
                      $byday = implode ( ',', $bydayOut );
                    }
                    if ( ! empty ( $wkst ) )
                      $wkst =  $wkst ;
                  }
                  /* recurrence frequency */
                  switch ( $type ) {
                    case 'daily':
                      $rrule .= ( $simple ? 'Daily' : 'FREQ=DAILY' );
                      break;
                    case 'weekly':
                      $rrule .= ( $simple ?  'Weekly' : 'FREQ=WEEKLY' );
                      break;
                    case 'monthlyBySetPos':
                    case 'monthlyByDay':
                    case 'monthlyByDate':
                      $rrule .= ( $simple ? 'Monthly'  : 'FREQ=MONTHLY' );
                      break;
                    case 'yearly':
                      $rrule .= ( $simple ? 'Yearly' : 'FREQ=YEARLY' );
                      break;
                  }
                  if ( ! empty ( $interval ) && $interval > 1 )
                    $rrule .= ';' . ( $simple ?  'Interval' : 'INTERVAL' )
                     . "=$interval";

                  if ( ! empty ( $bymonth ) )
                    $rrule .= ';' . ( $simple ? 'Months' : 'BYMONTH' )
                     . "=$bymonth";

                  if ( ! empty ( $bymonthday ) )
                    $rrule .= ';' . ( $simple ? 'Month Days'  : 'BYMONTHDAY' )
                     . "=$bymonthday";

                  if ( ! empty ( $byday ) )
                    $rrule .= ';' . ( $simple ? 'Days'  : 'BYDAY' )
                     . "=$byday";

                  if ( ! empty ( $byweekno ) )
                    $rrule .= ';' . ( $simple ? 'Weeks' : 'BYWEEKNO' )
                     . "=$byweekno";

                  if ( ! empty ( $bysetpos ) )
                    $rrule .= ';' . ( $simple ?  'Position'  : 'BYSETPOS' )
                     . "=$bysetpos";

                  if ( ! empty ( $wkst ) && $wkst2 != 'MO' )
                    $rrule .= ';' . ( $simple ?  'Week Start'  : 'WKST' )
                     . "=$wkst";

                  if ( ! empty ( $end ) ) {
                    $endtime = ( empty ( $endtime ) ? 0 : $endtime );
                    $utc = ( $simple
                     ? date_to_str ( $end, $DATE_FORMAT_TASK, false ) . ' '
                      . display_time ( $endtime )
                     : export_get_utc_date ( $end, $endtime ) );
                  } else
                  if ( ! empty ( $cal_count ) && $cal_count != 999 )
                    $rrule .= ';' . ( $simple ? 'Count' : 'COUNT' )
                     . "=$cal_count";
                  $rrule = $this->export_fold_lines ( $rrule );
                  while ( list ( $key, $value ) = each ( $rrule ) ) {
                    $recurrance .= "$value\r\n";
                  }
                  if ( $type == 'manual' )
                   $recurrance = '';

                  if ( count ( $rdate ) > 0 ) {
                    $rdatesStr = '';
                    foreach ( $rdate as $rdates ) {
                      $rdatesStr .= date_to_str ( $rdates, $DATE_FORMAT_TASK, false ) . ' ';
                    }
                    $string = ( $simple
                    ? ',' .  'Inclusion Dates' . '=' . $rdatesStr
                    : 'RDATE;VALUE=DATE:' . implode ( ',', $rdate ) );
                    $string = $this->export_fold_lines ( $string );
                    while ( list ( $key, $value ) = each ( $string ) ) {
                      $recurrance .= "$value\r\n";
                    }
                  }
                  if ( $simple )
                   $recurrance .= '<br />';

                  if ( count ( $exdate ) > 0 )
                       {
                    $exdatesStr = '';
                    foreach ( $exdate as $exdates )
                            {
                      $exdatesStr .= date_to_str ( $exdates, $DATE_FORMAT_TASK, false ) . ' ';
                    }
                    $string = ( $simple
                     ? ',' . 'Exclusion Dates' . '=' . $exdatesStr
                     : 'EXDATE;VALUE=DATE:' . implode ( ',', $exdate ) );
                    $string = $this->export_fold_lines ( $string );
                    while ( list ( $key, $value ) = each ( $string ) )
                            {
                      $recurrance .= "$value\r\n";
                    }
                  }
                        return $recurrance;
            }
            function getEndDate($id,$row,$simple = false)
            {
                  $type = $row["rpt_type"];
                  $end = $row["rpt_end"];
                  $endtime = $row["rpt_endtime"];
                  $interval = $row["rpt_frequency"];
                  $day = $row["rpt_days"];

                  $bymonth = $row["rpt_bymonth"];
                  $bymonthday = $row["rpt_bymonthday"];
                  $byday = $row["rpt_byday"];
                  $bysetpos = $row["rpt_bysetpos"];
                  $byweekno = $row["rpt_byweekno"];
                  $byyearday = $row["rpt_byyearday"];
                  $wkst = $wkst2 = $row["rpt_wkst"];
                  $cal_count = $row["rpt_count"];

                  $rrule = '';
                  if ( ! empty ( $end ) ) {
                    $endtime = ( empty ( $endtime ) ? 0 : $endtime );
                    $rrule .= ';' . ( $simple ? 'Until' : 'UNTIL' ) . '=';
                    $utc = ( $simple ? date_to_str ( $end, $DATE_FORMAT_TASK, false ) : export_get_utc_date ( $end, $endtime ) );
                  }
                  return $utc;

            }

            function export_fold_lines ( $string, $encoding = 'none', $limit = 76 ) {
              global $enable_mbstring;

              if ($enable_mbstring) {
                $res = mb_export_fold_lines ( $string, $encoding, $limit);
              } else {
                $res = $this->wc_export_fold_lines ( $string, $encoding, $limit);
              }
              return $res;
            }

            function wc_export_fold_lines ( $string, $encoding = 'none', $limit = 76 ) {
              $len = strlen ( $string );
              $fold = $limit;
              $res = array ();
              $row = '';
              $enc = '';
              $lwsp = 0; // position of the last linear whitespace (where to fold)
              $res_ind = 0; // row index
              $start_encode = 0; // we start encoding only after the ': ' character is encountered
              if ( strcmp( $encoding, 'quotedprintable' ) == 0 )
                $fold--; // must take into account the soft line break
             for ( $i = 0; $i < $len; $i++ ) {
                $enc = $string[$i];

                if ( $start_encode ) {
                  if ( strcmp( $encoding, 'quotedprintable' ) == 0 )
                    $enc = export_quoted_printable_encode( $string[$i] );
                  else if ( strcmp( $encoding, 'utf8' ) == 0 )
                    $enc = utf8_encode ( $string[$i] );
                }
                if ( $string[$i] == ':' )
                  $start_encode = 1;

                if ( ( strlen ( $row ) + strlen ( $enc ) ) > $fold ) {
                  $delta = 0;

                  if ( $lwsp == 0 )
                    $lwsp = $fold - 1; // the folding will occur in the middle of a word
                  if ( $row[$lwsp] == ' ' || $row[$lwsp] == "\t" )
                    $delta = -1;

                  $res[$res_ind] = substr ( $row, 0, $lwsp + 1 + $delta );

                  if ( strcmp( $encoding, 'quotedprintable' ) == 0 )
                    $res[$res_ind] .= '='; // soft line break;
                  $row = substr ( $row, $lwsp + 1 );

                  $row = ' ' . $row;

                  if ( $delta == -1 && strcmp( $encoding, 'utf8' ) == 0 )
                    $row = ' ' . $row;

                  if ( $res_ind == 0 )
                    $fold--; //reduce row length of 1 to take into account the whitespace
                  // at the beginning of lines
                  $res_ind++; // next line
                  $lwsp = 0;
                } //end if ((strlen ($row) + strlen ($enc)) > $fold)
                $row .= $enc;

                if ( $string[$i] == ' ' || $string[$i] == "\t" || $string[$i] == ';' ||
                  $string[$i] == ',' )
                  $lwsp = strlen ( $row ) - 1;

                if ( $string[$i] == ':' && ( strcmp( $encoding, 'quotedprintable' ) == 0 ) )
                  $lwsp = strlen ( $row ) - 1; // We cut at ':' only for quoted printable.
              } //end for ($i = 0; $i < $len; $i++)
              $res[$res_ind] = $row; // Add last row (or first if no folding is necessary)
              return $res;
            } //end function wc_export_fold_lines ($string, $encoding="none", $limit=76)
            function getToAddress($name)
            {
                if($name!="")
                $sql = "SELECT email_value,email_template FROM `email_options` where email_name='".$name."'";
                $res = mysql_query($sql);
                $row = mysql_fetch_assoc($res);
                return ($row);
            }
            function sendMail($to,$subject,$message)
            {
                     /*  $eol="\r\n";
                       $headers .= 'From: '.$_SESSION['firstname'].$eol;
                       $headers .= 'Reply-To: '.$to.$eol;
                      // $headers .= "Return-Path: info@befree.com.au \r\n";
                      $headers .= "Return-Path: murugesh@hiristechnologies.com \r\n";
                       $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n";
                       $status=mail($to , $subject, $message,$headers); */
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $body = $message;
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                         $status = $mail_object->send($to, $headers, $body);

                       return $status;
            }
            function mailCompose($to,$subject,$message,$headersold)
            {
                       //$status=mail($to , $subject, $message,$headers);
                        $headers["From"]    = "help@superrecords.com.au";
                        $headers["To"]      = $to;
                        $headers["Subject"] = $subject;
                        $headers["Content-Type"] = "text/html; charset=\"windows-1251\"\r\n";
                        $body = $message;
                        $params["host"] = "ssl://smtp.gmail.com";
                        $params["port"] = "465";
                        $params["auth"] = true;
                        $params["username"] = "help@superrecords.com.au";
                        $params["password"] = "88ge0rge#";
                        // Create the mail object using the Mail::factory method
                        $mail_object =& Mail::factory("smtp", $params);
                         $status = $mail_object->send($to, $headers, $body);

                       return $status;
            }

            function getIndMgrMail($staffcode)
            {
                 //$query = "SELECT c1.cli_Code, con1.con_Email FROM cli_client AS c1 LEFT OUTER JOIN con_contact AS con1 ON(c1.cli_Code=con1.cli_Code) WHERE cli_Assignedto=".$staffcode;
                 $query = "SELECT t2.con_Email FROM `stf_staff` t1 LEFT JOIN con_contact t2 ON t1.stf_CCode=t2.con_Code where stf_Code=".$staffcode;
                 $res=mysql_query($query);
                 $indMgrEmail=@mysql_result( $res,0,'con_Email') ;
                 return $indMgrEmail;
            }
            function getUsername($staffcode)
            {
                 //$query = "SELECT c1.cli_Code, con1.con_Email FROM cli_client AS c1 LEFT OUTER JOIN con_contact AS con1 ON(c1.cli_Code=con1.cli_Code) WHERE cli_Assignedto=".$staffcode;
                 $query = "SELECT t2.con_Firstname,t2.con_Lastname FROM `stf_staff` t1 LEFT JOIN con_contact t2 ON t1.stf_CCode=t2.con_Code where stf_Code=".$staffcode;
                 $res=mysql_query($query);
                 $notifyuser=@mysql_fetch_array($res) ;
                 $NotifyUser = $notifyuser['con_Firstname']." ".$notifyuser['con_Lastname'];
                 return $NotifyUser;
            }

            function getHeader()
            {
                   /*    $eol="\r\n";
                       $headers .= 'From: info@befree.com.au'.$eol;
                       $headers .= 'Reply-To: info@befree.com.au'.$eol;
                      // $headers .= "Return-Path: info@befree.com.au \r\n";
                       $headers .= "Return-Path: murugesh@hiristechnologies.com \r\n";
                       $headers.= "Content-Type: text/html; charset=\"windows-1251\"\r\n"; */
                        $headers["From"]   = "help@superrecords.com.au";
                       

                       return $headers;
            }
            function getSmtphost(){
                $params["host"] = "ssl://smtp.gmail.com";
                $params["port"] = "465";
                $params["auth"] = true;
                $params["username"] = "help@superrecords.com.au";
                $params["password"] = "88ge0rge#";
                // Create the mail object using the Mail::factory method
                return $mail_object =& Mail::factory("smtp", $params);

            }

            function getClientFiles($id)
            {
                if($id!=0)
                {
                    $query="select dmfilename from jos_docman where dmowner=".$id. " and dmsubmitedby=".$id;
                    $result=@mysql_query($query);
                    $clientfiles[]=@mysql_result( $result,0,'dmfilename') ;
                }
                return $clientfiles;
            }
            function getTmpFiles($id)
            {
                if($id!=0)
                {
                    $query="select dmfilename from jos_docman where id=".$id;
                    $result=@mysql_query($query);
                    $tmpfiles[]=@mysql_result( $result,0,'dmfilename') ;
                }
                return $tmpfiles;
            }

            function getAdminFiles($id)
            {
                if($id!=0)
                {
                    $query="select dmfilename from jos_docman where dmowner=".$id. " and dmsubmitedby=62";
                    $result=@mysql_query($query);
                    $clientfiles[]=@mysql_result( $result,0,'dmfilename') ;
                }
                return $clientfiles;
            }

            function getMailContent($eno)
            {
                switch($eno)
                {
                    case 'E2':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=7";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;

                    case 'E3':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=6";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'E3-tax':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=57";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;

                    case 'E4':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=5";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;

                    case 'E1_AssignAustralian':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=11";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;

                    case 'E1_Salesperson':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=10";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'E5_Hosting':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=12";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'E6':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=13";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'E7_TaxAccount':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=16";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'E8_Notification':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=17";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'ACT':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=18";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'NSW':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=19";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'NT':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=20";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'QLD':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=21";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'SA':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=22";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'TAS':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=23";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'VIC':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=24";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'WA':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=26";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'Thanking':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=34";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'TellAFriend':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=35";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'ForgotPassword':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=36";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'DocUpload':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=37";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'AdminDocUpload':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=38";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'ClientActive':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=39";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'WorksheetStatus':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=53";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'NewCase':
                    $query="SELECT email_name, email_value, email_template FROM email_options where email_id=54";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'CaseStatus':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=55";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'CaseType':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=59";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'Discontinued':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=56";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'NewCrossSales':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=60";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'CrossSalesStatus':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=61";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;

                }
            }
            function smsMailContent($sms)
            {
                switch ($sms)
                {
                    case 'ACT':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=45";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'NSW':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=46";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'NT':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=47";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'QLD':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=48";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'SA':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=49";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'TAS':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=52";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'VIC':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=50";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                    case 'WA':
                     $query="SELECT email_name, email_value, email_template FROM email_options where email_id=51";
                     $res=mysql_query($query);
                     $row=mysql_fetch_assoc($res);
                     return $row;
                     break;
                }
            }
			
		function compareURL($sessionURL,$crntURL)
		{
			if(strcasecmp($sessionURL,$crntURL) != 0)
			{
				unset($_SESSION["filter"]);
				unset($_SESSION["filter_field"]);
				$_SESSION['URL'] = $crntURL; 
			}	
				
		}
		
		function showArray($exp){
			echo '<pre>';
			print_r($exp);
			echo '</pre>';
		}

		function arrayToString($sep,$source){

			$cs_str = implode($sep, $source);
			return $cs_str;
		}

		function stringToArray($sep, $src){

			$cs_array = explode($sep, $src);
			return $cs_array;
		}

		function stringrtrim($source, $sep){

			$string = rtrim($source, $sep);
			return $string;
		}

		function replaceString($srch, $rep, $src)
		{
			$cont = str_replace($srch, $rep, $src);
			return $cont;
		}
                
                function getFeatureVisibility($ftName=NULL)
                {
                    
                    if(isset($ftName))
                        $strAppend = "WHERE disp_id = '".$ftName."' AND stf_SCode = '".$_SESSION['staffcode']."'";
                    else 
                        $strAppend = "";
                    
                    $ftQry = "SELECT * FROM stf_staff_features {$strAppend}";
                    
                    $fetchData = mysql_query($ftQry);
                    
                    while($res = mysql_fetch_assoc($fetchData)){
                        if(isset($ftName))
                            $arrFeatures = $res;
                        else
                            $arrFeatures[$res['ft_id']] = $res;
                    }
                        
                    return $arrFeatures;
                }
                    
    }
    $commonUses = new commonUse();
?>
