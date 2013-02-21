<?php
session_start();
include("common/class.Database.php");
$conn = new Database();

$conditions['Auto'] = array("Equals");
$conditions['Normal'] = array("Equals","Not equal to","Starts with","Contains any part of word","Contains full word");
$conditions['Strict'] = array("Equals","Not equal to");
$conditions['Date'] = array("On","Before","After","Before or On","After or On","Between dates");
$conditions['Date_pending'] = array("On","Before","After","Before or On","After or On","Between dates","Pending");
  
  $report =  $_POST['report'];
  $process_type =  $_POST['process_type'];
  
  if($process_type == "select_fields")
  {
    $selected_field = $_POST['field'];
    $condition_value = $_POST['condition_value'];
    $compname = $_POST['compname'];
    $field_count = $_POST['field_count'];
    $condition = $_POST['condition'];
    $rep_qry = "Select condition_type,lookup_table1,lookup_field1,lookup_table2,lookup_field2,condition_value_type,dropdown_fields,order_by from lookup WHERE field_name ='$selected_field' ";
    $rep_result = mysql_query($rep_qry);
    
    list($condition_type,$lookup_table1,$lookup_field1,$lookup_table2,$lookup_field2,$condition_value_type,$dropdown_fields,$order_by) = mysql_fetch_row($rep_result);
    
    switch($condition_type)
    {
      case "Auto":
          $cont = "";
          foreach($conditions['Auto'] as $val)
          {
                $selected = ($condition == $val)?"selected":"";
                $cont .= "<option value='$val' $selected>$val</option>";
          }
          $element_name = "condition_value$field_count";
          $cname = "compname$field_count";
            $cont .= "~~<input type='text'  name='$cname' id='$cname' value='$compname' /><input type='hidden'  name='$element_name' id='clientid' value='$condition_value' />~~auto";
          break;

        case "Normal":
          $cont = "";
          foreach($conditions['Normal'] as $val)
          {
                $selected = ($condition == $val)?"selected":"";  
                $cont .= "<option value='$val' $selected>$val</option>";
          }
          $element_name = "condition_value$field_count";   
            $cont .= "~~<input type='text'  name='$element_name' id='$element_name' value='$condition_value' />";
     
          break;
      case "Strict":
          $cont = "";
          //============== Array Flag for multiple selection of Staff ==========================
          $array_flag = false;
          foreach($conditions['Strict'] as $val)
          {
                $selected = ($condition == $val)?"selected":"";
                $cont .= "<option value='$val' $selected>$val</option>";
          }
          if($lookup_table1 != "" && $condition_value_type == "dropdown")
          {
              $element_name = "condition_value$field_count";
              if($selected_field != "wrk_StaffInCharge" && $selected_field != "wrk_TeamInCharge" && $selected_field != "wrk_ManagerInChrge" && $selected_field != "wrk_SeniorInCharge")
              {
                $orderby = explode(",",$dropdown_fields);
                $lookup_qry = "SELECT $dropdown_fields from $lookup_table1 Order By $order_by ASC";
                $cont .= "~~<select name='".$element_name."' id='$element_name' >";
                $array_flag = false;
              }
              else
              {
                  switch ($selected_field) {
                      case 'wrk_StaffInCharge':
                          $staff_desig = "1=1";
                          break;
                      case 'wrk_TeamInCharge':
                          $staff_desig = "1=1";
                          break;
                      case 'wrk_ManagerInChrge':
                          $staff_desig = "con_contact.con_Designation=17";
                          break;
                      case 'wrk_SeniorInCharge':
                          $staff_desig = "1=1";
                          break;
                  }
                $lookup_qry = "SELECT stf_staff.stf_Code,CONCAT_WS(' ',con_contact.con_Firstname,con_contact.con_Lastname) from stf_staff LEFT OUTER JOIN aty_accesstype ON stf_staff.stf_AccessType = aty_accesstype.aty_Code LEFT OUTER JOIN con_contact ON stf_staff.stf_CCode = con_contact.con_Code WHERE $staff_desig AND aty_accesstype.aty_Description LIKE '%Staff%' GROUP BY con_contact.con_Code ORDER BY con_contact.con_Firstname ASC";
                $cont .= "~~<select name='".$element_name."[]' id='$element_name' multiple size='10' >";
                $condition_value_array = explode(",",$condition_value);
                $array_flag = true;
              }
              
              $lookup_result = mysql_query($lookup_qry);
              
              
              while($row = mysql_fetch_array($lookup_result))
              {
                 if($array_flag)
                 {
                     $selected = (in_array($row[0],$condition_value_array))?"selected":"";
                            
                 }
                 else
                 {
                      $selected = ($condition_value == $row[0])?"selected":"";
                 }
                 $cont .= "<option value='$row[0]' $selected>$row[1]</option>";
              }
              
              $cont .= "</select>";              
          }
          if($selected_field=="cli_Category" && $condition_value_type == "dropdown") {
              $element_name = "condition_value$field_count";
              $chargeval = $condition_value;
              $cont .= "~~<select name='".$element_name."' id='".$element_name."'>";
              if($chargeval=='1') $first_select = 'selected';
              if($chargeval=='2') $second_select = 'selected';
              if($chargeval=='3') $third_select = 'selected';
              $cont .= "<option value='1' $first_select>1</option>";
              $cont .= "<option value='2' $second_select>2</option>";
              $cont .= "<option value='3' $third_select>3</option>";
              $cont .= "</select>";
          }
          if($lookup_table1 != "" && $condition_value_type == "MultipleSelect")
          {
              $element_name = "condition_value$field_count";
              if($selected_field != "wrk_StaffInCharge" && $selected_field != "wrk_TeamInCharge" && $selected_field != "wrk_ManagerInChrge" && $selected_field != "wrk_SeniorInCharge")
              {
                $orderby = explode(",",$dropdown_fields);
                $lookup_qry = "SELECT $dropdown_fields from $lookup_table1 Order By $order_by ASC";
                $cont .= "~~<select name='".$element_name."[]' id='$element_name' multiple>";
                $condition_value_array = explode(",",$condition_value);
                $array_flag = true;
              }
              $lookup_result = mysql_query($lookup_qry);


              while($row = mysql_fetch_array($lookup_result))
              {
                 if($array_flag)
                 {
                     $selected = (in_array($row[0],$condition_value_array))?"selected":"";

                 }
                 else
                 {
                      $selected = ($condition_value == $row[0])?"selected":"";
                 }
                 $cont .= "<option value='$row[0]' $selected>$row[1]</option>";
              }

              $cont .= "</select>";
          }

          break;
      case "Date":
           $cont = "";
          foreach($conditions['Date'] as $val)
          {
                $selected = ($condition == $val)?"selected":"";
                $cont .= "<option value='$val' $selected>$val</option>";
          }
          $element_name = "condition_value$field_count";
          
          $date_format = explode("-",$condition_value);
            
            if(count($date_format) == 3)
            {
              $condition_value = $date_format[2]."/".$date_format[1]."/".$date_format[0];
            }
          if($condition == "Between Dates")
          {
            $element_name_from = "condition_value$field_count'_from'";
            $element_name_to = "condition_value$field_count'_to'";  
            $cont .= "~~<input type='text'  name='$element_name_from' id='$element_name_from' value='$condition_value' /><a href=javascript:NewCal('$element_name_from','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a><br><input type='text'  name='$element_name_to' id='$element_name_to' value='$condition_value' /><a href=javascript:NewCal('$element_name_to','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
          }
          else
          {    
          $cont .= "~~<input type='text'  name='$element_name' id='$element_name' value='$condition_value' class='datepicker' /><a href=javascript:NewCal('$element_name','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
          } 
          break;            
          
      case "Date_pending":
           $cont = "";
          foreach($conditions['Date_pending'] as $val)
          {
                $selected = ($condition == $val)?"selected":"";
                $cont .= "<option value='$val' $selected>$val</option>";
          }
          $element_name = "condition_value$field_count";
          
          $date_format = explode("-",$condition_value);
            
          if(count($date_format) == 3)
          {
            $condition_value = $date_format[2]."/".$date_format[1]."/".$date_format[0];
          }
          if($condition == "Pending")
          {  
            $cont .= "~~<input type='text'  name='$element_name' id='$element_name' value='date is null'  readonly />";
          } 
          else if($condition == "Between Dates")
          {
            $element_name_from = "condition_value$field_count'_from'";
            $element_name_to = "condition_value$field_count'_to'";  
            $cont .= "~~<input type='text'  name='$element_name_from' id='$element_name_from' value='$condition_value' /><a href=javascript:NewCal('$element_name_from','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a><br><input type='text'  name='$element_name_to' id='$element_name_to' value='$condition_value' /><a href=javascript:NewCal('$element_name_to','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
          } 
          else
          {
              $cont .= "~~<input type='text'  name='$element_name' id='$element_name' value='$condition_value' /><a href=javascript:NewCal('$element_name','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
          }
          break;                  
    }
  }
  
  if($process_type == "between_dates")
  {
      $field_count = $_POST['field_count'];
      $element_name_from = "condition_value$field_count"."_from";
      $element_name_to = "condition_value$field_count"."_to";  
      $cont = "<label>From: </label><input type='text'  name='$element_name_from' id='$element_name_from' value='$condition_value' readonly /><a href=javascript:NewCal('$element_name_from','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a><br><label>To: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type='text'  name='$element_name_to' id='$element_name_to' value='$condition_value' readonly /><a href=javascript:NewCal('$element_name_to','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
  }
  echo $cont;
?>