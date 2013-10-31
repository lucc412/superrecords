<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of address_details_class
 *
 * @author siddheshc
 */
class ADDRESS_DETAILS 
{
    
    public function fetchAddrDtls()
    {
        $qry = "SELECT * FROM spc_adddress_dtls WHERE job_id = ".$_SESSION['jobId'];
        $fetchResult = mysql_query($qry);
        $rowData = mysql_fetch_assoc($fetchResult);
                
        return $rowData;
    } 
    
    //put your code here
    public function insertAddrDtls()
    {
        $qry = "INSERT INTO spc_adddress_dtls (job_id, reg_add_unit, reg_add_build, reg_add_street, reg_add_subrb,
                                               reg_add_state, reg_add_pst_code, is_comp_addr, occp_name, bsns_add_unit,
                                               bsns_add_build, bsns_add_street, bsns_add_subrb, bsns_add_state, bsns_add_pst_code,
                                               met_add_unit, met_add_build, met_add_street, met_add_subrb, met_add_state, met_add_pst_code)
                                        VALUES(".$_SESSION['jobId'].",
                                               '".$_REQUEST['regAddUnit']."',
                                               '".$_REQUEST['regAddBuild']."',
                                               '".$_REQUEST['regAddStreet']."',
                                               '".$_REQUEST['regAddSubrb']."',
                                               '".$_REQUEST['regAddState']."',
                                               '".$_REQUEST['regAddPstCode']."',
                                               '".$_REQUEST['selCompAddr']."',
                                               '".$_REQUEST['txtOccpName']."',
                                               '".$_REQUEST['busAddUnit']."',
                                               '".$_REQUEST['busAddBuild']."',
                                               '".$_REQUEST['busAddStreet']."',
                                               '".$_REQUEST['busAddSubrb']."',
                                               '".$_REQUEST['busAddState']."',
                                               '".$_REQUEST['busAddPstCode']."',
                                               '".$_REQUEST['metAddUnit']."',
                                               '".$_REQUEST['metAddBuild']."',
                                               '".$_REQUEST['metAddStreet']."',
                                               '".$_REQUEST['metAddSubrb']."',
                                               '".$_REQUEST['metAddState']."',
                                               '".$_REQUEST['metAddPstCode']."'
                                              )";
        
        $result = mysql_query($qry);
        
        return $result;
    }
    
    public function updateAddrDtls()
    {
        $qry = "UPDATE spc_adddress_dtls  SET reg_add_unit = '".$_REQUEST['regAddUnit']."', 
                                            reg_add_build = '".$_REQUEST['regAddBuild']."', 
                                            reg_add_street = '".$_REQUEST['regAddStreet']."',
                                            reg_add_subrb = '".$_REQUEST['regAddSubrb']."',
                                            reg_add_state = '".$_REQUEST['regAddState']."',
                                            reg_add_pst_code = '".$_REQUEST['regAddPstCode']."', 
                                            is_comp_addr = '".$_REQUEST['selCompAddr']."', 
                                            occp_name = '".$_REQUEST['txtOccpName']."', 
                                            bsns_add_unit = '".$_REQUEST['busAddUnit']."',
                                            bsns_add_build = '".$_REQUEST['busAddBuild']."', 
                                            bsns_add_street = '".$_REQUEST['busAddStreet']."', 
                                            bsns_add_subrb = '".$_REQUEST['busAddSubrb']."', 
                                            bsns_add_state = '".$_REQUEST['busAddState']."', 
                                            bsns_add_pst_code = '".$_REQUEST['busAddPstCode']."',
                                            met_add_unit = '".$_REQUEST['metAddUnit']."',
                                            met_add_build = '".$_REQUEST['metAddBuild']."',
                                            met_add_street = '".$_REQUEST['metAddStreet']."', 
                                            met_add_subrb = '".$_REQUEST['metAddSubrb']."', 
                                            met_add_state = '".$_REQUEST['metAddState']."', 
                                            met_add_pst_code = '".$_REQUEST['metAddPstCode']."'
                                        WHERE job_id = ".$_SESSION['jobId'];
        
        $result = mysql_query($qry);        
        return $result;
    }
    
}

?>
