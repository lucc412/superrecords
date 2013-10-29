<?php

/**
 * Description of company_details_class
 *
 * @author siddheshc
 */

class COMPANY_DETAILS
{
    //put your code here    
    
    public function fetchCompDtls()
    {
        $qry = "SELECT * FROM stp_comp_dtls WHERE job_id = ".$_SESSION['jobId'];
        $fetchResult = mysql_query($qry);
        $rowData = mysql_fetch_assoc($fetchResult);
                
        return $rowData;
    } 
    
    public function insertCompanyDetails()
    {        
        $compPref = implode(',',$_REQUEST['txtCompPref']); 
        $juriReg = $_REQUEST['selJuriReg'];
        $existBusnsName = $_REQUEST['selExtBusName']; 
        $regBusns = $_REQUEST['selRegBusns'];
        $regBusnsABN = $_REQUEST['txtABN'];
        $regBusnsState = $_REQUEST['selState']; 
        $regNo = $_REQUEST['txtRegNo'];
        
        if($existBusnsName == 1)
        {
            if($regBusns == 1)
            {
                $regBusnsState = ''; 
                $regNo = '';
            }
            else
            {
                $regBusnsABN = '';
            }
        }
        else
        {
            $regBusns = '';
            $regBusnsABN = '';
            $regBusnsState = ''; 
            $regNo = '';
        }
                
        $qry = "INSERT INTO stp_comp_dtls (job_id, comp_pref_name, comp_juri_reg, exst_busns_name, reg_busns_name, reg_busns_abn, reg_busns_state, reg_busns_number)
                    VALUES('".$_SESSION['jobId']."',
                            '".addslashes($compPref)."',
                            '".$juriReg."',
                            '".$existBusnsName."',
                            '".$regBusns."',
                            '".$regBusnsABN."',
                            '".$regBusnsState."',
                            '".$regNo."'
                           )";
        
        $result = mysql_query($qry);
        return $result;
    }
    
    public function updateCompanyDetails()
    {        
        $compPref = implode(',',$_REQUEST['txtCompPref']); 
        $juriReg = $_REQUEST['selJuriReg'];
        $existBusnsName = $_REQUEST['selExtBusName']; 
        $regBusns = $_REQUEST['selRegBusns'];
        $regBusnsABN = $_REQUEST['txtABN'];
        $regBusnsState = $_REQUEST['selState']; 
        $regNo = $_REQUEST['txtRegNo'];
        
        if($existBusnsName == 1)
        {
            if($regBusns == 1)
            {
                $regBusnsState = ''; 
                $regNo = '';
            }
            else
            {
                $regBusnsABN = '';
            }
        }
        else
        {
            $regBusns = '';
            $regBusnsABN = '';
            $regBusnsState = ''; 
            $regNo = '';
        }
                
        $qry = "UPDATE stp_comp_dtls SET comp_pref_name = '".addslashes($compPref)."',  
                                         comp_juri_reg = '".$juriReg."',
                                         exst_busns_name = '".$existBusnsName."', 
                                         reg_busns_name = '".$regBusns."', 
                                         reg_busns_abn = '".$regBusnsABN."',
                                         reg_busns_state = '".$regBusnsState."', 
                                         reg_busns_number = '".$regNo."'
                                         WHERE job_id = '".$_SESSION['jobId']."' ";
        
        
        $result = mysql_query($qry);
        return $result;
    }
    
    function insertJobDetail()
    {
        $clientId = NULL;
        $jobtypeId = 21;
        $cliType = 25;
        $period = 'Year End 30/06/'. date('Y');
        $jobGenre = 'SETUP';
        $setup_subfrm = $_SESSION['frmId'];
        
        $jobSubmitted = 'N';
        $jobReceived = 'NULL';
        $job_due_date = "0000-00-00 00:00:00";
        
        $jobName = $clientId .'::'. $period .'::'. $jobtypeId;
        if(empty($clientId) && empty($period))$jobName=NULL;
        
        $qryIns = "INSERT INTO job(client_id, job_genre, job_submitted, mas_Code, job_type_id, period, job_name, job_status_id, setup_subfrm_id, job_created_date, job_received, job_due_date)
                                VALUES (
                                '" . $clientId . "', 
                                '" . $jobGenre . "', 
                                '" . $jobSubmitted . "', 
                                " . $cliType . ", 
                                " . $jobtypeId . ", 
                                '" . $period . "',
                                '" . $jobName . "',  
                                1,   
                                '".$setup_subfrm."',    
                                '".date('Y-m-d')."',            
                                '".$jobReceived."',
                                '".$job_due_date."'
                                )";
        mysql_query($qryIns);
        $jobId = mysql_insert_id();
        
        return $jobId;
        
    }
}

?>
