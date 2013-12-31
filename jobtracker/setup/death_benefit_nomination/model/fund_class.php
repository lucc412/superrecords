<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Fund 
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
    function newFundDetails($fund, $trusteeId, $compName, $acn, $address, $cntDirector, $cntMember) 
    {
      $qryIns = "INSERT INTO dbn_fund(job_id, fund, trustee_id, comp_name, acn, reg_address, noofdirector, noofmember)
                    VALUES (
                    '".$_SESSION['jobId']."',
                    '".addslashes($fund)."', 
                    ".$trusteeId.", 
                    '".addslashes($compName)."', 
                    '".addslashes($acn)."', 
                    '".addslashes($address)."', 
                    '".$cntDirector."',
                    '".$cntMember."'
                    )";
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateFundDetails($fund, $trusteeId, $compName, $acn, $address, $cntDirector, $cntMember) 
    {
      $qryUpd = "UPDATE dbn_fund
                    SET fund = '".addslashes($fund)."',
                        trustee_id = '".$trusteeId."',
                        comp_name = '".addslashes($compName)."',
                        acn = '".addslashes($acn)."',
                        reg_address = '".addslashes($address)."',
                        noofdirector = '".$cntDirector."',
                        noofmember = '".$cntMember."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch holding trust details
    public function fetchHoldingTrustDetails()
    {
        $selQry="SELECT fund, trustee_id, noofmember, noofdirector, comp_name, acn, reg_address
                FROM dbn_fund 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // fetch director
    public function fetchDirectorDetails()
    {
       $selQry="SELECT d_id, name, res_add address
                FROM dbn_director 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // insert director
    function insertDirector($dirName, $resAdd) 
    {
        $insDir="INSERT INTO dbn_director (job_id, name, res_add) 
                    VALUES({$_SESSION['jobId']},'".addslashes($dirName)."','".addslashes($resAdd)."')";
        //print $insDir;exit;
        mysql_query($insDir);
    }
    
    // update director
    function updateDirector($memberId, $dirName, $resAdd)  
    {
        $updDir = "UPDATE dbn_director 
                        SET name = '".addslashes($dirName)."', 
                            res_add = '".addslashes($resAdd)."'
                        WHERE d_id = {$memberId}";
                            
        //print $updDir;
        mysql_query($updDir);
    }
    
    // delete director
    function deleteDirector($deleteMemberId) 
    {
        $delMember = "DELETE FROM dbn_director WHERE job_id = {$_SESSION['jobId']} AND d_id IN ({$deleteMemberId})";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // delete all director
    function deleteAllDirector() 
    {
        $delMember = "DELETE FROM dbn_director WHERE job_id = {$_SESSION['jobId']}";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, fname, lname, mname, res_add address, res_add
                FROM dbn_indvdl_member 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // insert individual trustee
    function insertIndividual($trusteeFName, $trusteeLName, $trusteeMName, $resAdd) 
    {
        $insMember="INSERT INTO dbn_indvdl_member (job_id, fname, lname, mname, res_add) 
                    VALUES({$_SESSION['jobId']},'".addslashes($trusteeFName)."','".addslashes($trusteeLName)."','".addslashes($trusteeMName)."','".addslashes($resAdd)."')";
        //print $insMember;
        mysql_query($insMember);
    }
    
    // update individual trustee
    function updateIndividual($memberId, $trusteeFName,$trusteeLName, $trusteeMName, $resAdd)  
    {
        echo $updMember = "UPDATE dbn_indvdl_member 
                        SET fname = '".addslashes($trusteeFName)."', 
							mname = '".addslashes($trusteeMName)."', 						
							lname = '".addslashes($trusteeLName)."', 							
                            res_add = '".addslashes($resAdd)."'
                        WHERE indvdl_id = {$memberId}";
                   
        //print $updMember;
        mysql_query($updMember);
    }
    
    // delete individual trustee
    function deleteIndividual($deleteMemberId) 
    {
        $delMember = "DELETE FROM dbn_indvdl_member WHERE job_id = {$_SESSION['jobId']} AND indvdl_id IN ({$deleteMemberId})";
        //print $delMember;
        mysql_query($delMember);
    }
    
    // delete all individual trustee
    function deleteAllIndividual() 
    {
        $delMember = "DELETE FROM dbn_indvdl_member WHERE job_id = {$_SESSION['jobId']}";
        //print $delMember;
        mysql_query($delMember);
    }
    
}

?>