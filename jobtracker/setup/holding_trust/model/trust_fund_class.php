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
class Trust_Fund 
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
    function newHoldingTrust($trust, $trusteeId, $compName, $acn, $address, $directors, $cntMember) 
    {
      $qryIns = "INSERT INTO trust_fund(job_id, trust_name, trustee_id, comp_name, acn, reg_address, director, noofmember)
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
    
    // update fund details
    function updateHoldingTrust($trust, $trusteeId, $compName, $acn, $address, $directors, $cntMember) 
    {
      $qryUpd = "UPDATE trust_fund
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
                FROM trust_fund 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, trustee_name name, res_add address
                FROM indvdl_holding_fund 
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
        $insMember="INSERT INTO indvdl_holding_fund (job_id, trustee_name, res_add) 
                    VALUES({$_SESSION['jobId']},'".addslashes($trusteeName)."','".addslashes($resAdd)."')";
        //print $insMember;
        mysql_query($insMember);
    }
    
    // delete individual trustee
    function updateIndividual($memberId, $trusteeName, $resAdd)  
    {
        $updMember = "UPDATE indvdl_holding_fund 
                        SET trustee_name = '".addslashes($trusteeName)."', 
                            res_add = '".addslashes($resAdd)."'
                        WHERE indvdl_id = {$memberId}";
                            
        //print $updMember;
        mysql_query($updMember);
    }
    
    // delete individual trustee
    function deleteIndividual($deleteMemberId) 
    {
        $delMember = "DELETE FROM indvdl_holding_fund WHERE job_id = {$_SESSION['jobId']} AND indvdl_id IN ({$deleteMemberId})";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // delete all individual trustee
    function deleteAllIndividual() 
    {
        $delMember = "DELETE FROM indvdl_holding_fund WHERE job_id = {$_SESSION['jobId']}";
        //print $delMember;
        mysql_query($delMember);
    }
    
}

?>