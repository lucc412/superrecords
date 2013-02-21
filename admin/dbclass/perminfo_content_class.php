<?php
class perminfoContentList extends Database
{
    // setupsydney content
    function setupSydney()
    {
        global $commonUses;
        global $access_file_level_syd;
        $cli_code=$_REQUEST['cli_code'];
        $recid=$_GET['recid'];
        $query = "SELECT * FROM  set_psetup where set_ClientCode =".$cli_code;
        $result=@mysql_query($query);
        $row_set = mysql_fetch_assoc($result);
        $set_Code=@mysql_result( $result,0,'set_Code') ;
        $details_query = "SELECT * FROM  set_psetupdetails where set_PSCode =".$set_Code." order by set_Code";
        $details_result=@mysql_query($details_query);
                if($_GET['a']=="edit")
                {
                    $this->showtableheader_syd($access_file_level_syd);
                    if($access_file_level_syd['stf_Add']=="Y" || $access_file_level_syd['stf_Edit']=="Y" || $access_file_level_syd['stf_Delete']=="Y")
                    {
                        if(mysql_num_rows($details_result)>0)
                        {
                        ?>
                            <form method="post" action="dbclass/perminfo_db_class.php"  >
                                <?php
                                if ($_GET['a']=="edit")
                                {
                                if($access_file_level_syd['stf_Edit']=="Y")
                                {
                                    $this->showrow_setupdetails($details_result,$set_Code,$access_file_level_syd,$cli_code,$recid);
                                ?>
                                    <input type='hidden' name='sql' value='update'>
                                    <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>"><input type="hidden" name="recid" value="<?php echo $recid;?>">
                                    <input type="hidden" name="xset_Code" value="<?php echo $set_Code;?>">
                                    <?php
                                    $query = "SELECT i1.set_Code,i2.set_Notes, i2.set_IndiaNotes FROM set_psetup AS i1 LEFT OUTER JOIN set_psetupdetails AS i2 ON (i1.set_Code = i2.set_PSCode) where set_ClientCode =".$cli_code;
                                    $result=@mysql_query($query);
                                    $row_notes = mysql_fetch_array($result);
                                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                    ?>
                                   <table class="fieldtable" border="0" cellspacing="1" cellpadding="2">
                                    <tr><td><div style="float:left; width:367px;"><b>Notes</b></div></td><td><div style="width:287px;"><textarea name="set_Notes" rows="3" cols="40" ><?php echo $row_notes['set_Notes']; ?></textarea> </div></td></tr>
                                    <tr><td><div style="float:left; width:367px;"><b>India Notes</b></div></td><td><div style="width:287px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="set_IndiaNotes" rows="3" cols="40" ><?php echo $row_notes['set_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['set_IndiaNotes']; ?><input type="hidden" name="set_IndiaNotes" value="<?php echo $row_notes['set_IndiaNotes']; ?>"> <?php } ?></div></td></tr>
                                    <tr>
                                        <td colspan="13"  >
                                              <center><input type="submit" name="setupsyd" id="setupupdate" value="Update" class="detailsbutton"></center>
                                        </td>
                                    </tr>
                                   </table>
                                 <?php
                                 }
                                  else if($access_file_level_syd['stf_Edit']=="N")
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
                                                $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Set up Syd%')";
                                                $tresult=@mysql_query($tquery);
                                                $tcount=mysql_num_rows($tresult);
                                                        if($tcount>0)
                                                        {
                                                                //Insert all tasks in details table for this client
                                                                while($trow=@mysql_fetch_array($tresult))
                                                                {
                                                                  $sql = "insert into `set_psetupdetails` (`set_PSCode`, `set_TaskCode`) values (" .$set_Code.", " .$trow['tsk_Code'].")";
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
                     if($access_file_level_syd['stf_View']=="Y")
                     {
                               $this->showtableheader_syd($access_file_level_syd);
                               $this->showrow_setupdetails_view($details_result,$set_Code);
                               echo "</table>";
                               $this->showrow_setupFooter( $row_set);
                      }
                      else if($access_file_level_syd['stf_View']=="N")
                      {
                           echo "You are not authorised to view a record.";
                      }

                }
    }
    // setupsydney edit
      function showrow_setupdetails($details_result,$set_Code,$access_file_level_syd,$cli_code,$recid)
      {
                global $commonUses;
                $count=mysql_num_rows($details_result);
                $l=0;
                while ($row_setupdetails=mysql_fetch_array($details_result))
                {
                    $tcode = $row_setupdetails["set_TaskCode"];
                    ?>
                    <input type="hidden" name="count" value="<?php echo $count;?>">
                    <input type="hidden" name="set_Code[<?php echo $tcode; ?>]" value="<?php echo $row_setupdetails["set_Code"];?>">
                    <input type="hidden" name="set_PSCode[<?php echo $tcode; ?>]" value="<?php echo $row_setupdetails["set_PSCode"];?>">
                                <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_setupdetails["set_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($l==0) echo "<td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($l==5) echo "<td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                ?>
                    <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_setupdetails["set_TaskCode"])); ?></td>
                        <td>
                        <?php
                            $typequery="select tsk_TypeofControl, tsk_Description from tsk_tasks where tsk_Code=".$row_setupdetails["set_TaskCode"];
                            $typeresult=@mysql_query($typequery);
                            $type_control = mysql_fetch_array($typeresult);
                        if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                        <?php if($type_control["tsk_Description"]=='BGL Login Details') { 
                            echo 'User Name: '; 
                            $login_val = explode('~',$row_setupdetails["set_TaskValue"]);
                            ?>
                            <input type="text" name="set_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($login_val[0])) ?>" size="30"/>
                        <?php
                        }
                            if($type_control["tsk_Description"]=='BGL Login Details') {
                                ?>
                                <br/><span>Password: </span><br/><input type="text" name="set_TaskValue_pass[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($login_val[1])) ?>" size="30"/>                        
                        <?php
                            }
                        }
                        if($type_control["tsk_TypeofControl"]=="2") {
                        ?>
                        <select name="set_TaskValue[<?php echo $tcode; ?>]">
                                    <option value="">Select</option>
                                    <?php
                                        $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_setupdetails["set_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                      while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                      $val = $lp_row["tsk_Code"];
                                      $control = explode(",",$lp_row["tsk_LookupValues"]);
                                        for($i = 0; $i < count($control); $i++){
                                      if($row_setupdetails["set_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                     ?>
                                        <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                    <?php } } ?>
                        </select>
                            <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                if($row_setupdetails["set_TaskValue"]=="Y") { echo $selyes="checked"; } else { $selyes=""; }
                         ?>
                        <input type="checkbox" name="set_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?>>
                        <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                        ?>
                            <textarea cols="35" rows="2" name="set_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_setupdetails["set_TaskValue"])) ?></textarea>
                        <?php
                        }
                        ?>
                        </td>
                        <td><textarea cols="30" rows="2" name="set_Remarks[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_setupdetails["set_Remarks"])) ?></textarea></td>
                    </tr>
                    <?php
                    $l++;
                    $consolidated_ids .= $row_setupdetails["set_TaskCode"].",";
                }
                $consolidated_ids = substr($consolidated_ids,0,-1);
                ?>
                <input type="hidden" name="set_TaskCode" value="<?php echo $consolidated_ids;?>">
     <?php
     }
     // setupsydney footer
     function showrow_setupFooter( $row_set)
        {
            echo "<br><span class='footer'>Created by: ".$row_set['set_Createdby']." | ". "Created on: ".$row_set['set_Createdon']." | ". "Lastmodified by: ".$row_set['set_Lastmodifiedby']." | ". "Lastmodified on: ".$row_set['set_Lastmodifiedon']."</span>";
        }
        // setupsydney header
      function showtableheader_syd($access_file_level_syd)
      {
     ?>
    <table  class="fieldtable"  border="0" cellspacing="1" cellpadding="5" width="70%">
            <tr class="fieldheader">
            <th class="fieldheader">Task Description</th>
            <th class="fieldheader"></th>
            <th class="fieldheader">Remarks</th>
     </tr>
<?php
      }
      // setupsydney view
       function showrow_setupdetails_view($details_result,$set_Code)
       {
            global $commonUses;
            $c=0;
             while ($row_setupdetails=mysql_fetch_array($details_result))
            {
            ?>
                        <?php
                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_setupdetails["set_TaskCode"];
                                $lookupresult=@mysql_query($typequery);
                                $sub_query = mysql_fetch_array($lookupresult);
                                if($c==0) echo "<td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                if($c==5) echo "<td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
             <tr>
                <td><?php echo $taskContent = $commonUses->getTaskDescription(htmlspecialchars($row_setupdetails["set_TaskCode"])); ?></td>
                <td>
                    <?php
                    if($row_setupdetails["set_TaskValue"]=="Y") $TaskVal = "Yes"; else $TaskVal = str_replace('"', '&quot;', trim($row_setupdetails["set_TaskValue"])); 
                    if($taskContent=='BGL Login Details') { 
                       $loginval = explode('~',$row_setupdetails['set_TaskValue']);
                        $TaskVal = 'Username: '.$loginval[0].", Password: ".$loginval[1];
                    }
                            echo $TaskVal;
                    ?>
                </td>
                <td><?php echo str_replace('"', '&quot;', trim($row_setupdetails["set_Remarks"])) ?></td>
             </tr>
            <?php
            $c++;
            }
            ?>
            <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
            <?php
            $cli_code=$_REQUEST['cli_code'];
            $query = "SELECT i1.set_Code,i2.set_Notes, i2.set_IndiaNotes FROM set_psetup AS i1 LEFT OUTER JOIN set_psetupdetails AS i2 ON (i1.set_Code = i2.set_PSCode) where set_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $ind_id = $commonUses->getIndiamanagerId($cli_code);
            ?>
            <tr><td><div style="float:left; width:168px;"><b>Notes</b></div></td><td><div style="width:454px;"><?php echo $row_notes['set_Notes']; ?></div></td></tr>
            <tr><td><div style="float:left; width:168px;"><b>India Notes</b></div></td><td><div style="width:454px;"><?php echo $row_notes['set_IndiaNotes']; ?></div></td></tr>
  <?php
       }
       // perm info details content
       function perminfoDetails()
       {
                global $commonUses;
                global $access_file_level_perminfo;
                
                $cli_code=$_REQUEST['cli_code'];
                $recid=$_GET['recid'];
                $query = "SELECT * FROM inf_pinfo where inf_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_inf = mysql_fetch_assoc($result);
                //============ card file info selected ========================
                $card_qry = "SELECT crd_HasRelatedEntities from crd_qcardfile WHERE crd_ClientCode=".$cli_code;
                $card_result = @mysql_query($card_qry);
                list($hasRelatedEntities) = @mysql_fetch_row($card_result);
                $inf_Code=@mysql_result( $result,0,'inf_Code') ;
                $details_query = "SELECT * FROM inf_pinfodetails where inf_PInfoCode =".$inf_Code." order by inf_TaskCode";
                $details_result=@mysql_query($details_query);
                if($_GET['a']=="edit")
                {
                        $this->showtableheader_inf($access_file_level_perminfo);
                        if($access_file_level_perminfo['stf_Add']=="Y" || $access_file_level_perminfo['stf_Edit']=="Y" || $access_file_level_perminfo['stf_Delete']=="Y")
                        {
                            if(mysql_num_rows($details_result)>0)
                            {
                             ?>
                                <form name="perminfoedit" method="post" action="dbclass/perminfo_db_class.php">
                                        <?php
                                        if ($_GET['a']=="edit")
                                        {
                                            if($access_file_level_perminfo['stf_Edit']=="Y")
                                            {
                                                $this->showrow_infdetails($details_result,$inf_Code,$access_file_level_perminfo,$cli_code,$recid,$hasRelatedEntities);
                                            ?>
                                            <?php
                                               $qcard_qry = "select crd_EntityType from crd_qcardfile WHERE crd_ClientCode='$cli_code' ";
                                               $qcard_result = @mysql_query($qcard_qry);
                                               list($entity_type) = @mysql_fetch_row($qcard_result);
                                               switch($entity_type)
                                               {
                                                 case 1:
                                                    $title = "Director";
                                                    $entity = true;
                                                    $rows = 4;
                                                    break;

                                                 case 2:
                                                    $title = "Sole Trader";
                                                    $entity = true;
                                                    $rows = 1;
                                                    break;

                                                 case 3:
                                                    $title = "Partnership";
                                                    $entity = true;
                                                    $rows = 4;
                                                    break;
                                                 default:
                                                   $entity = false;

                                               }
                                               if($entity)
                                               {
                                                  $entity_cont = '<tr><td style="background-color: rgb(245, 252, 255); border-bottom: 1px solid rgb(175, 229, 247); border-right: 1px solid rgb(245, 252, 255);" nowrap="nowrap"><b style="font-size: 14px; color: rgb(178, 26, 3);">Entity Details</b></td><td style="background-color: rgb(245, 252, 255); border-bottom: 1px solid rgb(175, 229, 247);"></td></tr>';
                                                  $entity_cont .= "<tr><td colspan='3'><table width='100%' class='fieldtable'>
                                                                        <tr><td><b>$title</b></td><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>DOB</b></td><td><b>TFN</b></td><td>Action</td></tr>";
                                                  $entity_qry = "Select inf_Code,inf_ClientCode,inf_EntityType,inf_FirstName,inf_LastName,inf_DOB,inf_TFN from inf_pinfoentity
                                                                  WHERE
                                                                  inf_ClientCode = '$cli_code' AND inf_EntityType='$entity_type' ";
                                                  $entity_result = @mysql_query($entity_qry);
                                                  $sno = 1;
                                                  while(list($infCode,$infClientCode,$infEntityType,$infFirstName,$infLastName,$infDOB,$infTFN) = mysql_fetch_array($entity_result))
                                                  {
                                                    //$inf_DOB = date("d/m/Y",strtotime($infDOB));
                                                     if($infDOB != "0000-00-00")
                                                           $inf_DOB = date("d/m/Y",strtotime($infDOB));
                                                    else
                                                       $inf_DOB = "";

                                                    $entity_cont .= "<tr><td>$sno</td><td><input type='text' name='fname_$sno' id='fname_$sno' value='$infFirstName' /></td><td><input type='text' name='lname_$sno' id='lname_$sno' value='$infLastName' /></td><td><input type='text'  name='date_$sno'  id='date_$sno' value='$inf_DOB' class='datepicker' readonly /><a href=javascript:NewCal('date_$sno','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a></td><td><input type='text' name='tfn_$sno' id='tfn_$sno'  value='$infTFN' /></td><td><a href='javascript:;' onclick='return entity_function($sno,\"save\");' ><img src='images/save.png' /></a>&nbsp;&nbsp;<a href='javascript:;' onclick='return entity_function($sno,\"delete\");' ><img src='images/erase.png' /></a><input type='hidden' name='hid_$sno' value='$infCode' /></td></tr>";
                                                    $sno++;
                                                  }

                                                  for($i=$sno;$i<=$rows;$i++)
                                                  {
                                                    $entity_cont .= "<tr><td>$i</td><td><input type='text' name='fname_$i' id='fname_$i' value='' /></td><td><input type='text' name='lname_$i' id='lname_$i' value='' /></td><td><input type='text' name='date_$i' id='date_$i' value='' class='datepicker' readonly /><a href=javascript:NewCal('date_$i','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a></td><td><input type='text' name='tfn_$i' id='tfn_$i' value='' /></td><td><a href='javascript:;' onclick='return entity_function($i,\"save\");' ><img src='images/save.png' /></a></td></tr>";
                                                  }
                                                 echo $entity_cont .= "</table><input type='hidden' name='entity' value='$entity_type' /></td></tr>";
                                               }
                                        ?>
                                                <input type='hidden' name='sql' value='update'>
                                                <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">			<input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                <input type="hidden" name="xinf_Code" value="<?php echo $inf_Code;?>">
                                        <?php
                                        $query = "SELECT i1.inf_Code,i2.inf_Notes, i2.inf_IndiaNotes FROM inf_pinfo AS i1 LEFT OUTER JOIN inf_pinfodetails AS i2 ON (i1.inf_Code = i2.inf_PInfoCode) where inf_ClientCode =".$cli_code;
                                        $result=@mysql_query($query);
                                        $row_notes = mysql_fetch_array($result);
                                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                        ?>
                                        <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div style=""><textarea name="inf_Notes" rows="3" cols="40" ><?php echo $row_notes['inf_Notes']; ?></textarea> </div></td></tr>
                                        <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div style=""><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="inf_IndiaNotes" rows="3" cols="40" ><?php echo $row_notes['inf_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['inf_IndiaNotes']; ?> <input type="hidden" name="inf_IndiaNotes" value="<?php echo $row_notes['inf_IndiaNotes']; ?>"><?php } ?></div></td></tr>
                                        <tr><td colspan="13" >
                                                <center><input type="submit" name="perminfo" value="Update" class="detailsbutton"></center>
                                             </td>
                                        </tr>
                                    </table>
                                        <?php
                                            }
                                            else if($access_file_level_perminfo['stf_Edit']=="N")
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
                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Permanent Information%')";
                                        $tresult=@mysql_query($tquery);
                                        $tcount=mysql_num_rows($tresult);
                                                if($tcount>0)
                                                {
                                                        //Insert all tasks in details table for this client
                                                        while($trow=@mysql_fetch_array($tresult))
                                                        {
                                                          $sql = "insert into `inf_pinfodetails` (`inf_PInfoCode`, `inf_TaskCode`) values (" .$inf_Code.", " .$trow['tsk_Code'].")";
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
                     if($access_file_level_perminfo['stf_View']=="Y")
                     {
                               $this->showtableheader_inf($access_file_level_perminfo);
                               $this->showrow_infdetails_view($details_result,$inf_Code);
                               echo "</table>";
                               $this->showrow_perminfoFooter( $row_perminfo);
                      }
                      else if($access_file_level_perminfo['stf_View']=="N")
                      {
                          echo "You are not authorised to view a record.";
                      }
                }
       }
       // perminfo edit
        function showrow_infdetails($details_result,$inf_Code,$access_file_level_perminfo,$cli_code,$recid,$hasRelatedEntities)
          {
                  global $commonUses;
                  $count=mysql_num_rows($details_result);
                  $c=0;
                        while ($row_infdetails=mysql_fetch_array($details_result))
                        {
                                $tcode = $row_infdetails["inf_TaskCode"];
                                ?>
                                <input type="hidden" name="count" value="<?php echo $count;?>">
                                <input type="hidden" name="inf_Code[<?php echo $tcode; ?>]" value="<?php echo $row_infdetails["inf_Code"];?>">
                                <input type="hidden" name="inf_PInfoCode[<?php echo $tcode; ?>]" value="<?php echo $row_infdetails["inf_PInfoCode"];?>">
                                        <?php
                                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_infdetails["inf_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                    $sub_query = mysql_fetch_array($lookupresult);
                                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                    if($c==7) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                    if($c==9) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                    if($c==11) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                 //   if($c==16) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                 //   if($c==24) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        ?>
                                <tr id="permInfo_<?php echo $tcode; ?>">
                                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_infdetails["inf_TaskCode"])); ?></td>
                                <td>
                                    <?php
                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_infdetails["inf_TaskCode"];
                                $typeresult=@mysql_query($typequery);
                                $type_control = mysql_fetch_array($typeresult);
                                    if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                    <input type="text" name="inf_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_infdetails["inf_TaskValue"])) ?>" size="30">
                                    <?php
                                    }
                                if($type_control["tsk_TypeofControl"]=="2") {
                                ?>
                                    <select name="inf_TaskValue[<?php echo $tcode; ?>]" onchange="enablePerm(<?php echo $tcode; ?>,<?php echo $c; ?>)" id="onGoing">
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_infdetails["inf_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                  if($row_infdetails["inf_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select>
                                        <?php
                                }
                                if($type_control["tsk_TypeofControl"]=="3") {
                                        ?>
                                        <?php
                                            if($row_infdetails["inf_TaskValue"]=="Y") { $selyes="checked"; }
                                            else
                                            {
                                              if($hasRelatedEntities == "Y")
                                                  $selyes="checked";
                                              else
                                                 $selyes="";
                                            }
                                        ?>
                                    <input type="checkbox" name="inf_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePerm(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                    <?php
                                    if($selyes == "checked")
                                    {
                                        $taskCont .= "<script>
                                                enablePerm(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                if($type_control["tsk_TypeofControl"]=="4") {
                                    ?>
                                    <textarea cols="35" rows="2" name="inf_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_infdetails["inf_TaskValue"])) ?></textarea>
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="5") {
                                ?>
                                    <select name="inf_TaskValue[<?php echo $tcode; ?>]" disabled>
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_infdetails["inf_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                  if($row_infdetails["inf_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select>
                                        <?php
                                }
                                if($type_control["tsk_TypeofControl"]=="6") {
                                ?>
                                    <input type="text" name="inf_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_infdetails["inf_TaskValue"])) ?>" size="30" id="oneVal_<?php echo $tcode; ?>" style="display:none">
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="7") {
                                ?>
                                    <select name="inf_TaskValue[<?php echo $tcode; ?>]" id="conOngoing">
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_infdetails["inf_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                  if($row_infdetails["inf_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select>
                                        <?php
                                }
                                ?>
                                </td>
                                </tr>
                                <?php
                                $c++;
                                $consolidated_ids .= $row_infdetails["inf_TaskCode"].",";
                        }
                        $consolidated_ids = substr($consolidated_ids,0,-1);
                        ?>
                        <input type="hidden" name="inf_TaskCode" value="<?php echo $consolidated_ids;?>">
                         <?php

                          echo $taskCont;
         }
         // perminfo footer
        function showrow_perminfoFooter( $row_perminfo)
        {
            echo "<br><span class='footer'>Created by: ".$row_perminfo['inf_Createdby']." | ". "Created on: ".$row_perminfo['inf_Createdon']." | ". "Lastmodified by: ".$row_perminfo['inf_Lastmodifiedby']." | ". "Lastmodified on: ".$row_perminfo['inf_Lastmodifiedon']."</span>";
        }
        // perminfo header
         function showtableheader_inf($access_file_level_perminfo)
         {
         ?>
                <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="90%" >
                        <tr class="fieldheader">
                        <th class="fieldheader">Task Description</th>
                        <th class="fieldheader"></th>
                        </tr>
          <?php
          }
          // perminfo view
            function showrow_infdetails_view($details_result,$inf_Code)
            {
                global $commonUses;
                $c=0;
                while ($row_infdetails=mysql_fetch_array($details_result))
                {
                ?>
                    <tr>
                            <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_infdetails["inf_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==7) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==9) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        if($c==11) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        //if($c==16) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        //if($c==24) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                            ?>

                    </tr>
                    <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_infdetails["inf_TaskCode"])); ?></td>
                    <td><?php if($row_infdetails["inf_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_infdetails["inf_TaskValue"])); ?></td>
                    </tr>
                    <?php
                    $c++;
                }
                ?>
                  <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                <?php
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT i1.inf_Code,i2.inf_Notes, i2.inf_IndiaNotes FROM inf_pinfo AS i1 LEFT OUTER JOIN inf_pinfodetails AS i2 ON (i1.inf_Code = i2.inf_PInfoCode) where inf_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_notes = mysql_fetch_array($result);
                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                    ?>
                <tr><td><div style="float:left; width:525px;"><b>Notes</b></div></td><td><div style="width:282px;"><?php echo $row_notes['inf_Notes']; ?></div></td></tr>
                <tr><td><div style="float:left; width:525px;"><b>India Notes</b></div></td><td><div style="width:282px;"><?php echo $row_notes['inf_IndiaNotes']; ?></div></td></tr>
     <?php
            }
            // current status content
            function currentStatus()
            {
                    global $commonUses;
                    global $access_file_level_curst;
                    $cli_code=$_REQUEST['cli_code'];
                    $recid=$_GET['recid'];
                    $query = "SELECT * FROM cst_pcurrentstatus where cst_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_cst = mysql_fetch_assoc($result);
                    $cst_Code=@mysql_result( $result,0,'cst_Code') ;
                    $details_query = "SELECT * FROM cst_pcurrentstatusdetails where cst_PCSCode =".$cst_Code." order by cst_Code";
                    $details_result=@mysql_query($details_query);
                    if($_GET['a']=="edit")
                    {
                           $this->showtableheader_curst($access_file_level_curst);
                           if($access_file_level_curst['stf_Add']=="Y" || $access_file_level_curst['stf_Edit']=="Y" || $access_file_level_curst['stf_Delete']=="Y")
                           {
                               if(mysql_num_rows($details_result)>0)
                               {
                                ?>
                                    <form name="currentstatusedit" method="post" action="dbclass/perminfo_db_class.php" >
                                   <?php
                                            if ($_GET['a']=="edit")
                                            {
                                            if($access_file_level_curst['stf_Edit']=="Y")
                                                      {
                                            $this->showrow_curstatusdetails($details_result,$cst_Code,$access_file_level_curst,$cli_code,$recid);
                                            ?>

                                            <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                    <input type="hidden" name="recid" value="<?php echo $recid;?>">

                                                            <input type="hidden" name="xcst_Code" value="<?php echo $cst_Code;?>">
                                                                <?php
                                            $query = "SELECT i1.cst_Code,i2.cst_Notes, i2.cst_IndiaNotes FROM cst_pcurrentstatus AS i1 LEFT OUTER JOIN cst_pcurrentstatusdetails AS i2 ON (i1.cst_Code = i2.cst_PCSCode) where cst_ClientCode =".$cli_code;
                                            $result=@mysql_query($query);
                                            $row_notes = mysql_fetch_array($result);
                                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                                ?>
                                            <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="cst_Notes" rows="3" cols="60" ><?php echo $row_notes['cst_Notes']; ?></textarea> </div></td></tr>
                                            <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="cst_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['cst_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['cst_IndiaNotes']; ?><input type="hidden" name="cst_IndiaNotes" value="<?php echo $row_notes['cst_IndiaNotes']; ?>"> <?php } ?></div></td></tr>
                                            <tr><td colspan="13"><center><input type="submit" name="curstatus" value="Update" class="detailsbutton"></center>
                                            </td></tr>
                                        </table>
                                                                     <?php
                                                      }
                                                      else if($access_file_level_curst['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Current Status%')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                          $sql = "insert into `cst_pcurrentstatusdetails` (`cst_PCSCode`, `cst_TaskCode`) values (" .$cst_Code.", " .$trow['tsk_Code'].")";
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
                         if($access_file_level_curst['stf_View']=="Y")
                         {
                                   $this->showtableheader_curst($access_file_level_curst);
                                   $this->showrow_curstdetails_view($details_result,$cst_Code);
                                   echo "</table>";
                                   $this->showrow_curreststatusFooter( $row_cst);
                          }
                          else if($access_file_level_curst['stf_View']=="N")
                          {
                              echo "You are not authorised to view a record.";
                           }
                    }
            }
            // current status edit
                function showrow_curstatusdetails($details_result,$cst_Code,$access_file_level_curst,$cli_code,$recid)
                {
                          global $commonUses;
                          $count=mysql_num_rows($details_result);
                          $c=0;
                        while ($row_cstdetails=mysql_fetch_array($details_result))
                        {
                                $tcode = $row_cstdetails["cst_TaskCode"];
                                ?>
                                <input type="hidden" name="count" value="<?php echo $count;?>">
                                <input type="hidden" name="cst_Code[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["cst_Code"];?>">
                                <input type="hidden" name="cst_PCSCode[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["cst_PCSCode"];?>">
                                <?php
                                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_cstdetails["cst_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                    $sub_query = mysql_fetch_array($lookupresult);
                                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                ?>
                                <tr id="curStat_<?php echo $tcode; ?>">
                                    <td id="taskCont_<?php echo $tcode; ?>"><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_cstdetails["cst_TaskCode"])); ?></td>
                                <td>
                                    <?php
                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_cstdetails["cst_TaskCode"];
                                $typeresult=@mysql_query($typequery);
                                $type_control = mysql_fetch_array($typeresult);

                                    if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                    <input type="text" name="cst_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["cst_TaskValue"])) ?>" size="30" id="uptoDate">
                                    <?php
                                    }
                                if($type_control["tsk_TypeofControl"]=="2") {
                                ?>
                                    <select name="cst_TaskValue[<?php echo $tcode; ?>]" onchange="taskVal()" id="curTask">
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_cstdetails["cst_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                 $tVal = explode("~",$row_cstdetails["cst_TaskValue"]);
                                                 if($tVal[0]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select><div style="float:right;"><input type="text" name="other_Value[<?php echo $tcode; ?>]" value="<?php echo $tVal[1]; ?>" style="display:none;" id="otherVal"></div>
                                        <?php
                                        if($tVal[0]=="other")
                                        {
                                        $taskCont .= "<script>
                                                taskVal();
                                                </script>";
                                        }
                                }
                                if($type_control["tsk_TypeofControl"]=="3") {
                                        ?>
                                        <?php
                                            if($row_cstdetails["cst_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>
                                    <input type="checkbox" name="cst_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableStatus(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                    <?php
                                    if($row_cstdetails["cst_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enableStatus(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                if($type_control["tsk_TypeofControl"]=="4") {
                                    ?>
                                    <textarea cols="20" rows="2" name="cst_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_cstdetails["cst_TaskValue"])) ?></textarea>
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="5") {
                                        ?>
                                            <?php
                                            if($row_cstdetails["cst_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>

                                    <input type="checkbox" name="cst_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableStatus(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                    <?php
                                    if($row_cstdetails["cst_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enableStatus(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                if($type_control["tsk_TypeofControl"]=="6") {
                                        ?>
                                    <input type="text" name="cst_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["cst_TaskValue"])) ?>" id="conDetails" size="30" style="display:none;">
                                    <?php
                                }
                                if($type_control["tsk_TypeofControl"]=="7") {
                                        ?>
                                    <input type="text" name="cst_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["cst_TaskValue"])) ?>" size="30">
                                    <?php
                                }
                                ?>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                                $consolidated_ids .= $row_cstdetails["cst_TaskCode"].",";
                        }
                        $consolidated_ids = substr($consolidated_ids,0,-1);
                        ?>
                        <input type="hidden" name="cst_TaskCode" value="<?php echo $consolidated_ids;?>">
                         <?php
                         echo $taskCont;
                 }
                 // current status footer
                 function showrow_curreststatusFooter( $row_cursts)
                 {
                        echo "<br><span class='footer'>Created by: ".$row_cursts['cst_Createdby']." | ". "Created on: ".$row_cursts['cst_Createdon']." | ". "Lastmodified by: ".$row_cursts['cst_Lastmodifiedby']." | ". "Lastmodified on: ".$row_cursts['cst_Lastmodifiedon']."</span>";
                 }
                 // current status header
                 function showtableheader_curst($access_file_level_curst)
                 {
                 ?>
                        <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                                <tr class="fieldheader">
                                <th class="fieldheader">Task Description</th>
                                <th class="fieldheader"></th>
                                </tr>
                <?php
                }
                // current status view
                function  showrow_curstdetails_view($details_result,$set_Code)
                {
                        global $commonUses;
                        $c=0;
                        while ($row_curdetails=mysql_fetch_array($details_result))
                        {
                        ?>
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_curdetails["cst_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = @mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                            <tr>
                            <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_curdetails["cst_TaskCode"])); ?></td>
                            <td><?php if($row_curdetails["cst_TaskValue"]=="Y") echo "Yes"; else { $tVal = explode("~",$row_curdetails["cst_TaskValue"]); if(count($tVal)>1) { echo $tVal[0]; echo "&nbsp;&nbsp;:&nbsp; ".$tVal[1]; } else { echo $tVal[0]; }} ?></td>
                            <!-- <td><?php echo str_replace('"', '&quot;', trim($row_curdetails["cst_Description"])) ?></td> -->
                            </tr>
                            <?php
                            $c++;
                        }
                        ?>
                         <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                          <tr>
                        <?php
                        $cli_code=$_REQUEST['cli_code'];
                            $query = "SELECT i1.cst_Code,i2.cst_Notes,i2.cst_IndiaNotes FROM cst_pcurrentstatus AS i1 LEFT OUTER JOIN cst_pcurrentstatusdetails AS i2 ON (i1.cst_Code = i2.cst_PCSCode) where cst_ClientCode =".$cli_code;
                            $result=@mysql_query($query);
                            $row_notes = mysql_fetch_array($result);
                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                        ?>
                            <td><div style="float:left; width:333px;"><b>Notes</b></div></td><td><div style="width:289px;"><?php echo $row_notes['cst_Notes']; ?></div> </td>
                         </tr>
                         <tr>
                             <tr><td><div style="float:left; width:333px;"><b>India Notes</b></div></td><td><div style="width:289px;"><?php echo $row_notes['cst_IndiaNotes']; ?></div></td></tr>
                         </tr>
                <?php
                }
                // backlog jobsheet content
                function backlogJobsheet()
                {
                        global $commonUses;
                        global $access_file_level_blj;
                        
                        $cli_code=$_REQUEST['cli_code'];
                        $recid=$_GET['recid'];
                        $task_check = false;
                        $query = "SELECT * FROM  blj_pbacklog where blj_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_backlog = mysql_fetch_assoc($result);
                        $blj_Code=@mysql_result( $result,0,'blj_Code') ;
                        $details_query = "SELECT * FROM blj_pbacklogdetails where blj_PBLCode =".$blj_Code." order by blj_Code";
                        $details_result=@mysql_query($details_query);
                         if($_GET['a']=="edit")
                         {
                                $this->showtableheader_blj($access_file_level_blj);
                                if($access_file_level_blj['stf_Add']=="Y" || $access_file_level_blj['stf_Edit']=="Y" || $access_file_level_blj['stf_Delete']=="Y")
                                {
                                   if(mysql_num_rows($details_result)>0)
                                   {
                                    ?>
                                        <form method="post" action="dbclass/perminfo_db_class.php"  >
                                            <?php
                                            if ($_GET['a']=="edit")
                                            {
                                                if($access_file_level_blj['stf_Edit']=="Y")
                                                {
                                                    $this->showrow_backlogdetails($details_result,$blj_Code,$access_file_level_blj,$cli_code,$recid);?>
                                                    <tr>
                                                    <td colspan="13"  >
                                                    <input type='hidden' name='sql' value='update'>
                                                    <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">			<input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                    <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%">
                                                        <tr class="fieldheader">
                                                        <th>Source documents needed</th>
                                                        <th colspan="15">Method of delivery(attached/to come)</th>
                                                        </tr>

                                                                <?php
                                                                        $details_query = "SELECT * FROM bjs_sourcedocumentdetails where bjs_PBLCode =".$blj_Code." order by bjs_Code asc limit 10";
                                                                        $details_result=@mysql_query($details_query);
                                                                        $count=mysql_num_rows($details_result);
                                                                        while ($row_bjsdetails=mysql_fetch_array($details_result))
                                                                        {
                                                                            if($GLOBALS['task_check'])
                                                                                $disabled = "";
                                                                            else
                                                                                $disabled = "disabled";
                                                                $scode = $row_bjsdetails["bjs_Code"];
                                                                ?>
                                                        <input type="hidden" name="count" value="<?php echo $count;?>">
                                                        <input type="hidden" name="bjs_Code[]" value="<?php echo $row_bjsdetails["bjs_Code"];?>">
                                                        <input type="hidden" name="bjs_PBLCode[]" value="<?php echo $row_bjsdetails["bjs_PBLCode"];?>">
                                                        <tr id="sourceDoc">
                                                            <td style="display:none;"><?php echo $row_bjsdetails['bjs_code'] ?></td>
                                                            <td><input type="text" size="55" name="bjs_SourceDocument[]" value="<?php if($row_bjsdetails['bjs_SourceDocument']=="NULL") echo ""; else echo $row_bjsdetails['bjs_SourceDocument'] ?>" <?php echo $disabled; ?> ></td>
                                                            <td><input type="text" size="55" name="bjs_MethodofDelivery[]" value="<?php echo $row_bjsdetails['bjs_MethodofDelivery'] ?>" <?php echo $disabled; ?> ></td>
                                                        </tr>
                                                        <?php
                                                              }
                                                        ?>
                                                    </table>
                                                    <input type="hidden" name="xblj_Code" value="<?php echo $blj_Code;?>">
                                                    <?php
                                                        $query = "SELECT i1.blj_Code,i2.blj_Notes, i2.blj_IndiaNotes FROM blj_pbacklog AS i1 LEFT OUTER JOIN blj_pbacklogdetails AS i2 ON (i1.blj_Code = i2.blj_PBLCode) where blj_ClientCode =".$cli_code;
                                                        $result=@mysql_query($query);
                                                        $row_notes = mysql_fetch_array($result);
                                                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                     ?>
                                                        <tr><td><div style="float:left; width:360px;"><b>Notes</b></div></td><td><div><textarea name="blj_Notes" rows="3" cols="57" ><?php echo $row_notes['blj_Notes']; ?></textarea> </div></td></tr>
                                                        <tr><td><div style="float:left; width:360px;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="blj_IndiaNotes" rows="3" cols="57" ><?php echo $row_notes['blj_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['blj_IndiaNotes']; ?><input type="hidden" name="blj_IndiaNotes" value="<?php echo $row_notes['blj_IndiaNotes']; ?>"> <?php } ?></div></td></tr>
                                                        <tr><td colspan="3">
                                                        <center><input type="submit" name="bckjob" value="Update" class="detailsbutton"></center>
                                                        </td></tr>
                                                    </table>
                                                      <?php
                                                      }
                                                      else if($access_file_level_blj['stf_Edit']=="N")
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
                                                            $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Back Log Jobsheet%')";
                                                            $tresult=@mysql_query($tquery);
                                                            $tcount=mysql_num_rows($tresult);
                                                                    if($tcount>0)
                                                                    {
                                                                            //Insert all tasks in details table for this client
                                                                            while($trow=@mysql_fetch_array($tresult))
                                                                            {
                                                                              $sql_source = "insert into `bjs_sourcedocumentdetails` (`bjs_PBLCode`) values (" .$blj_Code.")";
                                                                              @mysql_query($sql_source);

                                                                              $sql = "insert into `blj_pbacklogdetails` (`blj_PBLCode`, `blj_TaskCode`) values (" .$blj_Code.", " .$trow['tsk_Code'].")";
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
                                 if($access_file_level_blj['stf_View']=="Y")
                                 {
                                           $this->showtableheader_blj($access_file_level_blj);
                                           $this->showrow_bljdetails_view($details_result,$blj_Code);
                                           echo "</table>";
                                           $this->showrow_backlogFooter( $row_backlog);
                                  }
                                  else if($access_file_level_blj['stf_View']=="N")
                                  {
                                      echo "You are not authorised to view a record.";
                                   }
                         }
                }
                // backlog jobsheet edit
                  function showrow_backlogdetails($details_result,$blj_Code,$access_file_level_blj,$cli_code,$recid)
                  {
                          global $commonUses;
                          $count=mysql_num_rows($details_result);
                            $c=0;
                            while ($row_bljdetails=mysql_fetch_array($details_result))
                            {
                                    $tcode = $row_bljdetails["blj_TaskCode"];
                                    ?>
                                    <input type="hidden" name="count" value="<?php echo $count;?>">
                                    <input type="hidden" name="blj_Code[<?php echo $tcode; ?>]" value="<?php echo $row_bljdetails["blj_Code"];?>">
                                    <input type="hidden" name="blj_PBLCode[<?php echo $tcode; ?>]" value="<?php echo $row_bljdetails["blj_PBLCode"];?>">
                                    <?php
                                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_bljdetails["blj_TaskCode"];
                                                        $lookupresult=@mysql_query($typequery);
                                                        $sub_query = mysql_fetch_array($lookupresult);
                                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                        if($c==2) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                        if($c==17) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                      //   echo "<td>".$tcode."</td>"
                                    ?>
                                    <tr id="backLog_<?php echo $tcode; ?>">
                                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_bljdetails["blj_TaskCode"])); ?></td>
                                    <td>
                                        <?php
                                    $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_bljdetails["blj_TaskCode"];
                                    $typeresult=@mysql_query($typequery);
                                    $type_control = mysql_fetch_array($typeresult);

                                        if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                        <input type="text" name="blj_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_bljdetails["blj_TaskValue"])) ?>" size="30" disabled>
                                        <?php
                                        }
                                    if($type_control["tsk_TypeofControl"]=="2") {
                                    ?>
                                        <select name="blj_TaskValue[<?php echo $tcode; ?>]" disabled>
                                            <option value="">Select</option>
                                                    <?php
                                                        $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_bljdetails["blj_TaskCode"];
                                                        $lookupresult=@mysql_query($typequery);
                                                      while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                      $val = $lp_row["tsk_Code"];
                                                      $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                        for($i = 0; $i < count($control); $i++){
                                                      if($row_bljdetails["blj_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                     ?>
                                                        <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                    <?php } } ?>
                                        </select>
                                            <?php
                                    }
                                    if($type_control["tsk_TypeofControl"]=="3") {
                                            ?>
                                            <?php
                                                if($row_bljdetails["blj_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                            ?>
                                        <input type="checkbox" name="blj_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBacklog(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" disabled>
                                        <?php
                                            if($row_bljdetails["blj_TaskValue"]=="Y")
                                            {
                                            $taskCont .= "<script>
                                                    enableBacklog(true,$tcode,$c);
                                                    </script>";

                                            }
                                    }
                                    if($type_control["tsk_TypeofControl"]=="4") {
                                        ?>
                                        <textarea cols="30" rows="2" name="blj_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_bljdetails["blj_TaskValue"])) ?></textarea>
                                        <?php }
                                    if($type_control["tsk_TypeofControl"]=="5") {
                                        ?>
                                        <input type="text" name="blj_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_bljdetails["blj_TaskValue"])) ?>" id="taskNote" size="30" style="display:none;">
                                        <?php }
                                    if($type_control["tsk_TypeofControl"]=="6") {
                                            ?>
                                            <?php
                                                if($row_bljdetails["blj_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                            ?>

                                        <input type="checkbox" name="blj_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBacklog(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                        <?php
                                            if($row_bljdetails["blj_TaskValue"]=="Y")
                                            {
                                              $GLOBALS['task_check'] = true;
                                            $taskCont .= "<script>
                                                    enableBacklog(true,$tcode,$c);
                                                    </script>";
                                            }
                                    }
                                        if($type_control["tsk_TypeofControl"]=="7") { ?>
                                        <input type="text" name="blj_TaskValue[<?php echo $tcode; ?>]" id="relevant_<?php echo $tcode; ?>" value="<?php echo str_replace('"', '&quot;', trim($row_bljdetails["blj_TaskValue"])) ?>" size="30" style="display:none;">
                                        <?php
                                        }
                                    if($type_control["tsk_TypeofControl"]=="8") {
                                            ?>
                                            <?php
                                            $exTask = explode("~",$row_bljdetails["blj_TaskValue"]);
                                                if($exTask[0]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                            ?>

                                        <input type="checkbox" name="blj_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBacklog(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                        <div style="float:right;"><input type="text" name="rel_Value[<?php echo $tcode; ?>]" value="<?php echo $exTask[1]; ?>" style="display:none;" id="relOther"></div>
                                        <?php
                                            if($exTask[0]=="Y")
                                            {
                                            $taskCont .= "<script>
                                                    enableBacklog(true,$tcode,$c);
                                                    </script>";
                                            }
                                    }
                                    ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $c++;
                                    $consolidated_ids .= $row_bljdetails["blj_TaskCode"].",";
                            }
                            $consolidated_ids = substr($consolidated_ids,0,-1);
                            ?>
                            <input type="hidden" name="blj_TaskCode" value="<?php echo $consolidated_ids;?>">
                             <?php
                             echo $taskCont;
                 }
                 // backlog jobsheet footer
                 function showrow_backlogFooter( $row_backlog)
                 {
                    echo "<br><span class='footer'>Created by: ".$row_backlog['blj_Createdby']." | ". "Created on: ".$row_backlog['blj_Createdon']." | ". "Lastmodified by: ".$row_backlog['blj_Lastmodifiedby']." | ". "Lastmodified on: ".$row_backlog['blj_Lastmodifiedon']."</span>";
                 }
                 // backlog jobsheet header
                function showtableheader_blj($access_file_level_blj)
                {
                ?>
                <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                        <tr class="fieldheader">
                        <th class="fieldheader">Task Description</th>
                        <th></th>
                        </tr>
                <?php
                }
                // backlog jobsheet view
                function  showrow_bljdetails_view($details_result,$set_Code)
                {
                        global $commonUses;
                        
                        $count=mysql_num_rows($details_result);
                        $c=0;
                        while ($row_bljdetails=mysql_fetch_array($details_result))
                        {
                        ?>
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_bljdetails["blj_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==2) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                            if($c==17) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                        <tr>
                                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_bljdetails["blj_TaskCode"])); ?></td>
                                <td><?php if($row_bljdetails["blj_TaskValue"]=="Y") echo "Yes"; else { $tVal = explode("~",$row_bljdetails["blj_TaskValue"]); if(count($tVal)>1) { if($tVal[0]=="Y") echo "Yes"; echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other :&nbsp; ".$tVal[1]; } else { echo $tVal[0]; }} ?></td>
                        </tr>
                        <?php
                        $c++;
                        }
                        ?>
                            <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%">
                                <tr class="fieldheader">
                                <th>Source documents needed</th>
                                <th colspan="15">Method of delivery(attached/to come)</th>
                                </tr>

                                        <?php
                                                $cli_code=$_REQUEST['cli_code'];
                                                $query = "SELECT * FROM  blj_pbacklog where blj_ClientCode =".$cli_code;
                                                $result=@mysql_query($query);
                                                $row_backlog = mysql_fetch_assoc($result);
                                                $blj_Code=@mysql_result( $result,0,'blj_Code') ;
                                        
                                                $details_query = "SELECT * FROM bjs_sourcedocumentdetails where bjs_PBLCode =".$blj_Code." order by bjs_Code asc limit 10";
                                                $details_result=@mysql_query($details_query);
                                                $count=@mysql_num_rows($details_result);
                                                while ($row_bjsdetails=@mysql_fetch_array($details_result))
                                                {
                                        ?>
                    <input type="hidden" name="count" value="<?php echo $count;?>">
                    <input type="hidden" name="bjs_Code[]" value="<?php echo $row_bjsdetails["bjs_Code"];?>">
                    <input type="hidden" name="bjs_PBLCode[]" value="<?php echo $row_bjsdetails["bjs_PBLCode"];?>">

                                <tr>
                                    <td style="display:none;"><?php echo $row_bjsdetails['bjs_code'] ?></td>
                                    <td><?php if($row_bjsdetails['bjs_SourceDocument']=="NULL") echo ""; else echo $row_bjsdetails['bjs_SourceDocument']; ?></td>
                                    <td><?php echo $row_bjsdetails['bjs_MethodofDelivery']; ?></td>
                                </tr>
                                        <?php
                                                }
                                        ?>
                     <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                      <tr>
                    <?php
                    $cli_code=$_REQUEST['cli_code'];
                    $query = "SELECT i1.blj_Code,i2.blj_Notes, i2.blj_IndiaNotes FROM blj_pbacklog AS i1 LEFT OUTER JOIN blj_pbacklogdetails AS i2 ON (i1.blj_Code = i2.blj_PBLCode) where blj_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_notes = mysql_fetch_array($result);
                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                    ?>
                          <td><div style="float:left; width:269px;"><b>Notes</b></div></td><td><div style="width:354px;"><?php echo $row_notes['blj_Notes']; ?></div> </td>
                     </tr>
                     <tr>
                         <tr><td><div style="float:left; width:269px;"><b>India Notes</b></div></td><td><div style="width:354px;"><?php echo $row_notes['blj_IndiaNotes']; ?></div></td></tr>
                     </tr>
                <?php
                }
}
	$perminfoContent = new perminfoContentList();
?>

