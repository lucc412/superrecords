<?
// include topbar file
include(TOPBAR);

switch($_REQUEST['a'])
{
	// My Document case starts here....
	case "document" :

		// page header
		?><div class="pageheader">
			<h1>My Documents</h1>
			<span>
				<b>Welcome to the Super Records documents list.</b></br>Below you can see all documents for your jobs.
			<span>
		</div><?

		?><form name="objForm" method="post" action="jobs.php">
			<input type="hidden" name="a" value="pending"><?

			// content
			if(count($arrjobs) == 0) {
				?><div class="errorMsg"><?=ERRORICON?>&nbsp;No documents uploaded...!</div><?	
			}
			else {
				?><a href="jobs.php?a=uploadDoc" title="Click to view this document">
				<button type="button" title="Click here to upload new source document" onclick="javascript:addElement();" value="Add">Upload Document +</button></a>
					</br></br>
					
				<table width="100%" class="resources">
					<tr>
						<td class="td_title">Job Name</td>
						<td class="td_title">Document Title</td>
						<td class="td_title">Source Documents</td>
					</tr><?
					
					$countRow = 0;
					foreach($arrjobs AS $jobId => $arrJobDetails) {
						if($countRow%2 == 0) $trClass = "trcolor";
						else $trClass = "";

						?><tr class="<?=$trClass?>"><?
							$arrJobParts = explode('::', $arrJobDetails['job_name']);
							$jobName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];

							?><td class="tddata"><?=$jobName?></td>

							<td class="tddata"><?
								$arrSourceDocs = $objScr->fetch_documents($jobId);
								if(!empty($arrSourceDocs)) {
									$docCnt = 0;
									foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
										$docCnt++;
										$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
										if(file_exists($folderPath)) {
											echo $arrDocInfo['document_title']."</br>";
										}
									}
								}
							?></td>

							<td class="tddata"><?
								$arrSourceDocs = $objScr->fetch_documents($jobId);
								if(!empty($arrSourceDocs)) {
									$docCnt = 0;
									foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
										$docCnt++;
										$folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
										if(file_exists($folderPath)) {
											?><p><a href="jobs.php?a=download&filePath=<?=$arrDocInfo['file_path']?>&flagChecklist=S" title="Click to view this document">Document <?=$docCnt?></a></p><?
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
		
		<form name="objForm" method="post" action="jobs.php?sql=insertDoc" enctype="multipart/form-data" onSubmit="javascript:return checkDocValidation();">
			<!--<input type="hidden" name="sql" value="insertDoc">-->

			<table align="center" width="70%" class="fieldtable" cellpadding="10px;">
				<tr>
					<td><strong> Select Job <font style="color:red;" size="2">*</font></strong></td>
					<td>
						<select name="lstJob" id="lstJob">
							<option value="0">Select Job</option><?
							foreach($arrjobs AS $jobId => $jobName)
							{
								$arrJobParts = explode('::', $jobName["job_name"]);
								$jobDispName = $arrClients[$arrJobParts[0]] . ' - ' . $arrJobParts[1] . ' - ' . $arrJobType[$arrJobParts[2]];
								?><option <?=$selectStr?> value="<?=$jobId?>"><?=$jobDispName?></option><?php 
							}
						?></select>
					</td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>
				
				<tr>
					<td><strong> Document Title </strong></td>
					<td> <input type="text" name="txtDocTitle" id="txtDocTitle" size="36px" /></td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>
				
				<tr>
					<td><strong> Select Document <font style="color:red;" size="2">*</font> </strong></td>
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