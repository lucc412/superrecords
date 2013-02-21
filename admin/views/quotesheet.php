<?php
    include 'common/varDeclare.php';
    include 'dbclass/quotesheet_content_class.php';
?>
<link href="<?php echo $styleSheet; ?>quotesheet.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>webfxlayout.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>tabpane.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>qcardfile.js"></script>
<script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
<script language="JavaScript" src="<?php echo $javaScript; ?>quotesheet.js"></script>

<div  id="tabPane1" style="margin-left:-10px;">
        <script type="text/javascript">
            tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );
        </script>
        <?php
                if(($access_file_level_crd['stf_Add']=="Y" || $access_file_level_crd['stf_Edit']=="Y" || $access_file_level_crd['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                      <div class="tab-page" id="tabPage1">
                          <h2 class="tab" id="card">Card File Info</h2>
                                     <script type="text/javascript">
                                         var alertval="edit";
                                         tp1.addTabPage( document.getElementById( "tabPage1" ) );
                                     </script>
                                    <?php
                                      if($access_file_level_crd==0)
                                        {
                                            //If View, Add, Edit, Delete all set to N
                                            echo "You are not authorised to view this file.";
                                        }
                                      else if(is_array($access_file_level_crd)==1)
                                      {
                                            $quotesheetContentlist->cardfileinfo();
                                      }
                                      ?>
                      </div>
                <?php
                }
                else if($access_file_level_crd['stf_View']=="Y" && $_GET['a']=="view")
                {
                ?>
                      <div class="tab-page" id="tabPage2">
                          <h2 class="tab">Card File Info</h2>
                                     <script type="text/javascript">
                                         var alertval="";
                                         tp1.addTabPage( document.getElementById( "tabPage2" ) );
                                     </script>
                                    <?php
                                      if($access_file_level_crd==0)
                                      {
                                            //If View, Add, Edit, Delete all set to N
                                            echo "You are not authorised to view this file.";
                                      }
                                      else if(is_array($access_file_level_crd)==1)
                                      {
                                            $quotesheetContentlist->cardfileinfo();
                                      }
                                      ?>
                      </div>
                <?php
                }
                if(($access_file_level_inv['stf_Add']=="Y" || $access_file_level_inv['stf_Edit']=="Y" || $access_file_level_inv['stf_Delete']=="Y") && $_GET['a']=="edit")
                {
                ?>
                                <div class="tab-page" id="tabPage5">
                                    <h2 class="tab" id="invoice">Invoice</h2>
                                            <script type="text/javascript">
                                                var alertval="edit";
                                                tp1.addTabPage( document.getElementById( "tabPage5" ) );
                                            </script>

                                            <?php
                                              if($access_file_level_inv==0)
                                              {
                                                    //If View, Add, Edit, Delete all set to N
                                                    echo "You are not authorised to view this file.";
                                              }
                                              else if(is_array($access_file_level_inv)==1)
                                              {
                                                    $quotesheetContentlist->invoiceContent();
                                              }
                                            ?>
                                                <script>
                                                    var isDirty = false;
                                                    $(document).ready(function(){

                                                        $('a').click(function(){
                                                               var form_val = $(this).parent().attr("id");
                                                               var form_id = "form_"+form_val;
                                                              // alert(form_id);
                                                            $('#'+form_id+' > :input').change(function(){
                                                            if(!isDirty){
                                                                isDirty = true;
                                                            }
                                                        });
                                                            if(isDirty){
                                                                var confirmExit = confirm('Are you sure? You haven\'t saved your changes. Click OK to leave or Cancel to go back and save your changes.');
                                                                if(confirmExit){
                                                                    return true;
                                                                }
                                                                else{
                                                                    return false;
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                </div>
                <?php } else if($access_file_level_inv['stf_View']=="Y" && $_GET['a']=="view")
                {
                ?>
                    <div class="tab-page" id="tabPage6">
                                <h2 class="tab">Invoice</h2>
                                <script type="text/javascript">
                                    var alertval="";
                                    tp1.addTabPage( document.getElementById( "tabPage6" ) );
                                </script>

                                <?php
                                  if($access_file_level_inv==0)
                                  {
                                        //If View, Add, Edit, Delete all set to N
                                        echo "You are not authorised to view this file.";
                                  }
                                  else if(is_array($access_file_level_inv)==1)
                                  {
                                        $quotesheetContentlist->invoiceContent();
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
