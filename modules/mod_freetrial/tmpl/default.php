
<?php
    defined ('_JEXEC') or die ('Not Access');
    $document = &JFactory::getDocument();
    $document->addCustomTag('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>');
//    $document->addScript(JURI::root() .'modules/mod_freetrial/tmpl/securimage/js/contactregister.js');
    $exist_url = JURI::root();
?>
<h5>Free Trial Registration</h5></br>

<form action="" method="POST" enctype="multipart/form-data" name="josForm"  id="myForm" onSubmit="return validation()">
	<table width="400px" border="0" cellspacing="0" cellpadding="10">
		<tbody>
			<tr>
				<td class="text"><strong>Your Name </strong></td>
                                <td><input type="text" name="RName" required style="width:180px;" value="<?=$_REQUEST['RName']?>" title="Please enter your name" /></td>
			</tr>
			<tr>
				<td class="text"><strong>Practice Name </strong></td>
                                <td><input type="text" name="RPracticeName"  style="width:180px;" value="<?=$_REQUEST['RPracticeName']?>" /></td>
			</tr>
                        <tr>
                            <td class="text"><strong>Email Address </strong></td>
				<td><input type="text" name="REmail" required style="width:180px;" value="<?=$_REQUEST['REmail']?>" /></td>
			</tr>
                        <tr>
                            <td class="text"><strong>Phone Number </strong></td>
				<td><input type="text" name="Phone" required  style="width:180px;" value="<?=$_REQUEST['Phone']?>" /></td>
			</tr>
			<tr>
                            <td class="text"><strong>State </strong></td>
                                <td>
                                    <?php $arrStates = array("Australian Capital Territory"=>"Australian Capital Territory",
                                                            "New South Wales"=>"New South Wales",
                                                            "Northern Territory"=>"Northern Territory",
                                                            "Queensland"=>"Queensland",
                                                            "South Australia"=>"South Australia",
                                                            "Tasmania"=>"Tasmania",
                                                            "Victoria"=>"Victoria",
                                                            "Western Australia"=>"Western Australia"
                                                       ); 
                                    
                                    ?>
                                    <select id="state" name="state" style="width:198px;" required>
                                        <option value="0">--Select State--</option>
                                        <?php 
                                            foreach ($arrStates as $key => $value) {
                                                $sel="";
                                                if($_REQUEST['state'] == $key) $sel = "selected=''";
                                                ?><option value="<?=$key?>" <?=$sel?> ><?=$value?></option><?php
                                            }
                                        ?>
                                    </select>
                                </td>
			</tr>
			<tr>
                            <td class="text"><strong>Enter Captcha </strong></td>
                            <td>
                                <div style="float: left;">
                                    <div class="row_inner" id="input" >
                                        <img id="siimage" style="border: 1px solid #CCC; margin-right: 15px; border-radius: 4px; height:25px; width:140px; padding: 8px;" src="<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />
                                        <div style="height: auto;width: auto;position: relative;margin-top: 3px;">
                                                <object type="application/x-shockwave-flash" data="<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/images/audio_icon.png&amp;audio_file=<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/securimage_play.php" height="18" width="18">
                                                <param name="movie" value="<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/images/audio_icon.png&amp;audio_file=./securimage_play.php" />
                                                </object>
                                                &nbsp;
                                                <a tabindex="-1" style="border-style: none;background:none;right: 2px;top: 55%;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="<?=$exist_url?>modules/mod_freetrial/tmpl/securimage/images/refresh.png" alt="Reload Image" height="18" width="18" onclick="this.blur()" align="bottom" border="0" /></a>
                                                <br />
                                        </div>
                                        <input type="text" class="inputbox" required style="margin-top: 5px; width:180px; margin-bottom: 5px" id="ct_captcha" name="ct_captcha" size="12" maxlength="8" value="<?=$_REQUEST['ct_captcha']?>" />
                                        <span style="color:red; font-size:11px; font-weight: normal;"><? if(isset($_REQUEST['hidMsg']) && $_REQUEST['hidMsg'] == 'Y') echo '<script>document.getElementById("ct_captcha").className = "errclass";</script>';?></span>
                                    </div>
                              </div>
                            </td>
			</tr>
			<tr>
				<td></td>
				<td><button class="submit" name="" type="submit">Register Now</button></td>
			</tr>
		</tbody>
	</table>
</form>

