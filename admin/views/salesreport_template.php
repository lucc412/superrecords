<?php
ob_start();
    //require_once("common/class.Database.php");
    include("dbclass/commonFunctions_class.php");
    include 'common/varDeclare.php';
    if($_GET['a']=="reset") $_SESSION['saveid'] = "";
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
        <title>Super Records</title>
        <style type="text/css">
           @media print {
                p#printscreen {
                    display:block;
                }
                div#notprint {
                    display:none;
                }
                td#notprint {
                    display:none;
                }
                            th#notprint {
                    display:none;
                }
          }
        </style>
        <script type="text/javascript" language="javascript">
function customSave(id,page,aid,type,sid)
{
    // lead closure reason
    if((document.getElementById('cli_Status'+id)) && (document.getElementById('lead_to_notsuccessful_reason'+id)) && (document.getElementById('lead_to_notsuccessful_date'+id))){
        if(document.getElementById('cli_Status'+id).value=='3' && document.getElementById('lead_to_notsuccessful_reason'+id).value==''){
            alert('Enter Lead closed Reason');
            document.getElementById('lead_to_notsuccessful_reason'+id).focus();
            return false;
        }
        else if(document.getElementById('cli_Status'+id).value=='3' && document.getElementById('lead_to_notsuccessful_date'+id).value==''){
            alert('Enter Lead closed Date');
            document.getElementById('lead_to_notsuccessful_date'+id).focus();
            return false;
        }
        else if(document.getElementById('cli_Statusold'+id).value!='Not Successful' && document.getElementById('cli_Status'+id).value!='3' && document.getElementById('lead_to_notsuccessful_reason'+id).value!='') {
            alert('Status should selected Not Successful');
            document.getElementById('cli_Status'+id).focus();
            return false;
        }
        else if(document.getElementById('cli_Statusold'+id).value!='Not Successful' && document.getElementById('cli_Status'+id).value!='3' && document.getElementById('lead_to_notsuccessful_date'+id).value!='') {
            alert('Status should selected Not Successful');
            document.getElementById('cli_Status'+id).focus();
            return false;
        }
    }

    var val = document.getElementById('generateForm').innerHTML;
    document.getElementById('genId').innerHTML = val;
    if(document.form1.condition_value1_from) document.inlineSave.condition_value1_from.value = document.form1.condition_value1_from.value;
    if(document.form1.condition_value2_from) document.inlineSave.condition_value2_from.value = document.form1.condition_value2_from.value;
    if(document.form1.condition_value3_from) document.inlineSave.condition_value3_from.value = document.form1.condition_value3_from.value;
    if(document.form1.condition_value4_from) document.inlineSave.condition_value4_from.value = document.form1.condition_value4_from.value;
    if(document.form1.condition_value5_from) document.inlineSave.condition_value5_from.value = document.form1.condition_value5_from.value;
    if(document.form1.condition_value1_to) document.inlineSave.condition_value1_to.value = document.form1.condition_value1_to.value;
    if(document.form1.condition_value2_to) document.inlineSave.condition_value2_to.value = document.form1.condition_value2_to.value;
    if(document.form1.condition_value3_to) document.inlineSave.condition_value3_to.value = document.form1.condition_value3_to.value;
    if(document.form1.condition_value4_to) document.inlineSave.condition_value4_to.value = document.form1.condition_value4_to.value;
    if(document.form1.condition_value5_to) document.inlineSave.condition_value5_to.value = document.form1.condition_value5_to.value;
    document.inlineSave.fields1.value = document.form1.fields1.value;
    document.inlineSave.fields2.value = document.form1.fields2.value;
    document.inlineSave.fields3.value = document.form1.fields3.value;
    document.inlineSave.fields4.value = document.form1.fields4.value;
    document.inlineSave.fields5.value = document.form1.fields5.value;
    if(type=='save') document.inlineSave.action="sales_report.php?aid="+aid+"&row_id="+id+"&page="+page;
    else document.inlineSave.action="sales_report.php?aid="+aid+"&open_id="+id+"&sid="+sid+"&page="+page;
    document.inlineSave.submit();
    return false;
}
        </script>
    </head>
    <body>
        <?php
        require_once "includes/header.php";
        // inline save
        $grid_rowid      = @$_GET['row_id'];
            if($grid_rowid)
            {
                $output_fields = $_POST['output_fields'];
                $rowid = $_GET['row_id'];
                $fields = "";
                    foreach($output_fields as $fld)
                    {
                        if($fld=="cli_DiscontinuedDate" || $fld=="cli_Createdon" || $fld=="cli_Lastdate" || $fld=="cli_FutureContactDate" || $fld=="date_contract_signed" || $fld=="date_quotesheet_submitted" || $fld=="date_permanent_info" || $fld=="date_india_manager_assigned" || $fld=="date_salesnotes_submitted" || $fld=="date_taxaccount_submitted" || $fld=="date_client_changed" || $fld=="lead_to_notsuccessful_date")
                        {
                            $fields .= "$fld='".$commonUses->getDateFormat($_POST[$fld][$rowid])."',";
                        }
                        // service required
                        else if($fld=="cli_ServiceRequired")
                        {
                         if(count($_POST['cli_ServiceRequired'][$rowid]>0))
                         {
                             $selectedservice = $_POST['cli_ServiceRequired'][$rowid];
                             mysql_query("Delete from `cli_allservicerequired` where cli_ClientCode=".$rowid);
                            foreach($selectedservice as $v) {
                            $query = "insert into cli_allservicerequired (cli_ServiceRequiredCode,cli_ClientCode) values(".$v.",$rowid)";
                            $service = mysql_query($query);
                            }
                         }
                        }
                        else if($fld=="cli_Lastmodifiedon")
                        {
                            $fields .="";
                        }
                        else if(($fld=="cli_DateReceived") || ($fld=="cli_DateReceived" && $fld=="cli_DayReceived"))
                        {
                            $redate = $commonUses->getDateFormat($_POST[$fld][$rowid]); 
                             $recday = date("D",  strtotime($redate));
                             switch ($recday)
                             {
                                 case 'Mon':
                                     $dayname = "Monday";
                                     break;
                                 case 'Tue':
                                     $dayname = "Tuesday";
                                     break;
                                 case 'Wed':
                                     $dayname = "Wednesday";
                                     break;
                                 case 'Thu':
                                     $dayname = "Thursday";
                                     break;
                                 case 'Fri':
                                     $dayname = "Friday";
                                     break;
                                 case 'Sat':
                                     $dayname = "Saturday";
                                     break;
                                 case 'Sun':
                                     $dayname = "Sunday";
                                     break;

                             }
                            $fields .= "cli_DateReceived='".$redate."',cli_DayReceived='".$dayname."',";
                        }
                        else if($fld=="cli_DayReceived")
                        {
                            $fields .="";
                        }

                        else {
                            $fields .= "$fld='".str_replace("'","''",$_POST[$fld][$rowid])."',";
                        }
                    }

                    $fields = substr($fields,0,-1);
                    $lastmoddate = date("Y-m-d G:i:s");
                    $fields = $fields.",cli_Lastmodifiedon='".$lastmoddate."'";
                    $query = "update `jos_users` set ".$fields." where cli_Code=".$rowid;
                    $result = mysql_query($query);

            }
            if($_GET['open_id']) {
                $query = "UPDATE jos_users SET cli_Status=".$_GET['sid'].",lead_to_notsuccessful_date='',lead_to_notsuccessful_reason='' WHERE cli_Code=".$_GET['open_id'];
                mysql_query($query);
            }
        include 'dbclass/salesreport_db_class.php';

        ?>
        <div id="notprint" align="left">
            <form name="form1" method="post" >
                <div id="generateForm">
                <table cellpadding="10" width="90%"  align="left" >
                     <tr>
                        <td colspan="4" height="40" align="left"><span class="frmheading">Custom Sales Report</span></td>
                      </tr>
                      <tr>
                                    <td><b>Choose the Report</b></td>
                                    <td>
                                        <select name="csr_Report" onChange="return saveCondition('<?php echo $_SESSION['staffcode']; ?>',this.value)">
                                            <option value="0">Select the report</option>
                                            <?php
                                            if($_POST['saveid']) $_SESSION['saveid'] = $_POST['saveid'];
                                                $query = "SELECT csr_Code,csr_Title FROM csr_customsalesreportsave WHERE csr_SCode=".$_SESSION['staffcode'];
                                                $result = mysql_query($query);
                                                while($reptitle = mysql_fetch_array($result))
                                                {
                                                 if(($reptitle['csr_Code']==$_SESSION['saveid'])) echo $sr = "selected"; else $sr = ""  ;
                                            ?>
                                            <option value="<?php echo $reptitle['csr_Code']; ?>" <?php echo $sr; ?>><?php echo $reptitle['csr_Title']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="stfcode" value="<?php echo $_SESSION['staffcode']; ?>">
                                    </td>
                                    <td>&nbsp;<div id="img_load" >&nbsp;</div></td>
                      </tr><tr><td></td></tr>
                      <tr>
                            <td valign="top">
                                <b>Condition fileds</b> <br>
                                 <select name="fields1" id="fields1" onchange="return select_fields(this.value,'','','1');">
                                  <option value="">Select fields</option>
                                  <?php echo $cont; ?>
                                 </select>
                            </td>
                            <td valign="top">
                                <b>Conditions</b> <br>
                               <select name="condition1" id="condition1" onchange="return select_conditions(this.value,'1','','');">
                                <option value="">Select</option>

                               </select>
                            </td>
                            <td valign="top">
                                <b>Value</b> <br>
                                <div id="value_for_condition1">
                                  <input type="text" name="condition_value1" id="condition_value1" />
                                </div>
                            </td>
                            <td valign="top" rowspan="5">
                               <b> Output fields</b> <br>
                               <select name="output_fields[]" id="output_fields" class="multiselect" multiple="multiple" >
                                  <?php echo $sales_cont; ?>
                               </select> <br>
                               <b>NOTE:</b>&nbsp;Click "+" on fieldname to select.
                            </td>
                      </tr>
                      <tr>
                             <td valign="top">
                                 <select name="fields2" id="fields2" onchange="return select_fields(this.value,'','','2');">
                                  <option value="">Select fields</option>
                                  <?php echo $cont; ?>
                                 </select>
                            </td>
                            <td valign="top">

                               <select name="condition2" id="condition2" onchange="return select_conditions(this.value,'2','','');">
                                <option value="">Select</option>

                               </select>
                            </td>
                            <td valign="top">

                                <div id="value_for_condition2">
                                  <input type="text" name="condition_value2" id="condition_value2" />
                                </div>
                            </td>
                      </tr>
                      <tr>
                             <td valign="top">

                                 <select name="fields3" id="fields3" onchange="return select_fields(this.value,'','','3');">
                                  <option value="">Select fields</option>
                                  <?php echo $cont; ?>
                                 </select>
                            </td>
                            <td valign="top">

                               <select name="condition3" id="condition3" onchange="return select_conditions(this.value,'3','','');">
                                <option value="">Select</option>

                               </select>
                            </td>
                            <td valign="top">

                                <div id="value_for_condition3">
                                  <input type="text" name="condition_value3" id="condition_value3"  />
                                </div>
                            </td>
                      </tr>
                      <tr>
                             <td valign="top">
                                 <select name="fields4" id="fields4" onchange="return select_fields(this.value,'','','4');">
                                  <option value="">Select fields</option>
                                  <?php echo $cont; ?>
                                 </select>
                            </td>
                            <td valign="top">

                               <select name="condition4" id="condition4" onchange="return select_conditions(this.value,'4','','');">
                                <option value="">Select</option>

                               </select>
                            </td>
                            <td valign="top">

                                <div id="value_for_condition4">
                                  <input type="text" name="condition_value4" id="condition_value4" />
                                </div>
                            </td>
                      </tr>
                      <tr>
                             <td valign="top">
                                 <select name="fields5" id="fields5" onchange="return select_fields(this.value,'','','5');">
                                  <option value="">Select fields</option>
                                  <?php echo $cont; ?>
                                 </select>
                            </td>
                            <td valign="top">

                               <select name="condition5" id="condition5" onchange="return select_conditions(this.value,'5','','');">
                                <option value="">Select</option>

                               </select>
                            </td>
                            <td valign="top">

                                <div id="value_for_condition5">
                                  <input type="text" name="condition_value5" id="condition_value5" />
                                </div>
                            </td>
                      </tr>
                      <tr>
                        <td colspan="4" height="20" align="left"><b>NOTE:</b>&nbsp; Please select at-least one conditions and outputs.</td>
                      </tr>
                      <tr>
                                    <?php
                                        $query = "SHOW TABLE STATUS LIKE 'csr_customsalesreportsave'";
                                        $result = mysql_query($query);
                                        $maxid = mysql_fetch_array($result);
                                        $mid = $maxid['Auto_increment'];
                                      //  if($_GET['aid']) $mid = $mid-1;
                                    if($_GET['aid']) $sid = $_POST['saveid']; else $sid = $mid;
                                    ?>
                                    <td><b>Save the Current Report as Name</b> : </td>
                                    <td><input type="text" name="csr_Title" id="csr_Title" value="<?php echo $_POST['csr_Title']; ?>">
                                        <input type="hidden" name="saveid" id="saveid" value="<?php echo $sid; ?>">
                                        <input type="hidden" name="maxid" id="maxid" value="<?php echo $mid; ?>">
                                        <input type="hidden" name="hiSave" id="hiSave" value="">
                                        <input type="hidden" name="hiUpdate" id="hiUpdate" value="">
                                    </td>
                                    <td>
                                        <?php if($_POST['csr_Title']=="") { ?>
                                        <div id="butSave">
                                            <input type="submit" name="save_button" value="Save" onClick="return saveSubmit();">
                                        </div>
                                        <?php } if(($_GET['aid'] || $_GET['page']) && $_POST['csr_Title']!="") { ?>
                                        <div id="saveAs" style="position:relative; top: 10px;">
                                            <input type="submit" name="save_button" value="Save As New" onClick="return saveasSubmit();">
                                        </div>
                                        <?php } ?>
                                        <div id="saveAsreport" style="display:none; position:relative; top: 10px;">
                                            <input type="submit" name="save_button" value="Save As New" onClick="return saveasSubmit();">
                                        </div>
                                        <div id="butUpdate" style="display:none; position:relative; top:-11px; left:120px;">
                                            <input type="submit" name="update_button" value="Update" onClick="return updateSubmit();">
                                        </div>
                                        <?php if($_GET['aid'] && $_POST['csr_Title']) { ?>
                                        <div id="sUpdate" style="position:relative; top:-11px; left:120px;">
                                            <input type="submit" name="update_button" value="Update" onClick="return updateSubmit();">
                                        </div>
                                       <?php } ?>
                                    </td>
                      </tr>
                      <tr>
                        <td colspan="4" height="20" align="center"></td>
                      </tr>
                      <tr>
                         <td colspan="4" height="50" align="center"><input type="button" name="view" value="Generate Report" onclick="return validation();" />&nbsp;&nbsp;<input type="button" name="view" value="Reset Filter" onclick="window.location='sales_report.php?a=reset';" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                      </tr>
                </table>
        </div>
                <div id="mm"></div>
            </form>
         </div>
        <div id="showgrid" style="clear:both;padding-top:30px;">
            <table width="100%">
                <tr>
                      <td align="left" width="600">
                      <label style="text-align:center;font-family:Arial,Tahoma,Verdana,Helvetica,sans-serif;font-size:12px;"><?php echo $total_rec; ?></label>
                      </td>
                      <td><?php echo $extra_options; ?></td>
                      <td align="center">
                      <?php echo $page_cont; ?>
                      </td>
                </tr>
            </table>
            <br>
            <?php echo $table_content; ?>
        </div>
                <link type="text/css" rel="stylesheet" href="<?php echo $styleSheet; ?>jquery-ui-1.7.2/themes/base/ui.all.css" />
                <link type="text/css" href="<?php echo $styleSheet; ?>ui.multiselect.css" rel="stylesheet" />
                <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.4.2.min.js"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-ui-1.8.custom.min.js"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>plugins/localisation/jquery.localisation-min.js"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>plugins/scrollTo/jquery.scrollTo-min.js"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>ui.multiselect.js"></script>
                <script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>sales_report.js"></script>
          <style>
            .multiselect {
        height:300px;
        width:550px;
        }
          </style>
        <script>
          $(document).ready(function()
          {
        <?php echo $script_content; ?>
        });
        </script>    </body>
</html>
