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
                    
                        $QueId = explode(",", $arrQuesAns['question_id']);
			for($i=0; $i<count($arrQues); $i++)	{
                            
                            if ($QueId[$i] == $arrQues[$i]['question_id'])
                            {
                                $ansNo = 'checked="1checked"'; $ansYes = '';
                            }
                            else
                            {
                                $ansNo = ''; $ansYes = 'checked="1checked"';                            }
                            
				?><tr>
					<td class="pdB20">
						<?=$arrQues[$i]['question']?>
					</td>
					<td class="pdB20">
                                            <label style="padding-left:30px;"><input class="checkboxClass" type="radio" name="rd[<?=$i+1?>]" <?=$ansYes?> id="rd<?=$i+1?>" value="on" />Yes</label>
                                            <label><input class="checkboxClass" type="radio" name="rd[<?=$i+1?>]" id="rd<?=$i+1?>" <?=$ansNo?> value="off" />No</label>
					</td>
				</tr><?
			}	
		?></table>

		</br>

	</div>
        <input type="hidden" name="job_submitted" id="job_submitted" value="">
        <input type="hidden" name="preview" id="preview" value="">
        <div class="txtAboveButton">Your document details are ready to be submitted. However, prior to doing so, please preview to make sure all details are correct. <p>To preview, please click the 'Preview' button below.</p></div>
	<div class="pdT20"><?

		if($_SESSION['TRUSTEETYPE'] != 1)
			$jsFunc = "window.location.href='new_smsf_trustee.php'";
		else
		{
                    if(count($arrLegRef)>0){
                        $jsFunc = "window.location.href='legal_references.php'";
                    }
                    else {
                        $jsFunc = "window.location.href='new_smsf_member.php'";
                    }
                }
                ?><span class="pdR20"><button type="button" onclick="<?=$jsFunc?>" >Back</button></span>
                <span class="pdR20"><button type="submit" id="btnNext">Save & Exit</button></span>
                <span class="pdR20"><button id="btnPreview" name="btnPreview" class="" type="submit" value="preview">Preview</button></span>
	</div>
        <script>
            $('#btnNext').click(function(){$('#job_submitted').val('N')})
            $('#btnPreview').click(function(){$('#job_submitted').val('')})
        </script>
</form><?

include(FOOTER);
?>