<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * created by Siddhesh Champaneri
 */

include(TOPBAR);
?>
<style>
    .wrap ul li { list-style: none;padding: 5px;}
    /*.wrap li :hover{color:#F05729;}*/
    .wrap ul{ padding-left: 15px;}
    .wrap li a {color: #074263;}
</style>
<div class="pageheader">
	<h1>Order Documents</h1>
	<span>
		<b>Welcome to the Super Records order documents page.</b></br>If you would like to retrieve the saved order, please click on <i>Retrieve saved jobs</i> under Jobs menu. Otherwise please select the document you would like to order from below list.
	<span>
</div>
<div class="wrap" style="min-height: 350px; ">
    
    <?php foreach ($arrForms as $forms => $subforms) { ?>
        <h1 style="font-size: 15px;color: #F05729"><?=$subforms['form_name']?></h1>
        <br>
        <ul>
        <?php foreach($subforms['subforms'] as $frm => $frmVal){ ?>
            <li>
                <div style="width: 550px;float: left;padding: 4px 0 5px;"><span class="checklistlabel"><?=$frmVal['subform_name']?></span></div>
                <div style="width: 60px;float: left;padding: 4px 0 5px;"><span class="checklistlabel"><?='$'.$frmVal['subform_price'];?></span></div>
                <button style="width: 82px;margin: 0" onclick='window.location.href="jobs.php?a=redirect&type=setup&frmId=<?=$frmVal['subform_id']?>"' >Order</button>
            </li>
        <?php } ?>
        </ul>        
        <br>
    <?php } ?>
</div>
<!--<div style="padding-top:20px;" >
<span align="left"><button type="button" onclick="window.location.href='jobs.php?a=edit&recid=<?=$_SESSION['jobId']?>'" value="BACK" />BACK</button></span>
</div>-->

<?
// include footer file
include(FOOTER);
?>