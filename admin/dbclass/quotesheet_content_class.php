<?php
class quotesheetContent extends Database
{
            // card file info content
            function cardfileinfo()
            {
                    global $access_file_level_crd;
                    // card file content
                    $recid=$_GET['recid'];
                    $cli_code=$_REQUEST['cli_code'];
                    $showeditorquery = "SELECT * FROM crd_qcardfile where crd_ClientCode =".$cli_code;
                    $showeditorresult=mysql_query($showeditorquery);
                    if(mysql_num_rows($showeditorresult)>0)
                    {
                             $row_qcard = mysql_fetch_assoc($showeditorresult);
                             ?>
                            <br>
                            <form enctype="multipart/form-data" action="dbclass/quotesheet_db_class.php" method="post" name="qcardfile" id="form_card">
                                    <input type="hidden" name="sql_qcard" value="update_qcard">
                                    <input type="hidden" name="cli_code" value="<?php echo $cli_code ?>">
                                    <input type="hidden" name="recid" value="<?php echo $recid ?>">
                                    <input type="hidden" name="xcrd_Code" value="<?php echo $row_qcard["crd_Code"] ?>">
                                    <?php
                                    if($_GET['a']=="edit")
                                    {
                                         if($access_file_level_crd['stf_Edit']=="Y")
                                                  {
                                                        $this->showroweditor_qcardfile($row_qcard, true,$cli_code);
                                                  }
                                                  else
                                                  {
                                                    echo "You are not authorised to edit a record.";
                                                  }
                                        if($access_file_level_crd['stf_Edit']=="Y")
                                        {
                                        ?>
                                        <input type="submit" name="action" id="cardupdate" value="Update" class="button" >
                                        <?php
                                        }
                                    }
                                    else
                                    {
                                        $showquery = "SELECT * FROM (SELECT t1.`crd_Code`, t1.`crd_ClientCode`, t1.`crd_LegalName`, t1.`crd_BillingName`, t1.`crd_TradingName`, t1.`crd_EntityType`, lp5.`ety_Description` AS `lp_crd_EntityType`, t1.`crd_ABN`, t1.`crd_HasRelatedEntities`, t1.`crd_PrimaryContact`, lp8.`con_Firstname` AS `lp_crd_PrimaryContact`, t1.`crd_Createdby`, t1.`crd_Createdon`, t1.`crd_Lastmodifiedby`, t1.`crd_Lastmodifiedon` FROM `crd_qcardfile` AS t1 LEFT OUTER JOIN `ety_entitytype` AS lp5 ON (t1.`crd_EntityType` = lp5.`ety_Code`) LEFT OUTER JOIN `con_contact` AS lp8 ON (t1.`crd_PrimaryContact` = lp8.`con_Code`)) subq where crd_ClientCode=".$cli_code;
                                        $showresult=mysql_query($showquery);
                                        $row_qcard = mysql_fetch_assoc($showresult);
                                                    if($access_file_level_crd['stf_View']=="Y")
                                                      {
                                                         $this->showrow_qcardfile($row_qcard, $cli_code);
                                                       }
                                                     else
                                                              {
                                                                    echo "You are not authorised to view a record.";
                                                              }
                                    }
                                    ?>
                            </form>
                    <?php
                     }
                    else
                    {
                    ?>
                            <form enctype="multipart/form-data" action="dbclass/quotesheet_db_class.php" method="post" name="qcardfile" id="form_card">
                                    <p><input type="hidden" name="sql_qcard" value="insert_qcard"></p>
                                    <input type="hidden" name="cli_code" value="<?php echo $cli_code ?>">
                                    <input type="hidden" name="recid" value="<?php echo $recid ?>">
                                    <?php
                                    $row_qcard = array(
                                      "crd_Code" => "",
                                      "crd_ClientCode" => "",
                                      "crd_LegalName" => "",
                                      "crd_BillingName" => "",
                                      "crd_TradingName" => "",
                                      "crd_EntityType" => "",
                                      "crd_ABN" => "",
                                      "crd_HasRelatedEntities" => "",
                                      "crd_PrimaryContact" => "",
                                      "crd_Createdby" => "",
                                      "crd_Createdon" => "",
                                      "crd_Lastmodifiedby" => "",
                                      "crd_Lastmodifiedon" => "");
                                      if($_GET['a']=="edit")
                                      {
                                         if($access_file_level_crd['stf_Add']=="Y")
                                         {
                                                  $this->showroweditor_qcardfile($row_qcard, false,$cli_code);
                                          ?>
                                                  <input type="submit" name="action" value="Save" class="button">
                                          <?php
                                         }
                                         else
                                         {
                                                  echo "You are not authorised to add a record.";
                                          }
                                     }
                                     else
                                     {
                                             if($access_file_level_crd['stf_View']=="Y")
                                             {
                                                 $this->showrow_qcardfile($row_qcard, $cli_code);
                                             }
                                             else
                                             {
                                                  echo "You are not authorised to view a record.";
                                              }
                                    }
                                    ?>
                            </form>
                    <?php
                    }

            }
            // edit card file
             function showroweditor_qcardfile($row_qcard, $iseditmode,$client_code)
              {
            ?>
                    <input type="hidden" name="crd_ClientCode" value="<?php echo $client_code ?>">
                    <input type="hidden" name="cde_CardFileCode" value="<?php echo $row_qcard["crd_Code"] ?>">
                    <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="40%">
                        <tr>
                                <td class="hr">Legal Name</td>
                                <td class="dr"><input type="text" name="crd_LegalName" value="<?php echo str_replace('"', '&quot;', trim($row_qcard["crd_LegalName"])) ?>"></td>
                        </tr>
                        <tr>
                                <td class="hr">Billing Name</td>
                                <td class="dr"><input type="text"  name="crd_BillingName" value="<?php echo str_replace('"', '&quot;', trim($row_qcard["crd_BillingName"])) ?>"></td>
                        </tr>
                        <tr>
                                <td class="hr">Trading Name</td>
                                <td class="dr"><input type="text"  name="crd_TradingName" value="<?php echo str_replace('"', '&quot;', trim($row_qcard["crd_TradingName"])) ?>"></td>
                        </tr>
                        <tr>
                                <td class="hr">Entity Type</td>
                                <td class="dr">
                                    <select name="crd_EntityType"><option value="0">Select Entity Type</option>
                                        <?php
                                          $sql = "select `ety_Code`, `ety_Description` from `ety_entitytype` order by ety_Order asc";
                                          $res = mysql_query($sql) or die(mysql_error());

                                          while ($lp_row = mysql_fetch_assoc($res)){
                                          $val = $lp_row["ety_Code"];
                                          $caption = $lp_row["ety_Description"];
                                          if ($row_qcard["crd_EntityType"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                        </tr>
                        <tr>
                                <td class="hr">ABN</td>
                                <td class="dr"><input type="text"  name="crd_ABN" onkeypress='return isNumberKey(event)' value="<?php echo str_replace('"', '&quot;', trim($row_qcard["crd_ABN"])) ?>"></td>
                        </tr>
                        <tr>
                                <td class="hr">Related Entities</td>
                                <td class="dr">
                                    <select name="crd_HasRelatedEntities" onChange="showClients(this.value)"><option value="0">Select Related Entities</option>
                                         <?php
                                          $lookupvalues = array("Y","N");
                                          reset($lookupvalues);
                                          foreach($lookupvalues as $val){
                                          $caption = $val;
                                          if($caption=="Y")
                                                $caption="Yes";
                                                else if($caption=="N")
                                                $caption="No";
                                          if ($row_qcard["crd_HasRelatedEntities"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                        </tr>
                        <tr >
                                <td >
                                    Client List
                                </td>
                                <td>
                                    <?php
                                    if ($row_qcard["crd_HasRelatedEntities"]=="Y")
                                    {
                                    ?>
                                        <script>showClients("Y")</script>
                                        <div id="allclients"></div>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <div id="allclients"></div>
                                    <?php } ?>
                                </td>
                        </tr>
                        <tr>
                                <td class="hr">Primary Contact</td>
                                <td class="dr">
                                    <select name="crd_PrimaryContact"><option value="0">Select Contact</option>
                                        <?php
                                          $sql = "select t1.`con_Code`, t1.`con_Firstname`, t1.`con_Lastname` from `con_contact` as t1 LEFT JOIN cnt_contacttype AS t2 on t1.con_Type=t2.cnt_Code where t2.cnt_Description like 'Client' and t1.con_Company=".$_GET['cli_code'];
                                          $res = mysql_query($sql) or die(mysql_error());

                                          while ($lp_row = mysql_fetch_assoc($res)){
                                          $val = $lp_row["con_Code"];
                                          $caption = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                                          if ($row_qcard["crd_PrimaryContact"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                        </tr>
                    </table>
            <?php
            }
            // view card file
             function showrow_qcardfile($row_qcard ,$client_code)
              {
            ?>
                    <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="40%">
                        <tr>
                            <td class="hr">Legal Name</td>
                            <td class="dr"><?php echo str_replace('"', '&quot;', trim($row_qcard["crd_LegalName"])); ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Billing Name</td>
                            <td class="dr"><?php echo str_replace('"', '&quot;', trim($row_qcard["crd_BillingName"])) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Trading Name</td>
                            <td class="dr"><?php echo str_replace('"', '&quot;', trim($row_qcard["crd_TradingName"])) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Entity Type</td>
                            <td class="dr">
                        <?php echo $row_qcard["lp_crd_EntityType"]; ?></td>
                        </tr>
                        <tr>
                            <td class="hr">ABN</td>
                            <td class="dr"><?php echo str_replace('"', '&quot;', trim($row_qcard["crd_ABN"])) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Related Entities</td>
                            <td class="dr">
                                <?php
                                if($row_qcard["crd_HasRelatedEntities"]=='Y') echo 'Yes'; else echo 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="hr">Primary Contact</td>
                            <td class="dr">
                                <?php
                                    echo $row_qcard["lp_crd_PrimaryContact"] ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="hr">Created By</td>
                            <td class="dr"><?php echo htmlspecialchars($row_qcard["crd_Createdby"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Created On</td>
                            <td class="dr"><?php echo htmlspecialchars($row_qcard["crd_Createdon"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Lastmodified By</td>
                            <td class="dr"><?php echo htmlspecialchars($row_qcard["crd_Lastmodifiedby"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Lastmodified On</td>
                            <td class="dr"><?php echo htmlspecialchars($row_qcard["crd_Lastmodifiedon"]) ?></td>
                        </tr>
                    </table>
            <?php
            }
            // invoice contnet
            function invoiceContent()
            {
                    global $access_file_level_inv;
                    global $commonUses;
                    $cli_code=$_REQUEST['cli_code'];
                    $recid=$_GET['recid'];
                    $query = "SELECT * FROM inv_qinvoice where inv_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_inv = mysql_fetch_assoc($result);
                    $inv_Code=@mysql_result( $result,0,'inv_Code') ;
                    $details_query = "SELECT * FROM inv_qinvoicedetails where inv_QICode =".$inv_Code." order by inv_Code";
                    $details_result=@mysql_query($details_query);
                    if($_GET['a']=="edit")
                    {
                        $this->showtableheader_inv($access_file_level_inv);
                        if($access_file_level_inv['stf_Add']=="Y" || $access_file_level_inv['stf_Edit']=="Y" || $access_file_level_inv['stf_Delete']=="Y")
                        {
                              if(mysql_num_rows($details_result)>0)
                              {
                     ?>
                                    <form name="qinvoicedetailedit" method="post" action="dbclass/quotesheet_db_class.php" id="form_invoice">
                                            <?php
                                            if($_GET['a']=="edit")
                                            {
                                                if($access_file_level_inv['stf_Edit']=="Y")
                                                {
                                                    $this->showrow_invoicedetails($details_result,$inv_Code,$access_file_level_inv,$cli_code,$recid);
                                                    $query = "SELECT i1.inv_Code,i2.inv_Notes,i2.inv_IndiaNotes FROM inv_qinvoice AS i1 LEFT OUTER JOIN inv_qinvoicedetails AS i2 ON (i1.inv_Code = i2.inv_QICode) where inv_ClientCode =".$cli_code;
                                                    $result=@mysql_query($query);
                                                    $row_notes = mysql_fetch_array($result);
                                                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                        ?>
                                                        <table class="fieldtable" border="0" cellspacing="1" cellpadding="14">
                                                        <tr><td><div style="float:left; width:236px;"><b>Notes</b></div></td><td><div style="width:377px;"><textarea name="inv_Notes" rows="3" cols="53" ><?php echo $row_notes['inv_Notes']; ?></textarea> </div></td></tr>
                                                        <tr><td><div style="float:left; width:236px;"><b>India Notes</b></div></td><td><div style="width:377px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="inv_IndiaNotes" rows="3" cols="53" ><?php echo $row_notes['inv_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['inv_IndiaNotes']; ?> <input type="hidden" name="inv_IndiaNotes" value="<?php echo $row_notes['inv_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                        <tr>
                                                            <td colspan="13"  >
                                                            <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                            <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                            <input type="hidden" name="xinv_Code" value="<?php echo $inv_Code;?>">
                                                            <center><input type="submit" name="qinvoice" id="invoiceupdate" value="Update" class="detailsbutton"></center>
                                                            </td>
                                                        </tr>
                                                        </table>
                                                 <?php
                                                 }
                                                 else if($access_file_level_inv['stf_Edit']=="N")
                                                 {
                                                     echo "You are not authorised to edit a record.";
                                                 }
                                            }
                                            ?>
                                    </form>
                                    <?php
                                    }
                                    else
                                         {
                                                    //Save all tasks for this category in details table
                                                    $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Invoice%')";
                                                    $tresult=@mysql_query($tquery);
                                                    $tcount=mysql_num_rows($tresult);
                                                    if($tcount>0)
                                                    {
                                                                    //Insert all tasks in details table for this client
                                                                    while($trow=@mysql_fetch_array($tresult))
                                                                    {
                                                                      $sql = "insert into `inv_qinvoicedetails` (`inv_QICode`, `inv_TaskCode`) values (" .$inv_Code.", " .$trow['tsk_Code'].")";
                                                                      @mysql_query($sql);
                                                                      echo "<META HTTP-EQUIV=Refresh CONTENT='0'> ";
                                                                    }
                                                    }
                                            }

                         }
                         else
                         {
                             echo "You are not authorised to view this resource";
                         }
                   }
                   else {
                                             if($access_file_level_inv['stf_View']=="Y")
                                             {
                                                   $this->showtableheader_inv($access_file_level_inv);
                                                   $this->showrow_invoicedetails_view($details_result,$inv_Code);
                                                   echo "</table>";
                                                   $this->showrow_invoiceFooter($row_inv);
                                             }
                                             else
                                             {
                                                  echo "You are not authorised to view a record.";
                                              }

                   }
            }
            // invoice view record
            function showrow_invoicedetails($details_result,$inv_Code,$access_file_level_inv,$cli_code,$recid)
            {
                  global $commonUses;
                    $count=mysql_num_rows($details_result);
                    $c=0;
                    while ($row_invdetails=mysql_fetch_array($details_result))
                    {
                        $tcode = $row_invdetails["inv_TaskCode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="inv_Code[<?php echo $tcode; ?>]" value="<?php echo $row_invdetails["inv_Code"];?>">
                        <input type="hidden" name="inv_QICode[<?php echo $tcode; ?>]" value="<?php echo $row_invdetails["inv_QICode"];?>">
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_invdetails["inv_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==4) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==7) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==9) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                        <tr>
                            <td>
                                <div style="float:left;"><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_invdetails["inv_TaskCode"])); ?></div>
                                <?php
                                    $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_invdetails["inv_TaskCode"];
                                    $typeresult=@mysql_query($typequery);
                                    $type_control = mysql_fetch_array($typeresult);
                                ?>
                                <div style="float:right;">
                                    <?php
                                        if($type_control["tsk_TypeofControl"]=="0") {

                                        if($row_invdetails["inv_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                    ?>
                                        <input type="checkbox" name="inv_TaskValue[<?php echo $tcode; ?>]" id="task_val" <?php echo $selyes; ?> onclick="rateVal(this.checked,<?php echo $c; ?>)" value="Y">
                                    <?php
                                        if($row_invdetails["inv_TaskValue"]=="Y")
                                        {
                                            $taskCont .= "<script>
                                                    rateVal(true,$c);
                                                    </script>";
                                        }
                                    } ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                    if($c==0) echo "$250";
                                    if($c==1) echo "$730";
                                    if($c==2) echo "$835";
                                    if($c==3) echo "$325";
                                    if($c==4) echo "$50";
                                    if($c==5) echo "$100";
                                    if($c==6) echo "$300";
                                    if($c==7) echo "$100";
                                    if($c==8) echo "$300";
                                    if($c==9) echo "$0";
                                    if($c==10) echo "$0";
                                    if($c==11) echo "$0";
                                ?>
                            </td>
                            <td>
                                <input type="text" name="inv_Rates[<?php echo $tcode; ?>]" id="inv_Rates_<?php echo $c; ?>" value="<?php if($row_invdetails["inv_Rates"]==0.00 && $row_invdetails["inv_TaskValue"]=="") {
                                    if($c==0) echo "$250";
                                    if($c==1) echo "$730";
                                    if($c==2) echo "$835";
                                    if($c==3) echo "$325";
                                    if($c==4) echo "$50";
                                    if($c==5) echo "$100";
                                    if($c==6) echo "$300";
                                    if($c==7) echo "$100";
                                    if($c==8) echo "$300";
                                    if($c==9) echo "$0";
                                    if($c==10) echo "$0";
                                    if($c==11) echo "$0";
                                } else { echo "$".$row_invdetails["inv_Rates"]; } ?>" disabled>
                            </td>
                            <td>
                                <?php
                                    if($c==0) echo "one off";
                                    if($c==1) echo "one off";
                                    if($c==2) echo "one off";
                                    if($c==3) echo "one off";
                                    if($c==4) echo "per hour";
                                    if($c==5) echo "per hour";
                                    if($c==6) echo "per year";
                                    if($c==7) echo "per month";
                                    if($c==8) echo "per year";
                                    if($c==9) echo "per year";
                                    if($c==10) echo "per year";
                                    if($c==11) echo "";
                                ?>
                            </td>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_invdetails["inv_TaskCode"].",";
                    }
                    $consolidated_ids = substr($consolidated_ids,0,-1);
                    ?>
                    <input type="hidden" name="inv_TaskCode" value="<?php echo $consolidated_ids;?>">
                    <?php
                    echo $taskCont;
             }
             // invoice view record header
            function showrow_invoiceFooter( $row_inv)
            {
                global $commonUses;
                echo "<br><span class='footer'>Created by: ".$row_inv['inv_Createdby']." | ". "Created on: ".$commonUses->showGridDateFormat($row_inv['inv_Createdon'])." | ". "Lastmodified by: ".$row_inv['inv_Lastmodifiedby']." | ". "Lastmodified on: ".$commonUses->showGridDateFormat($row_inv['inv_Lastmodifiedon'])."</span>";
            }
             // invoice edit & view record header
              function showtableheader_inv($access_file_level_inv)
              {
              ?>
                    <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5" >
                          <tr class="fieldheader">
                            <th class="fieldheader" nowrap style="width:100px ">Tasks Agreed</th>
                            <th class="fieldheader" style="width:100px ">Standard Rates (ex.GST)</th>
                            <th class="fieldheader" style="width:100px ">Agreed Rates (ex.GST)</th>
                            <th class="fieldheader" style="width:100px ">Period</th>
                          </tr>
            <?php
            }
            // invoice view record
             function showrow_invoicedetails_view($details_result,$inv_Code)
              {
                  global $conn;
                  global $commonUses;
                 $c=0;
                 while ($row_invdetails=mysql_fetch_array($details_result))
                 {
                ?>
                <?php
                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_invdetails["inv_TaskCode"];
                                    $lookupresult=@mysql_query($typequery);
                                    $sub_query = mysql_fetch_array($lookupresult);
                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                    if($c==4) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                    if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                    if($c==7) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                    if($c==9) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                ?>
                     <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_invdetails["inv_TaskCode"])); ?></td>
                        <td>
                            <?php
                                    if($c==0) echo "$250";
                                    if($c==1) echo "$730";
                                    if($c==2) echo "$835";
                                    if($c==3) echo "$325";
                                    if($c==4) echo "$50";
                                    if($c==5) echo "$100";
                                    if($c==6) echo "$300";
                                    if($c==7) echo "$100";
                                    if($c==8) echo "$300";
                                    if($c==9) echo "$0";
                                    if($c==10) echo "$0";
                                    if($c==11) echo "$0";
                            ?>
                        </td>
                        <td><?php if($row_invdetails["inv_Rates"]!="") echo "$".$row_invdetails["inv_Rates"]; else echo $row_invdetails["inv_Rates"]; ?></td>
                        <td>
                            <?php
                                    if($c==0) echo "one off";
                                    if($c==1) echo "one off";
                                    if($c==2) echo "one off";
                                    if($c==3) echo "one off";
                                    if($c==4) echo "per hour";
                                    if($c==5) echo "per hour";
                                    if($c==6) echo "per year";
                                    if($c==7) echo "per month";
                                    if($c==8) echo "per year";
                                    if($c==9) echo "per year";
                                    if($c==10) echo "per year";
                                    if($c==11) echo "";
                            ?>
                        </td>
                     </tr>
                    <?php
                    $c++;
                 } ?>
                 <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                  <tr>
                        <?php
                        $cli_code=$_REQUEST['cli_code'];

                        $query = "SELECT i1.inv_Code,i2.inv_Notes,i2.inv_IndiaNotes FROM inv_qinvoice AS i1 LEFT OUTER JOIN inv_qinvoicedetails AS i2 ON (i1.inv_Code = i2.inv_QICode) where inv_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                        ?>
                        <td><div style="float:left; width:237px;"><b>Notes</b></div></td><td><div style="width:336px;"><?php echo $row_notes['inv_Notes']; ?></div> </td>
                 </tr>
                 <tr><td><div style="float:left; width:237px;"><b>India Notes</b></div></td><td><div style="width:336px;"><?php echo $row_notes['inv_IndiaNotes']; ?></div></td></tr>
                 <?php
             }

}
	$quotesheetContentlist = new quotesheetContent();
?>

