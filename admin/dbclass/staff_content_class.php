<?php
class staffContentList extends Database
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
			global $staffQuery;
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
			if ($ordtype == "asc") { 
				$ordtypestr = "desc"; 
			} 
			else { 
				$ordtypestr = "asc"; 
			}
			$res = $staffQuery->sql_select();
			$count = mysql_num_rows($res);

			if ($count % $showrecs != 0) {
				$pagecount = intval($count / $showrecs) + 1;
			}
			else {
				$pagecount = intval($count / $showrecs);
			}
			$startrec = $showrecs * ($page - 1);
			if ($startrec < $count) {
				mysql_data_seek($res, $startrec);
			}
			$reccount = min($showrecs * $page, $count);

			?><div class="frmheading">
				<h1>Users</h1>
			</div>
			<form action="stf_staff.php" method="post">
				<table class="customFilter" align="right" style="margin-right:15px;" border="0" cellspacing="1" cellpadding="4">
					<tr>
						<td><b>Custom Filter</b>&nbsp;</td>
						<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
						<td>
							<select name="filter_field">
							<option value="">All Fields</option>
							<option value="<?php echo "lp_stf_CCode" ?>"<?php if ($filterfield == "lp_stf_CCode") { echo "selected"; } ?>>Contact Name</option>
							<option value="<?php echo "lp_stf_AccessType" ?>"<?php if ($filterfield == "lp_stf_AccessType") { echo "selected"; } ?>>Access Type</option>
							<option value="<?php echo "dsg_Description" ?>"<?php if ($filterfield == "dsg_Description") { echo "selected"; } ?>>Designation</option>
							<!--
							<option value="<?php echo "stf_Login" ?>"<?php if ($filterfield == "stf_Login") { echo "selected"; } ?>>Login</option>
							<option value="<?php echo "stf_Password" ?>"<?php if ($filterfield == "stf_Password") { echo "selected"; } ?>>Password</option>
							-->
							</select>
						</td>
						<td><input class="checkboxClass" type="checkbox" name="wholeonly"<?=$checkstr?>>Whole words only</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
						<td><a href="stf_staff.php?a=reset" class="hlight">Reset Filter</a></td>
						</tr>
				</table>
			</form>
			<p>&nbsp;</p>
			<br><br><?

			if($access_file_level['stf_Add']=="Y") {
				?><a href="stf_staff.php?a=add" class="hlight">
				<img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a><?php
			}

			$this->showpagenav($page, $pagecount);
			?><br><br>

			<table class="fieldtable" align="center" width="100%" border="0" cellspacing="1" cellpadding="5" >
				<tr class="fieldheader">
					<th align="left" class="fieldheader"><a href="stf_staff.php?order=<?php echo "lp_stf_CCode" ?>&type=<?php echo $ordtypestr ?>">Contact Name</a></th>
					<th align="left" class="fieldheader"><a  href="stf_staff.php?order=<?php echo "lp_stf_AccessType" ?>&type=<?php echo $ordtypestr ?>">AccessType</a></th>
					<th align="left" class="fieldheader"><a  href="stf_staff.php?order=<?php echo "dsg_Description" ?>&type=<?php echo $ordtypestr ?>">Designation</a></th>
					<th width="12%" class="fieldheader" colspan="3" align="center">Actions</th>
				</tr><?

				$countRow = 0;
				for ($i = $startrec; $i < $reccount; $i++) {
					$row = mysql_fetch_assoc($res);

					if($countRow%2 == 0) $trClass = "trcolor";
					else $trClass = "";

					?><tr class="<?=$trClass?>">
						<td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["stf_Code"]) ?></td>
						<td class="<?php echo $style ?>"><?php if ($row["lp_stf_AccessType"]=="Staff") echo "User"; else echo htmlspecialchars($row["lp_stf_AccessType"]) ?></td>
						<td class="<?php echo $style ?>"><?=$row["dsg_Description"]?></td><?
						if($access_file_level['stf_View']=="Y")
						{
							?><td align="center"><a href="stf_staff.php?a=view&recid=<?php echo $i ?>"><img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a></td><?
						}

						if($access_file_level['stf_Edit']=="Y")
						{
							?><td align="center"><a href="stf_staff.php?a=edit&recid=<?php echo $i ?>"><img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
							</td><?
						} 

						if($access_file_level['stf_Delete']=="Y")
						{
							?><td align="center"><a onClick="performdelete('stf_staff.php?mode=delete&recid=<?php echo htmlspecialchars($row["stf_Code"]) ?>'); return false;" href="#"><img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
							</td><? 
						} 
					?></tr><?
					$countRow++;
				}
				mysql_free_result($res);
				?>
			</table>
			<br><?
		}

		function showrow($row, $recid)
		{
			global $commonUses;

			?><table align="center" border="0" cellspacing="10" cellpadding="5" width="50%">
				 <tr>
					<td class="hr">Contact Name</td>
					<td class="dr"><?php echo $commonUses->getFirstLastName($row["stf_Code"]) ?></td>
				</tr>
				<tr>
					<td class="hr">AccessType</td>
					<td class="dr"><?php if ($row["lp_stf_AccessType"]=="Staff") echo "User"; else echo htmlspecialchars($row["lp_stf_AccessType"]) ?></td>
				</tr>
				<tr>
					<td class="hr">Login</td>
					<td class="dr"><?php echo htmlspecialchars($row["stf_Login"]) ?></td>
				</tr>
				<tr>
					<td class="hr">Password</td>
					<td class="dr"><?php echo htmlspecialchars($row["stf_Password"]) ?></td>
				</tr>
				<tr>
					<td class="hr">Disabled</td>
					<td class="dr"><?php echo htmlspecialchars($row["stf_Disabled"]) ?></td>
				</tr>
				<!--<tr>
					<td class="hr">Can view all data</td>
					<td class="dr"><?php echo htmlspecialchars($row["stf_Viewall"]) ?></td>
				</tr>
				<tr>
					<td class="hr">Document Upload / Download</td>
					<td class="dr"><?php echo htmlspecialchars($row["stf_Upload"]) ?></td>
				</tr>
				<tr>
					<td class="hr">Client login & Status update</td>
					<td class="dr"><?php echo htmlspecialchars($row["stf_LoginStatus"]) ?></td>
				</tr>-->
			</table>
			<br><?

			if ($row["stf_AccessType"] == 2) {
				$hideSection = "style='display:none'"; 
			}

			?><table border="0" cellspacing="0" <?=$hideSection?> cellpadding="0" id="permissionSection" align="center" class="fieldtable">
				<tr class="fieldheader">
					<td width="300" rowspan="2" align="center" > <b style="color:#F05729;">Forms to be shown</b></span>
					<td colspan="4" class="helpBod"><div align="center"><b>View Permissions </b></div></td>
				</tr>
				<tr class="fieldheader">
					<th class="fieldheader" align="center"><b>View</b></th>
					<th class="fieldheader" align="center"><b>Add</b></th>
					<th class="fieldheader" align="center"><b>Edit</b></th>
					<th class="fieldheader" align="center"><b>Delete</b></th>
				</tr><?

				$i=0;
				//show permission settings
				$permquery = "SELECT a. *,b.* 
							FROM stf_staffforms a,frm_forms b  
							WHERE a.stf_SCode =".$row['stf_Code']. " 
							AND b.frm_Code = a.stf_FormCode 
							ORDER BY b.frm_Order ";
				$permres = mysql_query($permquery);

				while ($row_perm=mysql_fetch_array($permres)) {

					if($i==0)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Lead</div></i></b></td></tr>";
					if($i==6)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Referrer Partner</div></i></b></td></tr>";
					if($i==10)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Practice</div></i></b></td></tr>";
					if($i==14)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Client</div></i></b></td></tr>";
					if($i==17)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Job</div></i></b></td></tr>";
					if($i==25)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Administration</div></i></b></td></tr>";
					if($i==32)
					echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Reports</div></i></b></td></tr>";

					?><tr>
						<td  width="300px">&nbsp;&nbsp;<span style="margin:20px;"><div style="margin-left:60px; float:left">

						<?php
						if($row_perm['frm_Code']==19)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Clients</div></i></b>";
						else if($row_perm['frm_Code']==49)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Lead</div></i></b>";
						else if($row_perm['frm_Code']==54)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Contract Signed</div></i></b>";
						else if($row_perm['frm_Code']==32)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Quotesheet Tab</div></i></b>";
						else if($row_perm['frm_Code']==66)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Sales Notes Tab</div></i></b>";
						else if($row_perm['frm_Code']==34)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Permanent Info Tab</div></i></b>";
						else if($row_perm['frm_Code']==71)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Tax & Accounting Tab</div></i></b>";
						else if($row_perm['frm_Code']==46)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Discontinued</div></i></b>";
						else if($row_perm['frm_Code']==63)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Hosting Tab</div></i></b>";
						else if($row_perm['frm_Code']==20)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Contact</div></i></b>";
						else if($row_perm['frm_Code']==27)
						echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Other</div></i></b>";
						else if($row_perm['frm_Code']==28)
						echo "<div style='float:left; margin-left:55px;'>Card File Info</div>";
						else if($row_perm['frm_Code']==29)
						echo "<div style='float:left; margin-left:55px;'>Tasks & Budgeted Hours</div>";
						else if($row_perm['frm_Code']==30)
						echo "<div style='float:left; margin-left:55px;'>Invoice</div>";
						else if($row_perm['frm_Code']==67)
						echo "<div style='float:left; margin-left:55px;'>Entity Details</div>";
						else if($row_perm['frm_Code']==68)
						echo "<div style='float:left; margin-left:55px;'>Current Status</div>";
						else if($row_perm['frm_Code']==69)
						echo "<div style='float:left; margin-left:55px;'>Tasks</div>";
						else if($row_perm['frm_Code']==70)
						echo "<div style='float:left; margin-left:55px;'>Notes</div>";
						else if($row_perm['frm_Code']==33)
						echo "<div style='float:left; margin-left:55px;'>Set up Syd</div>";
						else if($row_perm['frm_Code']==26)
						echo "<div style='float:left; margin-left:55px;'>Permanent Information</div>";
						else if($row_perm['frm_Code']==35)
						echo "<div style='float:left; margin-left:55px;'>Current Status</div>";
						/* else if($row_perm['frm_Code']==37)
						echo "<div style='float:left; margin-left:55px;'>General Info</div>"; */
						else if($row_perm['frm_Code']==36)
						echo "<div style='float:left; margin-left:55px;'>Back Log Jobsheet</div>";
						else if($row_perm['frm_Code']==38)
						echo "<div style='float:left; margin-left:55px;'>Bank</div>";
						else if($row_perm['frm_Code']==39)
						echo "<div style='float:left; margin-left:55px;'>Investments</div>";
					  /*  else if($row_perm['frm_Code']==40)
						echo "<div style='float:left; margin-left:55px;'>AP</div>";
						 else if($row_perm['frm_Code']==41)
						echo "<div style='float:left; margin-left:55px;'>Payroll</div>"; */
						else if($row_perm['frm_Code']==42)
						echo "<div style='float:left; margin-left:55px;'>Tax Returns</div>";
						/* else if($row_perm['frm_Code']==59)
						echo "<div style='float:left; margin-left:55px;'>Estimated hours</div>"; */
						else if($row_perm['frm_Code']==60)
						echo "<div style='float:left; margin-left:55px;'>BAS</div>";
						else if($row_perm['frm_Code']==61)
						echo "<div style='float:left; margin-left:55px;'>Special tasks</div>";
						else if($row_perm['frm_Code']==62)
						echo "<div style='float:left; margin-left:55px;'>Task List</div>";
						else if($row_perm['frm_Code']==72)
						echo "<div style='float:left; margin-left:55px;'>Tax & Accounting</div>";
						else if($row_perm['frm_Code']==64)
						echo "<div style='float:left; margin-left:55px;'>Hosting</div>";
						else if($row_perm['frm_Description']=="Staff") echo "Users";
						else if($row_perm['frm_Description']=="Cases") echo "Tickets";
						else echo $row_perm['frm_Description']; ?>
						</div></span>
					</td>
					<td  align="center">
					<input type="checkbox" name="stf_View[]" disabled value="<?php if($row_perm['stf_View']=="Y"){ echo "Y"; }else { echo "NULL"; }?>"  id="stf_View[]"  <?php if($row_perm['stf_View']=="Y"){ echo "checked"; }?> >
					</td>
					<td align="center">
					<input type="checkbox" name="stf_Add[]" disabled value="<?php if($row_perm['stf_Add']=="Y"){ echo "Y"; }else { echo "NULL"; }?>" <?php if($row_perm['stf_Add']=="Y"){ echo "checked"; }?>   id="stf_Add[]">
					</td>
					<td align="center">
					<input type="checkbox" name="stf_Edit[]" disabled value="<?php if($row_perm['stf_Edit']=="Y"){ echo "Y"; }else { echo "NULL"; }?>"  <?php if($row_perm['stf_Edit']=="Y"){ echo "checked"; }?>  id="stf_Edit[]">
					</td>
					<td align="center">
					<input type="checkbox" name="stf_Delete[]" disabled value="<?php if($row_perm['stf_Delete']=="Y"){ echo "Y"; }else { echo "NULL"; }?>"  <?php if($row_perm['stf_Delete']=="Y"){ echo "checked"; }?>   id="stf_Delete[]">
					</td>
				</tr>
			   <?php
			   $i++;
			}
			?></table><br><br>
			<span class="frmheading"  style='font-size:96%;'>Created by: <?php echo htmlspecialchars($row["stf_Createdby"]) ?> | Created on: <?php echo $commonUses->showGridDateFormat($row["stf_Createdon"]); ?> | Lastmodified by: <?php echo htmlspecialchars($row["stf_Lastmodifiedby"]) ?> | Lastmodified on: <?php echo  $commonUses->showGridDateFormat($row["stf_Lastmodifiedon"]); ?></span><?
		}

		function showroweditor($row, $iseditmode)
		{
			global $commonUses;
			$i=0;
			?>
			<table class="tbl" border="0" cellspacing="10" cellpadding="5" width="70%">
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
						<td class="hr">Contact<font style="color:red;" size="2">*</font>
						</td>
						<td class="dr"><?
							if($iseditmode) {
								$sql = "SELECT t1.`con_Code`, CONCAT_WS(' ', t1.`con_Firstname`, t1.`con_Lastname`) contactName
										FROM `con_contact` as t1 
										LEFT JOIN cnt_contacttype AS t2 
										ON t1.con_Type = t2.cnt_Code 
										WHERE t2.cnt_Description like 'Employee' 
										ORDER BY t1.con_Firstname";
							}
							else {
								$sql = "SELECT t1.`con_Code`, t1.`con_Firstname`, t1.`con_Lastname` 
									FROM con_contact t1, cnt_contacttype t3
									WHERE t3.cnt_Code = t1.con_Type
									AND t3.cnt_Description = 'Employee'
									AND t1.`con_Code` NOT IN (SELECT stf_CCode FROM stf_staff t2) 
									ORDER BY t1.con_Firstname";
							}
							$res = mysql_query($sql) or die(mysql_error());

							if($iseditmode) {
								while ($lp_row = mysql_fetch_assoc($res)) {
									$arrContacts[$lp_row["con_Code"]] = $lp_row["contactName"];
								}
								echo $arrContacts[$row["stf_CCode"]];
							}
							else {
								?><select name="stf_CCode" onChange="genUserPwd(this.value)" <?=$disabledTxt?>> 
									<option value="0">Select Contact</option><?
							  
									while ($lp_row = mysql_fetch_assoc($res)) {
										$val = $lp_row["con_Code"];
										$caption = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
										if ($row["stf_CCode"] == $val) {
											$selstr = " selected"; 
										}
										else {
											$selstr = ""; 
										}
										?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option><?
									} 
								?></select><?
							}
							?>&nbsp;<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Contact Person (Staff) of the User.</span></a>
						</td>
					</tr>
					<tr>
						<td class="hr">Access Type<font style="color:red;" size="2">*</font>
						</td>
						<td class="dr">
							<select name="stf_AccessType" onchange="javascript:showHideAccessSection(this.value);">
								<option value="0">Select Access Type</option><?php
						
								$sql = "select `aty_Code`, `aty_Description` from `aty_accesstype` where aty_Description not like 'Super Administrator' ORDER BY aty_Description";
								$res = mysql_query($sql) or die(mysql_error());

								while ($lp_row = mysql_fetch_assoc($res)) {
										$val = $lp_row["aty_Code"];
										$caption = $lp_row["aty_Description"];
										if ($row["stf_AccessType"] == $val) {
											$selstr = " selected"; 
										} 
										else {
											$selstr = ""; 
										}
										?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php if ($caption=="Staff") echo "User"; else echo $caption ?></option><?php
								} 
							?></select>
							<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Permission of the User. If type <b>Administrator</b> the user has full access rights for all forms. If type <b>User</b> user has limited permissions based on the rights selected for each form.</span></a>
						</td>
					</tr>
					<tr>
						<td class="hr">Login<font style="color:red;" size="2">*</font></td>
						<td class="dr"><? 
							$updateValue = trim($row["stf_Login"]);
							
							if(!empty($updateValue))
								$mode = "edit";
							else
								$mode = "add";
						
						?><input type="text" onblur="javascript:checkUnique(this,'<?php echo $mode?>','<?php echo $updateValue?>')" name="stf_Login" id="stf_Login" maxlength="50" value="<?php echo str_replace('"', '&quot;', trim($row["stf_Login"])) ?>">
							<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Login name of the User.</span></a> &nbsp;&nbsp;
							<span id="enableText" class="successmsg"></span>
							<span id="disableText" class="errmsg"></span>
							
						</td>
					</tr>
					<tr>
						<td class="hr">Password<font style="color:red;" size="2">*</font></td>
						<td class="dr"><input type="text" name="stf_Password" id="stf_Password" maxlength="50" value="<?php echo str_replace('"', '&quot;', trim($row["stf_Password"])) ?>">
						<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Password of the User.</span></a>
						</td>
					</tr>
					<tr>
						<td class="hr">Disabled<font style="color:red;" size="2"></font></td>
						<td class="dr"><input type="checkbox" class="checkboxClass" name="stf_Disabled" id="stf_Disabled" <?php if($row["stf_Disabled"]=='Y'){echo "checked";} ?> >
							<input type="hidden" name="chkDisabled" />
							<a class="tooltip" href="#"><img src="images/help.png"><span class="help">if checked the user is disabled, it cannot access the SR App.</span></a>
						</td>
					</tr>
					<!--<tr>
						<td class="hr">Can view all data<font style="color:red;" size="2"></font></td>
						<td class="dr"><input type="checkbox" class="checkboxClass" name="stf_Viewall" id="stf_Viewall" <?php if($row["stf_Viewall"]=='Y'){echo "checked";} ?> >
							<input type="hidden" name="chkViewall" />
							<a class="tooltip" href="#"><img src="images/help.png"><span class="help">This is used to enable the user to view all data without any limitation similar to Administrator.  But this conditions will apply to only their enabled forms.</span></a>
						</td>
					</tr>
					<tr>
						<td class="hr">Document Upload / Download</td>
						<td class="dr"><input type="checkbox" class="checkboxClass" name="stf_Upload" id="stf_Upload" <?php if($row["stf_Upload"]=='Y'){echo "checked";} ?> >
							<input type="hidden" name="chkUpload" />
							<a class="tooltip" href="#"><img src="images/help.png"><span class="help">This is used to enable the user to upload the documents to their corresponding clients via CMS admin as well as to view the documents in client's grid list (Clients -> Manage Clients).</span></a>
						</td>
					</tr>
					<tr>
						<td class="hr">Client Login & Status Update</td>
						<td class="dr"><input type="checkbox" class="checkboxClass" name="stf_LoginStatus" id="stf_LoginStatus" <?php if($row["stf_LoginStatus"]=='Y'){echo "checked";} ?> >
							<input type="hidden" name="chkLoginStatus" />
							<a class="tooltip" href="#"><img src="images/help.png"><span class="help">This is used to enable the user to Active / In-Active clients.</span></a>
						</td>
					</tr>-->
					<br><?

					//show permission settings
					$formquery_chkcode_view = "SELECT * FROM frm_forms WHERE frm_Code";
					$formres_chkcode_view = mysql_query($formquery_chkcode_view);
					$formquery_chkcode_add = "SELECT * FROM frm_forms where frm_Code";
					$formres_chkcode_add = mysql_query($formquery_chkcode_add);
					$formquery_chkcode_edit = "SELECT * FROM frm_forms where frm_Code";
					$formres_chkcode_edit = mysql_query($formquery_chkcode_edit);
					$formquery_chkcode_delete = "SELECT * FROM frm_forms where frm_Code";
					$formres_chkcode_delete = mysql_query($formquery_chkcode_delete);

					if(!$iseditmode) {
					 ?><table border="0" cellspacing="0" id="permissionSection" cellpadding="0" align="center" class="fieldtable">
						  <tr class="fieldheader">
								<td width="300" rowspan="2" align="left" ><b style="color:#F05729;">Forms to be shown</b></td>
								<td colspan="4" class="helpBod"><div align="center"><b style="color:#F05729;">Add Permissions </b></div></td>
						  </tr>
						  <tr class="fieldheader">
								<th style="width:150px;" class="fieldheader" align="center">
									<input class="checkboxClass" type="checkbox" name="Check_ctr_view" value="yes" onClick="CheckAll_View('<?php while(list($id) = mysql_fetch_array($formres_chkcode_view))
								{  echo $id."|"; }?>')" >
									&nbsp;&nbsp;<b>View</b></th>
								<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_add" value="yes" onClick="CheckAll_Add('<?php while(list($id2) = mysql_fetch_array($formres_chkcode_add))
								{  echo $id2."|"; }?>')" >&nbsp;&nbsp;<b>Add</b></th>
								<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_edit" value="yes" onClick="CheckAll_Edit('<?php while(list($id3) = mysql_fetch_array($formres_chkcode_edit))
								{  echo $id3."|"; }?>')" >&nbsp;&nbsp;<b>Edit</b></th>
								<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_delete" value="yes" onClick="CheckAll_Delete('<?php while(list($id4) = mysql_fetch_array($formres_chkcode_delete))
								{  echo $id4."|"; }?>')" >&nbsp;&nbsp;<b>Delete</b></th>
						  </tr>
							<?php
							 //show permission settings
							$formquery="SELECT * FROM frm_forms WHERE frm_Code ORDER BY frm_Order";
							$formres=@mysql_query($formquery);
							while ($row_form = @mysql_fetch_array($formres))
							{

								if($i==0)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Lead</div></i></b></td></tr>";
								if($i==6)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Referrer Partner</div></i></b></td></tr>";
								if($i==10)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Practice</div></i></b></td></tr>";
								if($i==14)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Client</div></i></b></td></tr>";
								if($i==17)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Job</div></i></b></td></tr>";
								if($i==25)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Administration</div></i></b></td></tr>";
								if($i==32)
								echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Reports</div></i></b></td></tr>";
								
								?><tr>
									<td width="300px">&nbsp;&nbsp;
									<span style="margin-left:20px;">
									<div style="margin-left:60px; float:left"><?
										if($row_form['frm_Description']=="Staff") echo "Users";
										else if($row_form['frm_Description']=="Cases") echo "Tickets";
										else echo $row_form['frm_Description']; 
									?></div>
									<div style=" float:right"><input type="hidden" name="id[]" value="<?php echo $row_form['frm_Code']; ?>" /><input class="checkboxClass" type="checkbox" name="Check_ctr_row[<?php echo $row_form['frm_Code']; ?>]" id="Check_ctr_row[<?php echo $row_form['frm_Code']; ?>]" value="yes" onClick="CheckAll_Row(<?php echo $row_form['frm_Code']; ?>)" ></div></span>
									</td>
									<td align="center">&nbsp;&nbsp;&nbsp;
										<input class="checkboxClass" type="checkbox" name="stf_View<?php echo $row_form['frm_Code']; ?>" value="Y"  id="stf_View[<?php echo $row_form['frm_Code']; ?>]" >
									</td>
									<td align="center">
										<input class="checkboxClass" type="checkbox" name="stf_Add<?php echo $row_form['frm_Code']; ?>" value="Y"   id="stf_Add[<?php echo $row_form['frm_Code']; ?>]">
									</td>
									<td align="center">
										<input class="checkboxClass" type="checkbox" name="stf_Edit<?php echo $row_form['frm_Code']; ?>" value="Y"   id="stf_Edit[<?php echo $row_form['frm_Code']; ?>]">
									</td>
									<td align="center">
										<input class="checkboxClass" type="checkbox" name="stf_Delete<?php echo $row_form['frm_Code']; ?>" value="Y"   id="stf_Delete[<?php echo $row_form['frm_Code']; ?>]">
									</td>
								</tr><?
								$i++;
						 }
					   ?></table><?
				}
			
				if($iseditmode) { 
					if ($row["stf_AccessType"] == 2) {
						$hideSection = "style='display:none'"; 
					}

					?><table border="0" cellspacing="0" cellpadding="0" <?=$hideSection?> id="permissionSection" align="center" class="fieldtable">
						<tr class="fieldheader">
							<td  rowspan="2" align="left" ><b style="color:#F05729;">Forms to be shown</b></td>
							<td colspan="4" class="helpBod"><div align="center"><b style="color:#F05729;">Edit Permissions </b></div></td>
						</tr>
						<tr class="fieldheader">
							<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_view" value="yes" onClick="CheckAll_View('<?php while(list($id) = mysql_fetch_array($formres_chkcode_view))
							{  echo $id."|"; }?>')" >
								&nbsp;&nbsp;<b>View</b></th>
							<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_add" value="yes" onClick="CheckAll_Add('<?php while(list($id2) = mysql_fetch_array($formres_chkcode_add))
							{  echo $id2."|"; }?>')" >
								&nbsp;&nbsp;<b>Add</b></th>
							<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_edit" value="yes" onClick="CheckAll_Edit('<?php while(list($id3) = mysql_fetch_array($formres_chkcode_edit))
							{  echo $id3."|"; }?>')" >
								&nbsp;&nbsp;<b>Edit</b></th>
							<th style="width:150px;" class="fieldheader" align="center"><input class="checkboxClass" type="checkbox" name="Check_ctr_delete" value="yes" onClick="CheckAll_Delete('<?php while(list($id4) = mysql_fetch_array($formres_chkcode_delete))
							{  echo $id4."|"; }?>')" >
								&nbsp;&nbsp;<b>Delete</b></th>
						</tr>
						<?php
						 //show permission settings
						 $permquery="SELECT a.*,b.* 
									FROM stf_staffforms a,frm_forms b 
									WHERE a.stf_SCode =".$row['stf_Code']. " 
									AND b.frm_Code = a.stf_FormCode 
									ORDER BY b.frm_Order";

						$permres = mysql_query($permquery);
						$count = mysql_num_rows($permres);

						while ($row_perm=mysql_fetch_array($permres)) {
							if($commonUses->getAccessTypeDescription($row["stf_AccessType"])=="Administrator")
							$checked="checked";
							?><input type="hidden" name="stf_Code[]" value="<?php echo $row_perm['stf_Code']; ?>" />
							<input type="hidden" name="stf_FormCode<?php echo $row_perm['stf_Code']; ?>" value="<?php echo $row_perm['stf_FormCode']; ?>" />
							<input type="hidden" name="count" value="<?php echo $count;?>"><?

							if($i==0)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Lead</div></i></b></td></tr>";
							if($i==6)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Referrer Partner</div></i></b></td></tr>";
							if($i==10)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Practice</div></i></b></td></tr>";
							if($i==14)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Client</div></i></b></td></tr>";
							if($i==17)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Job</div></i></b></td></tr>";
							if($i==25)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Administration</div></i></b></td></tr>";
							if($i==32)
							echo "<tr><td colspan=\"8\"><b><i><div style='margin-left:10px; float:left; color:#FB5C24'>Reports</div></i></b></td></tr>";

							?><tr><td width="300px">
							&nbsp;&nbsp;<span style="margin:20px;"><div style="margin-left:60px; float:left">

							<?php
							if($row_perm['frm_Code']==19)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Clients</div></i></b>";
							else if($row_perm['frm_Code']==49)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Lead</div></i></b>";
							else if($row_perm['frm_Code']==54)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Contract Signed</div></i></b>";
							else if($row_perm['frm_Code']==32)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Quotesheet Tab</div></i></b>";
							else if($row_perm['frm_Code']==66)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Sales Notes Tab</div></i></b>";
							else if($row_perm['frm_Code']==34)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Permanent Info Tab</div></i></b>";
							else if($row_perm['frm_Code']==71)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Tax & Accounting Tab</div></i></b>";
							else if($row_perm['frm_Code']==46)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Discontinued</div></i></b>";
							else if($row_perm['frm_Code']==63)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Hosting Tab</div></i></b>";
							else if($row_perm['frm_Code']==20)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Contact</div></i></b>";
							else if($row_perm['frm_Code']==27)
							echo "<b><i><div style='float:left; margin-left:25px; color:#047EA7'>Other</div></i></b>";
							else if($row_perm['frm_Code']==28)
							echo "<div style='float:left; margin-left:55px;'>Card File Info</div>";
							else if($row_perm['frm_Code']==30)
							echo "<div style='float:left; margin-left:55px;'>Invoice</div>";
							else if($row_perm['frm_Code']==67)
							echo "<div style='float:left; margin-left:55px;'>Entity Details</div>";
							else if($row_perm['frm_Code']==68)
							echo "<div style='float:left; margin-left:55px;'>Current Status</div>";
							else if($row_perm['frm_Code']==69)
							echo "<div style='float:left; margin-left:55px;'>Tasks</div>";
							else if($row_perm['frm_Code']==70)
							echo "<div style='float:left; margin-left:55px;'>Notes</div>";
							else if($row_perm['frm_Code']==33)
							echo "<div style='float:left; margin-left:55px;'>Set up Syd</div>";
							else if($row_perm['frm_Code']==26)
							echo "<div style='float:left; margin-left:55px;'>Permanent Information</div>";
							else if($row_perm['frm_Code']==35)
							echo "<div style='float:left; margin-left:55px;'>Current Status</div>";
							/* else if($row_perm['frm_Code']==37)
							echo "<div style='float:left; margin-left:55px;'>General Info</div>"; */
							else if($row_perm['frm_Code']==36)
							echo "<div style='float:left; margin-left:55px;'>Back Log Jobsheet</div>";
							else if($row_perm['frm_Code']==38)
							echo "<div style='float:left; margin-left:55px;'>Bank</div>";
							else if($row_perm['frm_Code']==39)
							echo "<div style='float:left; margin-left:55px;'>Investments</div>";
							/* else if($row_perm['frm_Code']==40)
							echo "<div style='float:left; margin-left:55px;'>AP</div>"; 
							else if($row_perm['frm_Code']==41)
							echo "<div style='float:left; margin-left:55px;'>Payroll</div>"; */
							else if($row_perm['frm_Code']==42)
							echo "<div style='float:left; margin-left:55px;'>Tax Returns</div>";
							/*else if($row_perm['frm_Code']==59)
							echo "<div style='float:left; margin-left:55px;'>Estimated hours</div>"; */
							else if($row_perm['frm_Code']==60)
							echo "<div style='float:left; margin-left:55px;'>BAS</div>";
							else if($row_perm['frm_Code']==61)
							echo "<div style='float:left; margin-left:55px;'>Special tasks</div>";
							else if($row_perm['frm_Code']==62)
							echo "<div style='float:left; margin-left:55px;'>Task List</div>";
							else if($row_perm['frm_Code']==72)
							echo "<div style='float:left; margin-left:55px;'>Tax & Accounting</div>";
							else if($row_perm['frm_Code']==64)
							echo "<div style='float:left; margin-left:55px;'>Hosting</div>";
							else if($row_perm['frm_Description']=="Staff") echo "Users";
							else if($row_perm['frm_Description']=="Cases") echo "Tickets";
							else echo $row_perm['frm_Description']; ?> </div></span>
							<div style=" float:right"><input class="checkboxClass" type="checkbox" name="Check_ctr_row[<?php echo $row_perm['stf_FormCode']; ?>]" id="Check_ctr_row[<?php echo $row_perm['stf_FormCode']; ?>]"  value="yes" onClick="CheckAll_Row(<?php echo $row_perm['stf_FormCode']; ?>)" ></div>
							</td>
							<td  align="center">
							<input class="checkboxClass" type="checkbox" name="stf_View<?php echo $row_perm['stf_Code']; ?>" value="Y"  <?php echo $checked; if($row_perm['stf_View']=="Y"){ echo " checked"; }?>  id="stf_View[<?php echo $row_perm['stf_FormCode']; ?>]" >
							 </td>
							 <td  align="center">
							<input class="checkboxClass" type="checkbox" name="stf_Add<?php echo $row_perm['stf_Code']; ?>" value="Y"  <?php echo $checked; if($row_perm['stf_Add']=="Y"){ echo " checked"; }?>  id="stf_Add[<?php echo $row_perm['stf_FormCode']; ?>]" >
							 </td>
							<td  align="center">
							<input class="checkboxClass" type="checkbox" name="stf_Edit<?php echo $row_perm['stf_Code']; ?>" value="Y"  <?php echo $checked; if($row_perm['stf_Edit']=="Y"){ echo " checked"; }?>  id="stf_Edit[<?php echo $row_perm['stf_FormCode']; ?>]" >
							 </td>
							<td  align="center">
							<input class="checkboxClass" type="checkbox" name="stf_Delete<?php echo $row_perm['stf_Code']; ?>" value="Y"<?php echo $checked; if($row_perm['stf_Delete']=="Y"){ echo " checked"; }?>  id="stf_Delete[<?php echo $row_perm['stf_FormCode']; ?>]" >
							 </td>
							<?php //} ?>
							</tr>
							<?php
							$i++;
						}
					?></table><?
				}
		}
	function showpagenav($page, $pagecount) {
		?><table border="0" cellspacing="1" cellpadding="4" align="right" >
			<tr>
				 <?php if ($page > 1) { ?>
				<td><a href="stf_staff.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; "></span></a>&nbsp;</td>
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
				<td><a href="stf_staff.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
				<?php } } } else { ?>
				<td><a href="stf_staff.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
				<?php } } } ?>
				<?php if ($page < $pagecount) { ?>
				<td>&nbsp;<a href="stf_staff.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
				<?php } ?>
			</tr>
		</table><?
	}

	function showrecnav($a, $recid, $count) {

		?><table border="0" cellspacing="1" cellpadding="4" align="right">
			<tr>
			 <?php if ($recid > 0) { ?>
			<td><a href="stf_staff.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; "></span></a></td>
			<?php } if ($recid < $count - 1) { ?>
			<td><a href="stf_staff.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; "></span></a></td>
			<?php } ?>
			</tr>
		</table><br><?
		
		switch($a) {
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
		?><div class="frmheading">
			<h1><?=$title?> Users</h1>
		</div><?
	}

	function addrec() {
		global $staffQuery;
		 ?><div class="frmheading">
			<h1>Add Record</h1>
		</div>
		<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
			<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
		</div>

		<form enctype="multipart/form-data" action="stf_staff.php" method="post"  name="staff" onSubmit="return validateFormOnSubmit()">
		<p><input type="hidden" name="sql" value="insert"></p>
		<?php
		$row = array(
		  "stf_Code" => "",
		  "stf_CCode" => "",
		  "stf_AccessType" => "",
		  "stf_Login" => "",
		  "stf_Password" => "",
		  "stf_Createdby" => "",
		  "stf_Createdon" => "",
		  "stf_Lastmodifiedby" => "",
		  "stf_Lastmodifiedon" => "");
		$this->showroweditor($row, false);
		?>
		<button style="margin-right:32px;" type="button" value="Cancel" onClick='javascript:history.back(-1);'>Cancel</button>
		<button type="submit" id="btnSave" name="action" value="Save" class="" style="width:115px;">Save</button>
		</form><?
		if(isset($_SESSION["USERLOGIN"])) unset($_SESSION["USERLOGIN"]);
		$_SESSION["USERLOGIN"] = $staffQuery->fetch_login_name();
	} 

	function viewrec($recid,$access_file_level) {
		  global $staffQuery;
		  
		  $res = $staffQuery->sql_select();
		  $count = mysql_num_rows($res);
		  mysql_data_seek($res, $recid);

		  $row = mysql_fetch_assoc($res);
		  $this->showrecnav("view", $recid, $count);
		?><br><?
		$this->showrow($row, $recid);

		?><div class="frmheading">
			<h1></h1>
		</div>
		<table class="bd" border="0" cellspacing="1" cellpadding="4">
			<tr><?
				if($access_file_level['stf_Add']=="Y") {
					?><td><a href="stf_staff.php?a=add" class="hlight">Add Record</a></td><? 
				}
					
				if($access_file_level['stf_Edit']=="Y") {
					?><td><a href="stf_staff.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td><?
				} 

				if($access_file_level['stf_Delete']=="Y") {
					?><td><a onClick="performdelete('stf_staff.php?mode=delete&recid=<?php echo htmlspecialchars($row["stf_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td><?
				} 
			?></tr>
		</table><?

		mysql_free_result($res);
	}

	function editrec($recid) {
		global $staffQuery;

		$res = $staffQuery->sql_select();
		$count = mysql_num_rows($res);
		mysql_data_seek($res, $recid);

		$row = mysql_fetch_assoc($res);
		$this->showrecnav("edit", $recid, $count);

		?><div style="position:absolute; top:20; right:-90px; width:300; height:300;">
			<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
		</div>

		<form enctype="multipart/form-data" action="stf_staff.php<?php echo "?a=".$_GET['a']."&recid=".$_GET['recid'];?>" method="post"  name="staff" onSubmit="return validateFormOnSubmit()">
			<input type="hidden" name="sql" value="update">
			<input type="hidden" name="xstf_Code" value="<?php echo $row["stf_Code"] ?>">
			<?
				// error message
				if(!empty($_REQUEST['flagDuplicate'])) {
					?><div class="errorMsg"><img src="../images_user/errorIcon.gif"> &nbsp;Login already exists.</div><?	
				}
					
			?>
			<?php $this->showroweditor($row, true); ?>
			<button style="margin-right:32px;" type="button" value="Cancel" onClick='return ComfirmCancel();'>Cancel</button>
			<button type="submit" id="btnUpdate" name="action" value="Update" style="width:115px;" class="button">Update</button>
		</form><?
		$_SESSION["USERLOGIN"] = $staffQuery->fetch_login_name($row["stf_Code"]);
		
		mysql_free_result($res);
	}
}
$staffContent = new staffContentList();
?>