<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setup_preview_class
 *
 * @author siddheshc
 */
class SETUP_PREVIEW 
{
    //put your code here
    
    public function contactDetails() 
    {
        $jobid = $_SESSION['jobId'];
        $contQry = "SELECT * FROM es_contact_details WHERE job_id = ".$_SESSION['jobId'];
        $fetchCntact = mysql_query($contQry);
        while($rowData = mysql_fetch_assoc($fetchCntact))
        {
                $arrCntact[$rowData['job_id']] = $rowData;
        }
        
        return $arrCntact;
    }
    
    public function fundDetails() 
    {
        $fundQry = "SELECT * FROM es_fund_details WHERE job_id = ".$_SESSION['jobId'];
        $fetchFund = mysql_query($fundQry);
        while($rowData = mysql_fetch_assoc($fetchFund))
        {
                $arrFund[$rowData['job_id']] = $rowData;
        }
        return $arrFund;
    }
    
    public function memberDetails()
    {
        $memberQry = "SELECT * FROM es_member_details WHERE job_id = ".$_SESSION['jobId'];
        $fetchMembr = mysql_query($memberQry);
        while($rowData = mysql_fetch_assoc($fetchMembr))
        {
                $arrMembrs[$rowData['member_id']] = $rowData;
        }
        return $arrMembrs;
    }
    
    public function legalrefDetails()
    {
        $legalQry = "SELECT * FROM es_legal_references WHERE job_id = ".$_SESSION['jobId'];
        $fetchLegRef = mysql_query($legalQry);
        while($rowData = mysql_fetch_assoc($fetchLegRef))
        {
                $arrLegRef[$rowData['member_id']] = $rowData;
        }
        
        return $arrLegRef;
    }
    
    public function newTrustDetails()
    {
        $newTrstyQry = "SELECT * FROM es_new_trustee WHERE job_id = ".$_SESSION['jobId'];
        $fetchNewTrsty = mysql_query($newTrstyQry);
        $arrNewTrsty = array();
        while($rowData = mysql_fetch_assoc($fetchNewTrsty))
        {
            $arrNewTrsty[$rowData['job_id']] = $rowData;
        }
        return $arrNewTrsty;
    }
    
    public function extTrustDetails()
    {
        $extTrstyQry = "SELECT * FROM es_existing_trustee WHERE job_id = ".$_SESSION['jobId'];
        $fetchExtTrsty = mysql_query($extTrstyQry);
        $arrExtTrsty = array();
        while($rowData = mysql_fetch_assoc($fetchExtTrsty))
        {
                $arrExtTrsty[$rowData['job_id']] = $rowData;
        }
        return $arrExtTrsty;
    }
    
    public function jobDetails()
    {
        $jobQry = "SELECT * FROM job WHERE job_id = ".$_SESSION['jobId'];
        $fetchJob = mysql_query($jobQry);
        $arrJob = array();
        while($rowData = mysql_fetch_assoc($fetchJob))
        {
            $arrJob[$rowData['job_id']] = $rowData;
        }
        return $arrJob;
    }
    
    public function country()
    {
        $qryCntry = "SELECT * FROM es_country";
        $fetchCntry = mysql_query($qryCntry);
        
        while($rowData = mysql_fetch_assoc($fetchCntry))
        {
            $arrCountry[$rowData['country_name']] = $rowData['country_id'];
        }
        
        return $arrCountry;
    }
    
    public function clientDetails($clientId)
    {
        $qryCli = "SELECT t1.client_id, t1.client_name
                    FROM client t1
                    WHERE t1.client_id = '{$clientId}'
                    ORDER BY t1.client_name";

        $fetchClients = mysql_query($qryCli);
        $arrClients = mysql_fetch_assoc($fetchClients);
        
        return $arrClients;

    }
    
    public function practiceDetails()
    {
        $qryPra = "SELECT t1.id, t1.name
                    FROM pr_practice t1
                    WHERE t1.id = '{$_SESSION['PRACTICEID']}'
                    ORDER BY t1.name";
                        
        $fetchPrac = mysql_query($qryPra);
        $arrPractice = mysql_fetch_assoc($fetchPrac);
        
        return $arrPractice;
    }
    
    public function jobActivityDetails($job_type_id)
    {
        $qryAct = "SELECT sa.sub_Code, sa.sub_Description
                    FROM sub_subactivity sa
                    WHERE sa.sub_Code = ".$job_type_id."
                    AND sa.display_in_practice = 'yes'
                    ORDER BY sa.sub_Order";
        
        $fetchAct = mysql_query($qryAct);
        $arrActivity = mysql_fetch_assoc($fetchAct);
        
        return $arrActivity;
    }
    
    public function fetchTrusteeName($id) 
    {
        $qryFetch = "SELECT * FROM es_trustee_type  WHERE trustee_type_id = ".$id;

        $fetchResult = mysql_query($qryFetch);
        $rowData = mysql_fetch_assoc($fetchResult);

        return $rowData['trustee_type_name'];
    }
    
    public function smsfNotes() 
    {
        $qryFetch = "SELECT * FROM es_smsf  WHERE job_id = ".$_SESSION['jobId'];

        $fetchResult = mysql_query($qryFetch);
        $arrNotes = mysql_fetch_assoc($fetchResult);

        return $arrNotes;
    }
    
    public function generatePreview($mode=NULL)
    {
        $jobid = $_SESSION['jobId'];
        $arrCntact = SETUP_PREVIEW::contactDetails();
        $arrFund = SETUP_PREVIEW::fundDetails();
        //$arrJob = SETUP_PREVIEW::jobDetails();

        $trusteeName = SETUP_PREVIEW::fetchTrusteeName($arrFund[$_SESSION['jobId']]['trustee_type_id']);

        if ($_SESSION['frmId'] == 1) 
        {
            $arrMembrs = SETUP_PREVIEW::memberDetails();
            $arrLegRef = SETUP_PREVIEW::legalrefDetails();

            if($arrFund[$jobid]['trustee_type_id'] == 2)
                $arrNewTrsty = SETUP_PREVIEW::newTrustDetails();

            if ($arrFund[$jobid]['trustee_type_id'] == 3)
                $arrExtTrsty = SETUP_PREVIEW::extTrustDetails();

            $arrCountry = SETUP_PREVIEW::country();
            $arrNotes = SETUP_PREVIEW::smsfNotes();
            
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
                                width:50%;
                        }
                    </style>';
        
        if ($_SESSION['frmId'] == 1)
        {
            $abn_tfn = ($arrNotes['apply_abntfn'] == 1)? 'Yes':'No'; 
            $authority_status = ($arrNotes['authority_status'] == 1)? 'Yes':'No';
            $notes = '<br/>
                        <div class="test">General</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>If you want us to apply for ABN/TFN for new SMSF ? </td>
                                <td>'.$abn_tfn.'</td>
                            </tr>
                            <tr>
                                <td>Receieved written authority from client to utilise the services ? </td>
                                <td>'.$authority_status.'</td>
                            </tr>
                        </table>';
        }
        
        
        $contact = '<br/>
                        <div class="test">Contact Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>First Name :</td>
                                <td>'.$arrCntact[$jobid]['fname'].'</td>
                            </tr>
                            <tr>
                                <td>Last Name : </td>
                                <td>'.$arrCntact[$jobid]['lname'].' </td>
                            </tr>
                            <tr>
                                <td>Email Address : </td>
                                <td>'.$arrCntact[$jobid]['email'].' </td>
                            </tr>
                            <tr>
                                <td>Phone Number : </td>
                                <td>'.$arrCntact[$jobid]['phoneno'].' </td>
                            </tr>
                        </table>
                        <br/>';
        
        
        if ($_SESSION['frmId'] == 1) 
        {
            $fundPart = '<tr>
                            <td>Date of establishment : </td>
                            <td>'.$arrFund[$jobid]['date_of_establishment'].'</td>
                        </tr>
                        <tr>
                                <td>State of registration : </td>
                                <td>'.fetchStateName($arrFund[$jobid]['registration_state']).'</td>
                        </tr>';
        }
        if ($_SESSION['frmId'] == 2) 
        {
             $fundPart = '<tr>
                            <td>Fund ABN : </td>
                            <td>'.$arrFund[$jobid]['abn'].'</td>
                        </tr>';
        }
        
        $fund = '<div class="test">Fund Details</div>
                        <br/>
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Fund Name : </td>
                                <td>'.$arrFund[$jobid]['fund_name'].' </td>
                            </tr>
                            <tr>
                                <td>Street Address : </td>
                                <td>'.$arrFund[$jobid]['street_address'].' </td>
                            </tr>
                            <tr>
                                <td>Postal Address : </td>
                                <td>'.$arrFund[$jobid]['postal_address'].' </td>
                            </tr>
                            '.$fundPart.'
                            <tr>
                                <td>How many members? : </td>
                                <td>'.$arrFund[$jobid]['members'].' </td>
                            </tr>
                            <tr>
                                <td>Trustee Type : </td>
                                <td>'.$trusteeName.' </td>
                            </tr>
                            
                        </table> 
                        <br/>';
        
        
        if ($_SESSION['frmId'] == 1) 
        {
            $members = '';
            $leagalRef = '';
            $memberCtr = 1;
            $legalCntr = 1;
            foreach ($arrMembrs AS $memberInfo) 
            {
                $memberInfo["gender"] = ($memberInfo["gender"] == "M") ? "Male" : "Female";
                $memberInfo['country_id'] = array_search($memberInfo['country_id'],$arrCountry);

                if ($memberCtr == 1)
                    $members .= '<div class="test">Member Details</div><br/>';

                
                $members .= '<table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td colspan="2"><u>Member '.$memberCtr.'</u></td>
                            </tr>
                            <tr>
                                <td>Member Name : </td>
                                <td>'.$memberInfo['title'].' '.$memberInfo['fname'].' '.$memberInfo['mname'].' '.$memberInfo['lname'].' </td>
                            </tr>
                            <tr>
                                <td>Date of Birth : </td>
                                <td>'.$memberInfo['dob'].' </td>
                            </tr>
                            <tr>
                                <td>City of Birth : </td>
                                <td>'.$memberInfo['city'].' </td>
                            </tr>
                            <tr>
                                <td>Country of Birth : </td>
                                <td>'.$memberInfo['country_id'].' </td>
                            </tr>
                            <tr>
                                <td>Sex : </td>
                                <td>'.$memberInfo["gender"].' </td>
                            </tr>
                            <tr>
                                <td>Address : </td>
                                <td>'.$memberInfo['address'].' </td>
                            </tr>
                            <tr>
                                <td>Tax File Number : </td>
                                <td> '.$memberInfo['tfn'].' </td>
                            </tr>
                            <tr>
                                <td>Occupation : </td>
                                <td>'.$memberInfo['occupation'].' </td>
                            </tr>
                            <tr>
                                <td>Contact Number : </td>
                                <td>'.$memberInfo['contact_no'].' </td>
                            </tr>
                            
                        </table>
                        <br/>';
                
                if ($memberInfo['legal_references'] == 1) 
                {
                    foreach ($arrLegRef as $memberId => $legalInfo) 
                    {
                        $legalInfo["gender"] = ($legalInfo["gender"] == "M") ? "Male" : "Female";
                        $legalInfo['country_id'] = array_search($legalInfo['country_id'],$arrCountry);


                        if ($legalCntr == 1)
                            $leagalRef .= '<div class="test">Legal Personal Representative</div><br/>';

                        if ($memberInfo['member_id'] == $memberId) 
                        {
                            $leagalRef .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                            <td colspan="2"><u>Legal Personal Representative '.$legalCntr.'</u></td>
                                    </tr>
                                    <tr>
                                            <td>Name : </td>
                                            <td>'.$legalInfo["title"] . ' ' . $legalInfo["fname"] . ' ' . $legalInfo['mname'] . ' ' . $legalInfo['lname'].'</td>
                                    </tr>
                                    <tr>
                                            <td>Date of Birth : </td>
                                            <td>'.$legalInfo['dob'].'</td>
                                    </tr>
                                    <tr>
                                            <td>City of Birth : </td>
                                            <td>'.$legalInfo['city'].'</td>
                                    </tr>
                                    <tr>
                                            <td>Country of Birth : </td>
                                            <td>'.$legalInfo['country_id'].'</td>
                                    </tr>
                                    <tr>
                                            <td>Sex : </td>
                                            <td>'.$legalInfo["gender"].'</td>
                                    </tr>
                                    <tr>
                                            <td>Address : </td>
                                            <td>'.$legalInfo['address'].'</td>
                                    </tr>
                                    <tr>
                                            <td>Tax File Number : </td>
                                            <td>'.$legalInfo['tfn'].'</td>
                                    </tr>
                                    <tr>
                                            <td>Occupation : </td>
                                            <td>'.$legalInfo['occupation'].'</td>
                                    </tr>
                                    <tr>
                                            <td>Contact Number : </td>
                                            <td>'.$legalInfo['contact_no'].'</td>
                                    </tr>

                                </table>
                                <br/>';

                            $legalCntr++;
                        }
                    }
                }
                $memberCtr++;
            }
        
            $trustee = '';
            if ($arrFund[$jobid]['trustee_type_id'] == 1) $trustee = '';

            if ($arrFund[$jobid]['trustee_type_id'] == 2) 
            {
                $trustee .= '<div class="test">New Corporate Trustee Details</div>
                            <br />
                            <table class="first" cellpadding="4" cellspacing="6">
                                <tr>
                                    <td>Preferred Company Name : </td>
                                    <td>'.$arrNewTrsty[$jobid]['company_name'].' </td>
                                </tr>
                                <tr>
                                    <td>Alternative Name Option 1 : </td>
                                    <td>'.$arrNewTrsty[$jobid]['alternative_name1'].' </td>
                                </tr>
                                <tr>
                                    <td>Alternative Name Option 2 : </td>
                                    <td>'.$arrNewTrsty[$jobid]['alternative_name2'].' </td>
                                </tr>
                                <tr>
                                    <td>Registered Office Address : </td>
                                    <td>'.$arrNewTrsty[$jobid]['office_address'].' </td>
                                </tr>
                                <tr>
                                    <td>Principal Place of Business : </td>
                                    <td>'.$arrNewTrsty[$jobid]['business_address'].' </td>
                                </tr>
                            </table><br/>';
            }

            if ($arrFund[$jobid]['trustee_type_id'] == 3) 
            {
                $trustee .= '<div class="test">Existing Corporate Trustee Details</div>
                            <br />
                            <table class="first" cellpadding="4" cellspacing="6">
                                <tr>
                                    <td>Company Name : </td>
                                    <td>'.$arrExtTrsty[$jobid]['company_name'].' </td>
                                </tr>
                                <tr>
                                    <td>Company A.C.N : </td>
                                    <td>'.$arrExtTrsty[$jobid]['acn'].' </td>
                                </tr>
                                <tr>
                                    <td>Company A.B.N : </td>
                                    <td>'.$arrExtTrsty[$jobid]['abn'].' </td>
                                </tr>
                                <tr>
                                    <td>Company T.F.N : </td>
                                    <td>'.$arrExtTrsty[$jobid]['tfn'].' </td>
                                </tr>
                                <tr>
                                    <td>Registered Office Address : </td>
                                    <td>'.$arrExtTrsty[$jobid]['office_address'].' </td>
                                </tr>
                                <tr>
                                    <td>Principal Place of Business : </td>
                                    <td>'.$arrExtTrsty[$jobid]['business_address'].' </td>
                                </tr>
                                <tr>
                                    <td>Are all proposed members of the Superfund are directors of the company ? : </td>
                                    <td>'.$arrExtTrsty[$jobid]['yes_no'].' </td>
                                </tr>
                            </table><br/>';
            }
        }
        
        $header = ' <table style="margin-bottom: 30px;">
                            <tr>
                                <td><a href="www.superrecords.com.au" style="float:left;margin-right: 40px;"><img src="images_user/header-logo.png" style="width:250px;" /></a></td>                            
                                <td><p>'.$arrPractice['name'].'</p>
                                    <p>'.$arrClients['client_name'].' - '.$arrJob[$jobid]['period'].' - '.$arrActivity['sub_Description'].'</p>
                                </td>
                            </tr>
                        </table>';
        
        
        if ($_SESSION['frmId'] == 1) 
            $html = $styleCSS.$notes.$contact.$fund.$members.$leagalRef.$trustee;
        elseif ($_SESSION['frmId'] == 2)
            $html = $styleCSS.$contact.$fund;
        
        
        return $html;
        
    }
}

?>
