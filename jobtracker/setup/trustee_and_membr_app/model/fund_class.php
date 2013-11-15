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
      $qryIns = "INSERT INTO ctm_fund_dtls(job_id, fund_name, new_director_name, res_add_unit, res_add_build, res_add_street, res_add_subrb, res_add_state, res_add_pst_code, dob)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($_REQUEST['txtFund'])."', 
                    '".addslashes($_REQUEST['txtNwDirctr'])."', 
                    '".addslashes($_REQUEST['resAddUnit'])."', 
                    '".addslashes($_REQUEST['resAddBuild'])."', 
                    '".addslashes($_REQUEST['resAddStreet'])."', 
                    '".addslashes($_REQUEST['resAddSubrb'])."', 
                    '".$_REQUEST['resAddState']."', 
                    '".addslashes($_REQUEST['resAddPstCode'])."', 
                    '".getDateFormat($_REQUEST['txtDob'])."'
                    )";
      
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateFund() 
    {
      $qryUpd = "UPDATE ctm_fund_dtls
                    SET fund_name = '".addslashes($_REQUEST['txtFund'])."',
                        new_director_name = '".addslashes($_REQUEST['txtNwDirctr'])."',
                        res_add_unit = '".addslashes($_REQUEST['resAddUnit'])."',
                        res_add_build = '".addslashes($_REQUEST['resAddBuild'])."',
                        res_add_street = '".addslashes($_REQUEST['resAddStreet'])."',
                        res_add_subrb = '".addslashes($_REQUEST['resAddSubrb'])."',
                        res_add_state = '".addslashes($_REQUEST['resAddState'])."',
                        res_add_pst_code = '".addslashes($_REQUEST['resAddPstCode'])."',
                        dob = '".getDateFormat($_REQUEST['txtDob'])."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch fund details
    public function fetchFundDetails()
    {
        $selQry="SELECT job_id, fund_name, new_director_name, res_add_unit, res_add_build, res_add_street, res_add_subrb, res_add_state, res_add_pst_code, DATE_FORMAT(dob, '%d/%m/%Y') dob FROM ctm_fund_dtls WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrData = mysql_fetch_assoc($fetchResult);
            
        return $arrData;
    }
    
}

?>