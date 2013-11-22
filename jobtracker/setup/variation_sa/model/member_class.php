<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MEMBER 
{
    // fetch holding trust type
    public function fetchTrustType()
    {
       $selQry="SELECT trustee_id
                FROM vsa_holding_trust
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $rowInfo = mysql_fetch_assoc($fetchResult);
        $trusteeType = $rowInfo['trustee_id'];
            
        return $trusteeType;
    }
    
    public function fetchMemberDtls($member)
    {
        $qry = "SELECT * FROM vsa_member_details WHERE job_id = ".$_SESSION['jobId'];

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
        $qryDel = "DELETE FROM vsa_member_details WHERE member_id =". $member_id;
        mysql_query($qryDel);
    }
    
    public function insertMemberDtls($member)
    {
        $qry = "INSERT INTO vsa_member_details (job_id, no_of_member, fname, mname, lname, dob, city_birth, cntry_birth, tfn, res_add)
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
        
        $qry = "UPDATE vsa_member_details 
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
