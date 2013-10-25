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
                $typeStr = $arrQryStr[1];
                
		if(basename($_SERVER['PHP_SELF']) == 'jobs.php') {
			if($typeStr == 'type=comp') {
				?><title>Submit new compliance job</title><?
			}
                        else if($typeStr == 'type=setup') {
				?><title>Submit new setup job</title><?
			}
			else if($qryStr == 'a=audit') {
				if(isset($typeStr) && strstr($typeStr, 'recid')) {
					?><title>Edit existing audit job</title><?
				}
				else {
					?><title>Submit new audit job</title><?
				}
			}
			else if($qryStr == 'a=checklist') {
				?><title>Audit Checklist</title><?
			}
			else if($qryStr == 'a=subchecklist' || $qryStr == 'a=uploadAudit' || $qryStr == 'a=uploadSubAudit') {
				?><title>Checklist for Audit</title><?
			}
			else if($qryStr == 'a=edit') {
				?><title>Edit existing job</title><?
			}
			else if($qryStr == 'a=order') {
				?><title>Order Documents</title><?
			}
			else if($qryStr == 'a=saved') {
				?><title>Retrieve saved jobs</title><?
			}
			else if($qryStr == 'a=pending') {
				?><title>Pending jobs</title><?
			}
			else if($qryStr == 'a=completed') {
				?><title>Completed jobs</title><?
			}
			else if($qryStr == 'a=document') {
				?><title>View and upload documents</title><?
			}
			else if($qryStr == 'a=uploadDoc') {
				?><title>View and upload documents</title><?
			}
			else {
				?><title>Submit new job</title><?
			}
			?>
			<script type="text/javascript" src="<?=DIR?>js/job_validation.js"></script><?
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