<?php
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
        <h1>Upload Documents</h1>
        <span>
                <b>Welcome to the Super Records upload documents page.</b></br>Below you can upload documents for your job.
        <span>
</div>

<form name="objForm" id="objForm" method="post" action="jobs_doc_upload.php?sql=insertDoc" enctype="multipart/form-data" onSubmit="javascript:return checkDocValidation();">
        <input type="hidden" name="additionalDoc" value="<?if(!empty($_REQUEST['lstJob'])) echo 'Y'; else echo 'N';?>">
        <table width="60%" class="fieldtable" cellpadding="10px;">
                <tr>
                        <td><strong> Select Job</strong></td>
                        <td><?
                                // Code to sort Job Names array in ascending order
                                asort($arrjobs);

                                ?><select name="lstJob" id="lstJob">
                                        <option value="0">Select Job</option><?
                                        foreach($arrjobs AS $jobId => $arrInfo)
                                        {
                                                $selectStr = "";
                                                if($_REQUEST['lstJob'] == $jobId) $selectStr = "selected";
                                                ?><option <?=$selectStr?> value="<?=$jobId?>"><?=$arrInfo['job_name']?></option><?php 
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
                                                
// include footer file
include(FOOTER);
?>
