<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shareholder_details_class
 *
 * @author siddheshc
 */

class SHAREHOLDER_DETAILS 
{    
    //put your code here
    public function fetchShrhldrDtls()
    {
        $qry = "SELECT * FROM stp_sharehldr_dtls WHERE job_id = ".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($qry);
        
        $arrData = array();
        while($rowData = mysql_fetch_assoc($fetchResult)) {
        $arrData[$rowData['shrhldr_id']] = $rowData;
        }

        return $arrData;
    }
    
    public function fetchShareClass()
    {
        $qryFetch = "SELECT * FROM stp_share_class";	
        $fetchResult = mysql_query($qryFetch);
        while($rowData = mysql_fetch_assoc($fetchResult)) 
        {
            $arrShrCls[$rowData['shrclass_id']] = $rowData['shr_desc'];
        }
        return $arrShrCls;
    }
    
    public function insertShrhldrDtls($shrhldr)
    {
       print $qry = "INSERT INTO stp_sharehldr_dtls (job_id, no_of_shrhldr, shrhldr_type, shrhldr_cmpny_name, shrhldr_acn, shrhldr_reg_addr, no_of_directrs,
                                                directrs_name, shrhldr_fname, shrhldr_mname, shrhldr_lname, res_addr_unit, res_addr_build, res_addr_street,
                                                res_addr_subrb, res_addr_state, res_addr_pcode, share_class,is_shars_own_bhlf, shars_own_bhlf, no_of_shares) 
                                                VALUES(
                                                '".$_SESSION['jobId']."',
                                                '".$shrhldr['no_of_shrhldr']."',
                                                '".$shrhldr['shrhldr_type']."',
                                                '".$shrhldr['shrhldr_cmpny_name']."',
                                                '".$shrhldr['shrhldr_acn']."',
                                                '".$shrhldr['shrhldr_reg_addr']."',
                                                '".$shrhldr['no_of_directrs']."', 
                                                '".$shrhldr['directrs_name']."',
                                                '".$shrhldr['shrhldr_fname']."', 
                                                '".$shrhldr['shrhldr_mname']."', 
                                                '".$shrhldr['shrhldr_lname']."', 
                                                '".$shrhldr['res_addr_unit']."', 
                                                '".$shrhldr['res_addr_build']."',
                                                '".$shrhldr['res_addr_street']."', 
                                                '".$shrhldr['res_addr_subrb']."', 
                                                '".$shrhldr['res_addr_state']."', 
                                                '".$shrhldr['res_addr_pcode']."', 
                                                '".$shrhldr['share_class']."',
                                                '".$shrhldr['is_shars_own_bhlf']."', 
                                                '".$shrhldr['shars_own_bhlf']."', 
                                                '".$shrhldr['no_of_shares']."')";
        
        //$result = mysql_query($qry);        
        return $result;
    }
    
    public function updateShrhldrDtls($shrhldr)
    {
        print $qry = "UPDATE stp_sharehldr_dtls SET
                                            no_of_shrhldr = '".$shrhldr['no_of_shrhldr']."',
                                            shrhldr_type = '".$shrhldr['shrhldr_type']."',
                                            shrhldr_cmpny_name = '".$shrhldr['shrhldr_cmpny_name']."',
                                            shrhldr_acn = '".$shrhldr['shrhldr_acn']."',
                                            shrhldr_reg_addr = '".$shrhldr['shrhldr_reg_addr']."',
                                            no_of_directrs = '".$shrhldr['no_of_directrs']."', 
                                            directrs_name = '".$shrhldr['directrs_name']."',
                                            shrhldr_fname = '".$shrhldr['shrhldr_fname']."', 
                                            shrhldr_mname = '".$shrhldr['shrhldr_mname']."', 
                                            shrhldr_lname = '".$shrhldr['shrhldr_lname']."', 
                                            res_addr_unit = '".$shrhldr['res_addr_unit']."', 
                                            res_addr_build = '".$shrhldr['res_addr_build']."',
                                            res_addr_street = '".$shrhldr['res_addr_street']."', 
                                            res_addr_subrb = '".$shrhldr['res_addr_subrb']."', 
                                            res_addr_state = '".$shrhldr['res_addr_state']."', 
                                            res_addr_pcode = '".$shrhldr['res_addr_pcode']."', 
                                            share_class = '".$shrhldr['share_class']."',
                                            is_shars_own_bhlf = '".$shrhldr['is_shars_own_bhlf']."', 
                                            shars_own_bhlf = '".$shrhldr['shars_own_bhlf']."', 
                                            no_of_shares = '".$shrhldr['no_of_shares']."'
                                            WHERE shrhldr_id = ".$shrhldr['shrhldr_id'];
        
        //$result = mysql_query($qry);        
        return $result;
        
    }
    
}

?>
