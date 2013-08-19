<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" /> 
		<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
		<link href="images_user/favicon.ico" rel="shortcut icon" />
		<!-- Main CSS-->
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
		<!-- Google Webfont -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/tooltip.css"/>
		<script type="text/javascript" src="js/datetimepicker_css.js"></script><?

		$arrQryStr = explode('&', $_SERVER['QUERY_STRING']);
		$qryStr = $arrQryStr[0];

		if(basename($_SERVER['PHP_SELF']) == 'jobs.php') {
			if($qryStr == 'a=add') {
				?><title>Submit a Job (Compliance)</title><?
			}
			else if($qryStr == 'a=audit') {
				?><title>Submit a Job (Audit)</title><?
			}
			else if($qryStr == 'a=uploadAudit') {
				?><title>Add documents (Audit)</title><?
			}
			else if($qryStr == 'a=edit') {
				?><title>Edit Existing Job</title><?
			}
			else if($qryStr == 'a=pending') {
				?><title>Pending Jobs</title><?
			}
			else if($qryStr == 'a=completed') {
				?><title>Completed Jobs</title><?
			}
			else if($qryStr == 'a=document') {
				?><title>My Documents</title><?
			}
			else if($qryStr == 'a=uploadDoc') {
				?><title>Upload Document</title><?
			}
			else {
				?><title>View My Job List</title><?
			}
			?><script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="js/job_validation.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_contact.php') {
				?><title>Contact Details</title>
				<script type="text/javascript" src="js/new_smsf_contact.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_fund.php') {
				?><title>Fund Details</title>
				<script type="text/javascript" src="js/new_smsf_fund.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_member.php') {
				?><title>Member Details</title>
				<script type="text/javascript" src="js/new_smsf_member.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_trustee.php') {
				?><title>Trustee Details</title>
				<script type="text/javascript" src="js/new_smsf_trustee.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'new_smsf_declarations.php') {
				?><title>Declarations</title>
				<script type="text/javascript" src="js/new_smsf_declarations.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'existing_smsf_contact.php') {
				?><title>Contact Details</title>
				<script type="text/javascript" src="js/existing_smsf_contact.js"></script><?
		}else if(basename($_SERVER['PHP_SELF']) == 'existing_smsf_fund.php') {
				?><title>Fund Details</title>
				<script type="text/javascript" src="js/existing_smsf_fund.js"></script><?
		}
		else if(basename($_SERVER['PHP_SELF']) == 'queries.php') {
			?><title>View All Queries</title>
			<script type="text/javascript" src="js/queries_validation.js"></script><?
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
			?><script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="js/client_validation.js"></script><?
		}
		else {
			?><title>Home</title><?
		}
		?></head>
	<body><?	