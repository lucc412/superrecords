<?php

  if($_SESSION['validUser'])
  {
  if (isset($_GET["conorder"])) $conorder = @$_GET["conorder"];
  $_SESSION["conorder"] = $conorder;
  if (isset($_GET["contype"])) $conordtype = @$_GET["contype"];
  $_SESSION["contype"] = $conordtype;
  if (isset($_POST["confilter"])) $confilter =str_replace("\'","'",stripslashes(@$_POST["confilter"])) ;
  $_SESSION["confilter"] = $confilter;
  if (isset($_POST["confilter_field"])) $confilterfield = @$_POST["confilter_field"];
  $_SESSION["confilter_field"] = $confilterfield;
  $wholeonly = false;
  if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
  if (!isset($conorder) && isset($_SESSION["conorder"])) $conorder = $_SESSION["conorder"];
  if (!isset($conordtype) && isset($_SESSION["contype"])) $conordtype = $_SESSION["contype"];
  if (!isset($confilter) && isset($_SESSION["confilter"])) $confilter = $_SESSION["confilter"];
  if (!isset($confilterfield) && isset($_SESSION["confilter_field"])) $confilterfield = $_SESSION["confilter_field"];
?>
<title>Client Contact</title>
<meta name="generator" http-equiv="content-type" content="text/html">
<link type="text/css" href="<?php echo $styleSheet; ?>contact.css" rel="stylesheet" />
<!-- <script type="text/javascript" src="<?php echo $javaScript; ?>contact.js"></script> -->
<script type="text/javascript">
 function validateFormOnSubmit()
{
            if(enterkeycodeflag==1)
			{
			enterkeycodeflag=0;
			return (false);
			}
			else
			{
			// do field validation
			typecodeindex=document.contact.con_Type.selectedIndex
 			if(document.contact.con_Firstname.value == "") {
 				alert( "Enter the First Name" );
				document.contact.con_Firstname.focus();
				return(false);
			}
			else if(document.contact.con_Lastname.value == "") {
				alert( "Enter the Last Name" );
				document.contact.con_Lastname.focus();
				return(false);
			}
			else if (document.contact.con_Email.value != "" )
			{
			var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i

				 if (filter.test(document.contact.con_Email.value)==false)
				  {
						alert("Please enter a valid email address.");
						  document.contact.con_Email.focus();
							var a = true; return false;
				  }
  			}


			else {
				document.contact.submit();
				return(true);
			}
			}
}
 function isNumberKey(evt)
                {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    //alert(charCode);
                    if(charCode==67 || charCode==86 || charCode==99 || charCode==118)
                        return true;
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                    return true;
                }

function ComfirmContact(acon,arec,acli){
   var rc=confirm("Are you sure you want to cancel?");
   if(rc==true){

      window.location = "cli_client.php?a="+acon+"&recid="+arec+"&cli_code="+acli+"&con=reset&process=contact";

   }else{

      return false;
   }
}

</script>

<?php
  //Get FormCode
  $formcode = $commonUses->getFormCode("Client Contact");

  //Call CheckAccess function by passing $_SESSION of staff code and form code
  $access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
  if($access_file_level==0)
  {
    //If View, Add, Edit, Delete all set to N
    echo "You are not authorised to view this file.";
  }
  else if(is_array($access_file_level)==1)
  {
    $conshowrecs = 20;
    $pagerange = 10;
    $con = @$_GET["con"];
    $con_recid = @$_GET["conrecid"];
    $page = @$_GET["conpage"];
    if (!isset($page)) $page = 1;
    $con_sql = @$_POST["consql"];
    $conmode=@$_GET["conmode"];
    if($conmode=="delete_contact")
     if($access_file_level['stf_Delete']=="Y")
	 {    
            $ClientDbcontent->sql_delete_contact($_REQUEST['conrecid']);
	 }
	 else
	 {
            echo "You are not authorised to delete the record.";
	 }
           if($con_sql) queryContact();
           if($con) mainContact();
              if (isset($conorder)) $_SESSION["conorder"] = $conorder;
              if (isset($conordtype)) $_SESSION["contype"] = $conordtype;
              if (isset($confilter)) $_SESSION["confilter"] = $confilter;
              if (isset($confilterfield)) $_SESSION["confilter_field"] = $confilterfield;
              if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;
                if ($con == "reset") {
                    $_SESSION["confilter"] = "";
                    $_SESSION["confilter_field"] = "";
                    $_SESSION["conorder"] = "";
                    $_SESSION["contype"] = "";
                }
  } 
}  
else
{
header("Location:index.php?msg=timeout");
}
        // add, update
        function queryContact()
        {
            global $ClientDbcontent;
            global $_POST;
            
          switch ($_POST["consql"]) {
            case "insert":
              $ClientDbcontent->sql_insert_contact();
              break;
            case "update":
              $ClientDbcontent->sql_update_contact();
              break;
           }
            
        }

           function mainContact()
           {
              global $clientContentlist;
              global $access_file_level;
               switch ($_GET["con"]) {
                case "add_contact":
                  if($access_file_level['stf_Add']=="Y")
                      {
                        $clientContentlist->addrec_contact();
                      }
                      else
                      {
                        echo "You are not authorised to add a record.";
                      }
                    break;
                case "view_contact":
                     if($access_file_level['stf_View']=="Y")
                      {
                            $clientContentlist->viewrec_contact($con_recid,$access_file_level);
                      }
                       else
                      {
                        echo "You are not authorised to view the record.";
                      }
                  break;
                case "edit_contact":
                     if($access_file_level['stf_Edit']=="Y")
                      {
                            $clientContentlist->editrec_contact($con_recid);
                      }
                       else
                      {
                        echo "You are not authorised to edit record.";
                      }
                  break;
                case "reset":
                     if($access_file_level['stf_View']=="Y")
                      {
                           $clientContentlist->select_contact($access_file_level);
                      }
                       else
                      {
                        echo "You are not authorised to view the record.";
                      }
                       break;
              }
           }

?>
