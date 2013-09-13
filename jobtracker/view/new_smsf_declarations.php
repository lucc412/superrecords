<?php
include(TOPBAR);
include(SETUPNAVIGATION);
?>
<div class="pageheader">
	<h1>Declarations</h1>
	<span>
		<b>Welcome to the Super Records declarations page.</b><br/>There are certain limitations on who can be a member or a trustee of a self managed superannuation fund. Please answer yes or no to the following questions to determine whether any proposed member or trustee is not allowed to be a member or trustee of the SMSF.
	<span>
</div>
<form method="post" action="new_smsf_declarations.php" onsubmit="return checkYesNoAns();">
	<input type="hidden" value="<?=$_SESSION['TRUSTEETYPE']?>" id="hdnTrusteeType"/>
	<div style="padding-top:20px;">
		<table class="fieldtable"><?
			for($i=0; $i<count($arrQues); $i++)	{
				?><tr>
					<td class="pdB20">
						<?=$arrQues[$i]?>
					</td>
					<td class="pdB20">
						<label style="padding-left:30px;"><input class="checkboxClass" type="radio" name="rd<?=$i+1?>" id="rd<?=$i+1?>"/>Yes</label>
						<label><input class="checkboxClass" type="radio" name="rd<?=$i+1?>" id="rd<?=$i+1?>" checked="checked"/>No</label>
					</td>
				</tr><?
			}	
		?></table>

		</br>
<!--                <div style="font-weight:bold;">
                    <input class="checkboxClass" type="checkbox" name="chkAgree" id="chkAgree" <?php echo ($checkTerms=='on')?"checked":""; ?>/> I have read and agree to your 
			<a href="#" onclick="javascript:popUp('docs/terms_conditions.html');">terms and conditions</a>
		</div>-->
	</div>
        <input type="hidden" name="job_submitted" id="job_submitted" value="">
	<div style="padding-top:20px;"><?

		if($_SESSION['TRUSTEETYPE'] != 1)
			$jsFunc = "window.location.href='new_smsf_trustee.php'";
		else
			$jsFunc = "window.location.href='new_smsf_member.php'";
		
			?><span align="left"><button type="button" onclick="<?=$jsFunc?>" >BACK</button></span>
			<span align="right" style="padding-left:55px;"><button type="submit" id="btnNext">SAVE & EXIT</button></span>
			<span align="right" style="padding-left:55px;"><button type="submit" id="btnSave">SUBMIT</button></span>
	</div>
        <script>
            $('#btnNext').click(function(){$('#job_submitted').val('N')})
            $('#btnSave').click(function(){$('#job_submitted').val('Y')})
        </script>
</form><?

include(FOOTER);
?>