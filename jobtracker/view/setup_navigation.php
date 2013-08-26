<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$arrQryStr = explode('&', $_SERVER['QUERY_STRING']);
                $qryStr = $arrQryStr[0];
                $typeStr = $arrQryStr[1];
                if(isset($arrQryStr[2]))//unset($_SESSION['frmId']);
                    $_SESSION['frmId'] = $arrQryStr[2];
?>              
<br>
<br>
<table border="0" cellspacing="1" cellpadding="4" align="left">
	<tr>
<!--            <td>
		<p class="joblstbtn" style="<?if($qryStr=='a=order') echo "background-color:#F05729;"?>" >Order Type</p>
            </td>-->
            <?php //if($frmId==1){ ?>
            <td>
		<p class="joblstbtn" style="<?if($qryStr=='a=add' || $qryStr=='a=edit') echo "background-color:#F05729;"?>" >Job Details</p>
            </td>
            <?php //} ?>
            <?php if($_SESSION['frmId'] == 'frmId=1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf.php") echo "background-color:#F05729;"?>" >New SMSF Details</p>
            </td>
            <?php } ?>
            <?php if($_SESSION['frmId'] == 'frmId=2'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "existing_smsf.php") echo "background-color:#F05729;"?>" >Existing SMSF Details</p>
            </td>
            <?php } ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_contact.php" || basename($_SERVER['PHP_SELF']) == "existing_smsf_contact.php") echo "background-color:#F05729;"?>" >Contact Details</p>
            </td>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_fund.php" || basename($_SERVER['PHP_SELF']) == "existing_smsf_fund.php") echo "background-color:#F05729;"?>" >Fund Details</p>
            </td>
            <?php if($_SESSION['frmId'] == 'frmId=1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_member.php") echo "background-color:#F05729;"?>" >Member Details</p>
            </td>
            <?php  } ?>
            <?php if($_SESSION['frmId'] == 'frmId=1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_trustee.php") echo "background-color:#F05729;"?>" >Trustee Details</p>
            </td>
            <?php  } ?>
            <?php if($_SESSION['frmId'] == 'frmId=1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_declarations.php") echo "background-color:#F05729;"?>" >Declarations</p>
            </td>
            <?php  } ?>
        </tr>
</table>
<br><br>