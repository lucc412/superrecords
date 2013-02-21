<?php
	
class lrfContentList extends Database
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
              global $leaverequestDbcontent;
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
              $res = $leaverequestDbcontent->sql_select();
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
            <span class="frmheading">Leave Request Form</span>
            <hr size="1" noshade>
            <form action="lrf_leaverequestform.php" method="post">
                <table align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
                    <tr>
                        <td><b>Custom Filter</b>&nbsp;</td>
                        <td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
                        <td><select name="filter_field">
                        <option value="">All Fields</option>
                         <option value="<?php echo "lp_lrf_StaffCode" ?>"<?php if ($filterfield == "lp_lrf_StaffCode") { echo "selected"; } ?>>User Name</option>
                        <!--<option value="<?php echo "lrf_From" ?>"<?php if ($filterfield == "lrf_From") { echo "selected"; } ?>>From</option>
                        <option value="<?php echo "lrf_To" ?>"<?php if ($filterfield == "lrf_To") { echo "selected"; } ?>>To</option>-->
                        <option value="<?php echo "lrf_Reason" ?>"<?php if ($filterfield == "lrf_Reason") { echo "selected"; } ?>>Reason</option>
                        <option value="<?php echo "lp_lrf_JobAlloted" ?>"<?php if ($filterfield == "lp_lrf_JobAlloted") { echo "selected"; } ?>>Job Alloted</option>
                        <option value="<?php echo "lrf_Notes" ?>"<?php if ($filterfield == "lrf_Notes") { echo "selected"; } ?>>Notes</option>
                        <option value="<?php echo "lrf_Status_Desc" ?>"<?php if ($filterfield == "lrf_Status_Desc") { echo "selected"; } ?>>Status</option>
                        </select></td>
                        <td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="action" value="Apply Filter"></td>
                        <td><a href="lrf_leaverequestform.php?a=reset" class="hlight">Reset Filter</a></td>
                    </tr>
                </table>
            </form>
            <p>&nbsp;</p>
            <br><br>
            <table class="fieldtable_outer" align="center">
                <tr>
                    <td><?php
                        if($access_file_level['stf_Add']=="Y")
                        {
                        ?>
                            <a href="lrf_leaverequestform.php?a=add" class="hlight">
                            <img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
                        <?php }
                            $this->showpagenav($page, $pagecount); ?>
                            <br><div class="msg" style="position:relative;left:300px;  "><?php echo  $_GET['msg'];?></div>
                            <table class="fieldtable" align="center" border="0" cellspacing="1" cellpadding="5" >
                            <tr class="fieldheader">
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lp_lrf_StaffCode" ?>&type=<?php echo $ordtypestr ?>">User Name</a></th>
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lrf_From" ?>&type=<?php echo $ordtypestr ?>">From</a></th>
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lrf_To" ?>&type=<?php echo $ordtypestr ?>">To</a></th>
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lrf_Reason" ?>&type=<?php echo $ordtypestr ?>">Reason</a></th>
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lp_lrf_JobAlloted" ?>&type=<?php echo $ordtypestr ?>">Job Alloted</a></th>
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lrf_Notes" ?>&type=<?php echo $ordtypestr ?>">Notes</a></th>
                                <th class="fieldheader"><a  href="lrf_leaverequestform.php?order=<?php echo "lrf_Status" ?>&type=<?php echo $ordtypestr ?>">Status</a></th>
                                <th  class="fieldheader" colspan="3" align="center">Actions</th>
                            </tr>
            <?php
              for ($i = $startrec; $i < $reccount; $i++)
              {
                $row = mysql_fetch_assoc($res);
             ?>
                <tr>
                 <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["lrf_StaffCode"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["lrf_From"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["lrf_To"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lrf_Reason"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo $commonUses->getFirstLastName($row["lrf_JobAlloted"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lrf_Notes"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lrf_Status_Desc"]) ?></td>
                <?php
                  if($access_file_level['stf_View']=="Y")
                  {
                ?>
                <td>
                <a href="lrf_leaverequestform.php?a=view&recid=<?php echo $i ?>">
                <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                </td>
                <?php }
                  if($access_file_level['stf_Edit']=="Y")
                  {
                ?>
                <td>
                <a href="lrf_leaverequestform.php?a=edit&recid=<?php echo $i ?>">
                <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                </td>
                <?php }
                  if($access_file_level['stf_Delete']=="Y")
                  {
                ?>
                <td>
                <a onClick="performdelete('lrf_leaverequestform.php?mode=delete&recid=<?php echo htmlspecialchars($row["lrf_Code"]) ?>'); return false;" href="#">
                <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                </td>
                <?php } ?>
                </tr>
            <?php
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
            <table  align="center"   border="0" cellspacing="1" cellpadding="5"width="50%">
                <tr>
                    <td class="hr">User Name</td>
                    <td class="dr"><?php echo $commonUses->getFirstLastName($row["lrf_StaffCode"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">From</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_From"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">To</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_To"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Reason</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_Reason"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Job Alloted</td>
                    <td class="dr"><?php echo $commonUses->getFirstLastName($row["lrf_JobAlloted"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Notes</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_Notes"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Status</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_Status_Desc"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Created By</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_Createdby"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Created On</td>
                    <td class="dr"><?php echo $commonUses->showGridDateFormat($row["lrf_Createdon"]); ?> </td>
                </tr>
                <tr>
                    <td class="hr">Lastmodified By</td>
                    <td class="dr"><?php echo htmlspecialchars($row["lrf_Lastmodifiedby"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Lastmodified On</td>
                    <td class="dr"><?php    echo $commonUses->showGridDateFormat($row["lrf_Lastmodifiedon"]); ?></td>
                </tr>
            </table>
        <?php } 
        function showroweditor($row, $iseditmode)
        {
            global $commonUses;
            ?>
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
                        <?php }
                        if($_SESSION['usertype']=="Staff")
                        {
                          $sql = "select `stf_Code`, `stf_Login` from `stf_staff` where stf_Code=".$_SESSION['staffcode']." ORDER BY stf_Login ASC";
                          $res = mysql_query($sql) or die(mysql_error());
                          while ($lp_row = mysql_fetch_assoc($res)){
                          ?>
                          <input type="hidden" name="lrf_StaffCode" value="<?php echo $lp_row['stf_Code']?>">
                          <?php
                          }
                        }
                        if($_SESSION['usertype']=="Administrator")
                        {
                        ?>
                        <tr><td>User </td>
                        <td>
                                <select name="lrf_StaffCode"><option value="0">Select User Name</option>
                                <?php
                                      $sql = "select `stf_Code`, `stf_Login` from `stf_staff` ORDER BY stf_Login ASC";
                                      $res = mysql_query($sql) or die(mysql_error());
                                      while ($lp_row = mysql_fetch_assoc($res)){
                                      $val = $lp_row["stf_Code"];
                                      $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                                      if ($row["lrf_StaffCode"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                            if(!$iseditmode)
                                      {
                                      if($_SESSION['staffcode']==$val)   {$selstr_new = " selected"; } else {$selstr_new = ""; }
                                      }
                                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                                <?php } ?>
                                </select>
                        <?php } ?>
                        </td>
                        </tr>
                        <tr>
                            <td class="hr">From<font style="color:red;" size="2">*</font>
                            </td>
                            <td class="dr"><input type="text" name="lrf_From" id="lrf_From" value="<?php if (isset($row["lrf_From"]) && $row["lrf_From"]!="") {
                            $php_lrf_From = strtotime( $row["lrf_From"] );
                            echo date("d/m/Y",$php_lrf_From); } else { echo date("d/m/Y");} ?>">&nbsp;<a href="javascript:NewCal('lrf_From','ddmmyyyy',false,24)"><img
                            src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                        </tr>
                        <tr>
                            <td class="hr">To<font style="color:red;" size="2">*</font>
                            </td>
                            <td class="dr"><input type="text" name="lrf_To" id="lrf_To" value="<?php if (isset($row["lrf_To"]) && $row["lrf_To"]!="") {
                            $php_lrf_To = strtotime( $row["lrf_To"] );
                            echo date("d/m/Y",$php_lrf_To); } else { echo date("d/m/Y");} ?>">&nbsp;<a href="javascript:NewCal('lrf_To','ddmmyyyy',false,24)"><img
                            src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                        </tr>
                        <tr>
                            <td class="hr">Reason<font style="color:red;" size="2">*</font>
                            </td>
                            <td class="dr"><textarea cols="35" rows="4" name="lrf_Reason" maxlength="200"><?php echo str_replace('"', '&quot;', trim($row["lrf_Reason"])) ?></textarea>
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Write reasons to apply the leave .</span></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="hr">Job Alloted</td>
                            <td class="dr">
                                <select name="lrf_JobAlloted"><option value="0">Select User Name</option>
                                    <?php
                                      $sql = "select `stf_Code`, `stf_Login` from `stf_staff` ORDER BY stf_Login ASC";
                                      $res = mysql_query($sql) or die(mysql_error());
                                      while ($lp_row = mysql_fetch_assoc($res)){
                                      $val = $lp_row["stf_Code"];
                                      $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                                      if ($row["lrf_JobAlloted"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                    <?php } ?>
                                </select>
                        </td>
                        </tr>
                        <tr>
                            <td class="hr">Notes</td>
                            <td class="dr"><textarea cols="35" rows="4" name="lrf_Notes"><?php echo str_replace('"', '&quot;', trim($row["lrf_Notes"])) ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="hr">Status</td>
                            <td class="dr">
                             <select name="lrf_Status"><option value="0">Select Leave Request Status</option>
                                <?php
                                  if($_SESSION['usertype']=="Administrator")
                                  {
                                  $sql = "select `lst_Code`, `lst_Description` from `lst_leaverequeststatus` ORDER BY lst_Order ASC";
                                  }
                                  else if($_SESSION['usertype']=="Staff")
                                  {
                                    $sql = "select `lst_Code`, `lst_Description` from `lst_leaverequeststatus` where lst_Description like 'Submitted' ORDER BY lst_Order ASC";
                                  }
                                  $res = mysql_query($sql) or die(mysql_error());
                                  while ($lp_row = mysql_fetch_assoc($res)){
                                  $val = $lp_row["lst_Code"];
                                  $caption = $lp_row["lst_Description"];
                                  if ($row["lrf_Status"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                  if(!$iseditmode)
                                  {
                                  if ( $caption == "Submitted") {$selstr = " selected"; } else {$selstr = ""; }
                                  }
                                 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                <?php } ?>
                             </select>
                             </td>
                        </tr>
                 </table>
        <?php } 
        function showpagenav($page, $pagecount)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a href="lrf_leaverequestform.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="lrf_leaverequestform.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="lrf_leaverequestform.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="lrf_leaverequestform.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
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
                <td><a href="lrf_leaverequestform.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                <?php } if ($recid < $count - 1) { ?>
                <td><a href="lrf_leaverequestform.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
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
            <?php echo $title?> Leave Request Form
            </span>
            <hr size="1" noshade>
        <?php } 
        function addrec()
        {
             ?><br>
            <span class="frmheading">
             Add Record
            </span>
            <hr size="1" noshade><div style="position:absolute; top:150; right:-50px; width:300; height:300;">
            <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
            <form enctype="multipart/form-data" action="lrf_leaverequestform.php" method="post" name="leaverequest" onSubmit="return validateFormOnSubmit()">
            <p><input type="hidden" name="sql" value="insert"></p>
            <?php
            $row = array(
              "lrf_Code" => "",
              "lrf_StaffCode" => "",
              "lrf_From" => "",
              "lrf_To" => "",
              "lrf_Reason" => "",
              "lrf_JobAlloted" => "",
              "lrf_Notes" => "",
              "lrf_Status" => "",
              "lrf_Createdby" => "",
              "lrf_Createdon" => "",
              "lrf_Lastmodifiedby" => "",
              "lrf_Lastmodifiedon" => "");
                $this->showroweditor($row, false);
            ?>
            <input type="submit" name="action" value="Save" class="button"><input type="button" value="Cancel" onClick='javascript:history.back(-1);' class="cancelbutton"/> </form>
        <?php } 
        function viewrec($recid,$access_file_level)
        {
           global $leaverequestDbcontent;
            $res = $leaverequestDbcontent->sql_select();
          // $count = sql_getrecordcount();
           $count = mysql_num_rows($res);
           mysql_data_seek($res, $recid);
           $row = mysql_fetch_assoc($res);
           $this->showrecnav("view", $recid, $count);
        ?>
        <br>
        <?php $this->showrow($row, $recid) ?>
        <br>
        <hr size="1" noshade>
        <table class="bd" border="0" cellspacing="1" cellpadding="4">
        <tr>
        <?php
          if($access_file_level['stf_Add']=="Y")
          {
        ?>
        <td><a href="lrf_leaverequestform.php?a=add" class="hlight">Add Record</a></td>
        <?php } 
          if($access_file_level['stf_Edit']=="Y")
          {
        ?>
        <td><a href="lrf_leaverequestform.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
        <?php } 
          if($access_file_level['stf_Delete']=="Y")
          {
        ?>
        <td><a onClick="performdelete('lrf_leaverequestform.php?mode=delete&recid=<?php echo htmlspecialchars($row["lrf_Code"]) ?>'); return false;" href="#"  class="hlight">Delete Record</a></td>
        <?php } ?>
        </tr>
        </table>
        <?php
          mysql_free_result($res);
        } 
        function editrec($recid)
        {
           global $leaverequestDbcontent;
            $res = $leaverequestDbcontent->sql_select();
          // $count = sql_getrecordcount();
           $count = mysql_num_rows($res);
           mysql_data_seek($res, $recid);
           $row = mysql_fetch_assoc($res);
           $this->showrecnav("edit", $recid, $count);
        ?>
            <div style="position:absolute; top:150; right:-50px; width:300; height:300;">
            <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
            <br>
            <form enctype="multipart/form-data" action="lrf_leaverequestform.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>" method="post" name="leaverequest" onSubmit="return validateFormOnSubmit()">
            <input type="hidden" name="sql" value="update">
            <input type="hidden" name="xlrf_Code" value="<?php echo $row["lrf_Code"] ?>">
            <?php $this->showroweditor($row, true); ?>
            <input type="submit" name="action" value="Update" class="button"> <input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/> </form>
        <?php
          mysql_free_result($res);
        } 

}
	$leaverequestContent = new lrfContentList();

?>

