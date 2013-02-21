<?php
class clidocumentContentList extends Database
{
       // client document content
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
                  global $clidocumentQuery;
                  global $commonUses;
                  
                  $res = $clidocumentQuery->sql_select();
                  $count = $clidocumentQuery->sql_getrecordcount();
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
                <?php if($_REQUEST['app']==1) { ?>
                    <span class="frmheading">View Admin Uploaded Documents</span>
                <?php } else { ?>
                    <span class="frmheading">View Client Uploaded Documents</span>
                <?php } ?>
                <hr size="1" noshade>
                <?php
                //get client name
                $typeapp = $_REQUEST['app'];
                $clientid = $_REQUEST['mid'];
                $get_query = "SELECT name FROM jos_users where id=$clientid";
                $cli_query = mysql_query($get_query);
                $cli_name = @mysql_fetch_array($cli_query);
                $clientname = $cli_name['name'];
                ?>
                <div style="font-size:12px;"><b>Client Name:</b> <?php echo $clientname; ?></div>
                <?php if($count!="0") { ?>
                <p>&nbsp;</p>
                <br><br>
                 <table class="fieldtable_outer">
                    <tr>
                        <td>
                        <?php   $this->showpagenav($page, $pagecount); ?><div class="msg"><?php echo $_GET['file']."\r\r\r\r\r\r" ;?><?php echo  $_GET['msg']; ?></div>
                        <br>
                        <table class="fieldtable" border="0" cellspacing="1" cellpadding="5">
                                <tr class="fieldheader">
                                    <th rowspan="2" class="fieldheader">Document</th>
                                    <th rowspan="2" class="fieldheader">Uploaded Date</th>
                                    <th rowspan="2" class="fieldheader">Downloaded</th>
                                    <th  class="fieldheader" rowspan="2" colspan="3" align="center">Actions</th>
                                </tr><tr></tr>
                            <?php
                              for ($i = $startrec; $i < $reccount; $i++)
                              {
                                $row = mysql_fetch_assoc($res);
                              ?>
                                <tr>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["dmname"]) ?></td>
                                    <td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["dmdate_published"]) ?></td>
                                    <?php foreach($commonUses->getTmpFiles($row['id']) as $files) { ?>
                                    <td class="<?php echo $style ?>">
                                        <a class='hlight' id="tick_<?php echo $i; ?>" style="display:none;">
                                            <img src="images/tick.png" border="0"  alt="Downloaded" name="Downloaded" title="Downloaded" align="middle" />
                                        </a>
                                        <?php
                                           if($row['dmndownload']=="Y")
                                           {
                                            $downloadFiles.="<script>
                                                                    checkdown('$i')
                                                            </script>";
                                           }
                                        ?>
                                        <div id="downimg_<?php echo $i; ?>" onclick="checkdown('<?php echo $i; ?>')">
                                            <a href='../download_attachment.php?file=<?php echo $files; ?>&fid=<?php echo $row['id']; ?>'>
                                                <img src="images/Download.gif" border="0"  alt="Download" name="Download" title="Download" align="middle" />
                                            </a>
                                        </div>
                                    </td>
                                    <?php } ?>
                                    <td style="border:0px;">
                                    <a onClick="performdelete('cli_client_document.php?mode=delete&recid=<?php echo htmlspecialchars($row["id"]) ?>&mid=<?php echo $clientid; ?>&app=<?php echo $typeapp; ?>'); return false;" href="#">
                                        <img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
                                    </td>
                                </tr>
                            <?php
                              }
                            ?>
                        </table>
                </td>
                </tr>
                 </table>
                <br>
                 <?php }
                 else {
                  echo '<div style="color:red; margin-left:370px;">'."Record not found".'</div>';
                 }
                 echo $downloadFiles;
         }
         // page navigation
        function showpagenav($page, $pagecount)
        {
        ?>
        <table   border="0" cellspacing="1" cellpadding="4" align="right" >
        <tr>
         <?php if ($page > 1) { ?>
        <td><a href="cli_client.php?page=<?php echo $page - 1 ?>"><span style="color:#208EB3; ">&lt;&lt;&nbsp;</span></a>&nbsp;</td>
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
        <td><a href="cli_client.php?page=<?php echo $j ?>"><span class="nav_links"><?php echo $j ?></span></a></td>
        <?php } } } else { ?>
        <td><a href="cli_client.php?page=<?php echo $startpage ?>"><span class="nav_links"><?php echo $startpage ."..." .$count ?></span></a></td>
        <?php } } } ?>
        <?php if ($page < $pagecount) { ?>
        <td>&nbsp;<a href="cli_client.php?page=<?php echo $page + 1 ?>"><span class="nav_links">&nbsp;&gt;&gt;</span></a>&nbsp;</td>
        <?php } ?>
        </tr>
        </table>
        <?php }
        function  adminLink()
        {
            $typeapp = $_REQUEST['app'];
            if($typeapp==1) { ?>
                <div style="position:relative; top:0px;"><a href="../administrator/index2.php?sid=<?php echo $_GET['mid']; ?>" class="frmheading">Click Here To Upload Admin Documents</a></div>
            <?php } ?>
        <br><br>
        <div><a href="cli_client.php" class="frmheading">Go to Client List</a></div>
        <?php
        }
}
	$clidocumentContent = new clidocumentContentList();
?>

