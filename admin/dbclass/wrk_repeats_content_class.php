<?php
	
class repeatsContentList extends Database
{
         function select($access_file_level)
         {
                  global $a;
                  global $showrecs;
                  global $page;
                  global $filtertext;
                  global $filterfieldrepeat;
                  global $wholeonly;
                  global $order;
                  global $ordtype;
                  global $access_file_level_worksheet;
                  global $access_file_level;
                  global $repeatsDbcontent;
                  global $commonUses;
                  
                  if ($a == "reset") {
                    $filtertext = "";
                    $filterfieldrepeat = "";
                    $wholeonly = "";
                    $order = "";
                    $ordtype = "";
                  }
                  $checkstr = "";
                  if ($wholeonly) $checkstr = " checked";
                  if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
                  $res = $repeatsDbcontent->sql_select();
                  $count=mysql_num_rows($res);
                  if ($count % $showrecs != 0) {
                    $pagecount = intval($count / $showrecs) + 1;
                  }
                  else {
                    $pagecount = intval($count / $showrecs);
                  }
                  $startrec = $showrecs * ($page - 1);
                  if ($startrec < $count) {mysql_data_seek($res, $startrec);}
                  $reccount = min($showrecs * $page, $count);
                ?>
                <br>
                <span class="frmheading">Worksheet Repeats</span>
                <hr size="1" noshade>
                <form action="worksheet_repeats.php" method="post">
                    <table align="right" style="margin-right:15px; "  border="0" cellspacing="1" cellpadding="4">
                        <tr>
                            <td><b>Custom Filter</b>&nbsp;</td>
                            <td><input type="text" name="filtertext" value="<?php echo $filtertext ?>"></td>
                            <td>
                                <select name="filter_fieldrepeat">
                                    <option value="allfields">All Fields</option>
                                    <option value="<?php echo "rpt_type" ?>"<?php if ($filterfieldrepeat == "rpt_type") { echo "selected"; } ?>>Repeat Type</option>
                                    <option value="<?php echo "lp1.name" ?>"<?php if ($filterfieldrepeat == "lp1.name") { echo "selected"; } ?>>Client</option>
                                    <option value="<?php echo "lp2.con_Firstname" ?>"<?php if ($filterfieldrepeat == "lp2.con_Firstname") { echo "selected"; } ?>>Contact Name</option>
                                    <option value="<?php echo "lp3.mas_Description" ?>"<?php if ($filterfieldrepeat == "lp3.mas_Description") { echo "selected"; } ?>>Master Activity</option>
                                    <option value="<?php echo "lp4.sub_Description" ?>"<?php if ($filterfieldrepeat == "lp4.sub_Description") { echo "selected"; } ?>>Sub Activity</option>
                                    <option value="<?php echo "lp5.pri_Description" ?>"<?php if ($filterfieldrepeat == "lp5.pri_Description") { echo "selected"; } ?>>Priority</option>
                                    <option value="<?php echo "teamincharge" ?>"<?php if ($filterfieldrepeat == "teamincharge") { echo "selected"; } ?>>Team In Charge</option>
                                    <option value="<?php echo "staffincharge" ?>"<?php if ($filterfieldrepeat == "staffincharge") { echo "selected"; } ?>>Staff In Charge</option>
                                    <option value="<?php echo "managerincharge" ?>"<?php if ($filterfieldrepeat == "managerincharge") { echo "selected"; } ?>>Manager In Charge</option>
                                    <option value="<?php echo "seniorincharge" ?>"<?php if ($filterfieldrepeat == "seniorincharge") { echo "selected"; } ?>>Senior In Charge</option>
                                </select>
                            </td>
                            <td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" name="action" value="Apply Filter"></td>
                            <td><a href="worksheet_repeats.php?a=reset"  class="hlight">Reset Filter</a></td>
                        </tr>
                    </table>
                </form>
                <p>&nbsp;</p>
                <br><br>
                <table class="fieldtable_outer" align="center">
                    <tr>
                        <td>
                        <?php $this->showpagenav($page, $pagecount); ?>
                            <table class="fieldtable" align="center"  border="0"   width="100%">
                                <tr class="fieldheader">
                                <th  class="fieldheader"  align="center"><a class="hr" href="worksheet_repeats.php?order=<?php echo "rpt_type" ?>&type=<?php echo $ordtypestr ?>">Repeat Type</a></th>
                                <th class="fieldheader">End Date</th>
                                <th class="fieldheader"><a class="hr" href="worksheet_repeats.php?order=<?php echo "lp_wrk_CompanyName" ?>&type=<?php echo $ordtypestr ?>">Client</a></th>
                                <th class="fieldheader"><a class="hr" href="worksheet_repeats.php?order=<?php echo "lp_wrk_ClientContact" ?>&type=<?php echo $ordtypestr ?>">Contact Name</a></th>
                                <th class="fieldheader"><a class="hr" href="worksheet_repeats.php?order=<?php echo "lp_wrk_MasterActivity" ?>&type=<?php echo $ordtypestr ?>">Master Activity</a></th>
                                <th class="fieldheader"><a class="hr" href="worksheet_repeats.php?order=<?php echo "lp_wrk_SubActivity" ?>&type=<?php echo $ordtypestr ?>">Sub Activity</a></th>
                                <th class="fieldheader"><a class="hr" href="worksheet_repeats.php?order=<?php echo "lp_wrk_Priority" ?>&type=<?php echo $ordtypestr ?>">Priority</a></th>
                                <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_TeamInCharge" ?>&type=<?php echo $ordtypestr ?>">Team In Charge</a></th>
                                <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_StaffInCharge" ?>&type=<?php echo $ordtypestr ?>">Staff In Charge</a></th>
                                <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_ManagerInChrge" ?>&type=<?php echo $ordtypestr ?>">Manager In Charge</a></th>
                                <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_SeniorInCharge" ?>&type=<?php echo $ordtypestr ?>">Senior In Charge</a></th>
                                    <?php
                                      if($access_file_level_worksheet['stf_Add']=="Y")
                                      {
                                    ?>
                                        <th class="fieldheader">Copy</th>
                                    <?php }
                                        if($access_file_level_worksheet['stf_Delete']=="Y" && $access_file_level['stf_Delete']=="Y")
                                        {
                                    ?>
                                            <th class="fieldheader">Delete</th>
                                    <?php } ?>
                                </tr>
                                    <?php
                                      for ($i = $startrec; $i < $reccount; $i++)
                                      {
                                        $row = mysql_fetch_assoc($res);
                                        if($row['wrk_Rptid']!=0) {
                                        $rpt_type_desc= str_replace("<br />","",$commonUses->getRepeatTypeDesc($row["rpt_id"],$row,true).$commonUses->getEndDate($row["rpt_id"],$row,true));
                                        $rpt_type_desc= str_replace("\r\n","|",$rpt_type_desc);
                                      ?>
                                        <tr <?php if($row["rpt_type"]!="none") echo $row["rpt_end_date"] <= 7 &&  $row["rpt_end_date"] >0 ? "style=\"background-color:#FF5555\"":"" ?>>
                                        <td class="<?php echo $style ?>"><?php if($row["rpt_type"]!="none")  echo $commonUses->getRepeatTypeDesc($row["rpt_id"],$row,true); else echo "None";?></td>
                                        <td class="<?php echo $style ?>"><?php if($row["rpt_type"]!="none")  echo $commonUses->getEndDate($row["rpt_id"],$row,true); else echo "None";?></td>
                                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_CompanyName"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_ClientContact"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_MasterActivity"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_SubActivity"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_Priority"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_TeamInCharge"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_StaffInCharge"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_ManagerInChrge"]) ?></td>
                                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_SeniorInCharge"]) ?></td>
                                        <?php
                                          if($access_file_level_worksheet['stf_Add']=="Y")
                                                  {
                                        ?>
                                        <td class="<?php echo $style ?>" align="center" style="background-color:white"><a href="wrk_worksheet.php?a=add&rpt_id=<?php echo $row["wrk_Rptid"];?>" class="hlight" target="_blank">Copy</a></td>
                                        <?php } ?>
                                        <?php
                                          if($access_file_level_worksheet['stf_Delete']=="Y"  && $access_file_level['stf_Delete']=="Y")
                                                  {
                                        ?>
                                        <td class="<?php echo $style ?>" align="center" style="background-color:white">
                                        <a HREF="javascript:void(0)"
                                        onClick="javascript:
                                        NewWindow('worksheet_repeats.php?a=view_wrksheet&rpt_id=<?php echo $row["wrk_Rptid"];?>&rpt_type=<?php echo $rpt_type_desc;?>','WorksheetDetails','1000','410','yes')"
                                        class="hlight" >Delete</a>
                                        </td>
                                        <?php  }?>
                                        </tr>
                                        <?php }
                                        }
                                          mysql_free_result($res);
                                        ?>
                            </table>
                <br>
        <?php
        }
         function showpagenav($page, $pagecount)
        {
        ?>
                <table  border="0" cellspacing="1" cellpadding="4" align="right">
                    <tr>
                        <td>&nbsp; </td>
                        <?php if ($page > 1) { ?>
                        <td><a href="worksheet_repeats.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;Prev</a>&nbsp;</span></td>
                        <?php } ?>
                        <?php
                          global $pagerange;
                          if ($pagecount > 1) {
                          if ($pagecount % $pagerange != 0) {
                            $rangecount = intval($pagecount / $pagerange) + 1;
                          }
                          else {
                            $rangecount = intval($pagecount / $pagerange);
                          }
                          for ($i = 1; $i < $rangecount + 1; $i++) {
                            $startpage = (($i - 1) * $pagerange) + 1;
                            $count = min($i * $pagerange, $pagecount);

                            if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
                              for ($j = $startpage; $j < $count + 1; $j++) {
                                if ($j == $page) {
                        ?>
                        <td><strong><span class="hlight_current" ><?php echo $j ?></span></strong></td>
                        <?php } else { ?>
                        <td><a href="worksheet_repeats.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                        <?php } } } else { ?>
                        <td><a href="worksheet_repeats.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                        <?php } } } ?>
                        <?php if ($page < $pagecount) { ?>
                        <td>&nbsp;<a href="worksheet_repeats.php?page=<?php echo $page + 1 ?>"><span class="nav_links">Next&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                        <?php } ?>
                    </tr>
                </table>
        <?php }
        function showrecnav($a, $recid, $count)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4"  align="right">
                <tr>
                     <?php if ($recid > 0) { ?>
                    <td><a href="worksheet_repeats.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                    <?php } if ($recid < $count - 1) { ?>
                    <td><a href="worksheet_repeats.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
                    <?php } ?>
                </tr>
            </table>
            <br>
            <span class="frmheading">
                Worksheet Repeats
            </span>
            <hr size="1" noshade>
        <?php }
        function viewrec_wrksheet($recid)
        {
                  if($recid!=0)
                  {
                      global $a;
                      global $showrecs;
                      global $page;
                      global $filtertext;
                      global $filterfieldrepeat;
                      global $wholeonly;
                      global $order;
                      global $ordtype;
                      global $access_file_level_worksheet;
                      global $access_file_level;
                      global $commonUses;
                      
                       $checkstr = "";
                      if ($wholeonly) $checkstr = " checked";
                      if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
                      $sql="select t1.*,lp1.`name` AS `lp_wrk_ClientCode`, lp2.`con_Firstname` AS `lp_wrk_ClientContact`,lp3.`mas_Description` AS `lp_wrk_MasterActivity`,  lp4.`sub_Description` AS `lp_wrk_SubActivity`,lp5.`pri_Description` AS `lp_wrk_Priority`,w2.`wst_Description` AS `lp_wrk_Status`   from wrk_worksheet t1 LEFT OUTER JOIN `jos_users` AS lp1 ON (t1.`wrk_ClientCode` = lp1.`cli_Code`) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`wrk_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `pri_priority` AS lp5 ON (t1.`wrk_Priority` = lp5.`pri_Code`)  LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`wrk_SubActivity` = lp4.`sub_Code`) 		LEFT OUTER JOIN `wst_worksheetstatus` AS w2 ON ( t1.`wrk_Status` = w2.`wst_Code` )    where t1.wrk_Rptid=$recid and t1.wrk_Rptid!=0";
                      if (isset($order) && $order!='') $sql .= " order by t1.`wrk_InternalDueDate`,`" .sqlstr($order) ."`";
                      if (!isset($order) && $order=='') $sql .= " order by t1.`wrk_InternalDueDate` asc";
                      if (isset($ordtype) && $ordtype!='') $sql .= " " .sqlstr($ordtype);
                      $res =  mysql_query($sql);
                      $count = mysql_num_rows($res);
                      if ($count % $showrecs != 0) {
                        $pagecount = intval($count / $showrecs) + 1;
                      }
                      else {
                        $pagecount = intval($count / $showrecs);
                      }
                      $startrec = $showrecs * ($page - 1);
                      if ($startrec < $count) {mysql_data_seek($res, $startrec);}
                      $reccount = min($showrecs * $page, $count);
                      ?>
                     <p>Please confirm to delete this Repeat (<?php echo str_replace("|",", Until=",$_GET['rpt_type']);?>) and its associated worhsheets shown below:</p>
                     <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" width="100%" >
                        <tr class="fieldheader">
                        <?php
                          if($access_file_level_worksheet['stf_Delete']=="Y")
                          {
                        ?>
                            <th>
                                <input type='checkbox' name='checkall' onclick='checkedAll();'>
                            </th>
                        <?php } ?>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_ClientContact" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Client</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_TeamInCharge" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Team In Charge</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_StaffInCharge" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Staff In Charge</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_Priority" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Priority</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_MasterActivity" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Master Activity</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_Details" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Last Reports Sent</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_Notes" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Current Job in Hand</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_TeamInChargeNotes" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Team Incharge Notes</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_DueDate" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">External Due Date</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "wrk_InternalDueDate" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Befree Due Date</a></th>
                            <th class="fieldheader"><a  href="worksheet_repeats.php?order=<?php echo "lp_wrk_Status" ?>&type=<?php echo $ordtypestr ?>&a=view_wrksheet&rpt_id=<?php echo $recid?>">Status</a></th>
                         </tr>
                          <form name="wrk_delete" id="wrk_delete" method="post" action="worksheet_repeats.php?a=view_wrksheet&rpt_id=<?php echo $_GET['rpt_id']?>&rpt_type=<?php echo $_GET['rpt_type'] ?>">
                        <?php
                          for ($i = 0; $i < $count; $i++)
                          {
                                $row = mysql_fetch_assoc($res);
                            ?>
                            <tr>
                                <?php
                                  if($access_file_level_worksheet['stf_Delete']=="Y"  && $access_file_level['stf_Delete']=="Y")
                                  {
                                ?>
                                    <td>&nbsp;&nbsp;<input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['wrk_Code']; ?>"></td>
                                <?php } ?>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_ClientCode"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_TeamInCharge"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_StaffInCharge"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_Priority"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_Code"]).($row["lp_wrk_Code"]!=""? "-":"").htmlspecialchars($row["lp_wrk_MasterActivity"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["wrk_Details"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["wrk_Notes"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["wrk_TeamInChargeNotes"]) ?></td>
                                    <td class="<?php echo $style ?>" >
                                    <?php
                                        if($row["wrk_DueDate"]!="0000-00-00") {
                                        $phpDueDate = strtotime( $row["wrk_DueDate"] );
                                        echo date("d-M-Y",$phpDueDate); } else { echo ""; } ?>
                                    </td>
                                <td class="<?php echo $style ?>" >
                                <?php
                                if($row["wrk_InternalDueDate"]!="0000-00-00") {
                                $phpInternalDueDate = strtotime( $row["wrk_InternalDueDate"] );
                                echo date("d-M-Y",$phpInternalDueDate); } else { echo ""; } ?>
                                </td>
                                <td nowrap>
                                <?php
                                 echo htmlspecialchars($row["lp_wrk_Status"]);
                                ?>
                                </td>
                            </tr>
                        <?php
                           }
                         ?>
                    </table>
                    <br>
                    <hr size="1" noshade>
                    <input type="submit" name="submit" value="Confirm" onClick='return ComfirmDelete();'  class="cancelbutton" ><input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/> <input type="hidden" name="wrkcode"  value="<?php echo $row['wrk_Code']; ?>" id="rpt_id"><input type="hidden" name="rpd_id"  value="<?php echo $recid ?>" id="rpt_id"><input type="hidden" name="count"  value="<?php echo $reccount ?>" id="count">
                    </form>
                    <?php
                      mysql_free_result($res);
                }
        }
}
	$repeatsContent = new repeatsContentList();

?>

