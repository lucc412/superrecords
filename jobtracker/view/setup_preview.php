<?php
    include(TOPBAR);
            
    
            // Fetch All Details of Job
            $jobid = $_SESSION['jobId'];
            $contQry = "SELECT * FROM es_contact_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchCntact = mysql_query($contQry);
            $arrCntact=array();
            while($rowData = mysql_fetch_assoc($fetchCntact))
            {
                    $arrCntact[$rowData['job_id']] = $rowData;
            }
            
            $fundQry = "SELECT * FROM es_fund_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchFund = mysql_query($fundQry);
            $arrFund = array();
            while($rowData = mysql_fetch_assoc($fetchFund))
            {
                $arrFund[$rowData['job_id']] = $rowData;
            }
            
            $memberQry = "SELECT * FROM es_member_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchMembr = mysql_query($memberQry);
            while($rowData = mysql_fetch_assoc($fetchMembr))
            {
                $arrMembrs[$rowData['member_id']] = $rowData;
            }
            
            $LegalQry = "SELECT * FROM es_legal_references WHERE job_id = ".$_SESSION['jobId'];
            $fetchLegRef = mysql_query($LegalQry);
            while($rowData = mysql_fetch_assoc($fetchLegRef))
            {
                $arrLegRef[$rowData['job_id']] = $rowData;
            }
            
            $newTrstyQry = "SELECT * FROM es_new_trustee WHERE job_id = ".$_SESSION['jobId'];
            $fetchNewTrsty = mysql_query($newTrstyQry);
            $arrNewTrsty = array();
            while($rowData = mysql_fetch_assoc($fetchNewTrsty))
            {
                $arrNewTrsty[$rowData['job_id']] = $rowData;
            }
            
            $extTrstyQry = "SELECT * FROM es_existing_trustee WHERE job_id = ".$_SESSION['jobId'];
            $fetchExtTrsty = mysql_query($extTrstyQry);
            $arrExtTrsty = array();
            while($rowData = mysql_fetch_assoc($fetchExtTrsty))
            {
                $arrExtTrsty[$rowData['job_id']] = $rowData;
            }
            
            $jobQry = "SELECT * FROM job WHERE job_id = ".$jobid;
            $fetchJob = mysql_query($jobQry);
            $arrJob = array();
            while($rowData = mysql_fetch_assoc($fetchJob))
            {
                $arrJob[$rowData['job_id']] = $rowData;
            }
            
            $qryCli = "SELECT t1.client_id, t1.client_name
                        FROM client t1
                        WHERE t1.client_id = '{$arrJob[$jobid]['client_id']}'
                        ORDER BY t1.client_name";
            
            $fetchClients = mysql_query($qryCli);
            $arrClients = mysql_fetch_assoc($fetchClients);
            
            $qryPra = "SELECT t1.id, t1.name
                        FROM pr_practice t1
                        WHERE t1.id = '{$_SESSION['PRACTICEID']}'
                        ORDER BY t1.name";
                        
            $fetchPrac = mysql_query($qryPra);
            $arrPractice = mysql_fetch_assoc($fetchPrac);
            
           
            $qryAct = "SELECT sa.sub_Code, sa.sub_Description
					FROM sub_subactivity sa
					WHERE sa.sub_Code = ".$arrJob[$jobid]['job_type_id']."
                                        AND sa.display_in_practice = 'yes'
					ORDER BY sa.sub_Order";
            $fetchAct = mysql_query($qryAct);
            $arrActivity = mysql_fetch_assoc($fetchAct);
            
            
            // HTML Part of PDF
            if($arrJob[$jobid][setup_subfrm_id] == 1)
            {
                $members = '';
                $leagalRef = '';
                $cnt = 1;
				$cntr = 1;
                foreach ($arrMembrs as $key => $value) 
                {
                   $value["gender"] =($value["gender"] == "M")?"Male":"Female";
                   $cntry = "SELECT * FROM es_country WHERE country_id = ".$value['country_id'];
                   $fetchCntry = mysql_query($cntry);
                   $Data = mysql_fetch_assoc($fetchCntry);
                   $value['country_id'] = $Data['country_name'];
                   
                   if($value['legal_references'] == 1)
                   {
                        foreach ($arrLegRef as $key => $value) 
                        {
                                if($cntr == 1)
									$leagalRef .= '<div class="test">Legal Personal Representative</div><br/>';
								
                                $leagalRef .= '<table class="fieldtable" cellpadding="4" cellspacing="6">
                                        <tr>
                                            <td colspan="2"><u>Legal Personal Representative '.$cntr.'</u></td>
                                        </tr>
                                        <tr>
                                            <td>Name : </td>
                                            <td>'.$value['title'].' '.$value['fname'].' '.$value['mname'].' '.$value['lname'].' </td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth : </td>
                                            <td>'.$value['dob'].' </td>
                                        </tr>
                                        <tr>
                                            <td>City of Birth : </td>
                                            <td>'.$value['city'].' </td>
                                        </tr>
                                        <tr>
                                            <td>Country of Birth : </td>
                                            <td>'.$value['country_id'].' </td>
                                        </tr>
                                        <tr>
                                            <td>Sex : </td>
                                            <td>'.$value["gender"].' </td>
                                        </tr>
                                        <tr>
                                            <td>Address : </td>
                                            <td>'.$value['address'].' </td>
                                        </tr>
                                        <tr>
                                            <td>Tax File Number : </td>
                                            <td> '.$value['tfn'].' </td>
                                        </tr>
                                        <tr>
                                            <td>Occupation : </td>
                                            <td>'.$value['occupation'].' </td>
                                        </tr>
                                        <tr>
                                            <td>Contact Number : </td>
                                            <td>'.$value['contact_no'].' </td>
                                        </tr>

                                    </table>
                                    <br/>';
                            $cntr++;
                        }
                   }
                           
                   if($cnt == 1)
                        $members .= '<div class="test">Member Details</div><br/>';
                    
                    $members .= '<table class="fieldtable" cellpadding="4" cellspacing="6">
                                <tr>
                                    <td colspan="2"><u>Member '.$cnt.'</u></td>
                                </tr>
                                <tr>
                                    <td>Member Name : </td>
                                    <td>'.$value['title'].' '.$value['fname'].' '.$value['mname'].' '.$value['lname'].' </td>
                                </tr>
                                <tr>
                                    <td>Date of Birth : </td>
                                    <td>'.$value['dob'].' </td>
                                </tr>
                                <tr>
                                    <td>City of Birth : </td>
                                    <td>'.$value['city'].' </td>
                                </tr>
                                <tr>
                                    <td>Country of Birth : </td>
                                    <td>'.$value['country_id'].' </td>
                                </tr>
                                <tr>
                                    <td>Sex : </td>
                                    <td>'.$value["gender"].' </td>
                                </tr>
                                <tr>
                                    <td>Address : </td>
                                    <td>'.$value['address'].' </td>
                                </tr>
                                <tr>
                                    <td>Tax File Number : </td>
                                    <td> '.$value['tfn'].' </td>
                                </tr>
                                <tr>
                                    <td>Occupation : </td>
                                    <td>'.$value['occupation'].' </td>
                                </tr>
                                <tr>
                                    <td>Contact Number : </td>
                                    <td>'.$value['contact_no'].' </td>
                                </tr>

                            </table>
                            <br/>';
                    $cnt++;
                }
                
            }
            if($arrJob[$jobid][setup_subfrm_id] == 1)
            {
                $trustee = '';
                if($arrFund[$jobid]['trustee_type_id'] == 1){
                    $trustee .= '';
                }  else if($arrFund[$jobid]['trustee_type_id'] == 2) {
                    $trustee .= '<div class="test">New Corporate Trustee Details</div>
                            <br />
                            <table class="fieldtable" cellpadding="4" cellspacing="6">
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
                            </table>';
                }  else if($arrFund[$jobid]['trustee_type_id'] == 3) {
                    $trustee .= '<div class="test">Existing Corporate Trustee Details</div>
                            <br />
                            <table class="fieldtable" cellpadding="4" cellspacing="6">
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
                            </table>';
                }
            }
            
            if($arrJob[$jobid][setup_subfrm_id] == 1)
            {
                $buttons = '<div align="left">
                            <span align="right"><button onclick=\' window.location.assign("new_smsf_declarations.php");\'>Back</button></span>
							<span style="padding-left:55px;" align="right"><button onclick=\' window.location.assign("jobs.php?a=saved");\'>Save & Exit</button></span>
                            <span style="padding-left:55px;" align="right"><button onclick=\' window.location.assign("new_smsf_declarations.php?job_submitted=Y");\'>Submit</button></span>
                        </div>';
                
                $fund = '<tr>
                                <td>Date of establishment : </td>
                                <td>'.$arrFund[$jobid]['date_of_establishment'].' </td>
                            </tr>
                            <tr>
                                <td>State of registration : </td>
                                <td>'.fetchStateName($arrFund[$jobid]['registration_state']).' </td>
                            </tr>';
                
            }    
            else if($arrJob[$jobid][setup_subfrm_id] == 2)
            {
                $buttons = '<div align="left">
                            <span align="right"><button onclick=\' window.location.assign("existing_smsf_fund.php");\'>Back</button></span>
							<span style="padding-left:55px;" align="right"><button onclick=\' window.location.assign("jobs.php?a=saved");\'>Save & Exit</button></span>
                            <span style="padding-left:55px;" align="right"><button onclick=\' window.location.assign("existing_smsf_fund.php?job_submitted=Y&preview_form=submit");\'>Submit</button></span>
                        </div>';
                $fund='<tr>
                            <td>Fund ABN : </td>
                            <td>'.$arrFund[$jobid]['abn'].' </td>
                        </tr>';
            }
            
            
            echo $html = '<!-- EXAMPLE OF CSS STYLE -->
                        <style>
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
                                font-size: 10px;
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
                        </style>
                        
                        <br/>
                        <div class="test">Contact Details</div>
                        <br />
                        <table class="fieldtable" cellpadding="4" cellspacing="6">
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
                        <br/>
                        <div class="test">Fund Details</div>
                        <br/>
                        <table class="fieldtable" cellpadding="4" cellspacing="6">
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
                            </tr>'.$fund.'
                            <tr>
                                <td>How many members? : </td>
                                <td>'.$arrFund[$jobid]['members'].' </td>
                            </tr>
                            <tr>
                                <td>Trustee Type : </td>
                                <td>'.fetchTrusteeName($arrFund[$jobid]['trustee_type_id']).' </td>
                            </tr>
                            
                        </table>                        
                        <br/>'.$members.$leagalRef.$trustee.'
                        <br/>
                        '.$buttons;
            
?>

<?php include(FOOTER); ?>
