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
    
     // fetch fund data
    public function getTrustData() {
            $qrytrust = "SELECT tf.trust_name
                        FROM lrl_trust tf
                        WHERE tf.job_id = ".$_SESSION['jobId'];
            $fetchTrust = mysql_query($qrytrust);
            $rowData = mysql_fetch_assoc($fetchTrust);
            return $rowData;
    }
    
    // fetch fund data
    public function fetchTrustData() {
            $qryfund = "SELECT tf.trustee_id, ht.trustee_name, tf.noofmember, tf.comp_name, tf.acn, tf.reg_address, tf.director
                        FROM lrl_holding_trust tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qryfund);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch fund data
    public function fetchFundData() {
            $qryfund = "SELECT tf.trust_name, tf.trustee_id, ht.trustee_name, tf.noofmember, tf.comp_name, tf.acn, tf.reg_address, tf.director
                        FROM lrl_trust_fund tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qryfund);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, trustee_name name, res_add address
                FROM lrl_indvdl_holding_trust 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // fetch individual fund details
    public function fetchIndividualFundDetails()
    {
       $selQry="SELECT indvdl_id, trustee_name name, res_add address
                FROM lrl_indvdl_holding_fund 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlFund[] = $rowData;
        }
        
        return $arrIndvdlFund;
    }

    // fetch asset data
    public function fetchAssetData() {
            $qryAsset = "SELECT asset_details, loan_amount, loan_years, interest, interest_type, loan_type
                        FROM lrl_trust_asset
                        WHERE job_id = ".$_SESSION['jobId'];
            $fetchAsset = mysql_query($qryAsset);
            $rowData = mysql_fetch_assoc($fetchAsset);
            return $rowData;
    }
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrTrust = $this->getTrustData();
       $arrTrustDetail = $this->fetchTrustData();
       $arrFundDetail = $this->fetchFundData();
       $arrAssetDetail = $this->fetchAssetData();
       $arrRateType = array('F'=>'Fixed Rate', 'V'=>'Variable Rate');
       $arrLoanType = array('I'=>'Interest Only', 'P'=>'Principal and Interest');
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
       
        /* Trust details starts */
        $trust = '<div class="test">Holding Trust Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of Trust :</td>
                                <td>'.$arrTrust['trust_name'].'</td>
                            </tr>
                        </table><br/>';
        /* Trust details ends */
       
        /* Holding trust details starts */
        // individual
        if($arrTrustDetail['trustee_id'] == '1') {
            $arrIndvdlTrust = $this->fetchIndividualTrustDetails();
            $holdingTrustee = '<tr>
                                <td>No of Individuals :</td>
                                <td>'.$arrTrustDetail['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            $trustIndividual = "";
            foreach ($arrIndvdlTrust as $individualInfo) {
                $trustIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Individual '.$memberCtr.'</u></td>
                                    </tr>
                                    <tr>
                                        <td>Name :</td>
                                        <td>'.$individualInfo['name'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Residential Address :</td>
                                        <td>'.$individualInfo['address'].'</td>
                                    </tr>
                                    </table>';
                $memberCtr++;
            }
        }
        // corporate
        elseif($arrTrustDetail['trustee_id'] == '2') {
            $holdingTrustee = '<tr>
                                <td>Name of company :</td>
                                <td>'.$arrTrustDetail['comp_name'].'</td>
                            </tr>
                            <tr>
                                <td>ACN Number :</td>
                                <td>'.$arrTrustDetail['acn'].'</td>
                            </tr>
                            <tr>
                                <td>Registered Address :</td>
                                <td>'.$arrTrustDetail['reg_address'].'</td>
                            </tr>
                            <tr>
                                <td>Directors :</td>
                                <td>'.  replaceString('|', ',', $arrTrustDetail['director']).'</td>
                            </tr>';
        }
        
        $lender = '<div class="test">Lender Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Type of lender :</td>
                                <td>'.$arrTrustDetail['trustee_name'].'</td>
                            </tr>'.$holdingTrustee.'
                        </table>'.$trustIndividual.'<br/>';
        
        /* Holding trustee details ends */
       
        /* Fund details starts */
        // individual 
        if($arrFundDetail['trustee_id'] == '1') {
            $arrIndvdlFund = $this->fetchIndividualFundDetails();
            $fundTrustee = '<tr>
                                <td>No of trustees :</td>
                                <td>'.$arrFundDetail['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            $fundIndividual = "";
            foreach ($arrIndvdlFund as $individualInfo) {
                $fundIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Trustee '.$memberCtr.'</u></td>
                                    </tr>
                                    <tr>
                                        <td>Name of Trustee :</td>
                                        <td>'.$individualInfo['name'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Residential Address :</td>
                                        <td>'.$individualInfo['address'].'</td>
                                    </tr>
                                    </table>';
                $memberCtr++;
            }
        }
        // corporate
        elseif($arrFundDetail['trustee_id'] == '2') {
            $fundTrustee = '<tr>
                                <td>Name of company :</td>
                                <td>'.$arrFundDetail['comp_name'].'</td>
                            </tr>
                            <tr>
                                <td>ACN Number :</td>
                                <td>'.$arrFundDetail['acn'].'</td>
                            </tr>
                            <tr>
                                <td>Registered Address :</td>
                                <td>'.$arrFundDetail['reg_address'].'</td>
                            </tr>
                            <tr>
                                <td>Directors :</td>
                                <td>'.  replaceString('|', ',', $arrFundDetail['director']).'</td>
                            </tr>';
        }
        
        $fund = '<div class="test">Borrower Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of the Fund :</td>
                                <td>'.$arrFundDetail['trust_name'].'</td>
                            </tr>
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrFundDetail['trustee_name'].'</td>
                            </tr>'.$fundTrustee.'
                        </table>'.$fundIndividual.'<br/>';
        
        /* Fund details ends */
        
        /* Asset details starts */
        $asset = '<div class="test">Limited Recourse Loan Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Asset :</td>
                                <td>'.$arrAssetDetail['asset_details'].'</td>
                            </tr>
                            <tr>
                                <td>Loan Amount :</td>
                                <td>'.$arrAssetDetail['loan_amount'].'</td>
                            </tr>
                            <tr>
                                <td>Term of loan (years) :</td>
                                <td>'.$arrAssetDetail['loan_years'].'</td>
                            </tr>
                            <tr>
                                <td>Interest Rate % :</td>
                                <td>'.$arrAssetDetail['interest'].'</td>
                            </tr>
                            <tr>
                                <td>Interest Rate Type :</td>
                                <td>'.$arrRateType[$arrAssetDetail['interest_type']].'</td>
                            </tr>
                            <tr>
                                <td>Loan Type :</td>
                                <td>'.$arrLoanType[$arrAssetDetail['loan_type']].'</td>
                            </tr>
                        </table>';
        /* Asset details ends */
        
        $html = $styleCSS.$trust.$lender.$fund.$asset;
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
