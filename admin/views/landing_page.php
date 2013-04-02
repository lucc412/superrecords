<div class="frmheading">
	<h1>Default Landing URL</h1>
</div><br>
<form name="objForm" action="landing_page.php" method="post">
	<input type="hidden" name="doAction" value="update">
	<input type="hidden" name="employeeId" id="employeeId" value="">
	<input type="hidden" name="employeeUrl" id="employeeUrl" value="">
	<div align="left">
		<table class="fieldtable" border="0" cellspacing="1" cellpadding="5" width="80%">
			<tr class="fieldheader">
				<th width="30%" align="left" class="fieldheader">Contact Name</th>
				<th width="45%" class="fieldheader">Landing URL</th>
				<th width="15%" class="fieldheader" colspan="3" align="center">Action</th>
			</tr><?

			$countRow = 0;
			foreach ($arrEmployees AS $empId => $arrInfo) {
				if($countRow%2 == 0) $trClass = "trcolor";
				else $trClass = "";

				?><tr class="<?=$trClass?>">
					<td name="<?=$empId?>"><?=htmlspecialchars($arrInfo["empName"])?></td>
					<td align="center"><input style="width:350px;" type="text" name="<?=$arrInfo["landingUrl"]?>" id="landingUrl<?=$empId?>" value="<?=htmlspecialchars($arrInfo["landingUrl"])?>" /></td>
					<td align="center">
						<button type="submit" name="gridedit" value="save" onclick="javascript:saveDefaultUrl(<?=$empId?>)">Save</button>
					</td>
				</tr><?
				$countRow++;
			}
		?></table>
	</div>
</form>