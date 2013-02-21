<?php
class taxaccountContentList extends Database
{
    // tax account content
    function taxaccountContent()
    {
            global $commonUses;
            global $access_file_level_taxaccount;
            
            $cli_code=$_REQUEST['cli_code'];
            $recid=$_GET['recid'];
            $query = "SELECT * FROM tax_taxaccounting where tax_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_inv = mysql_fetch_assoc($result);
            $tax_Code=@mysql_result( $result,0,'tax_Code') ;
            $details_query = "SELECT * FROM tax_taxaccountingdetails where tax_TAXCode =".$tax_Code." order by tax_Code";
            $details_result=@mysql_query($details_query);
                    if($_GET['a']=="edit")
                    {
                            $this->showtableheader_taxaccount($access_file_level_taxaccount);
                            if($access_file_level_taxaccount['stf_Add']=="Y" || $access_file_level_taxaccount['stf_Edit']=="Y" || $access_file_level_taxaccount['stf_Delete']=="Y")
                            {
                              if(mysql_num_rows($details_result)>0)
                              {
                            ?>
                                    <form name="taxaccountingdetailedit" method="post" action="dbclass/taxaccount_db_class.php">
                                        <?php
                                            if($_GET['a']=="edit")
                                            {
                                                  if($access_file_level_taxaccount['stf_Edit']=="Y")
                                                  {
                                                        $this->showrow_taxdetails($details_result,$tax_Code,$access_file_level_taxaccount,$cli_code,$recid);
                                                        ?>
                                                        <?php
                                                            $query = "SELECT i1.tax_Code,i2.tax_Notes,i2.tax_IndiaNotes FROM tax_taxaccounting AS i1 LEFT OUTER JOIN tax_taxaccountingdetails AS i2 ON (i1.tax_Code = i2.tax_TAXCode) where tax_ClientCode =".$cli_code;
                                                            $result=@mysql_query($query);
                                                            $row_notes = mysql_fetch_array($result);
                                                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                                                        ?>
                                                        <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                                                                <tr><td><div style="float:left; width:331px;"><b>Notes</b></div></td><td><div style="width:368px;"><textarea name="tax_Notes" rows="3" cols="53" ><?php echo $row_notes['tax_Notes']; ?></textarea> </div></td></tr>
                                                                <tr><td><div style="float:left; width:331px;"><b>India Notes</b></div></td><td><div style="width:368px;"><?php if($ind_id==$_SESSION['staffcode']) { ?><textarea name="tax_IndiaNotes" rows="3" cols="53" ><?php echo $row_notes['tax_IndiaNotes']; ?></textarea><?php } else { echo $row_notes['tax_IndiaNotes']; ?> <input type="hidden" name="tax_IndiaNotes" value="<?php echo $row_notes['tax_IndiaNotes']; ?>"><?php } ?> </div></td></tr>
                                                                <tr>
                                                                    <td colspan="13"  >
                                                                        <input type='hidden' name='sql' value='update'><input type="hidden" name="cli_code" value="<?php echo $cli_code;?>">
                                                                        <input type="hidden" name="recid" value="<?php echo $recid;?>">
                                                                        <input type="hidden" name="xtax_Code" value="<?php echo $tax_Code;?>">
                                                                        <center><input type="submit" name="taxaccount" id="invoiceupdate" value="Update" class="detailsbutton"></center>
                                                                    </td>
                                                                </tr>
                                                        </table>
                                                   <?php
                                                   }
                                                   else if($access_file_level_taxaccount['stf_Edit']=="N")
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
                                                $tquery = "SELECT `tsk_Code` , `tsk_Description` FROM `tsk_tasks` WHERE tsk_Category = (SELECT cat_Code FROM cat_categorytasks WHERE cat_Description LIKE 'Tax Accounting%')";
                                                $tresult=@mysql_query($tquery);
                                                $tcount=mysql_num_rows($tresult);
                                                        if($tcount>0)
                                                        {
                                                                //Insert all tasks in details table for this client
                                                                while($trow=@mysql_fetch_array($tresult))
                                                                {
                                                                  $sql = "insert into `tax_taxaccountingdetails` (`tax_TAXCode`, `tax_TaskCode`) values (" .$tax_Code.", " .$trow['tsk_Code'].")";
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
                             if($access_file_level_taxaccount['stf_View']=="Y")
                             {
                                       $this->showtableheader_taxaccount($access_file_level_taxaccount);
                                       $this->showrow_taxdetails_view($details_result,$tax_Code);
                                       echo "</table>";
                                       $this->showrow_taxFooter($row_inv);
                             }
                             else if($access_file_level_taxaccount['stf_View']=="N")
                             {
                                  echo "You are not authorised to view a record.";
                             }
                    }
    }
    // tax account edit
    function showrow_taxdetails($details_result,$tax_Code,$access_file_level_taxaccount,$cli_code,$recid)
    {
            global $commonUses;
            $count=mysql_num_rows($details_result);
            $c=0;
            while ($row_snddetails=mysql_fetch_array($details_result))
            {
                    $tcode = $row_snddetails["tax_TaskCode"];
                    ?>
                    <input type="hidden" name="count" value="<?php echo $count;?>">
                    <input type="hidden" name="tax_Code[<?php echo $tcode; ?>]" value="<?php echo $row_snddetails["tax_Code"];?>">
                    <input type="hidden" name="tax_TAXCode[<?php echo $tcode; ?>]" value="<?php echo $row_snddetails["tax_TAXCode"];?>">
                    <?php
                                        $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["tax_TaskCode"];
                                        $lookupresult=@mysql_query($typequery);
                                        $sub_query = mysql_fetch_array($lookupresult);
                                        if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                    ?>
                    <tr>
                        <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snddetails["tax_TaskCode"])); ?></td>
                        <td>
                            <?php
                                $typequery="select tsk_TypeofControl from tsk_tasks where tsk_Code=".$row_snddetails["tax_TaskCode"];
                                $typeresult=@mysql_query($typequery);
                                $type_control = mysql_fetch_array($typeresult);
                                if($type_control["tsk_TypeofControl"]=="0" || $type_control["tsk_TypeofControl"]=="1") { ?>
                                <input type="text" name="tax_TaskValue[<?php echo $tcode; ?>]" value="<?php echo str_replace('"', '&quot;', trim($row_snddetails["tax_TaskValue"])) ?>" size="30">
                            <?php
                            }
                            if($type_control["tsk_TypeofControl"]=="2") {
                            ?>
                                <select name="tax_TaskValue[<?php echo $tcode; ?>]">
                                            <option value="">Select</option>
                                            <?php
                                                $typequery="select tsk_Code, tsk_LookupValues from tsk_tasks where tsk_Code=".$row_snddetails["tax_TaskCode"];
                                                $lookupresult=@mysql_query($typequery);
                                              while ($lp_row = mysql_fetch_assoc($lookupresult)){
                                              $val = $lp_row["tsk_Code"];
                                              $control = explode(",",$lp_row["tsk_LookupValues"]);
                                                for($i = 0; $i < count($control); $i++){
                                                if($row_snddetails["tax_TaskValue"] == $control[$i]) { $selstr="selected"; } else { $selstr=""; }
                                             ?>
                                                <option value="<?php echo $control[$i]; ?>"<?php echo $selstr; ?>><?php echo $control[$i] ?></option>
                                            <?php } } ?>
                                </select>
                                <?php
                        }
                        if($type_control["tsk_TypeofControl"]=="3") {
                                ?>
                                <?php
                                    if($row_snddetails["tax_TaskValue"]=="Y") { $selyes="checked"; } else { $selyes=""; }
                                ?>
                            <input type="checkbox" name="tax_TaskValue[<?php echo $tcode; ?>]" value="Y" <?php echo $selyes; ?> onclick="enablePayroll(this.checked,<?php echo $tcode; ?>,<?php echo $c; ?>)">
                            <?php
                            if($row_snddetails["tax_TaskValue"]=="Y")
                            {
                                $taskCont .= "<script>
                                        enablePayroll(true,$tcode,$c);
                                        </script>";

                            }
                        }
                        if($type_control["tsk_TypeofControl"]=="4") {
                            ?>
                            <textarea cols="30" rows="2" name="tax_TaskValue[<?php echo $tcode; ?>]" STYLE="scrollbar-base-color:pink;scrollbar-arrow-color:purple;" ><?php echo str_replace('"', '&quot;', trim($row_snddetails["tax_TaskValue"])) ?></textarea>
                         <?php } ?>
                    </tr>
                    <?php
                    $c++;
                    $consolidated_ids .= $row_snddetails["tax_TaskCode"].",";
            }
            $consolidated_ids = substr($consolidated_ids,0,-1);
            ?>
            <input type="hidden" name="tax_TaskCode" value="<?php echo $consolidated_ids;?>">
            <?php
            echo $taskCont;
     }
     // tax account footer
     function showrow_taxFooter( $row_inv)
     {
        echo "<br><span class='footer'>Created by: ".$row_inv['tax_Createdby']." | ". "Created on: ".$row_inv['tax_Createdon']." | ". "Lastmodified by: ".$row_inv['tax_Lastmodifiedby']." | ". "Lastmodified on: ".$row_inv['tax_Lastmodifiedon']."</span>";
     }
     // tax account header
      function showtableheader_taxaccount($access_file_level_taxaccount)
      {
      ?>
            <table  class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="70%">
                    <tr class="fieldheader">
                           <th class="fieldheader">Task Description</th>
                           <th class="fieldheader"></th>
                    </tr>
    <?php
    }
    // tax account view
     function showrow_taxdetails_view($details_result,$tax_Code)
     {
            global $commonUses;
            $c=0;
             while ($row_snddetails=mysql_fetch_array($details_result))
            {
            ?>
                <?php
                                $typequery="select t1.tsk_SubCategory,s1.sub_Description from tsk_tasks as t1 LEFT OUTER JOIN sub_subcategorytasks as s1 ON (t1.tsk_SubCategory = s1.sub_Code) where tsk_Code=".$row_snddetails["tax_TaskCode"];
                                $lookupresult=@mysql_query($typequery);
                                $sub_query = mysql_fetch_array($lookupresult);
                                if($c==0) echo "<td nowrap style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7; border-right:1px solid #F5FCFF;'><b style='font-size:14px; color:#b21a03;'>".$sub_query['sub_Description']."</b></td><td style='background-color:#F5FCFF; border-bottom:1px solid #afe5f7;'></td>";
                ?>
             <tr>
                    <td><?php echo $commonUses->getTaskDescription(htmlspecialchars($row_snddetails["tax_TaskCode"])); ?></td>
                    <td><?php if($row_snddetails["tax_TaskValue"]=="Y") echo "Yes"; else echo str_replace('"', '&quot;', trim($row_snddetails["tax_TaskValue"]))?></td>
             </tr>
            <?php
            $c++;
            } ?>
             <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
              <tr>
                       <?php
                            $cli_code=$_REQUEST['cli_code'];
                            $query = "SELECT i1.tax_Code,i2.tax_Notes,i2.tax_IndiaNotes FROM tax_taxaccounting AS i1 LEFT OUTER JOIN tax_taxaccountingdetails AS i2 ON (i1.tax_Code = i2.tax_TAXCode) where tax_ClientCode =".$cli_code;
                            $result=@mysql_query($query);
                            $row_notes = mysql_fetch_array($result);
                            $ind_id = $commonUses->getIndiamanagerId($cli_code);
                       ?>
                  <td><div style="float:left; width:383px;"><b>Notes</b></div></td><td><div style="width:294px;"><?php echo $row_notes['tax_Notes']; ?></div> </td>
             </tr>
             <tr><td><div style="float:left; width:383px;"><b>India Notes</b></div></td><td><div style="width:294px;"><?php echo $row_notes['tax_IndiaNotes']; ?></div></td></tr>
     <?php
     }

}
	$taxaccountContent = new taxaccountContentList();
?>

