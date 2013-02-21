<?php
$formcode_report=$commonUses->getFormCode("Custom Worksheet Report");
$access_file_level_report=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode_report);

if($access_file_level_report==0)
{
  echo "<br><br>You are not authorised to view this file.";
  exit;
}


if($_SESSION['Viewall']=="N" && $_SESSION['usertype'] == "Staff")
   $restrict_flag = false;
else
   $restrict_flag = true;

//================== Build Input fields ============

  $rep_qry = "Select id,field_name,display from lookup WHERE report='Worksheet' ORDER BY display asc";
  $rep_result = mysql_query($rep_qry);
  $cont = "";

  while(list($id,$fieldname,$display) = mysql_fetch_array($rep_result))
  {
        $selected = ($_POST['fields'] == $fieldname)?"selected":"";
        $cont .= "<option value='$fieldname' $selected>$display</option>";
        
  }
//=================== End output fields ============

//================== Build Output fields ============

 $sales_qry = "Select id,field,display from worksheet_output ORDER BY display asc";
  $sales_result = mysql_query($sales_qry);
  $sales_cont = "";
  $outputs = $_POST['output_fields'];
  $no = 0;
  $output_array = array();
  while(list($id,$fieldname,$display) = mysql_fetch_array($sales_result))
  {
        $output_array[$no]['fieldname'] = $fieldname;
        $output_array[$no]['display'] = $display;
        /*if(isset($_POST['output_fields']))
        {
          $selected = (in_array($fieldname,$_POST['output_fields']))?"selected":"";
        } */

        //$sales_cont .= "<option value='$fieldname' $selected>$display</option>";
        $no++;
  }

  //=============== This is multiselection with order wise ===========================================
    $filter_array = array();
    for($i=0;$i<count($outputs);$i++)
    {
        for($j=0;$j<count($output_array);$j++)
        {
          if($outputs[$i] == $output_array[$j]['fieldname'])
          {
             $fieldname = $output_array[$j]['fieldname'];
             $display = $output_array[$j]['display'];

             $sales_cont .= "<option value='$fieldname' selected >$display</option>";
             $filter_array[] = $fieldname;
          }
        }
    }
  //====================================================================================================

  for($j=0;$j<count($output_array);$j++)
  {
     $fieldname = $output_array[$j]['fieldname'];
     $display = $output_array[$j]['display'];
     if(!in_array($fieldname,$filter_array))
            $sales_cont .= "<option value='$fieldname' >$display</option>";
  }

//==================  End output fields ====================================

if(isset($_POST['fields1']))
{

  $sql_condition['Equals'] = "=";
  $sql_condition['Not equal to'] = "!=";
  $sql_condition['On'] = "=";
  $sql_condition['Before'] = "<";
  $sql_condition['After'] = ">";
  $sql_condition['Before or On'] = "<=";
  $sql_condition['After or On'] = ">=";
  //$sql_condition['Pending'] = "= 0000-00-00";

    $fields1 = $_POST['fields1'];
    $condition1 = $_POST['condition1'];
    $condition_value1 = $_POST['condition_value1'];
    $compname1 = $_POST['compname1'];

    $fields2 = $_POST['fields2'];
    $condition2 = $_POST['condition2'];
    $condition_value2 = $_POST['condition_value2'];
    $compname2 = $_POST['compname2'];

    $fields3 = $_POST['fields3'];
    $condition3 = $_POST['condition3'];
    $condition_value3 = $_POST['condition_value3'];
    $compname3 = $_POST['compname3'];

    $fields4 = $_POST['fields4'];
    $condition4 = $_POST['condition4'];
    $condition_value4 = $_POST['condition_value4'];
    $compname4 = $_POST['compname4'];

    $fields5 = $_POST['fields5'];
    $condition5 = $_POST['condition5'];
    $condition_value5 = $_POST['condition_value5'];
    $compname5 = $_POST['compname5'];

    $output_fields = $_POST['output_fields'];
    $report_fields = "";

    foreach($output_fields as $f)
    {
        $report_fields .= "'$f',";
    }
    $report_fields = substr($report_fields,0,-1);

    $where_condition = " WHERE 1=1 AND c1.cty_Description !='Discontinued'";
    $script_content = "<script>";
    $person_qry = "";

    $qry_log = 0;
    for($i=1;$i<=5;$i++)
    {
      $cond = "condition".$i;
      $condition = $$cond;

      $cond_value = "condition_value".$i;
      $condition_value = $$cond_value;

       $field_value = "fields".$i;
       $fields = $$field_value;

       $cmpname = "compname".$i;
       $compname = $$cmpname;



            if($condition != "")// && $condition_value != "")
            {
                if(array_key_exists($condition,$sql_condition))
                {
                  $sql_condition_applied = $sql_condition[$condition];
                  if(!is_array($condition_value))
                    $date_format = explode("/",$condition_value);
                  else
                     $date_format = array();

                  if(count($date_format) == 3)
                  {
                    $condition_value = $date_format[2]."-".$date_format[1]."-".$date_format[0];
                    $where_condition .= " AND wrk_worksheet.$fields  != '0000-00-00 00:00:00' ";
                  }

                  if($fields != "wrk_StaffInCharge" && $fields != "wrk_TeamInCharge" && $fields != "wrk_ManagerInChrge" && $fields != "wrk_SeniorInCharge" && $fields != "wrk_MasterActivity" && $fields != "wrk_SubActivity")
                  {
                     if(count($date_format) == 3)
                     {
                        $where_condition .= " AND DATE(wrk_worksheet.$fields) $sql_condition_applied '$condition_value'";
                     }
                    else if($fields=="cli_Category") {
                        $where_condition .= " AND u1.$fields  $sql_condition_applied '$condition_value' ";
                    }
                     else
                     {
                        $where_condition .= " AND wrk_worksheet.$fields $sql_condition_applied '$condition_value'";
                     }

                  }
                  else
                  {
                    if(is_array($condition_value))
                    {

                       $condition_value = implode(",",$condition_value);
                       if($sql_condition_applied == "=")
                          $where_condition .= " AND wrk_worksheet.$fields  IN ($condition_value)";
                        else
                          $where_condition .= " AND wrk_worksheet.$fields  NOT IN ($condition_value) ";

                    }
                    else
                    {
                       $where_condition .= " AND wrk_worksheet.$fields  $sql_condition_applied '$condition_value' ";
                    }

                    $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = wrk_worksheet.$fields
                        LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                    $qry_log = 1;
                  }
                }
                else
                {
                  switch($condition)
                  {
                    case "Starts with":
                        if($fields != "wrk_StaffInCharge" && $fields != "wrk_TeamInCharge" && $fields != "wrk_ManagerInChrge" && $fields != "wrk_SeniorInCharge")
                        {
                            $where_condition .= " AND wrk_worksheet.$fields LIKE '$condition_value%' ";

                        }
                        else
                        {
                          $where_condition .= " AND (con_contact.con_Firstname LIKE '$condition_value%' || con_contact.con_Lastname LIKE '$condition_value%')";
                          $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = wrk_worksheet.$fields
                            LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                         break;
                    case "Contains any part of word":
                        if($fields != "wrk_StaffInCharge" && $fields != "wrk_TeamInCharge" && $fields != "wrk_ManagerInChrge" && $fields != "wrk_SeniorInCharge")
                        {
                          $where_condition .= " AND wrk_worksheet.$fields LIKE '%$condition_value%' ";

                        }
                        else
                        {
                          $where_condition .= " AND (con_contact.con_Firstname LIKE '%$condition_value%' || con_contact.con_Lastname LIKE '%$condition_value%')";
                          $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = wrk_worksheet.$fields
                                LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                         break;
                    case "Contains full word":
                        if($fields != "wrk_StaffInCharge" && $fields != "wrk_TeamInCharge" && $fields != "wrk_ManagerInChrge" && $fields != "wrk_SeniorInCharge")
                        {
                            $where_condition .= " AND wrk_worksheet.$fields LIKE '$condition_value' ";

                        }
                        else
                        {
                           $where_condition .= " AND (con_contact.con_Firstname LIKE '$condition_value' || con_contact.con_Lastname LIKE '$condition_value')";
                           $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = wrk_worksheet.$fields
                                LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                          break;

                      case "Pending":
                          $where_condition .= " AND DATE(wrk_worksheet.$fields) = '0000-00-00' ";
                          break;

                      case "Between dates":
                           $cond_val1 = "condition_value".$i."_from";
                           $cond_vals1 = explode("/",$_POST[$cond_val1]);
                           $cond_value1 = $cond_vals1[2]."-".$cond_vals1[1]."-".$cond_vals1[0];
                           $cond_val2 = "condition_value".$i."_to";
                           $cond_vals2= explode("/",$_POST[$cond_val2]);
                           $cond_value2 = $cond_vals2[2]."-".$cond_vals2[1]."-".$cond_vals2[0];
                          $where_condition .= " AND DATE(wrk_worksheet.$fields) >= '$cond_value1' AND DATE(wrk_worksheet.$fields) <= '$cond_value2' ";
                          $between_script = "select_conditions('Between dates','$i','$_POST[$cond_val1]','$_POST[$cond_val2]');";
                          break;

                  }
                }

                $script_content .= "document.form1.fields$i.value='$fields';
                                      select_fields('$fields','$condition','$condition_value','$i','$compname');
                                      document.form1.condition$i.value='$condition';
                                      $between_script";
            }


    }
     $script_content .= "</script>";
//================== Start Save Conditions =========
if($_POST['hiSave']=="save" || $_POST['hiUpdate']=="update") {
    // condition fields
    $condfields1 = $_POST['fields1'];
    $condfields2 = $_POST['fields2'];
    $condfields3 = $_POST['fields3'];
    $condfields4 = $_POST['fields4'];
    $condfields5 = $_POST['fields5'];
    $condfieldarray = array($condfields1,$condfields2,$condfields3,$condfields4,$condfields5);
    for($i=0; $i<=count($condfieldarray); $i++)
    {
         $conditionfields .= "^".$condfieldarray[$i];
    }
    $conditionfields = substr($conditionfields, 0,-1);
    // conditions
    $condname1 = $_POST['condition1'];
    $condname2 = $_POST['condition2'];
    $condname3 = $_POST['condition3'];
    $condname4 = $_POST['condition4'];
    $condname5 = $_POST['condition5'];
    $condnamearray = array($condname1,$condname2,$condname3,$condname4,$condname5);
    for($i=0; $i<=count($condnamearray); $i++)
    {
         $conditionname .= "^".$condnamearray[$i];
    }
    $conditionname = substr($conditionname, 0,-1);
    // condition value fields
    $condvalue1 = $_POST['condition_value1'];
    $condvalue2 = $_POST['condition_value2'];
    $condvalue3 = $_POST['condition_value3'];
    $condvalue4 = $_POST['condition_value4'];
    $condvalue5 = $_POST['condition_value5'];
    //company name fields
    if($condfields1=="wrk_ClientCode") {
        $condvalue1 = $condvalue1.",".$_POST['compname1'];
    }
    if($condfields2=="wrk_ClientCode") {
        $condvalue2 = $condvalue2.",".$_POST['compname2'];
    }
    if($condfields3=="wrk_ClientCode") {
        $condvalue3 = $condvalue3.",".$_POST['compname3'];
    }
    if($condfields4=="wrk_ClientCode") {
        $condvalue4 = $condvalue4.",".$_POST['compname4'];
    }
    if($condfields5=="wrk_ClientCode") {
        $condvalue5 = $condvalue5.",".$_POST['compname5'];
    }
    // between date conditions
    if($condname1=="Between dates") {
        $condfrm1 = $_POST['condition_value1_from']; $condto1 = $_POST['condition_value1_to'];
        $condvalue1 = $condfrm1.",".$condto1;
    }
    if($condname2=="Between dates") {
        $condfrm2 = $_POST['condition_value2_from']; $condto2 = $_POST['condition_value2_to'];
        $condvalue2 = $condfrm2.",".$condto2;
    }
    if($condname3=="Between dates") {
        $condfrm3 = $_POST['condition_value3_from']; $condto3 = $_POST['condition_value3_to'];
        $condvalue3 = $condfrm3.",".$condto3;
    }
    if($condname4=="Between dates") {
        $condfrm4 = $_POST['condition_value4_from']; $condto4 = $_POST['condition_value4_to'];
        $condvalue4 = $condfrm4.",".$condto4;
    }
    if($condname5=="Between dates") {
        $condfrm5 = $_POST['condition_value5_from']; $condto5 = $_POST['condition_value5_to'];
        $condvalue5 = $condfrm5.",".$condto5;
    }
    if($condfields1=="wrk_MasterActivity" || $condfields1=="wrk_SubActivity" || $condfields1=="wrk_TeamInCharge" || $condfields1=="wrk_StaffInCharge" || $condfields1=="wrk_ManagerInChrge" || $condfields1=="wrk_SeniorInCharge") {  $condvalue1 = implode(',', $condvalue1); }
    if($condfields2=="wrk_MasterActivity" || $condfields2=="wrk_SubActivity" || $condfields2=="wrk_TeamInCharge" || $condfields2=="wrk_StaffInCharge" || $condfields2=="wrk_ManagerInChrge" || $condfields2=="wrk_SeniorInCharge") {  $condvalue2 = implode(',', $condvalue2); }
    if($condfields3=="wrk_MasterActivity" || $condfields3=="wrk_SubActivity" || $condfields3=="wrk_TeamInCharge" || $condfields3=="wrk_StaffInCharge" || $condfields3=="wrk_ManagerInChrge" || $condfields3=="wrk_SeniorInCharge") {  $condvalue3 = implode(',', $condvalue3); }
    if($condfields4=="wrk_MasterActivity" || $condfields4=="wrk_SubActivity" || $condfields4=="wrk_TeamInCharge" || $condfields4=="wrk_StaffInCharge" || $condfields4=="wrk_ManagerInChrge" || $condfields4=="wrk_SeniorInCharge") {  $condvalue4 = implode(',', $condvalue4); }
    if($condfields5=="wrk_MasterActivity" || $condfields5=="wrk_SubActivity" || $condfields5=="wrk_TeamInCharge" || $condfields5=="wrk_StaffInCharge" || $condfields5=="wrk_ManagerInChrge" || $condfields5=="wrk_SeniorInCharge") {  $condvalue5 = implode(',', $condvalue5); }
    $condvaluearray = array($condvalue1,$condvalue2,$condvalue3,$condvalue4,$condvalue5);
    for($i=0; $i<=count($condvaluearray); $i++)
    {
         $conditionvalue .= "^".$condvaluearray[$i];
    }
    $conditionvalue = substr($conditionvalue, 0,-1);
    // output fields
    $outputname = $_POST['output_fields'];
    for($i=0; $i<=count($outputname); $i++)
    {
         $outputfields .= "^".$outputname[$i];
    }
    $outputfields = substr($outputfields, 0,-1);
        if($_POST['hiUpdate']=="update") {
            $qry = "UPDATE cwr_customwrkreportsave SET cwr_Title='".str_replace("'", "''", $_POST['cwr_Title'])."',cwr_Fields='".$conditionfields."',cwr_Conditions='".$conditionname."',cwr_Values='".$conditionvalue."',cwr_OutputFields='".$outputfields."' WHERE cwr_SCode=".$_SESSION['staffcode']." AND cwr_Code=".$_POST['saveid'];
            mysql_query($qry);
        }
        // insert datas
        if($_POST['hiSave']=="save") {
            $query = "INSERT INTO `cwr_customwrkreportsave` (cwr_SCode,cwr_Title,cwr_Fields,cwr_Conditions,cwr_Values,cwr_OutputFields) VALUES (".$_SESSION['staffcode'].",'".str_replace("'", "''", $_POST['cwr_Title'])."','".$conditionfields."','".$conditionname."','".$conditionvalue."','".$outputfields."')";
            mysql_query($query);
        }
}
//================== End Save Conditions ===========

    //==================== Build OUTPUT fields ==================================================================
    $field_qry =  $cond_qry = "";
    $field_array = array();
    /*
     $field_array[] = "cli_Flag";
     $field_array[] = "cli_Marked";
     */
    $qry = "SELECT ";

    foreach($output_fields as $f)
    {
      $select_qry = "SELECT field,display,lookup_table1,lookup_field1,condition_field1,alias_name from worksheet_output
                    WHERE
                    field = '$f' ";
      $select_result = mysql_query($select_qry);




      list($field,$display,$lookup_table1,$lookup_field1,$condition_field1,$alias_name) = mysql_fetch_row($select_result);


          if($field != "wrk_StaffInCharge" && $field != "wrk_TeamInCharge" && $field != "wrk_ManagerInChrge" && $field != "wrk_SeniorInCharge")
          {
                //$field_qry .= ($lookup_table1 != "")?"$lookup_table1.$lookup_field1,":"cli_client.$field,";
                if($lookup_table1 != "")
                {
                  if($alias_name == "")
                  {
                    if($field == "cli_ServiceRequired")
                    {
                      $field_qry .= "(wrk_worksheet.cli_Code) AS Service_Required,";
                      $field_array[] = "Service_Required";
                    }
                    else
                    {
                      $field_qry .= "$lookup_table1.$lookup_field1,";
                      $field_array[] = $lookup_field1;
                    }
                  }
                  else
                  {
                     $field_qry .= "($lookup_table1.$lookup_field1) AS $alias_name,";
                     $field_array[] = $alias_name;
                  }
                }
                else if($field=="cli_Category") {
                    $field_qry .= "u1.$field,";
                    $field_array[] = $field;
                }
                else
                {

                    $field_qry .= "wrk_worksheet.$field,";
                    $field_array[] = $field;
                }
          }
          else
          {
              /*$field_qry .= "CONCAT_WS(' ',con_Firstname,con_Lastname),";
              if($qry_log == 0)
              {
              $cond_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = cli_client.$field
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
$qry_log=1;
              }*/
              $field_qry .= "wrk_worksheet.$field,";
              $field_array[] = $field;
          }

        if($lookup_table1 != "")
        {
            $cond_qry  .= " LEFT OUTER JOIN $lookup_table1 ON $lookup_table1.$condition_field1 = wrk_worksheet.$field ";
        }

        $table_head .= "<th>$display</th>";
        $excel_header .= "$display \t ";
        $_SESSION['header'] .= $display;

    }

   // print_r($field_array);

    $field_qry = substr($field_qry,0,-1);
    //$cond_qry .= $person_qry;

    if(!$restrict_flag)
    {
      $where_condition .= " AND (wrk_worksheet.wrk_StaffInCharge = '$_SESSION[staffcode]' || wrk_worksheet.wrk_TeamInCharge = '$_SESSION[staffcode]' || wrk_worksheet.wrk_ManagerInChrge = '$_SESSION[staffcode]' || wrk_worksheet.wrk_SeniorInCharge = '$_SESSION[staffcode]')";
    }

    $count_qry = "SELECT ".$field_qry." FROM wrk_worksheet LEFT OUTER JOIN `jos_users` AS u1 ON (wrk_worksheet.`wrk_ClientCode` = u1.`cli_Code`) LEFT OUTER JOIN `cty_clienttype` AS c1 ON ( u1. `cli_Type` = c1. `cty_Code` ) $cond_qry $where_condition";
    $count_result = mysql_query($count_qry);
   // echo mysql_error();
    $row_count = mysql_num_rows($count_result);

    //Define Pagination details ====================
      $row_per_page = 20;
      $min_page = 1;
      $max_page = ceil($row_count/$row_per_page);
      $page = $_GET['page'];
      $page_no = ($page != "")?$page:"1";
      $page_cont = "";
      $page_limit = (($page_no-1)*$row_per_page);
      /*for($i=$min_page;$i<=$max_page;$i++)
      {

          if($i == "1" )
          {

              if($i == $page_no)
                  $page_cont .= "First &nbsp; Prev &nbsp;";
              else
                  $page_cont .= "<a href='javascript:;' onclick='return pagination(1);'>First</a>&nbsp;";
          }
          else if($i == $max_page )
          {

              if($i == $page_no)
                  $page_cont .= "Next &nbsp; Last &nbsp;";
              else
                  $page_cont .= "<a href='javascript:;'onclick='return pagination($max_page);'>Last</a>&nbsp;";
          }
          else
          {
               $prev = ($i-1 == 0)?1:$i-1;
               $next = ($i+1 > $max_page)?$max_page:$i+1;
              $page_cont .= "<a href='javascript:;' onclick='return pagination($prev);'>Prev</a>&nbsp;<a href='javascript:;' onclick='return pagination($next);'>Next</a>&nbsp;";
          }


      }*/
        if($max_page > 1)
        {
          if($page_no == "1" )
          {
               $next = ($page_no+1 > $max_page)?$max_page:$page_no+1;
               $page_cont .= "<img src='images/pagination-far-left.png' > &nbsp; <img src='images/pagination-left.png' >  &nbsp; <a href='javascript:;' onclick='return pagination($next,$_GET[aid]);'><img src='images/pagination-right.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($max_page,$_GET[aid]);'><img src='images/pagination-far-right.png' > </a>&nbsp;";

          }
          else if($page_no == $max_page )
          {
                 $prev = ($page_no-1 == 0)?1:$page_no-1;
                  $page_cont .= "<a href='javascript:;' onclick='return pagination(1,$_GET[aid]);'><img src='images/pagination-far-left.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($prev,$_GET[aid]);'><img src='images/pagination-left.png' > </a>&nbsp; <img src='images/pagination-right.png' >  &nbsp; <img src='images/pagination-far-right.png' >  &nbsp;";

          }
          else
          {
              $prev = ($page_no-1 == 0)?1:$page_no-1;
              $next = ($page_no+1 > $max_page)?$max_page:$page_no+1;
              $page_cont .= "<a href='javascript:;' onclick='return pagination(1,$_GET[aid]);'><img src='images/pagination-far-left.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($prev,$_GET[aid]);'><img src='images/pagination-left.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($next,$_GET[aid]);'><img src='images/pagination-right.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($max_page,$_GET[aid]);'><img src='images/pagination-far-right.png' > </a>&nbsp;";
          }
      }


    // $field_qry .= (!in_array("cli_FutureContactDate",$field_array))?",cli_client.cli_FutureContactDate":"";
    // $field_qry .= ",cli_client.cli_Flag,cli_client.cli_Marked ";
    // $field_array[] = "cli_FutureContactDate";

    $qry .= $field_qry." FROM wrk_worksheet LEFT OUTER JOIN `jos_users` AS u1 ON (wrk_worksheet.`wrk_ClientCode` = u1.`cli_Code`) LEFT OUTER JOIN `cty_clienttype` AS c1 ON ( u1. `cli_Type` = c1. `cty_Code` ) $cond_qry $where_condition limit $page_limit,$row_per_page";
    $result = mysql_query($qry);
    $_SESSION['query'] = $qry;


    $excel_cont .= "Sno \t $excel_header \r\n";

    //===================== Excel Report ==============================
    $excel_sno=0;
    while($row = mysql_fetch_array($count_result))
    {
      //print_r($row);
      $excel_sno++;
      $excel_cont .= "$excel_sno \t";

      foreach($field_array as $column)
      {
      //  if($column != "cli_Flag" && $column != "cli_Marked")
       // {
            if($column != "wrk_StaffInCharge" && $column != "wrk_TeamInCharge" && $column != "wrk_ManagerInChrge" && $column != "wrk_SeniorInCharge")
         {
            $vals = ($row[$column] != "")?$row[$column]:"-";
         }
         else
         {
             $get_vals = $commonUses->getFirstLastName($row[$column]);
             $vals = ($get_vals != "")?$get_vals:"-";
         }
                if($column == "Service_Required")
                {
                   $ids = $row[$column];
                   $qrys = "SELECT A.svr_Description
                            FROM cli_servicerequired AS A, cli_allservicerequired AS B
                            WHERE B.cli_ServiceRequiredCode = A.svr_Code AND B.cli_ClientCode = '$ids' ";
                   $results = mysql_query($qrys);
                   $valss = "";
                   while(list($descs) = mysql_fetch_array($results))
                   {
                      $valss .= "$descs,";
                   }
                  $vals = substr($valss,0,-1);
                }
            if($column=="wrk_DueDate" || $column=="wrk_InternalDueDate" || $column=="wrk_ClosedDate" || $column=="wrk_Date" || $column=="wrk_Createdon" || $column=="wrk_Lastmodifiedon" )
            {
               if($row[$column]!="0000-00-00 00:00:00") {
                $vals = date('d-M-Y',strtotime($row[$column]));
                if($vals=="01-Jan-1970") { $vals = ""; }
               }
               else { $vals = ""; }
            }

        $vals = preg_replace("/[\n|\r]/"," ",$vals);
        $excel_cont .= " $vals \t ";
       // }
      }

      $excel_cont .= " \r\n";

    }


     $table_content = "<table width='100%' cellpadding='5' class='fieldtable' align='center'><tr class='fieldheader'><th width='20'>Sno</th>$table_head</tr>";
    $sno=$page_limit;
   //====== Excel Report end================================


    while($row = mysql_fetch_array($result))
    {
      //print_r($row);
      $sno++;
      $table_content .= "<tr><td>$sno</td>";


      foreach($field_array as $column)
      {

         if($column != "wrk_StaffInCharge" && $column != "wrk_TeamInCharge" && $column != "wrk_ManagerInChrge" && $column != "wrk_SeniorInCharge" )
         {
             if($row[$column] != "")
            {
              $split_array = explode("-",$row[$column]);
              if(count($split_array) == 3)
              {
                 // $vals = date("d-m-Y h:i:s", strtotime($row[$column]));
                  $split_column = explode(" ",$split_array[2]);
                  $vals = $split_column[0]."-".$split_array[1]."-".$split_array[0]." ".$split_column[1];
              }
              else
              {
                if($column == "Service_Required")
                {
                   $ids = $row[$column];
                   $qrys = "SELECT A.svr_Description
                            FROM cli_servicerequired AS A, cli_allservicerequired AS B
                            WHERE B.cli_ServiceRequiredCode = A.svr_Code AND B.cli_ClientCode = '$ids' ";
                   $results = mysql_query($qrys);
                   $valss = "";
                   while(list($descs) = mysql_fetch_array($results))
                   {
                      $valss .= "$descs,";
                   }
                  $vals = substr($valss,0,-1);
                }
                else
                {
                   $vals = $row[$column];
                }
              }
            }
            else
            {
                $vals = "";
            }
            if($column=="wrk_DueDate" || $column=="wrk_InternalDueDate" || $column=="wrk_ClosedDate" || $column=="wrk_Date" || $column=="wrk_Createdon" || $column=="wrk_Lastmodifiedon" )
            {
               if($row[$column]!="0000-00-00 00:00:00") {
                $vals = date('d-M-Y',strtotime($row[$column]));
                if($vals=="01-Jan-1970") { $vals = ""; }
               }
               else { $vals = ""; }
            }
            $table_content .= "<td>$vals</td>";

         }
         else if($column == "wrk_StaffInCharge" || $column == "wrk_TeamInCharge" || $column  == "wrk_ManagerInChrge" || $column  == "wrk_SeniorInCharge")
         {
             $get_vals = $commonUses->getFirstLastName($row[$column]);
             $vals = ($get_vals != "")?$get_vals:"-";
             $table_content .= "<td>$vals</td>";
         }
         else
         {
            $table_content .= "";
         }


      }
      $table_content .= "</tr>";
    }


    $table_content .= "</table>";
     $_SESSION['query'] .= $vals;

    if(file_exists("custom_worksheet_report.xls"))
    {
      unlink("custom_worksheet_report.xls");
    }
    $fp = fopen("custom_worksheet_report.xls","a+");
    fwrite($fp,$excel_cont);
    fclose($fp);

    if($row_count >0 )
    {
      $startpage = $page_limit+1;
      $total_rec = "<b>Result :</b> $startpage - $sno records Out of $row_count";
      $extra_options = '<img border="0" align="middle" width="68" height="61" name="Print" alt="Print" style="margin-top: -7px;" src="images/excel1.jpg" onclick="window.location=\'excel_report.php?type=custom_worksheet_report\';" />';
    }
    else
    {
        $total_rec = "<b>Result</b> : No records found";
    }
}
?>