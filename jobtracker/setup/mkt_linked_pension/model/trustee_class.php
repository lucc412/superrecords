<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trustee
 *
 * @author siddheshc
 */
class TRUSTEE 
{
    // put your code here
    // fetch trustee type
    public function fetchTrustee()
    {
        $selQry="SELECT trusty_id, job_id, trusty_type, no_of_members FROM mkt_trusty_dtls 
                        WHERE job_id = ".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrTrustee = mysql_fetch_assoc($fetchResult);
        
        return $arrTrustee;
    }
    
    // insert holding trust details
    function newTrusty($trustyDtls) 
    {
      $qryIns = "INSERT INTO mkt_trusty_dtls(job_id, trusty_type, no_of_members)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    ".$trustyDtls['selTrstyType'].", 
                    '".$trustyDtls['selMember']."'
                    )";
        mysql_query($qryIns);
    }
    
    // update holding trust details & corporate trust details
    function updateTrusty($trustyDtls) 
    {
        $qryUpd = "UPDATE mkt_trusty_dtls
                    SET trusty_type = '".$trustyDtls['selTrstyType']."',
                        no_of_members = '".$trustyDtls['selMember']."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch holding trust details
    public function fetchCorpTrustDetails()
    {
       $selQry="SELECT corp_id, job_id, comp_name, acn, reg_add, directors
                FROM mkt_corp_trusty_dtls 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrCorpTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrCorpTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, job_id, fname, mname, lname, res_add
                FROM mkt_indvdl_trusty_dtls 
                WHERE job_id = ".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // insert individual trustee
    function insertIndividual($FName, $MName, $LName, $ResAdd) 
    {
        $insMember="INSERT INTO mkt_indvdl_trusty_dtls (job_id, fname, mname, lname, res_add) 
                                VALUES({$_SESSION['jobId']},
                                        '".addslashes($FName)."',
                                        '".addslashes($MName)."',
                                        '".addslashes($LName)."',
                                        '".addslashes($ResAdd)."'
                                       )";
       //echo $insMember;
        mysql_query($insMember);
    }
    
    // update individual trustee
    function updateIndividual($FName, $MName, $LName, $ResAdd, $indvdlId)  
    {
        $updMember = "UPDATE mkt_indvdl_trusty_dtls 
                        SET fname = '".addslashes($FName)."', 
                            mname = '".addslashes($MName)."',
                            lname = '".addslashes($LName)."',
                            res_add = '".addslashes($ResAdd)."'
                        WHERE indvdl_id = {$indvdlId}";
                            
        //print $updMember; 
        mysql_query($updMember);
    }
    
    // insert individual trustee
    function insertCorporate($trustyDtls) 
    {
        $insMember="INSERT INTO mkt_corp_trusty_dtls (job_id, comp_name, acn, reg_add, directors) 
                                VALUES({$_SESSION['jobId']},
                                        '".addslashes($trustyDtls['txtCompName'])."',
                                        '".addslashes($trustyDtls['txtAcn'])."',
                                        '".addslashes($trustyDtls['txtAdd'])."',
                                        '".addslashes($trustyDtls['directors'])."'
                                       )";
        //echo $insMember;
        mysql_query($insMember);
    }
    
    // update individual trustee
    function updateCorporate($trustyDtls)  
    {
        $updMember = "UPDATE mkt_corp_trusty_dtls 
                        SET comp_name = '".addslashes($trustyDtls['txtCompName'])."', 
                            acn = '".addslashes($trustyDtls['txtAcn'])."',
                            reg_add = '".addslashes($trustyDtls['txtAdd'])."',
                            directors = '".addslashes($trustyDtls['directors'])."'
                        WHERE job_id = {$_SESSION['jobId']}";
                            
        //echo $updMember;
        mysql_query($updMember);
    }
    
    // delete individual trustee
    function deleteIndividual($deleteMemberId) 
    {
        $delMember = "DELETE FROM mkt_indvdl_trusty_dtls WHERE job_id = {$_SESSION['jobId']} AND indvdl_id IN ({$deleteMemberId})";
       // print $delMember;
        mysql_query($delMember);
    }
    
    // delete all individual trustee
    function deleteAllIndividual() 
    {
        $delMember = "DELETE FROM mkt_indvdl_trusty_dtls WHERE job_id = {$_SESSION['jobId']}";
       // print $delMember;
        mysql_query($delMember);
    }
    
    // delete all individual trustee
    function deleteAllCorporate() 
    {
        $delMember = "DELETE FROM mkt_corp_trusty_dtls WHERE job_id = {$_SESSION['jobId']}";
       // print $delMember;
        mysql_query($delMember);
    }
    
}

?>
