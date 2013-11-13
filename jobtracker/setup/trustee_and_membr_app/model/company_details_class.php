<?php

class COMPANY_DETAILS 
{
    
    // insert fund details
    function insertCompDtls() 
    {
        
        if($_REQUEST['selNoDirtr'] > 0)    
            $directrs_name = implode(',',$_REQUEST['txtDirctrName']);
        else
            $directrs_name = $_REQUEST['txtDirctrName'];
        
        $qryIns = "INSERT INTO ctm_comp_dtls(job_id, comp_name, acn, reg_addr, no_of_directors, directors_name)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($_REQUEST['txtCmpName'])."', 
                    '".addslashes($_REQUEST['txtACN'])."', 
                    '".addslashes($_REQUEST['txtRegAddr'])."', 
                    '".addslashes($_REQUEST['selNoDirtr'])."', 
                    '".addslashes($directrs_name)."'
                    )";
        
        mysql_query($qryIns);
    }
    
    // update fund details
    function updateCompDtls() 
    {
        if($_REQUEST['selNoDirtr'] > 0)    
            $directrs_name = implode(',',$_REQUEST['txtDirctrName']);
        else
            $directrs_name = $_REQUEST['txtDirctrName'];
        
        $qryUpd = "UPDATE ctm_comp_dtls
                    SET comp_name = '".addslashes($_REQUEST['txtCmpName'])."',
                        acn = '".addslashes($_REQUEST['txtACN'])."',
                        reg_addr = '".addslashes($_REQUEST['txtRegAddr'])."',
                        no_of_directors = '".addslashes($_REQUEST['selNoDirtr'])."',
                        directors_name = '".addslashes($directrs_name)."'
                    WHERE job_id = ".$_SESSION['jobId'];
      
        mysql_query($qryUpd);
    }
    
    // fetch holding trust details
    public function fetchCompDetails()
    {
        $selQry="SELECT * FROM ctm_comp_dtls WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrData = mysql_fetch_assoc($fetchResult);
            
        return $arrData;
    }
    
}

?>