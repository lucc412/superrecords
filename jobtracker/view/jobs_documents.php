<?
// include topbar file
include(TOPBAR);

switch($_REQUEST['a'])
{
	// My Document case starts here....
	case "document" :

		// page header
		?><div class="pageheader">
			<h1>View and upload documents</h1>
			<span>
				<b>Welcome to the Super Records documents list for your jobs.</b></br>Below you can see all documents for your jobs.
			<span>
		</div><?

		?><form name="objForm" method="post" action="jobs.php">
			<input type="hidden" name="a" value="pending">
			
			<button style="width:94px;" type="button" onclick="javascript:urlRedirect('jobs.php?a=uploadDoc');" title="Click here to upload new source document" value="Add">Add</button>
  			</br></br><?

			// content
			if(count($arrjobs) == 0) {
				?><div class="errorMsg">You don't have any additional source documents added for jobs.</div><?
			}
			else {
				?><table width="100%" class="resources">
					<tr>
						<td class="td_title">Job Name</td>
						<td class="td_title">Job Genre</td>
						<td class="td_title">Source Documents</td>
					</tr><?
					
					$countRow = 0;
					foreach($arrjobs AS $jobId => $arrJobDetails) {
						if($countRow%2 == 0) $trClass = "trcolor";
						else $trClass = "";

						?><tr class="<?=$trClass?>"><?
							$arrJobParts = stringToArray('::', $arrJobDetails['job_name']);
							$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

							?><td class="tddata"><?=$jobName?></td>
							<td class="tddata"><?=ucfirst(strtolower($arrJobDetails['job_genre']))?></td>
							<td class="tddata"><?
								$arrSourceDocs = $objScr->fetch_documents($jobId);
								if(!empty($arrSourceDocs)) {
									foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
										$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
										if(file_exists($folderPath)) {
											?><p><a href="jobs.php?a=download&filePath=<?=urlencode($arrDocInfo['file_path'])?>&flagChecklist=S" title="Click to view this document"><?=$arrDocInfo['document_title'];?></a></p><?
										}
									}
								}
							?></td>
						</tr><?
						$countRow++;
					}
				?></table><?
			}
		?></form><?
	break;
	// My Document case ends here....

	// Upload Document case starts here....
	case "uploadDoc" :
			// page header
		?><div class="pageheader">
			<h1>Upload Documents</h1>
			<span>
				<b>Welcome to the Super Records upload documents page.</b></br>Below you can upload documents for your job.
			<span>
		</div>
		
		<form name="objForm" id="objForm" method="post" action="jobs.php?sql=insertDoc" enctype="multipart/form-data" onSubmit="javascript:return checkDocValidation();">
			<input type="hidden" name="additionalDoc" value="<?if(!empty($_REQUEST['lstJob'])) echo 'Y'; else echo 'N';?>">
			<input type="hidden" name="genre" value="<?=$_REQUEST['genre']?>">
			<table width="60%" class="fieldtable" cellpadding="10px;">
				<tr>
					<td><strong> Select Job</strong></td>
					<td><?
						$arrJobNames = array();
						foreach($arrjobs AS $jobId => $jobName)
						{
							$arrJobParts = stringToArray('::', $jobName["job_name"]);
							$arrJobNames[$jobId] = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];
						}
						// Code to sort Job Names array in ascending order
						asort($arrJobNames);

						?><select name="lstJob" id="lstJob">
							<option value="0">Select Job</option><?
							foreach($arrJobNames AS $jobId => $jobName)
							{
								$selectStr = "";
								if($_REQUEST['lstJob'] == $jobId) $selectStr = "selected";
								?><option <?=$selectStr?> value="<?=$jobId?>"><?=$jobName?></option><?php 
							}
						?></select>
					</td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>
				
				<tr>
					<td><strong> Document Title</strong></td>
					<td> <input type="text" name="txtDocTitle" id="txtDocTitle" size="36px" /></td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>
				
				<tr>
					<td><strong> Source Document</strong></td>
					<td> <input type="file" name="fileDoc" id="fileDoc" size="30px" /> </td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>
				
				<tr>
					<td>
						<button type="reset" value="Reset">Reset</button>
					</td>
					
					<td>
						<button class="button" type="submit" name="btnSubmit" value="Submit">Submit</button>
					</td>
				</tr>
			</table>
		</form><?
		break;
	// Upload Document case ends here....
}
// include footer file
include(FOOTER);
?>