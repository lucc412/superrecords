<!--*************************************************************************************************
//  Task          : Page for Adding Task details
//  Modified By   : Nishant Bhatt 
//  Created on    : 6-Jan-2014
//  Last Modified : 6-Jan-2014
//************************************************************************************************-->
<div class="frmheading">
	<h1>Add Record</h1>
</div>

<div style="position:absolute; top:20; right:-90px; width:300; height:300;">
<font style="color:red; font-family:Arial, Helvetica, sans-serif" size="2">Fields marked with * are mandatory</font></div>

<form action="audit_checklist.php?sql=insert" method="POST" name="managechecklist" onSubmit="return validateFormOnSubmit()">

	<table class="tbl" border="0" cellspacing="10" width="70%">
		<tr>
			<td class="hr">Checklist Name <font style="color:red;" size="2">*</font></td>
			<td class="dr">
				<input type="text" name="txtCheckListName" id="txtCheckListName" size="26" value="">
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Checklist or Subchecklist.</span></a>
			</td>
		</tr>
		
		<tr>
		   <td class="hr">Parent Checklist</td>		   
		   <td>
		   		<select id="selParent" name="selParent">
					<option value="0">Select Checklist</option><?php
					while($arrInfo = mysql_fetch_assoc($arrChecklist)) {
						?><option value="<?=$arrInfo['cid'];?>"><?=$arrInfo['name'];?></option><? 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">While Add SubChecklist you have to select Checklist.</span></a>
			</td>
		</tr>
		<tr>
		   <td class="hr">Order</td>		   
		   <td>
		   		<select id="order" name="order">
					<option value="0">Select order</option><?php
					for($i=1;$i<=$order;$i++){
						?><option value="<?=$i;?>"><?=$i;?></option><? 
					} 
				?></select>
				<a class="tooltip" href="#"><img src="images/help.png"><span class="help">While Add SubChecklist you have to select Checklist.</span></a>
			</td>
		</tr>
		
		
		<tr>
			<td><button type="button" value="Cancel" onClick='javascript:history.go(-1);' class="cancelbutton">Cancel</button></td>
			<td><button type="submit" name="action" value="Save" class="button">Save</button></td>
	</tr>
</table>
</form>
<script>
	function validateFormOnSubmit(){
		if($("#txtCheckListName").val()==""){
				txtCheckListName.className = "errclass";
				txtCheckListName.focus();
			return false;
		}
	}
</script>