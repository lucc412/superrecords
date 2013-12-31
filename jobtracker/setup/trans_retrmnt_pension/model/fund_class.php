<?php

class Fund 
{
    
    // this function is used to insert job details into Job table 
    function insertNewJob() 
    {
        $qryIns = "INSERT INTO job(job_genre, mas_Code, job_type_id, period, job_status_id, setup_subfrm_id, job_created_date)
                    VALUES ( 
                    'SETUP', 
                    '25', 
                    '21', 
                    'Year End 30/06/". date('Y') . "',  
                    1,   
                    ".$_REQUEST['frmId'].",    
                    '".date('Y-m-d')."'
                    )";

        mysql_query($qryIns);
        $jobId = mysql_insert_id();

        return $jobId;
    }
        
    // update client id and job name
    function updateClientName($fundName)
    {
        $qrySel = "SELECT t1.client_id, t1.client_name 
                    FROM client t1
                    WHERE id = '{$_SESSION['PRACTICEID']}' 
                    AND t1.client_name = '".$fundName."'";

        $fetchResult = mysql_query($qrySel);
        $rowData = mysql_fetch_assoc($fetchResult);

        if($rowData) $client_id = $rowData['client_id'];
        else
        {
            // client_code
            $qryIns = "INSERT INTO client(client_type_id, client_name, recieved_authority, id, client_received)
                    VALUES (7, '" . addslashes($fundName) . "', 1, " . $_SESSION['PRACTICEID'] . ", '".date('Y-m-d')."')";

            $flagReturn = mysql_query($qryIns);
            $client_id = mysql_insert_id();

            generateClientCode($client_id,$fundName);
        }

        if(!empty($client_id))
        {
            $jobName = $client_id .'::Year End 30/06/'. date('Y') .'::21';
            $updt = "UPDATE job 
                    SET client_id = ".$client_id.", 
                    job_name = '".addslashes($jobName)."' 
                    WHERE job_id = ".$_SESSION['jobId'];

            mysql_query($updt);
        }
    }
    
    
    // insert fund details
    function insertFund() 
    {
      $qryIns = "INSERT INTO trp_fund_dtls(job_id, fund_name, mt_add_unit, mt_add_build, mt_add_street, mt_add_subrb, mt_add_state, mt_add_pst_code, mt_add_cntry)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($_REQUEST['txtFund'])."', 
                    '".addslashes($_REQUEST['mtAddUnit'])."', 
                    '".addslashes($_REQUEST['mtAddBuild'])."', 
                    '".addslashes($_REQUEST['mtAddStreet'])."', 
                    '".addslashes($_REQUEST['mtAddSubrb'])."', 
                    '".$_REQUEST['mtAddState']."', 
                    '".addslashes($_REQUEST['mtAddPstCode'])."',
                    '".addslashes($_REQUEST['mtAddCntry'])."'
                    )";
      
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateFund() 
    {
      $qryUpd = "UPDATE trp_fund_dtls
                    SET fund_name = '".addslashes($_REQUEST['txtFund'])."',
                        mt_add_unit = '".addslashes($_REQUEST['mtAddUnit'])."',
                        mt_add_build = '".addslashes($_REQUEST['mtAddBuild'])."',
                        mt_add_street = '".addslashes($_REQUEST['mtAddStreet'])."',
                        mt_add_subrb = '".addslashes($_REQUEST['mtAddSubrb'])."',
                        mt_add_state = '".addslashes($_REQUEST['mtAddState'])."',
                        mt_add_pst_code = '".addslashes($_REQUEST['mtAddPstCode'])."',
                        mt_add_cntry = '".addslashes($_REQUEST['mtAddCntry'])."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch fund details
    public function fetchFundDetails()
    {
        $selQry="SELECT job_id, fund_name, mt_add_unit, mt_add_build, mt_add_street, mt_add_subrb, mt_add_state, mt_add_pst_code, mt_add_cntry FROM trp_fund_dtls WHERE job_id=".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrData = mysql_fetch_assoc($fetchResult);
            
        return $arrData;
    }
    
}

?>