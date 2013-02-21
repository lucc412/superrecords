<?php
    include("common/class.Database.php");
    include("dbclass/commonFunctions_class.php");
    		if($_POST['flagbut']=="Submit")
                {
                   //get last date and future contact date
                   $cliCode = $_GET['cli_code'];
                        $date_query = "SELECT cli_Lastdate, cli_FutureContactDate FROM jos_users WHERE cli_Code=".$cliCode;
                        $res_query = mysql_query($date_query);
                        $Lastdate = @mysql_fetch_array($res_query);

                   if($_POST['flagVal']=="today")
                   {
                        $flagday=date( 'Y-m-d H:i:s' );
                        $flagVal = "today";
                   }
                   else if($_POST['flagVal']=="tmrw")
                   {
                       $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
                       $flagday = date('Y-m-d',$tomorrow);
                       $flagVal = "tmrw";
                   }
                   else if($_POST['flagVal']=="thisweek")
                   {
                            //This week date
                            $myCurrentDayIs = date("D");

                            if($myCurrentDayIs == "Mon")
                            {
                                $day_for_fri = date("Y-m-d",time()+(60*60*24*4));
                            }

                            if($myCurrentDayIs == "Tue")
                            {
                                $day_for_fri = date("Y-m-d",time()+(60*60*24*3));
                            }

                            if($myCurrentDayIs == "Wed")
                            {
                                $day_for_fri = date("Y-m-d",time()+(60*60*24*2));
                            }

                            if($myCurrentDayIs == "Thu")
                            {
                                $day_for_fri = date("Y-m-d",time()+(60*60*24*1));
                            }

                            if($myCurrentDayIs == "Fri")
                            {
                                $day_for_fri = date("Y-m-d");
                            }

                        $flagday = $day_for_fri;
                       $flagVal = "tweek";
                   }
                  else if($_POST['flagVal']=="nextweek")
                   {
                        //Next week date
                        $myCurrentDayIs = date("D");

                        if($myCurrentDayIs == "Mon")
                        {
                            $day_for_mon = date("Y-m-d",time()+(60*60*24*7));
                        }

                        if($myCurrentDayIs == "Tue")
                        {
                            $day_for_mon = date("Y-m-d",time()+(60*60*24*6));
                        }

                        if($myCurrentDayIs == "Wed")
                        {
                            $day_for_mon = date("Y-m-d",time()+(60*60*24*5));
                        }

                        if($myCurrentDayIs == "Thu")
                        {
                            $day_for_mon = date("Y-m-d",time()+(60*60*24*4));
                        }

                        if($myCurrentDayIs == "Fri")
                        {
                            $day_for_mon = date("Y-m-d",time()+(60*60*24*3));
                        }
                       $flagday = $day_for_mon;
                       $flagVal = "nweek";
                   }
                   else if($_POST['flagVal']=="marked")
                   {
                       $marked = "Y";
                       $flagVal = "mark";
                       $lastDateContact = $Lastdate['cli_FutureContactDate'];
                   }
                   else if($_POST['flagVal']=="clear")
                   {
                       $flagVal = "0";
                   }
                   
                   if($_POST["cli_StartDate"]!="")
                    {
                        $flagday=$commonUses->getDateFormat($_POST["cli_StartDate"]);
                        $flagVal = "custom";
                    }
                    if($_POST['flagVal']!="marked") {
                     $lastDateContact = $Lastdate['cli_Lastdate'];
                    }
                  $sql_update_quote =mysql_query("update `jos_users` set `cli_Lastdate`='".$lastDateContact."', `cli_Flag`='".$flagVal."', `cli_FutureContactDate`='".$flagday."', `cli_Marked`='".$marked."' where cli_Code=".$cliCode);
                   echo "<script>
                            opener.refresh();
                            window.close();
                    </script>";
                }

?>
<html>
    <head>
        <style type="text/css">
            .flagbutton {
                color:white;
                background:url(images/buttonbg.jpg) repeat-x;
                font-weight:bold;
                cursor:pointer;
                height:18px;
                border:1px solid #000000;
                font-size:11px;
                font-family: Tahoma,Arial;
            }

        </style>
            <script language="JavaScript" src="js/datetimepicker.js"></script>
        <script language="javascript">
            function customVal()
            {
                var selObj = document.getElementById('flagVal');
                if(document.getElementById('flagVal').options[selObj.selectedIndex].text == "Custom")
                    {
                        document.getElementById('customData').style.display = 'block';
                    }
                    else {
                        document.getElementById('customData').style.display = 'none';
                    }
            }
    </script>
    </head>
    <body>
        <form name="flag" method="post" action="cli_flag.php?cli_code=<?php echo $_GET['cli_code']; ?>">
            <div style="margin-left:20px;">
            <label><b>Select</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
            <select name="flagVal" id="flagVal" multiple onchange="customVal()">
                <option value="today">Today</option>
                <option value="tmrw">Tomorrow</option>
                <option value="thisweek">This Week</option>
                <option value="nextweek">Next Week</option>
                <option value="customdate">Custom</option>
                <option value="marked">Mark Complete</option>
                <option value="clear">Clear follow up</option>
            </select>
            <div id="customData" style="display:none;"><br>
                <div><label>Start date</label>&nbsp;&nbsp;&nbsp;
                    <input type="text" name="cli_StartDate" id="cli_StartDate" value="<?php if (isset($row["cli_StartDate"]) && $row["cli_StartDate"]!="") {
                    if($row["cli_StartDate"]!="0000-00-00 00:00:00")
                      $php_startDate = date("d/m/Y",strtotime( $row["cli_StartDate"] ));
                    echo  $php_startDate ; } ?>">&nbsp;<a href="javascript:NewCal('cli_StartDate','ddmmyyyy',false,24)"><img
                    src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
                </div>
            </div><br><br>
            <div style="margin-left:70px;"><input type="submit" name="flagbut" id="flagbut" value="Submit" class="flagbutton">&nbsp;&nbsp;<input type="button" value="Close" onclick="window.close();" class="flagbutton"></div>

            </div>
        </form>
    </body>
</html>