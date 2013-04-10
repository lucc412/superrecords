<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is view file for all reports page	
*/

?><html>
	<head>
		<title><?=$reportPageTitle?></title>
		<meta name="generator" http-equiv="content-type" content="text/html">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="<?=$javaScript;?>report_validation.js"></script>
		<script type="text/javascript" src="<?=$javaScript;?>datetimepicker.js"></script>
	</head>
	<body><?
		include("includes/header.php");

		// error message if field name already exists
		if(isset($_REQUEST['flagDuplicate']) &&  $_REQUEST['flagDuplicate'] == 'Y') {
			?><div class="errorMsg" style="margin-top:-5px;">Sorry, This <strong>Report Name</strong> already exists. Please specify another name.</div><br/><br/><?
		}

		// display all columns in listbox here
		if(!empty($_SESSION['ARRDISPFIELDS'])) {
			?><form name="objForm" id="objForm" action="<?=$reportPageLink?>" method="post" onSubmit="return makeSelection();"><?

				// saved report drop-down
				if(!empty($arrSavedReports)) {
					?><span class="genlink" style="padding-right:20px;">Choose report:</span> 
					<select name="lstReport" id="lstReport" onChange="javascript:selectedReportDisplay(this.value, '<?=$reportPageLink?>');">
						<option value="0">--Please Select--</option><?
						foreach ($arrSavedReports AS $reportId => $reportInfo) {
							$selectStr = '';
							$styleColor = '';
							if($_REQUEST['lstReport'] == $reportId) $selectStr = 'selected';
							?><option <?=$selectStr?> value="<?=$reportId?>" style="<?=$styleColor?>"><?=$reportInfo['report_name']?></option><?
						}
					?></select><?
				}
				
				// save report text box
				?><span class="genlink">Report Name:</span><input type="text" name="txtReportName" id="txtReportName" value="<?=$arrSavedReports[$_REQUEST['lstReport']]['report_name']?>">
				<button type="submit" name="SaveReport" value="Save New Report" style="width:145px;" onClick="javascript:return saveReport();">Save New Report</button><br/><br/><?
				
				if(!empty($arrSavedReports)) {
					?>&nbsp;<button type="submit" style="width:130px;" name="UpdateReport" value="Update Report" onClick="javascript:return updateReport();">Update Report</button><?
					?><br/><br/><?
				}
				
				// display all columns here for conditional fields
				for ($key=0; $key<5; $key++) {
					$colName = $_REQUEST['lstTypex'.$key];
					$option = $_REQUEST['lstCondition'.$key];
					if($_REQUEST['lstCondition'.$key] == 'In Between') $option = 'between';
					$typex = $_SESSION['ARRFIELDTYPEX'][$colName];

					?><div id="div<?=$key?>" class="spantext1 pd40" align="left" style="<?=$divStyle?>">

						<span class="spantext1">Condition Fields
							<select name="lstTypex<?=$key?>" id="lstTypex<?=$key?>" onChange="javascript:showCondition(this.value, <?=$key?>);showInputType(this.value, <?=$key?>);">
								<option value="">--Please Select--</option><?
									foreach ($_SESSION['ARRDISPFIELDS'] AS $fieldName => $fieldTitle) {
										$strSelected = '';
										if($colName == $fieldName) $strSelected = 'selected';
										?><option value="<?=$fieldName?>" <?=$strSelected?>><?=$fieldTitle?></option><?
									}
							?></select>
						</span><?

						// include file to display condition drop-down
						include(REPORTCONDITION);
						?><span style="padding-left:20px;" id="condition<?=$key?>"><?=$conditionStr?></span><?

						// include file to display value drop-down / text box / calendar
						include(REPORTVALUE);
						?><span style="padding-left:20px;" id="inputType<?=$key?>"><?=$valueStr?></span>	

					</div><?

				}
				
				// display all columns here for multiple selection
				?><div class="pd40">
					<div style="padding-top:25px;" class="spantext1" align="left">
						<label for="chkAll"><input class="checkboxClass" type="checkbox" name="chkAll" id="chkAll" style="width:20px;" onClick="makeAllSelection();" <?if($_REQUEST['chkAll']) echo 'checked';?>>&nbsp;Add All / Remove All</label><br/><br/>
					</div><?

					// select output fields here
					?><select class="mainselection listclass" name="lstSelection[]" id="lstSelection" multiple="multiple" size="10"><?
						foreach($_SESSION['ARRDISPFIELDS'] AS $fieldName => $fieldTitle) {
							if(in_array($fieldName, $_REQUEST['lstSelected'])) continue;
							?><option value="<?=$fieldName?>"><?=$fieldTitle?></option><?
						}
                     ?></select><?
					
					// create add/remove arrows for moving options
					?><a class="pd10" href="javascript:;" onClick="moveOption(document.objForm.lstSelection, document.objForm.lstSelected);"><img style="margin-left:4px;" src="images/next.png" height="37px" width="40px"/></a>
					<a class="pd10" href="javascript:;" onClick="moveOption(document.objForm.lstSelected, document.objForm.lstSelection);"><img src="images/previous.png" height="37px" width="40px"/></a><?

					// display all selected output fields here
					?><select class="mainselection listclass" name="lstSelected[]" id="lstSelected" multiple="multiple" size="10"><?
						if(!empty($_REQUEST['lstSelected'])) {
							foreach($_REQUEST['lstSelected'] AS $intKeyId => $strColName) {
								?><option value="<?=$strColName?>"><?=$_SESSION['ARRDISPFIELDS'][$strColName]?></option><?
							}	
						}
					?></select>
					<a class="pd10" href="javascript:;" onClick="swap('up')"><img style="margin-left:2px;" src="images/up.png" height="35px" width="40px"/></a>
					<a class="pd10" href="javascript:;" onClick="swap('down')"><img src="images/down.png" height="35px" width="35px"/></a>
				</div>
				
				<div align="left" style="padding-top:20px;padding-bottom:20px;">
					<button type="submit" name="submit" value="Display">Display</button><?

					if(!empty($arrReportData)) {
						// generate button
						?><span style="padding-left:20px;"><a href="<?=$reportPageLink?>?generate=generate"><img src="images/excel.png" /></a></span><?
					}
				?></div><?
                
                if($_REQUEST['submit'] == "Display" && empty($arrReportData)) {
                    ?><br/><div class="errorMsg" style="margin-top:-5px;">Sorry, No results found. Please widen your criteria for conditions.</div><br/><br/><?
                }
				
				// display data to be exported in reports
				if(!empty($arrReportData)) {
					
					$_SESSION['REPORTDATA'] = $arrReportData;
					
					?><table class="fieldtable" align="center" width="100%" cellpadding="0px"><?
					$flagDisplay = true;
					
					foreach ($arrReportData AS $intCounter => $arrData){
						if($flagDisplay) {
							?><tr class="fieldheader">
								<th class="fieldheader" align="left" width="25px;">S.No.</th><?
								foreach($arrData AS $columnName => $columnValue) {
									?><th class="fieldheader" align="left"><?=strtoupper($_SESSION['ARRDISPFIELDS'][$columnName])?></th><?
								}
								$flagDisplay = false;
							?></tr><?
						}
					}
					
					$srNoCount = 1;
                    // display column values
					foreach($arrReportData AS $entityId => $arrData) {
						// background-color to alternate row
						if($srNoCount&1)
							$rowColor = 'trcolor';
						else
							$rowColor = '';
							
						?><tr class="<?=$rowColor?>">
							<td><?=$srNoCount?></td><?
							$srNoCount++;

							foreach($arrData AS $columnName => $columnValue) {
								?><td <?=$tdColor?>><?=$columnValue?></td><?
								$tdColor ='';
							}
						?></tr><?
					}
					?></table><?
				}
			?></form><?
		}
		else {
			?><br/><div class="errorMsg" style="margin-top:-5px;">There is no entity data added currently.</br><br/><?
		}

		include("includes/footer.php");
	
	?></body>
</html>