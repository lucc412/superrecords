<?
// include topbar file
include(TOPBAR);

// page header
?><div class="pageheader">
	<h1>Download Templates</h1>
	<span>
		<b>Welcome to the Super Records download templates page.</b></br>Below you can see a reference list that has been developed for Super Records clients to download sample forms. Read the information given for form & then simply click on the relevant form to download.
	<span>
</div>
<form name="objForm" id="objForm" method="post" action="template.php">
	<table width="100%" class="pdT20 resources">
		<tr>
			<td width="30%" class="td_title">Document Name</td>
			<td width="60%" class="td_title">Information</td>
			<td width="10%" class="td_title" align="center">Download</td>
		</tr><?
		
		$countRow = 0;
		foreach($arrTemplate AS $templateInfo) {
			if($countRow%2 == 0) $trClass = "trcolor";
			else $trClass = "";

			?><tr class="<?=$trClass?>">
				<td class="tddata" align="left"><?=$templateInfo['tmpl_name']?></td>
				<td class="tddata" align="left"><?=nl2br($templateInfo['tmpl_desc'])?></td>
				<td class="tddata" align="center"><?
					$folderPath = "../uploads/template/" . $templateInfo['tmpl_filepath'];
					if(file_exists($folderPath) && !empty($templateInfo['tmpl_filepath'])) {
                                                 $icon = returnFileIcon($templateInfo['tmpl_filepath']);
						?><p><?=$icon?><a href="<?=DOWNLOAD?>?fileName=<?=urlencode($templateInfo['tmpl_filepath'])?>&folderPath=T" title="Click to download this document">Document</a></p><?
					}
				?></td>
			</tr><?
			$countRow++;
		}
	?></table>
</form><?
		
// include footer file
include(FOOTER);
?>