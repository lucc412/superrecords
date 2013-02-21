<?php
	
class wrkReportContentList extends Database
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
                  global $wrkReportDbcontent;
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
                  $res = $wrkReportDbcontent->sql_select();
                  //$count = sql_getrecordcount();
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
                <span class="frmheading">
                 Worksheet Report
                </span>
                <div id="notprint">
                <hr size="1" noshade><div style="right:0px; width:300; ">

                <form  method="post" action="wrk_worksheet_report.php"  name="worksheet_report" onSubmit="return validateFormOnSubmitReport()">
                <table width="1100px">
                        <tr>
                                <td>Befree Due Date From</td><td> <input type="text" name="wrk_FromDate" id="wrk_FromDate" value="<?php echo $_SESSION['wrk_FromDate'] ?>">&nbsp;<a href="javascript:NewCal('wrk_FromDate','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                </td>
                                <td>
                                        External Due Date From
                                </td>
                                <td>
                                    <input type="text" name="wrk_ExdateFrom" id="wrk_ExdateFrom" value="<?php echo $_SESSION['wrk_ExdateFrom'] ?>">&nbsp;<a href="javascript:NewCal('wrk_ExdateFrom','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                </td>
                        </tr>
                        <tr>
                                <td>Befree Due Date To</td><td><input type="text" name="wrk_ToDate" id="wrk_ToDate" value="<?php echo $_SESSION['wrk_ToDate'];?>">&nbsp;<a href="javascript:NewCal('wrk_ToDate','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                </td>
                                <td>External Due Date To</td><td><input type="text" name="wrk_ExdateTo" id="wrk_ExdateTo" value="<?php echo $_SESSION['wrk_ExdateTo'];?>">&nbsp;<a href="javascript:NewCal('wrk_ExdateTo','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                </td>
                        </tr>

                        <tr>
                                <td>
                                        Client
                                </td>
                                <td>
                                        <div id="wrapper"><input type="hidden" id="wrk_ClientCode" name="wrk_ClientCode" value="" style="font-size: 10px; width: 20px;"  />
                                                <input style="width: 200px" type="text" id="wrk_ClientName" name="wrk_ClientName" value="<?php echo $_SESSION['wrk_ClientName']?>"  />
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
                                                        var as_json = new bsn.AutoSuggest('wrk_ClientName', options);

                                                        var options_xml = {
                                                                script: function (input) { return "as/test.php?input="+input+"&con_Company="+document.getElementById('wrk_ClientCode').value; },
                                                                varname:"input"
                                                                };
                                                        var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
                                        </script>
                                 </td>
                                <td>
                                        Master Activity
                                </td>
                                <td>
                                        <?php
                                                $mas_query="SELECT * FROM `mas_masteractivity` order by mas_Order asc";
                                                $mas_result=mysql_query($mas_query);
                                        ?>
                                        <select name="wrk_MasterActivityList[]" id="wrk_MasterActivityList"  multiple >
                                            <option value=""></option>
                                                <?php while($mas_row=mysql_fetch_array($mas_result))
                                                {
                                                ?>
                                                <option value="<?php echo $mas_row['mas_Code']?>"    <?php
                                                if(is_array($_SESSION['wrk_MasterActivityList']))
                                                {
                                                        foreach ($_SESSION['wrk_MasterActivityList'] as $v )
                                                        {
                                                                if($mas_row['mas_Code']==$v) echo "selected";
                                                        }
                                                }?> ><?php  echo $mas_row['Code'].($mas_row['Code']!=""? "-":"").$mas_row['mas_Description']?></option>
                                             <?php   } ?>
                                        </select>
                                        <input type="checkbox" name="SelectAll_Mas" id="SelectAll_Mas" value="Yes" onClick="javascript:selectAll('wrk_MasterActivityList', true);">Select All
                                </td>
                        </tr>
                        <tr>
                            <?php
                            if($_SESSION['usertype']=="Administrator")
                            {
                            ?>
                                <td>Team In Charge</td>
                                <td>
                                  <?php
                                  $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                        $staff_result=mysql_query($staff_query);
                                                ?>
                                                <select name="wrk_TeamList[]" id="wrk_TeamList"    multiple >
                                                    <option value=""></option>
                                                        <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                        ?>
                                                        <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                        if(is_array($_SESSION['wrk_TeamList']))
                                                        {
                                                                foreach ($_SESSION['wrk_TeamList'] as $v )
                                                        {
                                                                if($staff_row['stf_Code']==$v) echo "selected";
                                                        }
                                                        }?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname']; ?></option>
                                                        <?php   } ?>
                                                </select>
                                                <input type="checkbox" name="SelectAll_Team" id="SelectAll_Team" value="Yes" onClick="javascript:selectAll('wrk_TeamList', true);">Select All
                                </td>
                        <?php  }
                        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                        {
                        ?>
                                <td>Team In Charge</td>
                                <td>
                                        <?php
                                  $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                        $staff_result=mysql_query($staff_query);
                                                ?>
                                                <select name="wrk_TeamList[]" id="wrk_TeamList"    multiple >
                                            <option value=""></option>

                                            <?php while($staff_row=mysql_fetch_array($staff_result)) {

                                                 ?>
                                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                        if(is_array($_SESSION['wrk_TeamList']))
                                                        {
                                                                foreach ($_SESSION['wrk_TeamList'] as $v )
                                                        {
                                                                if($staff_row['stf_Code']==$v) echo "selected";
                                                        }
                                                        }?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname']; ?></option>
                                                     <?php   } ?>
                                         </select>
                                        <input type="checkbox" name="SelectAll_Team" id="SelectAll_Team" value="Yes" onClick="javascript:selectAll('wrk_TeamList', true);">Select All
                                </td>
                            <?php  }?>
                                <td>
                                        Sub Activity
                                </td>
                                <td>
                                        <?php
                                                $sub_query="SELECT * FROM `sub_subactivity` order by Code";
                                                $sub_result=mysql_query($sub_query);

                                        ?>
                                        <select name="wrk_SubActivityList[]" id="wrk_SubActivityList"  multiple >
                                                    <option value=""></option>
                                                        <?php while($sub_row=mysql_fetch_array($sub_result)) {
                                                        ?>
                                                        <option value="<?php echo $sub_row['sub_Code']?>"  <?php
                                                        if(is_array($_SESSION['wrk_SubActivityList']))
                                                        {
                                                            foreach ($_SESSION['wrk_SubActivityList'] as $v )
                                                            {
                                                                if($sub_row['sub_Code']==$v) echo "selected";
                                                            }
                                                        }?> ><?php  echo $sub_row['Code'].($sub_row['Code']!=""? "-":"").$sub_row['sub_Description']?></option>
                                                        <?php   } ?>
                                         </select>
                                        <input type="checkbox" name="SelectAll_SubActivity" id="SelectAll_SubActivity" value="Yes" onClick="javascript:selectAll('wrk_SubActivityList', true);">Select All
                                </td>
                        </tr>
                        <tr>
                            <?php
                            if($_SESSION['usertype']=="Administrator")
                            {
                            ?>
                                <td>Manager In Charge</td>
                                <td>
                                  <?php
                                  $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=17 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                $staff_result=mysql_query($staff_query);
                                       ?>
                                        <select name="wrk_ManagerList[]" id="wrk_ManagerList"   multiple >
                                        <option value=""></option>
                                            <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                 ?>
                                                    <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                        if(is_array($_SESSION['wrk_ManagerList']))
                                                        {
                                                                foreach ($_SESSION['wrk_ManagerList'] as $v )
                                                        {
                                                                if($staff_row['stf_Code']==$v) echo "selected";
                                                        }
                                                        }?>><?php  echo $staff_row['con_Firstname']."".$staff_row['con_Lastname']; ?></option>
                                                     <?php   } ?>
                                         </select>
                                        <input type="checkbox" name="SelectAll_Manager" id="SelectAll_Manager" value="Yes" onClick="javascript:selectAll('wrk_ManagerList', true);">Select All
                                </td>

                                <?php }
                        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                        {
                        ?>

                                <td>Manager In Charge</td>
                                <td>
                                        <?php
                                  $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=17 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                $staff_result=mysql_query($staff_query);
                                        ?>
                                        <select name="wrk_ManagerList[]" id="wrk_ManagerList"   multiple >
                                            <option value=""></option>
                                                <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                 ?>
                                                    <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                        if(is_array($_SESSION['wrk_ManagerList']))
                                                        {
                                                                foreach ($_SESSION['wrk_ManagerList'] as $v )
                                                        {
                                                                if($staff_row['stf_Code']==$v) echo "selected";
                                                        }
                                                        }?>><?php  echo $staff_row['con_Firstname']."".$staff_row['con_Lastname']; ?></option>
                                                     <?php   } ?>
                                         </select>
                                        <input type="checkbox" name="SelectAll_Manager" id="SelectAll_Manager" value="Yes" onClick="javascript:selectAll('wrk_ManagerList', true);">Select All
                                </td>

                          <?php } ?>
                                <td>Status
                                </td>
                                <td>
                                        <?php
                                                $status_query ="select `wst_Code`,`wst_Description` from `wst_worksheetstatus` ORDER BY wst_Order ASC";
                                                $status_result=mysql_query($status_query);
                                          ?>
                                        <select name="wrk_StatusList[]" id="wrk_StatusList"   multiple >
                                            <option value=""></option>
                                                <?php while($status_row=mysql_fetch_array($status_result)) {
                                                 ?>
                                                <option value="<?php echo $status_row['wst_Code'] ?>"  <?php
                                                if(is_array($_SESSION['wrk_StatusList']))
                                                {
                                                        foreach ($_SESSION['wrk_StatusList'] as $v )
                                                {
                                                        if($status_row['wst_Code']==$v) echo "selected";
                                                }
                                                }?>><?php  echo $status_row['wst_Description']?></option>
                                             <?php   } ?>
                                        </select>
                                        <input type="checkbox" name="SelectAll_Status" id="SelectAll_Status" value="Yes" onClick="javascript:selectAll('wrk_StatusList', true);">Select All
                                </td>
                        </tr>
                        <tr>
                            <?php
                            if($_SESSION['usertype']=="Administrator")
                            {
                            ?>
                                <td>Staff In Charge</td>
                                <td>
                                        <?php
                                                if($_SESSION['usertype']=="Staff")
                                                {
                                                        echo $_SESSION['user'];
                                        ?>
                                        <input type="hidden" name="wrk_StaffCode" value="<?php echo $_SESSION['staffcode']; ?> ">
                                        <?php
                                        }
                                        else
                                        {
                                        $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' AND c1.con_Firstname!='' ORDER BY c1.con_Firstname";
                                                $staff_result=mysql_query($staff_query);
                                        ?>
                                        <select name="wrk_StaffList[]" id="wrk_StaffList"    multiple >
                                            <option value=""></option>
                                                <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                 ?>
                                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                if(is_array($_SESSION['wrk_StaffList']))
                                                {
                                                        foreach ($_SESSION['wrk_StaffList'] as $v )
                                                {
                                                        if($staff_row['stf_Code']==$v) echo "selected";
                                                }
                                                }?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname'] ?></option>
                                             <?php   } ?>
                                        </select>
                                        <input type="checkbox" name="SelectAll_Staff" id="SelectAll_Staff" value="Yes" onClick="javascript:selectAll('wrk_StaffList', true);">Select All
                                        <?php
                                        }
                                        ?>
                                </td>
                        <?php }
                        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                        {
                        ?>
                        <td>Staff In Charge</td>
                                <td>
                                        <?php
                                  $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' AND c1.con_Firstname!='' ORDER BY c1.con_Firstname";
                                                $staff_result=mysql_query($staff_query);
                                        ?>
                                        <select name="wrk_StaffList[]" id="wrk_StaffList"    multiple >
                                            <option value=""></option>
                                                <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                 ?>
                                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                if(is_array($_SESSION['wrk_StaffList']))
                                                {
                                                        foreach ($_SESSION['wrk_StaffList'] as $v )
                                                {
                                                        if($staff_row['stf_Code']==$v) echo "selected";
                                                }
                                                }?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname'] ?></option>
                                             <?php   } ?>
                                        </select>
                                        <input type="checkbox" name="SelectAll_Staff" id="SelectAll_Staff" value="Yes" onClick="javascript:selectAll('wrk_StaffList', true);">Select All
                                </td>
                        <?php } ?>
                                <td>Category</td>
                                <td>
                                    <select name="cli_Category" id="cli_Category">
                                        <option value="">Select Category</option>
                                        <option value="1" <?php if($_SESSION["cli_Category"]=="1") echo "selected"; ?>>1</option>
                                        <option value="2" <?php if($_SESSION["cli_Category"]=="2") echo "selected"; ?>>2</option>
                                        <option value="3" <?php if($_SESSION["cli_Category"]=="3") echo "selected"; ?>>3</option>
                                    </select>
                                </td>
                        </tr>
                        <tr>
                            <?php
                            if($_SESSION['usertype']=="Administrator")
                            {
                            ?>
                                <td>Senior In Charge</td>
                                <td>
                                        <?php
                                        $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                $staff_result=mysql_query($staff_query);
                                        ?>
                                        <select name="wrk_SeniorList[]" id="wrk_SeniorList"    multiple >
                                            <option value=""></option>
                                                <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                 ?>
                                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                if(is_array($_SESSION['wrk_SeniorList']))
                                                {
                                                        foreach ($_SESSION['wrk_SeniorList'] as $v )
                                                {
                                                        if($staff_row['stf_Code']==$v) echo "selected";
                                                }
                                                }?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname'] ?></option>
                                             <?php   } ?>
                                        </select>
                                        <input type="checkbox" name="SelectAll_Senior" id="SelectAll_Senior" value="Yes" onClick="javascript:selectAll('wrk_SeniorList', true);">Select All
                                </td>
                        <?php }
                        else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                        {
                        ?>
                        <td>Senior In Charge</td>
                                <td>
                                        <?php
                                  $staff_query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                $staff_result=mysql_query($staff_query);
                                        ?>
                                        <select name="wrk_SeniorList[]" id="wrk_SeniorList"    multiple >
                                            <option value=""></option>
                                                <?php while($staff_row=mysql_fetch_array($staff_result)) {
                                                 ?>
                                            <option value="<?php echo $staff_row['stf_Code']?>"  <?php
                                                if(is_array($_SESSION['wrk_SeniorList']))
                                                {
                                                        foreach ($_SESSION['wrk_SeniorList'] as $v )
                                                {
                                                        if($staff_row['stf_Code']==$v) echo "selected";
                                                }
                                                }?>><?php  echo $staff_row['con_Firstname']." ".$staff_row['con_Lastname'] ?></option>
                                             <?php   } ?>
                                        </select>
                                        <input type="checkbox" name="SelectAll_Senior" id="SelectAll_Senior" value="Yes" onClick="javascript:selectAll('wrk_SeniorList', true);">Select All
                                </td>
                        <?php } ?>
                        </tr>
                        
                        <tr valign="middle">
                            <td colspan="2">&nbsp;</td>
                            <td ><input type="submit" name="Submit" value="Generate Report"   >
                            </td>
                            <td><input type="submit" name="Submit" value="Generate Excel Report"  >
                            <a href="wrk_worksheet_report.php?a=reset" style="color:#FB5C24;font-weight:bold; font-family:Tahoma, Arial, Verdana; font-size:12px; margin:40px; ">Reset Filter</a>
                            </td>
                            <td>
                                <?php if($_SESSION['Submit'] == 'Generate Report') { ?>
                                <a href="worksheet_report_pdf.php"><img src="images/pdf_icon.gif" style="margin-top:-7px; " alt="Pdf" align="middle" border="0" /></a>
                                <?php } ?>
                            </td>
                        </tr>
                </table>
            </form>
            </div></div>
                <p id="printscreen">
                <?php
                 if($_SESSION['Submit'] == 'Generate Report')
                 {
                         $this->showpagenav($page, $pagecount);
                 }
                ?><br><br>
                <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" width="100%" >
                    <tr class="fieldheader">
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "lp_wrk_CompanyName" ?>&type=<?php echo $ordtypestr ?>">Client</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "cli_Category" ?>&type=<?php echo $ordtypestr ?>">Category</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "lp_wrk_TeamInCharge" ?>&type=<?php echo $ordtypestr ?>">Team In Charge</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "lp_wrk_StaffInCharge" ?>&type=<?php echo $ordtypestr ?>">Staff In Charge</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "lp_wrk_priority" ?>&type=<?php echo $ordtypestr ?>">Priority</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "lp_wrk_MasterActivity" ?>&type=<?php echo $ordtypestr ?>">Master Activity</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet.php?order=<?php echo "lp_wrk_SubActivity" ?>&type=<?php echo $ordtypestr ?>">Sub Activity</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "wrk_Details" ?>&type=<?php echo $ordtypestr ?>">Last Reports Sent</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "wrk_Notes" ?>&type=<?php echo $ordtypestr ?>">Current Job in Hand</a></th>
                        <th class="fieldheader" style="padding:0px 40px 0px 40px;"><a  href="wrk_worksheet_report.php?order=<?php echo "wrk_TeamInChargeNotes" ?>&type=<?php echo $ordtypestr ?>">Team Incharge Notes</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "wrk_DueDate" ?>&type=<?php echo $ordtypestr ?>">External Due Date</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "wrk_InternalDueDate" ?>&type=<?php echo $ordtypestr ?>">Befree Due Date</a></th>
                        <th class="fieldheader"><a  href="wrk_worksheet_report.php?order=<?php echo "lp_wrk_Status" ?>&type=<?php echo $ordtypestr ?>">Status</a></th>
                        <th  class="fieldheader" colspan="3" align="center">Actions</th>
                    </tr>
                    <?php
                    if($_SESSION['Submit'] == 'Generate Report')
                    {
                      for ($i = $startrec; $i < $reccount; $i++)
                    {
                        $row = mysql_fetch_assoc($res);
                    ?>
                    <tr>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_CompanyName"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["cli_Category"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_TeamInCharge"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["wrk_StaffInCharge"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_priority"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_wrk_MasCode"]).($row["lp_wrk_MasCode"]!=""? "-":"").htmlspecialchars($row["lp_wrk_MasterActivity"]) ?></td>
                        <td class=""><?php echo $row['lp_wrk_SubCode'].($row['lp_wrk_SubCode']!=""? "-":"").$row['lp_wrk_SubActivity'];?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["wrk_Details"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["wrk_Notes"]) ?></td>
                        <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["wrk_TeamInChargeNotes"]) ?></td>
                        <td class=""><?php if($row['wrk_DueDate']!="0000-00-00") { $date = $row['wrk_DueDate']; echo date('d/M/Y', strtotime($date)); } ?></td>
                        <td class=""><?php if($row['wrk_InternalDueDate']!="0000-00-00") {  $internaldate = $row['wrk_InternalDueDate']; echo date('d/M/Y', strtotime($internaldate)); } ?></td>
                        <td class="<?php echo $style ?>" <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?> nowrap>
                        <?php
                        //Check access rights
                          if($access_file_level_report['stf_Edit']=="Y")
                                  {
                           //Inline stage edit
                                 if($_GET['page']!="")
                                 $addquery="?page=".$_GET['page'];
                                 if($_GET['order']!="" && $_GET['type']!="")
                                 $addquery="?order=".$_GET['order']."&type=".$_GET['type'];
                        ?>
                        <form action="wrk_worksheet_report.php<?php echo $addquery; ?>" method="post">
                        <select name="wrk_Status" onChange="if(confirm('Save?')){this.form.gridedit.click();} else { location.href='wrk_worksheet_report.php'}"  ><option value="0">Select Status</option>
                        <?php
                          $sql_stage = "select `wst_Code`, `wst_Description` from `wst_worksheetstatus` ORDER BY wst_Order ASC";
                          $res_stage = mysql_query($sql_stage) or die(mysql_error());

                          while ($lp_row = mysql_fetch_assoc($res_stage)){
                          $val = $lp_row["wst_Code"];
                          $caption = $lp_row["wst_Description"];
                          if ($row["lp_wrk_Status"] ==  $caption) {$selstr = " selected"; } else {$selstr = ""; }
                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                        <?php } ?></select>
                        <input type="hidden" name="workcode" value="<?php echo $row["wrk_Code"]; ?>">
                        <input type="submit" name="gridedit" value="save">
                        </form>
                         <?php
                        }
                        else
                        {
                        echo htmlspecialchars($row["lp_wrk_Status"]);
                        }
                        ?>
                        </td>
                        <?php
                          if($access_file_level['stf_View']=="Y" || $access_file_level_report['stf_View']=="Y")
                                  {
                        ?>
                        <td id="notprint"  <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?>>
                        <a href="wrk_worksheet.php?a=view&wid=<?php echo $row['wrk_Code']; ?>" target="_blank">
                        <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                        </td>
                        <?php } ?>
                         <?php
                          if($access_file_level['stf_Edit']=="Y" || $access_file_level_report['stf_Edit']=="Y")
                                  {
                        ?>
                        <td id="notprint"  <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?>>
                        <a href="wrk_worksheet.php?a=edit&wid=<?php echo $row['wrk_Code']; ?>" target="_blank">
                        <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                        </td>
                        <?php } ?>
                        <?php
                          if($access_file_level['stf_Delete']=="Y" || $access_file_level_report['stf_Delete']=="Y")
                                  {
                        ?>
                        <td id="notprint"  <?php echo ($row["wrk_InternalDueDate"] <= date('Y-m-d')? "style=\"background-color:white\"":"") ?>>
                        <a onClick="performdelete('wrk_worksheet_report.php?mode=delete&recid=<?php echo htmlspecialchars($row["wrk_Code"]) ?>'); return false;" href="#">
                        <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                        </td>
                        <?php }  ?>
                     </tr>
                <?php }  }
                if( $_SESSION['Submit']=="Generate Excel Report")
                  {
                   header("Location:dbclass/generate_excel_class.php?report=worksheet");
                  }
                 ?>
                </table>
                </p>
        <?php }
        function showpagenav($page, $pagecount)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                 <?php if ($page > 1) { ?>
                    <td><a href="wrk_worksheet_report.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="wrk_worksheet_report.php?page=<?php echo $j ?>&submit=Generate Report"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="wrk_worksheet_report.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="wrk_worksheet_report.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }

}
	$wrkReportContent = new wrkReportContentList();

?>

