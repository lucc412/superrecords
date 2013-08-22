<table border="0" cellspacing="1" cellpadding="4" align="left">
	<tr><?
		
		// Job Details
		?><td>
			<form method="POST" name="frmJobDetails" action="job.php">
				<input class="joblstbtn" type="submit" name="btnDetails" value="Details" style="<?if($_REQUEST['a']=='editJob') echo "background-color:#F05729;"?>">
				<input type="hidden" name="a" value="editJob">
				<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
			</form>
		</td><?

		// checklists
		if($_SESSION['jobGenre'] == 'AUDIT') {
			?><td>
				<form method="POST" name="frmDocuments" action="job.php">
					<input class="joblstbtn" type="submit" name="btnDocument" value="Checklists" style="<?if($_REQUEST['a']=='checklists') echo "background-color:#F05729;"?>">
					<input type="hidden" name="a" value="checklists">
					<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
				</form>
			</td><?
		}
		// Source Documents
		else if($_SESSION['jobGenre'] == 'COMPLIANCE') {
			?><td>
				<form method="POST" name="frmDocuments" action="job.php">
					<input class="joblstbtn" type="submit" name="btnDocument" value="Documents" style="<?if($_REQUEST['a']=='documents') echo "background-color:#F05729;"?>">
					<input type="hidden" name="a" value="documents">
					<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
				</form>
			</td><?
		}

		// Reports
		if($_SESSION['jobGenre'] == 'COMPLIANCE') {
			?><td>
				<form method="POST" name="frmReports" action="job.php">
					<input class="joblstbtn" type="submit" name="btnReports" value="Reports" style="<?if($_REQUEST['a']=='reports') echo "background-color:#F05729;"?>">
					<input type="hidden" name="a" value="reports">
					<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
				</form>
			</td><?
		}
		
		// Queries
		?><td>
			<form method="POST" name="frmQueries" action="job.php">
				<input class="joblstbtn" type="submit" name="btnQueries" value="Queries" style="<?if($_REQUEST['a']=='queries') echo "background-color:#F05729;"?>">
				<input type="hidden" name="a" value="queries">
				<input type="hidden" name="jobId" value="<?=$_REQUEST["jobId"]?>">
			</form>
		</td>
	</tr>
</table>