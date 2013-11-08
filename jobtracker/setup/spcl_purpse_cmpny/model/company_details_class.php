<?php

/**
 * Description of company_details_class
 *
 * @author siddheshc
 */

class COMPANY_DETAILS
{
    //put your code here    
    
    public function fetchCompDtls()
    {
        $qry = "SELECT * FROM spc_comp_dtls WHERE job_id = ".$_SESSION['jobId'];
        $fetchResult = mysql_query($qry);
        $rowData = mysql_fetch_assoc($fetchResult);
                
        return $rowData;
    } 
    
    public function insertCompanyDetails()
    {        
        $compPref = arrayToString(',',  array_filter($_REQUEST['txtCompPref'])); 
        $juriReg = $_REQUEST['selJuriReg'];
                
        $qry = "INSERT INTO spc_comp_dtls (job_id, comp_pref_name, comp_juri_reg)
                    VALUES('".$_SESSION['jobId']."',
                            '".addslashes($compPref)."',
                            '".$juriReg."'
                           )";
        
        $result = mysql_query($qry);
        return $result;
    }
    
    public function updateCompanyDetails()
    {        
        $compPref = implode(',',array_filter($_REQUEST['txtCompPref'])); 
        $juriReg = $_REQUEST['selJuriReg'];
                
        $qry = "UPDATE spc_comp_dtls 
            SET comp_pref_name = '".addslashes($compPref)."',  
                comp_juri_reg = '".$juriReg."'
                WHERE job_id = '".$_SESSION['jobId']."' ";
        
        
        $result = mysql_query($qry);
        return $result;
    }
    
    // update client id and job name
    function updateClientName($cliName)
    {
        $qrySel = "SELECT t1.client_id, t1.client_name 
                    FROM client t1
                    WHERE id = '{$_SESSION['PRACTICEID']}' 
                    AND t1.client_name = '".$cliName."'";

        $fetchResult = mysql_query($qrySel);
        $rowData = mysql_fetch_assoc($fetchResult);

        if($rowData) $client_id = $rowData['client_id'];
        else
        {
            // client_code
            $qryIns = "INSERT INTO client(client_type_id, client_name, recieved_authority, id, client_received)
                    VALUES (7, '" . addslashes($cliName) . "', 1, " . $_SESSION['PRACTICEID'] . ", '".date('Y-m-d')."')";

            $flagReturn = mysql_query($qryIns);
            $client_id = mysql_insert_id();

            generateClientCode($client_id,$cliName);
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
    
    function insertJobDetail()
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
}

?>
