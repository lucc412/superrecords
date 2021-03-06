<?php

class Client_Class extends Database {

    public function __construct() {
        $this->arrTypes = $this->fetchType();
        $this->arrStepsList = $this->fetchStepsList();
        $this->arrPractice = $this->fetchPractice();
        $this->arrTeamMember = $this->fetchTeamMember();
        $this->arrSrAccntComp = $this->fetchSrAccntComp();
        $this->arrSrAccntAudit = $this->fetchSrAccntAudit();
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

    public function fetchPractice() 
    {
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
    
    public function fetchSrAccntComp()
    {
        
        $qrySel = "SELECT stf_Code, c1.con_Firstname, c1.con_Lastname 
					FROM stf_staff t1, aty_accesstype t2, con_contact c1
					WHERE t1.stf_AccessType = t2.aty_Code 
					AND t1.stf_CCode = c1.con_Code 
					AND t2.aty_Description like 'Staff'
					AND c1.con_Designation = '27'
					ORDER BY c1.con_Firstname";

        $fetchResult = mysql_query($qrySel);
        while ($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrEmployees[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
        }
        return $arrEmployees;
    }
    
    public function fetchSrAccntAudit()
    {
        
        $qrySel = "SELECT stf_Code, c1.con_Firstname, c1.con_Lastname 
					FROM stf_staff t1, aty_accesstype t2, con_contact c1
					WHERE t1.stf_AccessType = t2.aty_Code 
					AND t1.stf_CCode = c1.con_Code 
					AND t2.aty_Description like 'Staff'
					AND c1.con_Designation = '33'
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
        global $order;
        global $ordertype;
        
        
        if ($_SESSION["usertype"] == "Staff") {
            $staffId = $_SESSION["staffcode"];
            $strWhere = "AND (pr.sr_manager=" . $staffId . " 
						OR pr.india_manager=" . $staffId . " 
						OR cl.team_member=" . $staffId . " 
                                                OR pr.audit_manager=" . $staffId . " 
                                                OR cl.sr_accnt_comp=" . $staffId . "
                                                OR cl.sr_accnt_audit=" . $staffId . "
						OR pr.sales_person=" . $staffId . ")";
        }

        if (isset($mode) && (($mode == 'view') || ($mode == 'edit'))) {

            $qrySel = "SELECT cl.*, pr.sr_manager, pr.india_manager, cl.team_member, pr.sales_person, pr.audit_manager 
					FROM client cl, pr_practice pr
					WHERE pr.id = cl.id AND cl.client_id = " . $recId . "
					ORDER BY cl.client_id DESC";
        } else {

            $filterstr = $commonUses->sqlstr($filter);
            if(strstr($filterstr, "/"))$filterstr = $commonUses->getDateFormat($filterstr)." 00:00:00";
            if (!$wholeonly && isset($wholeonly) && $filterstr != '')
            {
                $filterstr = "%" . $filterstr . "%"; $operator = ' LIKE ';
            }
            else
                $operator = ' = ';

            $qrySel = "SELECT cl.*, s.*, cnt.*, pr.sr_manager, pr.india_manager, pr.audit_manager, cl.team_member, pr.sales_person 
							FROM client cl, pr_practice pr, client_type clt, stf_staff s, con_contact cnt
							WHERE cl.id = pr.id and cl.client_type_id  = clt.client_type_id
							AND pr.sr_manager = s.stf_Code 
							AND s.stf_CCode = cnt.con_Code 
							{$strWhere}";


            if (isset($filterstr) && $filterstr != '' && isset($filterfield) && $filterfield != '') 
            {

                if ($commonUses->sqlstr($filterfield) == 'sr_manager') {
                    $qrySel .= "AND (cnt.con_Firstname LIKE '" . $filterstr . "' OR cnt.con_Middlename LIKE '" . $filterstr . "' OR cnt.con_Lastname LIKE '" . $filterstr . "')";
                } else {
                    $qrySel .= " AND " . $commonUses->sqlstr($filterfield) . $operator."'" . $filterstr . "'";
                }
                
            } 
            elseif (isset($filterstr) && $filterstr != '') {

                $qrySel .= " AND (cl.client_name LIKE '" . $filterstr . "' 
                                        OR cl.client_code LIKE '" . $filterstr . "'
					OR pr.name LIKE '" . $filterstr . "'
					OR clt.client_type LIKE '" . $filterstr . "'
					OR cnt.con_Firstname LIKE '" . $filterstr . "' OR cnt.con_Middlename LIKE '" . $filterstr . "' OR cnt.con_Lastname LIKE '" . $filterstr . "'
					OR cl.client_received LIKE '" . $filterstr . "')";
            }

            $qrySel .= " ORDER BY {$order} {$ordertype}";
            
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

        $qryIns = "INSERT INTO client(client_type_id, client_name, id, team_member, client_notes, client_received, sr_accnt_comp, sr_accnt_audit)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . addslashes($_REQUEST['cliName']) . "',
					'" . $_REQUEST['lstPractice'] . "',
					'" . $_REQUEST['lstTeamMember'] . "',
					'" . addslashes($_REQUEST['client_notes']) . "',
					'" . $dateSignedUp . "',  
                                        '" . addslashes($_REQUEST['lstSrAccntComp']) . "',
                                        '" . addslashes($_REQUEST['lstSrAccntAudit']) . "'
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
        $clientName = preg_replace('/[^a-zA-Z0-9]/', '_', $_REQUEST['cliName']);
        $arrCliName = explode("_", $clientName);

        $cntNameWords = count($arrCliName);
        $intCounter = 0;
        $cliCode = "";
        
        While ($intCounter < $cntNameWords) {
            
            $wordLgth=0;
            $word = $arrCliName[$intCounter];
            $wordLgth = strlen($arrCliName[$intCounter]);
            
            if($cntNameWords == 1){
                
                if(strlen($cliCode) < 5){
                
                    if($wordLgth >= 5) {
                        $cliCode .= substr($word, 0, 5);
                    } else {
                        $cliCode .= substr($word, 0, $wordLgth);
                    }
                }    
                
            }else{
                
                if(strlen($cliCode) < 5 && ($word != '')){
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
                else{
                   
                }
            }
          
            $intCounter++;
            if($intCounter == $cntNameWords)
            {
                if(strlen($cliCode) < 5)
                    $cliCode = str_pad($cliCode, 5, "0",STR_PAD_LEFT);
            }
            
            // check if client code is unique or not 
            if (strlen($cliCode) == 5) {
                $flagCodeExists = $this->checkClientCodeUnique($pracCode.$cliCode);
               
                if(!$flagCodeExists)
                {
                    break;
                }
                else
                {
                    
                    $strName = str_replace(' ', '', $_REQUEST['cliName']);
                    $seed = str_split($strName);
                    shuffle($seed);
                    $cliCode = '';
                    foreach (array_rand($seed, 5) as $k) $cliCode .= $seed[$k];
                    break;
                }
            }
            else{
                $word = "";
                $wordLgth = 0;
            }
            
        }
        if($pracCode != '' && $cliCode != '')
        {
            $qryUpd = "UPDATE client SET client_code = '" . strtoupper($pracCode.$cliCode) . "' WHERE client_id ='" . $newClientId . "'";
            mysql_query($qryUpd);
        }
     
		return $newClientId;
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
							sr_accnt_comp = '" . addslashes($_REQUEST['lstSrAccntComp']) . "',
							sr_accnt_audit = '" . addslashes($_REQUEST['lstSrAccntAudit']) . "'
						WHERE client_id = '" . $_REQUEST['recid'] . "'";

                mysql_query($qryUpd);
            } else {
                header("location: cli_client.php?a=edit&recid=" . $_REQUEST['recid'] . "&cli_code=" . $_REQUEST['cliCode'] . "&flagError=Y");
            }
        } 
		else {
            $qryUpd = "UPDATE client
						SET client_type_id = '" . $_REQUEST['lstType'] . "',
							client_name = '" . addslashes($_REQUEST['cliName']) . "',
							id = '" . $_REQUEST['lstPractice'] . "',
							team_member = '" . $_REQUEST['lstTeamMember'] . "',
							sr_accnt_comp = '" . addslashes($_REQUEST['lstSrAccntComp']) . "',
                            sr_accnt_audit = '" . addslashes($_REQUEST['lstSrAccntAudit']) . "',
							client_notes = '" . addslashes($_REQUEST['client_notes']) . "',
							client_received = '" . $dateSignedUp . "'
						WHERE client_id = '" . $_REQUEST['recid'] . "'";

            mysql_query($qryUpd);
        }
    }

    function sql_delete($recid) {

        $qryDel = "DELETE FROM client where client_id = '" . $recid . "' ";
        mysql_query($qryDel);
    }

	function fetchManager($clientId, $colManager) {

		$qryDel = "SELECT {$colManager} FROM client WHERE client_id = {$clientId}";
		$fetchResult = mysql_query($qryDel);
		$rowData = mysql_fetch_row($fetchResult);
		$cliManager = $rowData[0];

		return $cliManager;
	}

	// Function to fetch practice id
	public function fetchPracticeInfo($clientId)
	{
		$qrySel = "SELECT pr.id practiceId, pr.sr_manager srManager
					FROM client cl, pr_practice pr
					WHERE cl.id = pr.id
					AND cl.client_id = {$clientId}";

		$fetchResult = mysql_query($qrySel);		
		$arrPracInfo = mysql_fetch_row($fetchResult);
		return $arrPracInfo;
	} 

}

?>