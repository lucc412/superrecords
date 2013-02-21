<?php
ob_start();
include 'common/varDeclare.php';
include("dbclass/commonFunctions_class.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
<title>Tickets Report</title>
<style type="text/css">
   @media print {

        p#printscreen {
            display:block;
        }
        div#notprint {
            display:none;
        }
        td#notprint {
            display:none;
        }
		    th#notprint {
            display:none;
        }
       
  } 
</style>
</head>

<body>
<?php
require_once "includes/header.php";
include 'dbclass/custom_cases_report_class.php';

?>
<div id="notprint" align="left">
<form name="form1" method="post" >
 
<table cellpadding="10" width="90%"  align="left">
 <tr>
    <td colspan="4" height="40" align="left"><span class="frmheading">Custom Tickets Report</span></td>
  </tr>
                      <tr>
                                    <td><b>Choose the Report</b></td>
                                    <td>
                                        <select name="cas_Report" onChange="return saveCondition('<?php echo $_SESSION['staffcode']; ?>',this.value)">
                                            <option value="0">Select the report</option>
                                            <?php
                                                $query = "SELECT cas_Code,cas_Title FROM cas_customcasesreportsave WHERE cas_CCode=".$_SESSION['staffcode'];
                                                $result = mysql_query($query);
                                                while($reptitle = mysql_fetch_array($result))
                                                {
                                                 if(($reptitle['cas_Code']==$_POST['saveid'])) echo $sr = "selected"; else $sr = ""  ;
                                            ?>
                                            <option value="<?php echo $reptitle['cas_Code']; ?>" <?php echo $sr; ?>><?php echo $reptitle['cas_Title']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="stfcode" value="<?php echo $_SESSION['staffcode']; ?>">
                                    </td>
                                    <td>&nbsp;<div id="img_load" >&nbsp;</div></td>
                      </tr>
                      <tr><td></td></tr>

  <tr>
   
    <td valign="top"> 
        <b>Condition fields</b> <br>
         <select name="fields1" id="fields1" onchange="return select_fields(this.value,'','','1','');">
          <option value="">Select fields</option>
          <?php echo $cont; ?>          
         </select>
    </td>
    <td valign="top">
        <b>Conditions</b> <br>
       <select name="condition1" id="condition1" onchange="return select_conditions(this.value,'1','','');">
        <option value="">Select</option>
        
       </select>
    </td>
    <td valign="top">
        <b>Value</b> <br> 
        <div id="value_for_condition1">
          <input type="text" name="condition_value1" id="condition_value1" />
        </div>
    </td>
    <td valign="top" rowspan="5">
       <b> Output fields</b> <br>
       <select name="output_fields[]" id="output_fields" class="multiselect" multiple="multiple" >
          <?php echo $sales_cont; ?>
       </select> <br>
       <b>NOTE:</b>&nbsp;Click "+" on fieldname to select.
    </td>
  </tr>
  <tr>
     <td valign="top"> 
         <select name="fields2" id="fields2" onchange="return select_fields(this.value,'','','2','');">
          <option value="">Select fields</option>
          <?php echo $cont; ?>          
         </select>
    </td>
    <td valign="top">
     
       <select name="condition2" id="condition2" onchange="return select_conditions(this.value,'2','','');">
        <option value="">Select</option>
        
       </select>
    </td>
    <td valign="top">
      
        <div id="value_for_condition2">
          <input type="text" name="condition_value2" id="condition_value2" />
        </div>
    </td>
  </tr>
  <tr>
     <td valign="top"> 
      
         <select name="fields3" id="fields3" onchange="return select_fields(this.value,'','','3','');">
          <option value="">Select fields</option>
          <?php echo $cont; ?>          
         </select>
    </td>
    <td valign="top">
     
       <select name="condition3" id="condition3" onchange="return select_conditions(this.value,'3','','');">
        <option value="">Select</option>
        
       </select>
    </td>
    <td valign="top">
     
        <div id="value_for_condition3">
          <input type="text" name="condition_value3" id="condition_value3"  />
        </div>
    </td>
  </tr>
  <tr>
     <td valign="top"> 
      
         <select name="fields4" id="fields4" onchange="return select_fields(this.value,'','','4','');">
          <option value="">Select fields</option>
          <?php echo $cont; ?>          
         </select>
    </td>
    <td valign="top">
       
       <select name="condition4" id="condition4" onchange="return select_conditions(this.value,'4','','');">
        <option value="">Select</option>
        
       </select>
    </td>
    <td valign="top">
      
        <div id="value_for_condition4">
          <input type="text" name="condition_value4" id="condition_value4" />
        </div>
    </td>
  </tr>
  <tr>
     <td valign="top"> 
       
         <select name="fields5" id="fields5" onchange="return select_fields(this.value,'','','5','');">
          <option value="">Select fields</option>
          <?php echo $cont; ?>          
         </select>
    </td>
    <td valign="top">
      
       <select name="condition5" id="condition5" onchange="return select_conditions(this.value,'5','','');">
        <option value="">Select</option>
        
       </select>
    </td>
    <td valign="top">
       
        <div id="value_for_condition5">
          <input type="text" name="condition_value5" id="condition_value5" />
        </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" height="20" align="left"><b>NOTE:</b>&nbsp; Please select atleast one conditions and outputs.</td>
  </tr>
                      <tr>
                                    <?php
                                        $query = "SHOW TABLE STATUS LIKE 'cas_customcasesreportsave'";
                                        $result = mysql_query($query);
                                        $maxid = mysql_fetch_array($result);
                                        $mid = $maxid['Auto_increment'];
                                      //  if($_GET['aid']) $mid = $mid-1;
                                    if($_GET['aid']) $sid = $_POST['saveid']; else $sid = $mid;
                                    ?>
                                    <td><b>Save the Current Report as Name</b> : </td>
                                    <td><input type="text" name="cas_Title" id="cas_Title" value="<?php echo $_POST['cas_Title']; ?>">
                                        <input type="hidden" name="saveid" id="saveid" value="<?php echo $sid; ?>">
                                        <input type="hidden" name="maxid" id="maxid" value="<?php echo $mid; ?>">
                                        <input type="hidden" name="hiSave" id="hiSave" value="">
                                        <input type="hidden" name="hiUpdate" id="hiUpdate" value="">
                                    </td>
                                    <td>
                                        <?php if($_POST['cas_Title']=="") { ?>
                                        <div id="butSave">
                                            <input type="submit" name="save_button" value="Save" onClick="return saveSubmit();">
                                        </div>
                                        <?php } if(($_GET['aid'] || $_GET['page']) && $_POST['cas_Title']!="") { ?>
                                        <div id="saveAs" style="position:relative; top: 10px;">
                                            <input type="submit" name="save_button" value="Save As New" onClick="return saveasSubmit();">
                                        </div>
                                        <?php } ?>
                                        <div id="saveAsreport" style="display:none; position:relative; top: 10px;">
                                            <input type="submit" name="save_button" value="Save As New" onClick="return saveasSubmit();">
                                        </div>
                                        <div id="butUpdate" style="display:none; position:relative; top:-11px; left:120px;">
                                            <input type="submit" name="update_button" value="Update" onClick="return updateSubmit();">
                                        </div>
                                        <?php if($_GET['aid'] && $_POST['cas_Title']) { ?>
                                        <div id="sUpdate" style="position:relative; top:-11px; left:120px;">
                                            <input type="submit" name="update_button" value="Update" onClick="return updateSubmit();">
                                        </div>
                                       <?php } ?>
                                    </td>
                      </tr>

    <tr>
    <td colspan="4" height="20" align="center"></td>
  </tr>
  <tr>
     <td colspan="4" height="50" align="center"><input type="button" name="view" value="Generate Report" onclick="return validation();" />&nbsp;&nbsp;<input type="button" name="view" value="Reset Filter" onclick="window.location='custom_cases_report.php';" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
</table>
<div id="mm"></div>
</form>
 </div>

<div id="showgrid" style="clear:both;padding-top:30px;">
<table width="100%">
<tr>
  <td align="left" width="600">
  <label style="text-align:center;font-family:Arial,Tahoma,Verdana,Helvetica,sans-serif;font-size:12px;"><?php echo $total_rec; ?></label>
  </td>
  <?php $_SESSION['totalcount'] =  $row_count; ?>
  <td><?php echo $extra_options; ?></td>
  <td align="center">
  <?php echo $page_cont; ?>
  </td>
</tr>
</table>
<br>
<?php echo $table_content; ?>
</div>

<script language="JavaScript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo $styleSheet; ?>jquery-ui-1.7.2/themes/base/ui.all.css" />
	<link type="text/css" href="<?php echo $styleSheet; ?>ui.multiselect.css" rel="stylesheet" />
        <link rel="stylesheet" href="as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $javaScript; ?>jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo $javaScript; ?>plugins/localisation/jquery.localisation-min.js"></script>
	<script type="text/javascript" src="<?php echo $javaScript; ?>plugins/scrollTo/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="<?php echo $javaScript; ?>ui.multiselect.js"></script>
        <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $javaScript; ?>custom_cases_report.js"></script>
  <style>
    .multiselect {
height:300px;
width:550px;
}
  </style>
<?php echo $script_content; ?>
</body>
</html>
