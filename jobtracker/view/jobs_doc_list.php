<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
        <h1>View and upload documents</h1>
        <span>
                <b>Welcome to the Super Records documents list for your jobs.</b></br>Below you can see all documents for your jobs.
        <span>
</div><?

?><form name="objForm" method="post" action="jobs_doc_list.php">
        <input type="hidden" name="a" value="pending">

        <button style="width:94px;" type="button" onclick="javascript:urlRedirect('jobs_doc_upload.php');" title="Click here to upload new source document" value="Add">Add</button>
        </br></br><?

        // content
        if(count($arrjobs) == 0) {
                ?><div class="errorMsg">You don't have any additional source documents added for jobs.</div><?
        }
        else {
                ?><table width="100%" class="resources">
                        <tr>
                            <th class="td_title sort_column" style="cursor:pointer;" align="left" onclick="changeSortImage('sort_name');">Job Name <img id="sort_name" src="images/sort_asc.png"></th>
                            <td class="td_title">Source Documents</td>
                        </tr><?

                        $countRow = 0;
                        foreach($arrjobs AS $jobId => $arrJobDetails) {
                                if($countRow%2 == 0) $trClass = "trcolor";
                                else $trClass = "";

                                ?><tr class="<?=$trClass?>">
                                        <td class="tddata"><?=$arrJobDetails['job_name']?></td>
                                        <td class="tddata"><?
                                            $arrSourceDocs = $arrAllDocs[$jobId];
                                            if(!empty($arrSourceDocs)) {
                                                foreach($arrSourceDocs AS $documentId => $arrDocInfo) {
                                                    $icon = returnFileIcon($arrDocInfo['file_path']);
                                                    if($arrJobDetails['job_genre'] == 'AUDIT')
                                                        $folderPath = "../uploads/audit/" . $arrDocInfo['file_path'];
                                                        if(file_exists($folderPath)) {
                                                            ?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($arrDocInfo['file_path'])?>&folderPath=A" title="Click to view this document"><?=$arrDocInfo['document_title'];?></a></p><?
                                                        }
                                                    else {
                                                        $folderPath = "../uploads/sourcedocs/" . $arrDocInfo['file_path'];
                                                        if(file_exists($folderPath)) {
                                                            ?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($arrDocInfo['file_path'])?>&folderPath=S" title="Click to view this document"><?=$arrDocInfo['document_title'];?></a></p><?
                                                        }
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

// include footer file
include(FOOTER);
?>