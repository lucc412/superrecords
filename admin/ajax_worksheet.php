<?php
include("dbclass/commonFunctions_class.php");
include("dbclass/worksheet_db_class.php");
	
//print_r($_SESSION);
class worksheetContentList extends Database
{
       // worksheet grid content
	 
       function select($clientCode,$page_flag,$get_page,$filter,$filterfield,$wholeonly)
       {
          global $a;
          $showrecs = 20;
          global $page;
          global $page_records;
         // global $filter;
         // global $filterfield;
          //global $wholeonly;
          global $order;
          global $ordtype;
          global $worksheetQuery;
          global $commonUses;
          global $filterstr;
		  $access_file_level = $_SESSION['access_file_level'];
	
         // print_r($access_file_level);
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
		  //echo "count".$count;
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
                <!--<form name="wrkrowedit" method="post" action="wrk_worksheet.php" enctype="multipart/form-data">-->
                   <table class="fieldtable"  border="0" cellspacing="1" cellpadding="5" width="100%" >
                    <?php
                    if($count >0 )
                    {
                    ?>
                        <tr><td colspan="12">
                            <?php $this->showpagenav_client($page_records, $pagecount,$clientCode,$get_page);  ?>
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
                            <th class="fieldheader" nowrap style="width:180px;"><a  href="wrk_worksheet.php?order=<?php echo "wrk_InternalDueDate" ?>&type=<?php echo $ordtypestr ?>&client=<?php echo $clientCode; ?>">Super Records Due Date</a></th>
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
                            <!--<form name="wrkrowedit" id="wrkrowedit_<?php echo $row['wrk_Code']; ?>" method="post" action="wrk_worksheet.php" enctype="multipart/form-data">-->
                            <!--<form name="wrkrowedit_<?php echo $row['wrk_Code']; ?>" method="post" >-->
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
                                                                    <input type="hidden" name="wrk_DueDate[<?php echo $row['wrk_Code']; ?>]" value="<?php if($row["wrk_DueDate"]!="0000-00-00") { echo date("d/m/Y",strtotime( $row["wrk_DueDate"] )); } else { echo ""; } ?>"  />
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
                                         ?></td>
                                                                    <input type="hidden" name="wrk_InternalDueDate[<?php echo $row['wrk_Code']; ?>]" value="<?php if($row["wrk_InternalDueDate"]!="0000-00-00") { echo date("d/m/Y",strtotime( $row["wrk_InternalDueDate"] )); } else { echo ""; } ?>"  />
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
                                        <input type="hidden" name="wrk_Statusold[<?php echo $row['wrk_Code']; ?>]" value="<?php echo $row["wrk_Status"]; ?>">
                                     <?php
                                    }
                                    else
                                    {
                                    echo stripslashes($row["lp_wrk_Status"]);
                                    ?>
                                        <input type="hidden" name="wrk_Status[<?php echo $row['wrk_Code']; ?>]" value="<?php echo $row["wrk_Status"]; ?>">
                                        <input type="hidden" name="wrk_Statusold[<?php echo $row['wrk_Code']; ?>]" value="<?php echo $row["wrk_Status"]; ?>">
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
                                                   <input type="image" src="images/save.png" border="0"  alt="Edit" name="Edit" title="Save" align="middle" onClick=" return inlineSave('<?php echo $row['wrk_Code']; ?>','<?php echo $addquery; ?>','<?php echo $clientCode; ?>','<?php echo $page_records; ?>','<?php echo $row["wrk_MasterActivity"]; ?>','<?php echo $formurl; ?>','Worksheet','440','250','yes');" />
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
								</tr>
                            <!--</form>-->

                    <?php
                      }
                      mysql_free_result($res);
                    ?>
                    </table>
                  	<br /><p><input type="submit" name="submit" value="Delete" onClick='return ComfirmDelete(<?php echo $clientCode; ?>,<?php echo $page_flag; ?>,<?php echo $get_page; ?>);'  class="cancelbutton"></p>
              	<!--</form>-->                 
                <br>
               </td>
            </tr>
          </table>
         <?php
         }
		//================= Pagination for inner records under Clientele =============================
        function showpagenav_client($page, $pagecount,$clientCode,$get_page)
        {
			
        ?>
			<table border="0" cellspacing="1" cellpadding="4" align="right" >
				<tr>
					 <?php if ($page > 1) { ?>
					<td><a href="wrk_worksheet.php?page_records=<?php echo $page - 1 ?>&client=<?php echo $clientCode; ?>&page=<?php echo $get_page; ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
					<?php } ?>
					<?php
					  $pagerange = 10;
			
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
					<?php } else { 
					
					?>
					<td><a href="wrk_worksheet.php?page_records=<?php echo $j ?>&client=<?php echo $clientCode; ?>&page=<?php echo $get_page; ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
					<?php } } } else { ?>
					<td><a href="wrk_worksheet.php?page_records=<?php echo $startpage ?>&client=<?php echo $clientCode; ?>&page=<?php echo $get_page; ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
					<?php } } } ?>
					<?php if ($page < $pagecount) { ?>
					<td>&nbsp;<a href="wrk_worksheet.php?page_records=<?php echo $page + 1 ?>&client=<?php echo $clientCode; ?>&page=<?php echo $get_page; ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
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
                                  "wrk_SeniorInCharge" => "",  
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
                $res = $worksheetQuery->sql_select($_GET['client'], &$count,&$filter,&$filterfield);
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
                $res = $worksheetQuery->sql_select($_GET['client']);
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
                		<td class="hr">Super Records Due Date</td>
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
$id = $_GET['id'];
$pages = $_GET['pages'];
$page = $_GET['page'];
$filterstr = $_GET['filter'];
$filterfield = $_GET['filterfield'];
$wholeonly = $_GET['wholeonly'];
$worksheetContent = new worksheetContentList();
$worksheetContent->select($id,$pages,$page,$filterstr,$filterfield,$wholeonly);

?>

