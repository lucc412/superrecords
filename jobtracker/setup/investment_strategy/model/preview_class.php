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
    public function fetchFundData() {
            $qryfund = "SELECT tf.fund, DATE_FORMAT(tf.dt_estblshmnt, '%d/%m/%Y') dt_estblshmnt, DATE_FORMAT(tf.dt_meeting, '%d/%m/%Y') dt_meeting, tf.met_add, tf.trustee_id, ht.trustee_name, tf.noofmember, tf.noofdirector, tf.comp_name, tf.acn, tf.reg_address
                        FROM ins_fund tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qryfund);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch director details
    public function fetchDirectorDetails()
    {
       $selQry="SELECT indvdl_id, name, res_add address, DATE_FORMAT(dob, '%d/%m/%Y') dob
                FROM ins_director 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, name, res_add address, DATE_FORMAT(dob, '%d/%m/%Y') dob
                FROM ins_indvdl_member 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // fetch asset details
    public function fetchTrustAsset()
    {
       $selQry="SELECT asset_id, asset, financial_year, type, amount, asset_range, target
                FROM ins_asset 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        
        $assetCtr = 1;
        while($rowInfo = mysql_fetch_assoc($fetchResult)) {
            $arrAssets[$assetCtr++] = $rowInfo;
        }
            
        return $arrAssets;
    }
    
    // fetch asset financial year
    public function fetchTrustAssetYear()
    {
       $selQry="SELECT financial_year
                FROM ins_asset 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $rowInfo = mysql_fetch_assoc($fetchResult);
        $financialYear = $rowInfo['financial_year'];
            
        return $financialYear;
    }

    // fetch other details
    public function fetchOtherDetails()
    {
       $selQry="SELECT spc_objective, insurance_details
                FROM ins_other 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrFundDetail = $this->fetchFundData();
       $arrAssets = $this->fetchTrustAsset();
       $financialYear = $this->fetchTrustAssetYear();
       $arrOtherDetail = $this->fetchOtherDetails();
       $arrInsDetail = stringToArray(',', $arrOtherDetail['insurance_details']);
       $arrInsurancelist = array("1" => "The trustees have considered the members individual insurance requirements and will put in place the required insurance policies.",
                                 "2" => "The trustees have in place insurance policies both inside and/or outside of superannuation that currently meet each member’s insurance requirements.",
                                 "3" => "Due the age of the member and/or the current cash flow and asset levels of the fund insurance is not applicable."
                           );  
       
       $strInsuranceDet = "";
       foreach ($arrInsurancelist AS $insId => $insStr) {
           if(in_array($insId, $arrInsDetail))
                $strInsuranceDet .= '&#10004;&nbsp;' . $arrInsurancelist[$insId]. '<br/>';
           else 
               $strInsuranceDet .= '&#x2717;&nbsp;&nbsp;' . $arrInsurancelist[$insId]. '<br/>';
       }
       
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
                                /*width:55%;*/
                        }
                    </style>';
       
        /* Fund details starts */
        $fundTypeData = "";
        
        // individual
        if($arrFundDetail['trustee_id'] == '1') {
            $arrIndvdlTrust = $this->fetchIndividualTrustDetails();
            $fundType = '<tr>
                                <td>No of trustees :</td>
                                <td>'.$arrFundDetail['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            foreach ($arrIndvdlTrust as $individualInfo) {
                $fundTypeData .= '<table class="first" cellpadding="4" cellspacing="6">
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
                                        <tr>
                                            <td>Dob :</td>
                                            <td>'.$individualInfo['dob'].'</td>
                                        </tr>
                                   </table>';
                $memberCtr++;
            }
        }
        // corporate
        elseif($arrFundDetail['trustee_id'] == '2') {
            $arrDirectors = $this->fetchDirectorDetails();
            $fundType = '<tr>
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
                                    <td>No of Directors :</td>
                                    <td>'.$arrFundDetail['noofdirector'].'</td>
                                </tr>';
            $memberCtr = 1;
            foreach ($arrDirectors as $director) {
                $fundTypeData .= '<table class="first" cellpadding="4" cellspacing="6">
                                        <tr>
                                            <td colspan="2"><u>Director '.$memberCtr.'</u></td>
                                        </tr>
                                        <tr>
                                            <td>Name of Director :</td>
                                            <td>'.$director['name'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Residential Address :</td>
                                            <td>'.$director['address'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Dob :</td>
                                            <td>'.$director['dob'].'</td>
                                        </tr>
                                   </table>';
                $memberCtr++;
            }
        }
        
        $fund = '<div class="test">Fund Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of Fund :</td>
                                <td>'.$arrFundDetail['fund'].'</td>
                            </tr>
                            <tr>
                                <td>Date of Establishment :</td>
                                <td>'.$arrFundDetail['dt_estblshmnt'].'</td>
                            </tr>
                            <tr>
                                <td>Date of Meeting :</td>
                                <td>'.$arrFundDetail['dt_meeting'].'</td>
                            </tr>
                            <tr>
                                <td>Meeting Address :</td>
                                <td>'.$arrFundDetail['met_add'].'</td>
                            </tr>
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrFundDetail['trustee_name'].'</td>
                            </tr>'.$fundType.'
                        </table>'.$fundTypeData.'<br/>';
        
        /* Fund details ends */
        
        /* Asset details starts */
        $asset = '<div class="test">Asset Allocation</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">
                        <tr>
                            <td>Financial Year :</td>
                            <td>'.$financialYear.'</td>
                        </tr>';
        
        foreach ($arrAssets AS $assetCtr => $assetInfo) {
            $asset .= '<tr>
                            <td colspan="2"></td>
                        </tr> 
                        <tr>
                            <td colspan="2"><u>Asset '.$assetCtr.'</u></td>
                        </tr>
                        <tr>
                            <td>Asset :</td>
                            <td>'.$assetInfo['asset'].'</td>
                        </tr>
                        <tr>
                            <td>Asset Type :</td>
                            <td>'.$assetInfo['type'].'</td>
                        </tr>
                        <tr>
                            <td>Amount :</td>
                            <td>'.$assetInfo['amount'].'</td>
                        </tr>
                        <tr>
                            <td>Range (0-100%) :</td>
                            <td>'.$assetInfo['asset_range'].'</td>
                        </tr>
                        <tr>
                            <td>12 months target % :</td>
                            <td>'.$assetInfo['target'].'</td>
                        </tr>';
        }
        $asset .= '</table><br/>';
        /* Asset details ends */
        
        /* Other details starts */
        $other = "<div class='test'>Other Details</div>
                        <br />
                        <table class='first' cellpadding='4' cellspacing='6'>
                            <tr>
                                <td>Specific Objectives :</td>
                                <td>".$arrOtherDetail['spc_objective']."</td>
                            </tr>
                            <tr>
                                <td>Insurance Details :</td>
                                <td>".$strInsuranceDet."</td>
                            </tr>
                        </table>";
        /* Asset details ends */
        
        $html = $styleCSS.$fund.$asset.$other;
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
