<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of preview_class
 *
 * @author dishag
 */
class Preview {
    
    // fetch company data
    public function fetchCompanyData() {
            print $qryCom = "SELECT tf.*
                        FROM stp_comp_dtls tf
                        WHERE tf.job_id = ".$_SESSION['jobId'];
            $fetchRow = mysql_query($qryCom);
            $rowData = mysql_fetch_assoc($fetchRow);
            return $rowData;
    }
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrCompanyDetail = $this->fetchCompanyData();
       $arrStates = fetchStates();
       showArray($arrCompanyDetail);
       
       $html = '';
       $styleCSS = '<style>
                        h2 {
                                font-family: helvetica;
                                margin:0;
                                color:#F05729;
                        }
                        p {
                                font-family: helvetica;
                                margin:0;
                                color:#F05729;
                                font-size:12px;
                                font-weight: bold;
                        }
                        table.first {
                                font-family: helvetica;
                                font-size: 12px;
                        }

                        div.test {
                                background-color: #074165;
                                color: #FFFFFF;
                                font-family: helvetica;
                                font-size: 11pt;
                                font-weight: bold;
                                padding: 5px;
                                width:55%;
                        }
                    </style>';
       
        /* company details starts */
        $company = '<div class="test">Company Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">
                        <tr>
                            <td>Proposed name of company :</td>
                            <td>'.$arrCompanyDetail['comp_pref_name'].'</td>
                        </tr>
                        <tr>
                            <td>Jurisdiction of registration :</td>
                            <td>'.$arrStates[$arrCompanyDetail['comp_juri_reg']].'</td>
                        </tr>
                        <tr>
                            <td>Is the proposed company name an <br/>existing business name ? :</td>
                            <td>'.$arrCompanyDetail['exst_busns_name'].'</td>
                        </tr>
                        <tr>
                            <td>Was the business name registered <br/>on or after 28 May 2012 ? :</td>
                            <td>'.$arrCompanyDetail['reg_busns_name'].'</td>
                        </tr>
                        <tr>
                            <td>State :</td>
                            <td>'.$arrStates[$arrCompanyDetail['reg_busns_state']].'</td>
                        </tr>
                        <tr>
                            <td>Registration Number :</td>
                            <td>'.$arrCompanyDetail['reg_busns_number'].'</td>
                        </tr>
                        <tr>
                            <td>ABN :</td>
                            <td>'.$arrCompanyDetail['reg_busns_abn'].'</td>
                        </tr>
                    </table>';
        /* company details ends */
        
        $html = $styleCSS.$company;
        return $html;
        
    }
    
    function generatePDF($html) {

        // process new job
        submitSavedJob();

        // Insert into documents table
        $qrySel = "SELECT max(document_id) docId FROM documents";

        $objResult = mysql_query($qrySel);
        $arrInfo = mysql_fetch_assoc($objResult);
        $fileId = $arrInfo['docId'];	
        $fileId++;
        $currentTime = date('Y-m-d H:i:s');

        $filename = $fileId."~setup.pdf";
        $docQry = "INSERT INTO documents (job_id,document_title,date,file_path) VALUES (".$_SESSION['jobId'].",'setup','".$currentTime."','".$filename."')";
        mysql_query($docQry);

        $title1 = $_SESSION['PRACTICENAME'];
        $title2 = returnJobName();

        // Create PDF
        createPDF($html,$filename,$title1,$title2);
    }
}
?>
