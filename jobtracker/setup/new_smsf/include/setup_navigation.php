<br>
<table border="0" cellspacing="1" cellpadding="4" align="left">
	<tr>
            <?php if($_SESSION['frmId'] == '1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf.php") echo "background-color:#F05729;"?>" >New SMSF Details</p>
            </td>
            <?php } ?>
            <?php if($_SESSION['frmId'] == '2'){ ?>
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
            <?php if($_SESSION['frmId'] == '1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_member.php") echo "background-color:#F05729;"?>" >Member Details</p>
            </td>
            <td>
		<p class="joblstbtn" style="width:190px;<?if(basename($_SERVER['PHP_SELF']) == "legal_references.php") echo "background-color:#F05729"?>" >Legal Personal Representative</p>
            </td>
            <?php  } ?>
            <?php if($_SESSION['frmId'] == '1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_trustee.php") echo "background-color:#F05729;"?>" >Trustee Details</p>
            </td>
            <?php  } ?>
            <?php if($_SESSION['frmId'] == '1'){ ?>
            <td>
		<p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "new_smsf_declarations.php") echo "background-color:#F05729;"?>" >Declarations</p>
            </td>
            <?php  } ?>
            <td>
                <p class="joblstbtn" style="<?if(basename($_SERVER['PHP_SELF']) == "setup_preview.php") echo "background-color:#F05729;"?>" >Preview</p>
            </td>
        </tr>
</table>
<br><br>