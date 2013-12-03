<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of change_fund_class
 *
 * @author siddheshc
 */
class CHANGE_FUND {
    //put your code here
    
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
    function updateClientName($newFundName)
    {
        $qrySel = "SELECT t1.client_id, t1.client_name 
                    FROM client t1
                    WHERE id = '{$_SESSION['PRACTICEID']}' 
                    AND t1.client_name = '".$newFundName."'";

        $fetchResult = mysql_query($qrySel);
        $rowData = mysql_fetch_assoc($fetchResult);

        if($rowData)
        {
            $client_id = $rowData['client_id'];
        }
        else
        {
            // client_code
            $qryIns = "INSERT INTO client(client_type_id, client_name, recieved_authority, id, client_received)
                    VALUES (7, '" . addslashes($newFundName) . "', 1, " . $_SESSION['PRACTICEID'] . ", '".date('Y-m-d')."')";

            $flagReturn = mysql_query($qryIns);
            $client_id = mysql_insert_id();

            generateClientCode($client_id,$newFundName);
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
    function newFundName($fundDtls) 
    {
        $qryIns = "INSERT INTO cfn_fund_dtls(job_id, ext_fund_name, new_fund_name, metAddUnit, metAddBuild, metAddStreet, metAddSubrb, metAddState, metAddPstCode, metAddCntry)
                    VALUES (
                    '".$_SESSION['jobId']."',
                    '".addslashes($fundDtls['txtExtFund'])."',
                    '".addslashes($fundDtls['txtNewFund'])."',
                    '".addslashes($fundDtls['metAddUnit'])."',
                    '".addslashes($fundDtls['metAddBuild'])."',
                    '".addslashes($fundDtls['metAddStreet'])."',
                    '".addslashes($fundDtls['metAddSubrb'])."',
                    '".$fundDtls['metAddState']."',
                    '".addslashes($fundDtls['metAddPstCode'])."',
                    '".$fundDtls['metAddCntry']."'
                    )";
        
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateFundName($fundDtls) 
    {
        
        $qryUpd = "UPDATE cfn_fund_dtls
                    SET ext_fund_name = '".addslashes($fundDtls['txtExtFund'])."',
                        new_fund_name = '".addslashes($fundDtls['txtNewFund'])."',
                        metAddUnit = '".addslashes($fundDtls['metAddUnit'])."',
                        metAddBuild = '".addslashes($fundDtls['metAddBuild'])."',
                        metAddStreet = '".addslashes($fundDtls['metAddStreet'])."',
                        metAddSubrb = '".addslashes($fundDtls['metAddSubrb'])."',
                        metAddState = '".$fundDtls['metAddState']."',
                        metAddPstCode = '".addslashes($fundDtls['metAddPstCode'])."',
                        metAddCntry = '".$fundDtls['metAddCntry']."'
                    WHERE job_id = ".$_SESSION['jobId'];
      
        mysql_query($qryUpd);
    }
    
    // fetch fund details
    public function fetchFundDetails()
    {
       
       $selQry="SELECT job_id, ext_fund_name, new_fund_name, metAddUnit, metAddBuild, metAddStreet, metAddSubrb, metAddState, metAddPstCode, metAddCntry
                        FROM cfn_fund_dtls
                        WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrFundDtls = mysql_fetch_assoc($fetchResult);
            
        return $arrFundDtls;
    }
    
}

?>
