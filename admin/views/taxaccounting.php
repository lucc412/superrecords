<?php
    include 'common/varDeclare.php';
    include 'dbclass/taxaccount_content_class.php';
?>
<link href="<?php echo $styleSheet; ?>taxaccount.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>webfxlayout.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>tabpane.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>taxaccount.js"></script>
<div  id="tabPane4" style="margin-left:-10px;">
        <script type="text/javascript">
        tp4 = new WebFXTabPane( document.getElementById( "tabPane4" ) );
        //tp1.setClassNameTag( "dynamic-tab-pane-control-luna" );
        //alert( 0 )
        </script>
        <?php
                if(($access_file_level_taxaccount['stf_Add']=="Y" || $access_file_level_taxaccount['stf_Edit']=="Y" || $access_file_level_taxaccount['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                      <div class="tab-page" id="tabPage59">
                          <h2 class="tab" id="card">Tax & Accounting</h2>
                                     <script type="text/javascript">
                                         var alertval="edit";
                                     tp4.addTabPage( document.getElementById( "tabPage59" ) );
                                 </script>
                                    <?php
                                      if($access_file_level_taxaccount==0)
                                        {
                                            //If View, Add, Edit, Delete all set to N
                                            echo "You are not authorised to view this file.";
                                      }
                                      else if(is_array($access_file_level_taxaccount)==1)
                                      {
                                            $taxaccountContent->taxaccountContent();
                                      }
                                      ?>
                    </div>
                <?php
                }
                else if($access_file_level_taxaccount['stf_View']=="Y" && $_GET['a']=="view")
                {
                ?>
                      <div class="tab-page" id="tabPage59">
                          <h2 class="tab">Tax & Accounting</h2>
                                     <script type="text/javascript">
                                         var alertval="";
                                         tp4.addTabPage( document.getElementById( "tabPage59" ) );
                                     </script>
                                    <?php
                                      if($access_file_level_taxaccount==0)
                                        {
                                            //If View, Add, Edit, Delete all set to N
                                            echo "You are not authorised to view this file.";
                                      }
                                      else if(is_array($access_file_level_taxaccount)==1)
                                      {
                                            $taxaccountContent->taxaccountContent();
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
