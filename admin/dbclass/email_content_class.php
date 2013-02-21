<?php
	
class emailContentList extends Database
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
              global $emailDbcontent;
              
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
              $res = $emailDbcontent->sql_select();
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
            <span class="frmheading">Email Options</span>
            <hr size="1" noshade>
            <form action="email_options.php" method="post">
            <table   border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
            <tr>
            <td><b>Custom Filter</b>&nbsp;</td>
            <td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
            <td><select name="filter_field">
            <option value="">All Fields</option>
            <option value="<?php echo "email_order" ?>"<?php if ($filterfield == "email_order") { echo "selected"; } ?>>SNo</option>
            <option value="<?php echo "email_shortname" ?>"<?php if ($filterfield == "email_shortname") { echo "selected"; } ?>>Name</option>
            <option value="<?php echo "email_name" ?>"<?php if ($filterfield == "email_name") { echo "selected"; } ?>>Event of the Email</option>
            <option value="<?php echo "email_value" ?>"<?php if ($filterfield == "email_value") { echo "selected"; } ?>>Email Address</option>
            </select>
            </td>
            <td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
            </td></tr>
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="action" value="Apply Filter"></td>
            <td><a href="email_options.php?a=reset"  class="hlight">Reset Filter</a></td>
            <td><a href="javascript: window.open ('email_options_excel.php','mywindow','menubar=1,resizable=1,width=350,height=250')"><img src="images/excel2.png" /></a></td>
            <td><a href="email_options_pdf.php"><img src="images/pdf_icon.gif" /></a></td>
            </tr>
            </table>
            </form>
             <p>&nbsp;</p>
            <br><br>
            <table class="fieldtable_outer" align="center">
                <tr>
                    <td>
                        <?php
                          if($access_file_level['stf_Add']=="Y")
                          {
                        ?>
                        <a href="email_options.php?a=add" class="hlight"  ><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
                        <?php }
                        $this->showpagenav($page, $pagecount); ?><br>
                        <br>
                        <table  class="fieldtable" cellspacing="1" cellpadding="5" align="center"  >
                            <tr  class="fieldheader">
                                <th><a   href="email_options.php?order=<?php echo "email_order" ?>&type=<?php echo $ordtypestr ?>">SNo</a></th>
                                <th nowrap style="width:300px;"><a   href="email_options.php?order=<?php echo "email_shortname" ?>&type=<?php echo $ordtypestr ?>">Name</a></th>
                                <th nowrap style="width:300px;"><a   href="email_options.php?order=<?php echo "email_name" ?>&type=<?php echo $ordtypestr ?>">Event when email will be sent automatically</a></th>
                                <th><a   href="email_options.php?order=<?php echo "email_value" ?>&type=<?php echo $ordtypestr ?>">Email Address</a></th>
                                <th nowrap style="width:400px;">Email Address / Description</th>
                                <th nowrap style="width:400px;">Content of the Email</th>
                                 <th colspan="3" align="center">Actions</th>
                                </tr>
                                <?php
                                  for ($i = $startrec; $i < $reccount; $i++)
                                  {
                                    $row = mysql_fetch_assoc($res);
                                 ?>
                                <tr>
                                <td class="<?php echo $style ?>">
                                    <?php  echo $row["email_order"]; ?>
                                </td>
                                <td class="<?php echo $style ?>">
                                    <?php echo htmlspecialchars($row["email_shortname"]); ?>
                                </td>
                                <td class="<?php echo $style ?>">
                                    <?php echo htmlspecialchars($row["email_name"]); ?>
                                </td>
                                <td class="<?php echo $style ?>" >
                                    <?php echo htmlspecialchars($row["email_value"]); ?>
                                </td>
                                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["email_comments"]) ?></td>
                                <td class="<?php echo $style ?>"><?php echo html_entity_decode($row["email_content"]) ?></td>
                                 <?php
                                  if($access_file_level['stf_View']=="Y")
                                          {
                                ?>
                                <td class="<?php echo $style ?>"><a href="email_options.php?a=view&recid=<?php echo $i ?>"><img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a></td>
                                <?php } ?>
                                <?php
                                  if($access_file_level['stf_Edit']=="Y")
                                          {
                                ?>
                                <td class="<?php echo $style ?>"><a href="email_options.php?a=edit&recid=<?php echo $i ?>"><img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a></td>
                                <?php } ?>
                                <?php
                                  if($access_file_level['stf_Delete']=="Y")
                                          {
                                ?>
                                <td class="<?php echo $style ?>"><a href="email_options.php?mode=delete&recid=<?php echo htmlspecialchars($row["email_id"]) ?>"> <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a></td>
                                <?php } ?>
                            </tr>
                            <?php
                              }
                              mysql_free_result($res);
                            ?>
                        </table>
                    <br>
                    </td>
                </tr>
            </table>
        <?php }
        function showrow($row, $recid)
        {
            ?>
            <table class="tbl" border="0" cellspacing="1" cellpadding="5" width="70%" align="center">
                <tr>
                    <td class="hr">Name</td>
                    <td class="dr"><?php echo htmlspecialchars($row["email_shortname"]); ?></td>
                </tr>
                <tr>
                    <td class="hr">Event when email will be sent automatically</td>
                    <td class="dr"><?php echo htmlspecialchars($row["email_name"]); ?></td>
                </tr>
                <tr>
                    <td class="hr">Email Address</td>
                    <td class="dr"><?php echo htmlspecialchars($row["email_value"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Email Address / Description</td>
                    <td class="dr"><?php echo htmlspecialchars($row["email_comments"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Template</td>
                    <td class="dr"><?php echo html_entity_decode($row["email_template"]) ?></td>
                </tr>
                <tr>
                    <td class="hr">Content of the Email</td>
                    <td class="dr"><?php echo html_entity_decode($row["email_content"]) ?></td>
                </tr>
            </table>
       <?php }
       function showroweditor($row, $iseditmode)
       {
           $qry = "SELECT MAX(email_order) AS max_order FROM email_options";
           $result = mysql_query($qry);
           $row_mail = mysql_fetch_array($result);
           $max_order = $row_mail['max_order'];
           ?>
            <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="800px">
                <?php
                if(!$iseditmode) {
                ?>
                <tr>
                    <td class="hr">Id</td>
                    <td class="dr"><?php   echo "New"; ?>
                        <input type="hidden" name="email_order" value="<?php echo $max_order+1; ?>"/>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="hr">Name<font style="color:red;" size="2">*</font></td>
                    <td class="dr">
                    <textarea rows="3" cols="30" name="email_shortname"><?php echo str_replace('"', '&quot;', trim($row["email_shortname"])); ?></textarea>
                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of the Mail template.</span></a>
                    </td>
                </tr>
                <tr>
                    <td class="hr">Event when email will be sent automatically</td>
                    <td class="dr">
                    <textarea rows="3" cols="30" name="email_name"><?php echo str_replace('"', '&quot;', trim($row["email_name"])); ?></textarea>
                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Notes of when email will be sent automatically.</span></a>
                    </td>
                </tr>
                <tr>
                    <td class="hr" nowrap>Email Address<font style="color:red;" size="2">*</font></td>
                    <td class="dr">
                        <textarea rows="3" cols="30" name="email_value"><?php echo str_replace('"', '&quot;', trim($row["email_value"])) ?></textarea>
                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Enter one or More than one comma separated <b>( , )</b> valid email address.</span></a>
                    </td>
                </tr>
                <tr>
                    <td class="hr" nowrap>Email Address / Description</td>
                    <td class="dr">
                        <textarea rows="8" cols="60" name="email_comments"><?php echo str_replace('"', '&quot;', trim($row["email_comments"])) ?></textarea>
                    </td>
                </tr>
                <?php
                if(!$iseditmode) {
                ?>
                <tr>
                    <td class="hr">Template<font style="color:red;" size="2">*</font></td>
                    <td class="dr"><textarea cols="35" rows="4" style="width:800px; height:200px;" name="email_template" maxlength="65535"><?php echo str_replace('"', '&quot;', trim($row["email_template"])) ?></textarea>
                    </td>
                    <td>
                    <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Enter the mail content.</span></a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php }
        function showpagenav($page, $pagecount)
        {
        ?>
            <table  border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a href="email_options.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="email_options.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="email_options.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="email_options.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }
        function showrecnav($a, $recid, $count)
        {
        ?>
            <table class="bd" border="0" cellspacing="1" cellpadding="4" align="right">
                <tr>
                    <?php if ($recid > 0) { ?>
                    <td><a href="email_options.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                    <?php } if ($recid < $count - 1) { ?>
                    <td><a href="email_options.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
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
        <?php echo $title?> Email Options
        </span>
        <hr size="1" noshade>
        <?php }
        function addrec()
        {
        ?>
            <br>
            <span class="frmheading">
             Add Record
            </span><hr size="1" noshade>
            <form enctype="multipart/form-data" action="email_options.php" method="post" name="emailoptions" onSubmit="return validateFormOnSubmit()">
            <p><input type="hidden" name="sql" value="insert"></p>
            <?php
            $row = array(
              "email_id" => "",
              "email_name" => "",
              "email_value" => "",
              "email_template" => "");
            $this->showroweditor($row, false);
            ?>
            <input type="submit" name="action" value="Save" class="button"><input type="button" value="Cancel" onClick='javascript:history.back(-1);' class="cancelbutton"/></form>
            </form>
        <?php }
        function viewrec($recid,$access_file_level)
        {
          global $emailDbcontent;
            $res = $emailDbcontent->sql_select();
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
                    <td><a href="email_options.php?a=add" class="hlight">Add Record</a></td>
                    <?php } ?>
                    <?php
                    if($access_file_level['stf_Edit']=="Y")
                     {
                    ?>
                    <td><a href="email_options.php?a=edit&recid=<?php echo $recid ?>" class="hlight">Edit Record</a></td>
                    <?php } ?>
                    <?php
                    if($access_file_level['stf_Delete']=="Y")
                     {
                    ?>
                    <td><a href="email_options.php?mode=delete&recid=<?php echo $row['email_id'] ?>" class="hlight">Delete Record</a></td>
                    <?php } ?>
                </tr>
            </table>
        <?php
          mysql_free_result($res);
        }
        function editrec($recid)
        {
            global $emailDbcontent;

            $res = $emailDbcontent->sql_select();
             // $count = sql_getrecordcount();
              $count = mysql_num_rows($res);
              mysql_data_seek($res, $recid);
              $row = mysql_fetch_assoc($res);
              $this->showrecnav("edit", $recid, $count);
            ?>
            <br>
            <form enctype="multipart/form-data" action="email_options.php?a=edit&recid=<?php echo $_GET['recid']?>" method="post"  name="emailoptions" onSubmit="return validateFormOnSubmit()">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="xemail_id" value="<?php echo $row["email_id"] ?>">
                <?php $this->showroweditor($row, true); ?>
                <input type="submit" name="action" value="Update" class="button" style="margin-left:500px;">
                <input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton" />
            </form>
            <?php
              mysql_free_result($res);
        }

}
	$emailContent = new emailContentList();

?>

