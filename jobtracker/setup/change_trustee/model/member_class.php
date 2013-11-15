<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of member_class
 *
 * @author disha
 */
class MEMBER 
{
    //put your code here
    
    public function fetchMemberDtls($member)
    {
        $qry = "SELECT job_id, no_of_member, fname, mname, lname, DATE_FORMAT(dob, '%d/%m/%Y') dob, city_birth, cntry_birth, tfn, res_add FROM cot_member_details WHERE job_id = ".$_SESSION['jobId'];

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
    
    public function insertMemberDtls($member)
    {
        $qry = "INSERT INTO cot_member_details (job_id, no_of_member, fname, mname, lname, dob, city_birth, cntry_birth, tfn, res_add)
            VALUES ('".$_SESSION['jobId']."',
                    '".$member['selMembers']."',
                    '".$member['txtFname']."',
                    '".$member['txtMname']."',
                    '".$member['txtLname']."',
                    '".$member['txtDob']."', 
                    '".$member['txtCob']."', 
                    '".$member['selCntryob']."',
                    '".$member['txtTFN']."',
                    '".$member['resAdd']."'                    
                    )";
        
        $result = mysql_query($qry);
        
        return $result;
    }
    
    public function updateMemberDtls($member)
    {
        
        $qry = "UPDATE cot_member_details 
                SET no_of_member = '".$member['selMembers']."', 
                fname = '".$member['txtFname']."', 
                mname = '".$member['txtMname']."', 
                lname = '".$member['txtLname']."', 
                dob = '".$member['txtDob']."', 
                city_birth = '".$member['txtCob']."',                                                
                cntry_birth = '".$member['selCntryob']."',  
                tfn = '".$member['txtTFN']."', 
                res_add = '".$member['resAdd']."'         
                WHERE member_id = ".$member['offcrId'];
        
        $result = mysql_query($qry);
        return $result;
    }
    
}

?>
