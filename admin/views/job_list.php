<?php
//*************************************************************************************************
//  Task          : Page for Listing of Job.
//  Modified By   : Dhiraj Sahu
//  Created on    : 01-Jan-2013 
//  Last Modified : 07-Jan-2013 
//************************************************************************************************

$viewSection = $_REQUEST["doAction"];
//*************************************************************************************************
//  Task          : Switch case to load Tabs inside Job page while editing.
//  Modified By   : Dhiraj Sahu
//  Created on    : 02-Jan-2013 
//  Last Modified : 07-Jan-2013 
//************************************************************************************************

$client_id = $objCallData->arrJob[$_REQUEST["jobId"]]["client_id"];

if($viewSection != "list" && $viewSection != "add_job")
{
if($viewSection == "uploadReports")
{
	?><br /><br /><?
}
	?><table border="0" cellspacing="0" cellpadding="4" align="left" style="margin-left:-5px" width="100%">
		<tr>
			<td align="left">
				<span style="font-weight:bold; font-size:10pt;"> Practice Name: </span>
				<span class="frmheading" style="font-size:10pt;"><?=$objCallData->arrPractice[$objCallData->arrClient[$client_id]["id"]]["name"]?></span>
			</td>
			
			<td align="right">
				<span style="font-weight:bold; font-size:10pt;"> Job Name: </span><?
			$arrJobParts = explode('::', $arrJob[$_REQUEST["jobId"]]["job_name"]);
			$jobName = '<b style="color:#b30000;">'.$objCallData->arrClient[$arrJobParts[0]]["client_name"] . '</b> - <b style="color:#0411ff;">' . $arrJob[$_REQUEST["jobId"]]["period"] . '</b> - <b style="color:#006a0e;">' . $objCallData->arrJobType[$arrJobParts[2]].'</b>';
			
			 ?><span style="font-size:10pt;"><?=$jobName?></span>
			</td>				
		</tr>
	</table>
	<br /><hr size="2" noshade>	<?
}


switch ($viewSection)
{
	// **********************************************************
	// Case to load list of Jobs with edit button, Begins here.
	case "list":

			?><body><form method="POST" name="frmJobList" action="job.php?a=reset&doAction=list">
			<div class="frmheading">
				<h1>Job List</h1>
			</div>
			
			
			<table class="customFilter" width="50%" align="right" border="0" cellspacing="1" cellpadding="4" style="margin-right:0px;">
				<tr>
					<td><b>Custom Filter</b>&nbsp;</td>
					<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
					<td>
						<select name="filter_field">
							<option value="">All Fields</option>
							<option value="<?="practice"?>"<?if ($_REQUEST['filter_field'] == "practice") { echo "selected"; } ?>>Practice Name</option>
							<option value="<?="job"?>"<?if ($_REQUEST['filter_field'] == "job") { echo "selected"; } ?>>Job Name</option>
							<option value="<?="status"?>"<?if ($_REQUEST['filter_field'] == "status") { echo "selected"; } ?>>Job Status</option>
						</select>
					</td>
					<td align="right">
						<input type="checkbox" style="width:20px;" name="wholeonly" <?if ($_REQUEST['wholeonly']) { echo "checked"; } ?>>Whole words only
					</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td><button type="submit" name="action" value="Apply Filter">Apply Filter</button>
					</td>
					<td colspan="2"><a href="job.php?a=reset&doAction=list" class="hlight">Reset Filter</a></td>
				</tr>
			</table>
			
			<p>&nbsp;</p><br/><br/>

			<table class="fieldtable" align="center" width="100%"><?

				if($access_file_level['stf_Add'] == "Y") {
					?><tr>
						<td style="padding:7px;"><a href="job.php?a=addJob" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
					</tr><?
				}
				
				?><tr class="fieldheader">
					<th class="fieldheader" align="left">Practice Name</th>
					<th class="fieldheader" align="left">Job Name</th>
					<th class="fieldheader" align="left">Job Status</th>
					<th class="fieldheader">Date Received</th>
					<th class="fieldheader">Due Date</th>
					<th class="fieldheader" colspan="2">Actions</th>
				</tr><?

				foreach ($arrJob AS $jobId => $arrInfo) {
					?><tr class="trclass"><?
					$arrJobParts = explode('::', $arrInfo["job_name"]);
					$jobName = '<b style="color:#b30000">'.$objCallData->arrClient[$arrJobParts[0]]["client_name"] . '</b> - <b style="color:#0411ff">' . $arrInfo["period"] . '</b> - <b style="color:#006a0e">' . $objCallData->arrJobType[$arrJobParts[2]].'</b>';
					
					?><td class="<?=$style?> yellowBG"><?=$arrPractice[$arrInfo['id']]['name']?></td>	
					<td class="<?=$style?> yellowBG"><?=$jobName?></td>	
					<td class="<?=$style?> blueBG"><?=htmlspecialchars($objCallData->arrJobStatus[$arrInfo["job_status_id"]]["job_status"])?></td><?

					if(!empty($arrInfo["job_received"])){
						?><td align="center" class="<?=$style?> yellowBG"><?=date('d-M-Y', strtotime(htmlspecialchars($arrInfo["job_received"])))?></td><?
					}
					else{
						?><td class="<?=$style?> yellowBG"></td><?
					}

					if(!empty($arrInfo["job_due_date"])){
						?><td align="center" class="<?=$style?> blueBG"><?=date('d-M-Y', strtotime(htmlspecialchars($arrInfo["job_due_date"])))?></td><?
					}
					else{
						?><td class="<?=$style?> blueBG"></td><?
					}

					if($access_file_level['stf_Edit'] == "Y") {
						?><td width="5%" class="blueBG" align="center">
							<a href="job.php?a=reset&doAction=details&jobId=<?=$jobId?>"><img src="images/edit.png" height="23px" width="20px" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
						</td><?
					}

					if($access_file_level['stf_Delete'] == "Y") {
						?><td width="5%" class="blueBG" align="center"><?
							$jsFunc = "javascript:performdelete('job.php?a=reset&doAction=list&sql=discon&jobId=".$jobId."');";
						  ?><a onClick="<?=$jsFunc?>" href="javascript:;">
							  	<img src="images/erase.png"  border="0" height="23px" width="20px" alt="Delete" name="Delete" title="Delete" align="middle" />
						   </a>
						</td><?
					}

					?></tr><?
				}
			?></table><br></form></body><?
		break;
	// Case to load list of Jobs with edit button, Ends here.
	// **********************************************************
	

	// **********************************************************
	// Case to load page for Adding new Job, Begins here.
	case "add_job":
	
	?><div class="frmheading">
		<h1>Add Record</h1>
   	  </div>
			<form name="objForm" id="objForm" method="post" action="job.php?a=reset&doAction=list" onSubmit="javascript:return validateFormOnSubmit();" enctype="multipart/form-data">
 	
		 <input type="hidden" name="sql" value="insertJob">
		 
		 <table class="tbl" width="70%" cellspacing="10">
			<tr>
			   <td class="hr">Practice Name<font style="color:red;" size="2">*</font></td>
				  <td colspan="2">
				  	<select id="lstPractice" name="lstPractice" onchange="javascript:selectOptions('Client');">
						<option value="">----- Select Practice -----</option><?php
						foreach($objCallData->arrPracticeName AS $practice_id => $practice_name) {
							?><option value="<?=$practice_id?>"><?=$practice_name?></option><?php 
						} 
					?></select>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice.</span></a></td>
			</tr>
				<tr>
					<td class="hr">Client Name<font style="color:red;" size="2">*</font></td>
					<td colspan="2">
						<span id="spanClient">
							<select id="lstClient" name="lstClient">
								<option value="">------------- Select Client -------------</option><?php
						  ?></select>
						</span>
						<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Client.</span></a>
					</td>
				</tr>
			
				<tr>
				   <td class="hr">Client Type<font style="color:red;" size="2">*</font></td>
					   
					  <td colspan="2">
					   <select id="lstClientType" name="lstClientType">
							<option value="">--- Select Client Type ---</option><?php
							foreach($objCallData->arrClientType AS $mas_code => $client_type) {
								?><option value="<?=$mas_code?>"><?=$client_type?></option><?php 
							} 
						?></select>
						<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Practice.</span></a></td>
			   </tr>
			   	
				<tr>
					<td class="hr">Job Type<font style="color:red;" size="2">*</font></td>
					<td colspan="2">
						<select id="lstJob" name="lstJob">
							<option value="">----- Select Job -----</option><?php
							foreach($objCallData->arrJobType AS $type_id => $job_type) {
								?><option value="<?=$type_id?>"><?=$job_type?></option><?php 
							} 
					  ?></select>
					<a class="tooltip" href="#"><img src="images/help.png"><span class="help">Name of Job.</span></a>
					</td>
				</tr>
				<tr>
					<td class="hr">Period<font style="color:red;" size="2">*</font></td>
					<td colspan="2"><input title="Specify period of job" type="text" name="txtPeriod" id="txtPeriod" value=""></td>
				</tr>
				<tr>
					<td class="hr">Checklist</td>
					<td colspan="2"><input type="file" name="fileChecklist" id="fileChecklist"></td>
				</tr>
				<tr>
					<td class="hr">Source Documents</td>
					<td colspan="2"><input type="text" name="textSource_50" title="Specify name of source document">
						<input type="file" name="sourceDoc_50" id="sourceDoc_50">
						<span style="margin-left:20px;"></span>
						<div id="parentDiv"></div>
					</td>
					<td>
						<button type="button" title="Click here to upload new source document" name="addBtn" onclick="javascript:addElement();" value="Add" class="button1"/>Add</button>
					</td>
				</tr>
				
				<tr>
					<td>
						<button type="submit" title="Click here to add new job" value="Save" class="button1">Save</button>
					</td>
					<td>
						<button type="reset" title="Click here to cancel" value="Cancel" class="button1" onClick='return ComfirmCancel();'>Cancel</button>
					</td>
				</tr>
			</table>
		</form><?
	
		break;
	// Case to load page for Adding new Job, Ends here.
	// **********************************************************

		
	// **********************************************************
	// Case to load Job details tab of selected Job, begins here.	
	case "details":
				
			$client_id = $objCallData->arrJob[$_REQUEST["jobId"]]["client_id"];
			
			if(!empty($arrJob[$_REQUEST["jobId"]]["job_received"]))
				$rec_date = date('d/m/Y', strtotime($arrJob[$_REQUEST["jobId"]]["job_received"]));
			else	
				$rec_date = "";
				
			if(!empty($arrJob[$_REQUEST["jobId"]]["job_due_date"]))
				$due_date = date("d/m/Y",strtotime($arrJob[$_REQUEST["jobId"]]["job_due_date"]));
			else	
				$due_date = "";
			
			?><body>
			<table border="0" cellspacing="1" cellpadding="4" align="left">
				<tr>
					<td>
						<form method="POST" name="frmJobDetails" action="job.php?a=reset&doAction=details&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDetails" value="Job Details" style="background-color:#00439d; color:#ffffff;">
							<input type="hidden" name="doAction" value="details">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDocument" value="Documents" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="documents" style="cursor:pointer;">
						</form>
					</td>
						
					<td>
						<form method="POST" name="frmReports" action="job.php?a=reset&doAction=reports&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnReports" value="Reports" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="reports" style="cursor:pointer;">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmQueries" action="job.php?a=reset&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnQueries" value="Queries" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="queries" style="cursor:pointer;">
						</form>
					</td>
				</tr>
			</table>
							
			<br/><div class="frmheading" style="padding-top:25px;">
				<h1>Job Details</h1>
			</div>
			 
			 <form method="POST" name="frmJobDetails" action="tsk_task.php?a=reset&jobId=<?=$_REQUEST["jobId"]?>">
			 <input type="button" name="btnTasks" value="View Associated Tasks" style="background-color:#70b4ae; color:#ffffff; cursor:pointer;" onclick="JavaScript:newPopup('tsk_task.php?a=reset&jobId=<?=$_REQUEST["jobId"]?>');"><br/><br/>
			</form>
			
			<form method="POST" name="frmJobDetails" action="job.php">
			<table class="tbl" border="0" cellspacing="10" width="70%">
				<tr>
					<td class="hr">Client Name</td>
					<td class="dr"><b><?=$objCallData->arrClient[$client_id]["client_name"]?></b></td>
				</tr>
				
				<tr>
					<td class="hr">Job Type</td>
					<td class="dr"><b><?=$objCallData->arrJobType[$arrJob[$_REQUEST["jobId"]]["job_type_id"]]?></b></td>
				</tr>

				<tr>
					<td class="hr">Period</td>
					<td class="dr"><b><?=$arrJob[$_REQUEST["jobId"]]["period"]?></b></td>
				</tr>

				<tr>
					<td class="hr">Job Status</td>
					<td class="dr">
						<select name="lstJobStatus">
							<option value="">--- Select Job Status ---</option><?php
							foreach($objCallData->arrJobStatus AS $job_status_id => $job_status){
								$selectStr = '';
								if($job_status_id == $objCallData->arrJob[$_REQUEST["jobId"]]["job_status_id"]) $selectStr = 'selected';
								?><option <?=$selectStr?> value="<?=$job_status_id?>"><?=$job_status["job_status"]?></option><?php
							} 
						?></select>
					</td>
				</tr>

				<tr>
					<td class="hr">Job Received Date</td>
					<td class="dr"><b><?=$rec_date?></b></td>
				</tr>

				<tr>
					<td class="hr">Job Due Date</td>
					<td class="dr">						
						<input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$due_date?>">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
					</td>
				</tr>
			</table>
				<button type="submit" value="Update" name="btnJob" class="cancelbutton">Update</button></td>
				<input type="hidden" name="sql" value="update">
				<input type="hidden" name="recid" value="<?=$_REQUEST["jobId"]?>">
				<input type="hidden" name="a" value="edit">
			</form></body>
	<?php
		break;
	// Case to load Job details tab of selected Job, Ends here.
	// **********************************************************

	// **********************************************************
	// Case to load Documents tab, begins here.	
	case "documents":

		$objCallData->arrDocument = $objCallData->fetchDocument();
		$objCallData->arrChecklist = $objCallData->fetchChecklists();
			
		   ?><table border="0" cellspacing="1" cellpadding="4" align="left" style="margin-left:-5px">
				<tr>
					<td>
						<form method="POST" name="frmJobDetails" action="job.php?a=reset&doAction=details&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDetails" value="Job Details" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="details">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDocument" value="Documents" style="background-color:#00439d; color:#ffffff;">
							<input type="hidden" name="doAction" value="documents">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php?a=reset&doAction=reports&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnReports" value="Reports" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="reports" style="cursor:pointer;">
						</form>
					</td>

					
					<td>
						<form method="POST" name="frmQueries" action="job.php?a=reset&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnQueries" value="Queries" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="queries">
						</form>
					</td>
				</tr>
			</table>

		<div class="frmheading" style="padding-top:45px;">
			<h1>Documents</h1>
		</div>
		
		<table class="fieldtable_outer" align="center">

		<table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="4" >
		<tr class="fieldheader">
			<th class="fieldheader" align="left">Type</th>
			<th class="fieldheader">Document</th>
			<th class="fieldheader" align="center">Date Uploaded by Practice</th>
			<th class="fieldheader" align="center">Viewed by Super Records</th>
			<th class="fieldheader" align="center">Download</th>
		</tr><?


	foreach ($objCallData->arrDocument AS $docId => $arrInfo)
	{
		if($arrInfo["job_id"] == $_REQUEST["jobId"])
		{
			?><tr>
				<td class="yellowBG" width="10%">Source Documents</td><?
				$docName = $arrInfo["document_title"];
				if(empty($arrInfo["document_title"])) {
					$arrFileName = explode('~', $arrInfo['file_path']);
					$origFileName = $arrFileName[1];
					$docName = $origFileName;
				}
				?><td class="yellowBG" width="20%"><?=$docName?></td>
					
				<td class="yellowBG" width="10%" align="center"><?=htmlspecialchars($arrInfo["date"])?></td><?
					
				if($arrInfo["viewed"]==0)
				{
					$viewed = 'No';
					$strView = 'style="color:red;"';
				}
				else
				{
					$viewed = 'Yes';
					$strView = 'style="color:green;"';
				}
			    ?><td width="10%" align="center" class="<?=$style?> blueBG" <?=$strView?>><?=$viewed?></td>	
			  
			 	<td width="5%" class="<?=$style?> blueBG" align="center">
					<a href="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>&docId=<?=$arrInfo["document_id"]?>&filePath=<?=$arrInfo["file_path"]?>&flagType=S" title="Click to view this document"><img src="images/download1.png" border="0"  alt="Download" name="download" title="Download" align="middle" height="30px" width="105px"/></a>
				</td>
			</tr><?
		}	
	}

	foreach ($objCallData->arrChecklist AS $jobId => $arrInfo)
	{
		if($arrInfo["job_id"] == $_REQUEST["jobId"])
		{
			?><tr>
				<td class="yellowBG" width="10%">Checklist</td><?
				$arrFileName = explode('~', $arrInfo['checklist']);
				$origFileName = $arrFileName[1];
				$docName = $origFileName;
				?><td class="yellowBG" width="20%"><?=$docName?></td>
					
				<td class="yellowBG" width="10%" align="center"><?=date('Y-m-d', strtotime($arrInfo["job_received"]))?></td><?

				if($arrInfo["checklist_status"]==0)
				{
					$viewed = 'No';
					$strView = 'style="color:red;"';
				}
				else
				{
					$viewed = 'Yes';
					$strView = 'style="color:green;"';
				}
			    ?><td width="10%" align="center" class="<?=$style?> blueBG" <?=$strView?>><?=$viewed?></td>	
			  
			 	<td width="5%" class="<?=$style?> blueBG" align="center"><?
				$folderPath = "../uploads/checklists/".$arrInfo['checklist'];
				if(!empty($arrInfo['checklist']) && file_exists($folderPath)) {
					?><a href="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>&filePath=<?=$arrInfo["checklist"]?>&flagType=C" title="Click to view this document"><img src="images/download1.png" border="0"  alt="Download" name="download" title="Download" align="middle" height="30px" width="105px"/></a><?
					}
				?></td>
			</tr><?
		}	
	}
	?></table></table><?
		break;
	// Case to load Documents tab, Ends here.		
	// **********************************************************
	

	// **********************************************************
	// Case to load Reports tab, begins here.	
	case "reports":
		
			$objCallData->arrReport = $objCallData->fetchReport();
			?><table border="0" cellspacing="1" cellpadding="4" align="left" style="margin-left:-5px">
				<tr>
					<td>
						<form method="POST" name="frmJobDetails" action="job.php?a=reset&doAction=details&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDetails" value="Job Details" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="details">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDocument" value="Documents" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="documents">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php?a=reset&doAction=reports&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnReports" value="Reports"  style="background-color:#00439d; color:#ffffff;">
							<input type="hidden" name="doAction" value="reports" style="cursor:pointer;">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmQueries" action="job.php?a=reset&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnQueries" value="Queries" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="queries">
						</form>
					</td>
				</tr>
			</table>
			
		<div class="frmheading" style="padding-top:45px;">
			<h1>Reports</h1>
		</div>
		

		<table  class="fieldtable" width="100%" align="center"  border="0" cellspacing="1" cellpadding="4" >
		<tr class="fieldheader">
			<th class="fieldheader" align="left">Report Title</th>
			<th class="fieldheader" align="center">Date Uploaded by Super Records</th>
			<th class="fieldheader" align="center" width="15%">Download</th>
		</tr><?

		foreach ($objCallData->arrReport AS $docId => $arrInfo)
		{
			if($arrInfo["job_id"] == $_REQUEST["jobId"])
			{
				?><tr>
					<td class="<?=$style?> blueBG"><?=htmlspecialchars($arrInfo["report_title"])?></td>	
					<td width="23%" align="center" class="<?=$style?> blueBG"><?=htmlspecialchars($arrInfo["date"])?></td>
					<td width="10%" class="<?=$style?> blueBG" align="center">
							<a href="job.php?a=reset&doAction=documents&filePath=<?=$arrInfo["file_path"]?>&flagType=R" title="Click to view this document"><img src="images/download1.png" border="0"  alt="Download" name="download" title="Download" align="middle" height="30px" width="105px"/></a>
					  </td>
				</tr><?
			}
		}
	?></table></table>
		<table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="4" >
			<tr><td width="10%" align="center">
						<a href="">
							<img src="images/upload.png" border="0" alt="Upload" name="upload" title="Upload" align="middle" height="33px" width="117px" onclick="JavaScript:newPopup('job.php?a=reset&doAction=uploadReports&jobId=<?=$_REQUEST["jobId"]?>');"/>
						</a>
			</td></tr>
		</table><?
	
		break;
	// Case to load Reports tab, Ends here.		
	// **********************************************************


	// **********************************************************
	// Case to load page for Uploading Reports, begins here.	
	case "uploadReports":
			
			?>
			<div class="frmheading">
				<h1></h1>
			</div>

			<form name="objForm" id="objForm" method="post" action="job.php" enctype="multipart/form-data">
			
				<input type="hidden" name="a" value="reset"/>
				<input type="hidden" name="sql" value="add"/>
				<input type="hidden" name="doAction" value="reports"/>
				<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>"/>
			
				<div align="center">
					<table class="fieldtable" border="0" cellspacing="15" cellpadding="15" width="40%">
						<tr>
							<td width="15%"> Report Title </td>
							<td width="15%"> <input type="text" name="txtReportTitle" id="txtReportTitle" size="36px" /></td>
						</tr>
						
						<tr>
							<td width="15%"> Select Report <font style="color:red;" size="2">*</font> </td>
							<td width="15%"> <input type="file" name="fileReport" id="fileReport" size="30px" /> </td>
						</tr>
						
						<tr>
							<td colspan="2" align="center">
								<button class="button" type="button" name="btnSubmit" value="Submit" onclick="javascript:return checkReportValidation();">Submit</button>
							</td>
						</tr>
					</table>
				</div>
				<br/><br/><br/>
			</form><?
				
			break;
	// Case to load page for Uploading Reports, Ends here.		
	// **********************************************************

	
	// **********************************************************
	// Case to load Queries tab, begins here.	
	case "queries":
		
			$objCallData->arrQueries = $objCallData->fetchQueries();
			?><table border="0" cellspacing="1" cellpadding="4" align="left" style="margin-left:-5px">
				<tr>
					<td>
						<form method="POST" name="frmJobDetails" action="job.php?a=reset&doAction=details&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDetails" value="Job Details" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="details">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDocument" value="Documents" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="documents">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php?a=reset&doAction=reports&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnReports" value="Reports" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="reports">
						</form>
					</td>

					
					<td>
						<form method="POST" name="frmQueries" action="job.php?a=reset&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnQueries" value="Queries" style="background-color:#00439d; color:#ffffff;">
							<input type="hidden" name="doAction" value="queries">
						</form>
					</td>
				</tr>
			</table>

		<div class="frmheading" style="padding-top:45px;">
			<h1>Queries</h1>
		</div>
	
<a href="job.php?a=reset&doAction=addQueries&jobId=<?=$_REQUEST["jobId"]?>" class="hlight"><img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom">&nbsp;Add Record</a>
		<br><br>		
		
		<form method="POST" name="frmQueriesList" action="job.php?a=reset&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
			
			<input type="hidden" name="queryId" id="queryId" value="">
			
			
			 <table class="fieldtable" align="center" width="100%" border="0" cellspacing="1" cellpadding="4">
				<tr class="fieldheader">
					<!--<th class="fieldheader">S. No.</th>-->
					<th class="fieldheader" align="center" width="30%">Query</th>
					<th class="fieldheader">Reponse</th>
					<th class="fieldheader" align="center">Download</th>
					<th class="fieldheader">Date Answered</th>
					<th class="fieldheader">Answered?</th>
					<th class="fieldheader" align="center">Save</th>
				</tr><?
				
			$srNo = 0;
			foreach ($objCallData->arrQueries AS $queryId => $arrInfo)
			{
				if($objCallData->arrQueries[$queryId]["job_id"] == $_REQUEST["jobId"])
				{
					$srNo++;
				?><tr>
					<!--<td width="5%" class="<?=$style?>"><?=$srNo?></td>-->
										
					<td class="<?=$style?> blueBG" align="center" width="20%">
						<textarea name="txtQuery<?=$queryId?>" rows="5" style="width:300px; " cols="60"><?=$arrInfo["query"]?></textarea>						
					</td>
					
					<td class="<?=$style?> yellowBG"><?=$arrInfo["response"]?></td>
					
					<td width="9%" class="<?=$style?> yellowBG" align="center"><?
					if(!empty($arrInfo["file_path"])) {
						?><a href="job.php?a=reset&doAction=queries&filePath=<?=$arrInfo["file_path"]?>&flagType=Q" title="Click to view this document"><img src="images/download1.png" border="0"  alt="View" name="View" title="View" align="middle" height="30px" width="105px"/></a><?
					}
					?></td><?
						
						if(!empty($arrInfo["date_answered"]) && $arrInfo["date_answered"] != '0000-00-00') {
							?><td width="10%" class="<?=$style?> yellowBG"><?=date('d-M-Y', strtotime(htmlspecialchars($arrInfo["date_answered"])))?></td><?
						}
						else {
							?><td width="10%" class="<?=$style?> yellowBG"></td><?
						}
					 ?>
					 
					 <td width="9%" class="<?=$style?> blueBG" align="center"><?
					 
					 if($arrInfo["status"] == 1)
					 {
  			      		?><img src="images/right.png" border="0"  alt="View" name="View" title="View" align="middle" height="20px" width="20px"/></br></br>
						  <input class="checkboxClass" type="radio" name="rdStatus<?=$queryId?>" value="1" checked="true"/>Yes
						  <input class="checkboxClass" type="radio" name="rdStatus<?=$queryId?>" value="0"/>No<?
					 }
					 else
					 {
						?><img src="images/wrong.png" border="0"  alt="View" name="View" title="View" align="middle" height="20px" width="20px"/></br></br>
						<input class="checkboxClass"  type="radio" name="rdStatus<?=$queryId?>" value="1"/>Yes
						  <input class="checkboxClass"  type="radio" name="rdStatus<?=$queryId?>" value="0" checked="true"/>No<?				 
					 }		
					?></td>
						
					<td width="6%" class="<?=$style?> blueBG" align="center">
						<input type="button" name="btnSave" value="Save" style="background-color:#07aff8; border:solid; color:#ffffff; width:70px;" onclick="javascript:updateQuery(<?=$queryId?>)">
					</td>						
						</tr><?
				}
			}
			?></table></table>
		</form><?
		break;
	// Case to load Queries tab, Ends here.	
	// **********************************************************
	
	
	// **********************************************************
	// Case to Add Query, begins here.	
	case "addQueries":
			
		   ?><table border="0" cellspacing="1" cellpadding="4" align="left" style="margin-left:-5px">
				<tr>
					<td>
						<form method="POST" name="frmJobDetails" action="job.php?a=reset&doAction=details&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDetails" value="Job Details" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="details">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php?a=reset&doAction=documents&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnDocument" value="Documents & Reports" style="cursor:pointer;">
							<input type="hidden" name="doAction" value="documents">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmQueries" action="job.php?a=reset&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
							<input type="submit" name="btnQueries" value="Queries" style="background-color:#00439d; color:#ffffff;">
							<input type="hidden" name="doAction" value="queries">
						</form>
					</td>
				</tr>
			</table>
			
		<br><br><span class="frmheading">Add Query</span><hr size="1" noshade>
		
		<form method="POST" name="frmQueriesList" action="job.php?a=add&doAction=queries&jobId=<?=$_REQUEST["jobId"]?>">
			
			<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="40%">
				<tr>
					<td class="hr">Query</td>
					<td class="dr">
						<textarea name="txtQuery" rows="5" cols="50"></textarea>
					</td>
				</tr>
			</table>

			<input type="submit" name="btnSave" value="Save" class="button">
			<input type="button" value="Cancel" onClick='return ComfirmCancel(<?=$_REQUEST["jobId"]?>);' class="cancelbutton"/>
		</form><?
		break;
	// Case to Add Query, Ends here.		
	// **********************************************************	
}
?>