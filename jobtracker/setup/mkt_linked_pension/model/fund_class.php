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
      $qryIns = "INSERT INTO mkt_fund_dtls(job_id, fund_name, metAddUnit,metAddBuild,metAddStreet,metAddSubrb,metAddState,metAddPstCode,metAddCntry)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($_REQUEST['txtFund'])."', 
                    '".addslashes($_REQUEST['metAddUnit'])."',
					'".addslashes($_REQUEST['metAddBuild'])."',
					'".addslashes($_REQUEST['metAddStreet'])."',
					'".addslashes($_REQUEST['metAddSubrb'])."',
					'".addslashes($_REQUEST['metAddState'])."',
					'".addslashes($_REQUEST['metAddPstCode'])."',
					'".addslashes($_REQUEST['metAddCntry'])."'
                    )";
      
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateFund() 
    {
      $qryUpd = "UPDATE mkt_fund_dtls
                    SET fund_name = '".addslashes($_REQUEST['txtFund'])."',
                        metAddUnit = '".addslashes($_REQUEST['metAddUnit'])."' ,
						metAddBuild = '".addslashes($_REQUEST['metAddBuild'])."' ,
						metAddStreet = '".addslashes($_REQUEST['metAddStreet'])."' ,
						metAddSubrb = '".addslashes($_REQUEST['metAddSubrb'])."' ,
						metAddState = '".addslashes($_REQUEST['metAddState'])."' ,
						metAddPstCode = '".addslashes($_REQUEST['metAddPstCode'])."' ,
						metAddCntry = '".addslashes($_REQUEST['metAddCntry'])."' 
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch fund details
    public function fetchFundDetails()
    {
        $selQry="SELECT job_id, fund_name, metAddUnit,metAddBuild,metAddStreet,metAddSubrb,metAddState,metAddPstCode,metAddCntry FROM mkt_fund_dtls WHERE job_id=".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrData = mysql_fetch_assoc($fetchResult);
            
        return $arrData;
    }
    
}

?>