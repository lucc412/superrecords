<?
if(basename($_SERVER['PHP_SELF']) != 'login.php') {
	if(!isset($_SESSION['PRACTICE'])) {
		header('Location: login.php');
	}
}
include(HEADDATA);
include("path.php");
?><div class="wrapper"><?
	if(basename($_SERVER['PHP_SELF']) != 'login.php') {
		?><div class="header">
			<div class="container">
				<div class="branding">
					<a href="home.php"><img src="images/header-logo.png" /></a>
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
					<!--<li><a href="home.php">Home</a></li>-->
					<li class="dropdown"><a href="javascript:;">&nbsp;&nbsp;Clients&nbsp;&nbsp;</a>
						<ul class="sub">
							<li><a href="clients.php?a=add">Add New Client</a></li>
							<li><a href="clients.php">View My Client List</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="javascript:;">&nbsp;&nbsp;Jobs&nbsp;&nbsp;</a>
						<ul class="sub">
							<li><a href="jobs.php?a=job">Submit new job</a></li>
							<li><a href="jobs.php?a=saved">Retrieve saved jobs</a></li>
							<li><a href="jobs.php?a=pending">Pending jobs</a></li>
							<li><a href="jobs.php?a=completed">Completed jobs</a></li>
							<li><a href="jobs.php?a=document">View and upload documents</a></li>
						</ul>
					</li>
					<li><a href="jobs.php?a=order&var=new">Order Documents</a></li> 
					<li><a href="queries.php">View All Queries</a></li> 
					<!--<li><a href="template.php">Download Templates</a></li> -->
				</ul>
			</div><!--container-->
		</div><!--nav--><?
	}
	?><div class="pagebackground">
		<div class="container">