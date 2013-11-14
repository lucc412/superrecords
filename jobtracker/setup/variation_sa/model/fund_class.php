<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fund_class.php
 *
 * @author disha
 */
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
    function newFund($fund, $unit, $build, $street, $suburb, $state, $postCode, $country, $dtEstblshmnt, $dtVariation, $varCls) 
    {
      $qryIns = "INSERT INTO vsa_fund(job_id, fund_name, met_add_unit, met_add_build, met_add_street, met_add_subrb, met_add_state, met_add_pst_code, met_add_country, 
                        dt_estblshmnt, dt_variation, variation_clause)
                    VALUES (
                    '".$_SESSION['jobId']."',
                    '".addslashes($fund)."',
                    '".addslashes($unit)."',
                    '".addslashes($build)."',
                    '".addslashes($street)."',
                    '".addslashes($suburb)."',
                    '".$state."',
                    '".addslashes($postCode)."',
                    '".$country."',
                    '".$dtEstblshmnt."',
                    '".$dtVariation."',
                    '".addslashes($varCls)."'
                    )";
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateFund($fund, $unit, $build, $street, $suburb, $state, $postCode, $country, $dtEstblshmnt, $dtVariation, $varCls) 
    {
      $qryUpd = "UPDATE vsa_fund
                    SET fund_name = '".addslashes($fund)."',
                        met_add_unit = '".addslashes($unit)."',
                        met_add_build = '".addslashes($build)."',
                        met_add_street = '".addslashes($street)."',
                        met_add_subrb = '".addslashes($suburb)."',
                        met_add_state = '".$state."',
                        met_add_pst_code = '".addslashes($postCode)."',
                        met_add_country = '".$country."',
                        dt_estblshmnt = '".$dtEstblshmnt."',
                        dt_variation = '".$dtVariation."',
                        variation_clause = '".addslashes($varCls)."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch fund details
    public function fetchFundDetails()
    {
       $selQry="SELECT fund_name, met_add_unit, met_add_build, met_add_street, met_add_subrb, met_add_state, met_add_pst_code, met_add_country, 
                DATE_FORMAT(dt_estblshmnt, '%d/%m/%Y')dt_estblshmnt, DATE_FORMAT(dt_variation, '%d/%m/%Y')dt_variation, variation_clause
                FROM vsa_fund
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
}

?>