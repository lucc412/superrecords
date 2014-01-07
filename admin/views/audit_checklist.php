<?php
//*************************************************************************************************
//  Task          : Page List of Audit Checklists
//  Modified By   : Nishant Bhatt
//  Created on    : 6-Jan-2014
//  Last Modified : 6-Jan-2014
//************************************************************************************************
?>
<div class="frmheading">
	<h1>Audit <?=isset($_REQUEST['parent_id'])?"Sub":"";?>Checklist</h1>
</div>
<script type="text/javascript" src="http://www.befreetest.com/script/jquery_sort_data.js"></script>
<script type="text/javascript" src="http://www.befreetest.com/script/sort_data.js"></script>
<form action="audit_checklist.php<?=isset($_REQUEST['parent_id'])?"?parent_id=".$_REQUEST['parent_id']:"";?>" method="post">
<table class="customFilter" border="0" cellspacing="1" cellpadding="4" align="right" style="margin-right:15px; ">
<tr>
<td><b>Custom Filter</b>&nbsp;</td>
<td><input type="text" name="filter" value="<?php echo isset($_SESSION['filter'])?$_SESSION['filter']:"";?>"></td>
<td><input class="checkboxClass" type="checkbox" name="wholeonly" <?php echo isset($_SESSION['wholeonly'])?"checked":"";?> value="1">Whole words only</td>
</tr>
<tr>
<td>&nbsp;</td>
<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button></td>
<td><a href="audit_checklist.php?a=reset<?=isset($_REQUEST['parent_id'])?"&parent_id=".$_REQUEST['parent_id']:"";?>" class="hlight">Reset Filter</a></td>
</tr>
</table>
</form>
<table class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5"><?

	if($access_file_level['stf_Add'] == "Y") {
		?><tr>
			<td><a href="audit_checklist.php?a=add" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
			</td>
		</tr><?
	}
		
	?>
</table>
<table class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="5">
	<tr class="fieldheader">
		<th width="50%" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');" class="fieldheader sort_column">Audit Checklist Name <img id="sort_name" src="images/sort_asc.png"></th>
		<th width="30%" align="left" class="fieldheader">Order</th>		
		<td width="20%" class="fieldheader" colspan="2" align="center">Actions</td>
	</tr><?

	$countRow = 0;
	while($arrInfo = mysql_fetch_assoc($arrChecklist)) {
		if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";
 
		?><tr class="<?=$trClass?>">
			
			<td><?=htmlspecialchars($arrInfo["name"])?></td>

			<td>
			<form action="audit_checklist.php?sql=order_update" method="post">
				<select name="order" onchange="if(confirm('Save?')){this.form.gridedit.click();} else { }">
					<option value="0">Select Order</option>
					<? for($i=1;$i<=$arrCount;$i++){ ?>
						<option value="<?=$i;?>" <? if($arrInfo["corder"] == $i){ echo "selected";}?>><?=$i;?></option>
					<? }?>
				</select>
				<input type="hidden" name="id" value="<?=isset($_REQUEST['parent_id'])?$arrInfo["sid"]:$arrInfo["cid"];?>">
				<input  type="hidden" name="parent_ids" id="parent_ids" value="<?=isset($_REQUEST['parent_id'])?$_REQUEST['parent_id']:0;?>" />
				<button type="submit" name="gridedit" value="save">Save</button>
			</form>
	<? //=stripslashes($arrInfo["corder"])?></td>

		  	<?
			
			if($access_file_level['stf_View'] == "Y" && !isset($_REQUEST['parent_id'])) {
				?><td align="center">
					<a href="audit_checklist.php?parent_id=<?=$arrInfo["cid"]?>&reset=1">
					<img src="images/view.png" border="0"  alt="View" name="View" title="View SubChecklist" align="middle" /></a>
				</td><?
			}

			if($access_file_level['stf_Edit'] == "Y") {
				?><td align="center">
					<a href="audit_checklist.php?a=edit&id=<?=isset($_REQUEST['parent_id'])?$arrInfo["sid"]."&pid=".$arrInfo["cid"]:$arrInfo["cid"];?>">
					<img src="images/edit.png" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
				</td><?
			}
			
			/*if($access_file_level['stf_Delete'] == "Y") {
				?><td align="center"><?
					if(!isset($_REQUEST['parent_id'])) {
						$jsFunc = "javascript:performdelete('audit_checklist.php?sql=delete&checklist_id=".$arrInfo["cid"]."');";
					} else {
						$jsFunc = "javascript:performdelete('audit_checklist.php?sql=delete&parent_id=".$arrInfo["cid"]."&subchecklist_id=".$arrInfo["sid"]."');";
					}
					?><a onClick="<?=$jsFunc?>" href="javascript:;">
					<img src="images/erase.png" border="0"  alt="Delete" name="Delete" title="Delete" align="middle" /></a>
				</td><?
			}*/

		?></tr><?
	$countRow++;
	}
?></table><br>