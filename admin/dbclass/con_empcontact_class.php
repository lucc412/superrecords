<?php
	
class empcontactContentList extends Database
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
              global $empcontactDbcontent;

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
              $res = $empcontactDbcontent->sql_select();
             // $count = $empcontactDbcontent->sql_getrecordcount();
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
			<div class="frmheading">
				<h1>Employee Contact</h1>
			</div>
            <form action="con_empcontact.php" method="post">
                <table class="customFilter" align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
                <tr>
                    <td><b>Custom Filter</b>&nbsp;</td>
                    <td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
                    <td>
                        <select name="filter_field">
                            <option value="">All Fields</option>
                            <option value="<?php echo "lp_con_Designation" ?>"<?php if ($filterfield == "lp_con_Designation") { echo "selected"; } ?>>Designation</option>
                            <option value="<?php echo "con_Firstname" ?>"<?php if ($filterfield == "con_Firstname") { echo "selected"; } ?>>First Name</option>
                            <option value="<?php echo "con_Middlename" ?>"<?php if ($filterfield == "con_Middlename") { echo "selected"; } ?>>Middle Name</option>
                            <option value="<?php echo "con_Lastname" ?>"<?php if ($filterfield == "con_Lastname") { echo "selected"; } ?>>Last Name</option>
                            <option value="<?php echo "con_Build" ?>"<?php if ($filterfield == "con_Build") { echo "selected"; } ?>>Unit Number</option>
                            <option value="<?php echo "con_Address" ?>"<?php if ($filterfield == "con_Address") { echo "selected"; } ?>>Street Name</option>
                            <option value="<?php echo "con_City" ?>"<?php if ($filterfield == "con_City") { echo "selected"; } ?>>Suburb</option>
                            <option value="<?php echo "con_State" ?>"<?php if ($filterfield == "con_State") { echo "selected"; } ?>>State</option>
                            <option value="<?php echo "con_Postcode" ?>"<?php if ($filterfield == "con_Postcode") { echo "selected"; } ?>>Post Code</option>
                            <option value="<?php echo "con_Country" ?>"<?php if ($filterfield == "con_Country") { echo "selected"; } ?>>Country</option>
                            <option value="<?php echo "con_Phone" ?>"<?php if ($filterfield == "con_Phone") { echo "selected"; } ?>>Phone</option>
                            <option value="<?php echo "con_Mobile" ?>"<?php if ($filterfield == "con_Mobile") { echo "selected"; } ?>>Mobile</option>
                            <option value="<?php echo "con_Fax" ?>"<?php if ($filterfield == "con_Fax") { echo "selected"; } ?>>Fax</option>
                            <option value="<?php echo "con_Email" ?>"<?php if ($filterfield == "con_Email") { echo "selected"; } ?>>Email</option>
                            <option value="<?php echo "con_Notes" ?>"<?php if ($filterfield == "con_Notes") { echo "selected"; } ?>>Notes</option>
                        </select>
                    </td>
                    <td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
                    <td><a href="con_empcontact.php?a=reset" class="hlight">Reset Filter</a></td>
                </tr>
                </table>
            </form>
            <p>&nbsp;</p>
            <br><br><?php
                        if($access_file_level['stf_Add']=="Y")
                        {
                        ?>
                            <a href="con_empcontact.php?a=add" class="hlight">
                            <img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
                            <?php }
                             $this->showpagenav($page, $pagecount); ?>
                    <br><br>
                    <table width="100%" class="fieldtable" align="center" border="0" cellspacing="1" cellpadding="5" >
                         <tr class="fieldheader">
                            <th style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');" class="fieldheader sort_column">First Name <img id="sort_name" src="images/sort_asc.png"></th>
							<th style="cursor:pointer;" align="left" onclick="changeSortImage('sort_lname');" class="fieldheader sort_column">Last Name <img id="sort_lname" src="images/sort_asc.png"></th>
                            <th style="cursor:pointer;" align="left" onclick="changeSortImage('desi');" class="fieldheader sort_column">Designation <img id="desi" src="images/sort_asc.png"></th>	
                            <th style="cursor:pointer;" align="left" onclick="changeSortImage('sort_email');" class="fieldheader sort_column">Email <img id="sort_email" src="images/sort_asc.png"></th>
                            <th class="fieldheader" colspan="3" align="center">Actions</th>
                        </tr>
                        <?php
						$countRow = 0;
                          for ($i = $startrec; $i < $reccount; $i++)
                          {
							if($countRow%2 == 0) $trClass = "trcolor";
							else $trClass = "";

                            $row = mysql_fetch_assoc($res);

                        ?>
                        <tr class="<?=$trClass?>">
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["con_Salutation"]); if($row["con_Salutation"]=="") { echo ""; } else { echo ".";  echo "&nbsp;&nbsp;"; } echo stripslashes($row["con_Firstname"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["con_Lastname"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["lp_con_Designation"]) ?></td>
                            <td class="<?php echo $style ?>"><?php echo stripslashes($row["con_Email"]) ?></td>
                            <?php
                            if($access_file_level['stf_View']=="Y")
                            {
                            ?>
                            <td align="center">
                            <a href="con_empcontact.php?a=view&recid=<?php echo $i ?>">
                            <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                            </td>
                            <?php } ?>
                            <?php
                            if($access_file_level['stf_Edit']=="Y")
                            {
                            ?>
                            <td align="center">
                            <a href="con_empcontact.php?a=edit&recid=<?php echo $i ?>">
                            <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                            </td>
                            <?php }
                            if($access_file_level['stf_Delete']=="Y")
                            {
                            ?>
                            <td align="center">
                            <a onClick="performdelete('con_empcontact.php?mode=delete&recid=<?php echo stripslashes($row["con_Code"]) ?>'); return false;" href="#">
                            <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php
							$countRow++;
                          }
                          mysql_free_result($res);
                        ?>
                    </table>
            <br>
         <?php }
         function showrow($row, $recid)
         {
            global $commonUses;
             ?>
                <table align="center"   border="0" cellspacing="10" cellpadding="5"width="50%">
                    <tr>
                        <td class="hr">Designation</td>
                        <td class="dr"><?php echo stripslashes($row["lp_con_Designation"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">First Name</td>
                        <td class="dr"><?php echo stripslashes($row["con_Salutation"]); if($row["con_Salutation"]=="") { echo ""; } else { echo ".";  echo "&nbsp;&nbsp;"; } echo stripslashes($row["con_Firstname"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Middle Name</td>
                        <td class="dr"><?php echo stripslashes($row["con_Middlename"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Last Name</td>
                        <td class="dr"><?php echo stripslashes($row["con_Lastname"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Unit Number</td>
                        <td class="dr"><?php echo stripslashes($row["con_Build"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Street Name</td>
                        <td class="dr"><?php echo stripslashes($row["con_Address"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Suburb</td>
                        <td class="dr"><?php echo stripslashes($row["con_City"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">State</td>
                        <td class="dr"><?php echo stripslashes($row["state_Description"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Post Code</td>
                        <td class="dr"><?php echo stripslashes($row["con_Postcode"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Country</td>
                        <td class="dr"><?php echo stripslashes($row["con_Country"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Phone</td>
                        <td class="dr"><?php echo stripslashes($row["con_Phone"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Mobile</td>
                        <td class="dr"><?php echo stripslashes($row["con_Mobile"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Fax</td>
                        <td class="dr"><?php echo stripslashes($row["con_Fax"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Email</td>
                        <td class="dr"><?php echo stripslashes($row["con_Email"]) ?></td>
                    </tr>
                    <tr>
                        <td class="hr">Notes</td>
                        <td class="dr"><?php echo stripslashes($row["con_Notes"]) ?></td>
                    </tr>
                </table>
                <br>
                <span  class="footer2"  style='font-size:96%;'>Created by: <?php echo stripslashes($row["con_Createdby"]) ?> | Created on: <?php echo $commonUses->showGridDateFormat($row["con_Createdon"]); ?> | Lastmodified by: <?php echo stripslashes($row["con_Lastmodifiedby"]) ?> | Lastmodified on: <?php echo  $commonUses->showGridDateFormat($row["con_Lastmodifiedon"]); ?></span>
        <?php } 
        function showroweditor($row, $iseditmode)
        {
                ?>
                <table class="tbl" border="0" cellspacing="10" cellpadding="5"width="50%">
                    <?php
                    if(!$iseditmode) {
                    ?>
                    <tr>
                        <td class="hr">Code</td>
                        <td class="dr">
                        <?php echo "New"; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <?php
                         $sql = "select `cnt_Code` from `cnt_contacttype`  where cnt_Description='Employee'";
                         $res = mysql_query($sql) or die(mysql_error());
                         $contactcode=@mysql_result( $res,0,'cnt_Code') ;
                        ?>
                        <input type="hidden" name="con_Type" value="<?php echo $contactcode;?>">
                    </tr>
                    <tr>
                        <td class="hr">Designation
                        </td>
                        <td>
                            <select name="con_Designation"><option value="0">Select Designation</option>
                                <?php
                                  $sql = "select `dsg_Code`, `dsg_Description` from `dsg_designation` ORDER BY dsg_Order";
                                  $res = mysql_query($sql) or die(mysql_error());
                                  while ($lp_row = mysql_fetch_assoc($res)){
                                  $val = $lp_row["dsg_Code"];
                                  $caption = $lp_row["dsg_Description"];
                                  if ($row["con_Designation"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                  ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                   <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Salutation
                        </td>
                        <td class="dr">
                            <select name="con_Salutation">
                                <option value="">Select</option>
                                <option value="Mr" <?php if($row['con_Salutation']=="Mr") echo "selected"; ?>>Mr</option>
                                <option value="Ms" <?php if($row['con_Salutation']=="Mrs") echo "selected"; ?>>Mrs</option>
                                <option value="Miss"<?php if($row['con_Salutation']=="Miss") echo "selected"; ?>>Miss</option>
                                <option value="Dr"<?php if($row['con_Salutation']=="Dr") echo "selected"; ?>>Dr</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">First Name<font style="color:red;" size="2">*</font>
                        </td>
                        <td class="dr">
                            <input type="text"  name="con_Firstname" maxlength="100" value="<?php echo stripslashes($row["con_Firstname"]) ?>">
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">First Name of employee</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr" nowrap>Middle Name
                        </td>
                        <td class="dr"><input type="text"  name="con_Middlename" maxlength="100" value="<?php echo stripslashes($row["con_Middlename"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Last Name<font style="color:red;" size="2">*</font></td>
                        <td class="dr">
                            <input type="text" name="con_Lastname" maxlength="100" value="<?php echo stripslashes($row["con_Lastname"]) ?>">
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Last Name of employee</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr" nowrap>Unit Number<font style="color:red;" size="2">*</font></td>
                        <td class="dr">
                        <input type="text" name="con_Build" maxlength="50" value="<?php echo stripslashes($row["con_Build"]) ?>">
                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Street Number</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Street Name</td>
                        <td class="dr"><input type="text" name="con_Address" maxlength="100" value="<?php echo stripslashes($row["con_Address"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Suburb</td>
                        <td class="dr"><input type="text" name="con_City" maxlength="20" value="<?php echo stripslashes($row["con_City"]) ?>"></td>
                    </tr>
                    <!--<tr>
                        <td class="hr">State</td>
                        <td class="dr"><input type="text" name="con_State" maxlength="20" value="<?php echo stripslashes($row["con_State"]) ?>"></td>
                    </tr>-->
                                                    <tr>
                                                        <td >State</td>
                                                            <td>
                                                                <?php
                                                                $state_query ="select `cst_Code`,`cst_Description` from `cli_state` ORDER BY cst_Description";
                                                                $state_result=mysql_query($state_query) or die(mysql_error());
                                                                  ?>
                                                                <select name="con_State" ><option value="">Select State</option>
                                                                    <?php while($state_row=mysql_fetch_array($state_result)) {
                                                                        $val = $state_row["cst_Code"];
                                                                        $caption = $state_row["cst_Description"];
                                                                        if ($row["con_State"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                    ?>
                                                                        <option value="<?php echo $state_row['cst_Code']?>"<?php echo $selstr; ?>><?php  echo $caption; ?></option>
                                                                     <?php   } ?>
                                                                 </select>
                                                            </td>
                                                    </tr>

                    <tr>
                        <td class="hr">Post Code</td>
                        <td class="dr"><input type="text" name="con_Postcode" maxlength="20" value="<?php echo stripslashes($row["con_Postcode"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Country</td>
                        <td class="dr"><input type="text"  name="con_Country" maxlength="100" value="<?php echo stripslashes($row["con_Country"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Phone</td>
                        <td class="dr"><input type="text" name="con_Phone" maxlength="20" value="<?php echo stripslashes($row["con_Phone"]) ?>" onkeypress='return isNumberKey(event)'></td>
                    </tr>
                    <tr>
                        <td class="hr">Mobile</td>
                        <td class="dr"><input type="text" name="con_Mobile" maxlength="20" value="<?php echo stripslashes($row["con_Mobile"]) ?>" onkeypress='return isNumberKey(event)'></td>
                    </tr>
                    <tr>
                        <td class="hr">Fax</td>
                        <td class="dr"><input type="text" name="con_Fax" maxlength="20" value="<?php echo stripslashes($row["con_Fax"]) ?>" onkeypress='return isNumberKey(event)'></td>
                    </tr>
                    <tr>
                        <td class="hr">Email</td>
                        <td class="dr"><input type="text" name="con_Email" maxlength="100" value="<?php echo stripslashes($row["con_Email"]) ?>"  size="39"></td>
                    </tr>
                    <tr>
                        <td class="hr">Notes</td>
                        <td class="dr"><textarea cols="35" rows="4" name="con_Notes" ><?php echo stripslashes($row["con_Notes"]) ?></textarea></td>
                    </tr>
                 </table>
        <?php } 
        function showpagenav($page, $pagecount)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                 <?php if ($page > 1) { ?>
                <td><a href="con_empcontact.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                <td><a href="con_empcontact.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                <?php } } } else { ?>
                <td><a href="con_empcontact.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                <?php } } } ?>
                <?php if ($page < $pagecount) { ?>
                <td>&nbsp;<a href="con_empcontact.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                <?php } ?>
                </tr>
            </table>
        <?php } 
        function showrecnav($a, $recid, $count)
        {
        ?>
            <table border="0" cellspacing="1" cellpadding="4" align="right">
                <tr>
                    <?php if ($recid > 0) { ?>
                    <td><a href="con_empcontact.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                    <?php } if ($recid < $count - 1) { ?>
                    <td><a href="con_empcontact.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
                    <?php } ?>
                </tr>
            </table>
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
            <div class="frmheading">
				<h1><?=$title?> Employee Contact</h1>
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
             <form enctype="multipart/form-data" action="con_empcontact.php" method="post" name="contact" onSubmit="return validateFormOnSubmit()">
             <p><input type="hidden" name="sql" value="insert"></p>
            <?php
            $row = array(
              "con_Code" => "",
              "con_Type" => "",
              "con_Designation" => "",
              "con_Firstname" => "",
              "con_Middlename" => "",
              "con_Lastname" => "",
              "con_Build" => "",
              "con_Address" => "",
              "con_City" => "",
              "con_State" => "",
              "con_Postcode" => "",
              "con_Country" => "",
              "con_Phone" => "",
              "con_Mobile" => "",
              "con_Fax" => "",
              "con_Email" => "",
              "con_Notes" => "",
              "con_Createdby" => "",
              "con_Createdon" => "",
              "con_Lastmodifiedby" => "",
              "con_Lastmodifiedon" => "");
                $this->showroweditor($row, false);
            ?>
            <button style="margin-right:32px;" type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>
<button type="submit" name="action" value="Save" class="button">Save</button></form>
        <?php } 
        function viewrec($recid,$access_file_level)
        {
           global $empcontactDbcontent;
            $res = $empcontactDbcontent->sql_select();
           //$count = sql_getrecordcount();
           $count = mysql_num_rows($res);
           mysql_data_seek($res, $recid);
           $row = mysql_fetch_assoc($res);
           $this->showrecnav("view", $recid, $count);
        ?>
            <br>
            <?php $this->showrow($row, $recid) ?>
            <div class="frmheading">
				<h1></h1>
			</div>
            <table class="bd" border="0" cellspacing="1" cellpadding="4">
                <tr>
                <?php
                  if($access_file_level['stf_Add']=="Y")
                  {
                ?>
                <td><a href="con_empcontact.php?a=add" class="hlight">Add Record</a></td>
                <?php }
                  if($access_file_level['stf_Edit']=="Y")
                  {
                ?>
                <td><a href="con_empcontact.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
                <?php }
                  if($access_file_level['stf_Delete']=="Y")
                  {
                ?>
                <td><a onClick="performdelete('con_empcontact.php?mode=delete&recid=<?php echo stripslashes($row["con_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
                <?php } ?>
                </tr>
            </table>
            <?php
              mysql_free_result($res);
        }
        function editrec($recid)
        {
           global $empcontactDbcontent;
            $res = $empcontactDbcontent->sql_select();
           //$count = sql_getrecordcount();
           $count = mysql_num_rows($res);
           mysql_data_seek($res, $recid);
           $row = mysql_fetch_assoc($res);
           $this->showrecnav("edit", $recid, $count);
        ?>
            <div style="position:absolute; top:20; right:-90px; width:300; height:300;">
				<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
			</div>

            <br>
            <form enctype="multipart/form-data" action="con_empcontact.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>" method="post" name="contact" onSubmit="return validateFormOnSubmit()">
				<input type="hidden" name="sql" value="update">
				<input type="hidden" name="xcon_Code" value="<?php echo $row["con_Code"] ?>">
				<?php $this->showroweditor($row, true); ?>
				<button style="margin-right:32px;" type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button>
				<button type="submit" name="action" value="Update" class="button">Update</button>  
			</form>
        <?php
          mysql_free_result($res);
        }
}
	$empcontactContent = new empcontactContentList();

?>

