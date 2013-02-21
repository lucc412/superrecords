<?php
	
class timesheetReportContentList extends Database
{
        function select($access_file_level_report)
        {
                  global $a;
                  global $showrecs;
                  global $page;
                  global $filter;
                  global $filterfield;
                  global $wholeonly;
                  global $order;
                  global $ordtype;
                  global $timesheetReportDbcontent;
                  global $commonUses;
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
                  $res = $timesheetReportDbcontent->sql_select();
                 // $count = sql_getrecordcount();
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
                <br>
                <span class="frmheading">Time Sheet Report</span>
                <div id="notprint"  >
                <hr size="1" noshade>
                <div style="right:0px; width:300;  ">
                <form  method="post" action="tis_timesheet_report.php"  name="timesheet_report" onSubmit="return validateFormOnSubmit_filter()">
                    <table width="1110px">
                        <tr>
                        <td>From Date  </td><td> <input type="text" name="tis_FromDate" id="tis_FromDate" value="<?php echo $_SESSION["tis_FromDate"];?>">&nbsp;<a href="javascript:NewCal('tis_FromDate','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                        </td>
                        <td>
                        Client
                        </td>
                        <td>
                        <div id="wrapper"><input type="hidden" id="tis_ClientCode" name="tis_ClientCode" value="" style="font-size: 10px; width: 20px;"  />
                                <input style="width: 200px" type="text" id="tis_ClientName" name="tis_ClientName"  value="<?php echo $_SESSION['tis_ClientName']?>"  onBlur="checkKeycode(event);" />
                         </div>
                        <script type="text/javascript">
                                var options = {
                                        script:"dbclass/wrk_client_db_class.php?json=true&limit=6&",
                                        varname:"input",
                                        json:true,
                                        shownoresults:false,
                                        maxresults:6,
                                        callback: function (obj) { document.getElementById('tis_ClientCode').value = obj.id; }
                                };
                                var as_json = new bsn.AutoSuggest('tis_ClientName', options);


                                var options_xml = {
                                        script: function (input) { return "dbclass/wrk_client_db_class.php?input="+input+"&con_Company="+document.getElementById('tis_ClientCode').value; },
                                        varname:"input"
                                };
                                var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
                        </script>

                        </td>
                        </tr>
                        <tr>
                        <td>To Date  </td><td><input type="text" name="tis_ToDate" id="tis_ToDate" value="<?php echo $_SESSION["tis_ToDate"];?>">&nbsp;<a href="javascript:NewCal('tis_ToDate','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                        </td>
                        <td>
                        Master Activity
                        </td>
                        <td>
                        <?php
                        $mas_query="SELECT * FROM `mas_masteractivity` order by mas_Order asc";
                        $mas_result=mysql_query($mas_query);
                        ?>
                        <select name="tis_MasterActivityList[]" id="tis_MasterActivityList"  multiple >
                                    <option value=""></option>

                            <?php while($mas_row=mysql_fetch_array($mas_result))
                                {

                                 ?>
                            <option value="<?php echo $mas_row['mas_Code']?>"    <?php
                                if(is_array($_SESSION['tis_MasterActivityList']))
                                {
                                foreach ($_SESSION['tis_MasterActivityList'] as $v )
                                {
                                if($mas_row['mas_Code']==$v) echo "selected";
                                }
                                }?> ><?php  echo $mas_row['Code'].($mas_row['Code']!=""? "-":"").$mas_row['mas_Description']?></option>
                             <?php   } ?>
                                 </select>
                        <input type="checkbox" name="SelectAll_MasterActivity" value="Yes" onClick="javascript:selectAll('tis_MasterActivityList', true);">Select All

                        </td>

                        </tr>
                        <tr>
                        <td>User</td>
                        <td>
                        <?php
                        if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
                        {
                        echo $_SESSION['user'];
                        ?>
                        <input type="hidden" name="tis_StaffCode" value="<?php echo $_SESSION['staffcode']; ?> ">
                        <?php
                        }
                        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                        {
                        $staff_query="SELECT stf_Code, stf_Login
                        FROM `stf_staff` t1
                        LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code
                        WHERE t2.aty_Description LIKE '%Staff%'
                        ORDER BY stf_Code";
                        $staff_result=mysql_query($staff_query);
                        ?>
                        <select name="tis_StaffList[]" id="tis_StaffList"   multiple >
                                    <option value=""></option>

                            <?php while($staff_row=mysql_fetch_array($staff_result)) {

                                 ?>
                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                if(is_array($_SESSION['tis_StaffList']))
                                {
                                foreach ($_SESSION['tis_StaffList'] as $v )
                                {
                                if($staff_row['stf_Code']==$v) echo "selected";
                                }
                                }?>><?php  echo $commonUses->getFirstLastName($staff_row['stf_Code']) ?></option>
                             <?php   } ?>
                                 </select>
                        <input type="checkbox" name="SelectAll_Staff" id="SelectAll_Staff" value="Yes" onClick="javascript:selectAll('tis_StaffList', true);">Select All
                        <?php
                        }

                        else
                        {
                        $staff_query="SELECT stf_Code, stf_Login
                        FROM `stf_staff` t1
                        LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code
                        WHERE t2.aty_Description LIKE '%Staff%'
                        ORDER BY stf_Code";
                        $staff_result=mysql_query($staff_query);
                        ?>
                        <select name="tis_StaffList[]" id="tis_StaffList"   multiple >
                                    <option value=""></option>

                            <?php while($staff_row=mysql_fetch_array($staff_result)) {

                                 ?>
                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                if(is_array($_SESSION['tis_StaffList']))
                                {
                                foreach ($_SESSION['tis_StaffList'] as $v )
                                {
                                if($staff_row['stf_Code']==$v) echo "selected";
                                }
                                }?>><?php  echo $commonUses->getFirstLastName($staff_row['stf_Code']) ?></option>
                             <?php   } ?>
                                 </select>
                        <input type="checkbox" name="SelectAll_Staff" id="SelectAll_Staff" value="Yes" onClick="javascript:selectAll('tis_StaffList', true);">Select All
                        <?php
                        }
                        ?>
                        </td>

                        <td>
                        Sub Activity
                        </td>
                        <td>
                        <?php
                        $sub_query="SELECT * FROM `sub_subactivity` order by sub_Order asc";
                        $sub_result=mysql_query($sub_query);

                        ?>
                        <select name="tis_SubActivityList[]" id="tis_SubActivityList"  multiple >
                                    <option value=""></option>

                            <?php while($sub_row=mysql_fetch_array($sub_result)) {


                                 ?>
                            <option value="<?php echo $sub_row['sub_Code']?>"  <?php
                                if(is_array($_SESSION['tis_SubActivityList']))
                                {
                                foreach ($_SESSION['tis_SubActivityList'] as $v )
                                {
                                if($sub_row['sub_Code']==$v) echo "selected";
                                }
                                }?> ><?php  echo $sub_row['Code'].($sub_row['Code']!=""? "-":"").$sub_row['sub_Description']?></option>
                             <?php   } ?>
                                 </select>
                        <input type="checkbox" name="SelectAll_SubActivity" value="Yes" onClick="javascript:selectAll('tis_SubActivityList', true);">Select All

                        </td>
                        </tr>
                        <tr>
                        <td>Status
                        </td>
                        <td>
                        <?php
                        $status_query ="select `tst_Code`,`tst_Description` from `tst_timesheetstatus` ORDER BY tst_Order ASC";
                        $status_result=mysql_query($status_query);
                          ?>
                        <select name="tis_StatusList" ><option value="">Select Status</option>

                        <?php while($status_row=mysql_fetch_array($status_result)) {
                        ?>
                            <option value="<?php echo $status_row['tst_Code']?>"   <?php  if($status_row['tst_Code']==$_SESSION['tis_StatusList']) echo "selected";?> ><?php  echo $status_row['tst_Description']?></option>
                             <?php   } ?>
                                 </select>
                        </td>
                        </tr>
                        <tr valign="middle">
                        <td colspan="2">&nbsp;</td>
                        <td ><input type="submit" name="Submit" value="Generate Report"   >
                        </td>
                        <td><input type="submit" name="Submit" value="Generate Excel Report"  >
                          <a href="tis_timesheet_report.php?a=reset" style="color:#FB5C24;font-weight:bold; font-family:Tahoma, Arial, Verdana; font-size:12px; margin:40px;  ">Reset Filter</a>
                        </td>
                        <td>
                        <?php if($_SESSION['Submit'] == 'Generate Report') { ?>
                            <a href="timesheet_report_pdf.php?cli_code=110"> <img src="images/pdf_icon.gif" style="margin-top:-7px; " alt="Pdf" name="Print" align="middle" border="0" /></a>
                            <?php } ?>
                        </td>
                        </tr>
                    </table>
                </form>
                </div>
                </div>
                <p id="printscreen">
                <br><table class="fieldtable_outer" align="center">
                <tr>
                <td>
                <?php
                 if($_SESSION['Submit'] == 'Generate Report')
                 {
                 $this->showpagenav($page, $pagecount);
                 }
                 ?>
                <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" >
                    <tr class="fieldheader">
                        <th class="fieldheader"><a href="tis_timesheet_report.php?order=<?php echo "tis_Date" ?>&type=<?php echo $ordtypestr?>">Date</a></th>
                         <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "lp_tis_StaffCode" ?>&type=<?php echo $ordtypestr ?>">User Name</a></th>
                         <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "lp_tis_CompanyName" ?>&type=<?php echo $ordtypestr ?>">Client</a></th>
                         <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "lp_tis_MasterActivity" ?>&type=<?php echo $ordtypestr ?>">Master Activity</a></th>
                        <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "lp_tis_SubActivity" ?>&type=<?php echo $ordtypestr ?>">Sub Activity</a></th>
                        <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "tis_ArrivalTime" ?>&type=<?php echo $ordtypestr ?>">Arrival Time</a></th>
                        <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "tis_DepartureTime" ?>&type=<?php echo $ordtypestr ?>">Departure Time</a></th>
                        <th class="fieldheader"><a  href="tis_timesheet_report.php?order=<?php echo "tis_Status" ?>&type=<?php echo $ordtypestr ?>">Status</a></th>
                        <th class="fieldheader"><a href="tis_timesheet_report.php?order=<?php echo "lp_tis_Units" ?>&type=<?php echo $ordtypestr?>">Units</a></th>
                        <?php
                        if($_SESSION['usertype']=="Administrator")
                        {
                        ?>
                        <th class="fieldheader"><a href="tis_timesheet_report.php?order=<?php echo "lp_tis_NetUnits" ?>&type=<?php echo $ordtypestr?>">Net Units</a></th>
                        <?php
                        }
                        ?>
                        <th class="fieldheader"><a href="tis_timesheet_report.php?order=<?php echo "tis_Details" ?>&type=<?php echo $ordtypestr?>">Details</a></th>
                        <th id="notprint"  class="fieldheader" colspan="3" align="center">Actions</th>
                    </tr>
                    <?php
                    if($_SESSION['Submit']=="Generate Report")
                    {
                    if($reccount==0)
                    echo "<tr><td colspan='13'><b><center>No matching records found</center></b></td></tr>";
                    for ($i = $startrec; $i < $reccount; $i++)
                     {
                       $row = mysql_fetch_assoc($res);
                    ?>
                    <tr>
                        <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["tis_Date"]);?></td>
                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["tis_StaffCode"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_CompanyName"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_MasCode"]).($row["lp_tis_MasCode"]!=""? "-":"").htmlspecialchars($row["lp_tis_MasterActivity"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_SubCode"]).($row["lp_tis_SubCode"]!=""? "-":"").htmlspecialchars($row["lp_tis_SubActivity"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["tis_ArrivalTime"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["tis_DepartureTime"]) ?></td>
                        <td class="<?php echo $style ?>"><?php   echo $commonUses->getTimesheetStatus(htmlspecialchars($row["tis_Status"])); ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_Units"]);?></td>
                        <?php
                        if($_SESSION['usertype']=="Administrator")
                        {
                        ?>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_NetUnits"]);?></td>
                        <?php
                        }
                        ?>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["Details"]);?></td>
                        <?php
                          if($access_file_level['stf_View']=="Y" || $access_file_level_report['stf_View']=="Y")
                                  {
                        ?>
                        <td id="notprint">
                        <a href="tis_timesheet.php?a=view&tid=<?php echo $row["tis_Code"] ?>" target="_blank">
                        <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                        </td>
                        <?php } ?>
                        <?php
                          if($access_file_level['stf_Edit']=="Y" || $access_file_level_report['stf_Edit']=="Y")
                                  {
                        ?>
                        <td id="notprint">
                        <a href="tis_timesheet.php?a=edit&tid=<?php echo $row["tis_Code"] ?>" target="_blank">
                        <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                        </td>
                        <?php } ?>
                        <?php
                          if($access_file_level['stf_Delete']=="Y" || $access_file_level_report['stf_Delete']=="Y")
                                  {
                        ?>
                        <td id="notprint">
                        <a onClick="performdelete('tis_timesheet_report.php?mode=delete&recid=<?php echo htmlspecialchars($row["tis_Code"]) ?>'); return false;" href="#" target="_blank">
                        <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php }
                      }
                        if( $_SESSION['Submit']=="Generate Excel Report")
                      {
                       header("Location:dbclass/generate_excel_class.php?report=timesheet");
                      }
                      mysql_free_result($res);
                    ?>
                </table>
                </p>
                <br>
        <?php }
        function showpagenav($page, $pagecount)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a href="tis_timesheet_report.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="tis_timesheet_report.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="tis_timesheet_report.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="tis_timesheet_report.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }

}
	$timesheetReportContent = new timesheetReportContentList();

?>

