<?php

class Preview {
    
   // fetch fund details
    public function fetchFundDetails()
    {
        $selQry="SELECT cf.fund_name, cf.new_director_name, cf.dob, cs.cst_Description, 
        CONCAT_WS(',', cf.res_add_unit, cf.res_add_build, cf.res_add_street, cf.res_add_subrb, cf.res_add_pst_code, cs.cst_Description) resAddress
        FROM ctm_fund_dtls cf LEFT JOIN cli_state cs ON cf.res_add_state = cs.cst_Code 
                                                   WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrData = mysql_fetch_assoc($fetchResult);
            
        return $arrData;
    }
    
    // fetch holding trust details
    public function fetchCompDetails()
    {
        $selQry="SELECT * FROM ctm_comp_dtls WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrData = mysql_fetch_assoc($fetchResult);
            
        return $arrData;
    }
    
    // generate preview/pdf code
    public function generatePreview() {
        
       $arrFundDetail = $this->fetchFundDetails();
       $arrCompDetail = $this->fetchCompDetails();
       
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
       
       
       /* Fund details starts */
        $fund = '<div class="test">Fund Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of the Fund :</td>
                                <td>'.$arrFundDetail['fund_name'].'</td>
                            </tr>
                            <tr>
                                <td>Name of new Director :</td>
                                <td>'.$arrFundDetail['new_director_name'].'</td>
                            </tr>
                            <tr>
                                <td>Residential Address :</td>
                                <td>'.stringltrim($arrFundDetail['resAddress'], ',').'</td>
                            </tr>
                            <tr>
                                <td>Date of Birth :</td>
                                <td>'.$arrFundDetail['dob'].'</td>
                            </tr>
                        </table><br/>';
        
        /* Fund details ends */
        
        
             
        
        /* Company details starts */
        $company = '<div class="test">Company Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of company :</td>
                                <td>'.$arrCompDetail['comp_name'].'</td>
                            </tr>
                            <tr>
                                <td>ACN Number :</td>
                                <td>'.$arrCompDetail['acn'].'</td>
                            </tr>
                            <tr>
                                <td>Registered Address :</td>
                                <td>'.$arrCompDetail['reg_addr'].'</td>
                            </tr>
                            <tr>
                                <td>Directors :</td>
                                <td>'.$arrCompDetail['directors_name'].'</td>
                            </tr>
                        </table>';
        /* Company details ends */
                
        $html = $styleCSS.$fund.$company;
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
