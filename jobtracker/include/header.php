<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<script src="<?=DIR?>js/jquery-1.9.1.js"></script>
		<script src="<?=DIR?>js/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=DIR?>css/jquery-smoothness/jquery-ui-1.10.3.custom.min.css" />
		<!--<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" /> 
		<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />-->
		<link href="<?=DIR?>images/favicon.ico" rel="shortcut icon" />
		<!-- Main CSS-->
		<link rel="stylesheet" type="text/css" href="<?=DIR?>css/stylesheet.css"/>
		<!-- Google Webfont -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		<!--<link rel="stylesheet" type="text/css" href="css/tooltip.css"/>-->
		<link rel="stylesheet" type="text/css" href="<?=DIR?>css/tooltipster.css" />
		<script type="text/javascript" src="<?=DIR?>js/datetimepicker_css.js"></script>
		<script type="text/javascript" src="<?=DIR?>js/common.js"></script>
                <script type="text/javascript" src="<?=DIR?>js/jquery.tooltipster.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			 $('.tooltip').tooltipster({
				 animation: 'grow',
			 });
                });
		</script><?

		$arrQryStr = stringToArray('&', $_SERVER['QUERY_STRING']);
                $qryStr = $arrQryStr[0];
                
		if(basename($_SERVER['PHP_SELF']) == 'jobs.php') {
                    ?><title>Submit new job</title><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'compliance.php') {
                    ?><title>Submit new compliance job</title>
                    <script type="text/javascript" src="<?=DIR?>js/compliance_validation.js"></script><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'audit.php') {
                        if(isset($qryStr) && strstr($qryStr, 'recid')) {
                            ?><title>Edit existing audit job</title><?
			}
                        else {
                            ?><title>Submit new audit job</title><?
                        }
                        ?><script type="text/javascript" src="<?=DIR?>js/audit_validation.js"></script><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'audit_checklist.php') { 
                    ?><title>Audit Checklist</title><?
                }
                else if(basename($_SERVER['PHP_SELF']) == 'audit_subchecklist.php') { 
                    ?><title>Checklist for Audit</title>
                    <script type="text/javascript" src="<?=DIR?>js/audit_subchecklist_validation.js"></script><?
                }
                else if(basename($_SERVER['PHP_SELF']) == 'audit_upload.php') { 
                    ?><title>Upload multiple documents</title>
                    <script type="text/javascript" src="<?=DIR?>js/audit_upload_validation.js"></script><?
                }
                else if(basename($_SERVER['PHP_SELF']) == 'subaudit_upload.php') { 
                    ?><title>Upload documents for checklist</title>
                    <script type="text/javascript" src="<?=DIR?>js/subaudit_upload_validation.js"></script><?
                }
                else if(basename($_SERVER['PHP_SELF']) == 'setup.php') {
                    ?><title>Order Documents</title><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'jobs_saved.php') {
			?><title>Retrieve saved jobs</title><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'jobs_pending.php') {
			?><title>Pending jobs</title><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'jobs_completed.php') {
			?><title>Completed jobs</title><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'jobs_doc_list.php') {  
                    ?><title>View and upload documents</title><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'jobs_doc_upload.php') { 
                    ?><title>Upload Documents</title>
                    <script type="text/javascript" src="<?=DIR?>js/jobs_documents_validation.js"></script><?
                }
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf.php') {
			?><title>New SMSF Details</title><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_contact.php') {
				?><title>Contact Details</title>
				<script type="text/javascript" src="<?=DIR?>js/new_smsf_contact.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_fund.php') {
				?><title>Fund Details</title>
				<script type="text/javascript" src="<?=DIR?>js/new_smsf_fund.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_member.php') {
				?><title>Member Details</title>
				<script type="text/javascript" src="<?=DIR?>js/new_smsf_member.js"></script><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'legal_references.php') {
				?><title>Legal Personal Representative</title>
				<script type="text/javascript" src="<?=DIR?>js/legal_references.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_trustee.php') {
				?><title>Trustee Details</title>
				<script type="text/javascript" src="<?=DIR?>js/new_smsf_trustee.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_declarations.php') {
				?><title>Declarations</title>
				<script type="text/javascript" src="<?=DIR?>js/new_smsf_declarations.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'existing_smsf.php') {
			?><title>Existing SMSF Details</title><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'existing_smsf_contact.php') {

				?><title>Contact Details</title>
				<script type="text/javascript" src="<?=DIR?>js/existing_smsf_contact.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'existing_smsf_fund.php') {
				?><title>Fund Details</title>
				<script type="text/javascript" src="<?=DIR?>js/existing_smsf_fund.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'setup_preview.php') {
			?><title>Preview</title><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'queries.php') {
			?><title>View All Queries</title>
			<script type="text/javascript" src="<?=DIR?>js/queries_validation.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'template.php') {
			?><title>Download Templates</title>
			<script type="text/javascript" src="<?=DIR?>js/queries_validation.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'clients.php') {
			if($qryStr == 'a=add') {
				?><title>Add New Client</title><?
			}
			else if($qryStr == 'a=edit') {
				?><title>Edit Existing Client</title><?
			}
			else {
				?><title>View My Client List</title><?
			}
			?><script type="text/javascript" src="<?=DIR?>js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="<?=DIR?>js/client_validation.js"></script><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'company_details.php') {
			?><title>Company Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/standard_company/js/company_details.js"></script><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'address_details.php') {
			?><title>Company Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/standard_company/js/address_details.js"></script><?
		}
                else if(basename($_SERVER['PHP_SELF']) == 'officer_details.php') {
			?><title>Officer Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/standard_company/js/officer_details.js"></script><?
		}
		else {
			?><title>Home</title><?
		}
		?></head>
	<body><?	