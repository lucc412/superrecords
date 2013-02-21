<?php
    include 'common/varDeclare.php';
    include 'dbclass/salesnotes_content_class.php';
?>
<link href="<?php echo $styleSheet; ?>salesnotes.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>webfxlayout.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>tabpane.js"></script>

<div  id="tabPane3" style="margin-left:-10px;">
        <script type="text/javascript">
            tp3 = new WebFXTabPane( document.getElementById( "tabPane3" ) );
        </script>
        <?php
                if(($access_file_level_salesdetails['stf_Add']=="Y" || $access_file_level_salesdetails['stf_Edit']=="Y" || $access_file_level_salesdetails['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                      <div class="tab-page" id="tabPage55">
                          <h2 class="tab" id="card">Entity Details</h2>
                                     <script type="text/javascript">
                                         var alertval="edit";
                                     tp3.addTabPage( document.getElementById( "tabPage55" ) );
                                    </script>
                                    <?php
                                      if($access_file_level_salesdetails==0)
                                        {
                                            //If View, Add, Edit, Delete all set to N
                                            echo "You are not authorised to view this file.";
                                        }
                                      else if(is_array($access_file_level_salesdetails)==1)
                                      {
                                            $salesnotesContent->sndetailsContent();
                                      }
                                      ?>
                    </div>
                <?php
                }
                else if($access_file_level_salesdetails['stf_View']=="Y" && $_GET['a']=="view")
                {
                ?>
                      <div class="tab-page" id="tabPage55">
                          <h2 class="tab">Entity Details</h2>
                                     <script type="text/javascript">
                                         var alertval="";
                                         tp3.addTabPage( document.getElementById( "tabPage55" ) );
                                     </script>
                                    <?php
                                      if($access_file_level_salesdetails==0)
                                        {
                                            //If View, Add, Edit, Delete all set to N
                                            echo "You are not authorised to view this file.";
                                        }
                                      else if(is_array($access_file_level_salesdetails)==1)
                                      {
                                            $salesnotesContent->sndetailsContent();
                                      }
                                      ?>
                     </div>
                <?php }
                if(($access_file_level_salesstatus['stf_Add']=="Y" || $access_file_level_salesstatus['stf_Edit']=="Y" || $access_file_level_salesstatus['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                    <div class="tab-page" id="tabPage56">
                            <h2 class="tab">Current Status</h2>
                            <script type="text/javascript">
                                var alertval="edit";
                                tp3.addTabPage( document.getElementById( "tabPage56" ) );
                            </script>
                            <?php
                              if($access_file_level_salesstatus==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                              else if(is_array($access_file_level_salesstatus)==1)
                              {
                                $salesnotesContent->snstatusContent();
                              }
                              ?>
                    </div>
                <?php
                }
                else if($access_file_level_salesstatus['stf_View']=="Y"  && $_GET['a']=="view")
                {
                ?>
                    <div class="tab-page" id="tabPage56">
                            <h2 class="tab">Current Status</h2>
                            <script type="text/javascript">
                                var alertval="";
                                tp3.addTabPage( document.getElementById( "tabPage56" ) );
                            </script>
                            <?php
                              if($access_file_level_salesstatus==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                              else if(is_array($access_file_level_salesstatus)==1)
                              {
                                    $salesnotesContent->snstatusContent();
                              }
                              ?>
                    </div>
                <?php
                }
                if(($access_file_level_salestasks['stf_Add']=="Y" || $access_file_level_salestasks['stf_Edit']=="Y" || $access_file_level_salestasks['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                    <div class="tab-page" id="tabPage57">
                        <h2 class="tab" id="invoice">Tasks</h2>
                                <script type="text/javascript">
                                    var alertval="edit";
                                    tp3.addTabPage( document.getElementById( "tabPage57" ) );
                                </script>
                                <?php
                                  if($access_file_level_salestasks==0)
                                    {
                                        //If View, Add, Edit, Delete all set to N
                                        echo "You are not authorised to view this file.";
                                  }
                                  else if(is_array($access_file_level_salestasks)==1)
                                  {
                                        $salesnotesContent->sntasksContent();
                                  }
                                ?>
                   </div>
                <?php
                }
                else if($access_file_level_salestasks['stf_View']=="Y" && $_GET['a']=="view")
                {
                ?>
                    <div class="tab-page" id="tabPage57">
                                <h2 class="tab">Tasks</h2>
                                <script type="text/javascript">
                                    var alertval="";
                                    tp3.addTabPage( document.getElementById( "tabPage57" ) );
                                </script>
                                <?php
                                  if($access_file_level_salestasks==0)
                                    {
                                        //If View, Add, Edit, Delete all set to N
                                        echo "You are not authorised to view this file.";
                                    }
                                  else if(is_array($access_file_level_salestasks)==1)
                                  {
                                        $salesnotesContent->sntasksContent();
                                  }
                                ?>
                   </div>
                <?php
                }
                if(($access_file_level_salesnotes['stf_Add']=="Y" || $access_file_level_salesnotes['stf_Edit']=="Y" || $access_file_level_salesnotes['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                    <div class="tab-page" id="tabPage58">
                            <h2 class="tab">Notes</h2>
                            <script type="text/javascript">
                                var alertval="edit";
                                tp3.addTabPage( document.getElementById( "tabPage58" ) );
                            </script>
                            <?php
                              if($access_file_level_salesnotes==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                              else if(is_array($access_file_level_salesnotes)==1)
                              {
                                    $salesnotesContent->snnotesContent();
                               }
                               ?>
                    </div>
                <?php
                }
                else if($access_file_level_salesnotes['stf_View']=="Y" && $_GET['a']=="view")
                {
                ?>
                    <div class="tab-page" id="tabPage58">
                            <h2 class="tab">Notes</h2>
                            <script type="text/javascript">
                                var alertval="";
                                tp3.addTabPage( document.getElementById( "tabPage58" ) );
                            </script>
                            <?php
                              if($access_file_level_salesnotes==0)
                                {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                                }
                              else if(is_array($access_file_level_salesnotes)==1)
                              {
                                    $salesnotesContent->snnotesContent();
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
