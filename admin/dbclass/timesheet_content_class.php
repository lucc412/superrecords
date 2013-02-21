<?php
	
class timesheetContentList extends Database
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
              global $timesheetDbcontent;
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
              $res = $timesheetDbcontent->sql_select();
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
            <span class="frmheading">Time Sheet</span>
            <hr size="1" noshade>
            <form action="tis_timesheet.php" method="post">
                <table align="right" style="margin-right:15px; " border="0" cellspacing="1" cellpadding="4">
                <tr>
                    <td><b>Custom Filter</b>&nbsp;</td>
                    <td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
                    <td><select name="filter_field">
                    <option value="">All Fields</option>
                    <?php
                    if($_SESSION['usertype']=="Administrator")
                    {
                    ?>
                    <option value="<?php echo "lp_tis_StaffCode" ?>"<?php if ($filterfield == "lp_tis_StaffCode") { echo "selected"; } ?>>Staff</option>
                    <?php } ?>
                    <option value="<?php echo "lp_tis_CompanyName" ?>"<?php if ($filterfield == "lp_tis_CompanyName") { echo "selected"; } ?>>Client</option>
                    <option value="<?php echo "lp_tis_MasterActivity" ?>"<?php if ($filterfield == "lp_tis_MasterActivity") { echo "selected"; } ?>>Master Activity</option>
                    <option value="<?php echo "lp_tis_SubActivity" ?>"<?php if ($filterfield == "lp_tis_SubActivity") { echo "selected"; } ?>>Sub Activity</option>
                    <option value="<?php echo "tis_Date" ?>"<?php if ($filterfield == "tis_Date") { echo "selected"; } ?>>Date</option>
                    </select></td>
                    <td><input type="checkbox" name="wholeonly"<?php echo $checkstr ?>>Whole words only</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="action" value="Apply Filter"></td>
                    <td><a href="tis_timesheet.php?a=reset" class="hlight">Reset Filter</a></td>
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
                <a href="tis_timesheet.php?a=add" class="hlight">
                <img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
                <?php }
                $this->showpagenav($page, $pagecount); ?>
                <br><br>
                <table class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5" >
                <tr class="fieldheader">
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "lp_tis_StaffCode" ?>&type=<?php echo $ordtypestr ?>">Staff Name</a></th>
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "lp_tis_CompanyName" ?>&type=<?php echo $ordtypestr ?>">Client</a></th>
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "lp_tis_MasterActivity" ?>&type=<?php echo $ordtypestr ?>">Master Activity</a></th>
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "lp_tis_SubActivity" ?>&type=<?php echo $ordtypestr ?>">Sub Activity</a></th>
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "tis_ArrivalTime" ?>&type=<?php echo $ordtypestr ?>">Arrival Time</a></th>
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "tis_DepartureTime" ?>&type=<?php echo $ordtypestr ?>">Departure Time</a></th>
                 <th class="fieldheader"><a  href="tis_timesheet.php?order=<?php echo "tis_Status" ?>&type=<?php echo $ordtypestr ?>">Status</a></th>
                 <th class="fieldheader"><a href="tis_timesheet.php?order=<?php echo "tis_Date" ?>&type=<?php echo $ordtypestr?>">Date</a></th>
                 <th class="fieldheader"><a href="tis_timesheet.php?order=<?php echo "lp_tis_Units" ?>&type=<?php echo $ordtypestr?>">Units</a></th>
                <?php
                if($_SESSION['usertype']=="Administrator")
                {
                ?>
                <th class="fieldheader"><a href="tis_timesheet.php?order=<?php echo "lp_tis_NetUnits" ?>&type=<?php echo $ordtypestr?>">Net Units</a></th>
                <?php
                }
                ?>
                <th  class="fieldheader" colspan="3" align="center">Actions</th></td>
                </tr>
                <?php
                  for ($i = $startrec; $i < $reccount; $i++)
                  {
                    $row = mysql_fetch_assoc($res);
                 ?>
                <tr>
                 <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_StaffCode"]) ?></td>
                 <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_CompanyName"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_MasCode"]).($row["lp_tis_MasCode"]!=""? "-":"").htmlspecialchars($row["lp_tis_MasterActivity"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_SubCode"]).($row["lp_tis_SubCode"]!=""? "-":"").htmlspecialchars($row["lp_tis_SubActivity"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["tis_ArrivalTime"]) ?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["tis_DepartureTime"]) ?></td>
                <td class="<?php echo $style ?>"><?php   echo $commonUses->getTimesheetStatus(htmlspecialchars($row["tis_Status"])); ?></td>
                <td class="<?php echo $style ?>"><?php echo $commonUses->showGridDateFormat($row["tis_Date"]);?></td>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_Units"]);?></td>
                <?php
                if($_SESSION['usertype']=="Administrator")
                {
                ?>
                <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["lp_tis_NetUnits"]);?></td>
                <?php
                }
                ?>
                <?php
                  if($access_file_level['stf_View']=="Y")
                  {
                ?>
                <td>
                <a href="tis_timesheet.php?a=view&recid=<?php echo $i ?>">
                <img src="images/view.png" border="0"  alt="View" name="View" title="View" align="middle" /></a>
                </td>
                <?php }
                  if($access_file_level['stf_Edit']=="Y")
                  {
                ?>
                <td>
                <a href="tis_timesheet.php?a=edit&recid=<?php echo $row["tis_Code"] ?>">
                <img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
                </td>
                <?php }
                  if($access_file_level['stf_Delete']=="Y")
                  {
                ?>
                <td>
                <a onClick="performdelete('tis_timesheet.php?mode=delete&recid=<?php echo htmlspecialchars($row["tis_Code"]) ?>'); return false;" href="#">
                <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                </td>
                <?php } ?>
                </tr>
            <?php
              }
              mysql_free_result($res);
            ?>
            </table>

            <br><?php $this->showpagenav($page, $pagecount); ?>
             <?php }
            function showrow($row, $recid)
              {
                global $commonUses;
                ?>
            <table align="center" border="0" cellspacing="1" cellpadding="5"width="50%">
            <tr>
            <td class="hr">Staff Name</td>
            <td class="dr"><?php echo $commonUses->getFirstLastName($row["tis_StaffCode"]) ?></td>
            </tr>
            <tr>
            <td class="hr">Arrival Time</td>
            <td class="dr"><?php echo htmlspecialchars($row["tis_ArrivalTime"]) ?></td>
            </tr>
            <tr>
            <td class="hr">Departure Time</td>
            <td class="dr"><?php echo htmlspecialchars($row["tis_DepartureTime"]) ?></td>
            </tr>
            <tr>
            <td class="hr">Status</td>
            <td class="dr">
             <?php echo $commonUses->getTimesheetStatus(htmlspecialchars($row["tis_Status"])); ?></td>
            </tr>
            <tr>
            <td class="hr">Notes</td>
            <td class="dr"><?php echo htmlspecialchars($row["tis_Notes"]) ?></td>
            </tr>
            <tr>
            <td class="hr">Date</td>
            <td class="dr"><?php echo $commonUses->showGridDateFormat($row["tis_Date"]); ?></td>
            </tr>
            </table>

            <br><br>
            <?php
             $sql = "SELECT * FROM (SELECT t1.`tis_Code`, t1.`tis_TCode`, lp1.`tis_StaffCode` AS `lp_tis_TCode`, t1.`tis_ClientCode`,t1.`tis_Details`, lp2.`name` AS `lp_tis_ClientCode`, t1.`tis_MasterActivity`, lp3.`mas_Description` AS `lp_tis_MasterActivity`, lp3.`Code` AS `lp_tis_MasCode`, t1.`tis_SubActivity`, lp4.`sub_Description` AS `lp_tis_SubActivity`, lp4.`Code` AS `lp_tis_SubCode`, lp5.`tst_Description` AS `lp_tis_Details`,  t1.`tis_Units`, t1.`tis_NetUnits`, t1.`tis_Comments` FROM `tis_timesheetdetails` AS t1 LEFT OUTER JOIN `tis_timesheet` AS lp1 ON (t1.`tis_TCode` = lp1.`tis_Code`) LEFT OUTER JOIN `jos_users` AS lp2 ON (t1.`tis_ClientCode` = lp2.`cli_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`tis_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`tis_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `tst_tasktemplates` AS lp5 ON (t1.`tis_Details` = lp5.`tst_Code`)) subq where tis_TCode=".$row['tis_Code'];
            $res = mysql_query($sql);
             ?>
            <table class="fieldtable"  border="0" cellspacing="1" cellpadding="5"width="900px">
            <tr  class="fieldheader">
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "lp_tis_ClientCode" ?>&type=<?php echo $ordtypestr ?>">Client</a></td>
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "lp_tis_MasterActivity" ?>&type=<?php echo $ordtypestr ?>">Master Activity</a></td>
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "lp_tis_SubActivity" ?>&type=<?php echo $ordtypestr ?>">Sub Activity</a></td>
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "lp_tis_Details" ?>&type=<?php echo $ordtypestr ?>">Details</a></td>
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "tis_Units" ?>&type=<?php echo $ordtypestr ?>">Units</a></td>
            <?php
            if($_SESSION['usertype']=="Administrator")
            {
            ?>
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "tis_NetUnits" ?>&type=<?php echo $ordtypestr ?>">Net Units</a></td>
            <?php } ?>
            <th class="fieldheader"><a  href="tis_timesheetdetails.php?order=<?php echo "tis_Comments" ?>&type=<?php echo $ordtypestr ?>">Comments</a></td>
             </tr>
            <?php  while ($row2=mysql_fetch_array($res)) {?>

            <tr>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["lp_tis_ClientCode"]) ?></td>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["lp_tis_MasCode"]).($row2["lp_tis_MasCode"]!=""? "-":"").htmlspecialchars($row2["lp_tis_MasterActivity"]) ?></td>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["lp_tis_SubCode"]).($row2["lp_tis_SubCode"]!=""? "-":"").htmlspecialchars($row2["lp_tis_SubActivity"]) ?></td>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["tis_Details"]) ?></td>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["tis_Units"]) ?></td>
            <?php
            if($_SESSION['usertype']=="Administrator")
            {
            ?>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["tis_NetUnits"]) ?></td>
            <?php } ?>
            <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row2["tis_Comments"]) ?></td>
             </tr>
            <?php  }?>
            </table>
            <br>
            <span  class="footer"  style='font-size:96%;'>Created by: <?php echo htmlspecialchars($row["tis_Createdby"]) ?> | Created on: <?php echo $commonUses->showGridDateFormat($row["tis_Createdon"]); ?> | Lastmodified by: <?php echo htmlspecialchars($row["tis_Lastmodifiedby"]) ?> | Lastmodified on: <?php echo  $commonUses->showGridDateFormat($row["tis_Lastmodifiedon"]); ?></span>
        <?php }
        function showroweditor($row, $iseditmode)
          {
            global $commonUses;
            ?>
                <div style="margin-left:5px;">
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
                if($_SESSION['usertype']=="Administrator")
                {
                ?>
                <tr>
                    <td class="hr">Staff</td>
                    <td class="dr">
                     <select name="tis_StaffCode"><option value="0">Select Staff Name</option>
                        <?php
                          $sql = "select `stf_Code`, `stf_Login` from `stf_staff`";
                          $res = mysql_query($sql) or die(mysql_error());
                          while ($lp_row = mysql_fetch_assoc($res)){
                          $val = $lp_row["stf_Code"];
                          $caption = $commonUses->getFirstLastName($lp_row["stf_Code"]);
                          if ($row["tis_StaffCode"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                         ?><option value="<?php echo $val ?>"<?php echo $selstr ?> <?php echo $selstr_new ?>><?php echo $caption ?></option>
                        <?php } ?>
                     </select>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="hr">Date<font style="color:red;" size="2">*</font></td>
                    <td class="dr">
                    <input type="text" name="tis_Date" id="tis_Date" value="<?php if (isset($row["tis_Date"]) && $row["tis_Date"]!="") {

                    $php_tis_Date = strtotime( $row["tis_Date"] );
                    echo date("d/m/Y",$php_tis_Date); }else { echo date("d/m/Y");}  ?>">&nbsp;<a href="javascript:NewCal('tis_Date','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                    </td>
                </tr>
                <tr>
                <td class="hr">Arrival Time<font style="color:red;" size="2">*</font></td>
                <?php
                if($iseditmode)
                {
                $ArrivalTime=explode(":",$row["tis_ArrivalTime"]);
                }
                $at_seconds=$ArrivalTime[2];
                $at_minutes=$ArrivalTime[1];
                $at_hours=$ArrivalTime[0];
                ?>
                <td>
                <select name="at_hour"><option value="0">Select Hour</option>
                    <option value="00" <?php if ($at_hours=="00") echo "selected";?>>00</option>
                    <option value="01" <?php if ($at_hours=="01") echo "selected";?>>01</option>
                    <option value="02" <?php if ($at_hours=="02") echo "selected";?>>02</option>
                    <option value="03" <?php if ($at_hours=="03") echo "selected";?>>03</option>
                    <option value="04" <?php if ($at_hours=="04") echo "selected";?>>04</option>
                    <option value="05" <?php if ($at_hours=="05") echo "selected";?>>05</option>
                    <option value="06" <?php if ($at_hours=="06") echo "selected";?>>06</option>
                    <option value="07" <?php if ($at_hours=="07") echo "selected";?>>07</option>
                    <option value="08" <?php if ($at_hours=="08") echo "selected";?>>08</option>
                    <option value="09" <?php if ($at_hours=="09") echo "selected";?>>09</option>
                    <option value="10" <?php if ($at_hours=="10") echo "selected";?>>10</option>
                    <option value="11" <?php if ($at_hours=="11") echo "selected";?>>11</option>
                    <option value="12" <?php if ($at_hours=="12") echo "selected";?>>12</option>
                    <option value="13" <?php if ($at_hours=="13") echo "selected";?>>13</option>
                    <option value="14" <?php if ($at_hours=="14") echo "selected";?>>14</option>
                    <option value="15" <?php if ($at_hours=="15") echo "selected";?>>15</option>
                    <option value="16" <?php if ($at_hours=="16") echo "selected";?>>16</option>
                    <option value="17" <?php if ($at_hours=="17") echo "selected";?>>17</option>
                    <option value="18" <?php if ($at_hours=="18") echo "selected";?>>18</option>
                    <option value="19" <?php if ($at_hours=="19") echo "selected";?>>19</option>
                    <option value="20" <?php if ($at_hours=="20") echo "selected";?>>20</option>
                    <option value="21" <?php if ($at_hours=="21") echo "selected";?>>21</option>
                    <option value="22" <?php if ($at_hours=="22") echo "selected";?>>22</option>
                    <option value="23" <?php if ($at_hours=="23") echo "selected";?>>23</option>
                </select>
                <select name="at_minute"><option value="0">Select Minute</option>
                    <option value="00" <?php if ($at_minutes=="00") echo "selected";?>>00</option>
                    <option value="01" <?php if ($at_minutes=="01") echo "selected";?>>01</option>
                    <option value="02" <?php if ($at_minutes=="02") echo "selected";?>>02</option>
                    <option value="03" <?php if ($at_minutes=="03") echo "selected";?>>03</option>
                    <option value="04" <?php if ($at_minutes=="04") echo "selected";?>>04</option>
                    <option value="05" <?php if ($at_minutes=="05") echo "selected";?>>05</option>
                    <option value="06" <?php if ($at_minutes=="06") echo "selected";?>>06</option>
                    <option value="07" <?php if ($at_minutes=="07") echo "selected";?>>07</option>
                    <option value="08" <?php if ($at_minutes=="08") echo "selected";?>>08</option>
                    <option value="09" <?php if ($at_minutes=="09") echo "selected";?>>09</option>
                    <option value="10" <?php if ($at_minutes=="10") echo "selected";?>>10</option>
                    <option value="11" <?php if ($at_minutes=="11") echo "selected";?>>11</option>
                    <option value="12" <?php if ($at_minutes=="12") echo "selected";?>>12</option>
                    <option value="13" <?php if ($at_minutes=="13") echo "selected";?>>13</option>
                    <option value="14" <?php if ($at_minutes=="14") echo "selected";?>>14</option>
                    <option value="15" <?php if ($at_minutes=="15") echo "selected";?>>15</option>
                    <option value="16" <?php if ($at_minutes=="16") echo "selected";?>>16</option>
                    <option value="17" <?php if ($at_minutes=="17") echo "selected";?>>17</option>
                    <option value="18" <?php if ($at_minutes=="18") echo "selected";?>>18</option>
                    <option value="19" <?php if ($at_minutes=="19") echo "selected";?>>19</option>
                    <option value="20" <?php if ($at_minutes=="20") echo "selected";?>>20</option>
                    <option value="21" <?php if ($at_minutes=="21") echo "selected";?>>21</option>
                    <option value="22" <?php if ($at_minutes=="22") echo "selected";?>>22</option>
                    <option value="23" <?php if ($at_minutes=="23") echo "selected";?>>23</option>
                    <option value="24" <?php if ($at_minutes=="24") echo "selected";?>>24</option>
                    <option value="25" <?php if ($at_minutes=="25") echo "selected";?>>25</option>
                    <option value="26" <?php if ($at_minutes=="26") echo "selected";?>>26</option>
                    <option value="27" <?php if ($at_minutes=="27") echo "selected";?>>27</option>
                    <option value="28" <?php if ($at_minutes=="28") echo "selected";?>>28</option>
                    <option value="29" <?php if ($at_minutes=="29") echo "selected";?>>29</option>
                    <option value="30" <?php if ($at_minutes=="30") echo "selected";?>>30</option>
                    <option value="31" <?php if ($at_minutes=="31") echo "selected";?>>31</option>
                    <option value="32" <?php if ($at_minutes=="32") echo "selected";?>>32</option>
                    <option value="33" <?php if ($at_minutes=="33") echo "selected";?>>33</option>
                    <option value="34" <?php if ($at_minutes=="34") echo "selected";?>>34</option>
                    <option value="35" <?php if ($at_minutes=="35") echo "selected";?>>35</option>
                    <option value="36" <?php if ($at_minutes=="36") echo "selected";?>>36</option>
                    <option value="37" <?php if ($at_minutes=="37") echo "selected";?>>37</option>
                    <option value="38" <?php if ($at_minutes=="38") echo "selected";?>>38</option>
                    <option value="39" <?php if ($at_minutes=="39") echo "selected";?>>39</option>
                    <option value="40" <?php if ($at_minutes=="40") echo "selected";?>>40</option>
                    <option value="41" <?php if ($at_minutes=="41") echo "selected";?>>41</option>
                    <option value="42" <?php if ($at_minutes=="42") echo "selected";?>>42</option>
                    <option value="43" <?php if ($at_minutes=="43") echo "selected";?>>43</option>
                    <option value="44" <?php if ($at_minutes=="44") echo "selected";?>>44</option>
                    <option value="45" <?php if ($at_minutes=="45") echo "selected";?>>45</option>
                    <option value="46" <?php if ($at_minutes=="46") echo "selected";?>>46</option>
                    <option value="47" <?php if ($at_minutes=="47") echo "selected";?>>47</option>
                    <option value="48" <?php if ($at_minutes=="48") echo "selected";?>>48</option>
                    <option value="49" <?php if ($at_minutes=="49") echo "selected";?>>49</option>
                    <option value="50" <?php if ($at_minutes=="50") echo "selected";?>>50</option>
                    <option value="51" <?php if ($at_minutes=="51") echo "selected";?>>51</option>
                    <option value="52" <?php if ($at_minutes=="52") echo "selected";?>>52</option>
                    <option value="53" <?php if ($at_minutes=="53") echo "selected";?>>53</option>
                    <option value="54" <?php if ($at_minutes=="54") echo "selected";?>>54</option>
                    <option value="55" <?php if ($at_minutes=="55") echo "selected";?>>55</option>
                    <option value="56" <?php if ($at_minutes=="56") echo "selected";?>>56</option>
                    <option value="57" <?php if ($at_minutes=="57") echo "selected";?>>57</option>
                    <option value="58" <?php if ($at_minutes=="58") echo "selected";?>>58</option>
                    <option value="59" <?php if ($at_minutes=="59") echo "selected";?>>59</option>
                </select>
                <select name="at_second"><option value="0">Select Second</option>
                    <option value="00" <?php if ($at_seconds=="00") echo "selected";?>>00</option>
                    <option value="01" <?php if ($at_seconds=="01") echo "selected";?>>01</option>
                    <option value="02" <?php if ($at_seconds=="02") echo "selected";?>>02</option>
                    <option value="03" <?php if ($at_seconds=="03") echo "selected";?>>03</option>
                    <option value="04" <?php if ($at_seconds=="04") echo "selected";?>>04</option>
                    <option value="05" <?php if ($at_seconds=="05") echo "selected";?>>05</option>
                    <option value="06" <?php if ($at_seconds=="06") echo "selected";?>>06</option>
                    <option value="07" <?php if ($at_seconds=="07") echo "selected";?>>07</option>
                    <option value="08" <?php if ($at_seconds=="08") echo "selected";?>>08</option>
                    <option value="09" <?php if ($at_seconds=="09") echo "selected";?>>09</option>
                    <option value="10" <?php if ($at_seconds=="10") echo "selected";?>>10</option>
                    <option value="11" <?php if ($at_seconds=="11") echo "selected";?>>11</option>
                    <option value="12" <?php if ($at_seconds=="12") echo "selected";?>>12</option>
                    <option value="13" <?php if ($at_seconds=="13") echo "selected";?>>13</option>
                    <option value="14" <?php if ($at_seconds=="14") echo "selected";?>>14</option>
                    <option value="15" <?php if ($at_seconds=="15") echo "selected";?>>15</option>
                    <option value="16" <?php if ($at_seconds=="16") echo "selected";?>>16</option>
                    <option value="17" <?php if ($at_seconds=="17") echo "selected";?>>17</option>
                    <option value="18" <?php if ($at_seconds=="18") echo "selected";?>>18</option>
                    <option value="19" <?php if ($at_seconds=="19") echo "selected";?>>19</option>
                    <option value="20" <?php if ($at_seconds=="20") echo "selected";?>>20</option>
                    <option value="21" <?php if ($at_seconds=="21") echo "selected";?>>21</option>
                    <option value="22" <?php if ($at_seconds=="22") echo "selected";?>>22</option>
                    <option value="23" <?php if ($at_seconds=="23") echo "selected";?>>23</option>
                    <option value="24" <?php if ($at_seconds=="24") echo "selected";?>>24</option>
                    <option value="25" <?php if ($at_seconds=="25") echo "selected";?>>25</option>
                    <option value="26" <?php if ($at_seconds=="26") echo "selected";?>>26</option>
                    <option value="27" <?php if ($at_seconds=="27") echo "selected";?>>27</option>
                    <option value="28" <?php if ($at_seconds=="28") echo "selected";?>>28</option>
                    <option value="29" <?php if ($at_seconds=="29") echo "selected";?>>29</option>
                    <option value="30" <?php if ($at_seconds=="30") echo "selected";?>>30</option>
                    <option value="31" <?php if ($at_seconds=="31") echo "selected";?>>31</option>
                    <option value="32" <?php if ($at_seconds=="32") echo "selected";?>>32</option>
                    <option value="33" <?php if ($at_seconds=="33") echo "selected";?>>33</option>
                    <option value="34" <?php if ($at_seconds=="34") echo "selected";?>>34</option>
                    <option value="35" <?php if ($at_seconds=="35") echo "selected";?>>35</option>
                    <option value="36" <?php if ($at_seconds=="36") echo "selected";?>>36</option>
                    <option value="37" <?php if ($at_seconds=="37") echo "selected";?>>37</option>
                    <option value="38" <?php if ($at_seconds=="38") echo "selected";?>>38</option>
                    <option value="39" <?php if ($at_seconds=="39") echo "selected";?>>39</option>
                    <option value="40" <?php if ($at_seconds=="40") echo "selected";?>>40</option>
                    <option value="41" <?php if ($at_seconds=="41") echo "selected";?>>41</option>
                    <option value="42" <?php if ($at_seconds=="42") echo "selected";?>>42</option>
                    <option value="43" <?php if ($at_seconds=="43") echo "selected";?>>43</option>
                    <option value="44" <?php if ($at_seconds=="44") echo "selected";?>>44</option>
                    <option value="45" <?php if ($at_seconds=="45") echo "selected";?>>45</option>
                    <option value="46" <?php if ($at_seconds=="46") echo "selected";?>>46</option>
                    <option value="47" <?php if ($at_seconds=="47") echo "selected";?>>47</option>
                    <option value="48" <?php if ($at_seconds=="48") echo "selected";?>>48</option>
                    <option value="49" <?php if ($at_seconds=="49") echo "selected";?>>49</option>
                    <option value="50" <?php if ($at_seconds=="50") echo "selected";?>>50</option>
                    <option value="51" <?php if ($at_seconds=="51") echo "selected";?>>51</option>
                    <option value="52" <?php if ($at_seconds=="52") echo "selected";?>>52</option>
                    <option value="53" <?php if ($at_seconds=="53") echo "selected";?>>53</option>
                    <option value="54" <?php if ($at_seconds=="54") echo "selected";?>>54</option>
                    <option value="55" <?php if ($at_seconds=="55") echo "selected";?>>55</option>
                    <option value="56" <?php if ($at_seconds=="56") echo "selected";?>>56</option>
                    <option value="57" <?php if ($at_seconds=="57") echo "selected";?>>57</option>
                    <option value="58" <?php if ($at_seconds=="58") echo "selected";?>>58</option>
                    <option value="59" <?php if ($at_seconds=="59") echo "selected";?>>59</option>
                </select>
                </td>
                </tr>
                <tr>
                <td class="hr">Departure Time<font style="color:red;" size="2">*</font></td>
                <td>
                <?php
                if($iseditmode)
                {
                $DepartureTime=explode(":",$row["tis_DepartureTime"]);
                }
                $dt_seconds=$DepartureTime[2];
                $dt_minutes=$DepartureTime[1];
                $dt_hours=$DepartureTime[0];
                ?>
                <select name="dt_hour"><option value="0">Select Hour</option>
                    <option value="00" <?php if ($dt_hours=="00") echo "selected";?>>00</option>
                    <option value="01" <?php if ($dt_hours=="01") echo "selected";?>>01</option>
                    <option value="02" <?php if ($dt_hours=="02") echo "selected";?>>02</option>
                    <option value="03" <?php if ($dt_hours=="03") echo "selected";?>>03</option>
                    <option value="04" <?php if ($dt_hours=="04") echo "selected";?>>04</option>
                    <option value="05" <?php if ($dt_hours=="05") echo "selected";?>>05</option>
                    <option value="06" <?php if ($dt_hours=="06") echo "selected";?>>06</option>
                    <option value="07" <?php if ($dt_hours=="07") echo "selected";?>>07</option>
                    <option value="08" <?php if ($dt_hours=="08") echo "selected";?>>08</option>
                    <option value="09" <?php if ($dt_hours=="09") echo "selected";?>>09</option>
                    <option value="10" <?php if ($dt_hours=="10") echo "selected";?>>10</option>
                    <option value="11" <?php if ($dt_hours=="11") echo "selected";?>>11</option>
                    <option value="12" <?php if ($dt_hours=="12") echo "selected";?>>12</option>
                    <option value="13" <?php if ($dt_hours=="13") echo "selected";?>>13</option>
                    <option value="14" <?php if ($dt_hours=="14") echo "selected";?>>14</option>
                    <option value="15" <?php if ($dt_hours=="15") echo "selected";?>>15</option>
                    <option value="16" <?php if ($dt_hours=="16") echo "selected";?>>16</option>
                    <option value="17" <?php if ($dt_hours=="17") echo "selected";?>>17</option>
                    <option value="18" <?php if ($dt_hours=="18") echo "selected";?>>18</option>
                    <option value="19" <?php if ($dt_hours=="19") echo "selected";?>>19</option>
                    <option value="20" <?php if ($dt_hours=="20") echo "selected";?>>20</option>
                    <option value="21" <?php if ($dt_hours=="21") echo "selected";?>>21</option>
                    <option value="22" <?php if ($dt_hours=="22") echo "selected";?>>22</option>
                    <option value="23" <?php if ($dt_hours=="23") echo "selected";?>>23</option>
                </select>
                <select name="dt_minute"><option value="0">Select Minute</option>
                    <option value="00" <?php if ($dt_minutes=="00") echo "selected";?>>00</option>
                    <option value="01" <?php if ($dt_minutes=="01") echo "selected";?>>01</option>
                    <option value="02" <?php if ($dt_minutes=="02") echo "selected";?>>02</option>
                    <option value="03" <?php if ($dt_minutes=="03") echo "selected";?>>03</option>
                    <option value="04" <?php if ($dt_minutes=="04") echo "selected";?>>04</option>
                    <option value="05" <?php if ($dt_minutes=="05") echo "selected";?>>05</option>
                    <option value="06" <?php if ($dt_minutes=="06") echo "selected";?>>06</option>
                    <option value="07" <?php if ($dt_minutes=="07") echo "selected";?>>07</option>
                    <option value="08" <?php if ($dt_minutes=="08") echo "selected";?>>08</option>
                    <option value="09" <?php if ($dt_minutes=="09") echo "selected";?>>09</option>
                    <option value="10" <?php if ($dt_minutes=="10") echo "selected";?>>10</option>
                    <option value="11" <?php if ($dt_minutes=="11") echo "selected";?>>11</option>
                    <option value="12" <?php if ($dt_minutes=="12") echo "selected";?>>12</option>
                    <option value="13" <?php if ($dt_minutes=="13") echo "selected";?>>13</option>
                    <option value="14" <?php if ($dt_minutes=="14") echo "selected";?>>14</option>
                    <option value="15" <?php if ($dt_minutes=="15") echo "selected";?>>15</option>
                    <option value="16" <?php if ($dt_minutes=="16") echo "selected";?>>16</option>
                    <option value="17" <?php if ($dt_minutes=="17") echo "selected";?>>17</option>
                    <option value="18" <?php if ($dt_minutes=="18") echo "selected";?>>18</option>
                    <option value="19" <?php if ($dt_minutes=="19") echo "selected";?>>19</option>
                    <option value="20" <?php if ($dt_minutes=="20") echo "selected";?>>20</option>
                    <option value="21" <?php if ($dt_minutes=="21") echo "selected";?>>21</option>
                    <option value="22" <?php if ($dt_minutes=="22") echo "selected";?>>22</option>
                    <option value="23" <?php if ($dt_minutes=="23") echo "selected";?>>23</option>
                    <option value="24" <?php if ($dt_minutes=="24") echo "selected";?>>24</option>
                    <option value="25" <?php if ($dt_minutes=="25") echo "selected";?>>25</option>
                    <option value="26" <?php if ($dt_minutes=="26") echo "selected";?>>26</option>
                    <option value="27" <?php if ($dt_minutes=="27") echo "selected";?>>27</option>
                    <option value="28" <?php if ($dt_minutes=="28") echo "selected";?>>28</option>
                    <option value="29" <?php if ($dt_minutes=="29") echo "selected";?>>29</option>
                    <option value="30" <?php if ($dt_minutes=="30") echo "selected";?>>30</option>
                    <option value="31" <?php if ($dt_minutes=="31") echo "selected";?>>31</option>
                    <option value="32" <?php if ($dt_minutes=="32") echo "selected";?>>32</option>
                    <option value="33" <?php if ($dt_minutes=="33") echo "selected";?>>33</option>
                    <option value="34" <?php if ($dt_minutes=="34") echo "selected";?>>34</option>
                    <option value="35" <?php if ($dt_minutes=="35") echo "selected";?>>35</option>
                    <option value="36" <?php if ($dt_minutes=="36") echo "selected";?>>36</option>
                    <option value="37" <?php if ($dt_minutes=="37") echo "selected";?>>37</option>
                    <option value="38" <?php if ($dt_minutes=="38") echo "selected";?>>38</option>
                    <option value="39" <?php if ($dt_minutes=="39") echo "selected";?>>39</option>
                    <option value="40" <?php if ($dt_minutes=="40") echo "selected";?>>40</option>
                    <option value="41" <?php if ($dt_minutes=="41") echo "selected";?>>41</option>
                    <option value="42" <?php if ($dt_minutes=="42") echo "selected";?>>42</option>
                    <option value="43" <?php if ($dt_minutes=="43") echo "selected";?>>43</option>
                    <option value="44" <?php if ($dt_minutes=="44") echo "selected";?>>44</option>
                    <option value="45" <?php if ($dt_minutes=="45") echo "selected";?>>45</option>
                    <option value="46" <?php if ($dt_minutes=="46") echo "selected";?>>46</option>
                    <option value="47" <?php if ($dt_minutes=="47") echo "selected";?>>47</option>
                    <option value="48" <?php if ($dt_minutes=="48") echo "selected";?>>48</option>
                    <option value="49" <?php if ($dt_minutes=="49") echo "selected";?>>49</option>
                    <option value="50" <?php if ($dt_minutes=="50") echo "selected";?>>50</option>
                    <option value="51" <?php if ($dt_minutes=="51") echo "selected";?>>51</option>
                    <option value="52" <?php if ($dt_minutes=="52") echo "selected";?>>52</option>
                    <option value="53" <?php if ($dt_minutes=="53") echo "selected";?>>53</option>
                    <option value="54" <?php if ($dt_minutes=="54") echo "selected";?>>54</option>
                    <option value="55" <?php if ($dt_minutes=="55") echo "selected";?>>55</option>
                    <option value="56" <?php if ($dt_minutes=="56") echo "selected";?>>56</option>
                    <option value="57" <?php if ($dt_minutes=="57") echo "selected";?>>57</option>
                    <option value="58" <?php if ($dt_minutes=="58") echo "selected";?>>58</option>
                    <option value="59" <?php if ($dt_minutes=="59") echo "selected";?>>59</option>
                </select>
                <select name="dt_second"><option value="0">Select Second</option>
                    <option value="00" <?php if ($dt_seconds=="00") echo "selected";?>>00</option>
                    <option value="01" <?php if ($dt_seconds=="01") echo "selected";?>>01</option>
                    <option value="02" <?php if ($dt_seconds=="02") echo "selected";?>>02</option>
                    <option value="03" <?php if ($dt_seconds=="03") echo "selected";?>>03</option>
                    <option value="04" <?php if ($dt_seconds=="04") echo "selected";?>>04</option>
                    <option value="05" <?php if ($dt_seconds=="05") echo "selected";?>>05</option>
                    <option value="06" <?php if ($dt_seconds=="06") echo "selected";?>>06</option>
                    <option value="07" <?php if ($dt_seconds=="07") echo "selected";?>>07</option>
                    <option value="08" <?php if ($dt_seconds=="08") echo "selected";?>>08</option>
                    <option value="09" <?php if ($dt_seconds=="09") echo "selected";?>>09</option>
                    <option value="10" <?php if ($dt_seconds=="10") echo "selected";?>>10</option>
                    <option value="11" <?php if ($dt_seconds=="11") echo "selected";?>>11</option>
                    <option value="12" <?php if ($dt_seconds=="12") echo "selected";?>>12</option>
                    <option value="13" <?php if ($dt_seconds=="13") echo "selected";?>>13</option>
                    <option value="14" <?php if ($dt_seconds=="14") echo "selected";?>>14</option>
                    <option value="15" <?php if ($dt_seconds=="15") echo "selected";?>>15</option>
                    <option value="16" <?php if ($dt_seconds=="16") echo "selected";?>>16</option>
                    <option value="17" <?php if ($dt_seconds=="17") echo "selected";?>>17</option>
                    <option value="18" <?php if ($dt_seconds=="18") echo "selected";?>>18</option>
                    <option value="19" <?php if ($dt_seconds=="19") echo "selected";?>>19</option>
                    <option value="20" <?php if ($dt_seconds=="20") echo "selected";?>>20</option>
                    <option value="21" <?php if ($dt_seconds=="21") echo "selected";?>>21</option>
                    <option value="22" <?php if ($dt_seconds=="22") echo "selected";?>>22</option>
                    <option value="23" <?php if ($dt_seconds=="23") echo "selected";?>>23</option>
                    <option value="24" <?php if ($dt_seconds=="24") echo "selected";?>>24</option>
                    <option value="25" <?php if ($dt_seconds=="25") echo "selected";?>>25</option>
                    <option value="26" <?php if ($dt_seconds=="26") echo "selected";?>>26</option>
                    <option value="27" <?php if ($dt_seconds=="27") echo "selected";?>>27</option>
                    <option value="28" <?php if ($dt_seconds=="28") echo "selected";?>>28</option>
                    <option value="29" <?php if ($dt_seconds=="29") echo "selected";?>>29</option>
                    <option value="30" <?php if ($dt_seconds=="30") echo "selected";?>>30</option>
                    <option value="31" <?php if ($dt_seconds=="31") echo "selected";?>>31</option>
                    <option value="32" <?php if ($dt_seconds=="32") echo "selected";?>>32</option>
                    <option value="33" <?php if ($dt_seconds=="33") echo "selected";?>>33</option>
                    <option value="34" <?php if ($dt_seconds=="34") echo "selected";?>>34</option>
                    <option value="35" <?php if ($dt_seconds=="35") echo "selected";?>>35</option>
                    <option value="36" <?php if ($dt_seconds=="36") echo "selected";?>>36</option>
                    <option value="37" <?php if ($dt_seconds=="37") echo "selected";?>>37</option>
                    <option value="38" <?php if ($dt_seconds=="38") echo "selected";?>>38</option>
                    <option value="39" <?php if ($dt_seconds=="39") echo "selected";?>>39</option>
                    <option value="40" <?php if ($dt_seconds=="40") echo "selected";?>>40</option>
                    <option value="41" <?php if ($dt_seconds=="41") echo "selected";?>>41</option>
                    <option value="42" <?php if ($dt_seconds=="42") echo "selected";?>>42</option>
                    <option value="43" <?php if ($dt_seconds=="43") echo "selected";?>>43</option>
                    <option value="44" <?php if ($dt_seconds=="44") echo "selected";?>>44</option>
                    <option value="45" <?php if ($dt_seconds=="45") echo "selected";?>>45</option>
                    <option value="46" <?php if ($dt_seconds=="46") echo "selected";?>>46</option>
                    <option value="47" <?php if ($dt_seconds=="47") echo "selected";?>>47</option>
                    <option value="48" <?php if ($dt_seconds=="48") echo "selected";?>>48</option>
                    <option value="49" <?php if ($dt_seconds=="49") echo "selected";?>>49</option>
                    <option value="50" <?php if ($dt_seconds=="50") echo "selected";?>>50</option>
                    <option value="51" <?php if ($dt_seconds=="51") echo "selected";?>>51</option>
                    <option value="52" <?php if ($dt_seconds=="52") echo "selected";?>>52</option>
                    <option value="53" <?php if ($dt_seconds=="53") echo "selected";?>>53</option>
                    <option value="54" <?php if ($dt_seconds=="54") echo "selected";?>>54</option>
                    <option value="55" <?php if ($dt_seconds=="55") echo "selected";?>>55</option>
                    <option value="56" <?php if ($dt_seconds=="56") echo "selected";?>>56</option>
                    <option value="57" <?php if ($dt_seconds=="57") echo "selected";?>>57</option>
                    <option value="58" <?php if ($dt_seconds=="58") echo "selected";?>>58</option>
                    <option value="59" <?php if ($dt_seconds=="59") echo "selected";?>>59</option>
                </select>
                </td>
                </tr>
                <tr>
                    <td class="hr">Status<font style="color:red;" size="2">*</font></td>
                    <td class="dr">
                    <select name="tis_Status"><option value="0">Select Status</option>
                    <?php
                      //$sql = "select * from `tst_timesheetstatus`";
                        if($_SESSION['usertype']=="Administrator")
                      {
                      $sql ="select `tst_Code`,`tst_Description` from `tst_timesheetstatus` ORDER BY tst_Order ASC";
                      }
                      else if($_SESSION['usertype']=="Staff")
                      {
                        $sql = "select `tst_Code`, `tst_Description` from `tst_timesheetstatus` where tst_Description like 'Submitted' ORDER BY tst_Order ASC";
                      }
                      $res = mysql_query($sql) or die(mysql_error());
                      while ($ts_row = mysql_fetch_assoc($res)){
                      $val = $ts_row["tst_Code"];
                      $caption = $ts_row["tst_Description"];
                      if ($row["tis_Status"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                        if(!$iseditmode)
                      {
                      if ( $caption == "Submitted") {$selstr = " selected"; } else {$selstr = ""; }
                      }
                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                    <?php } ?></select></td>
                 </tr>
                <tr>
                    <td class="hr">Notes</td>
                    <td class="dr"><textarea cols="35" rows="4" name="tis_Notes" ><?php echo str_replace('"', '&quot;', trim($row["tis_Notes"])) ?></textarea></td>
                </tr>
             </table><br>
        <?php }
         function showroweditor_details_add($row, $iseditmode)
          {
              if(!$iseditmode)
              {
                $disabled="disabled";
              }
            ?>
            <td class="dr">
                <select name="tis_ClientCode_new" <?php echo $disabled?>>
                    <option value="0">Select Client</option>
                    <?php
                      $sql = "select `cli_Code`, `name` from `jos_users`";
                      $res = mysql_query($sql) or die(mysql_error());
                      while ($lp_row = mysql_fetch_assoc($res)){
                      $val = $lp_row["cli_Code"];
                      $caption = $lp_row["name"];
                      if ($row["tis_ClientCode"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="dr">
                <select name="tis_MasterActivity_new" onChange="getSubActivityTasks(this.value,-1)" <?php echo $disabled?>>
                    <option value="0">Master Activity</option>
                    <?php
                      $sql = "select `mas_Code`, `mas_Description`, Code from `mas_masteractivity` ORDER BY mas_Order ASC";
                      $res = mysql_query($sql) or die(mysql_error());
                      while ($lp_row = mysql_fetch_assoc($res)){
                      $val = $lp_row["mas_Code"];
                      $caption = $lp_row["mas_Description"];
                      $Code = $lp_row['Code'];
                      if ($row["tis_MasterActivity"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                     ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $Code.($Code!=""? "-":"").$caption ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="dr">
                    <select name="tis_SubActivity_new" id="tis_SubActivity_new">
                        <option value=""></option>
                    </select>
            </td>
            <td class="dr"><select style="width:120px; " name="tis_Details_new_select" id="tis_Details_new_select"  onChange="showTextArea(this.options[selectedIndex].value);" <?php echo $disabled?>>
                <option value="-1">Select Template</option>
                <option value="0">Your Own Text...</option>
                <?php
                  $sql = "select `tst_Code`, `tst_Description` from `tst_tasktemplates` ORDER BY tst_Order ASC";
                  $res = mysql_query($sql) or die(mysql_error());

                  while ($lp_row = mysql_fetch_assoc($res)){
                  $val = $lp_row["tst_Code"];
                  $caption = $lp_row["tst_Description"];
                  if ($row["tis_Details"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                 ?><option value='<?php echo $val."|".$caption  ?>'<?php echo $selstr ?>><?php echo $caption ?></option>
                <?php } ?></select>
                <div id="tis_Details_TextArea" style="display:none">
                <textarea   name="tis_Details_new"   cols="35" rows="2" id="tis_Details_new" <?php echo $disabled?>>
                </textarea>
                </div>
            </td>
            <td class="dr"><input type="text" <?php echo $disabled?> name="tis_Units_new" maxlength="8" size="10" value="<?php echo str_replace('"', '&quot;', trim($row["tis_Units"])) ?>"   ></td>
            <?php
            if($_SESSION['usertype']=="Administrator")
            {
            ?>
            <td class="dr">
            <input type="text" <?php echo $disabled?> name="tis_NetUnits_new" maxlength="8" size="10" value="<?php echo str_replace('"', '&quot;', trim($row["tis_NetUnits"])) ?>">
            </td><?php }?>
            <td class="dr"><textarea cols="35" rows="2" name="tis_Comments_new" <?php echo $disabled?> maxlength="100"><?php echo str_replace('"', '&quot;', trim($row["tis_Comments"])) ?></textarea></td>
            <td>
                <INPUT TYPE="image" SRC="images/save.png" style="border:0px; " ALT="Submit Form" <?php echo $disabled?>>
            </td>
            </tr>
            <?php }
            function showroweditor_details_edit($row, $iseditmode,$recid)
              {
              $tsheetrecid=$_GET['recid'];
            ?>
             <tr>

            <td class="dr">
                <input type="hidden" name="tis_Details_Code[]" value="<?php echo  $row["tis_Code"]; ?>">
                <select name="tis_ClientCode[]">
            <option value="0">Select Client</option>
            <?php
              $sql = "select `cli_Code`, `name` from `jos_users`";
              $res = mysql_query($sql) or die(mysql_error());

              while ($lp_row = mysql_fetch_assoc($res)){
              $val = $lp_row["cli_Code"];
              $caption = $lp_row["name"];
              if ($row["tis_ClientCode"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
             ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
            <?php } ?></select>
            </td>
            <td class="dr"><select name="tis_MasterActivity[]" onChange="getSubActivityTasks(this.value,<?php echo $recid;?>)">
            <option value="0">Master Activity</option>
            <?php
              $sql = "select `mas_Code`, `mas_Description`, Code from `mas_masteractivity` ORDER BY mas_Order ASC";
              $res = mysql_query($sql) or die(mysql_error());

              while ($lp_row = mysql_fetch_assoc($res)){
              $val = $lp_row["mas_Code"];
              $caption = $lp_row["mas_Description"];
              $Code = $lp_row['Code'];
              if ($row["tis_MasterActivity"] == $val) {
                    $selstr = " selected";

                    } else {$selstr = ""; }
             ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $Code.($Code!=""? "-":"").$caption ?></option>
            <?php } ?></select>
            </td>
            <td class="dr">
            <select name="tis_SubActivity[]" id="tis_SubActivity_ini<?php echo $recid;?>" >
            <?php
              $sql = "select `sub_Code`, `sub_Description`, Code from `sub_subactivity` where sas_Code = (select tis_MasterActivity from tis_timesheetdetails where tis_Code = " . $row["tis_Code"] . ") ORDER BY sub_Order ASC";

              $res = mysql_query($sql) or die(mysql_error());

              while ($lp_row = mysql_fetch_assoc($res)){
              $val = $lp_row["sub_Code"];
              $caption = $lp_row["sub_Description"];
              $SubCode = $lp_row["Code"];
              if ($row["tis_SubActivity"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
             ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $SubCode.($SubCode!=""? "-":"").$caption ?></option>
            <?php } ?></select>

                <select id="tis_SubActivity_edit<?php echo $recid?>" name="tis_SubActivity[]" style="display:none"><option></option></select> </td>
            <td class="dr">
            <textarea   name="tis_Details[]"   cols="35" rows="2" id="tis_Details[]"><?php echo $row["tis_Details"]?>
            </textarea><br>
            <select name="tis_Details_Update"  style="width:120px; " id="tis_Details_Update"  onChange="showValueinTextarea(this.options[selectedIndex].value,<?php echo $recid?>);">
            <option value="0">Select Template</option>
             <?php
              $sql = "select `tst_Code`, `tst_Description` from `tst_tasktemplates` ORDER BY tst_Order ASC";
              $res = mysql_query($sql) or die(mysql_error());

              while ($lp_row = mysql_fetch_assoc($res)){
              $val = $lp_row["tst_Code"];
              $caption = $lp_row["tst_Description"];
              if ($row["tis_Details"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
             ?><option value='<?php echo $val."|".$caption  ?>'<?php echo $selstr ?>><?php echo $caption ?></option>
            <?php } ?></select>
             </td>
            <td class="dr"><input type="text" name="tis_Units[]" maxlength="8" size="10" value="<?php echo str_replace('"', '&quot;', trim($row["tis_Units"])) ?>"  ></td>
            <?php
            if($_SESSION['usertype']=="Administrator")
            {
            ?>
            <td class="dr"><input type="text" name="tis_NetUnits[]" maxlength="8" size="10" value="<?php echo str_replace('"', '&quot;', trim($row["tis_NetUnits"])) ?>"  ></td>
            <?php } ?>
            <td class="dr"><textarea cols="35" rows="2" name="tis_Comments[]" maxlength="100"><?php echo str_replace('"', '&quot;', trim($row["tis_Comments"])) ?></textarea></td>
            <td><a onClick="performdelete('tis_timesheet.php?mode=detailsdelete&id=<?php echo htmlspecialchars($row["tis_Code"]) ?>&recid=<?php echo $tsheetrecid?>'); return false;" href="#"
             class="hlight"><img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a></td> </tr>
        <?php
        }
        function showpagenav($page, $pagecount)
        {
        ?>
            <table   border="0" cellspacing="1" cellpadding="4" align="right" >
                <tr>
                     <?php if ($page > 1) { ?>
                    <td><a href="tis_timesheet.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
                    <td><a href="tis_timesheet.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
                    <?php } } } else { ?>
                    <td><a href="tis_timesheet.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
                    <?php } } } ?>
                    <?php if ($page < $pagecount) { ?>
                    <td>&nbsp;<a href="tis_timesheet.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
                    <?php } ?>
                </tr>
            </table>
        <?php }
        function showrecnav($a, $recid, $count)
        {
            if($_GET['tid']=="" && !isset($_GET['tid']))
            {
            ?>
                <table border="0" cellspacing="1" cellpadding="4" align="right">
                    <tr>
                         <?php if ($recid > 0) { ?>
                        <td><a href="tis_timesheet.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>"><span style="color:#208EB3; ">&lt;&nbsp;</span></a></td>
                        <?php } if ($recid < $count - 1) { ?>
                        <td><a href="tis_timesheet.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>"><span style="color:#208EB3; ">&nbsp;&gt;</span></a></td>
                        <?php } ?>
                    </tr>
                </table>
            <?php } ?>
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
            <?php echo $title?> Time Sheet
            </span>
            <hr size="1" noshade>
            <?php }
            function addrec()
            {
            ?>
            <br>
            <span class="frmheading">
             Add Record
            </span>

            <hr size="1" noshade><div style="position:absolute; top:145; right:-50px; width:300; height:300;">
            <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
            <form enctype="multipart/form-data" action="tis_timesheet.php" method="post" name="timesheet" onSubmit="return validateFormOnSubmit()">
            <p><input type="hidden" name="sql" value="insert"></p>
            <?php
            $row = array(
              "tis_Code" => "",
              "tis_StaffCode" => "",
              "tis_ArrivalTime" => "",
              "tis_DepartureTime" => "",
              "tis_Status" => "",
              "tis_Notes" => "",
              "tis_Date" => "",
              "tis_Createdby" => "",
              "tis_Createdon" => "",
              "tis_Lastmodifiedby" => "",
              "tis_Lastmodifiedon" => "");
            $this->showroweditor($row, false);
            ?>
            <input type="submit" name="action" value="Save" class="button"><br></form><br>
            <form enctype="multipart/form-data" action="tis_timesheet.php" method="post" name="timesheet_new" >
                    <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="960px" >
                    <tr class="fieldheader">
                    <th class="fieldheader">Client</th>
                    <th class="fieldheader">Master Activity</th>
                    <th class="fieldheader">Sub Activity</th>
                    <th class="fieldheader">Details</th>
                    <th class="fieldheader">Units</th>
                    <?php
            if($_SESSION['usertype']=="Administrator")
            {
            ?>
                    <th class="fieldheader">Net Units</th>
                    <?php } ?>
                    <th class="fieldheader">Comments</th>
                    <th class="fieldheader">Action</th>
                    </tr>
             <tr>
            <?php
            $row = array(
              "tis_Code" => "",
              "tis_TCode" => "",
              "tis_ClientCode" => "",
              "tis_MasterActivity" => "",
              "tis_SubActivity" => "",
              "tis_Details" => "",
              "tis_Units" => "",
              "tis_NetUnits" => "",
              "tis_Comments" => "");
             $this->showroweditor_details_add($row, false);
             ?>
                 </form>
        <?php }
        function viewrec($recid,$access_file_level)
        {
            global $timesheetDbcontent;
            
            $res = $timesheetDbcontent->sql_select();
              //$count = sql_getrecordcount();
              $count = mysql_num_rows($res);
              if($_GET['tid']=="" && !isset($_GET['tid']))
              {
                mysql_data_seek($res, $recid);
              }
              $this->showrecnav("view", $recid, $count);
              $row = mysql_fetch_assoc($res);
             ?>
            <br>
            <?php $this->showrow($row, $recid) ?>
            <br>
             <hr size="1" noshade>
             <?php
            if($_GET['tid']=="" && !isset($_GET['tid']))
            {
            ?>
            <table class="bd" border="0" cellspacing="1" cellpadding="4">
                <tr>
                    <?php
                      if($access_file_level['stf_Add']=="Y")
                              {
                    ?>
                    <td><a href="tis_timesheet.php?a=add" class="hlight">Add Record</a></td>
                    <?php }?>
                    <?php
                      if($access_file_level['stf_Edit']=="Y")
                              {
                    ?>
                    <td><a href="tis_timesheet.php?a=edit&recid=<?php echo $row['tis_Code'] ?>" class="hlight">Edit Record</a></td>
                    <?php } ?>
                    <?php
                      if($access_file_level['stf_Delete']=="Y")
                              {
                    ?>
                    <td><a onClick="performdelete('tis_timesheet.php?mode=delete&recid=<?php echo htmlspecialchars($row["tis_Code"]) ?>'); return false;" href="#"
                     class="hlight">Delete Record</a></td>
                     <?php } ?>
                </tr>
            </table>
        <?php } 
          mysql_free_result($res);
        }
        function editrec($recid)
        {
            $sql = "SELECT * FROM (SELECT t1.`tis_Code`, t1.`tis_StaffCode`, lp1.`stf_Login` AS `lp_tis_StaffCode`, t1.`tis_ArrivalTime`, t1.`tis_DepartureTime`, t1.`tis_Status`, t1.`tis_Notes`, t1.`tis_Date`, t1.`tis_Createdby`, t1.`tis_Createdon`, t1.`tis_Lastmodifiedby`, t1.`tis_Lastmodifiedon` FROM `tis_timesheet` AS t1 LEFT OUTER JOIN `stf_staff` AS lp1 ON (t1.`tis_StaffCode` = lp1.`stf_Code`)  where t1.tis_Code=".$recid.") subq";
            $res =  @mysql_query($sql);
            $row=mysql_fetch_array($res);
            ?><br>
            <span class="frmheading">
             Edit Record
            </span>
            <hr size="1" noshade><div style="position:absolute; top:145; right:-50px; width:300; height:300;">
            <font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>
            <br>
            <form enctype="multipart/form-data" action="tis_timesheet.php" method="post" name="timesheet" onSubmit="return validateFormOnSubmit()">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="tid" value="<?php echo $_GET['tid'] ?>">
                <input type="hidden" name="xtis_Code" value="<?php echo $row["tis_Code"] ?>">
                <?php $this->showroweditor($row, true); ?>
                <input type="submit" name="action" value="Update" class="button">
            </form><br><br>
            <table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="5"  width="960px" >
                    <tr class="fieldheader">
                    <th class="fieldheader">Client</th>
                    <th class="fieldheader">Master Activity</th>
                    <th class="fieldheader">Sub Activity</th>
                    <th class="fieldheader">Details</th>
                    <th class="fieldheader">Units</th>
                    <?php
            if($_SESSION['usertype']=="Administrator")
            {
            ?>
                    <th class="fieldheader">Net Units</th><?php } ?>
                    <th class="fieldheader">Comments</th>
                    <th class="fieldheader">Action</th>
                    </tr>
                     <?php
                     if($_GET['tid']=="" && !isset($_GET['tid']))
                     $formaction="?a=".$_GET['a']."&recid=".$_GET['recid'];
                     ?>
            <form enctype="multipart/form-data" action="tis_timesheet.php<?php echo $formaction;?>" method="post" name="timesheet_edit" onSubmit="return validateFormOnSubmit_edit()">
                <input type="hidden" name="sql" value="update_details">
                <input type="hidden" name="action" value="insert_new">
                <input type="hidden" name="recid" value="<?php echo $_GET['recid']?>">
                <input type="hidden" name="xtis_Code" value="<?php echo $row["tis_Code"] ?>">

                <?php
                  $sql_details = "SELECT * FROM (SELECT t1.`tis_Code`, t1.`tis_TCode`, lp1.`tis_StaffCode` AS `lp_tis_TCode`, t1.`tis_ClientCode`, lp2.`name` AS `lp_tis_ClientCode`, t1.`tis_MasterActivity`, lp3.`mas_Description` AS `lp_tis_MasterActivity`, t1.`tis_SubActivity`, lp4.`sub_Description` AS `lp_tis_SubActivity`,lp5.`tst_Description` AS `lp_tis_Details`,  t1.`tis_Units`, t1.`tis_NetUnits`, t1.`tis_Comments` ,t1.`tis_Details` FROM `tis_timesheetdetails` AS t1 LEFT OUTER JOIN `tis_timesheet` AS lp1 ON (t1.`tis_TCode` = lp1.`tis_Code`) LEFT OUTER JOIN `jos_users` AS lp2 ON (t1.`tis_ClientCode` = lp2.`cli_Code`) LEFT OUTER JOIN `mas_masteractivity` AS lp3 ON (t1.`tis_MasterActivity` = lp3.`mas_Code`) LEFT OUTER JOIN `sub_subactivity` AS lp4 ON (t1.`tis_SubActivity` = lp4.`sub_Code`) LEFT OUTER JOIN `tst_tasktemplates` AS lp5 ON (t1.`tis_Details` = lp5.`tst_Code`)) subq where tis_TCode=".$row['tis_Code'];
                 $res_details = mysql_query($sql_details);
                $count = mysql_num_rows($res_details);
                $recid=0;
                while($row_details=mysql_fetch_array($res_details))
                {
                $this->showroweditor_details_edit($row_details, true,$recid);
                $recid++;
                }
                ?>
                <input type="hidden" name="count" value="<?php echo $count ?>">
                <tr>
                    <td colspan="7">
                        <input type="submit" name="action" value="Update" class="button"> <input type="button" value="Cancel" onClick='return ComfirmCancel();' class="cancelbutton"/>
                    </td>
                </tr>
            </form>
            <form enctype="multipart/form-data" action="tis_timesheet.php" method="post" name="timesheet_new"  onSubmit="return validateFormOnSubmit_new()">
                <input type="hidden" name="sql" value="update_details">
                <input type="hidden" name="action" value="insert_new">
                <input type="hidden" name="xtis_Code" value="<?php echo $row["tis_Code"] ?>">
                <input type="hidden" name="tid" value="<?php echo $_GET['tid'] ?>">
                <?php
                    $this->showroweditor_details_add($row, true);
                 ?>
            </form>
            <?php
        }

}
	$timesheetContent = new timesheetContentList();

?>

