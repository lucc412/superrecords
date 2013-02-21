<?php
class salesnotesContentList extends Database
{
    // sales notes details content list
    function sndetailsContent()
    {
        global $commonUses;
        global $access_file_level_salesdetails;
        
        $cli_code=$_REQUEST['cli_code'];
        $recid=$_GET['recid'];
        $query = "SELECT * FROM snd_salesdetails where snd_ClientCode =".$cli_code;
        $result=@mysql_query($query);
        $row_inv = mysql_fetch_assoc($result);
        $snd_Code=@mysql_result( $result,0,'snd_Code') ;
        $details_query = "SELECT * FROM snd_salesdetails_details where snd_SNCode =".$snd_Code." order by snd_Code";
        $details_result=@mysql_query($details_query);
                if($_GET['a']=="edit")
                {
                       $this->showtableheader_snd($access_file_level_salesdetails);
                        if($access_file_level_salesdetails['stf_Add']=="Y" || $access_file_level_salesdetails['stf_Edit']=="Y" || $access_file_level_salesdetails['stf_Delete']=="Y")
                         {
                            if(mysql_num_rows($details_result)>0)
                            {
                        ?>
                                <form name="salesdetailsdetailedit" method="post" action="dbclass/salesnotes_db_class.php">
                                        <?php
                                        if($_GET['a']=="edit")
                                                {
                                                    if($access_file_level_salesdetails['stf_Edit']=="Y")
                                                    {
                                                        $this->showrow_snddetails($details_result,$snd_Code,$access_file_level_salesdetails,$cli_code,$recid);
                                                            $query = "SELECT i1.snd_Code,i2.snd_Notes,i2.snd_IndiaNotes FROM snd_salesdetails AS i1 LEFT OUTER JOIN snd_salesdetails_details AS i2 ON (i1.snd_Code = i2.snd_SNCode) where snd_ClientCode =".$cli_code;
                                                            $result=@mysql_query($query);
                                                            $row_notes = mysql_fetch_array($result);
                                                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                        ?>
                                                        <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                                                        <tr><td><div style="float:left; width:343px;"><b>Notes</b></div></td><td><div><textarea name="snd_Notes" rows="3" cols="43" ><?php echo $row_notes['snd_Notes']; ?></textarea> </div></td></tr>
                                                        <tr><td><div style="float:left; width:343px;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="snd_IndiaNotes" rows="3" cols="53" ><?php echo $row_notes['snd_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['snd_IndiaNotes']; ?> <input type="hidden" name="snd_IndiaNotes" value="<?php echo $row_notes['snd_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                            <tr>
                                                                <td colspan="13"  >
                                                                    <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                    <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                                    <input type="hidden" name="xsnd_Code" value="<?php echo $snd_Code;?>">
                                                                    <center><input type="submit" name="sndetails" id="invoiceupdate" value="Update" class="detailsbutton"></center>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                <?php
                                                  }
                                                  else if($access_file_level_salesdetails['stf_Edit']=="N")
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
                                            $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Sales Details%')";
                                            $tresult=@mysql_query($tquery);
                                            $tcount=mysql_num_rows($tresult);
                                                    if($tcount>0)
                                                    {
                                                            //Insert all tasks in details table for this client
                                                            while($trow=@mysql_fetch_array($tresult))
                                                            {
                                                              $sql = "insert into `snd_salesdetails_details` (`snd_SNCode`, `snd_TaskCode`) values (" .$snd_Code.", " .$trow['tsk_Code'].")";
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
                else
                {
                    $cli_code=$_REQUEST['cli_code'];
                    $recid=$_GET['recid'];
                    $query = "SELECT * FROM snd_salesdetails where snd_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_inv = mysql_fetch_assoc($result);
                    $snd_Code=@mysql_result( $result,0,'snd_Code') ;
                    $details_query = "SELECT * FROM snd_salesdetails_details where snd_SNCode =".$snd_Code." order by snd_Code";
                    $details_result=@mysql_query($details_query);
                     if($_GET['a']=="view")
                     {
                             if($access_file_level_salesdetails['stf_View']=="Y")
                             {
                                       $this->showtableheader_snd($access_file_level_salesdetails);
                                       $this->showrow_snddetails_view($details_result,$snd_Code);
                                        $query = "SELECT i1.snd_Code,i2.snd_Notes FROM snd_salesdetails AS i1 LEFT OUTER JOIN snd_salesdetails_details AS i2 ON (i1.snd_Code = i2.snd_SNCode) where snd_ClientCode =".$cli_code;
                                        $result=@mysql_query($query);
                                        $row_notes = mysql_fetch_array($result);
                                        ?>
                            <?php
                                       echo "</table>";
                                       $this->showrow_sndFooter($row_inv);
                            }
                            else if($access_file_level_salesdetails['stf_View']=="N")
                            {
                                  echo "You are not authorised to view a record.";
                            }
                   }
                }
            }
                // sales notes details edit
                function showrow_snddetails($details_result,$snd_Code,$access_file_level_salesdetails,$cli_code,$recid)
                {
                          global $commonUses;
                          
                          $count=mysql_num_rows($details_result);
                          $s=0;
                            while ($row_snddetails=mysql_fetch_array($details_result))
                            {
                                $tcode = $row_snddetails["snd_TaskCode"];
                                ?>
                                <input type="hidden" name="count" value="<?php echo $count;?>">
                                <input type="hidden" name="snd_Code[<?php echo $tcode; ?>]" value="<?php echo $row_snddetails["snd_Code"];?>">
                                <input type="hidden" name="snd_SNCode[<?php echo $tcode; ?>]" value="<?php echo $row_snddetails["snd_SNCode"];?>">
                                <tr>
                                    <?php
                                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["snd_TaskCode"];
                                                        $lookupresult=@mysql_query($typequery);
                                                        $sub_query = mysql_fetch_array($lookupresult);
                                                        if($s==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                        if($s==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                        if($s==11) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                    ?>
                                </tr>
                                <tr>
                                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snddetails["snd_TaskCode"])); ?></td>
                                        <td>
                                            <?php
                                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_snddetails["snd_TaskCode"];
                                                $typeresult=@mysql_query($typequery);
                                                $type_control = mysql_fetch_array($typeresult);
                                                if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                                    <input type="text" name="snd_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_snddetails["snd_TaskValue"])) ?>" size="30">
                                                <?php
                                                }
                                                if($type_control["tsk_TypeofControl"]=="2") {
                                                ?>
                                                    <select name="snd_TaskValue[<?php echo $tcode; ?>]">
                                                        <option value="">Select</option>
                                                                <?php
                                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_snddetails["snd_TaskCode"];
                                                                    $lookupresult=@mysql_query($typequery);
                                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                                  $val = $lp_row["tsk_Code"];
                                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                                    for($i = 0; $i < count($control); $i++){
                                                                    if($row_snddetails["snd_TaskValue"] == $control[$i]) { $selstr="selected"; } else { $selstr=""; }
                                                                 ?>
                                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                                <?php } } ?>
                                                    </select>
                                                <?php
                                                }
                                                if($type_control["tsk_TypeofControl"]=="3") {
                                                        ?>
                                                        <?php
                                                            if($row_snddetails["snd_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                                        ?>
                                                    <input type="checkbox" name="snd_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                                    <?php
                                                    if($row_snddetails["snd_TaskValue"]=="Y")
                                                    {
                                                        $taskCont .= "<script>
                                                                enablePayroll(true,$tcode,$c);
                                                                </script>";

                                                    }
                                                }
                                                if($type_control["tsk_TypeofControl"]=="4") {
                                                    ?>
                                                    <textarea cols="30" rows="2" name="snd_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_snddetails["snd_TaskValue"])) ?></textarea>
                                                    <?php } ?>
                                </tr>
                                <?php
                                $s++;
                                $consolidated_ids .= $row_snddetails["snd_TaskCode"].",";
                            }
                            $consolidated_ids = substr($consolidated_ids,0,-1);
                            ?>
                            <input type="hidden" name="snd_TaskCode" value="<?php echo $consolidated_ids;?>">
                            <?php
                            echo $taskCont;
               }
               // sales notes details footer
                 function showrow_sndFooter( $row_inv)
                {
                    echo "<br><span class='footer'>Created by: ".$row_inv['snd_Createdby']." | ". "Created on: ".$row_inv['snd_Createdon']." | ". "Lastmodified by: ".$row_inv['snd_Lastmodifiedby']." | ". "Lastmodified on: ".$row_inv['snd_Lastmodifiedon']."</span>";
                }
                // sales notes details header
                function showtableheader_snd($access_file_level_salesdetails)
                {
                ?>
                    <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="70%">
                                        <tr class="fieldheader">
                                            <th class="fieldheader">Task Description</th>
                                            <th class="fieldheader"></th>
                                        </tr>
                <?php
                }
                // sales notes view
                 function showrow_snddetails_view($details_result,$snd_Code)
                  {
                      global $commonUses;
                        $c=0;
                         while ($row_snddetails=mysql_fetch_array($details_result))
                        {
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["snd_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==11) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                            ?>
                            <tr>
                                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snddetails["snd_TaskCode"])); ?></td>
                                <td><?php if($row_snddetails["snd_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_snddetails["snd_TaskValue"]))?></td>
                            </tr>
                            <?php
                            $c++;
                        }
                        ?>
                         <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                          <tr>
                                <?php
                                $cli_code=$_REQUEST['cli_code'];
                                $query = "SELECT i1.snd_Code,i2.snd_Notes,i2.snd_IndiaNotes FROM snd_salesdetails AS i1 LEFT OUTER JOIN snd_salesdetails_details AS i2 ON (i1.snd_Code = i2.snd_SNCode) where snd_ClientCode =".$cli_code;
                                $result=@mysql_query($query);
                                $row_notes = mysql_fetch_array($result);
                                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                ?>
                               <td><div style="float:left; width:382px;"><b>Notes</b></div></td><td><div style="width:295px;"><?php echo $row_notes['snd_Notes']; ?></div> </td>
                         </tr>
                         <tr><td><div style="float:left; width:382px;"><b>India Notes</b></div></td><td><div style="width:295px;"><?php echo $row_notes['snd_IndiaNotes']; ?></div></td></tr>
                         <?php
                  }
                  // sales notes status content
                  function snstatusContent()
                  {
                        global $commonUses;
                        global $access_file_level_salesstatus;

                        $cli_code=$_REQUEST['cli_code'];
                        $recid=$_GET['recid'];
                        $query = "SELECT * FROM sns_salesstatus where sns_ClientCode =".$cli_code;
                        $result=mysql_query($query);
                        $row_inv = mysql_fetch_assoc($result);
                        $sns_Code=mysql_result( $result,0,'sns_Code') ;
                        $details_query = "SELECT * FROM sns_salesstatusdetails where sns_SNCode =".$sns_Code." order by sns_Code";
                        $details_result=mysql_query($details_query);
                        if($_GET['a']=="edit")
                        {
                                $this->showtableheader_sns($access_file_level_salesstatus);
                                 if($access_file_level_salesstatus['stf_Add']=="Y" || $access_file_level_salesstatus['stf_Edit']=="Y" || $access_file_level_salesstatus['stf_Delete']=="Y")
                                 {
                                        if(mysql_num_rows($details_result)>0)
                                        {
                                        ?>
                                            <form name="salesstatusdetailedit" method="post" action="dbclass/salesnotes_db_class.php">
                                                <?php
                                                if($_GET['a']=="edit")
                                                {
                                                        if($access_file_level_salesstatus['stf_Edit']=="Y")
                                                       {
                                                        $this->showrow_snstaus($details_result,$sns_Code,$access_file_level_salesstatus,$cli_code,$recid);
                                                                $query = "SELECT i1.sns_Code,i2.sns_Notes,i2.sns_IndiaNotes FROM sns_salesstatus AS i1 LEFT OUTER JOIN sns_salesstatusdetails AS i2 ON (i1.sns_Code = i2.sns_SNCode) where sns_ClientCode =".$cli_code;
                                                                $result=mysql_query($query);
                                                                $row_notes = mysql_fetch_array($result);
                                                                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                            ?>
                                                                <tr><td><div style="float:left; width:347px;"><b>Notes</b></div></td><td><div style="width:351px;"><textarea name="sns_Notes" rows="3" cols="53" ><?php echo $row_notes['sns_Notes']; ?></textarea> </div></td></tr>
                                                                <tr><td><div style="float:left; width:347px;"><b>India Notes</b></div></td><td><div style="width:351px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="sns_IndiaNotes" rows="3" cols="53" ><?php echo $row_notes['sns_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['sns_IndiaNotes']; ?> <input type="hidden" name="sns_IndiaNotes" value="<?php echo $row_notes['sns_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                                    <tr>
                                                                    <td colspan="13"  >
                                                                        <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                        <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                                        <input type="hidden" name="xsns_Code" value="<?php echo $sns_Code;?>">
                                                                        <center><input type="submit" name="snstatus" id="invoiceupdate" value="Update" class="detailsbutton"></center>
                                                                    </td>
                                                                    </tr>
                                                            </table>
                                                     <?php
                                                          }
                                                          else if($access_file_level_salesstatus['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Sales Status%')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                          $sql = "insert into `sns_salesstatusdetails` (`sns_SNCode`, `sns_TaskCode`) values (" .$sns_Code.", " .$trow['tsk_Code'].")";
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
                                  if($access_file_level_salesstatus['stf_View']=="Y")
                                  {
                                                   $this->showtableheader_sns($access_file_level_salesstatus);
                                                   $this->showrow_snstatus_view($details_result,$sns_Code);
                                                   echo "</table>";
                                                   $this->showrow_snsFooter($row_inv);
                                  }
                                  else if($access_file_level_salesstatus['stf_View']=="N")
                                     {
                                                        echo "You are not authorised to view a record.";
                                     }
                                }
                  }
                  // sales nots status edit
                    function showrow_snstaus($details_result,$sns_Code,$access_file_level_salesstatus,$cli_code,$recid)
                      {
                          global $commonUses;
                              $count=mysql_num_rows($details_result);
                    $c=0;
                    while ($row_snsdetails=mysql_fetch_array($details_result))
                    {
                     $tcode = $row_snsdetails["sns_TaskCode"];
                    ?>
                    <input type="hidden" name="count" value="<?php echo $count;?>">
                    <input type="hidden" name="sns_Code[<?php echo $tcode; ?>]" value="<?php echo $row_snsdetails["sns_Code"];?>">
                    <input type="hidden" name="sns_SNCode[<?php echo $tcode; ?>]" value="<?php echo $row_snsdetails["sns_SNCode"];?>">
                    <tr>
                    <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snsdetails["sns_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==2) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==3) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==4) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                    ?>
                    </tr>
                    <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snsdetails["sns_TaskCode"])); ?></td>
                    <td>
                        <?php
                    $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_snsdetails["sns_TaskCode"];
                    $typeresult=@mysql_query($typequery);
                    $type_control = mysql_fetch_array($typeresult);

                        if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                        <input type="text" name="sns_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_snsdetails["sns_TaskValue"])) ?>" size="30">
                        <?php
                        }
                    if($type_control["tsk_TypeofControl"]=="2") {
                    ?>
                        <select name="sns_TaskValue[<?php echo $tcode; ?>]">
                            <option value="">Select</option>
                                    <?php
                                        $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_snsdetails["sns_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                      while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                      $val = $lp_row["tsk_Code"];
                                      $control = explode(",",$lp_row["tsk_LookupValues"]);
                                        for($i = 0; $i < count($control); $i++){
                                        if($row_snsdetails["sns_TaskValue"] == $control[$i]) { $selstr="selected"; } else { $selstr=""; }
                                     ?>
                                        <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                    <?php } } ?>
                        </select>
                            <?php
                    }
                    if($type_control["tsk_TypeofControl"]=="3") {
                            ?>
                            <?php
                                if($row_snsdetails["sns_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                            ?>
                        <input type="checkbox" name="sns_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                        <?php
                        if($row_snsdetails["sns_TaskValue"]=="Y")
                        {
                            $taskCont .= "<script>
                                    enablePayroll(true,$tcode,$c);
                                    </script>";

                        }
                    }
                    if($type_control["tsk_TypeofControl"]=="4") {
                        ?>
                        <textarea cols="30" rows="2" name="sns_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_snsdetails["sns_TaskValue"])) ?></textarea>
                        <?php } ?>
                    </tr>
                    <?php
                    $c++;
                    $consolidated_ids .= $row_snsdetails["sns_TaskCode"].",";
                    }
                    $consolidated_ids = substr($consolidated_ids,0,-1);

                    ?>
                    <input type="hidden" name="sns_TaskCode" value="<?php echo $consolidated_ids;?>">

                     <?php
                    echo $taskCont;
                     }
                     // sales notes status footer
                     function showrow_snsFooter( $row_inv)
                    {
                        echo "<br><span class='footer'>Created by: ".$row_inv['sns_Createdby']." | ". "Created on: ".$row_inv['sns_Createdon']." | ". "Lastmodified by: ".$row_inv['sns_Lastmodifiedby']." | ". "Lastmodified on: ".$row_inv['sns_Lastmodifiedon']."</span>";
                    }
                    // slaes notes status header
                    function showtableheader_sns($access_file_level_salesstatus)
                    {
                    ?>
                        <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="70%">
                                            <tr class="fieldheader">
                                                <th class="fieldheader">Task Description</th>
                                                <th class="fieldheader"></th>
                                            </tr>
                    <?php
                    }
                    // sales notes status view
                     function showrow_snstatus_view($details_result,$sns_Code)
                      {
                                  global $commonUses;
                            $c=0;
                             while ($row_snsdetails=mysql_fetch_array($details_result))
                            {
                            ?>
                            <?php
                                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snsdetails["sns_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                                $sub_query = mysql_fetch_array($lookupresult);
                                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==2) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==3) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==4) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                            ?>
                             <tr>
                            <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snsdetails["sns_TaskCode"])); ?></td>
                            <td><?php if($row_snsdetails["sns_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_snsdetails["sns_TaskValue"]))?></td>
                             </tr>
                            <?php
                            $c++;
                            } ?>
                             <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                              <tr>
                                                <?php
                            $cli_code=$_REQUEST['cli_code'];

                            $query = "SELECT i1.sns_Code,i2.sns_Notes,i2.sns_IndiaNotes FROM sns_salesstatus AS i1 LEFT OUTER JOIN sns_salesstatusdetails AS i2 ON (i1.sns_Code = i2.sns_SNCode) where sns_ClientCode =".$cli_code;
                            $result=@mysql_query($query);
                            $row_notes = mysql_fetch_array($result);
                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                ?>
                             <td><div style="float:left; width:392px;"><b>Notes</b></div></td><td><div style="width:286px;"><?php echo $row_notes['sns_Notes']; ?></div> </td>
                             </tr>
                             <tr><td><div style="float:left; width:392px;"><b>India Notes</b></div></td><td><div style="width:286px;"><?php echo $row_notes['sns_IndiaNotes']; ?></div></td></tr>
                             <?php
                      }
                      // sales notes Tasks content
                      function sntasksContent()
                      {
                            global $commonUses;
                            global $access_file_level_salestasks;

                            $cli_code=$_REQUEST['cli_code'];
                            $recid=$_GET['recid'];
                            $query = "SELECT * FROM snt_salestasks where snt_ClientCode =".$cli_code;
                            $result=@mysql_query($query);
                            $row_inv = mysql_fetch_assoc($result);
                            $snt_Code=@mysql_result( $result,0,'snt_Code') ;
                            $details_query = "SELECT * FROM snt_salestasksdetails where snt_SNCode =".$snt_Code." order by snt_Code";
                            $details_result=@mysql_query($details_query);
                                    if($_GET['a']=="edit")
                                    {
                                                    $this->showtableheader_snt($access_file_level_salestasks);

                                     if($access_file_level_salestasks['stf_Add']=="Y" || $access_file_level_salestasks['stf_Edit']=="Y" || $access_file_level_salestasks['stf_Delete']=="Y")
                                              {
                                              if(mysql_num_rows($details_result)>0)
                                            {
                                            ?>
                            <form name="salestasksdetailedit" method="post" action="dbclass/salesnotes_db_class.php">
                                             <?php
                                    if($_GET['a']=="edit")
                                            {
                                                    if($access_file_level_salestasks['stf_Edit']=="Y")
                                                {
                                            $this->showrow_sntasks($details_result,$snt_Code,$access_file_level_salestasks,$cli_code,$recid);
                                                ?>
                                                <?php
                                                    $query = "SELECT i1.snt_Code,i2.snt_Notes,i2.snt_IndiaNotes FROM snt_salestasks AS i1 LEFT OUTER JOIN snt_salestasksdetails AS i2 ON (i1.snt_Code = i2.snt_SNCode) where snt_ClientCode =".$cli_code;
                                                    $result=@mysql_query($query);
                                                    $row_notes = mysql_fetch_array($result);
                                                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                ?>
                                                <tr><td><div style="float:left; width:334px;"><b>Notes</b></div></td><td><div style="width:362px;"><textarea name="snt_Notes" rows="3" cols="53" ><?php echo $row_notes['snt_Notes']; ?></textarea> </div></td></tr>
                                                <tr><td><div style="float:left; width:334px;"><b>India Notes</b></div></td><td><div style="width:362px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="snt_IndiaNotes" rows="3" cols="53" ><?php echo $row_notes['snt_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['snt_IndiaNotes']; ?> <input type="hidden" name="snt_IndiaNotes" value="<?php echo $row_notes['snt_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                    <tr>
                                                    <td colspan="13"  >
                                                    <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                    <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                <input type="hidden" name="xsnt_Code" value="<?php echo $snt_Code;?>">
                                                <center><input type="submit" name="sntasks" id="invoiceupdate" value="Update" class="detailsbutton"></center>
                                                    </td>
                                                    </tr>
                                                </table>
                                         <?php
                                              }
                                              else if($access_file_level_salestasks['stf_Edit']=="N")
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
                                                            $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Sales Tasks%')";
                                                            $tresult=@mysql_query($tquery);
                                                            $tcount=mysql_num_rows($tresult);
                                                                    if($tcount>0)
                                                                    {
                                                                            //Insert all tasks in details table for this client
                                                                            while($trow=@mysql_fetch_array($tresult))
                                                                            {
                                                                              $sql = "insert into `snt_salestasksdetails` (`snt_SNCode`, `snt_TaskCode`) values (" .$snt_Code.", " .$trow['tsk_Code'].")";
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
                                             if($access_file_level_salestasks['stf_View']=="Y")
                                                      {
                                                       $this->showtableheader_snt($access_file_level_salestasks);
                                                       $this->showrow_sntasks_view($details_result,$snt_Code);
                                                       echo "</table>";
                                                       $this->showrow_sntFooter($row_inv);
                                                      }
                                                      else if($access_file_level_salestasks['stf_View']=="N")
                                                      {
                                                            echo "You are not authorised to view a record.";
                                                      }

                                    }
                     }
                     // sales notes tasks edit
                        function showrow_sntasks($details_result,$snt_Code,$access_file_level_salestasks,$cli_code,$recid)
                        {
                              global $commonUses;
                                  $count=mysql_num_rows($details_result);
                        $c=0;
                        while ($row_sntdetails=mysql_fetch_array($details_result))
                        {
                        $tcode = $row_sntdetails["snt_TaskCode"];
                        //$qcode = $row_sntdetails["inv_QICode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="snt_Code[<?php echo $tcode; ?>]" value="<?php echo $row_sntdetails["snt_Code"];?>">
                        <input type="hidden" name="snt_SNCode[<?php echo $tcode; ?>]" value="<?php echo $row_sntdetails["snt_SNCode"];?>">
                        <tr>
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_sntdetails["snt_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==10) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==14) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==17) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                        </tr>
                        <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_sntdetails["snt_TaskCode"])); ?></td>
                        <td>
                            <?php
                        $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_sntdetails["snt_TaskCode"];
                        $typeresult=@mysql_query($typequery);
                        $type_control = mysql_fetch_array($typeresult);
                            if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                            <input type="text" name="snt_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_sntdetails["snt_TaskValue"])) ?>" size="30">
                            <?php
                            }
                        if($type_control["tsk_TypeofControl"]=="2") {
                        ?>
                            <select name="snt_TaskValue[<?php echo $tcode; ?>]">
                                <option value="">Select</option>
                                        <?php
                                            $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_sntdetails["snt_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                          while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                          $val = $lp_row["tsk_Code"];
                                          $control = explode(",",$lp_row["tsk_LookupValues"]);
                                            for($i = 0; $i < count($control); $i++){
                                            if($row_sntdetails["snt_TaskValue"] == $control[$i]) { $selstr="selected"; } else { $selstr=""; }
                                         ?>
                                            <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                        <?php } } ?>
                            </select>
                                <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_sntdetails["snt_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="snt_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                            <?php
                            if($row_sntdetails["snt_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enablePayroll(true,$tcode,$c);
                                        </script>";

                            }
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                            ?>
                            <textarea cols="30" rows="2" name="snt_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_sntdetails["snt_TaskValue"])) ?></textarea>
                            <?php } ?>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_sntdetails["snt_TaskCode"].",";
                        }
                        $consolidated_ids = substr($consolidated_ids,0,-1);

                        ?>
                        <input type="hidden" name="snt_TaskCode" value="<?php echo $consolidated_ids;?>">

                         <?php
                        echo $taskCont;
                         }
                         // sales notes tasks footer
                         function showrow_sntFooter( $row_inv)
                         {
                        echo "<br><span class='footer'>Created by: ".$row_inv['snt_Createdby']." | ". "Created on: ".$row_inv['snt_Createdon']." | ". "Lastmodified by: ".$row_inv['snt_Lastmodifiedby']." | ". "Lastmodified on: ".$row_inv['snt_Lastmodifiedon']."</span>";
                        }
                        // sales notes tasks header
                        function showtableheader_snt($access_file_level_salestasks)
                        {
                        ?>
                        <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="70%">
                                                <tr class="fieldheader">
                                                    <th class="fieldheader">Task Description</th>
                                                    <th class="fieldheader"></th>
                                                </tr>
                        <?php
                        }
                        // sales notes tasks view
                         function showrow_sntasks_view($details_result,$snt_Code)
                          {
                              global $commonUses;
                        $c=0;
                         while ($row_sntdetails=mysql_fetch_array($details_result))
                        {
                        ?>
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_sntdetails["snt_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==10) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==14) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==17) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                         <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_sntdetails["snt_TaskCode"])); ?></td>
                        <td><?php if($row_sntdetails["snt_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_sntdetails["snt_TaskValue"]))?></td>
                         </tr>
                        <?php
                        $c++;
                        } ?>
                         <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                          <tr>
                                            <?php
                        $cli_code=$_REQUEST['cli_code'];

                        $query = "SELECT i1.snt_Code,i2.snt_Notes,i2.snt_IndiaNotes FROM snt_salestasks AS i1 LEFT OUTER JOIN snt_salestasksdetails AS i2 ON (i1.snt_Code = i2.snt_SNCode) where snt_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                            ?>
                              <td><div style="float:left; width:384px;"><b>Notes</b></div></td><td><div style="width:285px;"><?php echo $row_notes['snt_Notes']; ?></div> </td>
                         </tr>
                         <tr><td><div style="float:left; width:384px;"><b>India Notes</b></div></td><td><div style="width:285px;"><?php echo $row_notes['snt_IndiaNotes']; ?></div></td></tr>
                         <?php
                         }
                         // salesnotes Notes content
                         function snnotesContent()
                         {
                                global $commonUses;
                                global $access_file_level_salesnotes;
                                
                                $cli_code=$_REQUEST['cli_code'];
                                $recid=$_GET['recid'];
                                $query = "SELECT * FROM snn_salesnotes where snn_ClientCode =".$cli_code;
                                $result=@mysql_query($query);
                                $row_inv = mysql_fetch_assoc($result);
                                $snn_Code=@mysql_result( $result,0,'snn_Code') ;
                                $details_query = "SELECT * FROM snn_salesnotesdetails where snn_SNCode =".$snn_Code." order by snn_Code";
                                $details_result=@mysql_query($details_query);
                                        if($_GET['a']=="edit")
                                        {
                                                        $this->showtableheader_snn($access_file_level_salesnotes);

                                         if($access_file_level_salesnotes['stf_Add']=="Y" || $access_file_level_salesnotes['stf_Edit']=="Y" || $access_file_level_salesnotes['stf_Delete']=="Y")
                                                  {
                                                  if(mysql_num_rows($details_result)>0)
                                                {
                                                ?>
                                <form name="salesnotesdetailedit" method="post" action="dbclass/salesnotes_db_class.php">
                                                 <?php
                                        if($_GET['a']=="edit")
                                        {
                                                        if($access_file_level_salesnotes['stf_Edit']=="Y")
                                                    {
                                                $this->showrow_snNotes($details_result,$snn_Code,$access_file_level_salesnotes,$cli_code,$recid);
                                                    ?>
                                                    <?php
                                                        $query = "SELECT i1.snn_Code,i2.snn_Notes,i2.snn_IndiaNotes FROM snn_salesnotes AS i1 LEFT OUTER JOIN snn_salesnotesdetails AS i2 ON (i1.snn_Code = i2.snn_SNCode) where snn_ClientCode =".$cli_code;
                                                        $result=@mysql_query($query);
                                                        $row_notes = mysql_fetch_array($result);
                                                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                    ?>
                                                    <tr><td><div style="float:left; width:308px;"><b>Notes</b></div></td><td><div style="width:388px;"><textarea name="snn_Notes" rows="3" cols="53" ><?php echo $row_notes['snn_Notes']; ?></textarea> </div></td></tr>
                                                    <tr><td><div style="float:left; width:308px;"><b>India Notes</b></div></td><td><div style="width:388px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="snn_IndiaNotes" rows="3" cols="53" ><?php echo $row_notes['snn_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['snn_IndiaNotes']; ?> <input type="hidden" name="snn_IndiaNotes" value="<?php echo $row_notes['snn_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                        <tr>
                                                        <td colspan="13"  >
                                                        <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                                <input type="hidden" name="recid" value="<?php echo $recid;?>">

                                                    <input type="hidden" name="xsnn_Code" value="<?php echo $snn_Code;?>">

                                                    <center><input type="submit" name="snnotes" id="invoiceupdate" value="Update" class="detailsbutton"></center>
                                                        </td>
                                                        </tr>
                                                    </table>
                                             <?php
                                                  }
                                                  else if($access_file_level_salesnotes['stf_Edit']=="N")
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
                                                                $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Sales Notes%')";
                                                                $tresult=@mysql_query($tquery);
                                                                $tcount=mysql_num_rows($tresult);
                                                                        if($tcount>0)
                                                                        {
                                                                                //Insert all tasks in details table for this client
                                                                                while($trow=@mysql_fetch_array($tresult))
                                                                                {
                                                                                  $sql = "insert into `snn_salesnotesdetails` (`snn_SNCode`, `snn_TaskCode`) values (" .$snn_Code.", " .$trow['tsk_Code'].")";
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
                                         if($access_file_level_salesnotes['stf_View']=="Y")
                                                  {
                                                   $this->showtableheader_snn($access_file_level_salesnotes);
                                                   $this->showrow_snNotes_view($details_result,$snn_Code);
                                                   echo "</table>";
                                                   $this->showrow_snnFooter($row_inv);
                                                  }
                                                  else if($access_file_level_salesnotes['stf_View']=="N")
                                                  {
                                                        echo "You are not authorised to view a record.";
                                                  }
                                }
                         }
                         // sales notes Notes edit
                        function showrow_snNotes($details_result,$snn_Code,$access_file_level_salesnotes,$cli_code,$recid)
                        {
                              global $commonUses;
                                  $count=mysql_num_rows($details_result);
                        $c=0;
                        while ($row_snddetails=mysql_fetch_array($details_result))
                        {
                        $tcode = $row_snddetails["snn_TaskCode"];
                        //$qcode = $row_snddetails["inv_QICode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="snn_Code[<?php echo $tcode; ?>]" value="<?php echo $row_snddetails["snn_Code"];?>">
                        <input type="hidden" name="snn_SNCode[<?php echo $tcode; ?>]" value="<?php echo $row_snddetails["snn_SNCode"];?>">
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["snn_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>

                        <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snddetails["snn_TaskCode"])); ?></td>
                        <td>
                            <?php
                        $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_snddetails["snn_TaskCode"];
                        $typeresult=@mysql_query($typequery);
                        $type_control = mysql_fetch_array($typeresult);

                            if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                            <input type="text" name="snn_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_snddetails["snn_TaskValue"])) ?>" size="30">
                            <?php
                            }
                        if($type_control["tsk_TypeofControl"]=="2") {
                        ?>
                            <select name="snn_TaskValue[<?php echo $tcode; ?>]">
                                <option value="">Select</option>
                                        <?php
                                            $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_snddetails["snn_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                          while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                          $val = $lp_row["tsk_Code"];
                                          $control = explode(",",$lp_row["tsk_LookupValues"]);
                                            for($i = 0; $i < count($control); $i++){
                                            if($row_snddetails["snn_TaskValue"] == $control[$i]) { $selstr="selected"; } else { $selstr=""; }
                                         ?>
                                            <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                        <?php } } ?>
                            </select>
                                <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_snddetails["snn_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="snn_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                            <?php
                            if($row_snddetails["snn_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enablePayroll(true,$tcode,$c);
                                        </script>";

                            }
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                            ?>
                            <textarea cols="30" rows="2" name="snn_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_snddetails["snn_TaskValue"])) ?></textarea>
                            <?php } ?>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_snddetails["snn_TaskCode"].",";
                        }
                        $consolidated_ids = substr($consolidated_ids,0,-1);

                        ?>
                        <input type="hidden" name="snn_TaskCode" value="<?php echo $consolidated_ids;?>">

                         <?php
                        echo $taskCont;
                         }
                         // salesnotes Notes footer
                         function showrow_snnFooter( $row_inv)
                        {
                            echo "<br><span class='footer'>Created by: ".$row_inv['snn_Createdby']." | ". "Created on: ".$row_inv['snn_Createdon']." | ". "Lastmodified by: ".$row_inv['snn_Lastmodifiedby']." | ". "Lastmodified on: ".$row_inv['snn_Lastmodifiedon']."</span>";
                        }
                        // salesnotes Notes header
                          function showtableheader_snn($access_file_level_salesnotes)
                        {
                        ?>
                        <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="70%">
                                                <tr class="fieldheader">
                                                    <th class="fieldheader">Task Description</th>
                                                    <th class="fieldheader"></th>
                                                </tr>
                        <?php
                        }
                        // salesnotes Notes view
                         function showrow_snNotes_view($details_result,$snn_Code)
                          {
                              global $commonUses;
                        $c=0;
                         while ($row_snddetails=mysql_fetch_array($details_result))
                        {
                        ?>
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["snn_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                         <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snddetails["snn_TaskCode"])); ?></td>
                        <td><?php if($row_snddetails["snn_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_snddetails["snn_TaskValue"]))?></td>
                         </tr>
                        <?php
                        $c++;
                        } ?>
                         <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                          <tr>
                                            <?php
                        $cli_code=$_REQUEST['cli_code'];

                        $query = "SELECT i1.snn_Code,i2.snn_Notes,i2.snn_IndiaNotes FROM snn_salesnotes AS i1 LEFT OUTER JOIN snn_salesnotesdetails AS i2 ON (i1.snn_Code = i2.snn_SNCode) where snn_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                            ?>

                              <td><div style="float:left; width:344px;"><b>Notes</b></div></td><td><div style="width:333px;"><?php echo $row_notes['snn_Notes']; ?></div> </td>
                         </tr>
                         <tr><td><div style="float:left; width:344px;"><b>India Notes</b></div></td><td><div style="width:333px;"><?php echo $row_notes['snn_IndiaNotes']; ?></div></td></tr>
                         <?php }

}
	$salesnotesContent = new salesnotesContentList();
?>

