<?
if(basename($_SERVER['PHP_SELF']) != 'login.php') {
	if(!isset($_SESSION['PRACTICE'])) {
		header('Location: '.DIR.'login.php');
	}
}
include(HEADDATA);
?><div class="wrapper"><?
	if(basename($_SERVER['PHP_SELF']) != 'login.php') {
		?><div class="header">
			<div class="container">
				<div class="branding">
					<a href="<?=DIR?>home.php"><img src="<?=DIR?>images/header-logo.png" /></a>
				</div> <!--branding-->
				<div class="user">        	
					<span style="color:#074263">Welcome,</span> <span><?=$_SESSION['PRACTICE'];?></span>
				</div> <!--user-->
				<div class="phone">
					<button style="width:94px" onclick="javascript:urlRedirect('<?=DIR?>login.php?a=logout');" type="submit" value="Submit">Logout</button>
				</div> <!--phone-->
			</div> <!--container-->
		</div> <!--header-->

		<div class="nav">
			<div class="container">
				<ul>
					<!--<li><a href="<?=DIR?>home.php">Home</a></li>-->
					<li class="dropdown"><a href="javascript:;">&nbsp;&nbsp;Clients&nbsp;&nbsp;</a>
                                            <ul class="sub">
                                                <li><a href="<?=DIR?>clients.php?a=add">Add New Client</a></li>
                                                <li><a href="<?=DIR?>clients.php">View My Client List</a></li>
                                            </ul>
					</li>
					<li class="dropdown"><a href="javascript:;">&nbsp;&nbsp;Jobs&nbsp;&nbsp;</a>
                                            <ul class="sub">
                                                <li><a href="<?=DIR?>jobs.php">Submit new job</a></li>
                                                <li><a href="<?=DIR?>jobs_saved.php">Retrieve saved jobs</a></li>
                                                <li><a href="<?=DIR?>jobs_pending.php">Pending jobs</a></li>
                                                <li><a href="<?=DIR?>jobs_completed.php">Completed jobs</a></li>
                                                <li><a href="<?=DIR?>jobs_doc_list.php">View and upload documents</a></li>
                                            </ul>
					</li>
					<li><a href="<?=DIR?>setup.php">Order Documents</a></li> 
					<li><a href="<?=DIR?>queries.php">View All Queries</a></li> 
					<!--<li><a href="<?=DIR?>template.php">Download Templates</a></li> -->
				</ul>
			</div><!--container-->
		</div><!--nav--><?
	}
	?><div class="pagebackground">
		<div class="container">