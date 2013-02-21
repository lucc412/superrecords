<?php
class worksheetContentList extends Database
{
       // worksheet grid content
	 
       function select($access_file_level,$clientCode,$page_flag)
       {
          global $a;
          global $showrecs;
          global $page;
          global $page_records;
          global $filter;
          global $filterfield;
          global $wholeonly;
          global $order;
          global $ordtype;
          global $worksheetQuery;
          global $commonUses;
          
          if ($a == "reset") {
            $filter = "";
            $filterfield = "";
            $wholeonly = "";
            $order = "";
            $ordtype = "";
          }
          $page_records = $page_flag;
          $checkstr = "";
          if ($wholeonly) $checkstr = " checked";
          if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
          $res = $worksheetQuery->sql_select($clientCode,&$count,&$filter,&$filterfield,&$wholeonly);
          //$count = $worksheetQuery->sql_getrecordcount($clientCode);
          if ($count % $showrecs != 0) {
            $pagecount = intval($count / $showrecs) + 1;
          }
          else {
            $pagecount = intval($count / $showrecs);
          }
           $startrec = $showrecs * ($page_records - 1);
          if ($startrec < $count) {mysql_data_seek($res, $startrec);}
          $reccount = min($showrecs * $page_records, $count);
        ?>
        <table class="fieldtable1" align="center">
            <tr>
                <td>
                   <table class="fieldtable" align="right"  border="0" cellspacing="1" cellpadding="5" width="100%" >
                    <?php
                    if($count >0 )
                    {
                    ?>
                        <tr><td colspan="12">
                            <?php $this->showpagenav_client($page_records, $pagecount,$clientCode);  ?>
                            </td>
                        </tr>
                        <tr class="fieldheader">
                            <?php
                              if($access_file_level['stf_Delete']=="Y")
                              {
                            ?>
                            <th></th>
                            <?php } ?>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_ClientContact" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Client</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_TeamInCharge" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Team In Charge</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_StaffInCharge" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Staff In Charge</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_Priority" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Priority</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_MasterActivity" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Master Activity</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_SubActivity" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Sub Activity</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "wrk_Details" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Last Reports Sent</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "wrk_Notes" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Current Job in Hand</a></th>
                            <th class="fieldheader" style="padding:0px 40px 0px 40px;"><a  href="wrk_worksheet.php?order=<?php echo "wrk_TeamInChargeNotes" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Team Incharge Notes</a></th>
                            <th class="fieldheader" nowrap style="width:180px;"><a  href="wrk_worksheet.php?order=<?php echo "wrk_DueDate" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">External Due Date</a></th>
                            <th class="fieldheader" nowrap style="width:180px;"><a  href="wrk_worksheet.php?order=<?php echo "wrk_InternalDueDate" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Befree Due Date</a></th>
                            <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_Status" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Status</a></th>
                            <th  class="fieldheader" colspan="5" align="center">Actions</th>
                        </tr>
                    <?php
                    }
                    else
                    {
                    ?>
                      <tr><th nowrap align="center">No records added yet.</th></tr>
                    <?php
                    }
                    ?>
                    <?php
                      for ($i = $startrec; $i <$reccount; $i++)
                      {
                            $row = mysql_fetch_assoc($res);
                            ?>
                            <form name="wrkrowedit" id="wrkrowedit_<?php echo $row['wrk_Code']; ?>" method="post" action="wrk_worksheet.php" enctype="multipart/form-data">
                                <tr <?php echo ($row["wrk_InternalDueDate"]!="0000-00-00" && $row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:#FFAA7F\"":"") ?>>
                                <?php
                                  if($access_file_level['stf_Delete']=="Y")
                                  {
                                ?>
                                    <td>&nbsp;&nbsp;<input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $row['wrk_Code']; ?>"><input type="hidden" name="count"  value="<?php echo $reccount ?>" id="count"></td>
                                <?php } ?>
                                    <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_wrk_ClientCode"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_TeamInCharge"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_StaffInCharge"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_wrk_Priority"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_wrk_Code"]).($row["lp_wrk_Code"]!=""? "-":"").stripslashes($row["lp_wrk_MasterActivity"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_wrk_subCode"]).($row["lp_wrk_subCode"]!=""? "-":"").stripslashes($row["lp_wrk_SubActivity"]) ?></td>
                                <?php
                                         if($_GET['page']!="")
                                         $addquery="page=".$_GET['page'];
                                         if($_GET['order']!="" && $_GET['type']!="")
                                         $addquery="order=".$_GET['order']."&type=".$_GET['type'];
                                         $wrkCode = $row["wrk_Code"];
                                ?>
                                    <td class="<?php echo $style ?>">
                                        <textarea name="wrk_Details[<?php echo $row['wrk_Code']; ?>]" rows="3" cols="25"><?php echo stripslashes($row["wrk_Details"]) ?></textarea>
                                    </td>
                                    <td class="<?php echo $style ?>">
                                        <textarea name="wrk_Notes[<?php echo $row['wrk_Code']; ?>]" rows="3" cols="25"><?php echo stripslashes($row["wrk_Notes"]) ?></textarea>
                                    </td>
                                    <td class="<?php echo $style ?>">
                                        <textarea name="wrk_TeamInChargeNotes[<?php echo $row['wrk_Code']; ?>]" rows="3" cols="25"><?php echo stripslashes($row["wrk_TeamInChargeNotes"]) ?></textarea>
                                    </td>
                                    <td class="<?php echo $style ?>" >
                                        <?php if($access_file_level['stf_Edit']=="Y") { ?>
                                                                    <input type="text" name="wrk_DueDate[<?php echo $row['wrk_Code']; ?>]" id="wrk_DueDate<?php echo $i; echo $clientCode; ?>" value="<?php  if (isset($row["wrk_DueDate"]) && $row["wrk_DueDate"]!="") {
                                                                    if($row["wrk_DueDate"]!="0000-00-00")
                                                                      $php_duedate = date("d/m/Y",strtotime( $row["wrk_DueDate"] ));
                                                                     else
                                                                     $php_duedate="";
                                                                    echo  $php_duedate ; }  ?>">&nbsp;<a href="javascript:NewCal('wrk_DueDate<?php echo $i; echo $clientCode; ?>','ddmmyyyy',false,24)"><img
                                                                    src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                        <?php
                                        }
                                        else {
                                         $phpDueDate = strtotime( $row["wrk_DueDate"] );
                                         echo date("d-M-Y",$phpDueDate);
                                         ?>
                                                                    <input type="hidden" name="wrk_DueDate[<?php echo $row['wrk_Code']; ?>]" value="<?php if($row["wrk_DueDate"]!="0000-00-00") { echo date("d/m/Y",strtotime( $row["wrk_DueDate"] )); } else { echo ""; } ?>"
                                                                    <?php
                                        }
                                    ?>
                                    </td>
                                    <td class="<?php echo $style ?>">
                                        <?php if($access_file_level['stf_Edit']=="Y") { ?>
                                                                    <input type="text" name="wrk_InternalDueDate[<?php echo $row['wrk_Code']; ?>]" id="wrk_InternalDueDate<?php echo $i; echo $clientCode; ?>" value="<?php  if (isset($row["wrk_InternalDueDate"]) && $row["wrk_InternalDueDate"]!="") {
                                                                    if($row["wrk_InternalDueDate"]!="0000-00-00")
                                                                      $php_Induedate = date("d/m/Y",strtotime( $row["wrk_InternalDueDate"] ));
                                                                     else
                                                                     $php_Induedate="";
                                                                    echo  $php_Induedate ; }  ?>">&nbsp;<a href="javascript:NewCal('wrk_InternalDueDate<?php echo $i; echo $clientCode; ?>','ddmmyyyy',false,24)"><img
                                                                    src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                    <?php
                                        }
                                        else {
                                            $phpInternalDueDate = strtotime( $row["wrk_InternalDueDate"] );
                                            echo date("d-M-Y",$phpInternalDueDate);
                                         ?>
                                                                    <input type="hidden" name="wrk_InternalDueDate[<?php echo $row['wrk_Code']; ?>]" value="<?php if($row["wrk_InternalDueDate"]!="0000-00-00") { echo date("d/m/Y",strtotime( $row["wrk_InternalDueDate"] )); } else { echo ""; } ?>"
                                                                    <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="<?php echo $style ?>" <?php echo ($row["wrk_InternalDueDate"]!="0000-00-00" && $row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?> nowrap>
                                    <?php
                                    //Check access rights
                                      if($access_file_level['stf_Edit']=="Y")
                                      {
                                    ?>
                                        <select name="wrk_Status[<?php echo $row['wrk_Code']; ?>]" id="wrk_Status_<?php echo $row['wrk_Code']; ?>">
                                            <option value="0">Select Status</option>
                                            <?php
                                              $sql_stage = "select `wst_Code`, `wst_Description` from `wst_worksheetstatus` ORDER BY wst_Order ASC";
                                              $res_stage = mysql_query($sql_stage) or die(mysql_error());

                                              while ($lp_row = mysql_fetch_assoc($res_stage)){
                                              $val = $lp_row["wst_Code"];
                                              $caption = $lp_row["wst_Description"];
                                              if ($row["wrk_Status"] ==  $val) {$selstr = " selected"; } else {$selstr = ""; }
                                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="wrk_Statusold[<?php echo $row['wrk_Code']; ?>]">
                                     <?php
                                    }
                                    else
                                    {
                                    echo stripslashes($row["lp_wrk_Status"]);
                                    ?>
                                        <input type="hidden" name="wrk_Status[<?php echo $row['wrk_Code']; ?>]" value="<?php echo $row["wrk_Status"]; ?>">
                                        <input type="hidden" name="wrk_Statusold[<?php echo $row['wrk_Code']; ?>]">
                                        <?php
                                    }
                                    ?>
                                    </td>
                                    <?php
                                          if($access_file_level['stf_Edit']=="Y")
                                          {
                                                 $formurl = "wrk_worksheet.php?a=copy&copid=".$row['wrk_Code'];
                                    ?>
                                           <td style="background-color:white;">
                                                   <img src="images/save.png" border="0"  alt="Edit" name="Edit" title="Save" align="middle" onClick="inlineSave('<?php echo $row['wrk_Code']; ?>','<?php echo $addquery; ?>','<?php echo $clientCode; ?>','<?php echo $page_records; ?>','<?php echo $row["wrk_MasterActivity"]; ?>','<?php echo $formurl; ?>','Worksheet','440','250','yes')" />
                                           </td>
                                    <?php } ?>
                                           <td style="background-color:white;">
                                                <?php $formurl = "wrk_worksheet.php?a=copy&copid=".$row['wrk_Code']; ?>
                                                <img src="images/copyimg.png" border="0"  alt="Copy" name="Copy" title="Copy" align="middle" onClick="copyWindow('<?php echo $formurl; ?>','Worksheet','440','250','yes')" >
                                           </td>
                                    <?php
                                        if($access_file_level['stf_View']=="Y")
                                        {
                                    ?>
                                            <td <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?>>
                                            <a href="wrk_worksheet.php?a=view&recid=<?php echo $row['wrk_Code']; ?>&client=<?php echo $clientCode; ?>">
                                            <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                                            </td>
                                    <?php }
                                    if($access_file_level['stf_Edit']=="Y")
                                    {
                                    ?>
                                        <td <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?>>
                                        <a href="wrk_worksheet.php?a=edit&recid=<?php echo $row['wrk_Code']; ?>&client=<?php echo $clientCode; ?>">
                                        <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                                        </td>
                                    <?php }
                                    if($access_file_level['stf_Delete']=="Y")
                                    {
                                    ?>
                                        <td <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?>>
                                        <a onClick="performdelete('wrk_worksheet.php?mode=delete&recid=<?php echo stripslashes($row["wrk_Code"]) ?>&client=<?php echo $clientCode; ?>'); return false;" href="#">
                                        <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                                        </td>
                                    <?php } ?>
                            </form>

                    <?php
                      }
                      mysql_free_result($res);
                    ?>
                    </table>
                                    <input type="submit" name="submit" value="Delete" onClick='return ComfirmDelete();'  class="cancelbutton">
                <br>
               </td>
            </tr>
          </table>
         <?php
         }
         function select_clients($access_file_level)
         {
                  global $a;
                  global $showrecs;
                  global $page;
                  global $page_records;
                  global $filter;
                  global $filterfield;
                  global $wholeonly;
                  global $order;
                  global $ordtype;
                  global $worksheetQuery;
                  
                  if ($a == "reset") {
                    $filter = "";
                    $filterfield = "";
                    $wholeonly = "";
                    $order = "";
                    $ordtype = "";
                  }
                  $checkstr = "";
                  if ($wholeonly) $checkstr = " checked";
                  if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
                  $res = $worksheetQuery->sql_select_users(&$count);
                 // $count = $worksheetQuery->sql_getrecordcount_users();
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
                <span class="frmheading">Work Sheet</span>
                <hr size="1" noshade>
                <form action="wrk_worksheet.php" method="post">
                    <table align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
                    <tr>
                        <td><b>Custom Filter</b>&nbsp;</td>
                        <td><input type="text" name="filter" value="<?php if($filter=='0') $filter = "";  echo $filter ?>"></td>
                        <td>
                            <select name="filter_field">
                                <option value="">All Fields</option>
                                 <option value="<?php echo "lp_wrk_ClientCode" ?>"<?php if ($filterfield == "lp_wrk_ClientCode") { echo "selected"; } ?>>Client</option>
                                <option value="<?php echo "lp_wrk_ClientContact" ?>"<?php if ($filterfield == "lp_wrk_ClientContact") { echo "selected"; } ?>>Contact</option>
                                <option value="<?php echo "lp_wrk_MasterActivity" ?>"<?php if ($filterfield == "lp_wrk_MasterActivity") { echo "selected"; } ?>>Master Activity</option>
                                <option value="<?php echo "lp_wrk_SubActivity" ?>"<?php if ($filterfield == "lp_wrk_SubActivity") { echo "selected"; } ?>>Sub Activity</option>
                                <option value="<?php echo "lp_wrk_Priority" ?>"<?php if ($filterfield == "lp_wrk_Priority") { echo "selected"; } ?>>Priority</option>
                                <option value="<?php echo "lp_wrk_Status" ?>"<?php if ($filterfield == "lp_wrk_Status") { echo "selected"; } ?>>Status</option>
                                <option value="<?php echo "lp_wrk_StaffInCharge" ?>"<?php if ($filterfield == "lp_wrk_StaffInCharge") { echo "selected"; } ?>>Staff In Charge</option>
                                <option value="<?php echo "lp_wrk_TeamInCharge" ?>"<?php if ($filterfield == "lp_wrk_TeamInCharge") { echo "selected"; } ?>>Team In Charge</option>
                                <option value="<?php echo "lp_wrk_ManagerInChrge" ?>"<?php if ($filterfield == "lp_wrk_ManagerInChrge") { echo "selected"; } ?>>Manager In Charge</option>
                                <option value="<?php echo "lp_wrk_SeniorInCharge" ?>"<?php if ($filterfield == "lp_wrk_SeniorInCharge") { echo "selected"; } ?>>Senior In Charge</option>
                                <option value="<?php echo "wrk_ClosureReason" ?>"<?php if ($filterfield == "wrk_ClosureReason") { echo "selected"; } ?>>Closure Reason</option>
                                <option value="<?php echo "wrk_HoursSpent" ?>"<?php if ($filterfield == "wrk_HoursSpent") { echo "selected"; } ?>>Hours Spent</option>
                                <option value="<?php echo "wrk_Details" ?>"<?php if ($filterfield == "wrk_Details") { echo "selected"; } ?>>Last Reports Sent</option>
                                <option value="<?php echo "wrk_Resolution" ?>"<?php if ($filterfield == "wrk_Resolution") { echo "selected"; } ?>>Resolution</option>
                                <option value="<?php echo "wrk_Notes" ?>"<?php if ($filterfield == "wrk_Notes") { echo "selected"; } ?>>Current Job in Hand</option>
                                <option value="<?php echo "wrk_TeamInChargeNotes" ?>"<?php if ($filterfield == "wrk_TeamInChargeNotes") { echo "selected"; } ?>>Team In Charge Notes</option>
                                <option value="<?php echo "wrk_RelatedCases" ?>"<?php if ($filterfield == "wrk_RelatedCases") { echo "selected"; } ?>>Related Cases</option>
                                <option value="<?php echo "wrk_Recurring" ?>"<?php if ($filterfield == "wrk_Recurring") { echo "selected"; } ?>>Recurring</option>
                                <option value="<?php echo "lp_wrk_Schedule" ?>"<?php if ($filterfield == "lp_wrk_Schedule") { echo "selected"; } ?>>Schedule</option>
                                <option value="<?php echo "wrk_Day" ?>"<?php if ($filterfield == "wrk_Day") { echo "selected"; } ?>>Day</option>
                            </select>
                        </td>
                        <td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="action" value="Apply Filter"></td>
                        <td><a href="wrk_worksheet.php?a=reset" class="hlight" >Reset Filter</a></td>
                    </tr>
                    </table>
                </form>
                <p>&nbsp;</p>
                <br><br>
                <table class="fieldtable_outer11" align="left">
                    <tr>
                        <td>
                        <?php
                          if($access_file_level['stf_Add']=="Y")
                                  {
                        ?>
                        <a href="wrk_worksheet.php?a=add" class="hlight">
                        <img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
                        <?php } ?>
                        <?php $this->showpagenav($page, $pagecount);  ?>
                        <br><br>
                        <!--<form method="post" name="worksheet_update" id="worksheet_update" style="margin:0px 0px;">-->
                            <table class="fieldtable1"  border="0" cellspacing="1" cellpadding="5" width="100%" >
                                <tr class="fieldheader">
                                    <th class="fieldheader">Client</th>
                                </tr>
                                <?php
                                  for ($i = $startrec; $i <$reccount; $i++)
                                  {
                                    $row = mysql_fetch_assoc($res);
									$page_flag =  ($_GET['client']==$row['wrk_ClientCode'])?(($_GET['page_records'] != "")?$_GET['page_records']:$page_records):"1";
									$pages = ($_GET['page'])?$_GET['page']:"1";
                                                                        if($filter=="") $filter = '0';
                                                                        if($filterfield=="") $filterfield = '0';
                                                                        if($wholeonly=="") $wholeonly = '0';
									if($_GET['client']==$row['wrk_ClientCode'])
									{
										echo "<script>enable_divs(".$row['wrk_ClientCode'].",".$page_flag.",".$pages.",'".$filter."','".$filterfield."',".$wholeonly.");</script>";
									}
									
                                ?>
                                <tr>
                                    <td class="<?php echo $style ?>"><a href="javascript:;" onClick="return enable_divs(<?php echo $row['wrk_ClientCode']; ?>,<?php echo  $page_flag; ?>,<?php echo $pages; ?>,'<?php echo $filter; ?>','<?php echo $filterfield; ?>','<?php echo $wholeonly; ?>');" ><img src="<?php echo ($_GET['client']==$row['wrk_ClientCode'])?"images/minus.gif":"images/plus.gif"; ?>" border="0"  id="img_<?php echo $row['wrk_ClientCode']; ?>" /></a>&nbsp;&nbsp;<?php echo stripslashes($row["lp_wrk_ClientCode"]) ?></td>
                                </tr>
                                <tr>
                                    <td class="<?php echo $style ?>">
                                    <form name="wrkrowedit_<?php echo $row['wrk_ClientCode']; ?>"  id="wrkrowedit_<?php echo $row['wrk_ClientCode']; ?>"  method="post"enctype="multipart/form-data" action="wrk_worksheet.php" >
                                        <div id="div_<?php echo $row['wrk_ClientCode']; ?>" style="display:<?php echo ($_GET['client']==$row['wrk_ClientCode'])?"inline":"none;"; ?>;"><img src="images/loading.gif" />
                                        
                                          <?php
                                           // $page_flag =  ($_GET['client']==$row['wrk_ClientCode'])?(($_GET['page_records'] != "")?$_GET['page_records']:$page_records):"1";
											//$this->select($access_file_level,$row['wrk_ClientCode'],$page_flag);
                                          ?>
                                        </div>
                                        <input type="hidden" name="client_ids[]" value="<?php echo $row['wrk_ClientCode']; ?>" >
                                      </form>
                                    </td>
                                </tr>
                                <?php
                              }
                              mysql_free_result($res);
                            ?>
                            </table>
                        <p>
                        <!--</form>-->
        <?php $this->showpagenav($page, $pagecount);
         }
	     function showrow($row, $recid)
         {
            global $commonUses;
             ?>
                <div class="right_clientname" style="position:relative; top:-52px;"><?php echo stripslashes($row["lp_wrk_ClientCode"]); ?></div>
                 <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
                    <tr>
                            <td style="width: 80px; height:30px" class="tabsel" id="page4Tab">
                            <a ID="lnkPage4" onClick="switchTab('page4')" href="javascript:void(0)">Details</a></td>
                           <td style="width: 80px" class="tab" id="page5Tab">
                            <a ID="lnkPage5" OnClick="switchTab('page5')" href="javascript:void(0)" >Closure</a></td>
                    </tr>
                </table>
                <div id="page4">
                    <table align="center"    border="0" cellspacing="1" cellpadding="5"width="50%">
                         <tr>
                            <td class="hr">Client</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_ClientCode"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Contact</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_ClientContact"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Master Activity</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_Code"]).($row["lp_wrk_Code"]!=""? "-":"").stripslashes($row["lp_wrk_MasterActivity"]) ?></td>
                        </tr>
                        <?php if($row['wrk_MasterActivity']=="15") { ?>
                        <tr>
                            <td>CRM Notes</td>
                            <td><?php echo stripslashes($row["wrk_crmnotes"]); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="hr">Sub Activity</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_subCode"]).($row["lp_wrk_subCode"]!=""? "-":"").stripslashes($row["lp_wrk_SubActivity"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Priority</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_Priority"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Status</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_Status"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Team In Charge</td>
                            <td class="dr"><?php echo $commonUses->getFirstLastName($row["wrk_TeamInCharge"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Staff In Charge</td>
                            <td class="dr"><?php echo $commonUses->getFirstLastName($row["wrk_StaffInCharge"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Manager In Chrge</td>
                            <td class="dr"><?php echo $commonUses->getFirstLastName($row["wrk_ManagerInChrge"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Senior In Chrge</td>
                            <td class="dr"><?php echo $commonUses->getFirstLastName($row["wrk_SeniorInCharge"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">External Due Date</td>
                            <td class="dr"><?php echo $commonUses->showGridDateFormat($row["wrk_DueDate"]); ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Befree Due Date</td>
                            <td class="dr"><?php echo $commonUses->showGridDateFormat($row["wrk_InternalDueDate"]); ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Due Time</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_DueTime"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Last Reports Sent</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_Details"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Resolution</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_Resolution"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Current Job in Hand</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_Notes"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Team In Charge Notes</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_TeamInChargeNotes"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Related Cases</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_RelatedCases"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Recurring</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_Recurring"])=='Y'?'Yes':'No'; ?>
                         </td>
                        </tr>
                        <tr>
                            <td class="hr">Schedule</td>
                            <td class="dr"><?php echo stripslashes($row["lp_wrk_Schedule"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Date</td>
                            <td class="dr"><?php echo $commonUses->showGridDateFormat($row["wrk_Date"]) ?></td>
                        </tr>
                        <tr>
                            <td class="hr">Day</td>
                            <td class="dr"><?php echo stripslashes($row["wrk_Day"]) ?></td>
                        </tr>
                    </table>
                    <br>
                    <span  class="footer2"  style='font-size:96%;'>Created by: <?php echo stripslashes($row["wrk_Createdby"]) ?> | Created on: <?php echo $commonUses->showGridDateFormat($row["wrk_Createdon"]); ?> | Lastmodified by: <?php echo stripslashes($row["wrk_Lastmodifiedby"]) ?> | Lastmodified on: <?php echo  $commonUses->showGridDateFormat($row["wrk_Lastmodifiedon"]); ?></span>
                </div>
                    <div id="page5" style="display:none;">
                        <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
                            <tr>
                                <td class="hr">Completion Date</td>
                                <td class="dr"><?php echo stripslashes($row["wrk_ClosedDate"]=='0000-00-00'?'':showGridDateFormat($row["wrk_ClosedDate"])); ?></td>
                            </tr>
                            <tr>
                                <td class="hr">Closure Reason</td>
                                <td class="dr"><?php echo stripslashes($row["wrk_ClosureReason"]) ?></td>
                            </tr>
                            <tr>
                                <td class="hr">Hours Spent</td>
                                <td class="dr"><?php echo stripslashes($row["wrk_HoursSpent"]) ?></td>
                            </tr>
                        </table>
                    </div>
           <?php
           }
           function showroweditor($row, $iseditmode)
           {
                global $commonUses;
                
                if($_GET['rpt_id']!="")
                  {
                   $repeat_res = mysql_query("select t1.*,lp1.`sub_Description` AS `lp_wrk_SubActivity`,lp2.`con_Firstname` AS `lp_wrk_ClientContact`,lp3.* from wrk_worksheet t1 LEFT OUTER JOIN `sub_subactivity` AS lp1 ON ( t1.`wrk_SubActivity` = lp1.`sub_Code` ) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) LEFT OUTER JOIN `worksheet_repeats` AS lp3 ON (t1.`wrk_Rptid` = lp3.`rpt_id`)  where t1.wrk_Rptid=".$_GET['rpt_id']." Group by t1.wrk_Rptid");
                   $count = mysql_num_rows($repeat_res);
                   $row = mysql_fetch_assoc($repeat_res);
                        if ( ! empty ( $row['rpt_byday'] ) )
                        $byday = explode ( ',', $row['rpt_byday'] );

                         if ( ! empty ( $row['rpt_bymonth'] ) )
                        $bymonth = explode ( ',', $row['rpt_bymonth'] );

                        if ( ! empty ( $row['rpt_bymonthday'] ) )
                        $bymonthday = explode ( ',', $row['rpt_bymonthday'] );

                        if ( ! empty ( $row['rpt_bysetpos'] ) )
                        $bysetpos = explode ( ',', $row['rpt_bysetpos'] );

                        $byweekno = $row['rpt_byweekno'];
                        $byyearday = $row['rpt_byyearday'];
                        $rpt_count = $row['rpt_count'];
                    ?>
                   <input type="hidden" id="rpt_id" name="rpt_id" value="<?php echo $_GET['rpt_id']; ?>" />
                   <?php
                  }
                  ?>
                <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
                    <tr>
                        <td style="width: 80px; height:30px" class="tabsel" id="page1Tab">
                        <a ID="lnkPage1" onClick="switchTab('page1')" href="javascript:void(0)">Details</a></td>
                        <?php
                                //if(!$iseditmode) {
                                ?>
                        <td style="width: 80px" class="tab" id="page2Tab">
                        <a ID="lnkPage2" OnClick="switchTab('page2')" href="javascript:void(0)" >Repeats</a></td>
                        <?php
                                //}
                                ?>
                       <td style="width: 80px" class="tab" id="page3Tab">
                        <a ID="lnkPage3" OnClick="switchTab('page3')" href="javascript:void(0)" >Closure</a></td>
                    </tr>
                </table>
                <div id="page1">
                    <br>
                        <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
                            <?php
                            if(!$iseditmode) {
                            ?>
                            <tr>
                                <td class="hr">Code</td>
                                <td class="dr">
                                    <?php echo "New";?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="hr">Client<font style="color:red;" size="2">*</font></td>
                                <td class="dr">
                                    <?php
                                    if($row["wrk_ClientCode"]!="")
                                    {
                                       $sql = "select `id`, `name` from `jos_users` where cli_Code=".$row["wrk_ClientCode"]." ORDER BY name ASC";
                                       $res = mysql_query($sql) or die(mysql_error());
                                       $companyname=@mysql_result( $res,0,'name');
                                      }
                                    ?>
                                    <div id="wrapper">
                                            <small style="float:right"><input type="hidden" id="wrk_ClientCode" name="wrk_ClientCode" value="" style="font-size: 10px; width: 20px;"  /></small>
                                            <input type="hidden" id="wrk_ClientCode_old" name="wrk_ClientCode_old" value="<?php echo $row["wrk_ClientCode"];?>" style="font-size: 10px; width: 20px;"  />
                                            <input style="width: 200px" tabindex="1" type="text" id="testinput" value="<?php echo $companyname?>"   onBlur="showContacts(document.getElementById('wrk_ClientCode').value)" />
                                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of the client. Start typing to view existing clients.</span></a>
                                     </div>
                                    <script type="text/javascript">
                                            var options = {
                                                    script:"dbclass/wrk_client_db_class.php?json=true&limit=6&",
                                                    varname:"input",
                                                    json:true,
                                                    shownoresults:false,
                                                    maxresults:6,
                                                    callback: function (obj) { document.getElementById('wrk_ClientCode').value = obj.id; }
                                            };
                                            var as_json = new bsn.AutoSuggest('testinput', options);
                                            var options_xml = {
                                                    script: function (input) { return "dbclass/wrk_client_db_class.php?input="+input+"&con_Company="+document.getElementById('wrk_ClientCode').value; },
                                                    varname:"input"
                                            };
                                            var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Contact</td>
                                <td class="dr">
                                    <div id="wrk_ClientContact"></div>
                                    <div id="wrk_ClientContact_old" <?php if($iseditmode) { echo "style='display:block'"; } ?>>
                                        <?php
                                            echo $row["lp_wrk_ClientContact"];
                                        ?>
                                        <input type="hidden" name="wrk_ClientContact_old" value="<?php echo $row["wrk_ClientContact"];?>">
                                    </div>
                                 </td>
                            </tr>
                            <tr>
                                <td class="hr">Master Activity<font style="color:red;" size="2">*</font></td>
                                <td class="dr">
                                    <select name="wrk_MasterActivity" tabindex="2" onChange="getSubActivityTasks(this.value,-1)"><option value="0">Select Master Activity</option>
                                        <?php
                                          $sql = "select `mas_Code`, `mas_Description`, Code from `mas_masteractivity` ORDER BY mas_Order ASC";
                                          $res = mysql_query($sql) or die(mysql_error());
                                          while ($lp_row = mysql_fetch_assoc($res)){
                                          $val = $lp_row["mas_Code"];
                                          $caption = $lp_row["mas_Description"];
                                          $Code = $lp_row["Code"];
                                          if ($row["wrk_MasterActivity"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $Code.($Code!=""? "-":"").$caption ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Master Activity of the worksheet. Related sub-activity is populated automatically based on the Master Activity selected.</span></a>
                                </td>
                            </tr>
                            <tr id="crmnotes" style="display:none;">
                                <td>CRM Notes</td>
                                <td>
                                    <textarea name="wrk_crmnotes" cols="25" rows="3"><?php echo stripslashes($row["wrk_crmnotes"]); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                            <?php
                                if($row["wrk_MasterActivity"]=="15") {
                            ?>
                            <script>crmNotes()</script>
                            <?php } ?>

                                <td class="hr">Sub Activity</td>
                                <td class="dr">
                                <div id="wrk_SubActivity"></div>
                                <div id="wrk_SubActivity_old">
                                    <?php
                                    if($row["wrk_SubActivity"]!="")
                                    {
                                        echo $row["lp_wrk_subCode"].($row["lp_wrk_subCode"]!=""? "-":"").$row["lp_wrk_SubActivity"];
                                    ?>
                                        <input type="hidden" name="wrk_SubActivity_old" value="<?php echo $row["wrk_SubActivity"]?>">
                                    <?php
                                    }
                                    ?>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Priority<font style="color:red;" size="2">*</font>
                                </td>
                                <td class="dr">
                                    <select name="wrk_Priority"><option value="0">Select Priority</option>
                                        <?php
                                          $sql = "select `pri_Code`, `pri_Description` from `pri_priority` ORDER BY pri_Order ASC";
                                          $res = mysql_query($sql) or die(mysql_error());
                                          while ($lp_row = mysql_fetch_assoc($res)){
                                          $val = $lp_row["pri_Code"];
                                          $caption = $lp_row["pri_Description"];
                                          if ($row["wrk_Priority"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Priority of the worksheet.</span></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Status<font style="color:red;" size="2">*</font>
                                </td>
                                <td class="dr">
                                    <select name="wrk_Status">
                                        <option value="0">Select Work Status</option>
                                       <?php if(!$iseditmode) { ?>
                                        <option value="11" selected>Not Started</option>
                                        <?php } ?>
                                        <?php
                                          if($iseditmode) $sql = "select `wst_Code`, `wst_Description` from `wst_worksheetstatus` ORDER BY wst_Order ASC";
                                          else $sql = "select `wst_Code`, `wst_Description` from `wst_worksheetstatus` WHERE wst_Code NOT IN(11) ORDER BY wst_Order ASC";
                                          $res = mysql_query($sql) or die(mysql_error());
                                          while ($lp_row = mysql_fetch_assoc($res)){
                                          $val = $lp_row["wst_Code"];
                                          $caption = $lp_row["wst_Description"];
                                          if ($row["wrk_Status"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Status of the worksheet.</span></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Staff In Charge<font style="color:red;" size="2">*</font>
                                </td>
                                <td class="dr">
                                    <select name="wrk_StaffInCharge"><option value="0">Select Staff In Charge</option>
                                        <?php
                                          $staff_sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' AND c1.con_Firstname!='' ORDER BY c1.con_Firstname";
                                          $staff_res = mysql_query($staff_sql) or die(mysql_error());
                                          while ($staff_row = mysql_fetch_assoc($staff_res)){
                                          $val = $staff_row["stf_Code"];
                                           if(!$iseditmode)
                                          {
                                            if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                                          }
                                           if ($row["wrk_StaffInCharge"] == $val) {$selstr = " selected"; } else {$selstr = ""; } 
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Assign Staff to take charge as Staff in Charge.</span></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Team In Charge
                                </td>
                                <td class="dr">
                                    <select name="wrk_TeamInCharge"><option value="0">Select Team In Charge</option>
                                        <?php
                                          $staff_sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                          $staff_res = mysql_query($staff_sql) or die(mysql_error());
                                          while ($staff_row = mysql_fetch_assoc($staff_res)){
                                          $val = $staff_row["stf_Code"];
                                          if(!$iseditmode)
                                          {
                                            if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                                          }
                                          if ($row["wrk_TeamInCharge"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Assign Staff to take charge as Team in Charge.</span></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Manager In Charge
                                </td>
                                <td class="dr">
                                    <select name="wrk_ManagerInChrge"><option value="0">Select Manager In Charge</option>
                                        <?php
                                          $staff_sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=17 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                          $staff_res = mysql_query($staff_sql) or die(mysql_error());
                                          while ($staff_row = mysql_fetch_assoc($staff_res)){
                                          $val = $staff_row["stf_Code"];
                                          if(!$iseditmode)
                                          {
                                            if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                                          }
                                           if ($row["wrk_ManagerInChrge"] == $val) {$selstr = " selected"; } else {$selstr = ""; } 
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Assign Staff to take charge as Manager in Charge.</span></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">Senior In Charge
                                </td>
                                <td class="dr">
                                    <select name="wrk_SeniorInCharge"><option value="0">Select Senior In Charge</option>
                                        <?php
                                          $staff_sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                          $staff_res = mysql_query($staff_sql) or die(mysql_error());
                                          while ($staff_row = mysql_fetch_assoc($staff_res)){
                                          $val = $staff_row["stf_Code"];
                                          if(!$iseditmode)
                                          {
                                            if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                                          }
                                           if ($row["wrk_SeniorInCharge"] == $val) {$selstr = " selected"; } else {$selstr = ""; } 
                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Assign Staff to take charge as Senior in Charge.</span></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="hr">External Due Date<font style="color:red;" size="2">*</font>
                                </td>
                                <td class="dr"><input type="text" name="wrk_DueDate" id="wrk_DueDate" value="<?php if (isset($row["wrk_DueDate"]) && $row["wrk_DueDate"]!="") {
                                if($row["wrk_DueDate"]!="0000-00-00") {
                                $php_wrk_DueDate = strtotime( $row["wrk_DueDate"] );
                                echo date("d/m/Y",$php_wrk_DueDate); } else { echo "";} } ?>">&nbsp;<a href="javascript:NewCal('wrk_DueDate','ddmmyyyy',false,24)"><img
                                src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">The date which fixed internally to complete the tasks.</span></a>
                                </td>
                            </tr>
							<tr>
								<td class="hr">Befree Due Date<font style="color:red;" size="2">*</font>
								</td>
								<td class="dr"><input type="text" name="wrk_InternalDueDate" id="wrk_InternalDueDate" value="<?php if (isset($row["wrk_InternalDueDate"]) && $row["wrk_InternalDueDate"]!="") {
								if($row["wrk_InternalDueDate"]!="0000-00-00") {
								$php_wrk_InternalDueDate = strtotime( $row["wrk_InternalDueDate"] );
								echo date("d/m/Y",$php_wrk_InternalDueDate); } else { echo "";} }?>">&nbsp;<a href="javascript:NewCal('wrk_InternalDueDate','ddmmyyyy',false,24)"><img
								src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">The date which was said to the client to complete the tasks.</span></a>
                                                                </td>
							</tr>
							<tr>
								<td class="hr">Due Time</td>
								<td>
									<?php
									if($iseditmode)
									{
									$wrk_DueTime=explode(":",$row["wrk_DueTime"]);
									}
									$wrk_seconds=$wrk_DueTime[2];
									$wrk_minutes=$wrk_DueTime[1];
									$wrk_hours=$wrk_DueTime[0];
									?>
									<select name="hour"><option value="">Select Hour</option>
									<option value="00" <?php if ($wrk_hours=="00") echo "selected";?>>00</option>
									<option value="01" <?php if ($wrk_hours=="01") echo "selected";?>>01</option>
									<option value="02" <?php if ($wrk_hours=="02") echo "selected";?>>02</option>
									<option value="03" <?php if ($wrk_hours=="03") echo "selected";?>>03</option>
									<option value="04" <?php if ($wrk_hours=="04") echo "selected";?>>04</option>
									<option value="05" <?php if ($wrk_hours=="05") echo "selected";?>>05</option>
									<option value="06" <?php if ($wrk_hours=="06") echo "selected";?>>06</option>
									<option value="07" <?php if ($wrk_hours=="07") echo "selected";?>>07</option>
									<option value="08" <?php if ($wrk_hours=="08") echo "selected";?>>08</option>
									<option value="09" <?php if ($wrk_hours=="09") echo "selected";?>>09</option>
									<option value="10" <?php if ($wrk_hours=="10") echo "selected";?>>10</option>
									<option value="11" <?php if ($wrk_hours=="11") echo "selected";?>>11</option>
									<option value="12" <?php if ($wrk_hours=="12") echo "selected";?>>12</option>
									<option value="13" <?php if ($wrk_hours=="13") echo "selected";?>>13</option>
									<option value="14" <?php if ($wrk_hours=="14") echo "selected";?>>14</option>
									<option value="15" <?php if ($wrk_hours=="15") echo "selected";?>>15</option>
									<option value="16" <?php if ($wrk_hours=="16") echo "selected";?>>16</option>
									<option value="17" <?php if ($wrk_hours=="17") echo "selected";?>>17</option>
									<option value="18" <?php if ($wrk_hours=="18") echo "selected";?>>18</option>
									<option value="19" <?php if ($wrk_hours=="19") echo "selected";?>>19</option>
									<option value="20" <?php if ($wrk_hours=="20") echo "selected";?>>20</option>
									<option value="21" <?php if ($wrk_hours=="21") echo "selected";?>>21</option>
									<option value="22" <?php if ($wrk_hours=="22") echo "selected";?>>22</option>
									<option value="23" <?php if ($wrk_hours=="23") echo "selected";?>>23</option>
									</select>&nbsp;&nbsp;
									<select name="minute"><option value="">Select Minute</option>
									<option value="00" <?php if ($wrk_minutes=="00") echo "selected";?>>00</option>
									<option value="01" <?php if ($wrk_minutes=="01") echo "selected";?>>01</option>
									<option value="02" <?php if ($wrk_minutes=="02") echo "selected";?>>02</option>
									<option value="03" <?php if ($wrk_minutes=="03") echo "selected";?>>03</option>
									<option value="04" <?php if ($wrk_minutes=="04") echo "selected";?>>04</option>
									<option value="05" <?php if ($wrk_minutes=="05") echo "selected";?>>05</option>
									<option value="06" <?php if ($wrk_minutes=="06") echo "selected";?>>06</option>
									<option value="07" <?php if ($wrk_minutes=="07") echo "selected";?>>07</option>
									<option value="08" <?php if ($wrk_minutes=="08") echo "selected";?>>08</option>
									<option value="09" <?php if ($wrk_minutes=="09") echo "selected";?>>09</option>
									<option value="10" <?php if ($wrk_minutes=="10") echo "selected";?>>10</option>
									<option value="11" <?php if ($wrk_minutes=="11") echo "selected";?>>11</option>
									<option value="12" <?php if ($wrk_minutes=="12") echo "selected";?>>12</option>
									<option value="13" <?php if ($wrk_minutes=="13") echo "selected";?>>13</option>
									<option value="14" <?php if ($wrk_minutes=="14") echo "selected";?>>14</option>
									<option value="15" <?php if ($wrk_minutes=="15") echo "selected";?>>15</option>
									<option value="16" <?php if ($wrk_minutes=="16") echo "selected";?>>16</option>
									<option value="17" <?php if ($wrk_minutes=="17") echo "selected";?>>17</option>
									<option value="18" <?php if ($wrk_minutes=="18") echo "selected";?>>18</option>
									<option value="19" <?php if ($wrk_minutes=="19") echo "selected";?>>19</option>
									<option value="20" <?php if ($wrk_minutes=="20") echo "selected";?>>20</option>
									<option value="21" <?php if ($wrk_minutes=="21") echo "selected";?>>21</option>
									<option value="22" <?php if ($wrk_minutes=="22") echo "selected";?>>22</option>
									<option value="23" <?php if ($wrk_minutes=="23") echo "selected";?>>23</option>
									<option value="24" <?php if ($wrk_minutes=="24") echo "selected";?>>24</option>
									<option value="25" <?php if ($wrk_minutes=="25") echo "selected";?>>25</option>
									<option value="26" <?php if ($wrk_minutes=="26") echo "selected";?>>26</option>
									<option value="27" <?php if ($wrk_minutes=="27") echo "selected";?>>27</option>
									<option value="28" <?php if ($wrk_minutes=="28") echo "selected";?>>28</option>
									<option value="29" <?php if ($wrk_minutes=="29") echo "selected";?>>29</option>
									<option value="30" <?php if ($wrk_minutes=="30") echo "selected";?>>30</option>
									<option value="31" <?php if ($wrk_minutes=="31") echo "selected";?>>31</option>
									<option value="32" <?php if ($wrk_minutes=="32") echo "selected";?>>32</option>
									<option value="33" <?php if ($wrk_minutes=="33") echo "selected";?>>33</option>
									<option value="34" <?php if ($wrk_minutes=="34") echo "selected";?>>34</option>
									<option value="35" <?php if ($wrk_minutes=="35") echo "selected";?>>35</option>
									<option value="36" <?php if ($wrk_minutes=="36") echo "selected";?>>36</option>
									<option value="37" <?php if ($wrk_minutes=="37") echo "selected";?>>37</option>
									<option value="38" <?php if ($wrk_minutes=="38") echo "selected";?>>38</option>
									<option value="39" <?php if ($wrk_minutes=="39") echo "selected";?>>39</option>
									<option value="40" <?php if ($wrk_minutes=="40") echo "selected";?>>40</option>
									<option value="41" <?php if ($wrk_minutes=="41") echo "selected";?>>41</option>
									<option value="42" <?php if ($wrk_minutes=="42") echo "selected";?>>42</option>
									<option value="43" <?php if ($wrk_minutes=="43") echo "selected";?>>43</option>
									<option value="44" <?php if ($wrk_minutes=="44") echo "selected";?>>44</option>
									<option value="45" <?php if ($wrk_minutes=="45") echo "selected";?>>45</option>
									<option value="46" <?php if ($wrk_minutes=="46") echo "selected";?>>46</option>
									<option value="47" <?php if ($wrk_minutes=="47") echo "selected";?>>47</option>
									<option value="48" <?php if ($wrk_minutes=="48") echo "selected";?>>48</option>
									<option value="49" <?php if ($wrk_minutes=="49") echo "selected";?>>49</option>
									<option value="50" <?php if ($wrk_minutes=="50") echo "selected";?>>50</option>
									<option value="51" <?php if ($wrk_minutes=="51") echo "selected";?>>51</option>
									<option value="52" <?php if ($wrk_minutes=="52") echo "selected";?>>52</option>
									<option value="53" <?php if ($wrk_minutes=="53") echo "selected";?>>53</option>
									<option value="54" <?php if ($wrk_minutes=="54") echo "selected";?>>54</option>
									<option value="55" <?php if ($wrk_minutes=="55") echo "selected";?>>55</option>
									<option value="56" <?php if ($wrk_minutes=="56") echo "selected";?>>56</option>
									<option value="57" <?php if ($wrk_minutes=="57") echo "selected";?>>57</option>
									<option value="58" <?php if ($wrk_minutes=="58") echo "selected";?>>58</option>
									<option value="59" <?php if ($wrk_minutes=="59") echo "selected";?>>59</option>
									</select>&nbsp;&nbsp;
								</td>
							</tr>
							<tr>
								<td class="hr">Last Reports Sent<font style="color:red;" size="2">*</font></td>
								<td class="dr"><textarea cols="35" rows="4" name="wrk_Details" maxlength="200"><?php echo stripslashes($row["wrk_Details"]) ?></textarea></td>
							</tr>
							<tr>
								<td class="hr">Resolution</td>
								<td class="dr"><textarea cols="35" rows="4" name="wrk_Resolution" maxlength="200"><?php echo stripslashes($row["wrk_Resolution"]) ?></textarea></td>
							</tr>
							<tr>
								<td class="hr">Current Job in Hand</td>
								<td class="dr"><textarea cols="35" rows="4" name="wrk_Notes" ><?php echo stripslashes($row["wrk_Notes"]) ?></textarea></td>
							</tr>
							<tr>
								<td class="hr">Team In Charge Notes</td>
								<td class="dr"><textarea cols="35" rows="4" name="wrk_TeamInChargeNotes"><?php echo stripslashes($row["wrk_TeamInChargeNotes"]) ?></textarea></td>
							</tr>
							<tr>
								<td class="hr">Related Cases</td>
								<td class="dr"><textarea cols="35" rows="4" name="wrk_RelatedCases" maxlength="100"><?php echo stripslashes($row["wrk_RelatedCases"]) ?></textarea></td>
							</tr>
                 		</table>
                 </div>
                 <div id="page2" style="display:none;">
                     <table width="100%">
                         <tr>
                             <td width="50%">
				 	<?php if($row["wrk_Rptid"]!=0)
                    {
                        $sql_rep = "select * from `worksheet_repeats` where rpt_id=".$row['wrk_Rptid'];
                        $res_rep = mysql_query($sql_rep) or die(mysql_error());
                        $row_rep=mysql_fetch_assoc($res_rep);
                	?>
					<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
                        <tr>
                        <td>Repeat Type</td>
                        <td colspan="2"><?php
                                echo "<b>".$commonUses->getRepeatTypeDesc($row["wrk_Rptid"],$row_rep,true)."</b>";
                                ?>
								</td>
								</tr>
								<tr>
                         <td>End Date</td>
                        <td colspan="2"><?php
                                echo "<b>".$commonUses->getEndDate($row["wrk_Rptid"],$row_rep,true)."</b>";
                                ?></td>
                        </tr>
                    </table>
                    <?php } ?> <br>
                    <table border="0" cellspacing="0" cellpadding="3" summary="" class="fieldtable_outer11">
                        <tr>
                          <td class="tooltip" title="Select how often the event should repeat."><label for="rpttype">Type:</label></td>
                          <td colspan="2">
                           <select name="rpt_type" id="rpttype" onChange="rpttype_handler(); rpttype_weekly()">
                              <option value="none" <?php if($row["rpt_type"]=='none') echo "selected"?>>None</option>
                              <option value="daily" <?php if($row["rpt_type"]=='daily') echo "selected"?>>Daily</option>
                              <option value="weekly"  <?php if($row["rpt_type"]=='weekly') echo "selected"?>>Weekly</option>
                              <option value="monthlyByDay" <?php if($row["rpt_type"]=='monthlyByDay') echo "selected"?> >Monthly (by day)</option>
                              <option value="monthlyByDate" <?php if($row["rpt_type"]=='monthlyByDate') echo "selected"?> >Monthly (by date)</option>
                             <!-- <option value="monthlyBySetPos" <?php if($row["rpt_type"]=='monthlyBySetPos') echo "selected"?> >Monthly (by position)</option>  -->
                              <option value="yearly" <?php if($row["rpt_type"]=='yearly') echo "selected"?>>Yearly</option>
                            </select>
                            <?php
                                            // Determine if Expert mode needs to be set.
                                            $expert_mode = ( count ( $byday ) || count ( $bymonth ) ||
                                            count ( $bymonthday ) || count ( $bysetpos ) ||
                                            isset ( $byweekno ) || isset ( $byyearday ) || isset ( $rpt_count ) );
                           ?>
                           &nbsp;&nbsp;&nbsp;<label id="rpt_mode"><input type="checkbox" name="rptmode" id="rptmode" value="y" onClick="rpttype_handler()"  <?php if($expert_mode !="") echo "checked"?>/>Expert Mode</label>
                          </td>
                        </tr>
                        <tr>
                         <tr id="rptenddate1" style="visibility:hidden;">
                          	<td class="tooltip" title="Specifies the date the event should repeat until." rowspan="3"><label for="rpt_day">Ending:</label></td>
                         </tr>
                         <tr id="rptstartdate2" style="visibility:hidden;">
                          	<td class="boxleft" >Start Date:</td>
                		<?php  $thisYear = date("Y");
                        	$thisMonth = date("m");
                        	$thisDay = date("d");
                        ?>
                          <td class="boxright"><span class="start_day_selection" id="rpt_start_day_select">
							  <select name="rpt_startday" id="rpt_day">
								<option value="0" >Select</option>
								<option value="01" <?php if ($thisDay=="01") echo "selected";?>>1</option>
								<option value="02" <?php if ($thisDay=="02") echo "selected";?>>2</option>
								<option value="03" <?php if ($thisDay=="03") echo "selected";?>>3</option>
								<option value="04" <?php if ($thisDay=="04") echo "selected";?>>4</option>
								<option value="05" <?php if ($thisDay=="05") echo "selected";?>>5</option>
								<option value="06" <?php if ($thisDay=="06") echo "selected";?>>6</option>
								<option value="07" <?php if ($thisDay=="07") echo "selected";?>>7</option>
								<option value="08" <?php if ($thisDay=="08") echo "selected";?>>8</option>
								<option value="09" <?php if ($thisDay=="09") echo "selected";?>>9</option>
								<option value="10" <?php if ($thisDay=="10") echo "selected";?>>10</option>
								<option value="11" <?php if ($thisDay=="11") echo "selected";?>>11</option>
								<option value="12" <?php if ($thisDay=="12") echo "selected";?>>12</option>
								<option value="13" <?php if ($thisDay=="13") echo "selected";?>>13</option>
								<option value="14" <?php if ($thisDay=="14") echo "selected";?>>14</option>
								<option value="15" <?php if ($thisDay=="15") echo "selected";?>>15</option>
								<option value="16" <?php if ($thisDay=="16") echo "selected";?>>16</option>
								<option value="17" <?php if ($thisDay=="17") echo "selected";?>>17</option>
								<option value="18" <?php if ($thisDay=="18") echo "selected";?>>18</option>
								<option value="19" <?php if ($thisDay=="19") echo "selected";?>>19</option>
								<option value="20" <?php if ($thisDay=="20") echo "selected";?>>20</option>
								<option value="21" <?php if ($thisDay=="21") echo "selected";?>>21</option>
								<option value="22" <?php if ($thisDay=="22") echo "selected";?>>22</option>
								<option value="23" <?php if ($thisDay=="23") echo "selected";?>>23</option>
								<option value="24" <?php if ($thisDay=="24") echo "selected";?>>24</option>
								<option value="25" <?php if ($thisDay=="25") echo "selected";?>>25</option>
								<option value="26" <?php if ($thisDay=="26") echo "selected";?>>26</option>
								<option value="27" <?php if ($thisDay=="27") echo "selected";?>>27</option>
								<option value="28" <?php if ($thisDay=="28") echo "selected";?>>28</option>
								<option value="29" <?php if ($thisDay=="29") echo "selected";?>>29</option>
								<option value="30" <?php if ($thisDay=="30") echo "selected";?>>30</option>
								<option value="31" <?php if ($thisDay=="31") echo "selected";?>>31</option>
							  </select>
							  <select name="rpt_startmonth">
								<option value="0" >Select</option>
								<option value="01"  <?php if ($thisMonth=="01") echo "selected";?>>Jan</option>
								<option value="02"  <?php if ($thisMonth=="02") echo "selected";?>>Feb</option>
								<option value="03"  <?php if ($thisMonth=="03") echo "selected";?>>Mar</option>
								<option value="04"  <?php if ($thisMonth=="04") echo "selected";?>>Apr</option>
								<option value="05"  <?php if ($thisMonth=="05") echo "selected";?>>May</option>
								<option value="06"  <?php if ($thisMonth=="06") echo "selected";?>>Jun</option>
								<option value="07"  <?php if ($thisMonth=="07") echo "selected";?>>Jul</option>
								<option value="08"  <?php if ($thisMonth=="08") echo "selected";?>>Aug</option>
								<option value="09"  <?php if ($thisMonth=="09") echo "selected";?>>Sep</option>
								<option value="10"  <?php if ($thisMonth=="10") echo "selected";?>>Oct</option>
								<option value="11"  <?php if ($thisMonth=="11") echo "selected";?>>Nov</option>
								<option value="12" <?php if ($thisMonth=="12") echo "selected";?>>Dec</option>
							  </select>
							  <select name="rpt_startyear">
								<option value="0">Select</option>
								<option value="2009"  <?php if ($thisYear=="2009") echo "selected";?>>2009</option>
								<option value="2010"  <?php if ($thisYear=="2010") echo "selected";?>>2010</option>
								<option value="2011"  <?php if ($thisYear=="2011") echo "selected";?>>2011</option>
								<option value="2012" <?php if ($thisYear=="2012") echo "selected";?>>2012</option>
								<option value="2013"  <?php if ($thisYear=="2013") echo "selected";?>>2013</option>
								<option value="2014"  <?php if ($thisYear=="2014") echo "selected";?>>2014</option>
								<option value="2015"  <?php if ($thisYear=="2015") echo "selected";?>>2015</option>
								<option value="2016"  <?php if ($thisYear=="2016") echo "selected";?>>2016</option>
								<option value="2017"  <?php if ($thisYear=="2017") echo "selected";?>>2017</option>
								<option value="2018"  <?php if ($thisYear=="2018") echo "selected";?>>2018</option>
								<option value="2019"  <?php if ($thisYear=="2019") echo "selected";?>>2019</option>
								<option value="2020"  <?php if ($thisYear=="2020") echo "selected";?>>2020</option>
								<option value="2021"  <?php if ($thisYear=="2021") echo "selected";?>>2021</option>
								<option value="2022"  <?php if ($thisYear=="2022") echo "selected";?>>2022</option>
								<option value="2023"  <?php if ($thisYear=="2023") echo "selected";?>>2023</option>
								<option value="2024"  <?php if ($thisYear=="2024") echo "selected";?>>2024</option>
								<option value="2025"  <?php if ($thisYear=="2025") echo "selected";?>>2025</option>
								<option value="2026"  <?php if ($thisYear=="2026") echo "selected";?>>2026</option>
								<option value="2027"  <?php if ($thisYear=="2027") echo "selected";?>>2027</option>
								<option value="2028"  <?php if ($thisYear=="2028") echo "selected";?>>2028</option>
							  </select>
							  </span>
                        <tr id="rptenddate2" style="visibility:hidden;">
                          <td class="boxleft"><input type="radio" name="rpt_end_use" id="rpt_untilu" value="u"  onclick="toggle_until()" checked />&nbsp;<label for="rpt_untilu">Use end date<font style="color:red;" size="2">*</font>
                			</label></td>
                          <td class="boxright"><span class="end_day_selection" id="rpt_end_day_select">
							  <select name="rpt_day" id="rpt_day">
								<option value="0">Select</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							  </select>
							  <select name="rpt_month">
								<option value="0">Select</option>
								<option value="1">Jan</option>
								<option value="2">Feb</option>
								<option value="3">Mar</option>
								<option value="4">Apr</option>
								<option value="5">May</option>
								<option value="6">Jun</option>
								<option value="7">Jul</option>
								<option value="8">Aug</option>
								<option value="9">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>
							  </select>
							  <select name="rpt_year">
								<option value="0">Select</option>
								<option value="2009">2009</option>
								<option value="2010">2010</option>
								<option value="2011">2011</option>
								<option value="2012">2012</option>
								<option value="2013">2013</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								<option value="2027">2027</option>
								<option value="2028">2028</option>
							  </select>
							  </span>
                              <a class="tooltip" href="#"><img src="images/help.png"><span class="help">End date of the worksheet Repeats.</span></a>
                        <tr id="rptenddate3" style="visibility:hidden;"> <td>&nbsp;</td>
                          <td class="boxbottom boxleft"><input type="radio" name="rpt_end_use" id="rpt_untilc" value="c"  onclick="toggle_until()" />&nbsp;<label for="rpt_untilc">Number of times<font style="color:red;" size="2">*</font>
                			</label>
                          </td>
                          <td class="boxright boxbottom"><input type="text" name="rpt_count" id="rpt_count" size="4" maxlength="4" value="" />
                          <a class="tooltip" href="#"><img src="images/help.png"><span class="help">How many times worksheet should repeat from start  date.</span></a>
                          </td>
                        </tr>
                        <tr id="rptfreq" style="visibility:hidden;" title="Specifies how often the event should repeat.">
                          <td class="tooltip"><label for="entry_freq">Frequency:</label></td>
                          <td colspan="2">
                            <input type="text" name="rpt_freq" id="entry_freq" size="4" maxlength="4" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;
                            <label id="weekdays_only"><input type="checkbox" name="weekdays_only" value="y"  />Weekdays Only</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span id="rptwkst">
                              <select name="wkst">
                                <option value="SU" >SU</option>
                                <option value="MO"  selected="selected">MO</option>
                                <option value="TU" >TU</option>
                                <option value="WE" >WE</option>
                                <option value="TH" >TH</option>
                                <option value="FR" >FR</option>
                                <option value="SA" >SA</option>
                              </select>&nbsp;&nbsp;<label for="rptwkst">Week Start</label>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4"></td>
                        </tr>
                        <tr id="rptbydayextended" style="visibility:hidden;" title="Allows date selection based on day of week.">
                          <td class="tooltip"><label>ByDay:</label></td>
                          <td colspan="2" class="boxall">
                            <input type="hidden" name="bydayList" value="" />
                            <input type="hidden" name="bymonthdayList" value="" />
                            <input type="hidden" name="bysetposList" value="" />
                            <table class="byxxx" cellpadding="2" cellspacing="2" border="1" summary="">
                              <tr>
                                <td></td>
                                <th width="50px" class="weekend" ><label>Sun</label></th>
                                <th width="50px"><label>Mon</label></th>
                                <th width="50px"><label>Tue</label></th>
                                <th width="50px"><label>Wed</label></th>
                                <th width="50px"><label>Thu</label></th>
                                <th width="50px"><label>Fri</label></th>
                                <th width="50px" class="weekend" ><label>Sat</label></th>
                              </tr>
                                 <tr>
                                 <td></td>
                                <td><input type="checkbox" name="bydayAll[]" id="SU" value="SU" <?php if(preg_match("/SU/", $row['rpt_byday'])) echo "checked" ?>  /></td>
                                <td><input type="checkbox" name="bydayAll[]" id="MO" value="MO" <?php if(preg_match("/MO/", $row['rpt_byday'])) echo "checked" ?> /></td>
                                <td><input type="checkbox" name="bydayAll[]" id="TU" value="TU" <?php if(preg_match("/TU/", $row['rpt_byday'])) echo "checked" ?> /></td>
                                <td><input type="checkbox" name="bydayAll[]" id="WE" value="WE" <?php if(preg_match("/WE/", $row['rpt_byday'])) echo "checked" ?> /></td>
                                <td><input type="checkbox" name="bydayAll[]" id="TH" value="TH" <?php if(preg_match("/TH/", $row['rpt_byday'])) echo "checked" ?> /></td>
                                <td><input type="checkbox" name="bydayAll[]" id="FR" value="FR"  <?php if(preg_match("/FR/", $row['rpt_byday'])) echo "checked" ?>/></td>
                                <td><input type="checkbox" name="bydayAll[]" id="SA" value="SA"  <?php if(preg_match("/SA/", $row['rpt_byday'])) echo "checked" ?>/></td>
                              </tr>
                              <tr id="rptbydayln" style="visibility:hidden;">
                                <th><label>1/-5</label></th>
                                <td><input type="button" name="byday" id="_10" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_11" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_12" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_13" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_14" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_15" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_16" value="        " onClick="toggle_byday( this )" /></td>
                              </tr>
                              <tr id="rptbydayln1" style="visibility:hidden;">
                                <th><label>2/-4</label></th>
                                <td><input type="button" name="byday" id="_20" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_21" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_22" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_23" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_24" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_25" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_26" value="        " onClick="toggle_byday( this )" /></td>
                              </tr>
                              <tr id="rptbydayln2" style="visibility:hidden;">
                                <th><label>3/-3</label></th>
                                <td><input type="button" name="byday" id="_30" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_31" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_32" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_33" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_34" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_35" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_36" value="        " onClick="toggle_byday( this )" /></td>
                              </tr>
                              <tr id="rptbydayln3" style="visibility:hidden;">
                                <th><label>4/-2</label></th>
                                <td><input type="button" name="byday" id="_40" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_41" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_42" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_43" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_44" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_45" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_46" value="        " onClick="toggle_byday( this )" /></td>
                              </tr>
                              <tr id="rptbydayln4" style="visibility:hidden;">
                                <th><label>5/-1</label></th>
                                <td><input type="button" name="byday" id="_50" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_51" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_52" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_53" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_54" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_55" value="        " onClick="toggle_byday( this )" /></td>
                                <td><input type="button" name="byday" id="_56" value="        " onClick="toggle_byday( this )" /></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4"></td>
                        </tr>
                        <tr id="rptbymonth" style="visibility:hidden;" title="Specifies which months the event should repeat in.">
                          <td class="tooltip">ByMonth:&nbsp;</td>
                          <td colspan="2" class="boxall">
                            <table cellpadding="5" cellspacing="0" summary="">
                              <tr>
                                <td><label><input type="checkbox" name="bymonth[]" value="1"  <?php if(preg_match("/1/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Jan</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="2"  <?php if(preg_match("/2/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Feb</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="3"  <?php if(preg_match("/3/", $row['rpt_bymonth'])) echo "checked" ?>  />&nbsp;Mar</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="4"  <?php if(preg_match("/4/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Apr</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="5" <?php if(preg_match("/5/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;May</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="6"  <?php if(preg_match("/6/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Jun</label></td>
                              </tr>
                              <tr>
                                <td><label><input type="checkbox" name="bymonth[]" value="7" <?php if(preg_match("/7/", $row['rpt_bymonth'])) echo "checked" ?>  />&nbsp;Jul</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="8" <?php if(preg_match("/8/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Aug</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="9"  <?php if(preg_match("/9/", $row['rpt_bymonth'])) echo "checked" ?>  />&nbsp;Sep</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="10" <?php if(preg_match("/10/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Oct</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="11"  <?php if(preg_match("/11/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Nov</label></td>
                                <td><label><input type="checkbox" name="bymonth[]" value="12"  <?php if(preg_match("/12/", $row['rpt_bymonth'])) echo "checked" ?>   />&nbsp;Dec</label></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4"></td>
                        </tr>
                        <tr id="rptbysetpos" style="visibility:hidden;" title="Allows date selection based on position withing the month.">
                          <td class="tooltip" id="BySetPoslabel">BySetPos:&nbsp;</td>
                          <td colspan="2" class="boxall">
                            <table class="byxxx" cellpadding="2" cellspacing="0" border="1" summary="">
                              <tr>
                                <td></td>
                                <th width="37px"><label>1</label></th>
                                <th width="37px"><label>2</label></th>
                                <th width="37px"><label>3</label></th>
                                <th width="37px"><label>4</label></th>
                                <th width="37px"><label>5</label></th>
                                <th width="37px"><label>6</label></th>
                                <th width="37px"><label>7</label></th>
                                <th width="37px"><label>8</label></th>
                                <th width="37px"><label>9</label></th>
                                <th width="37px"><label>10</label></th>
                              </tr>
                              <tr>
                                <th><label>1-10</label></th>
                                <td><input type="button" name="bysetpos" id="bysetpos1" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos2" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos3" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos4" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos5" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos6" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos7" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos8" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos9" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos10" value="      " onClick="toggle_bysetpos( this )" /></td>
                              </tr>
                            <tr>
                                <th><label>11-20</label></th>
                                <td><input type="button" name="bysetpos" id="bysetpos11" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos12" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos13" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos14" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos15" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos16" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos17" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos18" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos19" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos20" value="      " onClick="toggle_bysetpos( this )" /></td>
                              </tr>
                            <tr>
                                <th><label>21-30</label></th>
                                <td><input type="button" name="bysetpos" id="bysetpos21" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos22" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos23" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos24" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos25" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos26" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos27" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos28" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos29" value="      " onClick="toggle_bysetpos( this )" /></td>
                                <td><input type="button" name="bysetpos" id="bysetpos30" value="      " onClick="toggle_bysetpos( this )" /></td>
                              </tr>
                            <tr>
                                <th><label>31</label></th>
                                <td><input type="button" name="bysetpos" id="bysetpos31" value="      " onClick="toggle_bysetpos( this )" /></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4"></td>
                      </tr>
                      <tr id="rptbymonthdayextended" style="visibility:hidden;" title="Allows date selection based on date.">
                        <td class="tooltip" id="ByMonthDaylabel">ByMonthDay:&nbsp;</td>
                        <td colspan="2" class="boxall">
                          <table class="byxxx" cellpadding="2" cellspacing="0" border="1" summary="">
                            <tr>
                              <td></td>
                              <th width="37px"><label>1</label></th>
                              <th width="37px"><label>2</label></th>
                              <th width="37px"><label>3</label></th>
                              <th width="37px"><label>4</label></th>
                              <th width="37px"><label>5</label></th>
                              <th width="37px"><label>6</label></th>
                              <th width="37px"><label>7</label></th>
                              <th width="37px"><label>8</label></th>
                              <th width="37px"><label>9</label></th>
                              <th width="37px"><label>10</label></th>
                            </tr>
                            <tr>
                            <th><label>1-10</label></th>
                            <td><input type="button" name="bymonthday" id="bymonthday1" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday2" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday3" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday4" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday5" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday6" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday7" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday8" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday9" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday10" value="      " onClick="toggle_bymonthday( this )" /></td>
                          </tr>
                          <tr>
                            <th><label>11-20</label></th>
                            <td><input type="button" name="bymonthday" id="bymonthday11" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday12" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday13" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday14" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday15" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday16" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday17" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday18" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday19" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday20" value="      " onClick="toggle_bymonthday( this )" /></td>
                          </tr>
                          <tr>
                            <th><label>21-30</label></th>
                            <td><input type="button" name="bymonthday" id="bymonthday21" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday22" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday23" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday24" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday25" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday26" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday27" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday28" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday29" value="      " onClick="toggle_bymonthday( this )" /></td>
                            <td><input type="button" name="bymonthday" id="bymonthday30" value="      " onClick="toggle_bymonthday( this )" /></td>
                          </tr>
                          <tr>
                            <th><label>31</label></th>
                            <td><input type="button" name="bymonthday" id="bymonthday31" value="      " onClick="toggle_bymonthday( this )" /></td>
                          </tr>
                        </table>
                       </td>
                      </tr>
                      <tr id="rptbyweekno" style="visibility:hidden;" title="Allows user to specify a list of weeks to repeat event (1,2...53,-53,-52...-1).">
                        <td class="tooltip">ByWeekNo:</td>
                        <td colspan="2"><input type="text" name="byweekno" id="byweekno" size="50" maxlength="100" value="" /></td>
                      </tr>
                      <tr id="rptbyyearday" style="visibility:hidden;" title="Allows user to specify a list of year days to repeat event (1,2...366,-366,-365...-1).">
                        <td class="tooltip">ByYearDay:</td>
                        <td colspan="2"><input type="text" name="byyearday" id="byyearday" size="50" maxlength="100" value="" /></td>
                      </tr>
                	</table>
                             </td>
                             <td width="50%">
							 		<div style="background-color:#f4fcff; color:#2b5d76; font-weight:bold; text-align:center; border:1px solid #000033; border-bottom:none; width:500px; position:relative; top:-35px; padding:5px 5px 5px 5px;">Notes</div>
									<div style="border:1px solid #000033; width:500px; position:relative; top:-35px; background-color: #FCFCFC; text-align:justify; padding:5px 5px 5px 5px;">
                                             <b>1. Daily </b><br />
											   If you select Start Date & End Date / Number of Times , number of worksheets will be created according to the selection on the basis of Frequency.<br />
											    If set Frequency is 1, create worksheet every day.<br/> 
												If frequency is 2, create worksheet two days once  and so on.<br /><br />
												<b>2. Weekly</b><br />
												If you select Start Date & End Date / Number of Times, number of worksheets will be created according to the selection on the basis of Frequency and ByDay.<br />
												If set Frequency is 1, create worksheet every week on that particular days (It will take checked days under ByDay option, if they are checked otherwise it will take the day of Start date )<br />
												If frequency is 2, create worksheet two weeks once on that particular days  and so on.<br /><br />
												<b>3. Monthly by day</b><br />
												If you select Start Date & End Date / Number of Times, number of worksheets will be created according to the selection of the Dates and Frequency.<br />
												If set Frequency is 1. create worksheet every month on that particular day which taken from Befree Due date from Details Tab.<br />
												If frequency is 2. create worksheet two months once on that particular day  and so on.<br /><br />
												<b>4. Monthly by date</b><br />
												If you select Start Date & End Date / Number of Times, number of worksheets will be created according to the selection of the Dates and Frequency. <br />
												If set Frequency is 1, create worksheet every month on that particular date which taken from Befree Due date from Details Tab.<br />
												If frequency is 2, create worksheet two months once on that particular date  and so on.<br /><br />
												<b>5. Yearly</b><br />
												If you select Start Date & End Date / Number of Times, number of worksheets will be created according to the selection of the Dates and Frequency. <br />
												If set Frequency is 1. create worksheet every year on that particular date which taken from Befree Due date from Details Tab  that would apply within the date limits.<br />
												If frequency is 2. create worksheet two years once on that particular date  and so on.<br />
									</div>	
                             </td>
                         </tr>
                     </table>
                </div>
                <div id="page3" style="display:none;"> <br>
					  <br>
					<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
						<tr>
							<td class="hr">Completion Date</td>
							<td class="dr"><input type="text" name="wrk_ClosedDate" id="wrk_ClosedDate" value="
							<?php if (isset($row["wrk_ClosedDate"]) && $row["wrk_ClosedDate"]!="" && $row["wrk_ClosedDate"]!='0000-00-00') {
							$php_wrk_ClosedDate = strtotime( $row["wrk_ClosedDate"] );
							echo date("d/m/Y",$php_wrk_ClosedDate);
							} ?>">&nbsp;<a href="javascript:NewCal('wrk_ClosedDate','ddmmyyyy',false,24)">
									<img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
							</tr>
							<tr>
							<td class="hr">Closure Reason</td>
							<td class="dr"><textarea cols="35" rows="4" name="wrk_ClosureReason" maxlength="200"><?php echo stripslashes($row["wrk_ClosureReason"]) ?></textarea></td>
							</tr>
							<tr>
							<td class="hr">Hours Spent</td>
							<td class="dr"><input type="text" name="wrk_HoursSpent" value="<?php echo stripslashes($row["wrk_HoursSpent"]) ?>"  maxlength="8"></td>
						</tr>
					</table>
                </div>
        <?php
        }
        function showpagenav($page, $pagecount)
        {
        ?>
			<table   border="0" cellspacing="1" cellpadding="4" align="right" >
				<tr>
					 <?php if ($page > 1) { ?>
					<td><a href="wrk_worksheet.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
					<td><a href="wrk_worksheet.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
					<?php } } } else { ?>
					<td><a href="wrk_worksheet.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
					<?php } } } ?>
					<?php if ($page < $pagecount) { ?>
					<td>&nbsp;<a href="wrk_worksheet.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
					<?php } ?>
				</tr>
			</table>
        <?php
        }
        //================= Pagination for inner records under Clientele =============================
        function showpagenav_client($page, $pagecount,$clientCode)
        {
        ?>
			<table border="0" cellspacing="1" cellpadding="4" align="right" >
				<tr>
					 <?php if ($page > 1) { ?>
					<td><a href="wrk_worksheet.php?page_records=<?php echo $page - 1 ?>&client=<?php echo $clientCode; ?>&page=<?php echo $_GET['page']; ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
					<td><a href="wrk_worksheet.php?page_records=<?php echo $j ?>&client=<?php echo $clientCode; ?>&page=<?php echo $_GET['page']; ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
					<?php } } } else { ?>
					<td><a href="wrk_worksheet.php?page_records=<?php echo $startpage ?>&client=<?php echo $clientCode; ?>&page=<?php echo $_GET['page']; ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
					<?php } } } ?>
					<?php if ($page < $pagecount) { ?>
					<td>&nbsp;<a href="wrk_worksheet.php?page_records=<?php echo $page + 1 ?>&client=<?php echo $clientCode; ?>&page=<?php echo $_GET['page']; ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
					<?php } ?>
				</tr>
			</table>
        <?php
        }
        //================= Pagination for inner records under Clientele =============================
        function showrecnav($a, $recid, $count)
        {
			if($_GET['wid']=="" && !isset($_GET['wid']))
			{
			?>
				<table border="0" cellspacing="1" cellpadding="4" align="right">
				<tr>
				 <?php if ($recid > 0) { ?>
				<td><a href="wrk_worksheet.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
				<?php } if ($recid < $count - 1) { ?>
				<td><a href="wrk_worksheet.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
				<?php } ?>
				</tr>
				</table>
			<?php
			}
			?>
			<br>
			<span class="frmheading">
			<?php
			switch($a)
			{
			case "view":
							$title="View";
							break;
			case "edit";
							$title="Edit";
							break;
			default:
							$title="";
							break;
			}
			?>
			<?php echo $title?> Work Sheet
			</span>
			<hr size="1" noshade>
        <?php }
        function addrec()
        {
         ?><br>
				<span class="frmheading">
				 Add Record
				</span>
				<hr size="1" noshade><div style="position:absolute; top:140; right:-50px; width:300; height:300;">
				<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
				 <form enctype="multipart/form-data" action="wrk_worksheet.php" method="post"  name="worksheet" onSubmit="return validateFormOnSubmit()"  >
				<p><input type="hidden" name="sql" value="insert"></p>
				<?php
				$row = array(
				  "wrk_Code" => "",
				  "wrk_ClientCode" => "",
				  "wrk_ClientContact" => "",
				  "wrk_MasterActivity" => "",
				  "wrk_SubActivity" => "",
				  "wrk_Priority" => "",
				  "wrk_Status" => "",
				  "wrk_TeamInCharge" => "",
				  "wrk_StaffInCharge" => "",
				  "wrk_ManagerInChrge" => "",
                                  "wrk_SeniorInChrge" => "",  
				  "wrk_DueDate" => "",
				  "wrk_InternalDueDate" => "",
				  "wrk_DueTime" => "",
				  "wrk_ClosedDate" => "",
				  "wrk_ClosureReason" => "",
				  "wrk_HoursSpent" => "",
				  "wrk_Details" => "",
				  "wrk_Resolution" => "",
				  "wrk_Notes" => "",
				  "wrk_TeamInChargeNotes" => "",
				  "wrk_RelatedCases" => "",
				  "wrk_Recurring" => "",
				  "wrk_Schedule" => "",
				  "wrk_Date" => "",
				  "wrk_Day" => "",
				  "wrk_Createdby" => "",
				  "wrk_Createdon" => "",
				  "wrk_Lastmodifiedby" => "",
				  "wrk_Lastmodifiedon" => "");
				$this->showroweditor($row, false);
				?>
				<input type="submit" name="action" value="Save" class="button"><input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/> </form>
        <?php
        }
        function viewrec($recid,$access_file_level)
        {
		global 	$worksheetQuery;
                $res = $worksheetQuery->sql_select($_GET['client'], &$count,&$filter,&$filterfield,&$wholeonly);
				  //$count = $worksheetQuery->sql_getrecordcount($_GET['client']);
				  $this->showrecnav("view", $recid, $count);
				  if($_GET['wid']=="" && !isset($_GET['wid']))
				  {
				   @mysql_data_seek($res, $recid);
				  }
				 $row = mysql_fetch_assoc($res);
				?>
				<br>
				<?php $this->showrow($row, $recid) ?>
				<br>
				<hr size="1" noshade>
				<?php
				if($_GET['wid']=="" && !isset($_GET['wid']))
				{
				?>
					<table class="bd" border="0" cellspacing="1" cellpadding="4">
						<tr>
							<?php
							  if($access_file_level['stf_Add']=="Y")
									  {
							?>
							<td><a href="wrk_worksheet.php?a=add" class="hlight">Add Record</a></td>
							<?php } ?>
							<?php
							  if($access_file_level['stf_Edit']=="Y")
									  {
							?>
							<td><a href="wrk_worksheet.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
							<?php } ?>
							<?php
							  if($access_file_level['stf_Delete']=="Y")
									  {
							?>
							<td><a onClick="performdelete('wrk_worksheet.php?mode=delete&recid=<?php echo stripslashes($row["wrk_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
							<?php } ?>
						</tr>
					</table>
				<?php } 
				
				  mysql_free_result($res);
        } 
        function editrec($recid)
        {
                global $worksheetQuery;
                $res = $worksheetQuery->sql_select($_GET['client'],&$count,&$filter,&$filterfield,&$wholeonly);
			  $count = $worksheetQuery->sql_getrecordcount($_GET['client']);
			  @mysql_data_seek($res, $recid);
			  $row = mysql_fetch_assoc($res);
			  $this->showrecnav("edit", $recid, $count);
			  if($_GET['wid']=="" && !isset($_GET['wid']))
			  {
			  $formaction="?a=".$_GET['a']."&recid=".$_GET['recid']."&client=".$_GET['client'];
			  }
			?>
			<div class="right_clientname" style="position:relative; top:-34px;"><?php echo stripslashes($row["lp_wrk_ClientCode"]); ?></div>
			<div style="position:absolute; top:160px; right:-83px; width:300; height:300;">
			<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
			<br>
			<form enctype="multipart/form-data" action="wrk_worksheet.php<?php echo $formaction?>" method="post"  name="worksheet" onSubmit="return validateFormOnSubmit()">
			<input type="hidden" name="sql" value="update">
			<input type="hidden" name="xwrk_Code" value="<?php echo $row["wrk_Code"] ?>">
			<input type="hidden" name="wrk_Rptid" value="<?php echo $row["wrk_Rptid"] ?>">
			<?php $this->showroweditor($row, true); ?>
			<input type="submit" name="action" value="Update" class="button">
			<input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/> </form>
			<?php
			  mysql_free_result($res);
        }
        function copyrec($copyid){
           $copy_res = "select t1.*,lp1.`sub_Description` AS `lp_wrk_SubActivity`,lp2.`con_Firstname` AS `lp_wrk_ClientContact` from wrk_worksheet t1 LEFT OUTER JOIN `sub_subactivity` AS lp1 ON ( t1.`wrk_SubActivity` = lp1.`sub_Code` ) LEFT OUTER JOIN `con_contact` AS lp2 ON (t1.`wrk_ClientContact` = lp2.`con_Code`) where t1.wrk_Code=".$copyid;
           $qry_result = mysql_query($copy_res);
           $copyrow = mysql_fetch_array($qry_result);
            ?>
                <form name="copyForm" id="copyForm" method="post" action="wrk_worksheet.php?a=copy" enctype="multipart/form-data">
                <div style="background-color: #047ea7; border: 1px double #000000; color:#FFFFFF; text-align:center; font-weight:bold; padding:10px 0 10px 0; width:400px; font-family:Arial,Tahoma, Verdana,  Helvetica, sans-serif; font-size:13px;">Work Sheet Copy</div>
                <div style="border: 1px double #000000; width:400px;">
                	<div style="position:relative; left:80px; top:10px; font-family:Arial,Tahoma, Verdana,  Helvetica, sans-serif; font-size:12px;">Enter due dates for the copy worksheet</div><br>
        		   <table align="center" style="font-family:Arial,Tahoma, Verdana,  Helvetica, sans-serif; font-size:12px;">
                	<tr><td><br></td></tr>
            		<tr>
                		<td class="hr">External Due Date</td>
                		<td class="dr">
                            <input type="text" name="wrk_DueDate" id="wrk_DueDate" >&nbsp;<a href="javascript:NewCal('wrk_DueDate','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                		</td>
            		</tr>
            		<tr>
                		<td class="hr">Befree Due Date</td>
                		<td class="dr">
                            <input type="text" name="wrk_InternalDueDate" id="wrk_InternalDueDate">&nbsp;<a href="javascript:NewCal('wrk_InternalDueDate','ddmmyyyy',false,24)"><img
                        		src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                		</td>
            		</tr>
        		</table>
                                <input type="hidden" name="wrk_ClientCode" value="<?php echo $copyrow['wrk_ClientCode']; ?>">
                                <input type="hidden" name="wrk_ClientContact" value="<?php echo $copyrow['wrk_ClientContact']; ?>">
                                <input type="hidden" name="wrk_MasterActivity" value="<?php echo $copyrow['wrk_MasterActivity']; ?>">
                                <input type="hidden" name="wrk_SubActivity" value="<?php echo $copyrow['wrk_SubActivity']; ?>">
                                <input type="hidden" name="wrk_Priority" value="<?php echo $copyrow['wrk_Priority']; ?>">
                                <input type="hidden" name="wrk_Status" value="11">
                                <input type="hidden" name="wrk_TeamInCharge" value="<?php echo $copyrow['wrk_TeamInCharge']; ?>">
                                <input type="hidden" name="wrk_StaffInCharge" value="<?php echo $copyrow['wrk_StaffInCharge']; ?>">
                                <input type="hidden" name="wrk_ManagerInChrge" value="<?php echo $copyrow['wrk_ManagerInChrge']; ?>">
                                <input type="hidden" name="wrk_SeniorInCharge" value="<?php echo $copyrow['wrk_SeniorInCharge']; ?>">
                                <input type="hidden" name="wrk_Createdby" value="<?php echo $copyrow['wrk_Createdby']; ?>">
                                <input type="hidden" name="wrk_Createdon" value="<?php echo $copyrow['wrk_Createdon']; ?>">
                                <input type="hidden" name="sql" value="insert">
                                <input type="hidden" name="copyid" value="<?php echo $_GET['copid']; ?>">
                    			<input type="submit" name="copy_submit" value="Save" style="background-color: #047ea7; padding:2px 5px 2px 5px; color:#FFFFFF; border:2px solid #000033; font-weight:bold; margin-left:200px; margin-top:20px; font-family:Arial,Tahoma, Verdana,  Helvetica, sans-serif; font-size:12px;">
                    			<input type="submit" name="copy_cancel" value="Cancel" style="background-color: #047ea7; padding:2px 5px 2px 5px; color:#FFFFFF; border:2px solid #000033; font-weight:bold; font-family:Arial,Tahoma, Verdana,  Helvetica, sans-serif; font-size:12px;" onClick="javascript: window.close();">
                                <br><br>
         		</div>
        	</form>
        <?php
        }
}
	$worksheetContent = new worksheetContentList();
?>

