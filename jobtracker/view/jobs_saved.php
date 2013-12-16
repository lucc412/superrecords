<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Retrieve saved jobs</h1>
	<span>
		<b>Welcome to the Super Records saved job list.</b></br>Below you can see all saved jobs for your practice.
	<span>
        </div><form name="objForm" method="post" action="jobs_saved.php"><?

	// client drop-down for filter
	?><table width="100%">
		<tr>
                    <td align="right">
                        <select style="width:300px;" name="lstClientType" id="lstClientType" onchange="this.form.submit();">
                                <option value="0">Select Client</option><?php
                                foreach($arrClients AS $clientId => $clientName){
                                        $selectStr = '';
                                        if($clientId == $_REQUEST['lstClientType']) $selectStr = 'selected';
                                        ?><option <?=$selectStr?> value="<?=$clientId?>"><?=$clientName?></option><?php 
                                }
                        ?></select>
                    </td>
		</tr>
	</table><br/><?

	// content
	if(count($arrJobs) == 0) {	
		?><div class="errorMsg">You don't have any saved jobs to be reviewed.</div><?
	}
	else {
		// display job data
		?><table align="center" width="100%" class="resources">
			<tr>
                            <th width="50%" class="td_title" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Job Name <img id="sort_name" src="images/sort_asc.png"></th>
                            <th width="10%" class="td_title date" align="center" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_date');">Creation Date <img id="sort_date" src="images/sort_asc.png"></th>
                            <td width="8%" class="td_title" align="center">Actions</td>
			</tr><?
                        
			$countRow = 0;
			foreach($arrJobs AS $jobId => $arrJobDetails) {
                            if($countRow%2 == 0) $trClass = "trcolor";
                            else $trClass = "";
                            $jobName = $arrJobDetails['job_name'];

                            ?><tr class="<?=$trClass?>">
                                    <td class="tddata"><?=$jobName?></td>
                                    <td class="tddata" align="center"><?=$arrJobDetails['job_created_date']?></td>
                                    <td class="tddata" align="center"><?
                                        if($arrJobDetails['job_genre'] == 'SETUP') {
                                            ?><a title="click here to edit this job" href='setup/<?=$arrJobDetails['subform_url']?>?recid=<?=$jobId?>&frmId=<?=$arrJobDetails['subform_id']?>'><?=EDITICON?></a><?
                                        }
                                        else {
                                            ?><a title="click here to edit this job" href='audit.php?recid=<?=$jobId?>'><?=EDITICON?></a><?
                                        }
                                    ?></td>
                            </tr><?
                            $countRow++;
			}
		?></table><?
	}
?></form><?

// include footer file
include(FOOTER);
?>