<?php
class permgeneralContentList extends Database
{
    // general info content
    function generalInfo()
    {
            global $commonUses;
            global $access_file_level_gen;
            
            $cli_code=$_REQUEST['cli_code'];
            $recid=$_GET['recid'];
            $query = "SELECT * FROM  gif_pgeneralinfo where gif_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_gif = mysql_fetch_assoc($result);
            $gif_Code=@mysql_result( $result,0,'gif_Code') ;
            $details_query = "SELECT * FROM gif_pgeneralinfodetails where gif_PGICode =".$gif_Code." order by gif_Code";
            $details_result=@mysql_query($details_query);
             if($_GET['a']=="edit")
             {
                    $this->showtableheader_geninfo($access_file_level_gen);
                    if($access_file_level_gen['stf_Add']=="Y" || $access_file_level_gen['stf_Edit']=="Y" || $access_file_level_gen['stf_Delete']=="Y")
                    {
                        if(mysql_num_rows($details_result)>0)
                        {
                        ?>
                              <form  method="post" action="dbclass/perminfo_db_class.php"   >
                                <?php

                                if ($_GET['a']=="edit")
                                {
                                if($access_file_level_gen['stf_Edit']=="Y")
                                          {
                                $this->showrow_geninfodetails($details_result,$gif_Code,$access_file_level_gen,$cli_code,$recid);?>
                                <?php
                                $query = "SELECT i1.gif_Code,i2.gif_Notes, i2.gif_IndiaNotes FROM gif_pgeneralinfo AS i1 LEFT OUTER JOIN gif_pgeneralinfodetails AS i2 ON (i1.gif_Code = i2.gif_PGICode) where gif_ClientCode =".$cli_code;
                                $result=@mysql_query($query);
                                $row_notes = mysql_fetch_array($result);
                                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                ?>
                                <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="gif_Notes" rows="4" cols="60" ><?php echo $row_notes['gif_Notes']; ?></textarea> </div></td></tr>
                                <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="gif_IndiaNotes" rows="4" cols="60" ><?php echo $row_notes['gif_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['gif_IndiaNotes']; ?><input type="hidden" name="gif_IndiaNotes" value="<?php echo $row_notes['gif_IndiaNotes']; ?>"> <?php } ?></div></td></tr>
                                <tr>
                                <td colspan="13"  >
                                <input type='hidden' name='sql' value='update'>			<input type="hidden" name="recid" value="<?php echo $recid;?>">
                                <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                <input type="hidden" name="xgif_Code" value="<?php echo $gif_Code;?>">
                                        <center><input type="submit" name="generalinfo" value="Update" class="detailsbutton"></center>
                                </td></tr>
                              </table>
                                  <?php
                                          }
                                          else if($access_file_level_gen['stf_Edit']=="N")
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
                                                $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'General Information%')";
                                                $tresult=@mysql_query($tquery);
                                                $tcount=mysql_num_rows($tresult);
                                                        if($tcount>0)
                                                        {
                                                                //Insert all tasks in details table for this client
                                                                while($trow=@mysql_fetch_array($tresult))
                                                                {
                                                                  $sql = "insert into `gif_pgeneralinfodetails` (`gif_PGICode`, `gif_TaskCode`) values (" .$gif_Code.", " .$trow['tsk_Code'].")";
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
                     if($access_file_level_gen['stf_View']=="Y")
                     {
                            $this->showtableheader_geninfo($access_file_level_gen);
                            $this->showrow_geninfodetails_view($details_result,$gif_Code);
                               echo "</table>";
                              $this->showrow_geninfoFooter( $row_gif);
                     }
                     else if($access_file_level_gen['stf_View']=="N")
                     {
                              echo "You are not authorised to view a record.";
                     }
             }
    }
    // general info edit
    function showrow_geninfodetails($details_result,$gif_Code,$access_file_level_gen,$cli_code,$recid)
    {
                  global $commonUses;
                  $count=mysql_num_rows($details_result);
                  $c=0;
        while ($row_gifdetails=mysql_fetch_array($details_result))
        {
                $tcode = $row_gifdetails["gif_TaskCode"];
                ?>
                <input type="hidden" name="count" value="<?php echo $count;?>">
                <input type="hidden" name="gif_Code[<?php echo $tcode; ?>]" value="<?php echo $row_gifdetails["gif_Code"];?>">
                <input type="hidden" name="gif_PGICode[<?php echo $tcode; ?>]" value="<?php echo $row_gifdetails["gif_PGICode"];?>">
                <?php
                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_gifdetails["gif_TaskCode"];
                                    $lookupresult=@mysql_query($typequery);
                                    $sub_query = mysql_fetch_array($lookupresult);
                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                    if($c==5) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                ?>
                <tr>
                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_gifdetails["gif_TaskCode"])); ?></td>
                <td>
                <?php
                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_gifdetails["gif_TaskCode"];
                $typeresult=@mysql_query($typequery);
                $type_control = mysql_fetch_array($typeresult);
                if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                        <input type="text" name="gif_TaskValue[<?php echo $tcode; ?>]" size="60" value="<?php echo str_replace('"', '&quot;', trim($row_gifdetails["gif_TaskValue"])) ?>" size="30">
                    <?php
                    }
                if($type_control["tsk_TypeofControl"]=="2") {
                ?>
                    <select name="gif_TaskValue[<?php echo $tcode; ?>]">
                        <option value="">Select</option>
                                <?php
                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_gifdetails["gif_TaskCode"];
                                    $lookupresult=@mysql_query($typequery);
                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                  $val = $lp_row["tsk_Code"];
                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                    for($i = 0; $i < count($control); $i++){
                                  if($row_gifdetails["gif_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                 ?>
                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                <?php } } ?>
                    </select>
                        <?php
                }
                if($type_control["tsk_TypeofControl"]=="3") {
                        ?>
                        <?php
                            if($row_gifdetails["gif_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                        ?>
                    <input type="checkbox" name="gif_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?>>
                    <?php
                }
                if($type_control["tsk_TypeofControl"]=="4") {
                    ?>
                    <textarea cols="60" rows="4" name="gif_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_gifdetails["gif_TaskValue"])) ?></textarea>
                    <?php } ?>
                </td>
              </tr>
                <?php
                $c++;
                $consolidated_ids .= $row_gifdetails["gif_TaskCode"].",";
        }
        $consolidated_ids = substr($consolidated_ids,0,-1);
        ?>
         <input type="hidden" name="gif_TaskCode" value="<?php echo $consolidated_ids;?>">
    <?php
    }
    // general info footer
    function showrow_geninfoFooter( $row_gif)
    {
        echo "<br><span class='footer'>Created by: ".$row_gif['gif_Createdby']." | ". "Created on: ".$row_gif['gif_Createdon']." | ". "Lastmodified by: ".$row_gif['gif_Lastmodifiedby']." | ". "Lastmodified on: ".$row_gif['gif_Lastmodifiedon']."</span>";
    }
    // general info header
    function showtableheader_geninfo($access_file_level_gen)
    {
    ?>
        <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                <tr class="fieldheader">
                <th class="fieldheader">Task Description</th>
                <th></th>
                </tr>
    <?php
    }
    // general info view
    function showrow_geninfodetails_view($details_result,$gif_Code)
    {
                  global $commonUses;
                  $count=mysql_num_rows($details_result);
                  $c=0;
        while ($row_gifdetails=mysql_fetch_array($details_result))
        {
        ?>
        <?php
                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_gifdetails["gif_TaskCode"];
                            $lookupresult=@mysql_query($typequery);
                            $sub_query = mysql_fetch_array($lookupresult);
                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                            if($c==5) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
        ?>
            <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_gifdetails["gif_TaskCode"])); ?></td>
                    <td><?php if($row_gifdetails["gif_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_gifdetails["gif_TaskValue"])) ?></td>
                    </td>
            </tr>
            <?php
            $c++;
        }
        ?>
        <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
          <tr>
                <?php
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT i1.gif_Code,i2.gif_Notes, i2.gif_IndiaNotes FROM gif_pgeneralinfo AS i1 LEFT OUTER JOIN gif_pgeneralinfodetails AS i2 ON (i1.gif_Code = i2.gif_PGICode) where gif_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_notes = mysql_fetch_array($result);
                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                ?>
              <td><div style="float:left; width:374px;"><b>Notes</b></div></td><td><div style="width:331px;"><?php echo $row_notes['gif_Notes']; ?></div> </td>
         </tr>
         <tr>
             <tr><td><div style="float:left; width:374px;"><b>India Notes</b></div></td><td><div style="width:331px;"><?php echo $row_notes['gif_IndiaNotes']; ?></div></td></tr>
         </tr>
      <?php
      }
      // bank content
      function bank()
      {
                global $commonUses;
                global $access_file_level_ban;
                
                $cli_code=$_REQUEST['cli_code'];
                $recid=$_GET['recid'];
                $query = "SELECT * FROM  ban_pbank where ban_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_ban = mysql_fetch_assoc($result);
                $ban_Code=@mysql_result( $result,0,'ban_Code') ;
                $details_query = "SELECT * FROM ban_pbankdetails where ban_PBCode =".$ban_Code." order by ban_Code";
                $details_result=@mysql_query($details_query);
                if($_GET['a']=="edit")
                {
                      $this->showtableheader_ban($access_file_level_ban);
                         if($access_file_level_ban['stf_Add']=="Y" || $access_file_level_ban['stf_Edit']=="Y" || $access_file_level_ban['stf_Delete']=="Y")
                         {
                             if(mysql_num_rows($details_result)>0)
                             {
                                ?>
                                    <form  method="post" action="dbclass/perminfo_db_class.php"  >
                                <?php
                                            if ($_GET['a']=="edit")
                                            {
                                                if($access_file_level_ban['stf_Edit']=="Y")
                                                {
                                                    $this->showrow_bankdetails($details_result,$ban_Code,$access_file_level_ban,$cli_code,$recid);?>
                                                    <?php
                                                        $query = "SELECT i1.ban_Code,i2.ban_Notes, i2.ban_IndiaNotes FROM ban_pbank AS i1 LEFT OUTER JOIN ban_pbankdetails AS i2 ON (i1.ban_Code = i2.ban_PBCode) where ban_ClientCode =".$cli_code;
                                                        $result=@mysql_query($query);
                                                        $row_notes = mysql_fetch_array($result);
                                                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                    ?>
                                                        <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="ban_Notes" rows="3" cols="60" ><?php echo $row_notes['ban_Notes']; ?></textarea> </div></td></tr>
                                                        <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="ban_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['ban_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['ban_IndiaNotes']; ?> <input type="hidden" name="ban_IndiaNotes" value="<?php echo $row_notes['ban_IndiaNotes']; ?>"><?php } ?></div></td></tr>
                                                        <tr>
                                                            <td colspan="13"  >
                                                                <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                                <input type="hidden" name="xban_Code" value="<?php echo $ban_Code;?>">
                                                                <center>
                                                                <input type="submit" name="bankupdate" value="Update" class="detailsbutton"></center>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                     <?php
                                                      }
                                                      else if($access_file_level_ban['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Bank%')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                          $sql = "insert into `ban_pbankdetails` (`ban_PBCode`, `ban_TaskCode`) values (" .$ban_Code.", " .$trow['tsk_Code'].")";
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
                         if($access_file_level_ban['stf_View']=="Y")
                         {
                             $this->showtableheader_ban($access_file_level_ban);
                             $this->showrow_bankdetails_view($details_result,$ban_Code);
                                   echo "</table>";
                                  $this->showrow_bankFooter( $row_ban);
                         }
                          else if($access_file_level_ban['stf_View']=="N")
                          {
                                 echo "You are not authorised to view a record.";
                           }
                 }
      }
      // bank edit
        function showrow_bankdetails($details_result,$ban_Code,$access_file_level_ban,$cli_code,$recid)
        {
                  global $commonUses;
                  $count=mysql_num_rows($details_result);
                  $c=0;
                    while ($row_bandetails=mysql_fetch_array($details_result))
                    {
                        $tcode = $row_bandetails["ban_TaskCode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="ban_Code[<?php echo $tcode; ?>]" value="<?php echo $row_bandetails["ban_Code"];?>">
                        <input type="hidden" name="ban_PBCode[<?php echo $tcode; ?>]" value="<?php echo $row_bandetails["ban_PBCode"];?>">
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_bandetails["ban_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                          // echo "<td>".$tcode."</td>"
                        ?>
                        <tr id="bankList_<?php echo $tcode; ?>">
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_bandetails["ban_TaskCode"])); ?></td>
                        <td>
                        <?php
                        $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_bandetails["ban_TaskCode"];
                        $typeresult=@mysql_query($typequery);
                        $type_control = mysql_fetch_array($typeresult);
                            if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                            <input type="text" name="ban_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_bandetails["ban_TaskValue"])) ?>" size="30" disabled />
                            <?php
                            }
                        if($type_control["tsk_TypeofControl"]=="2") {
                        ?>
                            <select name="ban_TaskValue[<?php echo $tcode; ?>]" disabled>
                                <option value="">Select</option>
                                        <?php
                                            $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_bandetails["ban_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                          while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                          $val = $lp_row["tsk_Code"];
                                          $control = explode(",",$lp_row["tsk_LookupValues"]);
                                            for($i = 0; $i < count($control); $i++){
                                          if($row_bandetails["ban_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                         ?>
                                            <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                        <?php } } ?>
                            </select>
                                <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_bandetails["ban_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="ban_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBank(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" disabled />
                            <?php
                        if($row_bandetails["ban_TaskValue"]=="Y")
                        {
                                $taskCont .= "<script>
                                        enableBank(true,$tcode,$c);
                                        </script>";
                        }
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                            ?>
                            <textarea cols="30" rows="2" name="ban_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_bandetails["ban_TaskValue"])) ?></textarea>
                            <?php }
                        if($type_control["tsk_TypeofControl"]=="5") {
                                ?>
                                <?php
                                    if($row_bandetails["ban_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="ban_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBank(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" />
                            <?php
                        if($row_bandetails["ban_TaskValue"]=="Y")
                        {
                                $taskCont .= "<script>
                                        enableBank(true,$tcode,$c);
                                        </script>";
                        }
                        }
                        ?>
                        </td>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_bandetails["ban_TaskCode"].",";
                    }
                    $consolidated_ids = substr($consolidated_ids,0,-1);
                    ?>
                    <input type="hidden" name="ban_TaskCode" value="<?php echo $consolidated_ids;?>">
                     <?php
                        echo $taskCont;
       }
       // bank footer
       function showrow_bankFooter( $row_bank)
       {
            echo "<br><span class='footer'>Created by: ".$row_bank['ban_Createdby']." | ". "Created on: ".$row_bank['ban_Createdon']." | ". "Lastmodified by: ".$row_bank['ban_Lastmodifiedby']." | ". "Lastmodified on: ".$row_bank['ban_Lastmodifiedon']."</span>";
       }
       // bank header
       function showtableheader_ban($access_file_level_ban)
       {
        ?>
        <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                <tr class="fieldheader">
                <th width="149" class="fieldheader">Task Description</th>
                <th></th>
                </tr>
        <?php
        }
        // bank view
        function showrow_bankdetails_view($details_result,$ban_Code)
        {
                  global $commonUses;
                  $c=0;
             while ($row_bandetails=mysql_fetch_array($details_result))
            {
            ?>
            <?php
                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_bandetails["ban_TaskCode"];
                                $lookupresult=@mysql_query($typequery);
                                $sub_query = mysql_fetch_array($lookupresult);
                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
            ?>
                <tr>
                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_bandetails["ban_TaskCode"])); ?></td>
                <td><?php if($row_bandetails["ban_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_bandetails["ban_TaskValue"])) ?></td>
                </tr>
                <?php
                $c++;
             }
                ?>
                 <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                  <tr>
                <?php
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT i1.ban_Code,i2.ban_Notes, i2.ban_IndiaNotes FROM ban_pbank AS i1 LEFT OUTER JOIN ban_pbankdetails AS i2 ON (i1.ban_Code = i2.ban_PBCode) where ban_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_notes = mysql_fetch_array($result);
                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                ?>
                      <td><div style="float:left; width:323px;"><b>Notes</b></div></td><td><div style="width:300px;"><?php echo $row_notes['ban_Notes']; ?></div> </td>
                 </tr>
                     <tr><td><div style="float:left; width:323px;"><b>India Notes</b></div></td><td><div style="width:300px;"><?php echo $row_notes['ban_IndiaNotes']; ?></div></td></tr>
            <?php
            }
            // AR content
            function AR()
            {
                global $commonUses;
                global $access_file_level_are;
                
                $cli_code=$_REQUEST['cli_code'];
                $recid=$_GET['recid'];
                $query = "SELECT * FROM  are_paccountsreceivable where are_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_are = mysql_fetch_assoc($result);
                $are_Code=@mysql_result( $result,0,'are_Code') ;
                $details_query = "SELECT * FROM `are_paccountsreceivable details` where are_PARCode =".$are_Code." order by are_Code";
                $details_result=@mysql_query($details_query);
                if($_GET['a']=="edit")
                {
                       $this->showtableheader_are($access_file_level_are);
                       if($access_file_level_are['stf_Add']=="Y" || $access_file_level_are['stf_Edit']=="Y" || $access_file_level_are['stf_Delete']=="Y")
                       {
                           if(mysql_num_rows($details_result)>0)
                           {
                           ?>
                                <form  method="post" action="dbclass/perminfo_db_class.php"   >
                                                        <?php
                                        if ($_GET['a']=="edit")
                                        {
                                            if($access_file_level_are['stf_Edit']=="Y")
                                            {
                                                $this->showrow_ardetails($details_result,$are_Code,$access_file_level_are,$cli_code,$recid);?>
                                                <?php
                                                    $query = "SELECT i1.are_Code,i2.are_Notes, i2.are_IndiaNotes FROM are_paccountsreceivable AS i1 LEFT OUTER JOIN `are_paccountsreceivable details` AS i2 ON (i1.are_Code = i2.are_PARCode) where are_ClientCode =".$cli_code;
                                                    $result=@mysql_query($query);
                                                    $row_notes = mysql_fetch_array($result);
                                                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                ?>
                                                <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="are_Notes" rows="3" cols="60" ><?php echo $row_notes['are_Notes']; ?></textarea> </div></td></tr>
                                                <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="are_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['are_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['are_IndiaNotes']; ?> <input type="hidden" name="are_IndiaNotes" value="<?php echo $row_notes['are_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                <tr>
                                                    <td colspan="13"  >
                                                        <input type='hidden' name='sql' value='update'>			<input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                        <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                        <input type="hidden" name="xare_Code" value="<?php echo $are_Code;?>">
                                                        <center><input type="submit" name="ARupdate" value="Update" class="detailsbutton"></center>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                            }
                                            else if($access_file_level_are['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'AR')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                          $sql = "insert into `are_paccountsreceivable details` (`are_PARCode`, `are_TaskCode`) values (" .$are_Code.", " .$trow['tsk_Code'].")";
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
                         if($access_file_level_are['stf_View']=="Y")
                         {
                               $this->showtableheader_are($access_file_level_are);
                               $this->showrow_ardetails_view($details_result,$are_Code);
                               echo "</table>";
                               $this->showrow_arFooter( $row_are);
                         }
                         else if($access_file_level_are['stf_View']=="N")
                         {
                              echo "You are not authorised to view a record.";
                         }
                }
            }
            // AR edit
             function showrow_ardetails($details_result,$are_Code,$access_file_level_are,$cli_code,$recid)
             {
                      global $commonUses;
                      $count=mysql_num_rows($details_result);
                      $c=0;
                    while ($row_aredetails=mysql_fetch_array($details_result))
                    {
                            $tcode = $row_aredetails["are_TaskCode"];
                            ?>
                            <input type="hidden" name="count" value="<?php echo $count;?>">
                            <input type="hidden" name="are_Code[<?php echo $tcode; ?>]" value="<?php echo $row_aredetails["are_Code"];?>">
                            <input type="hidden" name="are_PARCode[<?php echo $tcode; ?>]" value="<?php echo $row_aredetails["are_PARCode"];?>">
                            <?php
                                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_aredetails["are_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                                $sub_query = mysql_fetch_array($lookupresult);
                                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==11) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==17) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==22) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==28) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==36) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                            ?>
                            <tr id="arList_<?php echo $tcode; ?>">
                                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_aredetails["are_TaskCode"])); ?></td>
                                    <td>
                                    <?php
                                    $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_aredetails["are_TaskCode"];
                                    $typeresult=@mysql_query($typequery);
                                    $type_control = mysql_fetch_array($typeresult);
                                        if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                        <input type="text" name="are_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_aredetails["are_TaskValue"])) ?>" size="30" />
                                        <?php
                                        }
                                    if($type_control["tsk_TypeofControl"]=="2") {
                                    ?>
                                        <select name="are_TaskValue[<?php echo $tcode; ?>]" />
                                            <option value="">Select</option>
                                                    <?php
                                                        $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_aredetails["are_TaskCode"];
                                                        $lookupresult=@mysql_query($typequery);
                                                      while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                      $val = $lp_row["tsk_Code"];
                                                      $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                        for($i = 0; $i < count($control); $i++){
                                                      if($row_aredetails["are_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                     ?>
                                                        <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                    <?php } } ?>
                                        </select>
                                            <?php
                                    }
                                    if($type_control["tsk_TypeofControl"]=="3") {
                                            ?>
                                            <?php
                                                if($row_aredetails["are_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                            ?>
                                        <input type="checkbox" name="are_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableAR(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" />
                                        <?php
                                    if($row_aredetails["are_TaskValue"]=="Y")
                                    {
                                            $taskCont .= "<script>
                                                    enableAR(true,$tcode,$c);
                                                    </script>";
                                    }
                                    }
                                    if($type_control["tsk_TypeofControl"]=="4") {
                                        ?>
                                        <textarea cols="30" rows="2" name="are_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_aredetails["are_TaskValue"])) ?></textarea>
                                        <?php }
                                    if($type_control["tsk_TypeofControl"]=="5") {
                                        ?>
                                        <input type="text" size="30" name="are_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_aredetails["are_TaskValue"])) ?>"id="emailText_<?php echo $tcode; ?>" style="display:none;">
                                        <?php }
                                    if($type_control["tsk_TypeofControl"]=="6") {
                                            ?>
                                            <?php
                                                if($row_aredetails["are_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                            ?>
                                        <input type="checkbox" name="are_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableAR(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                        <?php
                                    if($row_aredetails["are_TaskValue"]=="Y")
                                    {
                                            $taskCont .= "<script>
                                                    enableAR(true,$tcode,$c);
                                                    </script>";
                                    }
                                    }
                                    ?>
                                    </td>
                            </tr>
                            <?php
                            $c++;
                            $consolidated_ids .= $row_aredetails["are_TaskCode"].",";
                    }
                    $consolidated_ids = substr($consolidated_ids,0,-1);
                    ?>
                    <input type="hidden" name="are_TaskCode" value="<?php echo $consolidated_ids;?>">
                     <?php
                    echo $taskCont;
            }
            // AR footer
            function showrow_arFooter( $row_are)
            {
                    echo "<br><span class='footer'>Created by: ".$row_are['are_Createdby']." | ". "Created on: ".$row_are['are_Createdon']." | ". "Lastmodified by: ".$row_are['are_Lastmodifiedby']." | ". "Lastmodified on: ".$row_are['are_Lastmodifiedon']."</span>";
            }
            // AR header
            function showtableheader_are($access_file_level_are)
            {
            ?>
                <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="55%" >
                        <tr class="fieldheader">
                        <th width="149" class="fieldheader">Task Description</th>
                        <th></th>
                        </tr>
            <?php
            }
            // AR view
            function showrow_ardetails_view($details_result,$are_Code)
            {
                  global $commonUses;
                  $c=0;
                    while ($row_aredetails=mysql_fetch_array($details_result))
                    {
                    ?>
                    <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_aredetails["are_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==6) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==11) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==17) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==22) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==28) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                                if($c==36) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                        
                    ?>
                        <tr>
                            <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_aredetails["are_TaskCode"])); ?></td>
                            <td><?php  if($row_aredetails["are_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_aredetails["are_TaskValue"])) ?></td>
                        </tr>
                        <?php
                        $c++;
                    }
                    ?>
                     <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                     <tr>
                        <?php
                        $cli_code=$_REQUEST['cli_code'];
                        $query = "SELECT i1.are_Code,i2.are_Notes, i2.are_IndiaNotes FROM are_paccountsreceivable AS i1 LEFT OUTER JOIN `are_paccountsreceivable details` AS i2 ON (i1.are_Code = i2.are_PARCode) where are_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                        ?>
                          <td><div style="float:left; width:258px;"><b>Notes</b></div></td><td><div style="width:226px;"><?php echo $row_notes['are_Notes']; ?></div> </td>
                     </tr>
                     <tr><td><div style="float:left; width:258px;"><b>India Notes</b></div></td><td><div style="width:226px;"><?php echo $row_notes['are_IndiaNotes']; ?></div></td></tr>
            <?php
            }
            // AP content
            function AP()
            {
                    global $commonUses;
                    global $access_file_level_ape;
                    
                    $cli_code=$_REQUEST['cli_code'];
                    $recid=$_GET['recid'];
                    $query = "SELECT * FROM  ape_paccountspayable where ape_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_ape = mysql_fetch_assoc($result);
                    $ape_Code=@mysql_result( $result,0,'ape_Code') ;
                    $details_query = "SELECT * FROM `ape_paccountspayabledetails` where ape_PARCode =".$ape_Code." order by ape_Code";
                    $details_result=@mysql_query($details_query);
                     if($_GET['a']=="edit")
                     {
                             $this->showtableheader_ape($access_file_level_ape);
                             if($access_file_level_ape['stf_Add']=="Y" || $access_file_level_ape['stf_Edit']=="Y" || $access_file_level_ape['stf_Delete']=="Y")
                             {
                                 if(mysql_num_rows($details_result)>0)
                                 {
                                 ?>
                                    <form  method="post" action="dbclass/perminfo_db_class.php" >
                                       <?php
                                        if ($_GET['a']=="edit")
                                        {
                                            if($access_file_level_ape['stf_Edit']=="Y")
                                            {
                                                $this->showrow_apdetails($details_result,$ape_Code,$access_file_level_ape,$cli_code,$recid);
                                                $query = "SELECT i1.ape_Code,i2.ape_Notes, i2.ape_IndiaNotes FROM ape_paccountspayable AS i1 LEFT OUTER JOIN ape_paccountspayabledetails AS i2 ON (i1.ape_Code = i2.ape_PARCode) where ape_ClientCode =".$cli_code;
                                                $result=@mysql_query($query);
                                                $row_notes = mysql_fetch_array($result);
                                                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                ?>
                                                    <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="ape_Notes" rows="3" cols="60" ><?php echo $row_notes['ape_Notes']; ?></textarea> </div></td></tr>
                                                    <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="ape_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['ape_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['ape_IndiaNotes']; ?> <input type="hidden" name="ape_IndiaNotes" value="<?php echo $row_notes['ape_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                    <tr><td colspan="13"  >
                                                    <input type='hidden' name='sql' value='update'>			<input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                    <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                    <input type="hidden" name="xape_Code" value="<?php echo $ape_Code;?>">
                                                    <center><input type="submit" name="APupdate" value="Update" class="detailsbutton"></center>
                                                    </td></tr>
                                                </table>
                                             <?php
                                             }
                                             else if($access_file_level_ape['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'AP')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                           $sql = "insert into `ape_paccountspayabledetails` (`ape_PARCode`, `ape_TaskCode`) values (" .$ape_Code.", " .$trow['tsk_Code'].")";
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
                             if($access_file_level_ape['stf_View']=="Y")
                             {
                                       $this->showtableheader_ape($access_file_level_ape);
                                       $this->showrow_apdetails_view($details_result,$ape_Code);
                                       echo "</table>";
                                       $this->showrow_apFooter( $row_ape);
                             }
                             else if($access_file_level_ape['stf_View']=="N")
                             {
                                 echo "You are not authorised to view a record.";
                             }
                    }
            }
            // AP edit
            function showrow_apdetails($details_result,$ape_Code,$access_file_level_ape,$cli_code,$recid)
            {
                      global $commonUses;
                      $count=mysql_num_rows($details_result);
                      $c=0;
                        while ($row_apedetails=mysql_fetch_array($details_result))
                        {
                                $tcode = $row_apedetails["ape_TaskCode"];
                                ?>
                                <input type="hidden" name="count" value="<?php echo $count;?>">
                                <input type="hidden" name="ape_Code[<?php echo $tcode; ?>]" value="<?php echo $row_apedetails["ape_Code"];?>">
                                <input type="hidden" name="ape_PARCode[<?php echo $tcode; ?>]" value="<?php echo $row_apedetails["ape_PARCode"];?>">
                                <?php
                                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_apedetails["ape_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                    $sub_query = mysql_fetch_array($lookupresult);
                                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'><b style='font-size:14px;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                ?>
                                <tr id="apList_<?php echo $tcode; ?>">
                                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_apedetails["ape_TaskCode"])); ?></td>
                                <td>
                                <?php
                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_apedetails["ape_TaskCode"];
                                $typeresult=@mysql_query($typequery);
                                $type_control = mysql_fetch_array($typeresult);
                                    if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                    <input type="text" name="ape_TaskValue[]" value="<?php echo str_replace('"', '&quot;', trim($row_apedetails["ape_TaskValue"])) ?>" size="30" disabled>
                                    <?php
                                    }
                                if($type_control["tsk_TypeofControl"]=="2") {
                                ?>
                                    <select name="ape_TaskValue[<?php echo $tcode; ?>]" disabled>
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_apedetails["ape_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                  if($row_apedetails["ape_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select>
                                        <?php
                                }
                                if($type_control["tsk_TypeofControl"]=="3") {
                                        ?>
                                        <?php
                                            if($row_apedetails["ape_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>
                                    <input type="checkbox" name="ape_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableAP(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" disabled>
                                    <?php
                                    if($row_apedetails["ape_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enableAP(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                if($type_control["tsk_TypeofControl"]=="4") {
                                    ?>
                                    <textarea cols="30" rows="2" name="ape_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_apedetails["ape_TaskValue"])) ?></textarea>
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="5") {
                                    ?>
                                    <input type="text" size="30" name="ape_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_apedetails["ape_TaskValue"])) ?>" id="splAcc_<?php echo $tcode; ?>" style="display:none;">
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="6") {
                                    ?>
                                    <select name="ape_TaskValue[<?php echo $tcode; ?>]" style="display:none;" id="cycle_<?php echo $tcode; ?>">
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_apedetails["ape_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                  if($row_apedetails["ape_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select>
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="7") {
                                        ?>
                                        <?php
                                            if($row_apedetails["ape_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>

                                    <input type="checkbox" name="ape_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableAP(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                    <?php
                                    if($row_apedetails["ape_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enableAP(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                ?>
                                </td>
                                </tr>
                                <?php
                                $c++;
                                $consolidated_ids .= $row_apedetails["ape_TaskCode"].",";
                        }
                        $consolidated_ids = substr($consolidated_ids,0,-1);
                        ?>
                        <input type="hidden" name="ape_TaskCode" value="<?php echo $consolidated_ids;?>">
                         <?php
                         echo $taskCont;
             }
             //AP footer
            function showrow_apFooter($row_ape)
            {
                    echo "<br><span class='footer'>Created by: ".$row_ape['ape_Createdby']." | ". "Created on: ".$row_ape['ape_Createdon']." | ". "Lastmodified by: ".$row_ape['ape_Lastmodifiedby']." | ". "Lastmodified on: ".$row_ape['ape_Lastmodifiedon']."</span>";
            }
            // AP header
            function showtableheader_ape($access_file_level_ape)
            {
            ?>
                <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                        <tr class="fieldheader">
                        <th class="fieldheader">Task Description</th>
                        <th></th>
                        </tr>
            <?php
            }
            // AP view
            function showrow_apdetails_view($details_result,$ape_Code)
            {
                   global $commonUses;
                   $c=0;
                    while ($row_apedetails=mysql_fetch_array($details_result))
                    {
                    ?>
                    <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_apedetails["ape_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                    ?>
                        <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_apedetails["ape_TaskCode"])); ?></td>
                        <td><?php if($row_apedetails["ape_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_apedetails["ape_TaskValue"])) ?></td>
                        </tr>
                        <?php
                        $c++;
                    }
                    ?>
                     <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                      <tr>
                    <?php
                    $cli_code=$_REQUEST['cli_code'];
                    $query = "SELECT i1.ape_Code,i2.ape_Notes, i2.ape_IndiaNotes FROM ape_paccountspayable AS i1 LEFT OUTER JOIN ape_paccountspayabledetails AS i2 ON (i1.ape_Code = i2.ape_PARCode) where ape_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_notes = mysql_fetch_array($result);
                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                    ?>
                          <td><div style="float:left; width:442px;"><b>Notes</b></div></td><td><div style="width:264px;"><?php echo $row_notes['ape_Notes']; ?></div> </td>
                     </tr>
                     <tr><td><div style="float:left; width:442px;"><b>India Notes</b></div></td><td><div style="width:264px;"><?php echo $row_notes['ape_IndiaNotes']; ?></div></td></tr>
            <?php
            }
            // Payroll content
            function payroll()
            {
                    global $commonUses;
                    global $access_file_level_pay;
                    
                    $cli_code=$_REQUEST['cli_code'];
                    $recid=$_GET['recid'];
                    $query = "SELECT * FROM  pay_ppayroll where pay_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_pay = mysql_fetch_assoc($result);
                    $pay_Code=@mysql_result( $result,0,'pay_Code') ;
                    $details_query = "SELECT * FROM `pay_ppayrolldetails` where pay_PPRCode =".$pay_Code." order by pay_Code";
                    $details_result=@mysql_query($details_query);
                    if($_GET['a']=="edit")
                    {
                             $this->showtableheader_pay($access_file_level_pay);
                             if($access_file_level_pay['stf_Add']=="Y" || $access_file_level_pay['stf_Edit']=="Y" || $access_file_level_pay['stf_Delete']=="Y")
                             {
                                 if(mysql_num_rows($details_result)>0)
                                 {
                                    ?>
                                    <form   method="post" action="dbclass/perminfo_db_class.php"   >
                                        <?php
                                        if ($_GET['a']=="edit")
                                        {
                                        if($access_file_level_pay['stf_Edit']=="Y")
                                        {
                                            $this->showrow_payrolldetails($details_result,$pay_Code,$access_file_level_pay,$cli_code,$recid);
                                            $query = "SELECT i1.pay_Code,i2.pay_Notes, i2.pay_IndiaNotes FROM pay_ppayroll AS i1 LEFT OUTER JOIN pay_ppayrolldetails AS i2 ON (i1.pay_Code = i2.pay_PPRCode) where pay_ClientCode =".$cli_code;
                                            $result=@mysql_query($query);
                                            $row_notes = mysql_fetch_array($result);
                                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                                ?>
                                            <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="pay_Notes" rows="3" cols="60" ><?php echo $row_notes['pay_Notes']; ?></textarea> </div></td></tr>
                                            <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="pay_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['pay_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['pay_IndiaNotes']; ?> <input type="hidden" name="pay_IndiaNotes" value="<?php echo $row_notes['pay_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                            <tr>
                                                <td colspan="13"  >
                                                <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                <input type="hidden" name="xpay_Code" value="<?php echo $pay_Code;?>">
                                                <center><input type="submit" name="payroll" value="Update" class="detailsbutton"></center>
                                                </td>
                                            </tr>
                                        </table>
                                         <?php
                                         }
                                         else if($access_file_level_pay['stf_Edit']=="N")
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
                                                        $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Payroll%')";
                                                        $tresult=@mysql_query($tquery);
                                                        $tcount=mysql_num_rows($tresult);
                                                                if($tcount>0)
                                                                {
                                                                        //Insert all tasks in details table for this client
                                                                        while($trow=@mysql_fetch_array($tresult))
                                                                        {
                                                                          $sql = "insert into `pay_ppayrolldetails` (`pay_PPRCode`, `pay_TaskCode`) values (" .$pay_Code.", " .$trow['tsk_Code'].")";
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
                             if($access_file_level_pay['stf_View']=="Y")
                             {
                                       $this->showtableheader_pay($access_file_level_pay);
                                       $this->showrow_payrolldetails_view($details_result,$pay_Code);
                                       echo "</table>";
                                       $this->showrow_payrollFooter( $row_pay);
                             }
                             else if($access_file_level_pay['stf_View']=="N")
                             {
                                  echo "You are not authorised to view a record.";
                             }
                    }
            }
            // payroll edit
             function showrow_payrolldetails($details_result,$pay_Code,$access_file_level_pay,$cli_code,$recid)
             {
                      global $commonUses;
                      $count=mysql_num_rows($details_result);
                      $c=0;
                        while ($row_paydetails=mysql_fetch_array($details_result))
                        {
                                $tcode = $row_paydetails["pay_TaskCode"];
                                ?>
                                <input type="hidden" name="count" value="<?php echo $count;?>">
                                <input type="hidden" name="pay_Code[<?php echo $tcode; ?>]" value="<?php echo $row_paydetails["pay_Code"];?>">
                                <input type="hidden" name="pay_PPRCode[<?php echo $tcode; ?>]" value="<?php echo $row_paydetails["pay_PPRCode"];?>">
                                <?php
                                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_paydetails["pay_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                    $sub_query = mysql_fetch_array($lookupresult);
                                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                                ?>
                                <tr id="payRoll_<?php echo $tcode; ?>">
                                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_paydetails["pay_TaskCode"])); ?></td>
                                <td>
                                <?php
                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_paydetails["pay_TaskCode"];
                                $typeresult=@mysql_query($typequery);
                                $type_control = mysql_fetch_array($typeresult);
                                    if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                    <input type="text" name="pay_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_paydetails["pay_TaskValue"])) ?>" size="30" disabled>
                                    <?php
                                    }
                                if($type_control["tsk_TypeofControl"]=="2") {
                                ?>
                                    <select name="pay_TaskValue[<?php echo $tcode; ?>]" disabled>
                                        <option value="">Select</option>
                                                <?php
                                                    $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_paydetails["pay_TaskCode"];
                                                    $lookupresult=@mysql_query($typequery);
                                                  while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                                  $val = $lp_row["tsk_Code"];
                                                  $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                    for($i = 0; $i < count($control); $i++){
                                                  if($row_paydetails["pay_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                                 ?>
                                                    <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                                <?php } } ?>
                                    </select>
                                        <?php
                                }
                                if($type_control["tsk_TypeofControl"]=="3") {
                                        ?>
                                        <?php
                                            if($row_paydetails["pay_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>
                                    <input type="checkbox" name="pay_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" disabled>
                                    <?php
                                    if($row_paydetails["pay_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enablePayroll(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                if($type_control["tsk_TypeofControl"]=="4") {
                                    ?>
                                    <textarea cols="30" rows="2" name="pay_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_paydetails["pay_TaskValue"])) ?></textarea>
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="5") {
                                    ?>
                                    <a>From Day / date:</a>&nbsp;<input type="text" size="20" name="pay_TaskValue[<?php echo $tcode; ?>]" value="<?php $fdate = explode("~",$row_paydetails["pay_TaskValue"]); echo $fdate[0]; ?>" disabled>&nbsp;&nbsp;&nbsp;<a>To Day / date:&nbsp;</a><input type="text" size="20" name="todate_Value[<?php echo $tcode; ?>]" value="<?php echo $fdate[1]; ?>" disabled>
                                    <?php }
                                if($type_control["tsk_TypeofControl"]=="6") {
                                        ?>
                                        <?php
                                            if($row_paydetails["pay_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                        ?>
                                    <input type="checkbox" name="pay_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                    <?php
                                    if($row_paydetails["pay_TaskValue"]=="Y")
                                    {
                                        $taskCont .= "<script>
                                                enablePayroll(true,$tcode,$c);
                                                </script>";
                                    }
                                }
                                ?>
                                </td>
                                </tr>
                                <?php
                                $c++;
                                $consolidated_ids .= $row_paydetails["pay_TaskCode"].",";
                        }
                        $consolidated_ids = substr($consolidated_ids,0,-1);
                        ?>
                        <input type="hidden" name="pay_TaskCode" value="<?php echo $consolidated_ids;?>">
                         <?php
                        echo $taskCont;
            }
            // payroll fotter
            function showrow_payrollFooter( $row_pay)
            {
                echo "<br><span class='footer'>Created by: ".$row_pay['pay_Createdby']." | ". "Created on: ".$row_pay['pay_Createdon']." | ". "Lastmodified by: ".$row_pay['pay_Lastmodifiedby']." | ". "Lastmodified on: ".$row_pay['pay_Lastmodifiedon']."</span>";
            }
            // payroll header
            function showtableheader_pay($access_file_level_pay)
            {
            ?>
                <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="100%" >
                        <tr class="fieldheader">
                        <th class="fieldheader">Task Description</th>
                        <th></th>
                        </tr>
            <?php
            }
            // payroll view
            function showrow_payrolldetails_view($details_result,$pay_Code)
            {
                   global $commonUses;
                   $c=0;
                    while ($row_paydetails=mysql_fetch_array($details_result))
                    {
                    ?>
                    <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_paydetails["pay_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'><b style='font-size:14px;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                    ?>
                        <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_paydetails["pay_TaskCode"])); ?></td>
                        <td><?php if($row_paydetails["pay_TaskValue"]=="Y") echo "Yes"; else { $tVal = explode("~",$row_paydetails["pay_TaskValue"]); if(count($tVal)>1) { echo "From date : ".$tVal[0]; echo "<br>  To date : ".$tVal[1]; } else { echo $tVal[0]; } } ?></td>
                        </tr>
                        <?php
                        $c++;
                    }
                    ?>
                     <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                      <tr>
                    <?php
                    $cli_code=$_REQUEST['cli_code'];
                    $query = "SELECT i1.pay_Code,i2.pay_Notes, i2.pay_IndiaNotes FROM pay_ppayroll AS i1 LEFT OUTER JOIN pay_ppayrolldetails AS i2 ON (i1.pay_Code = i2.pay_PPRCode) where pay_ClientCode =".$cli_code;
                    $result=@mysql_query($query);
                    $row_notes = mysql_fetch_array($result);
                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                    ?>
                       <td><div style="float:left; width:371px;"><b>Notes</b></div></td><td><div style="width:334px;"><?php echo $row_notes['pay_Notes']; ?></div> </td>
                     </tr>
                     <tr><td><div style="float:left; width:371px;"><b>India Notes</b></div></td><td><div style="width:334px;"><?php echo $row_notes['pay_IndiaNotes']; ?></div></td></tr>
            <?php
            }

}
	$permgeneralContent = new permgeneralContentList();
?>

