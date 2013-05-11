<?
if(basename($_SERVER['PHP_SELF']) != 'login.php') {
	if(!isset($_SESSION['PRACTICE'])) {
		header('Location: login.php');
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" /> 
		<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
		<link href="images_user/favicon.ico" rel="shortcut icon" />
		<!-- Main CSS-->
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
		<!-- Google Webfont -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'><?

		$arrQryStr = explode('&', $_SERVER['QUERY_STRING']);
		$qryStr = $arrQryStr[0];

		if(basename($_SERVER['PHP_SELF']) == 'jobs.php') {
			if($qryStr == 'a=add') {
				?><title>Submit a Job</title><?
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
	?>
		<script>
			// This function is used to redirect page
			function urlRedirect(url)
			{
				window.location.href = url;
			}
		</script>
		
	</head>
	<body><?
		include("path.php");
		?><div class="wrapper"><?
			if(basename($_SERVER['PHP_SELF']) != 'login.php') {
				?><div class="header">
					<div class="container">
						<div class="branding">
							<a href="home.php"><img src="images_user/header-logo.png" /></a>
						</div> <!--branding-->
						<div class="user">        	
							<span style="color:#074263">Welcome,</span> <span><?=$_SESSION['PRACTICE'];?></span>
						</div> <!--user-->
						<div class="phone">
							<button style="width:94px" onclick="javascript:urlRedirect('login.php?a=logout');" type="submit" value="Submit">Logout</button>
						</div> <!--phone-->
					</div> <!--container-->
				</div> <!--header-->

				<div class="nav">
					<div class="container">
						<ul>
							<li><a href="home.php">Home</a></li>
							<li class="dropdown"><a href="javascript:;">&nbsp;&nbsp;&nbsp;&nbsp;Clients&nbsp;&nbsp;&nbsp;&nbsp;</a>
								<ul class="sub">
									<li><a href="clients.php?a=add">Add New Client</a></li>
									<li><a href="clients.php">View My Client List</a></li>
								</ul>
							</li>
							<li class="dropdown"><a href="javascript:;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jobs&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								<ul class="sub">
									<li><a href="jobs.php?a=add">Submit a Job</a></li>
									<li><a href="jobs.php?a=pending">Pending Jobs</a></li>
									<li><a href="jobs.php?a=completed">Completed Jobs</a></li>
									<li><a href="jobs.php?a=document">My Documents</a></li>
								</ul>
							</li>
							<li><a href="queries.php">View All Queries</a></li> 
						</ul>
					</div><!--container-->
				</div><!--nav--><?
			}
			?><div class="pagebackground">
				<div class="container">