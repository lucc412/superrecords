<?php
	
class casesContentList extends Database
{
        function select($access_file_level)
         {
                  global $a;
                  global $showrecs;
                  global $page;
                  global $filter;
                  global $filterfield;
                  global $wholeonly;
                  global $order;
                  global $ordtype;
                  global $casesDbcontent;
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
                  $res = $casesDbcontent->sql_select();
                 // $count = sql_getrecordcount();
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
				<div class="frmheading">
					<h1>Tickets</h1>
				</div>
                <form action="cas_cases.php" method="post">
                    <table class="customFilter" align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
                        <tr>
                            <td><b>Custom Filter</b>&nbsp;</td>
                            <td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
                            <td><select name="filter_field">
                            <option value="allfields">All Fields</option>
                            <option value="<?php echo "t1.`cas_Code`" ?>"<?php if ($filterfield == "t1.`cas_Code`") { echo "selected"; } ?>>Ticket Number</option>
                            <option value="<?php echo "lp1.`name`" ?>"<?php if ($filterfield == "lp1.`name`") { echo "selected"; } ?>>Client Name</option>
                            <option value="<?php echo "lp3.`mas_Description`" ?>"<?php if ($filterfield == "lp3.`mas_Description`") { echo "selected"; } ?>>Master Activity</option>
                            <option value="<?php echo "lp4.`sub_Description`" ?>"<?php if ($filterfield == "lp4.`sub_Description`") { echo "selected"; } ?>>Sub Activity</option>
                            <option value="<?php echo "lp5.`pri_Description`" ?>"<?php if ($filterfield == "lp5.`pri_Description`") { echo "selected"; } ?>>Priority</option>
                            <option value="<?php echo "lp6.`cas_Description`" ?>"<?php if ($filterfield == "lp6.`cas_Description`") { echo "selected"; } ?>>Status</option>
                            <option value="<?php echo "staffincharge" ?>"<?php if ($filterfield == "staffincharge") { echo "selected"; } ?>>Staff In Charge</option>
                            <option value="<?php echo "teamincharge" ?>"<?php if ($filterfield == "teamincharge") { echo "selected"; } ?>>Team In Charge</option>
                            <option value="<?php echo "managerincharge" ?>"<?php if ($filterfield == "managerincharge") { echo "selected"; } ?>>Manager In Charge</option>
                            <option value="<?php echo "seniorincharge" ?>"<?php if ($filterfield == "seniorincharge") { echo "selected"; } ?>>Senior In Charge</option>
                            </select></td>
                            <td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
                            </td>
                        </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
                        <td><a href="cas_cases.php?a=reset" class="hlight">Reset Filter</a></td>
                    </tr>
                    </table>
                </form>
                <br><br><br><br>
                        <?php
                          if($access_file_level['stf_Add']=="Y")
                          {
                        ?>
                        <a href="cas_cases.php?a=add" class="hlight">
                        <img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a> <?php } ?>
                        <?php $this->showpagenav($page, $pagecount); ?>
                        <br><br>
                    <table class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5" >
                        <tr class="fieldheader">
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_Code" ?>&type=<?php echo $ordtypestr ?>">Ticket Number</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_Type" ?>&type=<?php echo $ordtypestr ?>">Ticket Type</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_ClientCode" ?>&type=<?php echo $ordtypestr ?>">Client Name</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_MasterActivity" ?>&type=<?php echo $ordtypestr ?>">Master Activity</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_SubActivity" ?>&type=<?php echo $ordtypestr ?>">Sub Activity</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_Priority" ?>&type=<?php echo $ordtypestr ?>">Priority</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_Status" ?>&type=<?php echo $ordtypestr ?>">Status</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_StaffInCharge" ?>&type=<?php echo $ordtypestr ?>">Staff In Charge</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_TeamInCharge" ?>&type=<?php echo $ordtypestr ?>">Team In Charge</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_ManagerInChrge" ?>&type=<?php echo $ordtypestr ?>">Manager In Charge</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "lp_cas_SeniorInCharge" ?>&type=<?php echo $ordtypestr ?>">Senior In Charge</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_InternalDueDate" ?>&type=<?php echo $ordtypestr ?>">Super Records Due Date</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_ExternalDueDate" ?>&type=<?php echo $ordtypestr ?>">External Due Date</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_Createdby" ?>&type=<?php echo $ordtypestr ?>">Created by</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_Createdon" ?>&type=<?php echo $ordtypestr ?>">Created Date</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_StatusCompletedby" ?>&type=<?php echo $ordtypestr ?>">Status Completed by</a></th>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_StatusCompletedon" ?>&type=<?php echo $ordtypestr ?>">Status Completed Date</a></th>
                        <?php
                        if( $_POST['filter_field']=="cas_ClosedDate")
                        {
                        ?>
                        <th class="fieldheader"><a  href="cas_cases.php?order=<?php echo "cas_ClosedDate" ?>&type=<?php echo $ordtypestr ?>">Completion Date</a></th>
                        <?php } ?>
                        <th  class="fieldheader" colspan="3" align="center">Actions</th>
                        </tr>
                        <?php
                           for ($i = $startrec; $i < $reccount; $i++)
                          {
                            $row = mysql_fetch_assoc($res);
						 ?>
                        <tr style="background-color: <?php if($row["cas_Type"]=="1") echo "#a4d8a4"; else if($row["cas_Type"]=="2") echo "#ffab7f"; else echo "#d5eef3"; ?>">
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["cas_Code"]) ?></td>
                            <td class="<?php echo $style ?>"><?php if($row["cas_Type"]=="1") echo "Request";  else if($row["cas_Type"]=="2") echo "Issue"; else echo "Internal"; ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_cas_ClientCode"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_cas_Code"]).($row["lp_cas_Code"]!=""? "-":"").stripslashes($row["lp_cas_MasterActivity"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_cas_subCode"]).($row["lp_cas_subCode"]!=""? "-":"").stripslashes($row["lp_cas_SubActivity"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_cas_Priority"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_cas_Status"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_StaffInCharge"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_TeamInCharge"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_ManagerInChrge"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_SeniorInCharge"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["cas_InternalDueDate"]); ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["cas_ExternalDueDate"]); ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_Createdby"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["cas_Createdon"]); ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_StatusCompletedby"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["cas_StatusCompletedon"]); ?></td>
                            <?php
                             if($access_file_level['stf_View']=="Y")
                            {
                            ?>  <td style="background-color:white;">
                            <a href="cas_cases.php?a=view&recid=<?php echo $i ?>&cid=<?php echo $row['cas_Code']; ?>">
                            <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                            </td><?php } ?>
                            <?php
                              if($access_file_level['stf_Edit']=="Y")
                               {
                            ?>
                            <td style="background-color:white;">
                            <a href="cas_cases.php?a=edit&recid=<?php echo $i ?>&cid=<?php echo $row['cas_Code']; ?>">
                            <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                            </td><?php } ?>
                            <?php
                              if($access_file_level['stf_Delete']=="Y")
                              {
                            ?>
                            <td style="background-color:white;">
                            <a onClick="performdelete('cas_cases.php?mode=delete&recid=<?php echo stripslashes($row["cas_Code"]) ?>'); return false;" href="#">
                            <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                            </td><?php } ?>
                        </tr>
                        <?php
                          }
                  mysql_free_result($res);
                ?>
                </table>
                <br>
        <?php $this->showpagenav($page, $pagecount);
        }
        function showrow($row, $recid)
        {
            global $commonUses;
            ?>
                <table class="tbl" border="0" cellspacing="12" width="70%">
                    <tr>
                        <td class="hr">Ticket Number</td>
                        <td class="dr">
                              <?php  echo $row["cas_Code"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Type</td>
                        <td class="dr"><?php if($row["cas_Type"]=='3') echo "Internal"; else if($row["cas_Type"]=='2') echo "Issue"; else echo "Request"; ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Subject</td>
                        <td class="dr"><?php echo stripslashes($row["cas_Title"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Client Name</td>
                        <td class="dr"><?php echo stripslashes($row["lp_cas_ClientCode"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Contact</td>
                        <td class="dr"><?php echo stripslashes($row["lp_cas_ClientContact"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Billing Person</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_BillingPerson"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Australia Manager</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_AustraliaManager"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Manager In Charge</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_ManagerInChrge"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Senior In Charge</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_SeniorInCharge"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Team In Charge</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_TeamInCharge"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Staff In Charge</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_StaffInCharge"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Sales Person</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_SalesPerson"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Master Activity</td>
                        <td class="dr"><?php echo stripslashes($row["lp_cas_Code"]).($row["lp_cas_Code"]!=""? "-":"").stripslashes($row["lp_cas_MasterActivity"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Sub Activity</td>
                        <td class="dr"><?php echo stripslashes($row["lp_cas_subCode"]).($row["lp_cas_subCode"]!=""? "-":"").stripslashes($row["lp_cas_SubActivity"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Priority</td>
                        <td class="dr"><?php echo stripslashes($row["lp_cas_Priority"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Status</td>
                        <td class="dr"><?php echo stripslashes($row["lp_cas_Status"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Internal Due Date</td>
                        <td class="dr"><?php echo $commonUses->showGridDateFormat($row["cas_InternalDueDate"]); ?></td>
                    </tr>
                    <tr>
                        <td class="hr">External Due Date</td>
                        <td class="dr"><?php echo $commonUses->showGridDateFormat($row["cas_ExternalDueDate"]); ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Due Time</td>
                        <td class="dr"><?php echo stripslashes($row["cas_DueTime"]) ?></td>
                    </tr>
                    <!--
                    <tr>
                        <td class="hr">Closure Reason</td>
                        <td class="dr"><?php echo stripslashes($row["cas_ClosureReason"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Hours Spent</td>
                        <td class="dr"><?php echo stripslashes($row["cas_HoursSpentDecimal"]) ?></td>
                    </tr>
                    -->
                    <tr>
                        <td class="hr">Issue Details</td>
                        <td class="dr"><?php echo stripslashes($row["cas_IssueDetails"]) ?></td>
                    </tr>
                    <!--
                    <tr>
                        <td class="hr">Super Records Comments</td>
                        <td class="dr"><?php echo stripslashes($row["cas_Notes"]) ?></td>
                    </tr>
                    -->
                    <tr>
                        <td class="hr">Explain why this has occurred</td>
                        <td class="dr"><?php echo stripslashes($row["cas_Issue_Occurred"]) ?></td>
                    </tr>
                    <tr>
                        <td>Action Required</td>
                        <td><?
							$act_query = mysql_query("SELECT * from cas_actionrequired WHERE cas_Code=".$_GET['cid']." AND (cas_ActionDetails <> NULL OR cas_Staff <> 0) ORDER BY id");
							$totRows = mysql_num_rows($act_query);
							
							if(!empty($totRows)) {
								?><table class="fieldtable" cellpadding="3">
									<tr class="fieldheader">
										<th style="padding-left:10px;padding-right:10px">Action Details</th>
										<th style="padding-left:10px;padding-right:10px">Assigned Staff</th>
									</tr><?
									
									$i = 1;
									while($act_row = mysql_fetch_array($act_query)) {
										if(!empty($act_row['cas_ActionDetails']) || !empty($act_row['cas_Staff'])) {
											?><tr>
												<td><?=$act_row['cas_ActionDetails'];?></td>
												<td>
													<?=$commonUses->getFirstLastName($act_row['cas_Staff']);?>
												</td>
											</tr><?
										}
									}
								?></table><?
							}
                         ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Resolution</td>
                        <td class="dr"><?php echo stripslashes($row["cas_Resolution"]) ?></td>
                    </tr>
                    <!--
                    <tr>
                        <td class="hr">Team In Charge Notes</td>
                        <td class="dr"><?php echo stripslashes($row["cas_TeamInChargeNotes"]) ?></td>
                    </tr>
                    -->
                    <tr>
                        <td class="hr">Client Comments</td>
                        <td class="dr"><?php echo stripslashes($row["cas_ClientNotes"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Completion Date</td>
                        <td class="dr"><?php echo $commonUses->showGridDateFormat($row["cas_ClosedDate"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Status Completed by</td>
                        <td class="dr"><?php echo $commonUses->getFirstLastName($row["cas_StatusCompletedby"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Status Completed Date</td>
                        <td class="dr"><?php echo $commonUses->showGridDateFormat($row["cas_StatusCompletedon"]) ?></td>
                    </tr>
                </table>
                <br>
                <span class="footer2 frmheading" style='font-size:96%;'>Created by: <?php echo $commonUses->getFirstLastName($row["cas_Createdby"]) ?> | Created on: <?php echo $commonUses->showGridDateFormat($row["cas_Createdon"]); ?> | Lastmodified by: <?php echo $commonUses->getFirstLastName($row["cas_Lastmodifiedby"]) ?> | Lastmodified on: <?php echo  $commonUses->showGridDateFormat($row["cas_Lastmodifiedon"]); ?></span>
        <?php }
         function showroweditor($row, $iseditmode)
          {
            global $commonUses;
             ?>
                <!--
                <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="30%">
                <tr>
                        <td style="width: 80px; height:30px" class="tabsel" id="page1Tab">
                        <a ID="lnkPage1" onClick="switchTab('page1')" href="javascript:void(0)">Details</a></td>
                        <td style="width: 80px" class="tab" id="page2Tab">
                        <a ID="lnkPage2" OnClick="switchTab('page2')" href="javascript:void(0)" >Closure</a></td>
                 </tr>
                </table>
                -->
                <div id="page1">
                <table class="tbl" border="0" cellspacing="10" width="70%">
                    <tr>
                        <td class="hr">Ticket Number</td>
                        <td class="dr">
                            <?php  if(!$iseditmode) {
                                $sql = "SHOW TABLE STATUS LIKE 'cas_cases'";
                                $result = mysql_query($sql);
                                $row = mysql_fetch_array($result);
                                echo $next_id = $row['Auto_increment'];
                             } else {
                                echo $row["cas_Code"];
                             } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Type<font style="color:red;" size="2">*</font>
                        </td>
                        <td>
                            <select name="cas_Type" id="cas_Type">
                                <option value="0">Select Type</option>
                                <option value="1" <?php if($row["cas_Type"]=='1') echo "selected"; ?>>Request</option>
                                <option value="2" <?php if($row["cas_Type"]=='2') echo "selected"; ?>>Issue</option>
                                <option value="3" <?php if($row["cas_Type"]=='3') echo "selected"; ?>>Internal</option>
                            </select>
                            <input type="hidden" name="cas_Typeold" id="cas_Typeold" value="<?php echo $row["cas_Type"]; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Subject
                        </td>
                        <td class="dr">
                            <input type="text" name="cas_Title" id="cas_Title" maxlength="255" value="<?php echo stripslashes($row["cas_Title"]) ?>">
                            <input type="hidden" name="cas_Titleold" id="cas_Titleold" maxlength="255" value="<?php echo stripslashes($row["cas_Title"]) ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Client Company Name<font style="color:red;" size="2">*</font>
                        </td>
                        <td class="dr">
                        <?php
                        if($row["cas_ClientCode"]!="")
                        {
                           $sql = "select `client_id`, `client_name` from `client` where client_id=".$row["cas_ClientCode"]." ORDER BY client_name ASC";
                           $res = mysql_query($sql) or die(mysql_error());
                           $companyname=@mysql_result( $res,0,'client_name');
                        }
                        ?>
                        <div id="wrapper">
                                <small style="float:right">
									
								<input type="hidden" id="cas_ClientCode" name="cas_ClientCode" value="<?php echo $row["cas_ClientCode"];?>" style="font-size: 10px; width: 40px;"  /></small>
                                
								<input type="hidden" id="cas_ClientCode_old" name="cas_ClientCode_old" value="<?php echo $row["cas_ClientCode"];?>" style="font-size: 10px; width: 20px;"  />
                                <input type="hidden" id="cli_Code" name="cli_Code" value="">
                               
							    <input style="width: 200px" type="text" name="cas_ClientName" id="testinput" value="<?php echo $companyname; ?>"/>
                                <input type="hidden" name="compcode" id="compcode">
                                
								<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Start typing to view existing clients. On selecting client/company name, Contact, Billing Person, Australia Manager, Manager In Charge, Team In Charge, Staff In Charge and Sales Person will be populated automatically based on the Client record.</span></a>
                         </div>
						 
                        <script type="text/javascript">
                                var options = {
                                        script:"dbclass/cases_client_db_class.php?json=true&limit=6&",
                                        varname:"input",
                                        json:true,
                                        shownoresults:false,
                                        maxresults:6,
                                        callback: function (obj) {
                                            document.getElementById('cas_ClientCode').value = obj.id;
                                            document.getElementById('cli_Code').value = obj.info;
                                            showMember(document.getElementById('cli_Code').value);
                                        }
                                };
                                var as_json = new bsn.AutoSuggest('testinput', options);

                                var options_xml = {
                                        script: function (input) { return "dbclass/cases_client_db_class.php?input="+input+"&con_Company="+document.getElementById('cas_ClientCode').value; },
                                        varname:"input"
                                };
                                var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
                        </script>
                        </td>
                    </tr>
                  <!--  <tr>
                        <td class="hr">Contact
                        </td>
                        <td class="dr">
                        <div id="cas_ClientContact"></div>
                         <div id="cas_ClientContact_old" <?php if($iseditmode) { echo "style='display:block'"; } ?>>
                        <?php
                         echo $row["lp_cas_ClientContact"];
                        ?>
                        <input type="hidden" name="cas_ClientContact_old" value="<?php echo $row["cas_ClientContact"];?>">
                         </div>
                        </td>
                    </tr> -->
                    <tr>
                        <td class="hr">Contact
                        </td>
                        <td class="dr">
                        <div id="cas_ClientContact"></div>
                        <div id="selectContact"><?php echo $row["lp_cas_ClientContact"]; ?></div>
                        <input type="hidden" name="cas_ClientContact_old" value="<?php echo $row["cas_ClientContact"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Billing Person
                        </td>
                        <td>
                         <select name="cas_BillingPerson" id="cas_BillingPerson"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_BillingPerson"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_BillingPersonold" value="<?php echo $row["cas_BillingPerson"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Australia Manager<font style="color:red;" size="2">*</font>
                        </td>
                        <td>
                         <select name="cas_AustraliaManager" id="cas_AustraliaManager"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=18 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_AustraliaManager"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_AustraliaManagerold" value="<?php echo $row["cas_AustraliaManager"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Manager In Charge
                        </td>
                        <td>
                         <select name="cas_ManagerInChrge" id="cas_ManagerInChrge"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=17 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_ManagerInChrge"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_ManagerInChrgeold" value="<?php echo $row["cas_ManagerInChrge"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Senior In Charge
                        </td>
                        <td>
                         <select name="cas_SeniorInCharge" id="cas_SeniorInCharge"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_SeniorInCharge"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_SeniorInChargeold" value="<?php echo $row["cas_SeniorInCharge"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Team In Charge<font style="color:red;" size="2">*</font>
                        </td>
                        <td>
                         <select name="cas_TeamInCharge" id="cas_TeamInCharge"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_TeamInCharge"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_TeamInChargeold" value="<?php echo $row["cas_TeamInCharge"];?>">
                         </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Staff In Charge
                        </td>
                        <td>
                         <select name="cas_StaffInCharge" id="cas_StaffInCharge"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' AND c1.con_Firstname!='' ORDER BY c1.con_Firstname";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_StaffInCharge"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_StaffInChargeold" value="<?php echo $row["cas_StaffInCharge"];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Sales Person
                        </td>
                        <td>
                         <select name="cas_SalesPerson" id="cas_SalesPerson"><option value="0">Select User</option>
                            <?php
                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE (c1.con_Designation=14 || c1.con_Designation=19) AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                              $res = mysql_query($sql) or die(mysql_error());
                              while ($lp_row = mysql_fetch_assoc($res)){
                              $val = $lp_row["stf_Code"];
                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                              if(!$iseditmode)
                              {
                              if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                              }
                              if ($row["cas_SalesPerson"] == $val) {$selstr = " selected"; } else {$selstr = "";
                              }
                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                            <?php } ?>
                         </select>
                        <input type="hidden" name="cas_SalesPersonold" value="<?php echo $row["cas_SalesPerson"];?>">
                        </td>
                    </tr>

                    <tr>
                        <td class="hr">Master Activity<font style="color:red;" size="2">*</font></td>
                        <td>
                            <select name="cas_MasterActivity" id="cas_MasterActivity" onChange="getSubActivityTasks(this.value,-1)"><option value="0">Select Master Activity</option>
                                <?php
                                  $sql = "select `mas_Code`, `mas_Description`, Code from `mas_masteractivity` ORDER BY mas_Order ASC";
                                  $res = mysql_query($sql) or die(mysql_error());
                                  while ($lp_row = mysql_fetch_assoc($res)){
                                  $val = $lp_row["mas_Code"];
                                  $caption = $lp_row["mas_Description"];
                                $Code = $lp_row["Code"];
                                 if ($row["cas_MasterActivity"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                ?>
                                <option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $Code.($Code!=""? "-":"").$caption ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="cas_MasterActivityold" id="cas_MasterActivityold" value="<?php echo $row["cas_MasterActivity"] ?>">
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Master Activity of the Tickets. Related sub-activity is populated automatically based on the Master Activity selected.</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Sub Activity</td>
                        <td>
                        <div id="cas_SubActivity"></div>
                        <div id="cas_SubActivity_old">
                        <?php
                         if($row["cas_SubActivity"]!="")
                        {
                        echo $row["lp_cas_subCode"].($row["lp_cas_subCode"]!=""? "-":"").$row["lp_cas_SubActivity"];
                        ?>
                        <input type="hidden" name="cas_SubActivity_old" value="<?php echo $row["cas_SubActivity"]?>">
                        <?php
                        }
                        ?>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Priority<font style="color:red;" size="2">*</font>
                        </td>
                        <td>
                            <select name="cas_Priority" id="cas_Priority"><option value="0">Select Priority</option>
                                <?php
                                  $sql = "select `pri_Code`, `pri_Description` from `pri_priority` ORDER BY pri_Order ASC";
                                  $res = mysql_query($sql) or die(mysql_error());
                                  while ($lp_row = mysql_fetch_assoc($res)){
                                  $val = $lp_row["pri_Code"];
                                  $caption = $lp_row["pri_Description"];
                                  if ($row["cas_Priority"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="cas_Priorityold" id="cas_Priorityold" value="<?php echo $row["cas_Priority"] ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Status<font style="color:red;" size="2">*</font>
                        </td>
                        <td>
                            <select name="cas_Status" id="cas_Status" onChange="statusComplete(<?php echo $_SESSION['staffcode']?>,'<?php echo $_SESSION['usertype']?>','<?php echo $row["cas_Createdby"]?>','<?php echo $row["cas_Status"]?>')"><option value="0">Select Status</option>
                                <?php
                                  $sql = "select `cas_Code`, `cas_Description` from `cas_casestatus` ORDER BY cas_Order ASC";
                                  $res = mysql_query($sql) or die(mysql_error());
                                  while ($lp_row = mysql_fetch_assoc($res)){
                                  $val = $lp_row["cas_Code"];
                                  $caption = $lp_row["cas_Description"];
                                  if ($row["cas_Status"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                <?php } ?>
                            </select>
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Status of the Tickets. When Status <b>Completed</b> mail goes to Issuer of Ticket, Team In Charge, user who closed the ticket and Australia Manager.</span></a>
                        </td>
                    <input type="hidden" name="cas_Statusold" value="<?php echo $row['cas_Status']; ?>">
                    </tr>
                    <tr>
                        <td class="hr">Internal Due Date<font style="color:red;" size="2">*</font></td>
                        <td class="dr"><input type="text" name="cas_InternalDueDate" id="cas_InternalDueDate" value="<?php if ($row["cas_ExternalDueDate"]) {
                        if($row["cas_InternalDueDate"]!="0000-00-00") { $php_cas_InDueDate = strtotime( $row["cas_InternalDueDate"] );
                        echo date("d/m/Y",$php_cas_InDueDate); } else ""; } else { echo date("d/m/Y");} ?>">&nbsp;<a href="javascript:NewCal('cas_InternalDueDate','ddmmyyyy',false,24)"><img
                        src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                        <input type="hidden" name="cas_InternalDueDateold" value="<?php echo $row['cas_InternalDueDate']; ?>">
                    </tr>
                    <tr>
                        <td class="hr">External Due Date<font style="color:red;" size="2">*</font></td>
                        <td class="dr"><input type="text" name="cas_ExternalDueDate" id="cas_ExternalDueDate" value="<?php if ($row["cas_ExternalDueDate"]) {
                        if($row["cas_ExternalDueDate"]!="0000-00-00") { $php_cas_DueDate = strtotime( $row["cas_ExternalDueDate"] );
                        echo date("d/m/Y",$php_cas_DueDate); } else ""; } else { echo date("d/m/Y");} ?>">&nbsp;<a href="javascript:NewCal('cas_ExternalDueDate','ddmmyyyy',false,24)"><img
                        src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                        <input type="hidden" name="cas_ExternalDueDateold" value="<?php echo $row['cas_ExternalDueDate']; ?>">
                    </tr>
                    <tr>
                        <td class="hr">Due Time</td>
                        <td>
                        <?php
                        if($iseditmode)
                        {
                        $cas_DueTime=explode(":",$row["cas_DueTime"]);
                        }
                        $cas_seconds=$cas_DueTime[2];
                        $cas_minutes=$cas_DueTime[1];
                        $cas_hours=$cas_DueTime[0];
                        ?>
                        <select name="hour" id="hour"><option value="0">Select Hour</option>
                            <option value="00" <?php if ($cas_hours=="00") echo "selected";?>>00</option>
                            <option value="01" <?php if ($cas_hours=="01") echo "selected";?>>01</option>
                            <option value="02" <?php if ($cas_hours=="02") echo "selected";?>>02</option>
                            <option value="03" <?php if ($cas_hours=="03") echo "selected";?>>03</option>
                            <option value="04" <?php if ($cas_hours=="04") echo "selected";?>>04</option>
                            <option value="05" <?php if ($cas_hours=="05") echo "selected";?>>05</option>
                            <option value="06" <?php if ($cas_hours=="06") echo "selected";?>>06</option>
                            <option value="07" <?php if ($cas_hours=="07") echo "selected";?>>07</option>
                            <option value="08" <?php if ($cas_hours=="08") echo "selected";?>>08</option>
                            <option value="09" <?php if ($cas_hours=="09") echo "selected";?>>09</option>
                            <option value="10" <?php if ($cas_hours=="10") echo "selected";?>>10</option>
                            <option value="11" <?php if ($cas_hours=="11") echo "selected";?>>11</option>
                            <option value="12" <?php if ($cas_hours=="12") echo "selected";?>>12</option>
                            <option value="13" <?php if ($cas_hours=="13") echo "selected";?>>13</option>
                            <option value="14" <?php if ($cas_hours=="14") echo "selected";?>>14</option>
                            <option value="15" <?php if ($cas_hours=="15") echo "selected";?>>15</option>
                            <option value="16" <?php if ($cas_hours=="16") echo "selected";?>>16</option>
                            <option value="17" <?php if ($cas_hours=="17") echo "selected";?>>17</option>
                            <option value="18" <?php if ($cas_hours=="18") echo "selected";?>>18</option>
                            <option value="19" <?php if ($cas_hours=="19") echo "selected";?>>19</option>
                            <option value="20" <?php if ($cas_hours=="20") echo "selected";?>>20</option>
                            <option value="21" <?php if ($cas_hours=="21") echo "selected";?>>21</option>
                            <option value="22" <?php if ($cas_hours=="22") echo "selected";?>>22</option>
                            <option value="23" <?php if ($cas_hours=="23") echo "selected";?>>23</option>
                        </select>&nbsp;&nbsp;
                        <input type="hidden" name="duetimeold" value="<?php echo $row['cas_DueTime']; ?>">
                        <select name="minute" id="minute"><option value="0">Select Minute</option>
                            <option value="00" <?php if ($cas_minutes=="00") echo "selected";?>>00</option>
                            <option value="01" <?php if ($cas_minutes=="01") echo "selected";?>>01</option>
                            <option value="02" <?php if ($cas_minutes=="02") echo "selected";?>>02</option>
                            <option value="03" <?php if ($cas_minutes=="03") echo "selected";?>>03</option>
                            <option value="04" <?php if ($cas_minutes=="04") echo "selected";?>>04</option>
                            <option value="05" <?php if ($cas_minutes=="05") echo "selected";?>>05</option>
                            <option value="06" <?php if ($cas_minutes=="06") echo "selected";?>>06</option>
                            <option value="07" <?php if ($cas_minutes=="07") echo "selected";?>>07</option>
                            <option value="08" <?php if ($cas_minutes=="08") echo "selected";?>>08</option>
                            <option value="09" <?php if ($cas_minutes=="09") echo "selected";?>>09</option>
                            <option value="10" <?php if ($cas_minutes=="10") echo "selected";?>>10</option>
                            <option value="11" <?php if ($cas_minutes=="11") echo "selected";?>>11</option>
                            <option value="12" <?php if ($cas_minutes=="12") echo "selected";?>>12</option>
                            <option value="13" <?php if ($cas_minutes=="13") echo "selected";?>>13</option>
                            <option value="14" <?php if ($cas_minutes=="14") echo "selected";?>>14</option>
                            <option value="15" <?php if ($cas_minutes=="15") echo "selected";?>>15</option>
                            <option value="16" <?php if ($cas_minutes=="16") echo "selected";?>>16</option>
                            <option value="17" <?php if ($cas_minutes=="17") echo "selected";?>>17</option>
                            <option value="18" <?php if ($cas_minutes=="18") echo "selected";?>>18</option>
                            <option value="19" <?php if ($cas_minutes=="19") echo "selected";?>>19</option>
                            <option value="20" <?php if ($cas_minutes=="20") echo "selected";?>>20</option>
                            <option value="21" <?php if ($cas_minutes=="21") echo "selected";?>>21</option>
                            <option value="22" <?php if ($cas_minutes=="22") echo "selected";?>>22</option>
                            <option value="23" <?php if ($cas_minutes=="23") echo "selected";?>>23</option>
                            <option value="24" <?php if ($cas_minutes=="24") echo "selected";?>>24</option>
                            <option value="25" <?php if ($cas_minutes=="25") echo "selected";?>>25</option>
                            <option value="26" <?php if ($cas_minutes=="26") echo "selected";?>>26</option>
                            <option value="27" <?php if ($cas_minutes=="27") echo "selected";?>>27</option>
                            <option value="28" <?php if ($cas_minutes=="28") echo "selected";?>>28</option>
                            <option value="29" <?php if ($cas_minutes=="29") echo "selected";?>>29</option>
                            <option value="30" <?php if ($cas_minutes=="30") echo "selected";?>>30</option>
                            <option value="31" <?php if ($cas_minutes=="31") echo "selected";?>>31</option>
                            <option value="32" <?php if ($cas_minutes=="32") echo "selected";?>>32</option>
                            <option value="33" <?php if ($cas_minutes=="33") echo "selected";?>>33</option>
                            <option value="34" <?php if ($cas_minutes=="34") echo "selected";?>>34</option>
                            <option value="35" <?php if ($cas_minutes=="35") echo "selected";?>>35</option>
                            <option value="36" <?php if ($cas_minutes=="36") echo "selected";?>>36</option>
                            <option value="37" <?php if ($cas_minutes=="37") echo "selected";?>>37</option>
                            <option value="38" <?php if ($cas_minutes=="38") echo "selected";?>>38</option>
                            <option value="39" <?php if ($cas_minutes=="39") echo "selected";?>>39</option>
                            <option value="40" <?php if ($cas_minutes=="40") echo "selected";?>>40</option>
                            <option value="41" <?php if ($cas_minutes=="41") echo "selected";?>>41</option>
                            <option value="42" <?php if ($cas_minutes=="42") echo "selected";?>>42</option>
                            <option value="43" <?php if ($cas_minutes=="43") echo "selected";?>>43</option>
                            <option value="44" <?php if ($cas_minutes=="44") echo "selected";?>>44</option>
                            <option value="45" <?php if ($cas_minutes=="45") echo "selected";?>>45</option>
                            <option value="46" <?php if ($cas_minutes=="46") echo "selected";?>>46</option>
                            <option value="47" <?php if ($cas_minutes=="47") echo "selected";?>>47</option>
                            <option value="48" <?php if ($cas_minutes=="48") echo "selected";?>>48</option>
                            <option value="49" <?php if ($cas_minutes=="49") echo "selected";?>>49</option>
                            <option value="50" <?php if ($cas_minutes=="50") echo "selected";?>>50</option>
                            <option value="51" <?php if ($cas_minutes=="51") echo "selected";?>>51</option>
                            <option value="52" <?php if ($cas_minutes=="52") echo "selected";?>>52</option>
                            <option value="53" <?php if ($cas_minutes=="53") echo "selected";?>>53</option>
                            <option value="54" <?php if ($cas_minutes=="54") echo "selected";?>>54</option>
                            <option value="55" <?php if ($cas_minutes=="55") echo "selected";?>>55</option>
                            <option value="56" <?php if ($cas_minutes=="56") echo "selected";?>>56</option>
                            <option value="57" <?php if ($cas_minutes=="57") echo "selected";?>>57</option>
                            <option value="58" <?php if ($cas_minutes=="58") echo "selected";?>>58</option>
                            <option value="59" <?php if ($cas_minutes=="59") echo "selected";?>>59</option>
                        </select>&nbsp;&nbsp;
                        <select name="second" id="second"><option value="0">Select Second</option>
                            <option value="00" <?php if ($cas_seconds=="00") echo "selected";?>>00</option>
                            <option value="01" <?php if ($cas_seconds=="01") echo "selected";?>>01</option>
                            <option value="02" <?php if ($cas_seconds=="02") echo "selected";?>>02</option>
                            <option value="03" <?php if ($cas_seconds=="03") echo "selected";?>>03</option>
                            <option value="04" <?php if ($cas_seconds=="04") echo "selected";?>>04</option>
                            <option value="05" <?php if ($cas_seconds=="05") echo "selected";?>>05</option>
                            <option value="06" <?php if ($cas_seconds=="06") echo "selected";?>>06</option>
                            <option value="07" <?php if ($cas_seconds=="07") echo "selected";?>>07</option>
                            <option value="08" <?php if ($cas_seconds=="08") echo "selected";?>>08</option>
                            <option value="09" <?php if ($cas_seconds=="09") echo "selected";?>>09</option>
                            <option value="10" <?php if ($cas_seconds=="10") echo "selected";?>>10</option>
                            <option value="11" <?php if ($cas_seconds=="11") echo "selected";?>>11</option>
                            <option value="12" <?php if ($cas_seconds=="12") echo "selected";?>>12</option>
                            <option value="13" <?php if ($cas_seconds=="13") echo "selected";?>>13</option>
                            <option value="14" <?php if ($cas_seconds=="14") echo "selected";?>>14</option>
                            <option value="15" <?php if ($cas_seconds=="15") echo "selected";?>>15</option>
                            <option value="16" <?php if ($cas_seconds=="16") echo "selected";?>>16</option>
                            <option value="17" <?php if ($cas_seconds=="17") echo "selected";?>>17</option>
                            <option value="18" <?php if ($cas_seconds=="18") echo "selected";?>>18</option>
                            <option value="19" <?php if ($cas_seconds=="19") echo "selected";?>>19</option>
                            <option value="20" <?php if ($cas_seconds=="20") echo "selected";?>>20</option>
                            <option value="21" <?php if ($cas_seconds=="21") echo "selected";?>>21</option>
                            <option value="22" <?php if ($cas_seconds=="22") echo "selected";?>>22</option>
                            <option value="23" <?php if ($cas_seconds=="23") echo "selected";?>>23</option>
                            <option value="24" <?php if ($cas_seconds=="24") echo "selected";?>>24</option>
                            <option value="25" <?php if ($cas_seconds=="25") echo "selected";?>>25</option>
                            <option value="26" <?php if ($cas_seconds=="26") echo "selected";?>>26</option>
                            <option value="27" <?php if ($cas_seconds=="27") echo "selected";?>>27</option>
                            <option value="28" <?php if ($cas_seconds=="28") echo "selected";?>>28</option>
                            <option value="29" <?php if ($cas_seconds=="29") echo "selected";?>>29</option>
                            <option value="30" <?php if ($cas_seconds=="30") echo "selected";?>>30</option>
                            <option value="31" <?php if ($cas_seconds=="31") echo "selected";?>>31</option>
                            <option value="32" <?php if ($cas_seconds=="32") echo "selected";?>>32</option>
                            <option value="33" <?php if ($cas_seconds=="33") echo "selected";?>>33</option>
                            <option value="34" <?php if ($cas_seconds=="34") echo "selected";?>>34</option>
                            <option value="35" <?php if ($cas_seconds=="35") echo "selected";?>>35</option>
                            <option value="36" <?php if ($cas_seconds=="36") echo "selected";?>>36</option>
                            <option value="37" <?php if ($cas_seconds=="37") echo "selected";?>>37</option>
                            <option value="38" <?php if ($cas_seconds=="38") echo "selected";?>>38</option>
                            <option value="39" <?php if ($cas_seconds=="39") echo "selected";?>>39</option>
                            <option value="40" <?php if ($cas_seconds=="40") echo "selected";?>>40</option>
                            <option value="41" <?php if ($cas_seconds=="41") echo "selected";?>>41</option>
                            <option value="42" <?php if ($cas_seconds=="42") echo "selected";?>>42</option>
                            <option value="43" <?php if ($cas_seconds=="43") echo "selected";?>>43</option>
                            <option value="44" <?php if ($cas_seconds=="44") echo "selected";?>>44</option>
                            <option value="45" <?php if ($cas_seconds=="45") echo "selected";?>>45</option>
                            <option value="46" <?php if ($cas_seconds=="46") echo "selected";?>>46</option>
                            <option value="47" <?php if ($cas_seconds=="47") echo "selected";?>>47</option>
                            <option value="48" <?php if ($cas_seconds=="48") echo "selected";?>>48</option>
                            <option value="49" <?php if ($cas_seconds=="49") echo "selected";?>>49</option>
                            <option value="50" <?php if ($cas_seconds=="50") echo "selected";?>>50</option>
                            <option value="51" <?php if ($cas_seconds=="51") echo "selected";?>>51</option>
                            <option value="52" <?php if ($cas_seconds=="52") echo "selected";?>>52</option>
                            <option value="53" <?php if ($cas_seconds=="53") echo "selected";?>>53</option>
                            <option value="54" <?php if ($cas_seconds=="54") echo "selected";?>>54</option>
                            <option value="55" <?php if ($cas_seconds=="55") echo "selected";?>>55</option>
                            <option value="56" <?php if ($cas_seconds=="56") echo "selected";?>>56</option>
                            <option value="57" <?php if ($cas_seconds=="57") echo "selected";?>>57</option>
                            <option value="58" <?php if ($cas_seconds=="58") echo "selected";?>>58</option>
                            <option value="59" <?php if ($cas_seconds=="59") echo "selected";?>>59</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Issue Details<font style="color:red;" size="2">*</font>
                        </td>
                        <td class="dr"><textarea cols="35" rows="4" name="cas_IssueDetails" id="cas_IssueDetails" ><?php echo stripslashes($row["cas_IssueDetails"]) ?></textarea>
                        <input type="hidden" name="cas_IssueDetailsold" value="<?php echo $row['cas_IssueDetails']; ?>">
                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Details of the issue.</span></a>
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td class="hr">Super Records Comments</td>
                        <td class="dr"><textarea cols="35" rows="4" name="cas_Notes" id="cas_Notes" maxlength="200"><?php echo stripslashes($row["cas_Notes"]) ?></textarea>
                        <input type="hidden" name="cas_Notesold" value="<?php echo $row['cas_Notes']; ?>">
                        </td>
                    </tr>
                    -->
                    <tr>
                        <td class="hr">Explain Why this has occurred<font id="explain_field" style="color:red; display: none;" size="2">*</font>
                        </td>
                        <td class="dr"><textarea cols="35" rows="4" name="cas_Issue_Occurred" id="cas_Issue_Occurred" ><?php echo stripslashes($row["cas_Issue_Occurred"]) ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Action Required<font id="action_field" style="color:red; display: none;" size="2">*</font></td>
                        <td>
                            <table class="fieldtable" cellpadding="3">
                                <tr class="fieldheader">
                                    <th style="padding-left:10px;padding-right:10px">Action Details</th>
                                    <th style="padding-left:10px;padding-right:10px">Assigned Staff</th>
                                </tr>
                                <?php
                                        $act_query = mysql_query("select * from cas_actionrequired where cas_Code=".$_GET['cid']." order by id");
                                        $total_action_row = @mysql_num_rows($act_query);
                                        if($total_action_row>0) {
                                        $i=1;
                                        while($act_row = mysql_fetch_array($act_query)) {
                                           ?>
                                            <tr>
                                                <td><textarea name="cas_ActionDetails[]" id="cas_ActionDetails"><?php echo $act_row['cas_ActionDetails']; ?></textarea></td>
                                                <td>
                                                     <select name="cas_Staff[]" id="cas_Staff"><option value="0">Select User</option>
                                                        <?php
                                                          $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                                          $res = mysql_query($sql) or die(mysql_error());
                                                          while ($lp_row = mysql_fetch_assoc($res)){
                                                          $val = $lp_row["stf_Code"];
                                                          $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                                                          if ($act_row["cas_Staff"] == $val) {$selstr = " selected"; } else {$selstr = "";
                                                          }
                                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                                                        <?php } ?>
                                                     </select>
                                                </td>
                                            </tr>
                                <?php
                                $i++;
                                        }
                                    }
                                    else {
                                    for($i=1;$i<5;$i++) { 
                                 ?>
                                <tr>
                                    <td><textarea name="cas_ActionDetails[]" id="cas_ActionDetails"></textarea></td>
                                    <td>
                                         <select name="cas_Staff[]" id="cas_Staff"><option value="0">Select User</option>
                                            <?php
                                              $sql = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                                              $res = mysql_query($sql) or die(mysql_error());
                                              while ($lp_row = mysql_fetch_assoc($res)){
                                              $val = $lp_row["stf_Code"];
                                              $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                                             /* if ($row["cas_SalesPerson"] == $val) {$selstr = " selected"; } else {$selstr = "";
                                              } */
                                             ?><option value="<?php echo $val ?>"><?php echo $caption ?></option>
                                            <?php } ?>
                                         </select>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Resolution
                        </td>
                        <td class="dr"><textarea cols="35" rows="4" name="cas_Resolution" id="cas_Resolution" ><?php echo stripslashes($row["cas_Resolution"]) ?></textarea>
                        <input type="hidden" name="cas_Resolutionold" value="<?php echo $row['cas_Resolution']; ?>">
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <td class="hr">Team In Charge Notes</td>
                        <td class="dr"><textarea cols="35" rows="4" name="cas_TeamInChargeNotes" id="cas_TeamInChargeNotes" maxlength="200"><?php echo stripslashes($row["cas_TeamInChargeNotes"]) ?></textarea>
                        <input type="hidden" name="cas_TeamInChargeNotesold" value="<?php echo $row['cas_TeamInChargeNotes']; ?>">
                        </td>
                    </tr>
                    -->
                    <?php if($iseditmode) { ?>
                    <tr>
                        <td class="hr">Client Comments
                        </td>
                        <td class="dr"><?php echo stripslashes($row["cas_ClientNotes"]) ?></td>
                    <td><input type="hidden" name="cas_ClientNotes" id="cas_ClientNotes" value="<?php echo stripslashes($row["cas_ClientNotes"]) ?>" ></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="hr">Completion Date<?php if($row['cas_Status']=="3") $display = "display:inline"; else $display = "display:none"; ?><font style="color:red; <?php echo $display; ?>; " id="closeDatestyle" size="2">*</font></td>
                        <td class="dr"><input type="text" name="cas_ClosedDate" id="cas_ClosedDate" value="<?php if (isset($row["cas_ClosedDate"]) && $row["cas_ClosedDate"]!="" && $row["cas_ClosedDate"]!='0000-00-00') {
                        $php_cas_ClosedDate = strtotime( $row["cas_ClosedDate"] );
                        echo date("d/m/Y",$php_cas_ClosedDate); }  ?>">&nbsp;<a href="javascript:NewCal('cas_ClosedDate','ddmmyyyy',false,24)"><img
                        src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                        <td><input type="hidden" name="cas_ClosedDateold" value="<?php echo $row['cas_ClosedDate']; ?>"></td>
                    </tr>
                    <input type="hidden" name="hisContent" id="hisContent">
                </table>
                </div>
        <?php }
        function showpagenav($page, $pagecount)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a href="cas_cases.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="cas_cases.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="cas_cases.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="cas_cases.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }
        function showrecnav($a, $recid, $count)
        {
        ?>
                <!--
            <table border="0" cellspacing="1" cellpadding="4" align="right">
                <tr>
                     <?php if ($recid > 0) { ?>
                    <td><a href="cas_cases.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                    <?php } if ($recid < $count - 1) { ?>
                    <td><a href="cas_cases.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
                    <?php } ?>
                </tr>
            </table>
                -->
            
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
            <?php echo $title?> Tickets 
            </span>
            <div class="frmheading">
				<h1></h1>
			</div>
        <?php }
        function addrec()
        {
          ?><div class="frmheading">
				<h1>Add Record</h1>
			</div>
            <div style="position:absolute; top:20; right:-90px; width:300; height:300;">
				<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
			</div>
            <form enctype="multipart/form-data" action="cas_cases.php?a=reset" method="post" name="cases" id="cases" onSubmit="return validateFormOnSubmit()">
            <p><input type="hidden" name="sql" value="insert"></p>
            <?php
            $row = array(
              "cas_Code" => "",
              "cas_ClientCode" => "",
              "cas_ClientContact" => "",
              "cas_MasterActivity" => "",
              "cas_SubActivity" => "",
              "cas_Priority" => "",
              "cas_Status" => "",
              "cas_TeamInCharge" => "",
              "cas_StaffInCharge" => "",
              "cas_ManagerInChrge" => "",
              "cas_SeniorInCharge" => "",  
              "cas_ExternalDueDate" => "",
              "cas_DueTime" => "",
              "cas_ClosedDate" => "",
              "cas_ClosureReason" => "",
              "cas_HoursSpentDecimal" => "",
              "cas_Details" => "",
              "cas_Resolution" => "",
              "cas_Notes" => "",
              "cas_TeamInChargeNotes" => "",
              "cas_Title" => "",
              "cas_Createdby" => "",
              "cas_Createdon" => "",
              "cas_Lastmodifiedby" => "",
              "cas_Lastmodifiedon" => "");
                $this->showroweditor($row, false);
            ?>
            <button style="margin-right:32px;" type="button" value="Cancel" onClick='javascript:history.back(-1);' class="cancelbutton">Cancel</button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="submit" name="action" value="Save" class="button">Save</button>
            </form>
        <?php }
        function viewrec($recid,$access_file_level)
        {
            global $casesDbcontent;
            $res = $casesDbcontent->sql_select();
             // $count = sql_getrecordcount();
              $count = mysql_num_rows($res);
              mysql_data_seek($res, $recid);
              $row = mysql_fetch_assoc($res);
              $this->showrecnav("view", $recid, $count);
              // history
           $hisquery = "SELECT cas_Lastmodifiedby,cas_Lastmodifiedon FROM cas_caseshistory WHERE cas_CCode=".$_GET['cid']." ORDER BY cas_Lastmodifiedon";
           $result = mysql_query($hisquery);
           $history = @mysql_fetch_array($result);
           $query = "SELECT CONCAT(c1.con_FirstName,' ',c1.con_LastName) AS cas_username FROM stf_staff s1 LEFT OUTER JOIN con_contact AS c1 ON (s1.stf_CCode = c1.con_Code) WHERE stf_Login='".$history['cas_Lastmodifiedby']."'";
           $result = mysql_query($query);
           $username = @mysql_fetch_array($result);

            ?>
            <div class="right_clientname" style="position:relative; top:-36px;">
				<?php echo stripslashes($row["lp_cas_ClientCode"]); ?>
			</div>
            <?php $this->showrow($row, $recid) ?>
            <br>
            <div class="frmheading">
				<h1></h1>
			</div>
            <table class="bd" border="0" cellspacing="1" cellpadding="4">
            <tr>
            <?php
              if($access_file_level['stf_Add']=="Y")
              {
            ?>
            <td><a href="cas_cases.php?a=add" class="hlight">Add Record</a></td>
            <?php }
              if($access_file_level['stf_Edit']=="Y")
              {
            ?>
           <td><a href="cas_cases.php?a=edit&recid=<?php echo $recid ?>&cid=<?php echo $_GET['cid'] ?>" class="hlight">Edit  Record</a></td><?php } ?>
            <?php
              if($access_file_level['stf_Delete']=="Y")
              {
            ?>

            <td><a onClick="performdelete('cas_cases.php?mode=delete&recid=<?php echo stripslashes($row["cas_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
            <?php }?>
            </tr>
            </table>
        <?php
          $this->historyContent();
          mysql_free_result($res);
        }
        function editrec($recid)
        {
           global $casesDbcontent;
           $res = $casesDbcontent->sql_select();
           //$count = sql_getrecordcount();
            $count = mysql_num_rows($res);
           mysql_data_seek($res, $recid);
           $row = mysql_fetch_assoc($res);
           $this->showrecnav("edit", $recid, $count);
           //history
           $hisquery = "SELECT cas_Lastmodifiedby,cas_Lastmodifiedon FROM cas_caseshistory WHERE cas_CCode=".$_GET['cid']." ORDER BY cas_Lastmodifiedon";
           $result = mysql_query($hisquery);
           $history = @mysql_fetch_array($result);
           $query = "SELECT CONCAT(c1.con_FirstName,' ',c1.con_LastName) AS cas_username FROM stf_staff s1 LEFT OUTER JOIN con_contact AS c1 ON (s1.stf_CCode = c1.con_Code) WHERE stf_Login='".$history['cas_Lastmodifiedby']."'";
           $result = mysql_query($query);
           $username = @mysql_fetch_array($result);
           // form actions
           if($_GET['b']!="") $action = "cas_cases.php?a=".$_GET['a']."&cid=".$_GET['cid']."&b=".$_GET['b'];
           else $action = "cas_cases.php?a=".$_GET['a']."&recid=".$_GET['recid']."&cid=".$_GET['cid'];
        ?>
        <div class="right_clientname" style="position:relative; top:-36px;"><?php echo stripslashes($row["lp_cas_ClientCode"]); ?></div>
        <div style="position:absolute; top:45; right:-90px; width:300; height:300;">
        <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
		
        <form enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="cases" id="cases" onSubmit="return validateFormOnSubmit()">
            <input type="hidden" name="sql" value="update">
            <input type="hidden" name="xcas_Code" value="<?php echo $row["cas_Code"] ?>">
            <?php $this->showroweditor($row, true); ?>
			<button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="submit" name="action" value="Update" class="button">Update</button>
			</form>
        
		<br>
        <?php
            $this->historyContent();
          mysql_free_result($res);
        }
        function historyContent()
        {
                  global $showrecs;
                  global $page;
                  global $casesDbcontent;
                  global $commonUses;

                  $showrecs = 10;
                  $pagerange = 10;
                  $res = $casesDbcontent->historySelect();
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
                  if($count>0) {
                  ?>
                
				<div style="margin-left:4px;margin-top:65px;" class="frmheading">History of Ticket</div>
				<div class="frmheading">
					<h1></h1>
				</div>
                <table align="center">
                        <tr>
                            <td>
                                <?php $this->historyPagenav($page, $pagecount); ?>
                            </td>
                        </tr>
                            <tr>
                            <td>
                                    <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" >
                                        <tr class="fieldheader" style="text-align:center;">
                                            <th class="fieldheader" style="padding-left:10px;padding-right:10px;">Last Modify</th>
                                            <th class="fieldheader" style="padding-left:10px;padding-right:10px;">Last Modify Date</th>
                                            <th class="fieldheader">Modify Details</th>
                                        </tr>
                                    <?php
                                       for ($i = $startrec; $i < $reccount; $i++)
                                      {
                                        $row = mysql_fetch_assoc($res);
                                     ?>
                                        <tr>
                                            <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["cas_Lastmodifiedby"]) ?></td>
                                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["cas_Lastmodifiedon"]) ?></td>
                                            <td class="<?php echo $style ?>">
                                                <div style='width:400px; height:100px; overflow:auto; margin-left: 30px;'>
                                                    <?php
                                                        $hrycont = explode('~', $row["cas_Description"]);
                                                        for($j=0; $j<=count($hrycont); $j++)
                                                        {
                                                            echo $hrycont[$j]."<br>";
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                      }
                                        mysql_free_result($res);
                                    ?>
                                    </table>
                            </td>
                        </tr>
                </table>
        <?php
        }
        }
        function historyPagenav($page, $pagecount)
        {
        ?>
            <table  border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a href="cas_cases.php?a=<?php echo $_GET['a'] ?>&recid=<?php echo $_GET['recid'] ?>&cid=<?php echo $_GET['cid'] ?>&page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="cas_cases.php?a=<?php echo $_GET['a'] ?>&recid=<?php echo $_GET['recid'] ?>&cid=<?php echo $_GET['cid'] ?>&page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="cas_cases.php?a=<?php echo $_GET['a'] ?>&recid=<?php echo $_GET['recid'] ?>&cid=<?php echo $_GET['cid'] ?>&page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="cas_cases.php?a=<?php echo $_GET['a'] ?>&recid=<?php echo $_GET['recid'] ?>&cid=<?php echo $_GET['cid'] ?>&page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }

    }
	$casesContent = new casesContentList();

?>

