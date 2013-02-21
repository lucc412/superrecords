<script type="text/javascript" src="<?php echo $javaScript; ?>hostingText.js"></script>
<?php
class hostingContentList extends Database
{
    // hosting content
    function hostingContent()
    {
            global $commonUses;
            global $access_file_level_host;
            
            $cli_code=$_REQUEST['cli_code'];
            $recid=$_GET['recid'];
            $query = "SELECT * FROM mhg_qmyobhosting where mhg_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_mhg = mysql_fetch_assoc($result);
            $mhg_Code=@mysql_result( $result,0,'mhg_Code') ;
            $details_query = "SELECT * FROM mhg_qmyobhostingdetails where mhg_MYOBHCode =".$mhg_Code." order by mhg_Code";
            $details_result=@mysql_query($details_query);
            if($_GET['a']=="edit")
            {
                     $this->showtableheader_host($access_file_level_host);
                     if($access_file_level_host['stf_Add']=="Y" || $access_file_level_host['stf_Edit']=="Y" || $access_file_level_host['stf_Delete']=="Y")
                     {
                              if(mysql_num_rows($details_result)>0)
                              {
                            ?>
                                <form name="hostingdetailedit" method="post" action="dbclass/hosting_db_class.php">
                                       <?php
                                       if ($_GET['a']=="edit")
                                       {
                                            if($access_file_level_host['stf_Edit']=="Y")
                                            {
                                                $this->showrow_mhgdetails($details_result,$mhg_Code,$access_file_level_host,$cli_code,$recid) ;
                                            ?>
                                            <?php
                                                    $query = "SELECT i1.mhg_Code,i2.mhg_Notes,i2.mhg_IndiaNotes FROM mhg_qmyobhosting AS i1 LEFT OUTER JOIN mhg_qmyobhostingdetails AS i2 ON (i1.mhg_Code = i2.mhg_MYOBHCode) where mhg_ClientCode =".$cli_code;
                                                    $result=@mysql_query($query);
                                                    $row_notes = mysql_fetch_array($result);
                                                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                             ?>
                                                    <tr><td><div style="float:left; width:236px;"><b>Notes</b></div></td><td><div style="width:377px;"><textarea name="mhg_Notes" rows="3" cols="53"><?php echo $row_notes['mhg_Notes']; ?></textarea> </div></td></tr>
                                                    <tr><td><div style="float:left; width:236px;"><b>India Notes</b></div></td><td><div style="width:377px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="mhg_IndiaNotes" rows="3" cols="53"><?php echo $row_notes['mhg_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['mhg_IndiaNotes']; ?> <input type="hidden" name="mhg_IndiaNotes" value="<?php echo $row_notes['mhg_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                    <tr><td colspan="13"  >
                                                        <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                        <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                        <input type="hidden" name="xmhg_Code" value="<?php echo $mhg_Code;?>">
                                                        <center><input type="submit" name="hostupdate" value="Update" class="detailsbutton"></center>
                                                        </td>
                                                    </tr>
                                                </table>
                                          <?php
                                          }
                                          else if($access_file_level_host['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Hosting%')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                          $sql = "insert into `mhg_qmyobhostingdetails` (`mhg_MYOBHCode`, `mhg_TaskCode`) values (" .$mhg_Code.", " .$trow['tsk_Code'].")";
                                                                          @mysql_query($sql);
                                                                         // echo "<META HTTP-EQUIV=Refresh CONTENT='0'> ";
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
                     if($access_file_level_host['stf_View']=="Y")
                     {
                               $this->showtableheader_host($access_file_level_host);
                               $this->showrow_mhgdetails_view($details_result,$mhg_Code);
                               echo "</table>";
                               $this->showrow_mhgFooter($row_mhg);
                     }
                     else if($access_file_level_host['stf_View']=="N")
                     {
                            echo "You are not authorised to view a record.";
                     }
            }
    }
    // hosting edit
    function showrow_mhgdetails($details_result,$mhg_Code,$access_file_level_host,$cli_code,$recid)
    {
              global $commonUses;
              $count=mysql_num_rows($details_result);
              $c=0;
                while ($row_mhgdetails=mysql_fetch_array($details_result))
                {
                        $tcode = $row_mhgdetails["mhg_TaskCode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="mhg_Code[<?php echo $tcode; ?>]" value="<?php echo $row_mhgdetails["mhg_Code"];?>">
                        <input type="hidden" name="mhg_MYOBHCode[<?php echo $tcode; ?>]" value="<?php echo $row_mhgdetails["mhg_MYOBHCode"];?>">
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_mhgdetails["mhg_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                        <tr id="hostingTab_<?php echo $tcode; ?>">
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_mhgdetails["mhg_TaskCode"])); ?></td>
                            <?php
                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_mhgdetails["mhg_TaskCode"];
                                $typeresult=@mysql_query($typequery);
                                $type_control = mysql_fetch_array($typeresult);
                                if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                    <td> <input type="text" name="mhg_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_mhgdetails["mhg_TaskValue"])) ?>" size="30" disabled></td>
                                <?php
                                }
                                else if($type_control["tsk_TypeofControl"]=="2") {
                                ?>
                                    <td>  <select name="mhg_TaskValue[<?php echo $tcode; ?>]" disabled>
                                            <option value="">Select</option>
                                            <?php
                                                $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_mhgdetails["mhg_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                              while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                              $val = $lp_row["tsk_Code"];
                                              $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                for($i = 0; $i < count($control); $i++){
                                              if($row_mhgdetails["mhg_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                             ?>
                                              <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                        <?php } } ?>
                                            </select>
                                    </td>
                                <?php
                                }
                                else if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_mhgdetails["mhg_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                                        <td><input type="checkbox" name="mhg_TaskValue[<?php echo $tcode; ?>]" id="mhg_TaskVal[<?php echo $c; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableHost(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" disabled></td>
                                    <?php
                                    if($row_mhgdetails["mhg_TaskValue"]=="Y")
                                    {
                                            $taskCont .= "<script>
                                            enableHost(true,$tcode,$c);
                                            </script>";
                                    }
                                }
                                else if($type_control["tsk_TypeofControl"]=="4") {
                                    ?>
                                        <td> <textarea cols="30" rows="2" name="mhg_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" disabled><?php echo str_replace('"', '&quot;', trim($row_mhgdetails["mhg_TaskValue"])) ?></textarea></td>
                                    <?php }
                                else if($type_control["tsk_TypeofControl"]=="5") {
                                    ?>
                                        <td> </td>
                                    <?php }
                                else if($type_control["tsk_TypeofControl"]=="6") {
                                    ?>
                                        <td><input type="text" name="mhg_TaskValue[<?php echo $tcode; ?>]" id="myob_<?php echo $tcode; ?>" value="<?php echo str_replace('"', '&quot;', trim($row_mhgdetails["mhg_TaskValue"])) ?>" size="30" style="display:none;"> </td>
                                    <?php }
                                else if($type_control["tsk_TypeofControl"]=="7") {
                                    ?>
                                        <td><textarea cols="30" rows="2" name="mhg_TaskValue[<?php echo $tcode; ?>]" id="myobNotes_<?php echo $tcode; ?>" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple; display:none;" disabled><?php echo str_replace('"', '&quot;', trim($row_mhgdetails["mhg_TaskValue"])) ?></textarea> </td>
                                    <?php }
                                else if($type_control["tsk_TypeofControl"]=="8") {
                                        ?>
                                        <?php
                                            if($row_mhgdetails["mhg_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>
                                        <td><input type="checkbox" name="mhg_TaskValue[<?php echo $tcode; ?>]" id="mhg_TaskVal[<?php echo $c; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableHost(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)"></td>
                                    <?php
                                    if($row_mhgdetails["mhg_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enableHost(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                         ?>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_mhgdetails["mhg_TaskCode"].",";
                }
                $consolidated_ids = substr($consolidated_ids,0,-1);
                ?>
                <input type="hidden" name="mhg_TaskCode" value="<?php echo $consolidated_ids;?>">
                 <?php
                 echo $taskCont;
     }
     // hosting footer
     function showrow_mhgFooter( $row_mhg)
     {
            echo "<br><span class='footer'>Created by: ".$row_mhg['mhg_Createdby']." | ". "Created on: ".$row_mhg['mhg_Createdon']." | ". "Lastmodified by: ".$row_mhg['mhg_Lastmodifiedby']." | ". "Lastmodified on: ".$row_mhg['mhg_Lastmodifiedon']."</span>";
     }
     // hosting header
    function showtableheader_host($access_file_level_host)
    {
    ?>
            <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5"  width="460px" >
                    <tr class="fieldheader">
                         <th class="fieldheader" style="width:100px ">TASK LIST</th>
                         <th></th>
                    </tr>
    <?php
    }
    // hosting view
     function showrow_mhgdetails_view($details_result,$mhg_Code)
      {
           global $commonUses;
            $c=0;
             while ($row_mhgdetails=mysql_fetch_array($details_result))
            {
            ?>
            <?php
                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_mhgdetails["mhg_TaskCode"];
                                $lookupresult=@mysql_query($typequery);
                                $sub_query = mysql_fetch_array($lookupresult);
                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                if($c==7) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
            ?>
                 <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_mhgdetails["mhg_TaskCode"])); ?></td>
                    <td><?php if($row_mhgdetails["mhg_TaskValue"]=="Y") echo "Yes"; else echo $row_mhgdetails["mhg_TaskValue"]; ?></td>
                 </tr>
            <?php
                $c++;
            } ?>
              <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
              <tr>
              <?php
                    $cli_code=$_REQUEST['cli_code'];
                    $query = "SELECT i1.mhg_Code,i2.mhg_Notes,i2.mhg_IndiaNotes FROM mhg_qmyobhosting AS i1 LEFT OUTER JOIN mhg_qmyobhostingdetails AS i2 ON (i1.mhg_Code = i2.mhg_MYOBHCode) where mhg_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_notes = mysql_fetch_array($result);
                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
              ?>
                <td><div style="float:left; width:185px;"><b>Notes</b></div></td><td><div style="width:252px;"><?php echo $row_notes['mhg_Notes']; ?></div> </td>
             </tr>
             <tr><td><div style="float:left; width:185px;"><b>India Notes</b></div></td><td><div style="width:252px;"><?php echo $row_notes['mhg_IndiaNotes']; ?></div></td></tr>
             <?php
     }

}
	$hostingContent = new hostingContentList();
?>

