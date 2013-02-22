<?php
class CrossSales extends Database
{
             function select()
              {
                        global $a;
                        global $showrecs;
                        global $page;
                        global $filter;
                        global $filterfield;
                        global $wholeonly;
                        global $order;
                        global $ordtype;
                        global $access_file_level;
                        global $CrossDbcontent;
                      if ($a == "reset") {
                            $filter = "";
                            $filterfield = "";
                            $wholeonly = "";
                            $order = "";
                            $ordtype = "";
                            $_SESSION["filter"] = "";
                            $_SESSION["order"] = "";
                            $_SESSION["type"] = "";
                            $_SESSION["filter_field"] = "";
                      }
                      $checkstr = "";
                      if ($wholeonly) $checkstr = " checked";
                      if ($ordtype == "asc") { $ordtypestr = "desc"; } else { $ordtypestr = "asc"; }
                      $count = 0;
                      $res = $CrossDbcontent->sql_select(&$count);
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
                   <div class="frmheading">
						<h1>Cross Sales Opportunity</h1>
				   </div>
                    <form action="cso_cross_sales_opportunity.php" method="post">
                        <table class="customFilter" width="50%" align="right" border="0" cellspacing="1" cellpadding="4" style="margin-right:0px;">
                            <tr>
                                <td><b>Custom Filter</b>&nbsp;</td>
                                <td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
                                <td>
                                    <select name="filter_field">
                                                    <option value="">All Fields</option>
                                                    <option value="cso_client_name" <?php if ($filterfield == "cso_client_name") { echo "selected"; } ?>>Company Name</option>
                                                    <option value="lp_cli_Stage" <?php if ($filterfield == "lp_cli_Stage") { echo "selected"; } ?>>Stage</option>
                                                    <option value="cli_lead_status" <?php if ($filterfield == "cli_lead_status") { echo "selected"; } ?>>Lead Status</option>
                                                    <option value="cso_lead_person" <?php if ($filterfield == "cso_lead_person") { echo "selected"; } ?>>Who generated lead</option>
                                                    <option value="lp_cli_MOC" <?php if ($filterfield == "lp_cli_MOC") { echo "selected"; } ?>>Method of contact</option>
                                                    <option value="lp_cli_Salesperson" <?php if ($filterfield == "lp_cli_Salesperson") { echo "selected"; } ?>>Sales staff</option>
                                   </select>
                                </td>
                                <td><input class="checkboxClass" type="checkbox" name="wholeonly"<?php echo $checkstr ?>>whole words</td>
                            </tr>
                            <tr>
                                  <td>&nbsp;</td>
                                  <td><button type="submit" name="action" id="applyFilter" value="Apply Filter">Apply Filter</button></td>
                                  <td><a href="cso_cross_sales_opportunity.php?a=reset" class="hlight">Reset Filter</a></td>
                            </tr>
                        </table>
                    </form>
                    <p>&nbsp;</p>
                    <br><br><br>
                                <?php
                                        $sql = "SHOW TABLE STATUS LIKE 'cso_cross_sales_opportunity'";
                                        $result = mysql_query($sql);
                                        $row = mysql_fetch_array($result);
                                        $next_id = $row['Auto_increment'];

                                        if($access_file_level['stf_Add']=="Y" || $access_file_level_lead['stf_View']=="Y" || $access_file_level_consigned['stf_View']=="Y" || $access_file_level_discontinued['stf_View']=="Y")
                                        {
                                 ?>
                                                <a href="cso_cross_sales_opportunity.php?a=add&recid=<?php echo $next_id;?>" class="hlight">
                                                    <img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record
                                                </a>
                                 <?php   } ?>
                                <?php   $this->showpagenav($page, $pagecount); ?>
	                          <table class="fieldtable" align="center" width="100%">
                                      <tr class="fieldheader">
                                            <th nowrap style="width:180px;"><a  href="cso_cross_sales_opportunity.php?order=<?php echo "cso_client_name" ?>&type=<?php echo $ordtypestr ?>">Client Name</a></th>
                                            <th nowrap style="width:180px;"><a  href="cso_cross_sales_opportunity.php?order=<?php echo "cso_date_received" ?>&type=<?php echo $ordtypestr ?>">Date Received</a></th>
                                            <th><a  href="cso_cross_sales_opportunity.php?order=<?php echo "cli_lead_status" ?>&type=<?php echo $ordtypestr ?>">Lead Status</a></th>
                                            <th><a  href="cso_cross_sales_opportunity.php?order=<?php echo "lp_cli_Stage" ?>&type=<?php echo $ordtypestr ?>">Stage</a></th>
                                            <th><a  href="cso_cross_sales_opportunity.php?order=<?php echo "cso_notes" ?>&type=<?php echo $ordtypestr ?>">Notes</a></th>
                                            <th nowrap style="width:180px;"><a  href="cso_cross_sales_opportunity.php?order=<?php echo "cso_last_contact_date" ?>&type=<?php echo $ordtypestr ?>">Last date of contact</a></th>
                                            <th nowrap style="width:180px;"><a  href="cso_cross_sales_opportunity.php?order=<?php echo "cso_future_contact_date" ?>&type=<?php echo $ordtypestr ?>">Future contact date</a></th>
                                            <th colspan="4" align="center">Actions</th>
                                        </tr> 
                                        <form name="cso_sales" id="cso_sales" method="post" action="">
                                        <?php
                                          for ($i = $startrec; $i < $reccount; $i++)
                                          {
                                                        $row = mysql_fetch_assoc($res);
                                                        //Inline stage edit
                                                        if($_GET['page']!="")
                                                        $addquery="?page=".$_GET['page'];
                                                        if($_GET['order']!="" && $_GET['type']!="")
                                                        $addquery="?order=".$_GET['order']."&type=".$_GET['type'];
                                                        $current_date = date( 'Y-m-d' );
                                                        $cliCode = $row["id"];
                                                ?>
                                                    <tr>
                                                        <td><?php echo stripslashes($row["cso_client_name"]); ?></td>
                                                                <td>
                                                                    <input type="text" name="cso_date_received[<?php echo $cliCode; ?>]" id="cso_date_received<?php echo $i;?>" value="<?php  if (isset($row["cso_date_received"]) && $row["cso_date_received"]!="") {
                                                                     if($row["cso_date_received"]!="0000-00-00 00:00:00")
                                                                     $php_dateReceived = date("d/m/Y",strtotime( $row["cso_date_received"] ));
                                                                     else
                                                                     $php_dateReceived="";
                                                                     echo  $php_dateReceived ; }  ?>"/>&nbsp;<a href="javascript:NewCal('cso_date_received<?php echo $i;?>','ddmmyyyy',false,24)"><img
                                                                     src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                                </td>
                                                            <td>
                                                                        <select name="cso_lead_status[<?php echo $cliCode; ?>]"><option value="0">Select Status</option>
                                                                            <?php
                                                                                $sql_stage = "select `cls_Code`, `cls_Description` from `cls_clientleadstatus` ORDER BY cls_Order ASC";
                                                                                $res_stage = mysql_query($sql_stage) or die(mysql_error());

                                                                                while ($lp_row = mysql_fetch_assoc($res_stage)){
                                                                                $val = $lp_row["cls_Code"];
                                                                                $caption = $lp_row["cls_Description"];
                                                                                if ($row["cso_lead_status"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                                ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                                                                <?php }  ?>
                                                                        </select>
                                                            </td>
                                                            <td>
                                                                        <select name="cso_stage[<?php echo $cliCode; ?>]"><option value="0">Select Stage</option>
                                                                            <?php
                                                                                $sql_stage = "select `cst_Code`, `cst_Description` from `cst_clientstatus` ORDER BY cst_Order ASC";
                                                                                $res_stage = mysql_query($sql_stage) or die(mysql_error());
                                                                                while ($lp_row = mysql_fetch_assoc($res_stage)){
                                                                                $val = $lp_row["cst_Code"];
                                                                                $caption = $lp_row["cst_Description"];
                                                                                if ($row["cso_stage"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                                ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                                                                <?php } ?>
                                                                        </select>
                                                            </td>
                                                            <td>
                                                                <textarea name="cso_notes[<?php echo $cliCode; ?>]"><?php echo $row["cso_notes"]; ?></textarea>
                                                            </td>
                                                            <td>
                                                                        <input type="text" name="cso_last_contact_date[<?php echo $cliCode; ?>]" id="cso_last_contact_date<?php echo $i;?>" value="<?php  if (isset($row["cso_last_contact_date"]) && $row["cso_last_contact_date"]!="") {
                                                                        if($row["cso_last_contact_date"]!="0000-00-00")
                                                                        $php_Dateto = date("d/m/Y",strtotime( $row["cso_last_contact_date"] ));
                                                                        else
                                                                        $php_Dateto="";
                                                                        echo  $php_Dateto ; }  ?>"/>&nbsp;<a href="javascript:NewCal('cso_last_contact_date<?php echo $i;?>','ddmmyyyy',false,24)"><img
                                                                        src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"/></a>
                                                            </td>
                                                            <td>
                                                                        <input type="text" name="cso_future_contact_date[<?php echo $cliCode; ?>]" id="cso_future_contact_date<?php echo $i;?>" value="<?php  if (isset($row["cso_future_contact_date"]) && $row["cso_future_contact_date"]!="") {
                                                                        if($row["cso_future_contact_date"]!="0000-00-00")
                                                                        $php_Dateto = date("d/m/Y",strtotime( $row["cso_future_contact_date"] ));
                                                                        else
                                                                        $php_Dateto="";
                                                                        echo  $php_Dateto ; }  ?>"/>&nbsp;<a href="javascript:NewCal('cso_future_contact_date<?php echo $i;?>','ddmmyyyy',false,24)"><img
                                                                        src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"/></a>
                                                           </td>
                                                            <?php
                                                              if($access_file_level['stf_Edit']=="Y")
                                                               {
                                                            ?>
                                                                <td style="background-color:white;">
                                                                    <img src="images/save.png" border="0"  alt="Edit" name="Edit" title="Save" align="middle" onClick="saveClick('<?php echo $addquery; ?>','<?php echo $row[id]; ?>');" />
                                                                </td>
                                                            <?php
                                                               }
                                                             if($access_file_level['stf_View']=="Y")
                                                            {
                                                            ?>
                                                            <td>
                                                                <a href="cso_cross_sales_opportunity.php?a=view&recid=<?php echo $i ?>&cli_code=<?php echo $row["id"]; ?>">
                                                                <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                                                            </td>
                                                            <?php } ?>
                                                            <?php
                                                              if($access_file_level['stf_Edit']=="Y")
                                                               {
                                                            ?>
                                                            <td>
                                                                <a href="cso_cross_sales_opportunity.php?a=edit&recid=<?php echo $i ?>&cli_code=<?php echo $row["id"]; ?>&page=1">
                                                                <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                                                            </td>
                                                            <?php } ?>
                                                            <?php
                                                              if($access_file_level['stf_Delete']=="Y")
                                                              {
                                                            ?>
                                                            <td>
                                                                <a onClick="performdelete('cso_cross_sales_opportunity.php?mode=delete&recid=<?php echo stripslashes($row["id"]) ?>'); return false;" href="#">
                                                                <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                                                            </td>
                                                            <?php } ?>
                                </tr>
                                                        <?php
                                           }
                                                  mysql_free_result($res);
                                                ?>
                                 </form> 
                    </table>
                                <?php $this->showpagenav($page, $pagecount); ?>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <?php
              }
              // client record view content
             function showrow($row, $recid)
             {
                        $cli_code=$_REQUEST['id'];
                        //Client type access global variable
                        global $access_file_level;
                        global $CrossDbcontent;
                        global $commonUses;
              ?>
                        <table class="tbl" border="0" cellspacing="12" width="100%">
                            <tr>
                                <td width="100% valign="top">
                                    <div class="frmheading">
										<h1>View Record</h1>
									</div>
                                             <table class="tbl" border="0" cellspacing="12" width="40%">
                                                   <tr>
                                                        <td ><strong>Company Name</strong></td>
                                                        <td ><?php echo stripslashes($row["cso_client_name"]) ?></td>
                                                    </tr>
                                                 <!--  <tr>
                                                        <td ><strong>Group Entity</strong></td>
                                                        <td ><?php echo stripslashes($row["cso_entity_name"]) ?></td>
                                                    </tr> -->
                                                   <tr>
                                                        <td ><strong>Name of Contact</strong></td>
                                                        <td ><?php echo stripslashes($row["cso_contact_name"]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Date Received</strong></td>
                                                        <td ><?php echo date("d/M/Y", strtotime($row["cso_date_received"])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Day Received</strong></td>
                                                        <td ><?php echo stripslashes($row["cso_day_received"]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Cross Sale Service Required</strong></td>
                                                        <td>
                                                        <?php
                                                            $ser_query = "SELECT cli_ClientCode,cli_ServiceRequiredCode FROM `cli_allservicerequired` where `cli_ClientCode`=".$row['cso_client_code']." AND cli_Form='Sales Opportunity'";
                                                            $cli_serclicode = mysql_query($ser_query);
                                                           while($service_required = mysql_fetch_array($cli_serclicode))
                                                           {
                                                                $svr_query = "SELECT c1.`cli_ServiceRequiredCode`, s1.`svr_Description` FROM `cli_allservicerequired` AS c1 LEFT OUTER JOIN `cli_servicerequired` AS s1 ON (c1.`cli_ServiceRequiredCode` = s1.`svr_Code`) where `cli_ServiceRequiredCode`=".$service_required['cli_ServiceRequiredCode'];
                                                                $cli_service = mysql_query($svr_query);
                                                                $service_name = @mysql_fetch_array($cli_service);
                                                                $servicename .= $service_name["svr_Description"].",";
                                                            }
                                                                echo substr($servicename,0,-1);
                                                    ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td ><strong>Stage</strong></td>
                                                        <td ><?php echo stripslashes($row["lp_cli_Stage"]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Cross Sales Lead Status</strong></td>
                                                        <td ><?php echo $row["cli_lead_status"]; ?></td>
                                                    </tr>
                                                    <tr>
                                                    <td ><strong>Source</strong></td>
                                                        <td ><?php echo stripslashes($row["source_name"]) ?></td>
                                                    </tr>
                                                   <tr>
                                                        <td ><strong>Name of Employee who generated lead</strong></td>
                                                        <td ><?php echo stripslashes($row["cso_lead_person"]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Method of Contact</strong></td>
                                                        <td ><?php echo stripslashes($row["lp_cli_MOC"]) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Cross Sales Staff</strong></td>
                                                        <td ><?php echo $row['lp_cli_Salesperson']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Last Contact Date</strong></td>
                                                        <td ><?php echo $commonUses->showGridDateFormat($row["cso_last_contact_date"]); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Future Contact Date</strong></td>
                                                        <td ><?php echo $commonUses->showGridDateFormat($row["cso_future_contact_date"]); ?></td>
                                                    </tr>
                                                    <tr>
                                                    <td ><strong>Notes</strong></td>
                                                        <td ><?php echo stripslashes($row["cso_notes"]) ?></td>
                                                    </tr>
                                                    
                                                </table>
                                        <!-- client contact details end -->
                                          <?php
                                              echo "<span class='footer' style='font-size:96%;'>Created by: ".$commonUses->getFirstLastName($row["cso_created_by"])." | ". "Created on: ".$commonUses->showGridDateFormat($row["cso_created_date"])." | ". "Lastmodified by: ".$commonUses->getFirstLastName($row["cso_modified_by"])." | ". "Lastmodified on: ".$commonUses->showGridDateFormat($row["cso_modified_date"])."</span>";
                                          ?>
                                </td>
                           </tr>
                       </table>
        <?php
        }
        // page navigation
        function showpagenav($page, $pagecount)
        {
            global $pagerange;
       ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a onClick="saveConfirm('<?php echo $page - 1; ?>')" href="javascript:;" ><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
                    <?php } 
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
                                    <?php
                                    }
                                    else {
                                        ?>
                                            <td ><a onClick="saveConfirm('<?php echo $j; ?>')" href="javascript:;"><span class="nav_links"><?php echo $j ?></span></a></td>
                                    <?php
                                    }
                                }
                            }
                            else { ?>
                                <td><a onClick="saveConfirm('<?php echo $startpage; ?>')" href="javascript:;" ><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                                <?php } } } ?>
                                <?php if ($page < $pagecount) { ?>
                                <td>&nbsp;<a onClick="saveConfirm('<?php echo $page + 1; ?>')" href="javascript:;" ><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                                <?php } ?>
                </tr>
            </table>
        <?php
        }
        // record navigation
        function showrecnav($a, $recid, $count)
        {
                if($a!="view")
                {
                      $res = sql_select();
                     // $count = sql_getrecordcount();
                      mysql_data_seek($res, $recid);
                      $row = mysql_fetch_assoc($res);
                    ?>
                    <table border="0" cellspacing="1" cellpadding="4" align="right">
                        <tr>
                             <?php if ($recid > 0) { ?>
                            <td><a href="cso_cross_sales_opportunity.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                            <?php } if ($recid < $count - 1) { ?>
                            <td><a href="cso_cross_sales_opportunity.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
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
                        <?php echo $title." Sales Opportunity"; ?>
                    </span>
                    <hr size="1" noshade>
        <?php }
            
        }
        function addrec()
        {
                $_SESSION['filter']="";
                $_SESSION['filter_field']="";
                $_SESSION['order']="";
                $_SESSION['type']="";
            ?><br>
            <div class="frmheading">
				<h1>Add Record</h1>
			</div>
            <div style="position:absolute; top:20; right:-90px; width:300; height:300;">
                <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
            </div>
            <form enctype="multipart/form-data" action="cso_cross_sales_opportunity.php?a=reset" method="post" name="salesOpp" onSubmit="return validateSales()">
                <?php
                $row = array(
                  "id" => "",
                  "cso_client_code" => "",
                  "cso_contact_code" => "",
                  "cso_entity" => "",
                  "cso_date_received" => "",
                  "cso_day_received" => "",
                  "cso_service_required" => "",
                  "cso_lead_status" => "",
                  "cso_stage" => "",
                  "cso_generated_lead" => "",
                  "cso_method_of_contact" => "",
                  "cso_sales_person" => "",
                  "cso_last_contact_date" => "",
                  "cso_future_contact_date" => "",
                  "cso_created_by" => "",
                  "cso_created_date" => "",
                  "cso_modified_by" => "",
                  "cso_modified_date" => "");
                    $this->editrow($row, false);
                ?>
                <br>
                <input type="hidden" name="sql" value="insert" id="insert"> <input type="hidden" name="recid" value="<?php echo $_GET['recid']?>" id="recid">
				<button type="button" value="Cancel" onClick="javascript:history.back(-1);" class="cancelbutton">Cancel</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="submit" name="action" value="Save" class="button">Save</button>
            </form>
                    <br><br>
                         <?php
         }
         // edit row
        function editrec()
        {
                global $access_file_level;
                global $CrossDbcontent;
                global $commonUses;

                   $res = $CrossDbcontent->sql_select();
                      $count = 0;
                      $res = $CrossDbcontent->sql_select(&$count);
                  $row = mysql_fetch_assoc($res);
            
            ?><br>
           <div class="frmheading">
				<h1>Edit Record</h1>
			</div>
            <div style="position:absolute; top:20; right:-90px; width:300; height:300;">
                <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font>
            </div>
            <form enctype="multipart/form-data" action="cso_cross_sales_opportunity.php?a=<?php echo $_GET['a']?>&recid=<?php echo $_GET['recid']?>&cli_code=<?php echo $_GET['cli_code']?>" method="post" name="salesForm" id="salesForm" onSubmit="return validateSales()">
                <?php
                    $this->editrow($row, true);
                ?>
                        <input type="hidden" name="sql" value="update">
                        <input type="hidden" name="xcli_Code" value="<?php echo $row["id"] ?>">
                        <input type="hidden" name="recid" value="<?php echo $_GET["recid"] ?>">
                
			 		 	<button type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton">Cancel</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				        <button type="submit" name="action" id="action" value="Update" class="button">Update</button>
            </form>
                    <br>
                         <?php
         }
         // client view record content
        function viewrec($recid)
        {
                        global $access_file_level;
                        global $CrossDbcontent;
                        global $commonUses;

                          $res = $CrossDbcontent->sql_select();
                          $count = 0;
                          $res = $CrossDbcontent->sql_select(&$count);
                          mysql_data_seek($res, $recid);
                          $row = mysql_fetch_assoc($res);
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
            <td><a href="cso_cross_sales_opportunity.php?a=add" class="hlight">Add Record</a></td>
            <?php }
              if($access_file_level['stf_Edit']=="Y")
              {
            ?>
            <td><a href="cso_cross_sales_opportunity.php?a=edit&recid=<?php echo $i ?>&cli_code=<?php echo $row["id"]; ?>&page=1" class="hlight">Edit Record</a></td><?php } ?>
            <?php
              if($access_file_level['stf_Delete']=="Y")
              {
            ?>

            <td><a onClick="performdelete('cso_cross_sales_opportunity.php?mode=delete&recid=<?php echo stripslashes($row["id"]) ?>'); return false;" href="#" class="hlight">Delete Record</a></td>
            <?php }?>
            </tr>
            </table>
            <div class="frmheading">
				<h1></h1>
			</div>
                    <?php
                        mysql_free_result($res);
        }
        //client record editor content
        function editrow($row,$iseditmode)
        {
                global $access_file_level;
                global $CrossDbcontent;
                global $commonUses;

                $cli_id = $row['cso_client_code'];
                $contact_id = $row['cso_contact_code'];
                $entity_id = $row['cso_entity'];
                ?>
                        <table class="tbl" border="0" cellspacing="1" cellpadding="5" width="100%">
                            <tr>
                                <td>
                                                <table class="tbl" border="0" cellspacing="10" width="70%">
                                                    <tr>
                                                        <td><strong>Company Name</strong><font style="color:red;" size="2">*</font></td>
                                                        <td class="dr">
                                                        <?php
                                                        if($row["cso_client_code"]!="")
                                                        {
                                                           $sql = "select client_id AS cli_Code, client_name AS name from client where client_id=".$row["cso_client_code"]." ORDER BY client_name ASC";
                                                           $res = mysql_query($sql) or die(mysql_error());
                                                           $companyname=@mysql_result( $res,0,'name');
                                                          }
                                                        ?>
                                                                <input type="hidden" id="cso_client_code" name="cso_client_code" value="" />
                                                                <input type="hidden" id="cso_client_code" name="cso_Company_old" value="<?php echo $row["cso_client_code"];?>"/>
                                                                <input style="width: 200px" type="text" name="comp_name" id="comp_name" value="<?php echo $companyname?>"   onBlur="checkKeycode(event);"/>
                                                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Start typing to view existing clients. On selecting client/company name, Contact and entity will be populated automatically based on the Client record.</span></a>
                                                        <script type="text/javascript">
                                                                var options = {
                                                                        script:"dbclass/wrk_client_db_class.php?json=true&limit=6&",
                                                                        varname:"input",
                                                                        json:true,
                                                                        shownoresults:false,
                                                                        maxresults:6,
                                                                        callback: function (obj) { 
                                                                            document.getElementById('cso_client_code').value = obj.id; 
                                                                            showContact(obj.id,'','');
                                                                        }
                                                                };
                                                                var as_json = new bsn.AutoSuggest('comp_name', options);


                                                                var options_xml = {
                                                                        script: function (input) { return "dbclass/wrk_client_db_class.php?input="+input+"&con_Company="+document.getElementById('cso_client_code').value; },
                                                                        varname:"input"
                                                                };
                                                                var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
                                                        </script>
                                                        </td>
                                                    </tr>
                                                 <!--   <tr>
                                                        <td><strong>Group Entity</strong><font style="color:red;" size="2">*</font></td>
                                                        <td class="dr">
                                                            <div id="cso_entity_type"><font style="font-size:10px;">On selecting company name, Entity will be populated automatically</font></div>
                                                        </td>
                                                    </tr> -->
                                                    <tr>
                                                        <td><strong>Name of Contact</strong></td>
                                                        <td class="dr">
                                                            <div id="cso_contact"><font style="font-size:10px;">On selecting company name, Contact will be populated automatically</font></div>
                                                            <?php
                                                            if($iseditmode) {
                                                                echo "<script>showContact('$cli_id','$contact_id','$entity_id')</script>";
                                                            }
                                                            ?>
                                                            <span id="add_contact" style="display:none;"><a href="javascript: contactForm()">Add Contact</a></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Date Received</strong><font style="color:red;" size="2">*</font>
                                                        </td>
                                                        <td class="dr"><input type="text" name="cso_date_received" id="cso_date_received" value="<?php if (isset($row["cso_date_received"]) && $row["cso_date_received"]!="") {
                                                                if($row["cso_date_received"]!="0000-00-00")
                                                                    $php_cli_DateReceived = date("d/m/Y",strtotime( $row["cso_date_received"] ));
                                                                    echo $php_cli_DateReceived;
                                                                } ?>" onBlur="showDay()">&nbsp;<a href="javascript:NewCal('cso_date_received','ddmmyyyy',false,24)"><img

                                                                src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Client Received date.  Day Received field is populated automatically based on this date.</span></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td ><strong>Day Received</strong></td>
                                                        <?php
                                                        if($row["cso_day_received"]!="")
                                                        {
                                                         ?>
                                                        <td id="dayhide">
                                                            <?php
                                                             echo $row["cso_day_received"];
                                                             ?>
                                                        </td>
                                                        <?php
                                                        }
                                                        ?>
                                                        <td>
                                                            <label id="cli_DayReceived"></label>
                                                            <input type="hidden" id="cli_DayHide" name="cso_day_received" value="<?php echo $row["cso_day_received"] ?>"/>
                                                        </td>
                                                    </tr>
                                                  <tr>
                                                    <td nowrap><strong>Cross Sale Service Required</strong><font style="color:red;" size="2">*</font>
                                                    </td>
                                                    <td >
							 <?php
								 $sales_qry = "select `svr_Code`, `svr_Description` from `cli_servicerequired` ORDER BY svr_Order ASC";
								  $sales_result = mysql_query($sales_qry);
								  $sales_cont = "";
								  $no = 0;
								  $output_array = array();
								  while(list($id,$display) = mysql_fetch_array($sales_result))
								  {
										$output_array[$no]['svr_Code'] = $id;
										$output_array[$no]['svr_Description'] = $display;
										$no++;
								  }
								  
								  for($j=0;$j<count($output_array);$j++)
								  {
									 $id = $output_array[$j]['svr_Code'];
									 $display = $output_array[$j]['svr_Description'];
										//$selected = $CrossDbcontent->multiServiceSelect($id,$row['cso_client_code']);
										$selected = '';
										if($id == $row['cso_client_code'])
											$selected = 'selected';
										
										$sales_cont .= "<option value='$id' $selected >".$display. "</option>";
								  }
										?><select name="cso_service_required" id="cso_service_required" class="multiservice" multiple="multiple">
                                                            <?php echo $sales_cont; ?>
                                                        </select> <a class="tooltip" href="#" style="position:relative; left:0px;"><img src="images/help.png"><span class="help">Select the Service's required for the client. Click <b>+</b> on services on the right to select</span></a>
														</td>

                                                 </tr>
                                                               <tr>
                                                                    <td ><strong>Stage</strong><font style="color:red;" size="2">*</font></td>
                                                                    <td ><select name="cso_stage" id="cso_stage"><option value="0">Select Stage</option>
                                                                        <?php
                                                                          $sql = "select `cst_Code`, `cst_Description` from `cst_clientstatus` ORDER BY cst_Order ASC";
                                                                          $res = mysql_query($sql) or die(mysql_error());

                                                                          while ($lp_row = mysql_fetch_assoc($res)){
                                                                          $val = $lp_row["cst_Code"];
                                                                          $caption = $lp_row["cst_Description"];
                                                                          if ($row["cso_stage"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                                                        <?php } ?></select>
                                                                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help"> Lead Stage of the client.</span></a>
                                                                    </td>
                                                               </tr>
                                                               <tr>
                                                                    <td><strong>Cross Sales Lead Status</strong><font style="color:red;" size="2">*</font></td>
                                                                    <td>
                                                                        <select name="cso_lead_status" id="cso_lead_status"><option value="0">Select Status</option>
                                                                            <?php
                                                                              $sql = "select `cls_Code`, `cls_Description` from `cls_clientleadstatus` ORDER BY cls_Order ASC";
                                                                              $res = mysql_query($sql) or die(mysql_error());
                                                                              while ($lp_row = mysql_fetch_assoc($res)){
                                                                              $val = $lp_row["cls_Code"];
                                                                              $caption = $lp_row["cls_Description"];
                                                                              if ($row["cso_lead_status"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Lead Status of the client.</span></a>
                                                                        <input type="hidden" name="cso_lead_status_old" id="cso_lead_status_old" value="<?php echo $row["cso_lead_status"]; ?>" />
                                                                    </td>
                                                               </tr>
                                                               <tr>
                                                                    <td ><strong>Source</strong><font style="color:red;" size="2">*</font></td>
                                                                    <td >
                                                                        <select name="cso_source" id="cso_source"><option value="0">---- Select Source ------</option>
                                                                            <?php
                                                                              $sql = "select `src_Code`, `src_Description` from `src_source` ORDER BY src_Order ASC";
                                                                              $res = mysql_query($sql) or die(mysql_error());
                                                                              while ($lp_row = mysql_fetch_assoc($res)){
                                                                              $val = $lp_row["src_Code"];
                                                                              $caption = $lp_row["src_Description"];
                                                                              if ($row["cso_source"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                             ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                                                            <?php } ?>
                                                                        </select>
																		<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Source of the client. Users with <b>Lead</b> access will be able to view/edit this field.</span></a>
                                                                    </td>
                                                               </tr>
                                                        <tr>
                                                            <td ><strong>Name of employee who generated lead</strong><font style="color:red;" size="2">*</font></td>
                                                            <td >
                                                                <select name="cso_generated_lead" id="cso_generated_lead"><option value="0">-- Select employee -</option>
                                                                    <?php
                                                                     $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY con_Firstname";
                                                                      $res = mysql_query($sql) or die(mysql_error());

                                                                      while ($lp_row = mysql_fetch_assoc($res)){
                                                                      $val = $lp_row["stf_Code"];
                                                                      $caption = $lp_row["con_Firstname"];
                                                                      if ($row["cso_generated_lead"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption." ".$lp_row['con_Lastname']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Generated lead of the client </span></a>
                                                            </td>
                                                        </tr>
                                                               <tr>
                                                                        <td ><strong>Method of Contact</strong><font style="color:red;" size="2">*</font></td>
                                                                        <td >
                                                                            <select name="cso_method_of_contact" id="cso_method_of_contact"><option value="0">Select MethodOfContact</option>
                                                                                <?php
                                                                                  $sql = "select `moc_Code`, `moc_Description` from `moc_methodofcontact` ORDER BY moc_Order ASC";
                                                                                  $res = mysql_query($sql) or die(mysql_error());

                                                                                  while ($lp_row = mysql_fetch_assoc($res)){
                                                                                  $val = $lp_row["moc_Code"];
                                                                                  $caption = $lp_row["moc_Description"];
                                                                                  if ($row["cso_method_of_contact"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                                 ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Contact Method of client.</span></a>
                                                                        </td>
                                                               </tr>
                                                        <tr>
                                                            <td ><strong>Cross Sales Staff</strong><font style="color:red;" size="2">*</font></td>
                                                            <td >
                                                                <select name="cso_sales_person" id="cso_sales_person"><option value="0">-- Select staff -</option>
                                                                    <?php
                                                                     $sql="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY con_Firstname";
                                                                      $res = mysql_query($sql) or die(mysql_error());

                                                                      while ($lp_row = mysql_fetch_assoc($res)){
                                                                      $val = $lp_row["stf_Code"];
                                                                      $caption = $lp_row["con_Firstname"];
                                                                      if ($row["cso_sales_person"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption." ".$lp_row['con_Lastname']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Assign Staff to take charge as sales person of client.</span></a>
                                                            </td>
                                                        </tr>
                                                            <tr>
                                                                <td><strong>Last contact date</strong>
                                                                </td>
                                                                <td class="dr"><input type="text" name="cso_last_contact_date" id="cso_last_contact_date" value="<?php if (isset($row["cso_last_contact_date"]) && $row["cso_last_contact_date"]!="") {
                                                                if($row["cso_last_contact_date"]!="0000-00-00")
                                                                    $php_lrf_From = date("d/m/Y",strtotime( $row["cso_last_contact_date"] ));
                                                                    echo  $php_lrf_From ; } ?>">&nbsp;<a href="javascript:NewCal('cso_last_contact_date','ddmmyyyy',false,24)"><img
                                                                    src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">The date Contact of the client.</span></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Future contact date</strong>
                                                                </td>
                                                                <td class="dr"><input type="text" name="cso_future_contact_date" id="cso_future_contact_date" value="<?php if (isset($row["cso_future_contact_date"]) && $row["cso_future_contact_date"]!="") {
                                                                if($row["cso_future_contact_date"]!="0000-00-00")
                                                                    $php_FutureContact = date("d/m/Y",strtotime( $row["cso_future_contact_date"] ));
                                                                    echo  $php_FutureContact ; } ?>">&nbsp;<a href="javascript:NewCal('cso_future_contact_date','ddmmyyyy',false,24)"><img
                                                                    src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                                                                <a class="tooltip" href="#"><img src="images/help.png"><span class="help">The date future Contact of the client.</span></a>
                                                                </td>
                                                            </tr>
                                                               <tr>
                                                                   <td><strong>Notes</strong></td>
                                                                   <td>
                                                                       <textarea name="cso_notes" id="cso_notes" cols="35" rows="4"><?php echo $row['cso_notes']; ?></textarea>
                                                                       <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Notes of the Cross Sales Opportunity.</span></a>
                                                                   </td>
                                                               </tr>
                                                            
                                                        </table>
                	<td>
                </tr>
              </table>
              <?php
                  mysql_free_result($res);
            }
}
	$crossSales = new CrossSales();

?>
