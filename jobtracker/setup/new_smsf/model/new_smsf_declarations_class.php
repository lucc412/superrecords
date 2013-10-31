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
        
        function generatePDF()
        {
            // process new job
            submitSavedJob();
            
            include("model/setup_preview_class.php");
            $objStpPrvw = new SETUP_PREVIEW();
            
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
            $title1 = $_SESSION['PRACTICENAME'];
            $title2 = returnJobName();

            // Create PDF
            createPDF($html,$filename,$title1,$title2);

        }
}
                    
?>