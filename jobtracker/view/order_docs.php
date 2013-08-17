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
    .wrap li :hover{font-size:12px;color:#F05729;}
    .wrap ul{ padding-left: 15px;}
    .wrap li a {color: #074263;}
</style>
<div class="pageheader">
	<h1>Order Documents</h1>
	<span>
		<b>Welcome to the Super Records job submission page.</b></br>If you would like to retrive the previously saved order, please click on retrive the saved order. Otherwise, to submit the new order, please select start the new order.
	<span>
</div>
<div class="wrap" style="min-height: 350px; ">
    
    <?php
    
    foreach ($arrForms as $forms => $subforms) { ?>
        <h1 style="font-size: 15px;color: #F05729"><?=$subforms['form_name']?></h1>
        <br>
        <ul>
        <?php foreach($subforms['subforms'] as $frm => $frmVal){ ?>
            <li><a href="jobs.php?a=add&type=setup&frmId=<?=$frmVal['subform_id']?>"><?=$frmVal['subform_name']?></a></li>
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