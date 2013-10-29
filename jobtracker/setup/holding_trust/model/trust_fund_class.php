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
    
    // insert holding trust details & individual details
    function newHoldingTrustIndividual($trust, $trusteeId, $cntMember, $arrTrusteeData) 
    {
        $qryIns = "INSERT INTO trust_fund(job_id, trust_name, trustee_id, noofmember)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($trust)."', 
                    ".$trusteeId.", 
                    ".$cntMember."
                    )";

        mysql_query($qryIns);
        
        foreach ($arrTrusteeData AS $trusteeData) {
           $qryIns = "INSERT INTO indvdl_holding_fund(job_id, trustee_name, res_add)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($trusteeData['name'])."', 
                    '".addslashes($trusteeData['address'])."'
                    )";
            mysql_query($qryIns);
        }
    }
    
    // insert holding trust details & corporate trust details
    function newHoldingTrustCorporate($trust, $trusteeId, $compName, $acn, $address, $directors) 
    {
      $qryIns = "INSERT INTO trust_fund(job_id, trust_name, trustee_id, comp_name, acn, reg_address, director)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($trust)."', 
                    ".$trusteeId.", 
                    '".addslashes($compName)."', 
                    '".addslashes($acn)."', 
                    '".addslashes($address)."', 
                    '".addslashes($directors)."'
                    )";
        mysql_query($qryIns);
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
    
    // update holding trust details & corporate trust details
    function updateHoldingTrust($trust, $trusteeId, $compName, $acn, $address, $directors) 
    {
      $qryUpd = "UPDATE trust_fund
                    SET trust_name = '".addslashes($trust)."',
                        trustee_id = '".$trusteeId."',
                        comp_name = '".addslashes($compName)."',
                        acn = '".addslashes($acn)."',
                        reg_address = '".addslashes($address)."',
                        director = '".addslashes($directors)."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // update holding trust details & corporate trust details
    function updateHoldingTrustIndividual($trust, $trusteeId, $cntMember, $arrAddMember, $arrRemMember) 
    {
      $qryUpd = "UPDATE trust_fund
                    SET trust_name = '".addslashes($trust)."',
                        trustee_id = '".$trusteeId."',
                        noofmember = '".$cntMember."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
        
        if(!empty($arrAddMember)) {
                $insMember = "INSERT INTO indvdl_holding_fund (job_id, trustee_name, res_add) VALUES";
                foreach($arrAddMember AS $memberInfo) {
                        $insMember .= "({$_SESSION['jobId']}, '{$memberInfo['name']}', '{$memberInfo['address']}'),";
                }
                $insMember = stringrtrim($insMember, ",");
                //print $insMember;exit;
                mysql_query($insMember);	
        }

        if(!empty($arrRemMember)) {
                $delMember = "DELETE FROM indvdl_holding_fund WHERE job_id = {$_SESSION['jobId']} AND indvdl_id IN (";
                foreach($arrRemMember AS $memberInfo) {
                        $delMember .= "'{$memberInfo['indvdl_id']}',";
                }
                $delMember = stringrtrim($delMember, ",");
                $delMember .= ")";
                //print $delMember;exit;
                mysql_query($delMember);	
        }
    }
    
}

?>