<?php
    include 'common/varDeclare.php';
    include 'dbclass/hosting_content_class.php';
?>
<link href="<?php echo $styleSheet; ?>hosting.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $javaScript; ?>webfxlayout.js"></script>
<script type="text/javascript" src="<?php echo $javaScript; ?>tabpane.js"></script>
<div  id="tabHostPane1" style="margin-left:-10px;">
<script type="text/javascript">
tp1 = new WebFXTabPane( document.getElementById( "tabHostPane1" ) );
//tp1.setClassNameTag( "dynamic-tab-pane-control-luna" );
//alert( 0 )
</script>
<?php 
	if(($access_file_level_host['stf_Add']=="Y" || $access_file_level_host['stf_Edit']=="Y" || $access_file_level_host['stf_Delete']=="Y") && $_GET['a']=="edit")
	{
	?>
              <div class="tab-page" id="tabHost1">
                            <h2 class="tab">Hosting</h2>
                            <script type="text/javascript">tp1.addTabPage( document.getElementById( "tabHost1" ) );</script>
                            <?php
                              if($access_file_level_host==0)
                              {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                              }
                              else if(is_array($access_file_level_host)==1)
                              {
                                    $hostingContent->hostingContent();
                              }
                              ?>
              </div>
	<?php
        }
	else if($access_file_level_host['stf_View']=="Y" && $_GET['a']=="view")
	{
	?>
              <div class="tab-page" id="tabHost2">
                            <h2 class="tab">Hosting</h2>
                            <script type="text/javascript">tp1.addTabPage( document.getElementById( "tabHost2" ) );</script>
                            <?php
                              if($access_file_level_host==0)
                              {
                                    //If View, Add, Edit, Delete all set to N
                                    echo "You are not authorised to view this file.";
                              }
                              else if(is_array($access_file_level_host)==1)
                              {
                                    $hostingContent->hostingContent();
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
