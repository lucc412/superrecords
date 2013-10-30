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
class OFFICER_DETAILS 
{
    //put your code here
    
    public function fetchOffcrDtls($offcr)
    {
        $qry = "SELECT * FROM stp_offcr_dtls WHERE job_id = ".$_SESSION['jobId'];
        
//        $fetchResult = mysql_query($qry);
//        
//        $arrData = array();
//        while($rowData = mysql_fetch_assoc($fetchResult)) {
//                $arrData[$rowData['offcr_id']] = $rowData;
//        }

         $fetchResult = mysql_query($qry);
		$count = 1;

		$arrData = array();
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrData[$count++] = $rowData;
		}

        
        return $arrData;
    }
    
    public function delOffcrDtls($offcr_id)
    {
        $qryDel = "DELETE FROM stp_offcr_dtls WHERE offcr_id =". $offcr_id;
        mysql_query($qryDel);
    }
    
    public function insertOffcrDtls($offcr)
    {
        $qry = "INSERT INTO stp_offcr_dtls (job_id, no_of_offcr, offcr_fname, offcr_mname, offcr_lname, offcr_dob, offcr_city_birth, offcr_state_birth,
            offcr_cntry_birth, offcr_tfn, offcr_addr_unit, offcr_addr_build, offcr_addr_street, offcr_addr_subrb, offcr_addr_state, offcr_addr_pst_code)
            VALUES ('".$_SESSION['jobId']."',
                    '".$offcr['selOfficers']."',
                    '".$offcr['txtFname']."',
                    '".$offcr['txtMname']."',
                    '".$offcr['txtLname']."',
                    '".$offcr['txtDob']."', 
                    '".$offcr['txtCob']."', 
                    '".$offcr['selSob']."',
                    '".$offcr['selCntryob']."',
                    '".$offcr['txtTFN']."',
                    '".$offcr['offAddUnit']."',
                    '".$offcr['offAddBuild']."',
                    '".$offcr['offAddStreet']."',
                    '".$offcr['offAddSubrb']."',
                    '".$offcr['offAddState']."',
                    '".$offcr['offAddPstCode']."'                    
                    )";
        
        $result = mysql_query($qry);
        
        return $result;
    }
    
    public function updateOffcrDtls($offcr)
    {
        
        $qry = "UPDATE stp_offcr_dtls SET job_id = '".$_SESSION['jobId']."', 
                                                no_of_offcr = '".$offcr['selOfficers']."', 
                                                offcr_fname = '".$offcr['txtFname']."', 
                                                offcr_mname = '".$offcr['txtMname']."', 
                                                offcr_lname = '".$offcr['txtLname']."', 
                                                offcr_dob = '".$offcr['txtDob']."', 
                                                offcr_city_birth = '".$offcr['txtCob']."', 
                                                offcr_state_birth = '".$offcr['selSob']."',                                                
                                                offcr_cntry_birth = '".$offcr['selCntryob']."',  
                                                offcr_tfn = '".$offcr['txtTFN']."', 
                                                offcr_addr_unit = '".$offcr['offAddUnit']."', 
                                                offcr_addr_build = '".$offcr['offAddBuild']."', 
                                                offcr_addr_street = '".$offcr['offAddStreet']."', 
                                                offcr_addr_subrb = '".$offcr['offAddSubrb']."', 
                                                offcr_addr_state = '".$offcr['offAddState']."', 
                                                offcr_addr_pst_code = '".$offcr['offAddPstCode']."'         
                                                WHERE offcr_id = ".$offcr['offcrId'];
        
        $result = mysql_query($qry);
        return $result;
    }
    
}

?>
