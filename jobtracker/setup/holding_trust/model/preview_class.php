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
    public function fetchTrustData() {
            $qryfund = "SELECT tf.trust_name, tf.trustee_id, ht.trustee_name, tf.noofmember, tf.comp_name, tf.acn, tf.reg_address, tf.director
                        FROM holding_trust tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qryfund);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch fund data
    public function fetchFundData() {
            $qryfund = "SELECT tf.trust_name, tf.trustee_id, ht.trustee_name, tf.noofmember, tf.comp_name, tf.acn, tf.reg_address, tf.director
                        FROM trust_fund tf, holding_trustee ht
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
                FROM indvdl_holding_trust 
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
                FROM indvdl_holding_fund 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlFund[] = $rowData;
        }
        
        return $arrIndvdlFund;
    }

    // fetch asset data
    public function fetchAssetData() {
            $qryAsset = "SELECT ta.asset_details
                        FROM trust_asset ta
                        WHERE ta.job_id = ".$_SESSION['jobId'];
            $fetchAsset = mysql_query($qryAsset);
            $rowData = mysql_fetch_assoc($fetchAsset);
            return $rowData['asset_details'];
    }
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrTrustDetail = $this->fetchTrustData();
       $arrFundDetail = $this->fetchFundData();
       $assetDetail = $this->fetchAssetData();
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
       
        // holding trust details for individual trustee type
        if($arrTrustDetail['trustee_id'] == '1') {
            $arrIndvdlTrust = $this->fetchIndividualTrustDetails();
            $fundTrustee = '<tr>
                                <td>No of members :</td>
                                <td>'.$arrTrustDetail['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            $fundIndividual = "";
            foreach ($arrIndvdlTrust as $individualInfo) {
                $fundIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Member '.$memberCtr.'</u></td>
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
        // holding trust details for corporate trustee type
        elseif($arrTrustDetail['trustee_id'] == '2') {
            $fundTrustee = '<tr>
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
        
        // holding trust details
        $trust = '<div class="test">Holding Trust Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of Trust :</td>
                                <td>'.$arrTrustDetail['trust_name'].'</td>
                            </tr>
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrTrustDetail['trustee_name'].'</td>
                            </tr>'.$fundTrustee.'
                        </table>'.$fundIndividual.'<br/>';
       
        // fund details for individual trustee type
        if($arrFundDetail['trustee_id'] == '1') {
            $arrIndvdlFund = $this->fetchIndividualFundDetails();
            $fundTrustee = '<tr>
                                <td>No of members :</td>
                                <td>'.$arrFundDetail['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            $fundIndividual = "";
            foreach ($arrIndvdlFund as $individualInfo) {
                $fundIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Member '.$memberCtr.'</u></td>
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
        // trust fund details for corporate trustee type
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
        
        // trust fund details
        $fund = '<div class="test">Fund Details</div>
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
        
        $asset = '<div class="test">Asset Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Asset Details :</td>
                                <td>'.$assetDetail.'</td>
                            </tr>
                        </table>';
        
          /* $fundPart = '<tr>
                            <td>Fund ABN : </td>
                            <td>'.$arrFund[$jobid]['abn'].'</td>
                        </tr>';
                
           $header = ' <table style="margin-bottom: 30px;">
                            <tr>
                                <td><a href="www.superrecords.com.au" style="float:left;margin-right: 40px;"><img src="images_user/header-logo.png" style="width:250px;" /></a></td>                            
                                <td><p>'.$arrPractice['name'].'</p>
                                    <p>'.$arrClients['client_name'].' - '.$arrJob[$jobid]['period'].' - '.$arrActivity['sub_Description'].'</p>
                                </td>
                            </tr>
                        </table>';*/
        
        
        $html = $styleCSS.$trust.$fund.$asset;
        
        return $html;
        
    }
}
?>
