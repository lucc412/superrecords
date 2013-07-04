<?php

class Practice_Class extends Database {

    public function __construct() {
        $this->arrTypes = $this->fetchType();
        $this->arrStepsList = $this->fetchStepsList();
        $this->arrPractice = $this->fetchPractice();
        $this->arrTeamMember = $this->fetchTeamMember();
    }

    public function fetchType() {

        $qrySel = "SELECT ct.client_type_id, ct.client_type 
					FROM client_type ct
					ORDER BY ct.order";

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrTypes[$rowData['client_type_id']] = $rowData['client_type'];
        }
        return $arrTypes;
    }

    public function fetchPractice() {

        $qrySel = "SELECT ct.id, ct.name 
					FROM pr_practice ct 
					ORDER BY ct.name";

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrPractice[$rowData['id']] = $rowData['name'];
        }
        return $arrPractice;
    }

    public function fetchStepsList() {

        $qrySel = "SELECT cs.id, cs.description
					FROM cli_steps cs
					ORDER BY cs.order";

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrItemList[$rowData['id']] = $rowData['description'];
        }
        return $arrItemList;
    }

    public function fetchTeamMember() {

        $qrySel = "SELECT stf_Code, c1.con_Firstname, c1.con_Lastname 
					FROM stf_staff t1, aty_accesstype t2, con_contact c1
					WHERE t1.stf_AccessType = t2.aty_Code 
					AND t1.stf_CCode = c1.con_Code 
					AND t2.aty_Description like 'Staff'
					AND c1.con_Designation = '29'
					ORDER BY c1.con_Firstname";

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrEmployees[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
        }
        return $arrEmployees;
    }

    public function fetchEmployees() {

        $qrySel = "SELECT ss.stf_Code, CONCAT_WS(' ', cc.con_Firstname, cc.con_Lastname) staffName 
					 FROM stf_staff ss, con_contact cc
					 WHERE ss.stf_CCode = cc.con_Code ";

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrEmployees[$rowData['stf_Code']] = $rowData['staffName'];
        }
        return $arrEmployees;
    }

    public function sql_select($mode = '', $recId = '') {

        global $filter;
        global $filterfield;
        global $wholeonly;
        global $commonUses;

        if ($_SESSION["usertype"] == "Staff") {
            $staffId = $_SESSION["staffcode"];
            $strWhere = "AND (pr.sr_manager=" . $staffId . " 
						OR pr.india_manager=" . $staffId . " 
						OR cl.team_member=" . $staffId . " 
						OR pr.sales_person=" . $staffId . ")";
        }

        if (isset($mode) && (($mode == 'view') || ($mode == 'edit'))) {

            $qrySel = "SELECT cl.*, pr.sr_manager, pr.india_manager, cl.team_member, pr.sales_person 
					FROM client cl, pr_practice pr
					WHERE pr.id = cl.id AND cl.client_id = " . $recId . "
					ORDER BY cl.client_id DESC";
        } else {

            $filterstr = $commonUses->sqlstr($filter);

            if (!$wholeonly && isset($wholeonly) && $filterstr != '')
                $filterstr = "%" . $filterstr . "%";

            $qrySel = "SELECT cl.*, s.*, cnt.*, pr.sr_manager, pr.india_manager, cl.team_member, pr.sales_person 
							FROM client cl, pr_practice pr, client_type clt, stf_staff s, con_contact cnt
							WHERE cl.id = pr.id and cl.client_type_id  = clt.client_type_id
							AND pr.sr_manager = s.stf_Code 
							AND s.stf_CCode = cnt.con_Code 
							{$strWhere}";


            if (isset($filterstr) && $filterstr != '' && isset($filterfield) && $filterfield != '') {

                if ($commonUses->sqlstr($filterfield) == 'sr_manager') {
                    $qrySel .= "AND (cnt.con_Firstname like '" . $filterstr . "' OR cnt.con_Middlename like '" . $filterstr . "' OR cnt.con_Lastname like '" . $filterstr . "')";
                } else {
                    $qrySel .= " AND " . $commonUses->sqlstr($filterfield) . " like '" . $filterstr . "'";
                }
            } elseif (isset($filterstr) && $filterstr != '') {

                $qrySel .= " AND (cl.client_name like '" . $filterstr . "' 
					OR pr.name like '" . $filterstr . "'
					OR clt.client_type like '" . $filterstr . "'
					OR cnt.con_Firstname like '" . $filterstr . "' OR cnt.con_Middlename like '" . $filterstr . "' OR cnt.con_Lastname like '" . $filterstr . "'
					OR cl.client_received like '" . $filterstr . "')";
            }

            $qrySel .= " ORDER BY cl.client_id DESC";
        }

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrClients[$rowData['client_id']] = $rowData;
        }
        return $arrClients;
    }

    public function sql_insert() {

        global $commonUses;

        foreach ($_REQUEST AS $fieldName => $fieldValue) {
            if (strstr($fieldName, "step:")) {
                $fieldId = str_replace('step:', '', $fieldName);
                $arrSteps[] = $fieldId;
            }
        }

        $strSteps = '';
        if (!empty($arrSteps))
            $strSteps = implode(',', $arrSteps);

        $dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

        $qryIns = "INSERT INTO client(client_type_id, client_name, id, team_member, client_notes, client_received, steps_done)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . addslashes($_REQUEST['cliName']) . "',
					'" . $_REQUEST['lstPractice'] . "',
					'" . $_REQUEST['lstTeamMember'] . "',
					'" . addslashes($_REQUEST['client_notes']) . "',
					'" . $dateSignedUp . "',  
					'" . $strSteps . "'
					)";

        mysql_query($qryIns);
        $newClientId = mysql_insert_id();
        
        /* update client code in client table */

        // fetch practice code for respective client
        $qrySel = "SELECT pr_code FROM pr_practice WHERE id = '" . $_REQUEST['lstPractice'] . "'";
        $resultObj = mysql_query($qrySel);
        $arrInfo = mysql_fetch_assoc($resultObj);
        $pracCode = $arrInfo['pr_code'];

        // build client code
        $clientName = preg_replace('/[^a-zA-Z1-2]/', '_', $_REQUEST['cliName']);
        $arrCliName = explode("_", $clientName);

        $cntNameWords = count($arrCliName);
        $intCounter = 0;
        $cliCode = "";
        
        While ($intCounter < $cntNameWords) {
            
            $wordLgth=0;
            $word = $arrCliName[$intCounter];
            $wordLgth = strlen($arrCliName[$intCounter]);
            
            if($cntNameWords == 1){
                
                if($cliCode < 5){
                
                    if($wordLgth >= 5) {
                        if(strlen($cliCode) == 0)
                        {
                            $cliCode .= substr($word, 0, 5);
                        }
                    } else {
                        $l = 5 - $wordLgth;
                        $cliCode .= substr($word, 0, $wordLgth);
                    }
                    $intCounter++;
                }    
                
            }else{
                
                if($cliCode < 5){
                
                    if ($wordLgth >= 3) {
                        if(strlen($cliCode) == 0)
                        {
                            $cliCode .= substr($word, 0, 3);
                        }
                        else
                        {
                            $len = 5 - strlen($cliCode);
                            $cliCode .= substr($word, 0, $len);
                        }

                    } else {
                        $cliCode .= substr($word, 0, $wordLgth);
                    }
                    
                }
                $intCounter++;
            }
            
            
            if($intCounter == $cntNameWords)
            {
                if(strlen($cliCode) < 5)
                $cliCode = str_pad($cliCode, 5, "0",STR_PAD_LEFT);
            }
            $cliCodeLen = strlen($cliCode);
            
            // check if client code is unique or not 
            if ($cliCodeLen == 5) {
                $flagCodeExists = $this->checkClientCodeUnique($pracCode.$cliCode);

                if (!$flagCodeExists)
                    break;
            }
//            else{
//                $word = "";
//                $wordLgth = 0;
//            }

        }
        
        // update client code in client table
        $qryUpd = "UPDATE client SET client_code = '" . strtoupper($pracCode.$cliCode) . "' WHERE client_id ='" . $newClientId . "'";
        mysql_query($qryUpd);
        
    }

    // check if client code is unique or not
    public function checkClientCodeUnique($code,$clientId = '') {
        
        if(!empty($clientId))
            $strAppend = "AND client_id <> ".$clientId;
        else
            $strAppend = "" ;
        
        $qrySel = "SELECT client_id FROM client WHERE client_code = '" . $code . "' {$strAppend}";
        $resultObj = mysql_query($qrySel);
        $flagCodeExists = mysql_fetch_assoc($resultObj);

        return $flagCodeExists;
    }

    public function sql_update() {

        global $commonUses;

        foreach ($_REQUEST AS $fieldName => $fieldValue) {
            if (strstr($fieldName, "step:")) {
                $fieldId = str_replace('step:', '', $fieldName);
                $arrSteps[] = $fieldId;
            }
        }

        $strSteps = '';
        if (!empty($arrSteps))
            $strSteps = implode(',', $arrSteps);

        $dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

        if (!empty($_REQUEST['cliCode'])) {

            // check if client code is unique or not
            $flagCodeExists = $this->checkClientCodeUnique($_REQUEST['cliCode'],$_REQUEST['recid']);

            if (!$flagCodeExists) {

                $qryUpd = "UPDATE client
						SET client_type_id = '" . $_REQUEST['lstType'] . "',
							client_code = '" . addslashes($_REQUEST['cliCode']) . "',
							client_name = '" . addslashes($_REQUEST['cliName']) . "',
							id = '" . $_REQUEST['lstPractice'] . "',
							team_member = '" . $_REQUEST['lstTeamMember'] . "',
							client_notes = '" . addslashes($_REQUEST['client_notes']) . "',
							client_received = '" . $dateSignedUp . "',
							steps_done = '" . $strSteps . "'
						WHERE client_id = '" . $_REQUEST['recid'] . "'";

                mysql_query($qryUpd);
            } else {
                header("location: cli_client.php?a=edit&recid=" . $_REQUEST['recid'] . "&cli_code=" . $_REQUEST['cliCode'] . "&flagError=Y");
            }
        } else {
            $qryUpd = "UPDATE client
						SET client_type_id = '" . $_REQUEST['lstType'] . "',
							client_name = '" . addslashes($_REQUEST['cliName']) . "',
							id = '" . $_REQUEST['lstPractice'] . "',
							team_member = '" . $_REQUEST['lstTeamMember'] . "',
							client_notes = '" . addslashes($_REQUEST['client_notes']) . "',
							client_received = '" . $dateSignedUp . "',
							steps_done = '" . $strSteps . "'
						WHERE client_id = '" . $_REQUEST['recid'] . "'";

            mysql_query($qryUpd);
        }
    }

    function sql_delete($recid) {

        $qryDel = "DELETE FROM client where client_id = '" . $recid . "' ";
        mysql_query($qryDel);
    }

}

?>