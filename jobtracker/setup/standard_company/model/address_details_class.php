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
    //put your code here
    public function insertAddrDtls()
    {
        $qry = "INSERT INTO stp_adddress_dtls (job_id, reg_add_unit, reg_add_build, reg_add_street, reg_add_subrb,
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
    
}

?>
