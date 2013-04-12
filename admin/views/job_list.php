<?php
//*************************************************************************************************
//  Task          : Page for Listing of Job.
//  Modified By   : Dhiraj Sahu
//  Created on    : 01-Jan-2013 
//  Last Modified : 07-Jan-2013 
//************************************************************************************************

//*************************************************************************************************
//  Task          : Made all URLs clean
//  Modified By   : Disha Goyal
//  Created on    : 01-Jan-2013 
//  Last Modified : 04-Mar-13
//************************************************************************************************

$client_id = $objCallData->arrJob[$_REQUEST["jobId"]]["client_id"];

if(!empty($a) && $a != 'addJob') {
	if($a == "uploadReports") {
		?><br /><br />
		<table align="center" width="100%" border="0">
			<tr>
				<td>
					<span style="font-weight:bold; font-size:14pt;"> Practice Name: </span>
					<span class="frmheading" style="font-size:14pt;"><?=$objCallData->arrPractice[$objCallData->arrClient[$client_id]["id"]]["name"]?></span>
				</td>
				<td align="right">
					<span style="font-weight:bold; font-size:14pt;"> Job Name: </span><?
					$arrJobParts = explode('::', $arrJob[$_REQUEST["jobId"]]["job_name"]);
					$jobName = '<b style="color:#b30000;">'.$objCallData->arrClient[$arrJobParts[0]]["client_name"] . '</b> - <b style="color:#0411ff;">' . $arrJob[$_REQUEST["jobId"]]["period"] . '</b> - <b style="color:#006a0e;">' . $objCallData->arrJobType[$arrJobParts[2]].'</b>';
					?><span style="font-size:14pt;"><?=$jobName?></span>
			  </td>
			  
			</tr>
		</table><?
	}
	else
	{
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
		<br /><?
	}
}

switch ($a)
{
	
	// **********************************************************
	// Case to load page for Adding new Job, Begins here.
	case "addJob":
	
	?><div class="frmheading">
		<h1>Add Record</h1>
   	  </div>
			<form name="objForm" id="objForm" method="post" action="job.php?sql=insertJob" onSubmit="javascript:return validateFormOnSubmit();" enctype="multipart/form-data">
 	
		 <!--<input type="hidden" name="sql" value="insertJob">-->
		 
		 <table class="tbl" width="72%" cellspacing="10">
			<tr>
			   <td class="hr">Practice Name<font style="color:red;" size="2">*</font></td>
				  <td colspan="2">
				  	<select id="lstPractice" name="lstPractice" onChange="javascript:selectOptions('Client');selectPanel();">
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
					<td class="hr">SR Manager</td>
					<td class="dr" id="tdSrManager">&nbsp;</td>
				</tr>
				<tr>
					<td class="hr">India Manager</td>
					<td class="dr" id="tdInManager">&nbsp;</td>
				</tr>
				<tr>
					<td class="hr">Team Member</td>
					<td class="dr" id="tdTeamMember">&nbsp;</td>
				</tr>
				<tr>
					<td class="hr">Sales Person</td>
					<td class="dr" id="tdSalesPrson">&nbsp;</td>
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
					<td class="hr">Notes</td>
					<td colspan="2"><textarea id="txtNotes" name="txtNotes"></textarea></td>
				</tr>
				
				<tr style="vertical-align:top;">
					<td class="hr">Source Documents	</td>
					<td colspan="2"><input type="text" name="textSource_50" title="Specify name of source document"><input type="file" name="sourceDoc_50" id="sourceDoc_50">
						<span style="margin-left:20px;"></span>
						<div id="parentDiv"></div>
					</td>
					<td>
						<button type="button" style="width:94px;margin-top:0px;" title="Click here to upload new source document" name="addBtn" onClick="javascript:addElement();" value="Add" />Add</button>
					</td>
				</tr>
				
				<tr>
					<td>
						<button type="reset" title="Click here to cancel" value="Cancel" onClick='return ComfirmCancel();'>Cancel</button>
					</td>
					<td>
						<button type="submit" title="Click here to add new job" value="Save" >Save</button>
					</td>
				</tr>
			</table>
		</form><?
	
		break;
	// Case to load page for Adding new Job, Ends here.
	// **********************************************************

		
	// **********************************************************
	// Case to load Job details tab of selected Job, begins here.	
	case "editJob":
				
			$client_id = $objCallData->arrJob[$_REQUEST["jobId"]]["client_id"];
			
			$strPanelInfo = $objCallData->sql_select_panel($arrJob[$_REQUEST['jobId']]['id']);
			$arrPanelInfo = explode('~', $strPanelInfo);
			$srManager = $arrPanelInfo[0];
			$salePerson = $arrPanelInfo[1];
			$indManager = $arrPanelInfo[2];
			$teamMember = $objCallData->fetch_team_member($client_id);
			
			if(!empty($arrJob[$_REQUEST["jobId"]]["job_received"]))
				$rec_date = date('d/m/Y', strtotime($arrJob[$_REQUEST["jobId"]]["job_received"]));
			else	
				$rec_date = "";
				
			if(!empty($arrJob[$_REQUEST["jobId"]]["job_due_date"]))
				$due_date = $arrJob[$_REQUEST["jobId"]]["job_due_date"];
				//$due_date = date('d/m/Y', strtotime($arrJob[$_REQUEST["jobId"]]["job_due_date"]));
			else	
				$due_date = "";
			
			?><body>
			<table border="0" cellspacing="1" cellpadding="4" align="left">
				<tr>
					<td><!--#0e4d7a-->
						<form method="POST" name="frmJobDetails" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDetails" value="Job Details" style="background-color:#F05729;">
							<input type="hidden" name="a" value="editJob">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDocument" value="Documents">
							<input type="hidden" name="a" value="documents">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
						
					<td>
						<form method="POST" name="frmReports" action="job.php">
							<input class="joblstbtn" type="submit" name="btnReports" value="Reports">
							<input type="hidden" name="a" value="reports">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmQueries" action="job.php">
							<input class="joblstbtn" type="submit" name="btnQueries" value="Queries">
							<input type="hidden" name="a" value="queries">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
				</tr>
			</table>
							
			<br/><div class="frmheading" style="padding-top:25px;">
				<h1>Job Details</h1>
			</div>
			 
			 <form method="POST" name="frmJobDetails" action="job.php?a=editJob&jobId=<?=$_REQUEST["jobId"]?>">
			 <!--<input class="vwtaskbtn" type="button" name="btnTasks" value="View Associated Tasks" style=""; width:215px;" onClick="JavaScript:newPopup('tsk_task.php?a=reset&jobId=<?=$_REQUEST["jobId"]?>');">-->
			 <button name="btnTasks" value="View Associated Tasks" style="width:215px;" onClick="JavaScript:newPopup('tsk_task.php?a=reset&jobId=<?=$_REQUEST["jobId"]?>');">View Associated Tasks</button>
			 <br/><br/>
			 
			</form>
			<!--background-color:#70b4ae; color:#ffffff; cursor:pointer; margin: 0-->
			<form method="POST" name="frmJobDetails" action="job.php?sql=updateJob">
			<table class="tbl" border="0" cellspacing="10" width="70%">
				<tr>
					<td class="hr">Client Name</td>
					<td class="dr"><?=$objCallData->arrClient[$client_id]["client_name"]?></td>
				</tr>

				<tr>
					<td class="hr">SR Manager</td>
					<td class="dr" id="tdSrManager"><?=$srManager?></td>
				</tr>
				<tr>
					<td class="hr">India Manager</td>
					<td class="dr" id="tdInManager"><?=$indManager?></td>
				</tr>
				<tr>
					<td class="hr">Team Member</td>
					<td class="dr" id="tdTeamMember"><?=$teamMember?></td>
				</tr>
				<tr>
					<td class="hr">Sales Person</td>
					<td class="dr" id="tdSalesPrson"><?=$salePerson?></td>
				</tr>
				
				<tr>
					<td class="hr">Job Type</td>
					<td class="dr"><?=$objCallData->arrJobType[$arrJob[$_REQUEST["jobId"]]["job_type_id"]]?></td>
				</tr>

				<tr>
					<td class="hr">Period</td>
					<td class="dr"><?=$arrJob[$_REQUEST["jobId"]]["period"]?></td>
				</tr>

				<tr>
					<td class="hr">Notes</td>
					<td class="dr"><?=nl2br($arrJob[$_REQUEST["jobId"]]["notes"])?></td>
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
					<td class="dr"><?=$rec_date?></td>
				</tr>

				<tr>
					<td class="hr">Job Due Date</td>
					<td class="dr">
					<?
						$jobDueDate = "";
						if (isset($due_date) && $due_date != "") {
							if($due_date != "0000-00-00 00:00:00") {
								$jobDueDate = date("d/m/Y",strtotime($due_date));
							}
						} 			
					?>
                        <input type="text" name="dateSignedUp" id="dateSignedUp" value="<?=$jobDueDate?>">&nbsp;<a href="javascript:NewCal('dateSignedUp','ddmmyyyy',false,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the timestamp"></a>
					</td>
				</tr>
			</table>
				<button type="submit" value="Update" name="btnJob">Update</button></td>
				<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
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
			
		   ?><table border="0" cellspacing="1" cellpadding="4" align="left" style="margin-left:-5px">
				<tr>
					<td>
						<form method="POST" name="frmJobDetails" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDetails" value="Job Details">
							<input type="hidden" name="a" value="editJob">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDocument" value="Documents" style="background-color:#F05729;">
							<input type="hidden" name="a" value="documents">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php">
							<input class="joblstbtn" type="submit" name="btnReports" value="Reports">
							<input type="hidden" name="a" value="reports">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmQueries" action="job.php">
							<input class="joblstbtn" type="submit" name="btnQueries" value="Queries">
							<input type="hidden" name="a" value="queries">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
				</tr>
			</table>

		<div class="frmheading" style="padding-top:45px;">
			<h1>Documents</h1>
		</div>
		
		<table class="fieldtable_outer" align="center">

		<table  class="fieldtable" align="center" width="100%" border="0" cellspacing="1" cellpadding="4" >
		<tr class="fieldheader">
			<th class="fieldheader" align="left">Type</th>
			<th class="fieldheader" align="left">Document</th>
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
					<!--<a href="job.php?sql=download&flagType=S&filePath=<?=$arrInfo['file_path']?>&docId=<?=$arrInfo['document_id']?>" title="Click to view this document" target="_blank">
                    <img src="images/download1.png" border="0" alt="Download" name="download" title="Download" align="middle" height="30px" width="105px"/>
                    </a>-->
					<button onclick="javascript:redirectURL('job.php?sql=download&flagType=S&filePath=<?=$arrInfo['file_path']?>&docId=<?=$arrInfo['document_id']?>');" title="Click to view this document" >Download</button>
                    
				</td>
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
						<form method="POST" name="frmJobDetails" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDetails" value="Job Details">
							<input type="hidden" name="a" value="editJob">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDocument" value="Documents">
							<input type="hidden" name="a" value="documents">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php">
							<input class="joblstbtn" type="submit" name="btnReports" value="Reports"  style="background-color:#F05729;">
							<input type="hidden" name="a" value="reports">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmQueries" action="job.php">
							<input class="joblstbtn" type="submit" name="btnQueries" value="Queries">
							<input type="hidden" name="a" value="queries">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
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
					<!--<a href="job.php?sql=download&flagType=R&filePath=<?=$arrInfo['file_path']?>" target="_blank" title="Click to view this document"><img src="images/download1.png" border="0"  alt="Download" name="download" title="Download" align="middle" height="30px" width="105px"/></a>-->
					<button onclick="redirectURL('job.php?sql=download&flagType=R&filePath=<?=$arrInfo['file_path']?>')"title="Click to view this document" >Download</button>
					  </td>
				</tr><?
			}
		}
	?></table></table>
		<table  class="fieldtable" align="center"  border="0" cellspacing="1" cellpadding="4" >
			<tr><td width="10%" align="center">
				<!--<a href="#"><img src="images/upload.png" border="0" alt="Upload" name="upload" title="Upload" align="middle" height="33px" width="117px" onClick="JavaScript:newPopup('job.php?a=uploadReports&jobId=<?=$_REQUEST["jobId"]?>');"/></a>-->
				<button onclick="JavaScript:newPopup('job.php?a=uploadReports&jobId=<?=$_REQUEST["jobId"]?>');">Upload</button>
			</td></tr>
		</table><?
	
		break;
	// Case to load Reports tab, Ends here.		
	// **********************************************************


	// **********************************************************
	// Case to load page for Uploading Reports, begins here.	
	case "uploadReports":
			?><div class="frmheading">
				<h1>
				
				</h1>
			</div>

			<form name="objForm" id="objForm" method="post" action="job.php?a=UploadReportDone" enctype="multipart/form-data">
				<input type="hidden" name="sql" value="insertReport"/>
				<input type="hidden" name="a" value="reports"/>
				<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>"/>
			
				<div align="center">
					<table class="fieldtable" border="0" cellspacing="15" cellpadding="15" width="40%">
						<tr>
							<td width="15%"> Report Title </td>
							<td width="15%"> <input type="text" name="txtReportTitle" id="txtReportTitle" size="36px" /></td>
						</tr>
						
						<tr>
							<td width="15%"> Select Report<font style="color:red;" size="2">*</font> </td>
							<td width="15%"> <input type="file" name="fileReport" id="fileReport" size="30px" /> </td>
						</tr>
						
						<tr>
							<td colspan="2" align="center">
								<button class="button" type="button" name="btnSubmit" value="Submit" onClick="javascript:return checkReportValidation();">Submit</button>
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
						<form method="POST" name="frmJobDetails" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDetails" value="Job Details">
							<input type="hidden" name="a" value="editJob">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDocument" value="Documents">
							<input type="hidden" name="a" value="documents">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php">
							<input class="joblstbtn" type="submit" name="btnReports" value="Reports">
							<input type="hidden" name="a" value="reports">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>

					
					<td>
						<form method="POST" name="frmQueries" action="job.php">
							<input class="joblstbtn" type="submit" name="btnQueries" value="Queries" style="background-color:#F05729;">
							<input type="hidden" name="a" value="queries">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
				</tr>
			</table>

		<div class="frmheading" style="padding-top:45px;">
			<h1>Queries</h1>
		</div>
		
        <div>
			<a href="job.php?a=addQueries&jobId=<?=$_REQUEST["jobId"]?>" class="hlight">
			<img src="images/add.gif" alt="Add" name="Add" title="Add" align="absbottom" height="22px" style="margin-top:-5px;" >&nbsp;Add Record</a><?

			// check if event is active or inactive [This will return TRUE or FALSE as per result]
			$pageUrl = "job.php?sql=sendMail";	
			$flagSet = getEventStatus($pageUrl);
			
			if($flagSet) {
				?><span style="margin-left:764px;">
				   <!--<a href="job.php?sql=sendMail&jobId=<?=$_REQUEST["jobId"]?>"><input type="button" name="sendEmail" value="Send Mail to Practice" class="sendMailBtn"></a>-->
				   <button name="sendEmail" style="width: 222px" onclick="javascript:redirectURL('job.php?sql=sendMail&jobId=<?=$_REQUEST["jobId"]?>')">Send Mail to Practice</button>
				</span><br>

				<span class="boldtext"><?php 
				$lastDate = $objCallData->view_send_mail_practice($_REQUEST["jobId"]);
				if($lastDate != '0000-00-00') {
					echo 'Last Sent : '.date('d-M-Y', strtotime($lastDate));
				}
			   ?></span><?
			}
	    ?></div>	
		<br>
		
		<form method="POST" name="frmQueriesList" action="job.php?sql=updateQuery">
			
			<input type="hidden" name="queryId" id="queryId" value="">
			<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
			<input type="hidden" name="qryPost" id="qryPost" value="">
			
			
			 <table class="fieldtable" align="center" width="100%" border="0" cellspacing="1" cellpadding="4">
				<tr class="fieldheader">
					<!--<th class="fieldheader">S. No.</th>-->
					<th class="fieldheader" width="30%">Query</th>
                    <th class="fieldheader" align="left">Reponse</th>
					<th class="fieldheader">Uploaded by SR</th>
					<th class="fieldheader">Supporting Doc</th>
					<th class="fieldheader">Date Added</th>
                    <th class="fieldheader">Date Answered</th>
					<th class="fieldheader">Answered?</th>
					<th class="fieldheader">Save</th>
					<th class="fieldheader">Post</th>
					<th class="fieldheader">Action</th>
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
					
					<td class="<?=$style?> yellowBG"><?=nl2br($arrInfo["response"])?></td>
					
					<td width="9%" class="<?=$style?> yellowBG" align="center"><?
					if(!empty($arrInfo["report_file_path"])) {
						?>
						<!--<a href="job.php?sql=download&flagType=SRQ&filePath=<?=$arrInfo['report_file_path']?>" target="_blank" title="Cilck here To Download Document."><img src="images/download1.png" border="0"  alt="View" name="View" title="View" align="middle" height="30px" width="105px"/></a>-->
<button style="width: 105px;" onclick="javascript:redirectURL('job.php?sql=download&flagType=SRQ&filePath=<?=$arrInfo['report_file_path']?>');" title="Cilck here To Download Document." >Download</button>
						<?
					}
					?></td>
					
					<td width="9%" class="<?=$style?> yellowBG" align="center"><?
					if(!empty($arrInfo["file_path"])) {
						?>
						<!--<a href="job.php?sql=download&flagType=Q&filePath=<?=$arrInfo['file_path']?>" target="_blank" title="Cilck here To Download Document."><img src="images/download1.png" border="0"  alt="View" name="View" title="View" align="middle" height="30px" width="105px"/></a>-->
						<button style="width: 105px;" onclick="javascript:redirectURL('job.php?sql=download&flagType=Q&filePath=<?=$arrInfo['file_path']?>');" title="Cilck here To Download Document." >Download</button>
						<?
					}
					?></td>
					
					 <?
						if(!empty($arrInfo["date_added"]) && $arrInfo["date_added"] != '0000-00-00') {
							?><td align="center" width="10%" class="<?=$style?> yellowBG"><?=date('d-M-Y', strtotime(htmlspecialchars($arrInfo["date_added"])))?></td><?
						}
						else {
							?><td width="10%" align="center" class="<?=$style?> yellowBG"></td><?
						}
					 ?>
					<?
						if(!empty($arrInfo["date_answered"]) && $arrInfo["date_answered"] != '0000-00-00') {
							?><td width="10%" class="<?=$style?> yellowBG"><?=date('d-M-Y', strtotime(htmlspecialchars($arrInfo["date_answered"])))?></td><?
						}
						else {
							?><td width="10%" class="<?=$style?> yellowBG"></td><?
						}
					  
					  if($arrInfo["status"] == 1)
					  	$yesNo = "background-color:#d5f2cc;";
					  else
						$yesNo = "background-color:#ffe1dd;";
						
					 ?><td width="9%" class="<?=$style?> blueBG" style="<?=$yesNo?>" align="center"><?
					 
					 if($arrInfo["status"] == 1)
					 {
  			      		?><label for="rdYes<?=$queryId?>"><input id="rdYes<?=$queryId?>" class="checkboxClass" type="radio" name="rdStatus<?=$queryId?>" value="1" checked="true"/>Yes</label>
						  <label for="rdNo<?=$queryId?>"><input id="rdNo<?=$queryId?>" class="checkboxClass" type="radio" name="rdStatus<?=$queryId?>" value="0"/>No</label><?
					 }
					 else
					 {
						?><label for="rdYes<?=$queryId?>"><input id="rdYes<?=$queryId?>" class="checkboxClass"  type="radio" name="rdStatus<?=$queryId?>" value="1"/>Yes</label>
						  <label for="rdNo<?=$queryId?>"><input id="rdNo<?=$queryId?>" class="checkboxClass"  type="radio" name="rdStatus<?=$queryId?>" value="0" checked="true"/>No</label><?				 
					 }		
					?></td>
						
					<td width="6%" class="<?=$style?> blueBG" align="center">
						<!--<input type="button" name="btnSave" value="Save" style="background-color:#07aff8; border:solid; color:#ffffff; width:70px;" onClick="javascript:updateQuery(<?=$queryId?>)">-->
						<button style="width: 70px;" onClick="javascript:updateQuery(<?=$queryId?>)">Save</button>
						
					</td>
					<td class=" blueBG" align="center">
						<input type="hidden" name="flagPost" id="flagPost" value="<?=$arrInfo['flag_post']?>"><?
						
					if($arrInfo["flag_post"] == 'N'){
						?><button id="qrPost" style="width:90px;" value="" title="click here to post this query to practice" onclick="javascript:updateQueryPost('<?=$arrInfo['flag_post']?>',<?=$queryId?>)" >Post</button><?
					}
					else{	
						?><button id="qrPost" style="width:90px;" value="" title="click here to unpost this query to practice" onclick="javascript:updateQueryPost('<?=$arrInfo['flag_post']?>',<?=$queryId?>)" >Unpost</button><?
					}
					?></td>	
					<td align="center"><?
					  	  $jsFunc = "javascript:performdelete('job.php?sql=deleteQuery&jobId=".$_REQUEST["jobId"]."&queryId=".$queryId."');";
						  ?><a onClick="<?=$jsFunc?>" href="javascript:;">
							  	<img src="images/erase.png"  border="0" height="23px" width="20px" alt="Delete" name="Delete" title="Delete" align="middle" />
						   </a>
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
						<form method="POST" name="frmJobDetails" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDetails" value="Job Details">
							<input type="hidden" name="a" value="editJob">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmDocuments" action="job.php">
							<input class="joblstbtn" type="submit" name="btnDocument" value="Documents">
							<input type="hidden" name="a" value="documents">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
					
					<td>
						<form method="POST" name="frmReports" action="job.php">
							<input class="joblstbtn" type="submit" name="btnReports" value="Reports">
							<input type="hidden" name="a" value="reports">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>

					
					<td>
						<form method="POST" name="frmQueries" action="job.php">
							<input class="joblstbtn" type="submit" name="btnQueries" value="Queries" style="background-color:#F05729;">
							<input type="hidden" name="a" value="queries">
							<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
						</form>
					</td>
				</tr>
			</table>
		<div class="frmheading" style="padding-top:45px;">
			<h1>Add Query</h1>
		</div>
		
		<form method="POST" name="frmAddQueries" id="frmAddQueries" action="job.php?sql=insertQuery" enctype="multipart/form-data">
			<input type="hidden" name="a" value="queries">
			<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
			
			<table class="tbl" border="0" cellspacing="15" cellpadding="5"width="40%">
				<tr>
					<td class="hr">Query</td>
					<td class="dr">
						<textarea name="txtQuery" rows="5" cols="50"></textarea>
					</td>
				</tr>
				
				<tr>
					<td width="15%"> Select Document </td>
					<td width="15%"> <input type="file" name="fileReport" id="fileReport" size="30px" /> </td>
				</tr>
			</table>

			<button type="submit" value="Save" name="btnSave">
				Save
			</button>

			<button type="button" value="Cancel" onClick='return ComfirmCancel(<?=$_REQUEST["jobId"]?>);'>
				Cancel
			</button>
			
		</form><?
		break;
	// Case to Add Query, Ends here.		
	// **********************************************************
	
	// Case to load list of Jobs with edit button, Begins here.
	default:
	
			?><body><form method="POST" name="frmJobList" action="job.php">
			<div class="frmheading">
				<h1>Job List</h1>
			</div>
			
			
			<table class="customFilter" width="50%" align="right" border="0" cellspacing="1" cellpadding="4" style="margin-right:0px;">
				<tr>
					<td><b>Custom Filter</b>&nbsp;</td>
					<td><input type="text" name="filter" value="<?php echo $filter ?>"></td>
					<td>
						<select name="filter_field">
							<option value="<?="all"?>"<?if ($_REQUEST['filter_field'] == "all") { echo "selected"; } ?>>All Fields</option>
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
					<td colspan="2"><a href="job.php" class="hlight">Reset Filter</a></td>
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
					<th class="fieldheader">Due Date</th><?

					if($access_file_level['stf_Edit'] == "Y" || $access_file_level['stf_Delete'] == "Y") {
						?><th class="fieldheader" colspan="2">Actions</th><?
					}
				?></tr><?

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
						?><td align="center" class="<?=$style?> blueBG"><?=
						//date('d-M-Y', strtotime(htmlspecialchars($arrInfo["job_due_date"])))
						$job_due_date = '';
						if (isset($arrInfo["job_due_date"]) && $arrInfo["job_due_date"] != "") {
							if($arrInfo["job_due_date"] != "0000-00-00 00:00:00") {
								$job_due_date = date('d-M-Y', strtotime(htmlspecialchars($arrInfo["job_due_date"])));
							}
						}
						echo $job_due_date; 	
						?></td><?
					}
					else{
						?><td class="<?=$style?> blueBG"></td><?
					}

					if($access_file_level['stf_Edit'] == "Y") {
						?><td width="5%" class="blueBG" align="center">
							<a href="job.php?a=editJob&jobId=<?=$jobId?>"><img src="images/edit.png" height="23px" width="20px" border="0"  alt="Edit" name="Edit" title="Edit" align="middle" /></a>
						</td><?
					}

					if($access_file_level['stf_Delete'] == "Y") {
						?><td width="5%" class="blueBG" align="center"><?
							$jsFunc = "javascript:performdelete('job.php?sql=deleteJob&jobId=".$jobId."');";
						  ?><a onClick="<?=$jsFunc?>" href="javascript:;">
							  	<img src="images/erase.png"  border="0" height="23px" width="20px" alt="Delete" name="Delete" title="Delete" align="middle" />
						   </a>
						</td><?
					}

					?></tr><?
				}
			?></table><br></form></body><?
		break;
		
		
}
?>