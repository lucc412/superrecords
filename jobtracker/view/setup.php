<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * created by Siddhesh Champaneri
 */

include(TOPBAR);
?>
<script>
$(document).ready(function(){
     $('.orderBtn').click(function() {
        $("#dialog-confirm").dialog({
                autoOpen: false,
                modal: true,
                resizable: false,
                height:250,
                buttons: {
                    "Ok": function() {
                        $( this ).dialog( "close" );
                    }
                }   
          });
          $( "#dialog-confirm" ).dialog( "open" );
      });
});
</script>
<style>
    .ui-dialog
    {
        height: 142px !important;
        width: 550px !important;
    }
    .ui-widget-header{
        background: url("../images/submit-bg.jpg") no-repeat scroll left center #074165;
        color: #FFF;
    }
    .ui-dialog-content{
        height: 40px !important;
        overflow: hidden !important;
    }
</style>
<div id="dialog-confirm" title="Message" style="display: none;">
      Coming soon. Please contact us on <b>1800 278 737</b>.
</div>

<div class="pageheader">
	<h1>Order Documents</h1>
	<span>
		<b>Welcome to the Super Records order documents page.</b></br>If you would like to retrieve the saved order, please click on <i>Retrieve saved jobs</i> under Jobs menu. Otherwise please select the document you would like to order from below list.
	<span>
</div>
<div class="wrap" style="min-height: 350px; ">
    <?php 
    
    foreach ($arrForms as $forms => $subforms) { ?>
        <h1 style="font-size: 15px;color: #F05729"><?=$subforms['form_name']?></h1>
        <br>
        <ul>
        <?php foreach($subforms['subforms'] as $frm => $frmVal){    ?>
            <li>
                <div style="width: 550px;float: left;padding: 4px 0 5px;"><span class="checklistlabel"><?=$frmVal['subform_name']?></span></div>
                <div style="width: 60px;float: left;padding: 4px 0 5px;"><span class="checklistlabel"><?='$'.$frmVal['subform_price'];?></span></div><?
                if(!empty($frmVal['subform_url'])) {
                    ?><button style="width: 82px;margin: 0" onclick='window.location.href="setup/<?=$frmVal['subform_url']?>?frmId=<?=$frmVal['subform_id']?>"' >Order</button><?
                }
                else {
                    ?><button style="width: 82px;margin: 0" class="orderBtn">Order</button><?
                }
            ?></li>
        <?php } ?>
        </ul>        
        <br>
    <?php } ?>
</div>
<?
// include footer file
include(FOOTER);
?>