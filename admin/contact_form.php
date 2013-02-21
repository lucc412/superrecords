<?php
session_start();
    include 'common/varDeclare.php';
    require_once("common/class.Database.php");
    $db = new Database();
?>
                <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.4.2.min.js"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-ui-1.8.custom.min.js"></script>
                <LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
                <LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
                <style>
                    body {
                        background: none;
                    }
                </style>

<script>
    function saveFlag() {
              var cCode = $('#con_Company').val();
              $(document).ready(function() {
                     $.ajax({
                        url: "sales_opportunity_ajax.php",
                        type:"POST",
                        cache: false,
                        async:false,
                        data:{code:cCode,type:'con'},
                        success: function(msg){
                            var msg_split = msg.split("~~");
                            //alert(msg_split[1]);
                            opener.document.getElementById('cso_contact').innerHTML = msg_split[1];
                            self.close();
                        }
                    });
              });
    }
    function contactValidate() {
        var fname = $('#con_Firstname').val();
        var lname = $('#con_Lastname').val();
        var ubuild = $('#con_Build').val();
        var cemail = $('#con_Email').val();
        if(fname=='') {
            alert('Enter first name');
            $('#con_Firstname').focus();
            return false;
        }
        else if(lname=='') {
            alert('Enter last name');
            $('#con_Lastname').focus();
            return false;
        }
        else if(ubuild=='') {
            alert('Enter build number');
            $('#con_Build').focus();
            return false;
        }
        else if(cemail!='') {
			var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i

            if (filter.test(document.getElementById('con_Email').value)==false)
				  {
						alert("Please enter a valid email address.");
                                                $('#con_Email').focus();
							return false;
				  }
        }
        else return true;
    }
</script>
             <span class="frmheading">Add Record</span>
             <hr size="1" noshade/>   
            <form enctype="multipart/form-data" action="contact_form.php?cli_code=<?php echo $_GET['cli_code'] ?>" method="post" name="contact" onSubmit="return contactValidate()">
                <table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
                    <tr>
                        <td class="hr">Code</td>
                        <td class="dr">
                        <?php echo "New"; ?>
                            <input type="hidden" name="frm_contact" value="Save" />
                            <input type="hidden" name="con_Company" id="con_Company" value="<?php echo $_GET['cli_code']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <?php
                         $sql = "select `cnt_Code` from `cnt_contacttype`  where cnt_Description='Employee'";
                         $res = mysql_query($sql) or die(mysql_error());
                         $contactcode=@mysql_result( $res,0,'cnt_Code') ;
                        ?>
                        <input type="hidden" name="con_Type" value="<?php echo $contactcode;?>">
                    </tr>
                    <tr>
                        <td class="hr">Designation
                        </td>
                        <td class="dr">
                            <select name="con_Designation"><option value="0">Select Designation</option>
                                <?php
                                  $sql = "select `dsg_Code`, `dsg_Description` from `dsg_designation` ORDER BY dsg_Order ASC";
                                  $res = mysql_query($sql) or die(mysql_error());
                                  while ($lp_row = mysql_fetch_assoc($res)){
                                  $val = $lp_row["dsg_Code"];
                                  $caption = $lp_row["dsg_Description"];
                                  if ($row["con_Designation"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                  ?><option value="<?php echo $val ?>"<?php echo $selstr ?>><?php echo $caption ?></option>
                                   <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Salutation
                        </td>
                        <td class="dr">
                            <select name="con_Salutation">
                                <option value="">Select</option>
                                <option value="Mr" <?php if($row['con_Salutation']=="Mr") echo "selected"; ?>>Mr</option>
                                <option value="Ms" <?php if($row['con_Salutation']=="Mrs") echo "selected"; ?>>Mrs</option>
                                <option value="Miss"<?php if($row['con_Salutation']=="Miss") echo "selected"; ?>>Miss</option>
                                <option value="Dr"<?php if($row['con_Salutation']=="Dr") echo "selected"; ?>>Dr</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">First Name<font style="color:red;" size="2">*</font>
                        </td>
                        <td class="dr">
                            <input type="text"  name="con_Firstname" id="con_Firstname" maxlength="100" value="<?php echo stripslashes($row["con_Firstname"]) ?>">
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">First Name of employee</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr" nowrap>Middle Name
                        </td>
                        <td class="dr"><input type="text"  name="con_Middlename" id="con_Middlename" maxlength="100" value="<?php echo stripslashes($row["con_Middlename"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Last Name<font style="color:red;" size="2">*</font></td>
                        <td class="dr">
                            <input type="text" name="con_Lastname" id="con_Lastname" maxlength="100" value="<?php echo stripslashes($row["con_Lastname"]) ?>">
                            <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Last Name of employee</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr" nowrap>Unit/Build Number<font style="color:red;" size="2">*</font></td>
                        <td class="dr">
                        <input type="text" name="con_Build" id="con_Build" maxlength="50" value="<?php echo stripslashes($row["con_Build"]) ?>">
                        <a class="tooltip" href="#"><img src="images/help.png"><span class="help">Street Number</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="hr">Street Name</td>
                        <td class="dr"><input type="text" name="con_Address" maxlength="100" value="<?php echo stripslashes($row["con_Address"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Suburb</td>
                        <td class="dr"><input type="text" name="con_City" maxlength="20" value="<?php echo stripslashes($row["con_City"]) ?>"></td>
                    </tr>
                                                    <tr>
                                                        <td >State</td>
                                                            <td>
                                                                <?php
                                                                $state_query ="select `cst_Code`,`cst_Description` from `cli_state` ORDER BY cst_Description ASC";
                                                                $state_result=mysql_query($state_query) or die(mysql_error());
                                                                  ?>
                                                                <select name="con_State" ><option value="">Select State</option>
                                                                    <?php while($state_row=mysql_fetch_array($state_result)) {
                                                                        $val = $state_row["cst_Code"];
                                                                        $caption = $state_row["cst_Description"];
                                                                        if ($row["con_State"] == $val) {$selstr = " selected"; } else {$selstr = ""; }
                                                                    ?>
                                                                        <option value="<?php echo $state_row['cst_Code']?>"<?php echo $selstr; ?>><?php  echo $caption; ?></option>
                                                                     <?php   } ?>
                                                                 </select>
                                                            </td>
                                                    </tr>

                    <tr>
                        <td class="hr">Post Code</td>
                        <td class="dr"><input type="text" name="con_Postcode" maxlength="20" value="<?php echo stripslashes($row["con_Postcode"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Country</td>
                        <td class="dr"><input type="text"  name="con_Country" maxlength="100" value="<?php echo stripslashes($row["con_Country"]) ?>"></td>
                    </tr>
                    <tr>
                        <td class="hr">Phone</td>
                        <td class="dr"><input type="text" name="con_Phone" maxlength="20" value="<?php echo stripslashes($row["con_Phone"]) ?>" onkeypress='return isNumberKey(event)'></td>
                    </tr>
                    <tr>
                        <td class="hr">Mobile</td>
                        <td class="dr"><input type="text" name="con_Mobile" maxlength="20" value="<?php echo stripslashes($row["con_Mobile"]) ?>" onkeypress='return isNumberKey(event)'></td>
                    </tr>
                    <tr>
                        <td class="hr">Fax</td>
                        <td class="dr"><input type="text" name="con_Fax" maxlength="20" value="<?php echo stripslashes($row["con_Fax"]) ?>" onkeypress='return isNumberKey(event)'></td>
                    </tr>
                    <tr>
                        <td class="hr">Email</td>
                        <td class="dr"><input type="text" name="con_Email" id="con_Email" maxlength="100" value="<?php echo stripslashes($row["con_Email"]) ?>"  size="39"></td>
                    </tr>
                    <tr>
                        <td class="hr">Notes</td>
                        <td class="dr"><textarea cols="35" rows="4" name="con_Notes" ><?php echo stripslashes($row["con_Notes"]) ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="action" value="Save" style="background-color: #047ea7; padding: 5px; color: white; font-weight: bold;"/>
                            <input type="button" value="Cancel" onClick='window.close();' style="background-color: #047ea7; padding: 5px; color: white; font-weight: bold;"/>
                        </td>
                    </tr>
                 </table>
            </form>
<?php
    if($_POST['frm_contact']=='Save') {
        $con_Createdon=date( 'Y-m-d H:i:s' );    
        $sql = "insert into `con_contact` (`con_Type`, `con_Designation`, `con_Salutation`, `con_Firstname`, `con_Middlename`, `con_Lastname`, `con_Company`, `con_Build`, `con_Address`, `con_City`, `con_State`, `con_Postcode`, `con_Country`, `con_Phone`, `con_Mobile`, `con_Fax`, `con_Email`, `con_Notes`, `con_Createdby`, `con_Createdon`) values ('".$_POST["con_Type"]."', '".$_POST["con_Designation"]."', '" .stripslashes(@$_POST["con_Salutation"]) ."', '" .mysql_real_escape_string(@$_POST["con_Firstname"]) ."', '" .mysql_real_escape_string(@$_POST["con_Middlename"]) ."', '" .mysql_real_escape_string(@$_POST["con_Lastname"]) ."', '" .mysql_real_escape_string(@$_POST["con_Company"])."', '" .mysql_real_escape_string(@$_POST["con_Build"]) ."','" .mysql_real_escape_string(@$_POST["con_Address"]) ."', '" .mysql_real_escape_string(@$_POST["con_City"])."', '" .mysql_real_escape_string(@$_POST["con_State"])."', '" .mysql_real_escape_string(@$_POST["con_Postcode"])."', '" .mysql_real_escape_string(@$_POST["con_Country"])."', '" .mysql_real_escape_string(@$_POST["con_Phone"])."', '" .mysql_real_escape_string(@$_POST["con_Mobile"])."', '" .mysql_real_escape_string($_POST["con_Fax"])."', '" .mysql_real_escape_string(@$_POST["con_Email"])."', '" .mysql_real_escape_string(@$_POST["con_Notes"]) ."', '" .$_SESSION['user']."', '" .$con_Createdon."')";
            mysql_query($sql) or die(mysql_error());
            $_SESSION['last_con_id'] = mysql_insert_id();
            echo "<script>saveFlag()</script>";
    }

?>