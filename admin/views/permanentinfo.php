<?php
    include 'common/varDeclare.php';
    include 'dbclass/perminfo_content_class.php';
    include 'dbclass/permgeneral_content_class.php';
    include 'dbclass/permbas_content_class.php';
?>
<link href="<?php echo $styleSheet; ?>permanentinfo.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>webfxlayout.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>tabpane.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>permanentinfo.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
<script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>setupsydney.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>perminfoDetails.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>permentity.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>currentstatus.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>backlog.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>generalinfo.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>bank.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>AR.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>AP.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>payroll.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>bas.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>taxreturn.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>specialTasks.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>duedate.js"></script>
<div class="tab-pane" id="tabPane2" style="margin-left:20px; top:-10px; width:100%; white-space:nowrap ">
    <script type="text/javascript">
    tp2 = new WebFXTabPane( document.getElementById( "tabPane2" ) );
    //tp1.setClassNameTag( "dynamic-tab-pane-control-luna" );
    //alert( 0 )
    </script>
            <?php
                    if(($access_file_level_syd['stf_Add']=="Y" || $access_file_level_syd['stf_Edit']=="Y" || $access_file_level_syd['stf_Delete']=="Y") &&  $_GET['a']=="edit")
                    {
                    ?>
                    <div class="tab-page" id="tabPage20">
                        <h2 class="tab">Set up Syd</h2>
                            <script type="text/javascript">
                                var alertval="edit";
                                tp2.addTabPage( document.getElementById( "tabPage20" ) );
                            </script>
                            <?php
                              if($access_file_level_syd==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_syd)==1)
                                {
                                    $perminfoContent->setupSydney();
                                }
                              ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_syd['stf_View']=="Y" && $_GET['a']=="view")
                    {
                    ?>
                    <div class="tab-page" id="tabPage20">
                            <h2 class="tab">Set up Syd</h2>
                            <script type="text/javascript">
                                var alertval="";
                                tp2.addTabPage( document.getElementById( "tabPage20" ) );
                            </script>
                            <?php
                              if($access_file_level_syd==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_syd)==1)
                                {
                                    $perminfoContent->setupSydney();
                                }
                              ?>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if(($access_file_level_perminfo['stf_Add']=="Y" || $access_file_level_perminfo['stf_Edit']=="Y" || $access_file_level_perminfo['stf_Delete']=="Y") &&  $_GET['a']=="edit")
                    {
                    ?>
                    <div class="tab-page" id="tabPage8">
                        <h2 class="tab">Perm Info</h2>
                        <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage8" ) );</script>
                            <?php
                              if($access_file_level_perminfo==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_perminfo)==1)
                                {
                                    $perminfoContent->perminfoDetails();
                                }
                              ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_perminfo['stf_View']=="Y" &&  $_GET['a']=="view")
                    {
                    ?>
                        <div class="tab-page" id="tabPage8">
                            <h2 class="tab">Perm Info</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage8" ) );</script>
                            <?php
                              if($access_file_level_perminfo==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_perminfo)==1)
                                {
                                    $perminfoContent->perminfoDetails();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    if(($access_file_level_curst['stf_Add']=="Y" || $access_file_level_curst['stf_Edit']=="Y" || $access_file_level_curst['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                            <div class="tab-page" id="tabPage21">
                                <h2 class="tab">Current Status</h2>
                                <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage21" ) );</script>
                            <?php
                              if($access_file_level_curst==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_curst)==1)
                                {
                                  $perminfoContent->currentStatus();
                                }
                              ?>
                            </div>
                    <?php
                    }
                    else if($access_file_level_curst['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                       <div class="tab-page" id="tabPage21">
                            <h2 class="tab">Current Status</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage21" ) );</script>
                       <?php
                              if($access_file_level_curst==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_curst)==1)
                                {
                                    $perminfoContent->currentStatus();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    if(($access_file_level_blj['stf_Add']=="Y" || $access_file_level_blj['stf_Edit']=="Y" || $access_file_level_blj['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                    <div class="tab-page" id="tabPage10">
                        <h2 class="tab">Back Log Jobsheet</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage10" ) );</script>
                        <?php
                              if($access_file_level_blj==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_blj)==1)
                                {
                                    $perminfoContent->backlogJobsheet();
                                }
                               ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_blj['stf_View']=="Y" &&  $_GET['a']=="view")
                    {
                    ?>
                    <div class="tab-page" id="tabPage10">
                            <h2 class="tab">Back Log Jobsheet</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage10" ) );</script>
                        <?php
                              if($access_file_level_blj==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_blj)==1)
                                {
                                    $perminfoContent->backlogJobsheet();
                                }
                               ?>
                    </div>
                    <?php
                    }
                 /*   if(($access_file_level_gen['stf_Add']=="Y" || $access_file_level_gen['stf_Edit']=="Y" || $access_file_level_gen['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                    <div class="tab-page" id="tabPage11">
                        <h2 class="tab">General Info</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage11" ) );</script>
                       <?php
                              if($access_file_level_gen==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_gen)==1)
                                {
                                    $permgeneralContent->generalInfo();
                                }
                               ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_gen['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                    <div class="tab-page" id="tabPage11">
                            <h2 class="tab">General Info</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage11" ) );</script>
                       <?php
                              if($access_file_level_gen==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_gen)==1)
                                {
                                    $permgeneralContent->generalInfo();
                                }
                               ?>
                    </div>
                    <?php
                    } */
                    if(($access_file_level_ban['stf_Add']=="Y" || $access_file_level_ban['stf_Edit']=="Y" || $access_file_level_ban['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                            <div class="tab-page" id="tabPage12">
                                <h2 class="tab">Bank</h2>
                                <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage12" ) );</script>
                            <?php
                              if($access_file_level_ban==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_ban)==1)
                                {
                                    $permgeneralContent->bank();
                                 }
                                 ?>
                            </div>
                    <?php
                    }
                    else if($access_file_level_ban['stf_View']=="Y" &&  $_GET['a']=="view")
                    {
                    ?>
                         <div class="tab-page" id="tabPage12">
                            <h2 class="tab">Bank</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage12" ) );</script>
                        <?php
                              if($access_file_level_ban==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_ban)==1)
                                {
                                    $permgeneralContent->bank();
                                }
                                ?>

                        </div>
                    <?php
                    }
                    // AR
                    if(($access_file_level_are['stf_Add']=="Y" || $access_file_level_are['stf_Edit']=="Y" || $access_file_level_are['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                        <div class="tab-page" id="tabPage13">
                                <h2 class="tab">Investments</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage13" ) );</script>
                         <?php
                              if($access_file_level_are==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_are)==1)
                                {   
                                    $permgeneralContent->AR();
                                }
                          ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_are['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                        <div class="tab-page" id="tabPage13">
                            <h2 class="tab">Investments</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage13" ) );</script>
                         <?php
                              if($access_file_level_are==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_are)==1)
                                {
                                    $permgeneralContent->AR();
                                 }
                          ?>
                        </div>
                    <?php
                    }
                    if(($access_file_level_tax['stf_Add']=="Y" || $access_file_level_tax['stf_Edit']=="Y" || $access_file_level_tax['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                    <div class="tab-page" id="tabPage16">
                        <h2 class="tab">Tax Returns</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage16" ) );</script>
                            <?php
                              if($access_file_level_tax==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_tax)==1)
                                {
                                    $permbasContent->taxReturn();
                                }
                                ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_tax['stf_View']=="Y" &&  $_GET['a']=="view")
                    {
                    ?>
                    <div class="tab-page" id="tabPage16">
                            <h2 class="tab">Tax Returns</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage16" ) );</script>
                            <?php
                              if($access_file_level_tax==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_tax)==1)
                                {
                                    $permbasContent->taxReturn();
                                }
                                ?>
                    </div>
                    <?php
                    }
                /*    if(($access_file_level_ape['stf_Add']=="Y" || $access_file_level_ape['stf_Edit']=="Y" || $access_file_level_ape['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                            <div class="tab-page" id="tabPage14">
                                <h2 class="tab">AP</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage14" ) );</script>
                            <?php
                              if($access_file_level_ape==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_ape)==1)
                                {
                                    $permgeneralContent->AP();
                                 }
                                 ?>
                            </div>
                    <?php
                    }
                    else if($access_file_level_ape['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                        <div class="tab-page" id="tabPage14">
                            <h2 class="tab">AP</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage14" ) );</script>
                            <?php
                              if($access_file_level_ape==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_ape)==1)
                                {
                                    $permgeneralContent->AP();
                                }
                                ?>
                        </div>
                    <?php
                    }
                    if(($access_file_level_pay['stf_Add']=="Y" || $access_file_level_pay['stf_Edit']=="Y" || $access_file_level_pay['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                    <div class="tab-page" id="tabPage15">
                        <h2 class="tab">Payroll</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage15" ) );</script>
                        <?php
                              if($access_file_level_pay==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_pay)==1)
                                {
                                    $permgeneralContent->payroll();
                                }
                                ?>
                    </div>
                    <?php
                    }
                    else if($access_file_level_pay['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                    <div class="tab-page" id="tabPage15">
                            <h2 class="tab">Payroll</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage15" ) );</script>
                             <?php
                              if($access_file_level_pay==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_pay)==1)
                                {
                                    $permgeneralContent->payroll();
                                }
                                ?>
                    </div>
                    <?php
                    } */
                    if(($access_file_level_bas['stf_Add']=="Y" || $access_file_level_bas['stf_Edit']=="Y" || $access_file_level_bas['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                         <div class="tab-page" id="tabPage51">
                                <h2 class="tab">BAS</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage51" ) );</script>
                            <?php
                              if($access_file_level_bas==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_bas)==1)
                                {
                                    $permbasContent->BAS();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    else if($access_file_level_bas['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                        <div class="tab-page" id="tabPage51">
                            <h2 class="tab">BAS</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage51" ) );</script>
                            <?php
                              if($access_file_level_bas==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_bas)==1)
                                {
                                    $permbasContent->BAS();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    if(($access_file_level_specialtasks['stf_Add']=="Y" || $access_file_level_specialtasks['stf_Edit']=="Y" || $access_file_level_specialtasks['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                       <div class="tab-page" id="tabPage51">
                                <h2 class="tab">Special Tasks</h2>
                                <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage51" ) );</script>
                            <?php
                              if($access_file_level_specialtasks==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_specialtasks)==1)
                                {
                                    $permbasContent->specialTasks();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    else if($access_file_level_specialtasks['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                        <div class="tab-page" id="tabPage51">
                            <h2 class="tab">Special Tasks</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage51" ) );</script>
                            <?php
                              if($access_file_level_specialtasks==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_specialtasks)==1)
                                {
                                    $permbasContent->specialTasks();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    // Due dates and Reports
                    if(($access_file_level_duedate['stf_Add']=="Y" || $access_file_level_duedate['stf_Edit']=="Y" || $access_file_level_duedate['stf_Delete']=="Y" ) &&  $_GET['a']=="edit")
                    {
                    ?>
                        <div class="tab-page" id="tabPage51" style="width: 800px">
                                <h2 class="tab">Task List</h2>
                                <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage51" ) );</script>
                            <?php
                              if($access_file_level_duedate==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_duedate)==1)
                                {
                                    //$permbasContent->dueDate();
                                    $permbasContent->taskList();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    else if($access_file_level_duedate['stf_View']=="Y" &&   $_GET['a']=="view")
                    {
                    ?>
                      <div class="tab-page" id="tabPage51" style="width: 800px">
                            <h2 class="tab">Task List</h2>
                            <script type="text/javascript">tp2.addTabPage( document.getElementById( "tabPage51" ) );</script>
                            <?php
                              if($access_file_level_duedate==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                                else if(is_array($access_file_level_duedate)==1)
                                {
                                    //$permbasContent->dueDate();
                                    $permbasContent->taskList();
                                }
                              ?>
                        </div>
                    <?php
                    }
                    ?>
</div>



<script type="text/javascript">
//<![CDATA[

setupAllTabs();

//]]>
</script>
 