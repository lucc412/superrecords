<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jobs_rights_class
 *
 * @author siddheshc
 */
class jobs_rights_class extends Database
{
    //put your code here
    
    public function showFeature($frmcode)
    {
        $qry = "SELECT * FROM stf_display_features WHERE stf_FCode = '".$frmcode."'";
        $res = mysql_query($qry);

        $arrData='';
        while($data = mysql_fetch_assoc($res))
        {
            $arrData[$data['disp_id']] = $data; 
        }
        
        return $arrData;
    }
    
    public function checkFeature()
    {
        $qry = "SELECT * FROM stf_staff_features WHERE stf_SCode = '".$_REQUEST['xstaffcode']."'";
        $res = mysql_query($qry);

        $arrData='';
        while($data = mysql_fetch_assoc($res))
        {
            $arrData[$data['disp_id']] = $data['stf_visibility']; 
        }
        
        return $arrData;
    }
    
    public function checklistFeature()
    {
        $qry = "SELECT df.*, sf.stf_visibility, IF(sf.stf_visibility,1,0) chcklstStatus
					FROM stf_display_features df
					LEFT JOIN stf_staff_features sf ON df.disp_id = sf.disp_id AND sf.stf_SCode = '".$_REQUEST['xstaffcode']."'
                                        ORDER BY df.disp_id ASC";
        
        $res = mysql_query($qry);

        $arrData='';
        while($data = mysql_fetch_assoc($res))
        {
            $arrData[$data['disp_id']] = $data; 
        }
        
        return $arrData;
    }
    
    public function removeJobRights($data,$disp_id)
    {
        $qry = "DELETE FROM stf_staff_features WHERE stf_SCode = '".$data['xstaffcode']."' 
                                                     AND disp_id IN ({$disp_id})";
                                                     //exit;
        $res = mysql_query($qry);
        //$data = mysql_fetch_assoc($res);
        return $data;
    }
    
    public function insertJobRights($data,$disp_id)
    {
        foreach ($disp_id as $key => $visibility)
        {
            $strAppend .= "(".$data['xstaffcode'].",".$key.",'".$visibility."'),";
        }
        $strAppend = rtrim($strAppend, ",");
        
        $qry = "INSERT INTO stf_staff_features(stf_SCode, disp_id, stf_visibility) 
                                            VALUES{$strAppend}";
        
        $res = mysql_query($qry);
        //$data = mysql_fetch_assoc($res);
        
        return $res;
    }
}

?>
