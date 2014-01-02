<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Nomination 
{
    
    // insert nominee details
    function newNominationDetails($name, $address, $dob, $beneficiaries) 
    {
      $qryIns = "INSERT INTO dbn_nomination(job_id, name, res_add, dob, noofbeneficiars)
                    VALUES (
                    '".$_SESSION['jobId']."',
                    '".addslashes($name)."', 
                    '".addslashes($address)."', 
                    '".$dob."',
                    '".$beneficiaries."'
                    )";
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateNominationDetails($name, $address, $dob, $beneficiaries) 
    {
      $qryUpd = "UPDATE dbn_nomination
                    SET name = '".addslashes($name)."',
                        reg_address = '".addslashes($address)."',
                        dob = '".$dob."',
                        $beneficiaries = '".$beneficiaries."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch nomination details
    public function fetchNominationDetails()
    {
        $selQry="SELECT job_id, name, res_add, DATE_FORMAT(dob, '%d/%m/%Y')dob, noofbeneficiars
                FROM dbn_nomination 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }       
    
    // fetch nomination Bref
    public function fetchNominationBref()
    {
       $selQry="SELECT benef_id, job_id, name,  DATE_FORMAT(dob, '%d/%m/%Y')dob, res_add, relationship, portion
                FROM dbn_nomination_benef 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrNominationBref[] = $rowData;
        }
        
        return $arrNominationBref;
    }
    
    // insert benef
    function insertbenef($name,$dob,$address, $relationship, $portion)
    {
        $insMember="INSERT INTO dbn_nomination_benef (job_id, name, dob, res_add, relationship, portion) 
                    VALUES({$_SESSION['jobId']},'".addslashes($name)."','".$dob."','".addslashes($address)."','".addslashes($relationship)."','".$portion."')";
        //print $insMember;
        mysql_query($insMember);
    }
    
    // update benef
    function updatebenef($benef_id, $name,$dob,$address, $relationship, $portion)  
    {
        echo $updMember = "UPDATE dbn_nomination_benef 
                        SET name = '".addslashes($name)."', 
							dob = '".$dob."',
							res_add = '".addslashes($address)."', 							
                            relationship = '".addslashes($relationship)."',
							portion = '".$portion."'
                        WHERE benef_id = {$benef_id}";
                   
        //print $updMember;
        mysql_query($updMember);
    }
    
    // delete benef
    function deletebenef($benef_id) 
    {
        $delMember = "DELETE FROM dbn_nomination_benef WHERE job_id = {$_SESSION['jobId']} AND benef_id IN ({$benef_id})";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // delete all benef
    function deleteAllbenef() 
    {
        $delMember = "DELETE FROM dbn_nomination_benef WHERE job_id = {$_SESSION['jobId']}";
        //print $delMember;
        mysql_query($delMember);
    }
    
}

?>