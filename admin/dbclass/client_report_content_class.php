<?php
	
class clireportContentList extends Database
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
          global $access_file_level_report;
          global $access_file_level;
          global $access_file_level_discontinued;
          global $access_file_level_lead;
          global $access_file_level_consigned;
          global $clireportDbcontent;
          
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
          $res = $clireportDbcontent->sql_select();
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
        Sales Report
        </span>
        <div id="notprint">
        <hr size="1" noshade><div style="right:0px;width:300;"> </div>
        <form  method="post" action="cli_client_report.php"  name="client_report" onSubmit="return validateFormOnSubmitReport()">
            <table width="1100px">
                <tr>
                        <td>Date Received From</td>
                        <td> <input type="text" name="cli_DateFrom" id="cli_DateFrom" value="<?php echo $_SESSION['cli_DateFrom'] ?>">&nbsp;<a href="javascript:NewCal('cli_DateFrom','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                        <td>
                                Company Name
                        </td>
                        <td>
                                <div id="wrapper"><input type="hidden" id="cli_Code" name="cli_Code" value="" style="font-size: 10px; width: 20px;"  />
                                        <input style="width: 200px" type="text" id="cli_CompanyName" name="cli_CompanyName" value="<?php echo $_SESSION['cli_CompanyName']?>"  />
                                </div>
                                <script type="text/javascript">
                                        var options = {
                                                script:"dbclass/wrk_client_db_class.php?json=true&limit=6&report=client&",
                                                varname:"input",
                                                json:true,
                                                shownoresults:false,
                                                maxresults:6,
                                                callback: function (obj) { document.getElementById('cli_Code').value = obj.id; }
                                                };
                                                var as_json = new bsn.AutoSuggest('cli_CompanyName', options);

                                                var options_xml = {
                                                        script: function (input) { return "dbclass/wrk_client_db_class.php?input="+input+"&con_Company="+document.getElementById('cli_Code').value+"&report=client"; },
                                                        varname:"input"
                                                        };
                                                var as_xml = new bsn.AutoSuggest('testinput_xml', options_xml);
                                </script>
                        </td>

                </tr>
                <tr>
                <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Date Received To</td>
                    <td><input type="text" name="cli_DateTo" id="cli_DateTo" value="<?php echo $_SESSION['cli_DateTo'];?>">&nbsp;<a href="javascript:NewCal('cli_DateTo','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a></td>
                    <td>State</td>
                    <td>
                    <?php
                    $state_query ="select `cst_Code`,`cst_Description` from `cli_state` ORDER BY cst_Description ASC";
                    $state_result=mysql_query($state_query);
                      ?>
                    <select name="cli_State" ><option value="">Select State</option>

                    <?php while($state_row=mysql_fetch_array($state_result)) {
                    ?>
                        <option value="<?php echo $state_row['cst_Code']?>"   <?php  if($state_row['cst_Code']==$_SESSION['cli_State']) echo "selected";?> ><?php  echo $state_row['cst_Description']?></option>
                         <?php   } ?>
                             </select>
                    </td>
                </tr>
                <tr>
                        <td>
                                Type
                        </td>
                        <td>
                            <?php
                                if(($access_file_level_discontinued['stf_View']=="") && ($access_file_level_discontinued['stf_Edit']=="") && ($access_file_level_discontinued['stf_Delete']=="") && ($access_file_level_consigned['stf_View']=="") && ($access_file_level_consigned['stf_Edit']=="") && ($access_file_level_consigned['stf_Delete']=="") && ($access_file_level_lead['stf_View']=="") && ($access_file_level_lead['stf_Edit']=="") && ($access_file_level_lead['stf_Delete']=="") && ($access_file_level['stf_View']=="") && ($access_file_level['stf_Edit']=="") && ($access_file_level['stf_Delete']==""))
                                {
                                    $rights[] = "";
                            ?>
                            <input type="hidden" name="cli_TypeListPerm[]" value="0">
                            <?php
                            }

                            if($_SESSION['usertype']=="Staff")
                            {
                                if(($access_file_level['stf_View']=="Y") || ($access_file_level['stf_Edit']=="Y") ||($access_file_level['stf_Delete']=="Y"))
                                {
                                    $rights[] = "Client";

                            ?>
                            <input type="hidden" name="cli_TypeListPerm[]" value="5">
                            <?php
                            }
                                if(($access_file_level_lead['stf_View']=="Y") || ($access_file_level_lead['stf_Edit']=="Y") ||($access_file_level_lead['stf_Delete']=="Y"))
                                {
                                    $rights[] = "Lead";
                            ?>
                            <input type="hidden" name="cli_TypeListPerm[]" value="4">
                            <?php
                            }
                                if(($access_file_level_consigned['stf_View']=="Y") || ($access_file_level_consigned['stf_Edit']=="Y") ||($access_file_level_consigned['stf_Delete']=="Y"))
                                {
                                    $rights[] = "Contract Signed";
                            ?>
                            <input type="hidden" name="cli_TypeListPerm[]" value="7">
                            <?php
                            }
                                if(($access_file_level_discontinued['stf_View']=="Y") || ($access_file_level_discontinued['stf_Edit']=="Y") ||($access_file_level_discontinued['stf_Delete']=="Y"))
                                {
                                     $rights[] = "Discontinued";
                            ?>
                            <input type="hidden" name="cli_TypeListPerm[]" value="6">
                            <?php
                            }

                                        @$sql_type = "select `cty_Code`, `cty_Description` from `cty_clienttype` where cty_Description IN ("."'".implode("','",$rights)."'".")";
                                        $res_type = mysql_query($sql_type) or die(mysql_error());

                            }
                                else {
                                        $sql_type = "select `cty_Code`, `cty_Description` from `cty_clienttype` ORDER BY cty_Description ASC";
                                        $res_type = mysql_query($sql_type) or die(mysql_error());
                                }
                            ?>
                                <select name="cli_TypeList[]" id="cli_TypeList"  multiple >
                                            <option value=""></option>
                                                <?php while($type_row=mysql_fetch_array($res_type))
                                                    {

                                                ?>
                                                <option value="<?php echo $type_row['cty_Code']?>"    <?php
                                                    if(is_array($_SESSION['cli_Type']))
                                                    {
                                                        foreach ($_SESSION['cli_Type'] as $v )
                                                        {
                                                            if($type_row['cty_Code']==$v) echo "selected";
                                                        }
                                                    }?> ><?php  echo $type_row['cty_Description']?></option>
                                                    <?php   } ?>
                                        </select>
                            <input type="checkbox" name="SelectAll_Type" id="SelectAll_Type" value="Yes" onClick="javascript:selectAll('cli_TypeList', true);">Select All
                        </td>
                        <td>Stage</td>
                        <td>
                                <?php
                                    $sql_stage = "select `cst_Code`, `cst_Description` from `cst_clientstatus` ORDER BY cst_Order ASC";
                                    $res_stage = mysql_query($sql_stage) or die(mysql_error());
                                ?>
                                <select name="cli_StageList[]" id="cli_StageList"  multiple >
                                    <option value=""></option>
                                    <?php while($stage_row=mysql_fetch_array($res_stage))
                                        {

                                    ?>
                                    <option value="<?php echo $stage_row['cst_Code']?>"    <?php
                                        if(is_array($_SESSION['cli_Stage']))
                                        {
                                                foreach ($_SESSION['cli_Stage'] as $v )
                                                {
                                                        if($stage_row['cst_Code']==$v) echo "selected";
                                                }
                                        }?> ><?php  echo $stage_row['cst_Description']?></option>
                                     <?php   } ?>
                                </select>
                                <input type="checkbox" name="SelectAll_Stage" id="SelectAll_Stage" value="Yes" onClick="javascript:selectAll('cli_StageList', true);">Select All
                        </td>
                </tr>
                <tr>
                        <td>Sales Person</td>
                        <td>
                            <?php
                            if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="N")
                            {
                                echo $_SESSION['user'];
                                ?>
                                <input type="hidden" name="cli_StaffCode" value="<?php echo $_SESSION['staffcode']; ?> ">
                                <?php
                            }
                            else if($_SESSION['usertype']=="Staff" && $_SESSION['Viewall']=="Y")
                            {
                               $sql_salesperson="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE (c1.con_Designation=14 || c1.con_Designation=19) AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                               $res_salesperson = mysql_query($sql_salesperson) or die(mysql_error());
                                                    ?>
                                                    <select name="cli_SalespersonList[]" id="cli_SalespersonList"  style="height:200px;"  multiple >
                                                        <option value=""></option>
                                                        <?php while($row_sales=mysql_fetch_array($res_salesperson)) {
                                                             ?>
                                                                <option value="<?php echo $row_sales['stf_Code']?>"  <?php
                                                                    if(is_array($_SESSION['cli_Salesperson']))
                                                                    {
                                                                            foreach ($_SESSION['cli_Salesperson'] as $v )
                                                                    {
                                                                            if($row_sales['stf_Code']==$v) echo "selected";
                                                                    }
                                                                    }?>><?php  echo $row_sales['con_Firstname']." ".$row_sales['con_Lastname']; ?></option>
                                                                 <?php   } ?>
                                                        </select>
                                                        <input type="checkbox" name="SelectAll_SalesPerson" id="SelectAll_SalesPerson" value="Yes" onClick="javascript:selectAll('cli_SalespersonList', true);">Select All
                            <?php
                            }
                            else {
                               $sql_salesperson="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE (c1.con_Designation=14 || c1.con_Designation=19) AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                               $res_salesperson = mysql_query($sql_salesperson) or die(mysql_error());
                                                    ?>
                                                    <select name="cli_SalespersonList[]" id="cli_SalespersonList"  style="height:200px;"  multiple >
                                                        <option value=""></option>
                                                        <?php while($row_sales=mysql_fetch_array($res_salesperson)) {
                                                             ?>
                                                                <option value="<?php echo $row_sales['stf_Code']?>"  <?php
                                                                    if(is_array($_SESSION['cli_Salesperson']))
                                                                    {
                                                                            foreach ($_SESSION['cli_Salesperson'] as $v )
                                                                    {
                                                                            if($row_sales['stf_Code']==$v) echo "selected";
                                                                    }
                                                                    }?>><?php  echo $row_sales['con_Firstname']." ".$row_sales['con_Lastname']; ?></option>
                                                                 <?php   } ?>
                                                        </select>
                                                        <input type="checkbox" name="SelectAll_SalesPerson" id="SelectAll_SalesPerson" value="Yes" onClick="javascript:selectAll('cli_SalespersonList', true);">Select All
                            <?php }
                                 ?>
                        </td>
                        <td>Lead Status</td>
                        <td>
                                 <select name="cli_StatusList[]"  id="cli_StatusList" multiple>
                                    <option value=""> </option>
                                        <?php
                                        $sql_stage = "select `cls_Code`, `cls_Description` from `cls_clientleadstatus` ORDER BY cls_Order ASC";
                                        $res_stage = mysql_query($sql_stage) or die(mysql_error());
                                         ?>
                                        <?php while($stage_row=mysql_fetch_array($res_stage))
                                            {
                                        ?>
                                    <option value="<?php echo $stage_row['cls_Code']?>"    <?php
                                        if(is_array($_SESSION['cli_Status']))
                                        {
                                                foreach ($_SESSION['cli_Status'] as $v )
                                                {
                                                        if($stage_row['cls_Code']==$v) echo "selected";
                                                }
                                        }?> ><?php  echo $stage_row['cls_Description']?>
                                    </option>
                                     <?php   } ?>
                                  </select>
                                <input type="checkbox" name="SelectAll_Status" id="SelectAll_Status" value="Yes" onClick="javascript:selectAll('cli_StatusList', true);">Select All
                        </td>
                </tr>
                <tr valign="middle">
                    <td colspan="2">&nbsp;</td>
                    <td ><input type="submit" name="Submit" value="Generate Report"   >
                    </td>
                    <td><input type="submit" name="Submit" value="Generate Excel Report"  >
                    <a href="cli_client_report.php?a=reset" style="color:#FB5C24;font-weight:bold; font-family:Tahoma, Arial, Verdana; font-size:12px; margin:40px; ">Reset Filter</a>
                    </td>
                    <td>
                        <?php if($_SESSION['Submit'] == 'Generate Report') { ?>
                        <a href="client_report_pdf.php"><img src="images/pdf_icon.gif" style="margin-top:-15px; " alt="Print" name="Print" align="middle" border="0" /></a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
         </form>
        </div>
        <p id="printscreen">
        <?php
         if($_SESSION['Submit'] == 'Generate Report')
         {
                 $this->showpagenav($page, $pagecount);
         }
        ?>
        <br><br>
        <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" >
            <tr class="fieldheader">
                <th class="fieldheader"><a  href="cli_client_report.php?order=<?php echo "name" ?>&type=<?php echo $ordtypestr ?>">Company Name</th>
                <th class="fieldheader"><a  href="cli_client_report.php?order=<?php echo "cli_State" ?>&type=<?php echo $ordtypestr ?>">State</th>
                <th class="fieldheader"><a  href="cli_client_report.php?order=<?php echo "cli_Type" ?>&type=<?php echo $ordtypestr ?>">Client Type</th>
                <th class="fieldheader"><a  href="cli_client_report.php?order=<?php echo "cli_Stage" ?>&type=<?php echo $ordtypestr ?>">Stage</th>
                <th class="fieldheader"><a  href="cli_client_report.php?order=<?php echo "cli_Salesperson" ?>&type=<?php echo $ordtypestr ?>">Sales Person</th>
                <th class="fieldheader"><a  href="cli_client_report.php?order=<?php echo "cli_Status" ?>&type=<?php echo $ordtypestr ?>">Status</th>
                <th  class="fieldheader" id="notprint" colspan="3" align="center">Actions</th>
             </tr>
                <?php
                if($_SESSION['Submit'] == 'Generate Report')
                {
                   for ($i = $startrec; $i < $reccount; $i++)
                    {
                        $row = mysql_fetch_assoc($res);
                 ?>
            <tr>
                <td class=""><?php echo $row['name'];?></td>
                <td class=""><?php echo $row['lp_cli_State'] ;?></td>
                <td class=""><?php echo $row['lp_cli_Type'];?></td>
                <td class=""><?php echo $row['lp_cli_Stage'] ;?></td>
                <td class=""><?php echo $row['lp_cli_Salesperson_fname']." ".$row['lp_cli_Salesperson_lname'];?></td>
                <td class=""><?php echo $row["cli_Lead_Status"]; ?></td>
                <?php
                  if($access_file_level_report['stf_View']=="Y" && ($access_file_level['stf_View']=="Y"  && $row["lp_cli_Type"]=="Client") || ($access_file_level_lead['stf_View']=="Y" && $row["lp_cli_Type"]=="Lead") ||($access_file_level_consigned['stf_View']=="Y" && $row["lp_cli_Type"]=="Contract Signed") || ($access_file_level_discontinued['stf_View']=="Y" && $row["lp_cli_Type"]=="Discontinued"))
                  {
                ?>
                <td id="notprint" >
                <a href="cli_client.php?a=view&cli_code=<?php echo $row['cli_Code']; ?>&b=report" target="_blank">
                <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                </td>
                <?php } ?>
                <?php
                  if($access_file_level_report['stf_Delete']=="Y" && ($access_file_level['stf_Delete']=="Y"  && $row["lp_cli_Type"]=="Client") || ($access_file_level_lead['stf_Delete']=="Y" && $row["lp_cli_Type"]=="Lead") ||($access_file_level_consigned['stf_Delete']=="Y" && $row["lp_cli_Type"]=="Contract Signed") || ($access_file_level_discontinued['stf_Delete']=="Y" && $row["lp_cli_Type"]=="Discontinued"))
                  {
                ?>
                <td id="notprint" >
                <a onClick="performdelete('cli_client_report.php?mode=delete&recid=<?php echo htmlspecialchars($row["cli_Code"]) ?>'); return false;" href="#">
                <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                </td>
                <?php }  ?>
            </tr>
                <?php }  }
                if( $_SESSION['Submit']=="Generate Excel Report")
                  {
                   header("Location:dbclass/generate_excel_class.php?report=client");
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
                    <td><a href="cli_client_report.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="cli_client_report.php?page=<?php echo $j ?>&submit=Generate Report"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="cli_client_report.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="cli_client_report.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }

}
	$clireportContent = new clireportContentList();

?>

