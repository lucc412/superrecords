<?php
$formcode_report=$commonUses->getFormCode("Cross Sales Opp Report");
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

  $rep_qry = "Select id,field_name,display from lookup WHERE report='Sales_Opportunity' ORDER BY display asc";
  $rep_result = mysql_query($rep_qry);
  $cont = "";

  while(list($id,$fieldname,$display) = mysql_fetch_array($rep_result))
  {
        $selected = ($_POST['fields'] == $fieldname)?"selected":"";
        if(!$restrict_flag && ($fieldname == "cso_generated_lead" || $fieldname == "cso_sales_person" || $fieldname == "cso_contact_code"))
        {

        }
        else
        {
          $cont .= "<option value='$fieldname' $selected>$display</option>";
        }
  }
//=================== End output fields ============
//================== Build Output fields ============

 $sales_qry = "Select id,field,display from sales_opportunity_output";
  $sales_result = mysql_query($sales_qry);
  $sales_cont = "";
  $outputs = $_POST['output_fields'];
  $no = 0;
  $output_array = array();
  while(list($id,$fieldname,$display) = mysql_fetch_array($sales_result))
  {
        $output_array[$no]['fieldname'] = $fieldname;
        $output_array[$no]['display'] = $display;
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
//print_r($_POST); exit;
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

    $where_condition = " WHERE 1=1";
    //$script_content = "<script>";
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
                    $where_condition .= " AND cso_cross_sales_opportunity.$fields  != '0000-00-00 00:00:00' ";
                  }
                //  echo $fields;
                  if($fields != "cso_generated_lead" && $fields != "cso_sales_person" && $fields != "cso_created_by" && $fields != "cso_modified_by")
                  {
                     if(count($date_format) == 3)
                     {
                        $where_condition .= " AND DATE(cso_cross_sales_opportunity.$fields) $sql_condition_applied '$condition_value'";
                     }
                     else
                     {

                     $where_condition .= " AND cso_cross_sales_opportunity.$fields $sql_condition_applied '$condition_value'";
                    }

                  }
                  else
                  {
                    if(is_array($condition_value))
                    {

                       $condition_value = implode(",",$condition_value);
                       if($sql_condition_applied == "=")
                          $where_condition .= " AND cso_cross_sales_opportunity.$fields  IN ($condition_value)";
                        else
                          $where_condition .= " AND cso_cross_sales_opportunity.$fields  NOT IN ($condition_value) ";

                    }
                    else
                    {
                       $where_condition .= " AND cso_cross_sales_opportunity.$fields  $sql_condition_applied '$condition_value' ";
                    }

                    $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = cso_cross_sales_opportunity.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                    $qry_log = 1;
                   // echo $person_qry;
                  }
                }
                else
                {
                  switch($condition)
                  {
                    case "Starts with":
                        if($fields != "cso_generated_lead" && $fields != "cso_sales_person" && $fields != "cso_created_by" && $fields != "cso_modified_by")
                        {
                            $where_condition .= " AND cso_cross_sales_opportunity.$fields LIKE '$condition_value%' ";

                        }
                        else
                        {
                          $where_condition .= " AND (con_contact.con_Firstname LIKE '$condition_value%' || con_contact.con_Lastname LIKE '$condition_value%')";
                          $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = cso_cross_sales_opportunity.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                         break;
                    case "Contains any part of word":
                        if($fields != "cso_generated_lead" && $fields != "cso_sales_person" && $fields != "cso_created_by" && $fields != "cso_modified_by")
                        {
                          $where_condition .= " AND cso_cross_sales_opportunity.$fields LIKE '%$condition_value%' ";

                        }
                        else
                        {
                          $where_condition .= " AND (con_contact.con_Firstname LIKE '%$condition_value%' || con_contact.con_Lastname LIKE '%$condition_value%')";
                          $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = cso_cross_sales_opportunity.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                         break;
                    case "Contains full word":
                        if($fields != "cso_generated_lead" && $fields != "cso_sales_person" && $fields != "cso_created_by" && $fields != "cso_modified_by")
                        {
                            $where_condition .= " AND cso_cross_sales_opportunity.$fields LIKE '$condition_value' ";

                        }
                        else
                        {
                           $where_condition .= " AND (con_contact.con_Firstname LIKE '$condition_value' || con_contact.con_Lastname LIKE '$condition_value')";
                           $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = cso_cross_sales_opportunity.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                          break;

                      case "Pending":
                          $where_condition .= " AND DATE(cso_cross_sales_opportunity.$fields) = '0000-00-00' ";
                          break;

                      case "Between dates":
                           $cond_val1 = "condition_value".$i."_from";
                           $cond_vals1 = explode("/",$_POST[$cond_val1]);
                           $cond_value1 = $cond_vals1[2]."-".$cond_vals1[1]."-".$cond_vals1[0];
                           $cond_val2 = "condition_value".$i."_to"; 
                           $cond_vals2= explode("/",$_POST[$cond_val2]);
                           $cond_value2 = $cond_vals2[2]."-".$cond_vals2[1]."-".$cond_vals2[0];
                          $where_condition .= " AND DATE(cso_cross_sales_opportunity.$fields) >= '$cond_value1' AND DATE(cso_cross_sales_opportunity.$fields) <= '$cond_value2' ";
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
    if($condfields1=="cso_client_code") {
        $condvalue1 = $condvalue1.",".$_POST['compname1'];
    }
    if($condfields2=="cso_client_code") {
        $condvalue2 = $condvalue2.",".$_POST['compname2'];
    }
    if($condfields3=="cso_client_code") {
        $condvalue3 = $condvalue3.",".$_POST['compname3'];
    }
    if($condfields4=="cso_client_code") {
        $condvalue4 = $condvalue4.",".$_POST['compname4'];
    }
    if($condfields5=="cso_client_code") {
        $condvalue5 = $condvalue5.",".$_POST['compname5'];
    }
    
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
    if($condfields1=="cso_generated_lead" || $condfields1=="cso_sales_person") {  $condvalue1 = implode(',', $condvalue1); }
    if($condfields2=="cso_generated_lead" || $condfields2=="cso_sales_person") {  $condvalue2 = implode(',', $condvalue2); }
    if($condfields3=="cso_generated_lead" || $condfields3=="cso_sales_person") {  $condvalue3 = implode(',', $condvalue3); }
    if($condfields4=="cso_generated_lead" || $condfields4=="cso_sales_person") {  $condvalue4 = implode(',', $condvalue4); }
    if($condfields5=="cso_generated_lead" || $condfields5=="cso_sales_person") {  $condvalue5 = implode(',', $condvalue5); }
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
    $query = "SELECT cso_SCode,cso_Title FROM cso_salesopportunityreport WHERE cso_SCode=".$_SESSION['staffcode']." AND cso_Code=".$_POST['saveid'];
    $result = mysql_query($query);
    $rowcount = @mysql_num_rows($result);
   // if($rowcount) {
        if($_POST['hiUpdate']=="update") {
            $qry = "UPDATE cso_salesopportunityreport SET cso_Title='".str_replace("'", "''", $_POST['cso_Title'])."',cso_Fields='".$conditionfields."',cso_Conditions='".$conditionname."',cso_Values='".$conditionvalue."',cso_OutputFields='".$outputfields."' WHERE cso_SCode=".$_SESSION['staffcode']." AND cso_Code=".$_POST['saveid'];
            mysql_query($qry);
        }
  //  }
   // else {
        // insert datas
        if($_POST['hiSave']=="save") {
            $query = "INSERT INTO `cso_salesopportunityreport` (cso_SCode,cso_Title,cso_Fields,cso_Conditions,cso_Values,cso_OutputFields) VALUES (".$_SESSION['staffcode'].",'".str_replace("'", "''", $_POST['cso_Title'])."','".$conditionfields."','".$conditionname."','".$conditionvalue."','".$outputfields."')";
            mysql_query($query);
        }
   // }
}
//================== End Save Conditions ===========

    //==================== Build OUTPUT fields ==================================================================
    $field_qry =  $cond_qry = "";
    $field_array = array();
   //  $field_array[] = "cli_Flag";
   //  $field_array[] = "cli_Marked";
    $qry = "SELECT ";

    foreach($output_fields as $f)
    {
      $select_qry = "SELECT field,display,lookup_table1,lookup_field1,condition_field1,alias_name from sales_opportunity_output
                    WHERE
                    field = '$f' ";
      $select_result = mysql_query($select_qry);




      list($field,$display,$lookup_table1,$lookup_field1,$condition_field1,$alias_name) = mysql_fetch_row($select_result);


          if($field != "cso_generated_lead" && $field != "cso_sales_person" && $field != "cso_created_by" && $field != "cso_modified_by")
          {
                if($lookup_table1 != "")
                {
                  if($alias_name == "")
                  {
                    if($field == "cso_service_required")
                    {
                      $field_qry .= "(cso_cross_sales_opportunity.cso_client_code) AS Service_Required,";
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
                else
                {

                    $field_qry .= "cso_cross_sales_opportunity.$field,";
                    $field_array[] = $field;
                }
          }
          else
          {
              $field_qry .= "cso_cross_sales_opportunity.$field,";
              $field_array[] = $field;
          }

        if($lookup_table1 != "")
        {
            $cond_qry  .= " LEFT OUTER JOIN $lookup_table1 ON $lookup_table1.$condition_field1 = cso_cross_sales_opportunity.$field ";
        }
        $table_head .= "<th>$display</th>";
        $excel_header .= "$display \t ";
        $pdf_header .= $display.",";
        $tableheader = explode(',',$pdf_header);
    }
   // print_r($field_array);

    $field_qry = substr($field_qry,0,-1);
    //$cond_qry .= $person_qry;

    if(!$restrict_flag)
    {
      $where_condition .= " AND (cso_cross_sales_opportunity.cso_generated_lead = '$_SESSION[staffcode]' || cso_cross_sales_opportunity.cso_sales_person = '$_SESSION[staffcode]' || cso_cross_sales_opportunity.cso_created_by = '$_SESSION[staffcode]')";
    }

     $count_qry = "SELECT ".$field_qry." FROM cso_cross_sales_opportunity $cond_qry $where_condition";

    $count_result = mysql_query($count_qry);
    //echo mysql_error();
    $row_count = @mysql_num_rows($count_result);

    //Define Pagination details ====================
      $row_per_page = 20;
      $min_page = 1;
      $max_page = ceil($row_count/$row_per_page);
      $page = $_GET['page'];
      $page_no = ($page != "")?$page:"1";
      $page_cont = "";
      $page_limit = (($page_no-1)*$row_per_page);
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


     //$field_qry .= (!in_array("cli_FutureContactDate",$field_array))?",cso_cross_sales_opportunity.cli_FutureContactDate":"";
     $field_qry .= ",cso_cross_sales_opportunity.id,cso_cross_sales_opportunity.cso_client_code ";
    // $field_array[] = "cli_FutureContactDate";

    $qry .= $field_qry." FROM cso_cross_sales_opportunity $cond_qry $where_condition limit $page_limit,$row_per_page";
    $result = mysql_query($qry);
 $_SESSION['query'] = $qry;


    $excel_cont .= "Sno \t $excel_header \r\n";

    //===================== Excel Report ==============================
    $excel_sno=0;
    while($row = @mysql_fetch_array($count_result))
    {
      //print_r($row);
      $excel_sno++;
      $excel_cont .= "$excel_sno \t";

      foreach($field_array as $column)
      {
       // if($column != "cli_Flag" && $column != "cli_Marked")
      //  {
         if($column != "cso_generated_lead" && $column != "cso_sales_person" && $column != "cso_contact_code")
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
                            WHERE B.cli_ServiceRequiredCode = A.svr_Code AND B.cli_ClientCode = '$ids' AND B.cli_Form='Sales Opportunity'";
                   $results = mysql_query($qrys);
                   $valss = "";
                   while(list($descs) = mysql_fetch_array($results))
                   {
                      $valss .= "$descs,";
                   }
                  $vals = substr($valss,0,-1);
                }
            if($column=="cso_created_by") {
                $vals = $commonUses->getFirstLastName($row[$column]);
            }
            if($column=="cso_modified_by") {
                $vals = $commonUses->getFirstLastName($row[$column]);
            }
            if($column=="cso_contact_code") {
                $query="SELECT CONCAT(`con_Firstname`,' ',`con_Lastname`)AS cso_contact_name FROM `con_contact` WHERE con_Code=".$row[$column]." AND con_Firstname!='' ORDER BY con_Firstname";
                $result1 = mysql_query($query);
                $vals = @mysql_result($result1, 0, 'cso_contact_name');
            }

            if($column=="cso_date_received" || $column=="cso_last_contact_date" || $column=="cso_future_contact_date" || $column=="cso_created_date" || $column=="cso_modified_date")
            {
               if($row[$column]!="0000-00-00") {
                $vals = date('d-M-Y',strtotime($row[$column]));
                if($vals=="01-Jan-1970") { $vals = ""; }
               }
               else { $vals = ""; }
            }

            $vals = stripslashes($vals);
        $vals = preg_replace("/[\n|\r]/"," ",$vals);
        $excel_cont .= " $vals \t ";
      //  }
      }
      $excel_cont .= " \r\n";

    }

    $_SESSION['tableHead'] = $pdf_header;
    $table_content = "<form name='inlineSave' method='post'>";
     $table_content .= "<table width='100%' cellpadding='5' class='fieldtable' align='center'><tr class='fieldheader'><th width='20'>Sno</th>$table_head<th colspan='2'>Actions</th></tr>";
    $sno=$page_limit;
   //====== Excel Report end================================


    while($row = @mysql_fetch_array($result))
    {
     // print_r($row);
      $sno++;
      $table_content .= "<tr><td>$sno</td>";

        $clicode = $row['id'];
        $cli_id = $row['cso_client_code'];
      foreach($field_array as $column)
      {
       //   if($column != "cli_Marked" && $column != "cli_Flag" )
      //   {
             if($row[$column] != "")
            {
              $split_array = explode("-",$row[$column]);
              if(count($split_array) == 3)
              {
                 // $vals = date("d-m-Y h:i:s", strtotime($row[$column]));
                  $split_column = explode(" ",$split_array[2]);
                  $vals = $split_column[0]."-".$split_array[1]."-".$split_array[0]." ".$split_column[1];
              }
              else {
                $vals = $row[$column];
              }
            }
            else
            {
                $vals = "";
            }
            $vals = stripslashes($vals);
            if($column=="cso_date_received" || $column=="cso_last_contact_date" || $column=="cso_future_contact_date" || $column=="cso_created_date" || $column=="cso_modified_date")
            {
               if($row[$column]!="0000-00-00") {
                $vals = date('d/m/Y',strtotime($row[$column]));
                if($vals=="01-01-1970") { $vals = ""; }
               }
               else { $vals = ""; }
            }
            
            if($column=="cso_generated_lead")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $assignteam = "";
                $assignteam.="<select name='cso_generated_lead[$clicode]'><option value='0'>Select staff</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $teamincharge = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $assignteam .= "<option value='$stfcode' $selstr >$teamincharge</option>";
                    }
                $assignteam.="</select>";
                $vals = $assignteam;
            }
            
            if($column=="name") {
                $temp_cid = $row['cso_client_code'];
              /*  $cquery="SELECT id, name FROM `jos_users` WHERE name!='' ORDER BY name";
                $cresult1 = mysql_query($cquery);
                $cmpname = "";
                $cmpname.="<select name='cso_client_code[$clicode]'><option value='0'>Select client</option>";
                    while ($clp_row = mysql_fetch_assoc($cresult1)){
                    $cCode = $clp_row["id"];
                    $cName = $clp_row["name"];
                    if ($temp_cid == $cCode) {$selstr = " selected"; } else {$selstr = ""; }
                    $cmpname .= "<option value='$cCode' $selstr >$cName</option>";
                    }
                $cmpname.="</select>"; */
                $cmpname = '';
                $cmpname .= "<input type='hidden' name='cso_client_code[$clicode]' id='cso_client_code$clicode' value='$temp_cid'/>";
                $cmpname .= "<input type='text' name='compname[$clicode]' id='compname$clicode' value=\"$vals\" onKeypress='cmpName($clicode)' onfocus='cmpName($clicode)' onblur='cmpName($clicode)'/>";
                $vals = $cmpname;
            }
            if($column=="cso_date_received") {
                $clidatereceived = "<input type='text' name='cso_date_received[$clicode]' id='cso_date_received$sno' value='$vals'><a href=\"javascript:NewCal('cso_date_received$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $clidatereceived;
            } 
            if($column=="Service_Required")
            {
                   $ids = $row[$column];
                   $qrys = "SELECT A.svr_Description,A.svr_Code
                            FROM cli_servicerequired AS A, cli_allservicerequired AS B
                            WHERE B.cli_ServiceRequiredCode = A.svr_Code AND B.cli_ClientCode = '$ids' AND B.cli_Form='Sales Opportunity'";
                   $results = mysql_query($qrys);
                   $valss = array();
                   while($descs = mysql_fetch_array($results))
                   {
                     $valss[] = $descs['svr_Code'];
                   }
                $query = "select * from `cli_servicerequired` ORDER BY svr_Order ASC";
                $result1 = mysql_query($query);
                $cliservice = "";
                $cliservice.="<select name='cso_service_required[$clicode][]' multiple style='height:50px;'><option value='0'>Select Service</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["svr_Code"];
                    $servicename = $lp_row["svr_Description"];
                       if(in_array($scode,$valss)){$selstr = " selected"; } else {$selstr = ""; }
                    $cliservice .= "<option value='$scode' $selstr >$servicename</option>";
                    }
                $cliservice.="</select>";
                $vals = $cliservice;
            }
            
        /*    if($column=="ety_Description")
            {
                $query = "select * from `ety_entitytype` ORDER BY ety_Order ASC";
                $result1 = mysql_query($query);
                $clistage = "";
                $clistage.="<select name='cso_entity[$clicode]'><option value='0'>Select entity</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $ecode = $lp_row["ety_Code"];
                    $etagename = $lp_row["ety_Description"];
                    if ($vals == $etagename) {$selstr = " selected"; } else {$selstr = ""; }
                    $clistage .= "<option value='$ecode' $selstr >$etagename</option>";
                    }
                $clistage.="</select>";
                $vals = $clistage;
            } */
            if($column=="cst_Description")
            {
                $query = "select * from `cst_clientstatus` ORDER BY cst_Order ASC";
                $result1 = mysql_query($query);
                $clistage = "";
                $clistage.="<select name='cso_stage[$clicode]'><option value='0'>Select Stage</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["cst_Code"];
                    $stagename = $lp_row["cst_Description"];
                    if ($vals == $stagename) {$selstr = " selected"; } else {$selstr = ""; }
                    $clistage .= "<option value='$scode' $selstr >$stagename</option>";
                    }
                $clistage.="</select>";
                $vals = $clistage;
            }
            
            if($column=="cls_Description")
            {
                $query = "select * from `cls_clientleadstatus` ORDER BY cls_Order ASC";
                $result1 = mysql_query($query);
                $clistatus = "";
                $aid = $_GET['aid'];
                $clistatus.="<select name='cso_lead_status[$clicode]' id='cso_lead_status$clicode'><option value='0'>Select Status</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["cls_Code"];
                    $statusname = $lp_row["cls_Description"];
                    if ($vals == $statusname) {$selstr = " selected"; } else {$selstr = ""; }
                    $clistatus .= "<option value='$scode' $selstr >$statusname</option>";
                    }
                $clistatus.="</select>";
                $vals = $clistatus;
            }
            if($column=="src_Description")
            {
                $query = "select `src_Code`, `src_Description` from `src_source` ORDER BY src_Order ASC";
                $result1 = mysql_query($query);
                $clisource = "";
                $aid = $_GET['aid'];
                $clisource.="<select name='cso_source[$clicode]' id='cso_source$clicode'><option value='0'>Select Source</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["src_Code"];
                    $statusname = $lp_row["src_Description"];
                    if ($vals == $statusname) {$selstr = " selected"; } else {$selstr = ""; }
                    $clisource .= "<option value='$scode' $selstr >$statusname</option>";
                    }
                $clisource.="</select>";
                $vals = $clisource;
            }
            
            if($column=="moc_Description")
            {
                $query = "select * from `moc_methodofcontact` ORDER BY moc_Order ASC";
                $result1 = mysql_query($query);
                $climoc = "";
                $climoc.="<select name='cso_method_of_contact[$clicode]'><option value='0'>Select</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $mcode = $lp_row["moc_Code"];
                    $moc = $lp_row["moc_Description"];
                    if ($vals == $moc) {$selstr = " selected"; } else {$selstr = ""; }
                    $climoc .= "<option value='$mcode' $selstr >$moc</option>";
                    }
                $climoc.="</select>";
                $vals = $climoc;
            }
            if($column=="cso_sales_person")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $clisales = "";
                $clisales.="<select name='cso_sales_person[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $salesperson = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $clisales .= "<option value='$stfcode' $selstr >$salesperson</option>";
                    }
                $clisales.="</select>";
                $vals = $clisales;
            }
            if($column=="cso_contact_code")
            {
             /*   $cCode = $row['cso_client_code'];
                $query="SELECT con_Code, con_Firstname, con_Lastname FROM `con_contact` WHERE con_Company='".$cCode."' AND con_Firstname!='' ORDER BY con_Firstname";
                $result1 = mysql_query($query);
                $clisales = "";
                $clisales.="<select name='cso_contact_code[$clicode]'><option value='0'>Select contact</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["con_Code"];
                    $salesperson = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $clisales .= "<option value='$stfcode' $selstr >$salesperson</option>";
                    }
                $clisales.="</select>";
                $vals = $clisales; */
                $query="SELECT `con_Firstname`,`con_Lastname` FROM `con_contact` WHERE con_Code=".$row[$column]." AND con_Firstname!='' ORDER BY con_Firstname";
                $result1 = mysql_query($query);
                $cfname = @mysql_result($result1, 0, 'con_Firstname');
                $clname = @mysql_result($result1, 0, 'con_Lastname');
                $cflname = "<input type='hidden' name='cso_contact_code[$clicode]' value='$vals'>";
                $vals = $cfname." ".$clname.$cflname;
            } 
            
            if($column=="cso_last_contact_date") {
                $lastdate = "<input type='text' name='cso_last_contact_date[$clicode]' id='cso_last_contact_date$sno' value='$vals'><a href=\"javascript:NewCal('cso_last_contact_date$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $lastdate;
            }
            if($column=="cso_future_contact_date") {
                $futuredate = "<input type='text' name='cso_future_contact_date[$clicode]' id='cso_future_contact_date$sno' value='$vals'><a href=\"javascript:NewCal('cso_future_contact_date$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $futuredate;
            }
            if($column=="cso_notes") {
                $csonotes = "<textarea name='cso_notes[$clicode]'>$vals</textarea>";
                $vals = $csonotes;
            }
            
            if($column=="cso_created_date") {
                $createdon = "<input type='hidden' name='cso_created_date[$clicode]' value='$vals'>";
                $vals = $vals.$createdon;
            }
            if($column=="cso_created_by") {
                $clicreatedby = "<input type='hidden' name='cso_created_by[$clicode]' value='$vals'>";
                $vals = $commonUses->getFirstLastName($vals).$clicreatedby;
            }
            if($column=="cso_modified_by") {
                $climodby = "<input type='hidden' name='cso_modified_by[$clicode]' value='$vals'>";
                $vals = $commonUses->getFirstLastName($vals).$climodby;
            }
            $table_content .= "<td>$vals</td>";
      //   }
      }
      $aid = $_GET['aid'];
      $table_content .= "<td><img src='images/save.png' border='0'  alt='Save' name='Save' title='Save' align='middle' onClick=\"return customSave('$clicode','$page','$aid','save','$cli_id')\" /></td>";
      $table_content .= "<td><a href='cso_cross_sales_opportunity.php?a=edit&cli_code=$clicode&b=report' target='blank'><img src='images/edit.png' border='0'  alt='Edit' name='Edit' title='Edit' align='middle' /></a></td>";
      $table_content .= "</tr>";
    $pdf_vas .= $vals.",";
    }
    $_SESSION['pdfVals'] = $pdf_vas;
    $table_content .= "</table>";
    $table_content .= "<div id='genId' style='display:none;'></div>";

    $table_content .= "</form>";
    if(file_exists("sales_opportunity_report.xls"))
    {
      unlink("sales_opportunity_report.xls");
    }
    $fp = fopen("sales_opportunity_report.xls","a+");
    fwrite($fp,$excel_cont);
    fclose($fp);

    if($row_count >0 )
    {
      $startpage = $page_limit+1;
      $total_rec = "<b>Result :</b> $startpage - $sno records Out of $row_count";
      $extra_options = '<img border="0" align="middle" width="45" height="45" name="Print" alt="Print" style="margin-top: -5px;" src="images/excel1.jpg" onclick="window.location=\'excel_report.php?type=sales_opportunity_report\';" />';
    }
    else
    {
        $total_rec = "<b>Result</b> : No records found";
    }
}
?>

