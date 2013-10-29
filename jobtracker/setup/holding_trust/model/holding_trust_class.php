<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of new_smsf_class
 *
 * @author disha
 */
class Holding_Trust 
{
    // fetch trustee type
    public function fetchTrusteeType()
    {
        $selQry="SELECT trustee_id, trustee_name FROM holding_trustee";
        $fetchResult = mysql_query($selQry);
        while($rowResult = mysql_fetch_assoc($fetchResult)) {
            $arrTrusteeType[$rowResult['trustee_id']] = $rowResult['trustee_name'];
        }
        
        return $arrTrusteeType;
    }
    
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
    
    // insert holding trust details
    function newHoldingTrust($trust, $trusteeId, $compName, $acn, $address, $directors, $cntMember) 
    {
      $qryIns = "INSERT INTO holding_trust(job_id, trust_name, trustee_id, comp_name, acn, reg_address, director, noofmember)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($trust)."', 
                    ".$trusteeId.", 
                    '".addslashes($compName)."', 
                    '".addslashes($acn)."', 
                    '".addslashes($address)."', 
                    '".addslashes($directors)."',
                    '".$cntMember."'
                    )";
        mysql_query($qryIns);
    }
    
    // update holding trust details & corporate trust details
    function updateHoldingTrust($trust, $trusteeId, $compName, $acn, $address, $directors, $cntMember) 
    {
      $qryUpd = "UPDATE holding_trust
                    SET trust_name = '".addslashes($trust)."',
                        trustee_id = '".$trusteeId."',
                        comp_name = '".addslashes($compName)."',
                        acn = '".addslashes($acn)."',
                        reg_address = '".addslashes($address)."',
                        director = '".addslashes($directors)."',
                        noofmember = '".$cntMember."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch holding trust details
    public function fetchHoldingTrustDetails()
    {
       $selQry="SELECT trust_name, trustee_id, noofmember, comp_name, acn, reg_address, director
                FROM holding_trust 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
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
    
    // delete individual trustee
    function insertIndividual($trusteeName, $resAdd) 
    {
        $insMember="INSERT INTO indvdl_holding_trust (job_id, trustee_name, res_add) 
                    VALUES({$_SESSION['jobId']},'".addslashes($trusteeName)."','".addslashes($resAdd)."')";
        //print $insMember;
        mysql_query($insMember);
    }
    
    // delete individual trustee
    function updateIndividual($memberId, $trusteeName, $resAdd)  
    {
        $updMember = "UPDATE indvdl_holding_trust 
                        SET trustee_name = '".addslashes($trusteeName)."', 
                            res_add = '".addslashes($resAdd)."'
                        WHERE indvdl_id = {$memberId}";
                            
        //print $updMember;
        mysql_query($updMember);
    }
    
    // delete individual trustee
    function deleteIndividual($deleteMemberId) 
    {
        $delMember = "DELETE FROM indvdl_holding_trust WHERE job_id = {$_SESSION['jobId']} AND indvdl_id IN ({$deleteMemberId})";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // delete all individual trustee
    function deleteAllIndividual() 
    {
        $delMember = "DELETE FROM indvdl_holding_trust WHERE job_id = {$_SESSION['jobId']}";
        //print $delMember;
        mysql_query($delMember);
    }
}

?>