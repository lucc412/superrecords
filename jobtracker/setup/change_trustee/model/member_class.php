<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of address_details_class
 *
 * @author disha
 */
class MEMBER 
{
    //put your code here
    
    public function fetchOffcrDtls($offcr)
    {
        $qry = "SELECT * FROM cot_member_details WHERE job_id = ".$_SESSION['jobId'];

        $fetchResult = mysql_query($qry);
        $count = 1;

        $arrData = array();
        while($rowData = mysql_fetch_assoc($fetchResult)) {
                $arrData[$count++] = $rowData;
        }

        
        return $arrData;
    }
    
    public function delMemberDtls($member_id)
    {
        $qryDel = "DELETE FROM cot_member_details WHERE member_id =". $member_id;
        mysql_query($qryDel);
    }
    
    public function insertMemberDtls($offcr)
    {
        $qry = "INSERT INTO cot_member_details (job_id, no_of_member, fname, mname, lname, dob, city_birth, cntry_birth, tfn, res_add)
            VALUES ('".$_SESSION['jobId']."',
                    '".$offcr['selOfficers']."',
                    '".$offcr['txtFname']."',
                    '".$offcr['txtMname']."',
                    '".$offcr['txtLname']."',
                    '".$offcr['txtDob']."', 
                    '".$offcr['txtCob']."', 
                    '".$offcr['selCntryob']."',
                    '".$offcr['txtTFN']."',
                    '".$offcr['resAdd']."'                    
                    )";
        
        $result = mysql_query($qry);
        
        return $result;
    }
    
    public function updateOffcrDtls($offcr)
    {
        
        $qry = "UPDATE cot_member_details 
                SET no_of_member = '".$offcr['selOfficers']."', 
                fname = '".$offcr['txtFname']."', 
                mname = '".$offcr['txtMname']."', 
                lname = '".$offcr['txtLname']."', 
                dob = '".$offcr['txtDob']."', 
                city_birth = '".$offcr['txtCob']."',                                                
                cntry_birth = '".$offcr['selCntryob']."',  
                tfn = '".$offcr['txtTFN']."', 
                res_add = '".$offcr['resAdd']."'         
                WHERE member_id = ".$offcr['offcrId'];
        
        $result = mysql_query($qry);
        return $result;
    }
    
}

?>
