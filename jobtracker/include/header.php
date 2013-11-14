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

                // get request url
                $requestUrl = basename($_SERVER['PHP_SELF']);
                $urlParts = pathinfo($_SERVER['PHP_SELF']);
                
                // get request folder path
                $folderPath = replaceString('/jobtracker/setup/', '', dirname($_SERVER['PHP_SELF']));
		$arrQryStr = stringToArray('&', $_SERVER['QUERY_STRING']);
                $qryStr = $arrQryStr[0];
                
		if($requestUrl == 'jobs.php') {
                    ?><title>Submit new job</title><?
		}
                else if($requestUrl == 'compliance.php') {
                    ?><title>Submit new compliance job</title>
                    <script type="text/javascript" src="<?=DIR?>js/compliance_validation.js"></script><?
		}
                else if($requestUrl == 'audit.php') {
                    if(isset($qryStr) && strstr($qryStr, 'recid')) {
                        ?><title>Edit existing audit job</title><?
                    }
                    else {
                        ?><title>Submit new audit job</title><?
                    }
                    ?><script type="text/javascript" src="<?=DIR?>js/audit_validation.js"></script><?
		}
                else if($requestUrl == 'audit_checklist.php') { 
                    ?><title>Audit Checklist</title><?
                }
                else if($requestUrl == 'audit_subchecklist.php') { 
                    ?><title>Checklist for Audit</title>
                    <script type="text/javascript" src="<?=DIR?>js/audit_subchecklist_validation.js"></script><?
                }
                else if($requestUrl == 'audit_upload.php') { 
                    ?><title>Upload multiple documents</title>
                    <script type="text/javascript" src="<?=DIR?>js/audit_upload_validation.js"></script><?
                }
                else if($requestUrl == 'subaudit_upload.php') { 
                    ?><title>Upload documents for checklist</title>
                    <script type="text/javascript" src="<?=DIR?>js/subaudit_upload_validation.js"></script><?
                }
                else if($requestUrl == 'setup.php') {
                    ?><title>Order Documents</title><?
		}
                else if($requestUrl == 'jobs_saved.php') {
			?><title>Retrieve saved jobs</title><?
		}
                else if($requestUrl == 'jobs_pending.php') {
			?><title>Pending jobs</title><?
		}
                else if($requestUrl == 'jobs_completed.php') {
			?><title>Completed jobs</title><?
		}
                else if($requestUrl == 'jobs_doc_list.php') {  
                    ?><title>View and upload documents</title><?
		}
                else if($requestUrl == 'jobs_doc_upload.php') { 
                    ?><title>Upload Documents</title>
                    <script type="text/javascript" src="<?=DIR?>js/jobs_documents_validation.js"></script><?
                }
		else if($requestUrl == 'setup_preview.php' || $requestUrl == 'preview.php') {
			?><title>Preview</title><?
		}
		else if($requestUrl == 'queries.php') {
			?><title>View All Queries</title>
			<script type="text/javascript" src="<?=DIR?>js/queries_validation.js"></script><?
		}
		else if($requestUrl == 'template.php') {
			?><title>Download Templates</title><?
		}
		else if($requestUrl == 'clients.php') {
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
		else if($requestUrl == 'new_smsf.php') {
			?><title>New SMSF Details</title><?
		}
		else if($requestUrl == 'new_smsf_contact.php') {
                        ?><title>Contact Details</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/new_smsf_contact.js"></script><?
		}
		else if($requestUrl == 'new_smsf_fund.php') {
                        ?><title>Fund Details</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/new_smsf_fund.js"></script><?
		}
		else if($requestUrl == 'new_smsf_member.php') {
                        ?><title>Member Details</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/new_smsf_member.js"></script><?
		}
                else if($requestUrl == 'legal_references.php') {
                        ?><title>Legal Personal Representative</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/legal_references.js"></script><?
		}
		else if($requestUrl == 'new_smsf_trustee.php') {
                        ?><title>Trustee Details</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/new_smsf_trustee.js"></script><?
		}
		else if($requestUrl == 'new_smsf_declarations.php') {
                        ?><title>Declarations</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/new_smsf_declarations.js"></script><?
		}
		else if($requestUrl == 'existing_smsf.php') {
			?><title>Existing SMSF Details</title><?
		}
		else if($requestUrl == 'existing_smsf_contact.php') {
                        ?><title>Contact Details</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/existing_smsf_contact.js"></script><?
		}
		else if($requestUrl == 'existing_smsf_fund.php') {
                        ?><title>Fund Details</title>
                        <script type="text/javascript" src="<?=DIR?>setup/new_smsf/js/existing_smsf_fund.js"></script><?
		}
                else if($requestUrl == 'company_details.php') {
			?><title>Company Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/<?=$folderPath?>/js/company_details.js"></script><?
		}
                else if($requestUrl == 'address_details.php') {
			?><title>Address Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/<?=$folderPath?>/js/address_details.js"></script><?
		}
                else if($requestUrl == 'officer_details.php') {
			?><title>Officer Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/<?=$folderPath?>/js/officer_details.js"></script><?
		}
                else if($requestUrl == 'shareholder_details.php') {
			?><title>Shareholder Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/<?=$folderPath?>/js/shareholder_details.js"></script><?
                }
                else if($requestUrl == 'holding_trust.php' && $folderPath == 'holding_trust') {
			?><title>Holding Trust Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/holding_trust/js/holding_trust.js"></script><?
		}
                else if($requestUrl == 'trust_fund.php' && $folderPath == 'holding_trust') {
			?><title>Fund Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/holding_trust/js/trust_fund.js"></script><?
		}
                else if($requestUrl == 'trust_asset.php' && $folderPath == 'holding_trust') {
			?><title>Asset Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/holding_trust/js/trust_asset.js"></script><?
		}
                else if($requestUrl == 'trust.php') {
			?><title>Holding Trust Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/limited_recourse/js/trust.js"></script><?
		}
                else if($requestUrl == 'holding_trust.php' && $folderPath == 'limited_recourse') {
			?><title>Lender Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/limited_recourse/js/holding_trust.js"></script><?
		}
                else if($requestUrl == 'trust_fund.php' && $folderPath == 'limited_recourse') {
			?><title>Borrower Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/limited_recourse/js/trust_fund.js"></script><?
		}
                else if($requestUrl == 'trust_asset.php' && $folderPath == 'limited_recourse') {
			?><title>Limited Recourse Loan Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/limited_recourse/js/trust_asset.js"></script><?
		}
                else if($requestUrl == 'fund.php' && $folderPath == 'change_trustee') {
			?><title>Fund Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/change_trustee/js/fund.js"></script><?
		}
                else if($requestUrl == 'existing_trustee.php' && $folderPath == 'change_trustee') {
			?><title>Existing Trustee Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/change_trustee/js/existing_trustee.js"></script><?
		}
                else if($requestUrl == 'new_trustee.php' && $folderPath == 'change_trustee') {
			?><title>New Trustee Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/change_trustee/js/new_trustee.js"></script><?
		}
                else if($requestUrl == 'member.php' && $folderPath == 'change_trustee') {
			?><title>Member Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/change_trustee/js/member.js"></script><?
		}
                else if($requestUrl == 'fund.php' && $folderPath == 'trustee_and_membr_app') {
			?><title>Fund Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/trustee_and_membr_app/js/fund.js"></script><?
		}
                else if($requestUrl == 'company_details.php' && $folderPath == 'trustee_and_membr_app') {
			?><title>Company Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/trustee_and_membr_app/js/company_details.js"></script><?
                }
                else if($requestUrl == 'fund.php' && $folderPath == 'investment_strategy') {
			?><title>Fund Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/investment_strategy/js/fund.js"></script><?
		}
                else if($requestUrl == 'trust_asset.php' && $folderPath == 'investment_strategy') {
			?><title>Asset Allocation</title>
			<script type="text/javascript" src="<?=DIR?>setup/investment_strategy/js/trust_asset.js"></script><?
		}
                else if($requestUrl == 'other.php' && $folderPath == 'investment_strategy') {
			?><title>Other Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/investment_strategy/js/other.js"></script><?
		}
                else if($requestUrl == 'fund.php' && $folderPath == 'deed_of_variation') {
			?><title>Fund Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/deed_of_variation/js/fund.js"></script><?
		}
                else if($requestUrl == 'holding_trust.php' && $folderPath == 'deed_of_variation') {
			?><title>Trustee Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/deed_of_variation/js/holding_trust.js"></script><?
		}
                else if($requestUrl == 'member.php' && $folderPath == 'deed_of_variation') {
			?><title>Member Details</title>
			<script type="text/javascript" src="<?=DIR?>setup/deed_of_variation/js/member.js"></script><?
		}
		else {
			?><title>Home</title><?
		}
		?></head>
	<body><?	