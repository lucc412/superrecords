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
        
        function generatePDF()
        {
            $jobid = $_SESSION['jobId'];
            $contQry = "SELECT * FROM es_contact_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchCntact = mysql_query($contQry);
            $arrCntact=array();
            while($rowData = mysql_fetch_assoc($fetchCntact))
            {
                    $arrCntact[$rowData['job_id']] = $rowData;
            }
            
            $fundQry = "SELECT * FROM es_fund_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchFund = mysql_query($fundQry);
            while($rowData = mysql_fetch_assoc($fetchFund))
            {
                $arrFund[$rowData['job_id']] = $rowData;
            }
            
            $memberQry = "SELECT * FROM es_member_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchMembr = mysql_query($memberQry);
            while($rowData = mysql_fetch_assoc($fetchMembr))
            {
                $arrMembrs[$rowData['member_id']] = $rowData;
            }
            
            $newTrstyQry = "SELECT * FROM es_new_trustee WHERE job_id = ".$_SESSION['jobId'];
            $fetchNewTrsty = mysql_query($newTrstyQry);
            while($rowData = mysql_fetch_assoc($newTrstyQry))
            {
                $arrNewTrsty[$rowData['job_id']] = $rowData;
            }
            
            $extTrstyQry = "SELECT * FROM es_existing_trustee WHERE job_id = ".$_SESSION['jobId'];
            $fetchExtTrsty = mysql_query($extTrstyQry);
            while($rowData = mysql_fetch_assoc($fetchExtTrsty))
            {
                $arrExtTrsty[$rowData['job_id']] = $rowData;
            }
            
            
            $filename = "job_".$jobid.".pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,viewed,file_path) VALUES (".$jobid.",'',NOW(),0,'".$filename."')";
            mysql_query($docQry);
            $doc_Id = mysql_insert_id();
            $filename = "job_".$doc_Id.".pdf";
            $doc2Qry = "UPDATE documents SET file_path = '".$filename."' WHERE document_id = ".$doc_Id;
            mysql_query($doc2Qry);
            
            include(PDF);
            $pdf=new HTML2FPDF();
            $pdf->AddPage();
//            $fp = fopen("template.html","r");
//            $strContent = fread($fp, filesize("template.html"));
//            fclose($fp);
            $strContent = "<table style='width:100%' >
                            <tr style='background-color:#0C436C;color:#FFF;' ><td colspan='2'>Contact Details</td></tr>
                            <tr>
                                <td>First Name:</td>
                                <td>".$arrCntact[$jobid]['fname']."</td>
                            </tr>
                        </table>";
            $pdf->WriteHTML($strContent);
            $pdf->Output($_SERVER['DOCUMENT_ROOT']."/uploads/setup/".$filename,"F");
            exit;
        }
}
                    
?>