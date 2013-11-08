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
    
    // insert holding trust details
    function newHoldingTrust($trusteeId, $compName, $acn, $address, $directors, $cntMember) 
    {
      $qryIns = "INSERT INTO lrl_holding_trust(job_id, trustee_id, comp_name, acn, reg_address, director, noofmember)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
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
    function updateHoldingTrust($trusteeId, $compName, $acn, $address, $directors, $cntMember) 
    {
      $qryUpd = "UPDATE lrl_holding_trust
                    SET trustee_id = '".$trusteeId."',
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
       $selQry="SELECT trustee_id, noofmember, comp_name, acn, reg_address, director
                FROM lrl_holding_trust 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, trustee_name name, res_add address
                FROM lrl_indvdl_holding_trust 
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
        $insMember="INSERT INTO lrl_indvdl_holding_trust (job_id, trustee_name, res_add) 
                    VALUES({$_SESSION['jobId']},'".addslashes($trusteeName)."','".addslashes($resAdd)."')";
        //print $insMember;
        mysql_query($insMember);
    }
    
    // delete individual trustee
    function updateIndividual($memberId, $trusteeName, $resAdd)  
    {
        $updMember = "UPDATE lrl_indvdl_holding_trust 
                        SET trustee_name = '".addslashes($trusteeName)."', 
                            res_add = '".addslashes($resAdd)."'
                        WHERE indvdl_id = {$memberId}";
                            
        //print $updMember;
        mysql_query($updMember);
    }
    
    // delete individual trustee
    function deleteIndividual($deleteMemberId) 
    {
        $delMember = "DELETE FROM lrl_indvdl_holding_trust WHERE job_id = {$_SESSION['jobId']} AND indvdl_id IN ({$deleteMemberId})";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // delete all individual trustee
    function deleteAllIndividual() 
    {
        $delMember = "DELETE FROM lrl_indvdl_holding_trust WHERE job_id = {$_SESSION['jobId']}";
        //print $delMember;
        mysql_query($delMember);
    }
}

?>