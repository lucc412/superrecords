<?php
class permbasContentList extends Database
{
    // BAS content
    function BAS()
    {
            global $commonUses;
            global $access_file_level_bas;
            
            $cli_code=$_REQUEST['cli_code'];
            $recid=$_GET['recid'];
            $query = "SELECT * FROM bas_bankaccount where bas_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_cst = mysql_fetch_assoc($result);
            $bas_Code=@mysql_result( $result,0,'bas_Code') ;
            $details_query = "SELECT * FROM bas_bankaccountdetails where bas_BASCode =".$bas_Code." order by bas_Code";
            $details_result=@mysql_query($details_query);
            if($_GET['a']=="edit")
            {
                    $this->showtableheader_bas($access_file_level_bas);
                    if($access_file_level_bas['stf_Add']=="Y" || $access_file_level_bas['stf_Edit']=="Y" || $access_file_level_bas['stf_Delete']=="Y")
                    {
                         if(mysql_num_rows($details_result)>0)
                         {
                         ?>
                              <form name="basedit" method="post" action="dbclass/perminfo_db_class.php" >
                                    <?php
                                    if ($_GET['a']=="edit")
                                    {
                                        if($access_file_level_bas['stf_Edit']=="Y")
                                        {
                                            $this->showrow_basdetails($details_result,$bas_Code,$access_file_level_bas,$cli_code,$recid);
                                        ?>
                                        <?php
                                                $query = "SELECT i1.bas_Code,i2.bas_Notes, i2.bas_IndiaNotes FROM bas_bankaccount AS i1 LEFT OUTER JOIN bas_bankaccountdetails AS i2 ON (i1.bas_Code = i2.bas_BASCode) where bas_ClientCode =".$cli_code;
                                                $result=@mysql_query($query);
                                                $row_notes = mysql_fetch_array($result);
                                                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                                    ?>
                                                <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="bas_Notes" rows="3" cols="60" ><?php echo $row_notes['bas_Notes']; ?></textarea> </div></td></tr>
                                                <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="bas_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['bas_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['bas_IndiaNotes']; ?> <input type="hidden" name="bas_IndiaNotes" value="<?php echo $row_notes['bas_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                <tr><td colspan="13"  >
                                                    <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                    <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                    <input type="hidden" name="xbas_Code" value="<?php echo $bas_Code;?>">
                                                    <center><input type="submit" name="BAS" value="Update" class="detailsbutton"></center>
                                                    </td>
                                                </tr>
                                            </table>
                                         <?php
                                         }
                                         else if($access_file_level_bas['stf_Edit']=="N")
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
                                                $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'BAS%')";
                                                $tresult=@mysql_query($tquery);
                                                $tcount=mysql_num_rows($tresult);
                                                        if($tcount>0)
                                                        {
                                                                //Insert all tasks in details table for this client
                                                                while($trow=@mysql_fetch_array($tresult))
                                                                {
                                                                  $sql = "insert into `bas_bankaccountdetails` (`bas_BASCode`, `bas_TaskCode`) values (" .$bas_Code.", " .$trow['tsk_Code'].")";
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
                 if($access_file_level_bas['stf_View']=="Y")
                 {
                           $this->showtableheader_bas($access_file_level_bas);
                           $this->showrow_basdetails_view($details_result,$emh_Code);
                           echo "</table>";
                           $this->showrow_basFooter($row_cst);
                 }
                 else if($access_file_level_bas['stf_View']=="N")
                 {
                     echo "You are not authorised to view a record.";
                 }
           }
    }
    // BAS edit
    function showrow_basdetails($details_result,$bas_Code,$access_file_level_bas,$cli_code,$recid)
    {
              global $commonUses;
              $count=mysql_num_rows($details_result);
              $c=0;
                while ($row_cstdetails=mysql_fetch_array($details_result))
                {
                        $tcode = $row_cstdetails["bas_TaskCode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="bas_Code[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["bas_Code"];?>">
                        <input type="hidden" name="bas_BASCode[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["bas_BASCode"];?>">
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_cstdetails["bas_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                        <tr id="basList_<?php echo $tcode; ?>">
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_cstdetails["bas_TaskCode"])); ?></td>
                        <td>
                        <?php
                        $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_cstdetails["bas_TaskCode"];
                        $typeresult=@mysql_query($typequery);
                        $type_control = mysql_fetch_array($typeresult);
                            if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                            <input type="text" name="bas_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["bas_TaskValue"])) ?>" />
                            <?php
                            }
                        if($type_control["tsk_TypeofControl"]=="2") {
                        ?>
                            <select name="bas_TaskValue[<?php echo $tcode; ?>]">
                                <option value="">Select</option>
                                        <?php
                                            $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_cstdetails["bas_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                          while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                          $val = $lp_row["tsk_Code"];
                                          $control = explode(",",$lp_row["tsk_LookupValues"]);
                                            for($i = 0; $i < count($control); $i++){
                                          if($row_cstdetails["bas_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                         ?>
                                            <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                        <?php } } ?>
                            </select>
                                <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_cstdetails["bas_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="bas_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBas(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)" />
                            <?php
                            if($row_cstdetails["bas_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enableBas(true,$tcode,$c);
                                        </script>";
                            }
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                            ?>
                            <textarea cols="20" rows="2" name="bas_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;"><?php echo str_replace('"', '&quot;', trim($row_cstdetails["bas_TaskValue"])) ?></textarea>
                            <?php }
                        if($type_control["tsk_TypeofControl"]=="5") {
                                ?>
                                <?php
                                    if($row_cstdetails["bas_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="bas_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableBas(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                            <?php
                            if($row_cstdetails["bas_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enableBas(true,$tcode,$c);
                                        </script>";
                            }
                        }
                        ?>
                        </td>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_cstdetails["bas_TaskCode"].",";
                }
                $consolidated_ids = substr($consolidated_ids,0,-1);
                ?>
                <input type="hidden" name="bas_TaskCode" value="<?php echo $consolidated_ids;?>">
                 <?php
                 echo $taskCont;
     }
     // BAS footer
    function showrow_basFooter( $row_cursts)
    {
        echo "<br><span class='footer'>Created by: ".$row_cursts['bas_Createdby']." | ". "Created on: ".$row_cursts['bas_Createdon']." | ". "Lastmodified by: ".$row_cursts['bas_Lastmodifiedby']." | ". "Lastmodified on: ".$row_cursts['bas_Lastmodifiedon']."</span>";
    }
    // BAS header
    function showtableheader_bas($access_file_level_bas)
    {
    ?>
        <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                <tr class="fieldheader">
                <th class="fieldheader">Task Description</th>
                <th class="fieldheader"></th>
                </tr>
    <?php
    }
    // BAS view
    function  showrow_basdetails_view($details_result,$set_Code)
    {
            global $commonUses;
            $c=0;
            while ($row_curdetails=mysql_fetch_array($details_result))
            {
            ?>
            <?php
                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_curdetails["bas_TaskCode"];
                                $lookupresult=@mysql_query($typequery);
                                $sub_query = mysql_fetch_array($lookupresult);
                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
            ?>
                <tr>
                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_curdetails["bas_TaskCode"])); ?></td>
                <td><?php if($row_curdetails["bas_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_curdetails["bas_TaskValue"])) ?></td>
                </tr>
                <?php
                $c++;
            }
            ?>
             <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
              <tr>
            <?php
            $cli_code=$_REQUEST['cli_code'];
            $query = "SELECT i1.bas_Code,i2.bas_Notes, i2.bas_IndiaNotes FROM bas_bankaccount AS i1 LEFT OUTER JOIN bas_bankaccountdetails AS i2 ON (i1.bas_Code = i2.bas_BASCode) where bas_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $ind_id = $commonUses->getIndiamanagerId($cli_code);
            ?>
                  <td><div style="float:left; width:290px;"><b>Notes</b></div></td><td><div style="width:332px;"><?php echo $row_notes['bas_Notes']; ?></div> </td>
             </tr>
             <tr><td><div style="float:left; width:290px;"><b>India Notes</b></div></td><td><div style="width:332px;"><?php echo $row_notes['bas_IndiaNotes']; ?></div></td></tr>
    <?php
    }
    // Tax return content
    function taxReturn()
    {
        global $commonUses;
        global $access_file_level_tax;

        $cli_code=$_REQUEST['cli_code'];
        $recid=$_GET['recid'];
        $query = "SELECT * FROM  tar_ptaxreturns where tar_ClientCode =".$cli_code;
        $result=@mysql_query($query);
        $row_tar = mysql_fetch_assoc($result);
        $tar_Code=@mysql_result( $result,0,'tar_Code') ;
        $details_query = "SELECT * FROM `tar_ptaxreturnsdetails` where tar_PTRCode =".$tar_Code." order by tar_Code";
        $details_result=@mysql_query($details_query);
        if($_GET['a']=="edit")
        {
                 $this->showtableheader_tax($access_file_level_tax);
                 if($access_file_level_tax['stf_Add']=="Y" || $access_file_level_tax['stf_Edit']=="Y" || $access_file_level_tax['stf_Delete']=="Y")
                 {
                     if(mysql_num_rows($details_result)>0)
                     {
                      ?>
                            <form  method="post" action="dbclass/perminfo_db_class.php" >
                                <?php
                                if ($_GET['a']=="edit")
                                {
                                    if($access_file_level_tax['stf_Edit']=="Y")
                                    {
                                        $this->showrow_taxreturnsdetails($details_result,$tar_Code,$access_file_level_tax,$cli_code,$recid);
                                        $query = "SELECT i1.tar_Code,i2.tar_Notes, i2.tar_IndiaNotes FROM tar_ptaxreturns AS i1 LEFT OUTER JOIN tar_ptaxreturnsdetails AS i2 ON (i1.tar_Code = i2.tar_PTRCode) where tar_ClientCode =".$cli_code;
                                        $result=@mysql_query($query);
                                        $row_notes = mysql_fetch_array($result);
                                        $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                        ?>
                                        <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="tar_Notes" rows="3" cols="60" ><?php echo $row_notes['tar_Notes']; ?></textarea> </div></td></tr>
                                        <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="tar_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['tar_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['tar_IndiaNotes']; ?> <input type="hidden" name="tar_IndiaNotes" value="<?php echo $row_notes['tar_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                         <tr>
                                                <td colspan="13"  >
                                                    <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                    <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                    <input type="hidden" name="xtar_Code" value="<?php echo $tar_Code;?>">
                                                    <center><input type="submit" name="tax" value="Update" class="detailsbutton"></center>
                                                </td>
                                         </tr>
                                    </table>
                                    <?php
                                     }
                                     else if($access_file_level_tax['stf_Edit']=="N")
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
                                            $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Tax Returns%')";
                                            $tresult=@mysql_query($tquery);
                                            $tcount=mysql_num_rows($tresult);
                                                    if($tcount>0)
                                                    {
                                                            //Insert all tasks in details table for this client
                                                            while($trow=@mysql_fetch_array($tresult))
                                                            {
                                                              $sql = "insert into `tar_ptaxreturnsdetails` (`tar_PTRCode`, `tar_TaskCode`) values (" .$tar_Code.", " .$trow['tsk_Code'].")";
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
                 if($access_file_level_tax['stf_View']=="Y")
                 {
                           $this->showtableheader_tax($access_file_level_tax);
                           $this->showrow_taxreturnsdetails_view($details_result,$tar_Code);
                           echo "</table>";
                           $this->showrow_taxreturnsFooter( $row_tar);
                 }
                 else if($access_file_level_tax['stf_View']=="N")
                 {
                      echo "You are not authorised to view a record.";
                 }
         }
    }
    // Tax return edit
     function showrow_taxreturnsdetails($details_result,$tar_Code,$access_file_level_tax,$cli_code,$recid)
     {
              global $commonUses;
              $count=mysql_num_rows($details_result);
              $c=0;
                    while ($row_tardetails=mysql_fetch_array($details_result))
                    {
                            $tcode = $row_tardetails["tar_TaskCode"];
                            ?>
                            <input type="hidden" name="count" value="<?php echo $count;?>">
                            <input type="hidden" name="tar_Code[<?php echo $tcode; ?>]" value="<?php echo $row_tardetails["tar_Code"];?>">
                            <input type="hidden" name="tar_PTRCode[<?php echo $tcode; ?>]" value="<?php echo $row_tardetails["tar_PTRCode"];?>">
                            <?php
                                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_tardetails["tar_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                                $sub_query = mysql_fetch_array($lookupresult);
                                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                            ?>
                            <tr id="taxReturn_<?php echo $tcode; ?>">
                            <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_tardetails["tar_TaskCode"])); ?></td>
                            <td>
                                <?php
                            $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_tardetails["tar_TaskCode"];
                            $typeresult=@mysql_query($typequery);
                            $type_control = mysql_fetch_array($typeresult);

                                if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                <input type="text" name="tar_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_tardetails["tar_TaskValue"])) ?>" size="30" />
                                <?php
                                }
                            if($type_control["tsk_TypeofControl"]=="2") {
                            ?>
                                <select name="tar_TaskValue[<?php echo $tcode; ?>]" />
                                    <option value="">Select</option>
                                            <?php
                                                $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_tardetails["tar_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                              while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                              $val = $lp_row["tsk_Code"];
                                              $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                for($i = 0; $i < count($control); $i++){
                                              if($row_tardetails["tar_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                             ?>
                                                <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                            <?php } } ?>
                                </select>
                                    <?php
                            }
                            if($type_control["tsk_TypeofControl"]=="3") {
                                    ?>
                                    <?php
                                        if($row_tardetails["tar_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                    ?>
                                <input type="checkbox" name="tar_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableTax(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)"/>
                                <?php
                                if($row_tardetails["tar_TaskValue"]=="Y")
                                {
                                    $taskCont .= "<script>
                                            enableTax(true,$tcode,$c);
                                            </script>";
                                }
                            }
                            if($type_control["tsk_TypeofControl"]=="4") {
                                ?>
                                <textarea cols="30" rows="2" name="tar_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_tardetails["tar_TaskValue"])) ?></textarea>
                                <?php }
                            if($type_control["tsk_TypeofControl"]=="5") {
                                    ?>
                                    <?php
                                        if($row_tardetails["tar_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                    ?>

                                <input type="checkbox" name="tar_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableTax(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                                <?php
                                if($row_tardetails["tar_TaskValue"]=="Y")
                                {
                                    $taskCont .= "<script>
                                            enableTax(true,$tcode,$c);
                                            </script>";
                                }
                            }
                            ?>
                            </td>
                            </tr>
                            <?php
                            $c++;
                            $consolidated_ids .= $row_tardetails["tar_TaskCode"].",";
                    }
                    $consolidated_ids = substr($consolidated_ids,0,-1);
                    ?>
                    <input type="hidden" name="tar_TaskCode" value="<?php echo $consolidated_ids;?>">
                    <?php
                    echo $taskCont;
       }
       // Tax return Footer
       function showrow_taxreturnsFooter( $row_tar)
        {
            echo "<br><span class='footer'>Created by: ".$row_tar['tar_Createdby']." | ". "Created on: ".$row_tar['tar_Createdon']." | ". "Lastmodified by: ".$row_tar['tar_Lastmodifiedby']." | ". "Lastmodified on: ".$row_tar['tar_Lastmodifiedon']."</span>";
        }
        // Tax return header
      function showtableheader_tax($access_file_level_tax)
      {
        ?>
            <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                    <tr class="fieldheader">
                    <th class="fieldheader">Task Description</th>
                    <th></th>
                    </tr>
    <?php
    }
    // Tax return view
     function showrow_taxreturnsdetails_view($details_result,$tar_Code)
     {
          global $commonUses;
          $c=0;
             while ($row_tardetails=mysql_fetch_array($details_result))
            {
            ?>
            <?php
                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_tardetails["tar_TaskCode"];
                                $lookupresult=@mysql_query($typequery);
                                $sub_query = mysql_fetch_array($lookupresult);
                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
            ?>
                 <tr>
                <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_tardetails["tar_TaskCode"])); ?></td>
                <td><?php if($row_tardetails["tar_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_tardetails["tar_TaskValue"])) ?></td>
                </tr>
                <?php
                $c++;
            } ?>
             <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
              <tr>
            <?php
            $cli_code=$_REQUEST['cli_code'];
            $query = "SELECT i1.tar_Code,i2.tar_Notes, i2.tar_IndiaNotes FROM tar_ptaxreturns AS i1 LEFT OUTER JOIN tar_ptaxreturnsdetails AS i2 ON (i1.tar_Code = i2.tar_PTRCode) where tar_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $ind_id = $commonUses->getIndiamanagerId($cli_code);
            ?>
                  <td><div style="float:left; width:294px;"><b>Notes</b></div></td><td><div style="width:328px;"><?php echo $row_notes['tar_Notes']; ?></div> </td>
             </tr>
             <tr><td><div style="float:left; width:294px;"><b>India Notes</b></div></td><td><div style="width:328px;"><?php echo $row_notes['tar_IndiaNotes']; ?></div></td></tr>
     <?php
     }
     // special Tasks content
     function specialTasks()
     {
            global $commonUses;
            global $access_file_level_specialtasks;
            
            $cli_code=$_REQUEST['cli_code'];
            $recid=$_GET['recid'];
            $query = "SELECT * FROM spt_specialtasks where spt_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_cst = mysql_fetch_assoc($result);
            $spt_Code=@mysql_result( $result,0,'spt_Code') ;
            $details_query = "SELECT * FROM spt_specialtasksdetails where spt_SPLCode =".$spt_Code." order by spt_Code";
            $details_result=@mysql_query($details_query);
            if($_GET['a']=="edit")
            {
                     $this->showtableheader_specialtasks($access_file_level_specialtasks);
                     if($access_file_level_specialtasks['stf_Add']=="Y" || $access_file_level_specialtasks['stf_Edit']=="Y" || $access_file_level_specialtasks['stf_Delete']=="Y")
                     {
                          if(mysql_num_rows($details_result)>0)
                          {
                            ?>
                                    <form name="basedit" method="post" action="dbclass/perminfo_db_class.php" >
                                         <?php
                                            if ($_GET['a']=="edit")
                                            {
                                                if($access_file_level_specialtasks['stf_Edit']=="Y")
                                                {
                                                            $this->showrow_sptdetails($details_result,$spt_Code,$access_file_level_specialtasks,$cli_code,$recid);
                                                            $query = "SELECT i1.spt_Code,i2.spt_Notes, i2.spt_IndiaNotes FROM spt_specialtasks AS i1 LEFT OUTER JOIN spt_specialtasksdetails AS i2 ON (i1.spt_Code = i2.spt_SPLCode) where spt_ClientCode =".$cli_code;
                                                            $result=@mysql_query($query);
                                                            $row_notes = mysql_fetch_array($result);
                                                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                                                ?>
                                                            <tr><td><div style="float:left;"><b>Notes</b></div></td><td><div><textarea name="spt_Notes" rows="3" cols="60" ><?php echo $row_notes['spt_Notes']; ?></textarea> </div></td></tr>
                                                            <tr><td><div style="float:left;"><b>India Notes</b></div></td><td><div><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="spt_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['spt_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['spt_IndiaNotes']; ?> <input type="hidden" name="spt_IndiaNotes" value="<?php echo $row_notes['spt_IndiaNotes']; ?>"><?php } ?> </div></td></tr>

                                                            <tr><td colspan="13"  >
                                                            <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                                    <input type="hidden" name="recid" value="<?php echo $recid;?>">

                                                                            <input type="hidden" name="xspt_Code" value="<?php echo $spt_Code;?>">
                                                                    <center><input type="submit" name="specialTasks" value="Update" class="detailsbutton"></center>
                                                            </td></tr>
                                                    </table>
                                                 <?php
                                                 }
                                                  else if($access_file_level_specialtasks['stf_Edit']=="N")
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
                                                $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Special tasks%')";
                                                $tresult=@mysql_query($tquery);
                                                $tcount=mysql_num_rows($tresult);
                                                        if($tcount>0)
                                                        {
                                                                //Insert all tasks in details table for this client
                                                                while($trow=@mysql_fetch_array($tresult))
                                                                {
                                                                  $sql = "insert into `spt_specialtasksdetails` (`spt_SPLCode`, `spt_TaskCode`) values (" .$spt_Code.", " .$trow['tsk_Code'].")";
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
                     if($access_file_level_specialtasks['stf_View']=="Y")
                     {
                               $this->showtableheader_specialtasks($access_file_level_specialtasks);
                               $this->showrow_specialtasks_view($details_result,$emh_Code);
                               echo "</table>";
                               $this->showrow_specialtasksFooter( $row_cst);
                     }
                     else if($access_file_level_specialtasks['stf_View']=="N")
                     {
                          echo "You are not authorised to view a record.";
                     }

            }
     }
     // special tasks edit
        function showrow_sptdetails($details_result,$spt_Code,$access_file_level_specialtasks,$cli_code,$recid)
        {
                  global $commonUses;
                  $count=mysql_num_rows($details_result);
                  $c=0;
                while ($row_cstdetails=mysql_fetch_array($details_result))
                {
                        $tcode = $row_cstdetails["spt_TaskCode"];
                        ?>
                        <input type="hidden" name="count" value="<?php echo $count;?>">
                        <input type="hidden" name="spt_Code[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["spt_Code"];?>">
                        <input type="hidden" name="spt_SPLCode[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["spt_SPLCode"];?>">
                        <?php
                                            $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_cstdetails["spt_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                            $sub_query = mysql_fetch_array($lookupresult);
                                            if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                        ?>
                        <tr id="splTasks_<?php echo $tcode; ?>">
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_cstdetails["spt_TaskCode"])); ?></td>
                        <td>
                        <?php
                        $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_cstdetails["spt_TaskCode"];
                        $typeresult=@mysql_query($typequery);
                        $type_control = mysql_fetch_array($typeresult);
                            if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                            <input type="text" name="spt_TaskValue[<?php echo $tcode; ?>]" id="spt_txt" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["spt_TaskValue"])) ?>" size="30" disabled>
                            <?php
                            }
                        if($type_control["tsk_TypeofControl"]=="2") {
                        ?>
                            <select name="spt_TaskValue[<?php echo $tcode; ?>]" disabled>
                                <option value="">Select</option>
                                        <?php
                                            $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_cstdetails["spt_TaskCode"];
                                            $lookupresult=@mysql_query($typequery);
                                          while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                          $val = $lp_row["tsk_Code"];
                                          $control = explode(",",$lp_row["tsk_LookupValues"]);
                                            for($i = 0; $i < count($control); $i++){
                                          if($row_cstdetails["spt_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                         ?>
                                            <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                        <?php } } ?>
                            </select>
                                <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_cstdetails["spt_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="spt_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableSplTask(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                            <?php
                            if($row_cstdetails["spt_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enableSplTask(true,$tcode,$c);
                                        </script>";
                            }
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                            ?>
                            <textarea cols="20" rows="2" name="spt_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" disabled><?php echo str_replace('"', '&quot;', trim($row_cstdetails["spt_TaskValue"])) ?></textarea>
                            <?php }
                        if($type_control["tsk_TypeofControl"]=="5") {
                                ?>
                                <?php
                                    if($row_cstdetails["spt_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="spt_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enableSplTask(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                            <?php
                            if($row_cstdetails["spt_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enableSplTask(true,$tcode,$c);
                                        </script>";
                            }
                        }
                        ?>
                            </td>
                        </tr>
                        <?php
                        $c++;
                        $consolidated_ids .= $row_cstdetails["spt_TaskCode"].",";
                }
                $consolidated_ids = substr($consolidated_ids,0,-1);
                ?>
                <input type="hidden" name="spt_TaskCode" value="<?php echo $consolidated_ids;?>">
                 <?php
                 echo $taskCont;
         }
         // special tasks footer
        function showrow_specialtasksFooter( $row_cursts)
        {
            echo "<br><span class='footer'>Created by: ".$row_cursts['spt_Createdby']." | ". "Created on: ".$row_cursts['spt_Createdon']." | ". "Lastmodified by: ".$row_cursts['spt_Lastmodifiedby']." | ". "Lastmodified on: ".$row_cursts['spt_Lastmodifiedon']."</span>";
        }
        // special tasks header
        function showtableheader_specialtasks($access_file_level_specialtasks)
        {
        ?>
            <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="70%" >
                    <tr class="fieldheader">
                    <th class="fieldheader">Task Description</th>
                    <th class="fieldheader"></th>
                    </tr>
        <?php
        }
        // special tasks view
        function  showrow_specialtasks_view($details_result,$set_Code)
        {
                global $commonUses;
                $c=0;
                while ($row_curdetails=mysql_fetch_array($details_result))
                {
                ?>
                <?php
                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_curdetails["spt_TaskCode"];
                                    $lookupresult=@mysql_query($typequery);
                                    $sub_query = mysql_fetch_array($lookupresult);
                                    if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                ?>
                    <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_curdetails["spt_TaskCode"])); ?></td>
                    <td><?php if($row_curdetails["spt_TaskValue"]=="Y") echo "Yes"; else echo $row_curdetails["spt_TaskValue"]; ?></td>
                    <!-- <td><?php echo str_replace('"', '&quot;', trim($row_curdetails["spt_Description"])) ?></td> -->
                    </tr>
                    <?php
                    $c++;
                }
                ?>
                 <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                  <tr>
                <?php
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT i1.spt_Code,i2.spt_Notes, i2.spt_IndiaNotes FROM spt_specialtasks AS i1 LEFT OUTER JOIN spt_specialtasksdetails AS i2 ON (i1.spt_Code = i2.spt_SPLCode) where spt_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_notes = mysql_fetch_array($result);
                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                ?>
                      <td><div style="float:left; width:300px;"><b>Notes</b></div></td><td><div style="width:324px;"><?php echo $row_notes['spt_Notes']; ?></div> </td>
                 </tr>
                 <tr><td><div style="float:left; width:300px;"><b>India Notes</b></div></td><td><div style="width:324px;"><?php echo $row_notes['spt_IndiaNotes']; ?></div></td></tr>
        <?php
        }
        // due dates content
        function dueDate()
        {
            global $commonUses;
            global $access_file_level_duedate;
            
            $cli_code=$_REQUEST['cli_code'];
            $recid=$_GET['recid'];
            $query = "SELECT * FROM ddr_duedatereports where ddr_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_cst = mysql_fetch_assoc($result);
            $ddr_Code=@mysql_result( $result,0,'ddr_Code') ;
            $details_query = "SELECT * FROM ddr_duedatereportsdetails where ddr_DDCode =".$ddr_Code." order by ddr_Code";
            $details_result=@mysql_query($details_query);
            if($_GET['a']=="edit")
            {
                    $this->showtableheader_duedate($access_file_level_duedate);
                    if($access_file_level_duedate['stf_Add']=="Y" || $access_file_level_duedate['stf_Edit']=="Y" || $access_file_level_duedate['stf_Delete']=="Y")
                    {
                             if(mysql_num_rows($details_result)>0)
                            {
                            ?>
                                    <form name="basedit" method="post" action="dbclass/perminfo_db_class.php" >
                                          <?php
                                            if ($_GET['a']=="edit")
                                            {
                                                if($access_file_level_duedate['stf_Edit']=="Y")
                                                {
                                                    $this->showrow_ddrdetails($details_result,$ddr_Code,$access_file_level_duedate,$cli_code,$recid);
                                                    $query = "SELECT i1.ddr_Code,i2.ddr_Notes, i2.ddr_IndiaNotes FROM ddr_duedatereports AS i1 LEFT OUTER JOIN ddr_duedatereportsdetails AS i2 ON (i1.ddr_Code = i2.ddr_DDCode) where ddr_ClientCode =".$cli_code;
                                                    $result=@mysql_query($query);
                                                    $row_notes = mysql_fetch_array($result);
                                                    $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                    ?>
                                                    <table class="fieldtable" align="center" border="0" cellspacing="1" cellpadding="5">
                                                        <tr><td><div style="float:left; width:278px;"><b>Notes</b></div></td><td><div style="width:427px;"><textarea name="ddr_Notes" rows="3" cols="60" ><?php echo $row_notes['ddr_Notes']; ?></textarea> </div></td></tr>
                                                        <tr><td><div style="float:left; width:278px;"><b>India Notes</b></div></td><td><div style="width:427px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="ddr_IndiaNotes" rows="3" cols="60" ><?php echo $row_notes['ddr_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['ddr_IndiaNotes']; ?> <input type="hidden" name="ddr_IndiaNotes" value="<?php echo $row_notes['ddr_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                        <tr><td colspan="13"  >
                                                            <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                            <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                            <input type="hidden" name="xddr_Code" value="<?php echo $ddr_Code;?>">
                                                            <center><input type="submit" name="dueDate" value="Update" class="detailsbutton"></center>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                 <?php
                                                 }
                                                 else if($access_file_level_duedate['stf_Edit']=="N")
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
                                                    $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Due Dates Reports%')";
                                                    $tresult=@mysql_query($tquery);
                                                    $tcount=mysql_num_rows($tresult);
                                                            if($tcount>0)
                                                            {
                                                                    //Insert all tasks in details table for this client
                                                                    while($trow=@mysql_fetch_array($tresult))
                                                                    {
                                                                      $sql = "insert into `ddr_duedatereportsdetails` (`ddr_DDCode`, `ddr_TaskCode`) values (" .$ddr_Code.", " .$trow['tsk_Code'].")";
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
                     if($access_file_level_duedate['stf_View']=="Y")
                     {
                               $this->showtableheader_duedate($access_file_level_duedate);
                               $this->showrow_duedate_view($details_result,$ddr_Code);
                               echo "</table>";
                               $this->showrow_duedateFooter( $row_cst);
                     }
                     else if($access_file_level_duedate['stf_View']=="N")
                     {
                           echo "You are not authorised to view a record.";
                     }
             }
        }
        // due date edit
        function showrow_ddrdetails($details_result,$ddr_Code,$access_file_level_duedate,$cli_code,$recid)
        {
                  global $commonUses;
                  $count=mysql_num_rows($details_result);
                  $c=0;
                    while ($row_cstdetails=mysql_fetch_array($details_result))
                    {
                            $tcode = $row_cstdetails["ddr_TaskCode"];
                            ?>
                            <input type="hidden" name="count" value="<?php echo $count;?>">
                            <input type="hidden" name="ddr_Code[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["ddr_Code"];?>">
                            <input type="hidden" name="ddr_DDCode[<?php echo $tcode; ?>]" value="<?php echo $row_cstdetails["ddr_DDCode"];?>">
                            <?php
                                               $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_cstdetails["ddr_TaskCode"];
                                               $lookupresult=@mysql_query($typequery);
                                               $sub_query = mysql_fetch_array($lookupresult);
                                               $doc = "Documents to be sent to Super Records";
                                               $day = "Due Day";
                                               $int = "Internal Process / Delivery method";
                                               if($c==6) echo "<td style='background-color:#047ea7; color:white;'><b>".Cycle."</b></td><td style='background-color:#047ea7; color:white;'><b>".$doc."</b></td><td style='background-color:#047ea7; color:white;'><b>".$day."</b></td><td style='background-color:#047ea7; color:white;'><b>".$int."</b></td>";
                            ?>
                            <tr>
                            <?php
                             if($c == 5)
                             {
                                echo "<td colspan='4' style='color:#047ea7; font-size:14px; font-weight:bold;' >Task list for client admin</td>";
                             }
                             else
                             {
                            ?>
                            <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_cstdetails["ddr_TaskCode"])); ?></td>
                            <td>
                                <?php
                            $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_cstdetails["ddr_TaskCode"];
                            $typeresult=@mysql_query($typequery);
                            $type_control = mysql_fetch_array($typeresult);

                                if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                <input type="text" name="ddr_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["ddr_TaskValue"])) ?>" size="30" >
                                <?php
                                }
                            if($type_control["tsk_TypeofControl"]=="2") {
                            ?>
                                <select name="ddr_TaskValue[<?php echo $tcode; ?>]">
                                    <option value="">Select</option>
                                            <?php
                                                $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_cstdetails["ddr_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                              while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                              $val = $lp_row["tsk_Code"];
                                              $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                for($i = 0; $i < count($control); $i++){
                                              if($row_cstdetails["ddr_TaskValue"]==$control[$i]){ $selstr="selected"; } else { $selstr=""; }
                                             ?>
                                                <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                            <?php } } ?>
                                </select>
                                    <?php
                            }
                            if($type_control["tsk_TypeofControl"]=="3") {
                                    ?>
                                    <?php
                                        if($row_cstdetails["ddr_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                    ?>
                                <input type="checkbox" name="ddr_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?>>
                                <?php
                            }
                            if($type_control["tsk_TypeofControl"]=="4") {
                                ?>
                                <textarea cols="20" rows="2" name="ddr_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_cstdetails["ddr_TaskValue"])) ?></textarea>
                                <?php }
                            if($type_control["tsk_TypeofControl"]=="5") {
                                echo "";
                            }
                            ?>
                            </td>
                            <td><input type="text" name="ddr_DuedaySend[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["ddr_DuedaySend"])) ?>" size="30" ></td>
                            <td><input type="text" name="ddr_WorkDone[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_cstdetails["ddr_WorkDone"])) ?>" size="30" ></td>
                            <?php
                            }
                            ?>
                            </tr>
                            <?php
                            $c++;
                            $consolidated_ids .= $row_cstdetails["ddr_TaskCode"].",";
                    }
                    $consolidated_ids = substr($consolidated_ids,0,-1);
                    ?>
                    <input type="hidden" name="ddr_TaskCode" value="<?php echo $consolidated_ids;?>">
         <?php
         }
         // due date footer
         function showrow_duedateFooter( $row_cursts)
         {
                echo "<br><span class='footer'>Created by: ".$row_cursts['ddr_Createdby']." | ". "Created on: ".$row_cursts['ddr_Createdon']." | ". "Lastmodified by: ".$row_cursts['ddr_Lastmodifiedby']." | ". "Lastmodified on: ".$row_cursts['ddr_Lastmodifiedon']."</span>";
         }
         // due date header
         function showtableheader_duedate($access_file_level_duedate)
         {
        ?>
            <div style="color:#047ea7; font-size:14px; font-weight:bold; position:relative; top:0;">Task list for Super Records</div>
            <table  class="fieldtable" align="center" border="0" cellspacing="1" cellpadding="5"  width="70%" >
                    <tr class="fieldheader">
                    <th class="fieldheader">Cycle</th>
                    <th class="fieldheader">Reports to be sent</th>
                    <th class="fieldheader">Due Day for Super Records to send report</th>
                    <th class="fieldheader">When work should be done</th>
                    </tr>
        <?php
        }
        // duedate view
        function  showrow_duedate_view($details_result,$ddr_Code)
        {
                global $commonUses;
                $c=0;
                while ($row_curdetails=mysql_fetch_array($details_result))
                {
                ?>
                <?php
                                    $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_curdetails["ddr_TaskCode"];
                                    $lookupresult=@mysql_query($typequery);
                                    $sub_query = mysql_fetch_array($lookupresult);
                                   $doc = "Documents to be sent to Super Records";
                                   $day = "Due Day";
                                   $int = "Internal Process / Delivery method";

                                    if($c==6) echo "<td style='background-color:#047ea7; color:white;'><b>".Cycle."</b></td><td style='background-color:#047ea7; color:white;'><b>".$doc."</b></td><td style='background-color:#047ea7; color:white;'><b>".$day."</b></td><td style='background-color:#047ea7; color:white;'><b>".$int."</b></td>";
                ?>
                <?php
                 if($c == 5)
                 {
                    echo "<td colspan='4' style='color:#047ea7; font-size:14px; font-weight:bold;' >Task list for client admin</td>";
                 }
                ?>
                    <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_curdetails["ddr_TaskCode"])); ?></td>
                    <td><?php echo str_replace('"', '&quot;', trim($row_curdetails["ddr_TaskValue"])) ?></td>
                    <td><?php echo str_replace('"', '&quot;', trim($row_curdetails["ddr_DuedaySend"])) ?></td>
                    <td><?php echo str_replace('"', '&quot;', trim($row_curdetails["ddr_WorkDone"])) ?></td>
                    </tr>
                <?php
                    $c++;
                }
                ?>
                 <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5">
                  <tr>
                <?php
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT i1.ddr_Code,i2.ddr_Notes, i2.ddr_IndiaNotes FROM ddr_duedatereports AS i1 LEFT OUTER JOIN ddr_duedatereportsdetails AS i2 ON (i1.ddr_Code = i2.ddr_DDCode) where ddr_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_notes = mysql_fetch_array($result);
                $ind_id = $commonUses->getIndiamanagerId($cli_code);
                ?>

                      <td><div style="float:left; width:349px;"><b>Notes</b></div></td><td><div style="width:356px;"><?php echo $row_notes['ddr_Notes']; ?></div> </td>
                 </tr>
                 <tr><td><div style="float:left; width:349px;"><b>India Notes</b></div></td><td><div style="width:356px;"><?php echo $row_notes['ddr_IndiaNotes']; ?></div></td></tr>
        <?php
        }
        function taskList() {
            $cli_code=$_REQUEST['cli_code'];
            $query = mysql_query("select * from tsk_perminfotasklist where cli_code=".$cli_code."");
            $tsk_row = mysql_fetch_array($query);
            // sub activity
            $sub_activity = explode(',',$tsk_row['sub_activity']);
            $sub_activity8 = explode('~',$sub_activity[0]); $sub_activity9 = explode('~',$sub_activity[1]); $sub_activity10 = explode('~',$sub_activity[2]); $sub_activity11 = explode('~',$sub_activity[3]); $sub_activity12 = explode('~',$sub_activity[4]);
            //befree internal due date
            $int_duedate = explode(',',$tsk_row['befree_internal_due_date']);
            $int_duedate3 = explode('~',$int_duedate[0]); $int_duedate4 = explode('~',$int_duedate[1]); $int_duedate5 = explode('~',$int_duedate[2]); $int_duedate7 = explode('~',$int_duedate[3]); $int_duedate8 = explode('~',$int_duedate[4]); $int_duedate9 = explode('~',$int_duedate[5]); $int_duedate10 = explode('~',$int_duedate[6]); $int_duedate11 = explode('~',$int_duedate[7]); $int_duedate12 = explode('~',$int_duedate[8]);
            //ato due date
            $ato_duedate = explode(',',$tsk_row['ato_due_date']);
            $ato_duedate1 = explode('~',$ato_duedate[0]); $ato_duedate2 = explode('~',$ato_duedate[1]); $ato_duedate3 = explode('~',$ato_duedate[2]); $ato_duedate4 = explode('~',$ato_duedate[3]); $ato_duedate5 = explode('~',$ato_duedate[4]); $ato_duedate7 = explode('~',$ato_duedate[5]); $ato_duedate8 = explode('~',$ato_duedate[6]); $ato_duedate9 = explode('~',$ato_duedate[7]); $ato_duedate10 = explode('~',$ato_duedate[8]); $ato_duedate11 = explode('~',$ato_duedate[9]); $ato_duedate12 = explode('~',$ato_duedate[10]);
            //one off
            $oneoff = explode(',',$tsk_row['one_off']);
            $oneoff1 = explode('~',$oneoff[0]); $oneoff2 = explode('~',$oneoff[1]); $oneoff3 = explode('~',$oneoff[2]); $oneoff4 = explode('~',$oneoff[3]); $oneoff5 = explode('~',$oneoff[4]); $oneoff7 = explode('~',$oneoff[5]); $oneoff8 = explode('~',$oneoff[6]); $oneoff9 = explode('~',$oneoff[7]); $oneoff10 = explode('~',$oneoff[8]); $oneoff11 = explode('~',$oneoff[9]); $oneoff12 = explode('~',$oneoff[10]);
            //monthly
            $monthly = explode(',',$tsk_row['monthly']);
            $monthly1 = explode('~',$monthly[0]); $monthly2 = explode('~',$monthly[1]); $monthly3 = explode('~',$monthly[2]); $monthly4 = explode('~',$monthly[3]); $monthly5 = explode('~',$monthly[4]); $monthly7 = explode('~',$monthly[5]); $monthly8 = explode('~',$monthly[6]); $monthly9 = explode('~',$monthly[7]); $monthly10 = explode('~',$monthly[8]); $monthly11 = explode('~',$monthly[9]); $monthly12 = explode('~',$monthly[10]);
            //quarterly
            $quarterly = explode(',',$tsk_row['quarterly']);
            $quarterly1 = explode('~',$quarterly[0]); $quarterly2 = explode('~',$quarterly[1]); $quarterly3 = explode('~',$quarterly[2]); $quarterly4 = explode('~',$quarterly[3]); $quarterly5 = explode('~',$quarterly[4]); $quarterly7 = explode('~',$quarterly[5]); $quarterly8 = explode('~',$quarterly[6]); $quarterly9 = explode('~',$quarterly[7]); $quarterly10 = explode('~',$quarterly[8]); $quarterly11 = explode('~',$quarterly[9]); $quarterly12 = explode('~',$quarterly[10]);
            //yearly
            $yearly = explode(',',$tsk_row['yearly']);
            $yearly2 = explode('~',$yearly[0]); $yearly3 = explode('~',$yearly[1]); $yearly4 = explode('~',$yearly[2]); $yearly5 = explode('~',$yearly[3]); $yearly7 = explode('~',$yearly[4]); $yearly8 = explode('~',$yearly[5]); $yearly9 = explode('~',$yearly[6]); $yearly10 = explode('~',$yearly[7]); $yearly11 = explode('~',$yearly[8]); $yearly12 = explode('~',$yearly[9]);
            //must
            $must = explode(',',$tsk_row['must']);
            $must2 = explode('~',$must[0]); $must3 = explode('~',$must[1]); $must4 = explode('~',$must[2]); $must5 = explode('~',$must[3]); $must7 = explode('~',$must[4]); $must8 = explode('~',$must[5]); $must9 = explode('~',$must[6]); $must10 = explode('~',$must[7]); $must11 = explode('~',$must[8]); $must12 = explode('~',$must[9]);
            //comments
            $comment = explode(',',$tsk_row['comment']);
            $comment1 = explode('~',$comment[0]); $comment2 = explode('~',$comment[1]); $comment3 = explode('~',$comment[2]); $comment4 = explode('~',$comment[3]); $comment5 = explode('~',$comment[4]); $comment7 = explode('~',$comment[5]); $comment8 = explode('~',$comment[6]); $comment9 = explode('~',$comment[7]); $comment10 = explode('~',$comment[8]); $comment11 = explode('~',$comment[9]); $comment12 = explode('~',$comment[10]);
            
            ?>
             <form name="tasklist" method="post" action="dbclass/perminfo_db_class.php" >    
                 <table class="fieldtable" align="center" border="0" cellspacing="1" cellpadding="5"  width="100%">
                     <tr class="fieldheader">
                         <th nowrap style="width:120px;" align="center">Master Activity</th>
                         <th align="center">Sub Activity / Notes</th>
                         <th align="center">Befree Internal Due Date</th>
                         <th align="center">ATO Due Date</th>
                         <th nowrap style="width:70px;" align="center">One off</th>
                         <th align="center">Monthly</th>
                         <th align="center">Quarterly</th>
                         <th align="center">Yearly</th>
                         <th align="center">Must</th>
                         <th align="center">Comment</th>
                     </tr>
                     <tr>
                         <td>Preparation of SMSF Accounts</td>
                         <td>Create Tasks for next year</td>
                         <td>15th June (every year)</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate1" value="<?php echo stripslashes($ato_duedate1[1]); ?>"/><?php } else echo stripslashes($ato_duedate1[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off1" value="Yes" <?php if($oneoff1[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff1[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly1" value="Yes" <?php if($monthly1[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly1[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly1" value="Yes" <?php if($quarterly1[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly1[1]); ?></td>
                         <td>Yearly</td>
                         <td>Must</td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment1"><?php echo stripslashes($comment1[1]); ?></textarea><?php } else echo stripslashes($comment1[1]); ?></td>
                     </tr>
                     <tr>
                         <td>Bank Processing</td>
                         <td>Processing SMSF Banks</td>
                         <td>5th of next month</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate2" value="<?php echo stripslashes($ato_duedate2[1]); ?>"/><?php } else echo stripslashes($ato_duedate2[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off2" value="Yes" <?php if($oneoff2[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff2[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly2" value="Yes" <?php if($monthly2[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly2[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly2" value="Yes" <?php if($quarterly2[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly2[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly2" value="Yes" <?php if($yearly2[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly2[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must2" value="Yes" <?php if($must2[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must2[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment2"><?php echo stripslashes($comment2[1]); ?></textarea><?php } else echo stripslashes($comment2[1]); ?></td>
                     </tr>
                     <tr>
                         <td>GST - SMSF Clients</td>
                         <td>BAS</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate3" value="<?php echo stripslashes($int_duedate3[1]); ?>"/><?php } else echo stripslashes($int_duedate3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate3" value="<?php echo stripslashes($ato_duedate3[1]); ?>"/><?php } else echo stripslashes($ato_duedate3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off3" value="Yes" <?php if($oneoff3[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly3" value="Yes" <?php if($monthly3[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly3" value="Yes" <?php if($quarterly3[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly3" value="Yes" <?php if($yearly3[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must3" value="Yes" <?php if($must3[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must3[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment3"><?php echo stripslashes($comment3[1]); ?></textarea><?php } else echo stripslashes($comment3[1]); ?></td>
                     </tr>
                     <tr>
                         <td></td>
                         <td>IAS</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate4" value="<?php echo stripslashes($int_duedate4[1]); ?>"/><?php } else echo stripslashes($int_duedate4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate4" value="<?php echo stripslashes($ato_duedate4[1]); ?>"/><?php } else echo stripslashes($ato_duedate4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off4" value="Yes" <?php if($oneoff4[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly4" value="Yes" <?php if($monthly4[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly4" value="Yes" <?php if($quarterly4[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly4" value="Yes" <?php if($yearly4[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must4" value="Yes" <?php if($must4[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must4[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment4"><?php echo stripslashes($comment4[1]); ?></textarea><?php } else echo stripslashes($comment4[1]); ?></td>
                     </tr>
                     <tr>
                         <td>SMSF Tax Return</td>
                         <td>Preparation of Tax return</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate5" value="<?php echo stripslashes($int_duedate5[1]); ?>"/><?php } else echo stripslashes($int_duedate5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate5" value="<?php echo stripslashes($ato_duedate5[1]); ?>"/><?php } else echo stripslashes($ato_duedate5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off5" value="Yes" <?php if($oneoff5[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly5" value="Yes" <?php if($monthly5[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly5" value="Yes" <?php if($quarterly5[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly5" value="Yes" <?php if($yearly5[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must5" value="Yes" <?php if($must5[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must5[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment5"><?php echo stripslashes($comment5[1]); ?></textarea><?php } else echo stripslashes($comment5[1]); ?></td>
                     </tr>
                     <tr>
                         <td style="background-color: #047ea7; color: white;" align="center">Misc Tasks</td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                     </tr>
                     <tr>
                         <td>Backlog</td>
                         <td>Create tasks for all agreed work we have to do for backlog</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate7" value="<?php echo stripslashes($int_duedate7[1]); ?>"/><?php } else echo stripslashes($int_duedate7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate7" value="<?php echo stripslashes($ato_duedate7[1]); ?>"/><?php } else echo stripslashes($ato_duedate7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off7" value="Yes" <?php if($oneoff7[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly7" value="Yes" <?php if($monthly7[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly7" value="Yes" <?php if($quarterly7[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly7" value="Yes" <?php if($yearly7[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must7" value="Yes" <?php if($must7[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must7[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment7"><?php echo stripslashes($comment7[1]); ?></textarea><?php } else echo stripslashes($comment7[1]); ?></td>
                     </tr>
                     <tr>
                         <td>2</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="sub_activity8" value="<?php echo stripslashes($sub_activity8[1]); ?>"/><?php } else echo stripslashes($sub_activity8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate8" value="<?php echo stripslashes($int_duedate8[1]); ?>"/><?php } else echo stripslashes($int_duedate8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate8" value="<?php echo stripslashes($ato_duedate8[1]); ?>"/><?php } else echo stripslashes($ato_duedate8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off8" value="Yes" <?php if($oneoff8[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly8" value="Yes" <?php if($monthly8[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly8" value="Yes" <?php if($quarterly8[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly8" value="Yes" <?php if($yearly8[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must8" value="Yes" <?php if($must8[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must8[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment8"><?php echo stripslashes($comment8[1]); ?></textarea><?php } else echo stripslashes($comment8[1]); ?></td>
                     </tr>
                     <tr>
                         <td>3</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="sub_activity9" value="<?php echo stripslashes($sub_activity9[1]); ?>"/><?php } else echo stripslashes($sub_activity9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate9" value="<?php echo stripslashes($int_duedate9[1]); ?>"/><?php } else echo stripslashes($int_duedate9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate9" value="<?php echo stripslashes($ato_duedate9[1]); ?>"/><?php } else echo stripslashes($ato_duedate9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off9" value="Yes" <?php if($oneoff9[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly9" value="Yes" <?php if($monthly9[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly9" value="Yes" <?php if($quarterly9[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly9" value="Yes" <?php if($yearly9[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must9" value="Yes" <?php if($must9[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must9[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment9"><?php echo stripslashes($comment9[1]); ?></textarea><?php } else echo stripslashes($comment9[1]); ?></td>
                     </tr>
                     <tr>
                         <td>4</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="sub_activity10" value="<?php echo stripslashes($sub_activity10[1]); ?>"/><?php } else echo stripslashes($sub_activity10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate10" value="<?php echo stripslashes($int_duedate10[1]); ?>"/><?php } else echo stripslashes($int_duedate10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate10" value="<?php echo stripslashes($ato_duedate10[1]); ?>"/><?php } else echo stripslashes($ato_duedate10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off10" value="Yes" <?php if($oneoff10[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly10" value="Yes" <?php if($monthly10[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly10" value="Yes" <?php if($quarterly10[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly10" value="Yes" <?php if($yearly10[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must10" value="Yes" <?php if($must10[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must10[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment10"><?php echo stripslashes($comment10[1]); ?></textarea><?php } else echo stripslashes($comment10[1]); ?></td>
                     </tr>
                     <tr>
                         <td>5</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="sub_activity11" value="<?php echo stripslashes($sub_activity11[1]); ?>"/><?php } else echo stripslashes($sub_activity11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate11" value="<?php echo stripslashes($int_duedate11[1]); ?>"/><?php } else echo stripslashes($int_duedate11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate11" value="<?php echo stripslashes($ato_duedate11[1]); ?>"/><?php } else echo stripslashes($ato_duedate11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off11" value="Yes" <?php if($oneoff11[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly11" value="Yes" <?php if($monthly11[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly11" value="Yes" <?php if($quarterly11[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly11" value="Yes" <?php if($yearly11[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must11" value="Yes" <?php if($must11[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must11[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment11"><?php echo stripslashes($comment11[1]); ?></textarea><?php } else echo stripslashes($comment11[1]); ?></td>
                     </tr>
                     <tr>
                         <td>6</td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="sub_activity12" value="<?php echo stripslashes($sub_activity12[1]); ?>"/><?php } else echo stripslashes($sub_activity12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="internal_duedate12" value="<?php echo stripslashes($int_duedate12[1]); ?>"/><?php } else echo stripslashes($int_duedate12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="text" name="ato_duedate12" value="<?php echo stripslashes($ato_duedate12[1]); ?>"/><?php } else echo stripslashes($ato_duedate12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="one_off12" value="Yes" <?php if($oneoff12[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($oneoff12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="monthly12" value="Yes" <?php if($monthly12[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($monthly12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="quarterly12" value="Yes" <?php if($quarterly12[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($quarterly12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="yearly12" value="Yes" <?php if($yearly12[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($yearly12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><input type="checkbox" name="must12" value="Yes" <?php if($must12[1]=='Yes') echo "checked"; ?>/><?php } else echo stripslashes($must12[1]); ?></td>
                         <td><?php if($_GET['a']=='edit') { ?><textarea name="comment12"><?php echo stripslashes($comment12[1]); ?></textarea><?php } else echo stripslashes($comment12[1]); ?></td>
                     </tr>
                 </table>         
                                                    <table class="fieldtable" align="center" border="0" cellspacing="1" cellpadding="5">
                                                        <tr><td><div style="float:left; width:350px;"><b>Notes</b></div></td><td><div style="width:427px;"><?php if($_GET['a']=='edit') { ?><textarea name="tsk_notes" rows="3" cols="60" ><?php echo stripslashes($tsk_row['tsk_notes']); ?></textarea><?php } else echo stripslashes($tsk_row['tsk_notes']); ?> </div></td></tr>
                                                        <tr><td><div style="float:left; width:350px;"><b>India Notes</b></div></td><td><?php if($_GET['a']=='edit') { ?><div style="width:427px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="tsk_india_notes" rows="3" cols="60" ><?php echo stripslashes($tsk_row['tsk_india_notes']); ?></textarea><?php } else { echo stripslashes($tsk_row['tsk_india_notes']); ?> <input type="hidden" name="ddr_IndiaNotes" value="<?php echo stripslashes($tsk_row['tsk_india_notes']); ?>"><?php } ?> </div><?php } else echo stripslashes($tsk_row['tsk_india_notes']); ?></td></tr>
                                                        <tr><td colspan="13"  >
                                                            <input type='hidden' name='sql' value='update'/>
                                                            <input type="hidden" name="cli_code" value="<?php echo $cli_code;?>"/>
                                                            <input type="hidden" name="recid" value="<?php echo $recid;?>"/>
                                                            <input type="hidden" name="xddr_Code" value="<?php echo $ddr_Code;?>"/>
                                                            <?php if($_GET['a']=='edit') { ?><center><input type="submit" name="tasklist" value="Update" class="detailsbutton"/></center><?php } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                 </form>
        <?php
        }

}
	$permbasContent = new permbasContentList();
?>

