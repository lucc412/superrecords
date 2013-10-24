<?
class DECLARATIONS
{ 	
	// class constructor
	public function __construct()
	{ 
	
	}
	
	// function to fetch states
	function fetchQuestions()
	{
            $qryFetch = "SELECT * FROM es_declarations";	

            $fetchResult = mysql_query($qryFetch);

            while($rowData = mysql_fetch_assoc($fetchResult))
            {
                    $arrQues[$rowData['question_id']] = $rowData;
            }

            return $arrQues;
	}

        function checkQuestion()
        {
            $qry = "SELECT * FROM es_declarations_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchResult = mysql_query($qry);
            
            $arrData = array();
            if($fetchResult) 
            {
                $arrData = mysql_fetch_assoc($fetchResult);
            }

            return $arrData;
        }
        
        function insertDeclaration() 
        {
            $qry = "INSERT INTO es_declarations_details (job_id, question_id) VALUE(".$_SESSION['jobId'].",'".implode(",", array_keys($_REQUEST['rd']))."')";
            $fetchResult = mysql_query($qry);
        }
        
        function updateDeclaration()
        {
            $qry = "UPDATE es_declarations_details SET question_id = '".implode(",", array_keys($_REQUEST['rd']))."' WHERE job_id = ".$_SESSION['jobId'];
            $fetchResult = mysql_query($qry);
        }
        
        function checkLegalRef()
        {
            $qryFetch = "SELECT * FROM es_member_details WHERE job_id = '" . $_SESSION['jobId'] . "' AND legal_references = 1";
            
            $fetchResult = mysql_query($qryFetch);
            $count = 1;

            $arrData = array();
            while($rowData = mysql_fetch_assoc($fetchResult)) {
                    $arrData[$count++] = $rowData['member_id'];
            }
            
            return $arrData;
        }
        
        public function fetch_job_data($jobId) {
		$qryUpd = "SELECT jb.client_id, jb.mas_Code, jb.job_type_id, CONCAT_WS(' - ', cl.client_name, jb.period, sa.sub_Description)task_name
                            FROM client cl, sub_subactivity sa, job jb
                            WHERE jb.job_id = {$_SESSION['jobId']}
                            AND jb.client_id = cl.client_id
                            AND jb.job_type_id = sa.sub_Code";

		$objResult = mysql_query($qryUpd);
		while($rowInfo = mysql_fetch_assoc($objResult)) {
			$arrJobData = $rowInfo;
		}

		return $arrJobData;
	}
        
        public function add_new_task($practiceId, $jobId) {
		$arrJobData = $this->fetch_job_data($jobId);
	
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code) 
					VALUES ('" . $arrJobData['task_name'] . "',
					'" . $practiceId . "',
					'" . $arrJobData['client_id'] . "',
					'" . $jobId . "',
					'" . $arrJobData['mas_Code'] . "',
					'" . $arrJobData['job_type_id'] . "'
					)";
		mysql_query($qryIns);			
	}
        
        function generatePDF()
        {
            // for adding task
            $stQry = "UPDATE job SET job_submitted = '".$_REQUEST['job_submitted']."', job_received = NOW() WHERE job_id = ".$_SESSION['jobId'];
            $flagReturn = mysql_query($stQry);

            // add new task
            $this->add_new_task($_SESSION['PRACTICEID'], $_SESSION['jobId']);
            
            // send mail for new task
            new_job_task_mail();
            
            include(MODEL . "setup_preview_class.php");
            $objStpPrvw = new SETUP_PREVIEW();
            
            $arrJob = $objStpPrvw->jobDetails();
            $arrClients = $objStpPrvw->clientDetails($arrJob[$_SESSION['jobId']]['client_id']);
            $arrPractice = $objStpPrvw->practiceDetails();
            $arrActivity = $objStpPrvw->jobActivityDetails($arrJob[$_SESSION['jobId']]['job_type_id']);
            
            // Insert into documents table
            $qrySel = "SELECT max(document_id) docId FROM documents";

            $objResult = mysql_query($qrySel);
            $arrInfo = mysql_fetch_assoc($objResult);
            $fileId = $arrInfo['docId'];	
            $fileId++;
            $currentTime = date('Y-m-d H:i:s');

            $filename = $fileId."~setup.pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,file_path) VALUES (".$_SESSION['jobId'].",'setup','".$currentTime."','".$filename."')";
            mysql_query($docQry);
            

            $html = $objStpPrvw->generatePreview();
            $title1 = $arrPractice['name'];
            $title2 = $arrClients['client_name'].' - '.$arrJob[$_SESSION['jobId']]['period'].' - '.$arrActivity['sub_Description'];

            // Create PDF
            createPDF($html,$filename,$title1,$title2);

        }
}
                    
?>