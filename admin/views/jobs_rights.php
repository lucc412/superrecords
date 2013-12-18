<?php
include ("includes/header.php");


//$arrFeatures = $commonUses->getFeatureVisibility();
//$commonUses->showArray($arrFeatures);

?>

<div class="frmheading">
    <h1>JOBS</h1>
</div>
<form name="jobRights" method="post" action="jobs_rights.php" >
<input type="hidden" value="<?=$_REQUEST['xstaffcode']?>" name="xstaffcode">
<input type="hidden" value="<?=$_REQUEST['recid']?>" name="recid">
<table cellspacing="0" cellpadding="0" border="0" align="center" class="fieldtable" id="permissionSection">
    <tbody>
        <tr class="fieldheader">
            <td align="left" rowspan="2"><b style="color:#F05729;">Forms to be shown</b></td>
            <td class="helpBod" colspan="4"><div align="center"><b style="color:#F05729;">View Permissions</b></div></td>
        </tr>
        <tr class="fieldheader">
            <th align="center" class="fieldheader" style="width:150px;"><input type="checkbox" onclick="CheckAll_View('1|2|3|4|5|6')" value="yes" name="Check_ctr_view" class="checkboxClass">
                &nbsp;&nbsp;<b>View</b>
            </th>
        </tr>
        <? 
        foreach ($arrFeatures as $key => $value) {
            //$commonUses->showArray($value); ?>
        
            <input type="hidden" value="<?=$value['stf_FCode']?>" name="frmcode">
            <tr><td colspan="8"><b><i><div style="margin-left:10px; float:left; color:#FB5C24"></div></i></b></td></tr>
            <tr>
                <td width="300px">&nbsp;&nbsp;
                    <span style="margin:20px;">
                        <div style="margin-left:60px; float:left">
                            <?=$value['disp_name'] ?>
                        </div>
                    </span>
                </td>
                <td align="center">
                    <input type="checkbox" class="checkboxClass" name="stf_View[<?=$value['disp_id'] ?>]" value="1" <?  if($value['chcklstStatus'] == '1') echo 'checked';  ?>  id="stf_View[<?=$value['disp_id'] ?>]">
                </td>
            </tr>
        <? } ?>
        
        
        
    </tbody>
</table>
    <button onclick="return ConfirmCancel();" value="Cancel" type="button" style="margin-right:32px;">Cancel</button>
    <button class="button" style="width:115px;" value="Submit" name="action" id="btnSubmit" type="submit">Submit</button>
</form>
<?php
include("includes/footer.php");
?>
