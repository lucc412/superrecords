<?php
$formcode_report=$commonUses->getFormCode("Custom Sales Report");
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

  $rep_qry = "Select id,field_name,display from lookup WHERE report='Sales' ORDER BY display asc";
  $rep_result = mysql_query($rep_qry);
  $cont = "";

  while(list($id,$fieldname,$display) = mysql_fetch_array($rep_result))
  {
        $selected = ($_POST['fields'] == $fieldname)?"selected":"";
        if(!$restrict_flag && ($fieldname == "cli_Assignedto" || $fieldname == "cli_AssignAustralia" || $fieldname == "cli_TeaminCharge" || $fieldname == "cli_SeniorInCharge" || $fieldname == "cli_TeamMember" || $fieldname == "cli_Salesperson"))
        {

        }
        else
        {
          $cont .= "<option value='$fieldname' $selected>$display</option>";
        }
  }
//=================== End output fields ============
//================== Build Output fields ============

 $sales_qry = "Select id,field,display from sales_output";
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

    $fields2 = $_POST['fields2'];
    $condition2 = $_POST['condition2'];
    $condition_value2 = $_POST['condition_value2'];

    $fields3 = $_POST['fields3'];
    $condition3 = $_POST['condition3'];
    $condition_value3 = $_POST['condition_value3'];

    $fields4 = $_POST['fields4'];
    $condition4 = $_POST['condition4'];
    $condition_value4 = $_POST['condition_value4'];

    $fields5 = $_POST['fields5'];
    $condition5 = $_POST['condition5'];
    $condition_value5 = $_POST['condition_value5'];


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
                    $where_condition .= " AND jos_users.$fields  != '0000-00-00 00:00:00' ";
                  }
                  if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_TeaminCharge" && $fields != "cli_SeniorInCharge" && $fields != "cli_TeamMember" && $fields != "cli_Salesperson")
                  {
                     if(count($date_format) == 3)
                     {
                        $where_condition .= " AND DATE(jos_users.$fields) $sql_condition_applied '$condition_value'";
                     }
                     else
                     {

                     $where_condition .= " AND jos_users.$fields $sql_condition_applied '$condition_value'";
}

                  }
                  else
                  {
                    if(is_array($condition_value))
                    {

                       $condition_value = implode(",",$condition_value);
                       if($sql_condition_applied == "=")
                          $where_condition .= " AND jos_users.$fields  IN ($condition_value)";
                        else
                          $where_condition .= " AND jos_users.$fields  NOT IN ($condition_value) ";

                    }
                    else
                    {
                       $where_condition .= " AND jos_users.$fields  $sql_condition_applied '$condition_value' ";
                    }

                    $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = jos_users.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                    $qry_log = 1;

                  }
                }
                else
                {
                  switch($condition)
                  {
                    case "Starts with":
                        if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_TeaminCharge" && $fields != "cli_SeniorInCharge" && $fields != "cli_TeamMember" && $fields != "cli_Salesperson")
                        {
                            $where_condition .= " AND jos_users.$fields LIKE '$condition_value%' ";

                        }
                        else
                        {
                          $where_condition .= " AND (con_contact.con_Firstname LIKE '$condition_value%' || con_contact.con_Lastname LIKE '$condition_value%')";
                          $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = jos_users.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                         break;
                    case "Contains any part of word":
                        if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_TeaminCharge" && $fields != "cli_SeniorInCharge" && $fields != "cli_TeamMember" && $fields != "cli_Salesperson")
                        {
                          $where_condition .= " AND jos_users.$fields LIKE '%$condition_value%' ";

                        }
                        else
                        {
                          $where_condition .= " AND (con_contact.con_Firstname LIKE '%$condition_value%' || con_contact.con_Lastname LIKE '%$condition_value%')";
                          $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = jos_users.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                         break;
                    case "Contains full word":
                        if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_TeaminCharge" && $fields != "cli_SeniorInCharge" && $fields != "cli_TeamMember" && $fields != "cli_Salesperson")
                        {
                            $where_condition .= " AND jos_users.$fields LIKE '$condition_value' ";

                        }
                        else
                        {
                           $where_condition .= " AND (con_contact.con_Firstname LIKE '$condition_value' || con_contact.con_Lastname LIKE '$condition_value')";
                           $person_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = jos_users.$fields
LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                          $qry_log = 1;

                        }
                          break;

                      case "Pending":
                          $where_condition .= " AND DATE(jos_users.$fields) = '0000-00-00' ";
                          break;

                      case "Between dates":
                           $cond_val1 = "condition_value".$i."_from";
                           $cond_vals1 = explode("/",$_POST[$cond_val1]);
                           $cond_value1 = $cond_vals1[2]."-".$cond_vals1[1]."-".$cond_vals1[0];
                           $cond_val2 = "condition_value".$i."_to"; 
                           $cond_vals2= explode("/",$_POST[$cond_val2]);
                           $cond_value2 = $cond_vals2[2]."-".$cond_vals2[1]."-".$cond_vals2[0];
                          $where_condition .= " AND DATE(jos_users.$fields) >= '$cond_value1' AND DATE(jos_users.$fields) <= '$cond_value2' ";
                          $between_script = "select_conditions('Between dates','$i','$_POST[$cond_val1]','$_POST[$cond_val2]');";
                          break;

                  }
                }
                 $script_content .= "document.form1.fields$i.value='$fields';
                                      select_fields('$fields','$condition','$condition_value','$i');
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
    if($condfields1=="cli_Assignedto" || $condfields1=="cli_AssignAustralia" || $condfields1=="cli_Salesperson" || $condfields1=="cli_TeamMember" || $condfields1=="cli_TeaminCharge" || $condfields1=="cli_SeniorInCharge") {  $condvalue1 = implode(',', $condvalue1); }
    if($condfields2=="cli_Assignedto" || $condfields2=="cli_AssignAustralia" || $condfields2=="cli_Salesperson" || $condfields2=="cli_TeamMember" || $condfields2=="cli_TeaminCharge" || $condfields2=="cli_SeniorInCharge") {  $condvalue2 = implode(',', $condvalue2); }
    if($condfields3=="cli_Assignedto" || $condfields3=="cli_AssignAustralia" || $condfields3=="cli_Salesperson" || $condfields3=="cli_TeamMember" || $condfields3=="cli_TeaminCharge" || $condfields3=="cli_SeniorInCharge") {  $condvalue3 = implode(',', $condvalue3); }
    if($condfields4=="cli_Assignedto" || $condfields4=="cli_AssignAustralia" || $condfields4=="cli_Salesperson" || $condfields4=="cli_TeamMember" || $condfields4=="cli_TeaminCharge" || $condfields4=="cli_SeniorInCharge") {  $condvalue4 = implode(',', $condvalue4); }
    if($condfields5=="cli_Assignedto" || $condfields5=="cli_AssignAustralia" || $condfields5=="cli_Salesperson" || $condfields5=="cli_TeamMember" || $condfields5=="cli_TeaminCharge" || $condfields5=="cli_SeniorInCharge") {  $condvalue5 = implode(',', $condvalue5); }
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
    $query = "SELECT csr_SCode,csr_Title FROM csr_customsalesreportsave WHERE csr_SCode=".$_SESSION['staffcode']." AND csr_Code=".$_POST['saveid'];
    $result = mysql_query($query);
    $rowcount = @mysql_num_rows($result);
   // if($rowcount) {
        if($_POST['hiUpdate']=="update") {
            $qry = "UPDATE csr_customsalesreportsave SET csr_Title='".str_replace("'", "''", $_POST['csr_Title'])."',csr_Fields='".$conditionfields."',csr_Conditions='".$conditionname."',csr_Values='".$conditionvalue."',csr_OutputFields='".$outputfields."' WHERE csr_SCode=".$_SESSION['staffcode']." AND csr_Code=".$_POST['saveid'];
            mysql_query($qry);
        }
  //  }
   // else {
        // insert datas
        if($_POST['hiSave']=="save") {
            $query = "INSERT INTO `csr_customsalesreportsave` (csr_SCode,csr_Title,csr_Fields,csr_Conditions,csr_Values,csr_OutputFields) VALUES (".$_SESSION['staffcode'].",'".str_replace("'", "''", $_POST['csr_Title'])."','".$conditionfields."','".$conditionname."','".$conditionvalue."','".$outputfields."')";
            mysql_query($query);
        }
   // }
}
//================== End Save Conditions ===========

    //==================== Build OUTPUT fields ==================================================================
    $field_qry =  $cond_qry = "";
    $field_array = array();
     $field_array[] = "cli_Flag";
     $field_array[] = "cli_Marked";
    $qry = "SELECT ";

    foreach($output_fields as $f)
    {
      $select_qry = "SELECT field,display,lookup_table1,lookup_field1,condition_field1,alias_name from sales_output
                    WHERE
                    field = '$f' ";
      $select_result = mysql_query($select_qry);




      list($field,$display,$lookup_table1,$lookup_field1,$condition_field1,$alias_name) = mysql_fetch_row($select_result);


          if($field != "cli_Assignedto" && $field != "cli_AssignAustralia" && $field != "cli_TeaminCharge" && $field != "cli_SeniorInCharge" && $field != "cli_TeamMember" && $field != "cli_Salesperson")
          {
                if($lookup_table1 != "")
                {
                  if($alias_name == "")
                  {
                    if($field == "cli_ServiceRequired")
                    {
                      $field_qry .= "(jos_users.cli_Code) AS Service_Required,";
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

                    $field_qry .= "jos_users.$field,";
                    $field_array[] = $field;
                }
          }
          else
          {
              $field_qry .= "jos_users.$field,";
              $field_array[] = $field;
          }

        if($lookup_table1 != "")
        {
            $cond_qry  .= " LEFT OUTER JOIN $lookup_table1 ON $lookup_table1.$condition_field1 = jos_users.$field ";
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
      $where_condition .= " AND (jos_users.cli_Assignedto = '$_SESSION[staffcode]' || jos_users.cli_AssignAustralia = '$_SESSION[staffcode]' || jos_users.cli_TeaminCharge = '$_SESSION[staffcode]' || jos_users.cli_SeniorInCharge = '$_SESSION[staffcode]' || jos_users.cli_TeamMember = '$_SESSION[staffcode]' || jos_users.cli_Salesperson = '$_SESSION[staffcode]')";
    }

     $count_qry = "SELECT ".$field_qry." FROM jos_users $cond_qry $where_condition";

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


     $field_qry .= (!in_array("cli_FutureContactDate",$field_array))?",jos_users.cli_FutureContactDate":"";
     $field_qry .= ",jos_users.cli_Flag,jos_users.cli_Marked,jos_users.cli_Code ";
    // $field_array[] = "cli_FutureContactDate";

    $qry .= $field_qry." FROM jos_users $cond_qry $where_condition limit $page_limit,$row_per_page";
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
        if($column != "cli_Flag" && $column != "cli_Marked")
        {
         if($column != "cli_Assignedto" && $column != "cli_AssignAustralia" && $column != "cli_TeaminCharge" && $column != "cli_SeniorInCharge" && $column != "cli_TeamMember" && $column != "cli_Salesperson")
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
                 if($column == "block")
                {
                    if($row[$column]=="1")
                    {
                        $vals = "InActive";
                    }
                    if($row[$column]=="0")
                    {
                        $vals = "Active";
                    }

                }

            if($column=="date_contract_signed" || $column=="cli_DateReceived" || $column=="cli_DiscontinuedDate" || $column=="lead_to_notsuccessful_date" || $column=="cli_Lastdate" || $column=="cli_Lastmodifiedon" || $column=="cli_FutureContactDate" || $column=="date_quotesheet_submitted" || $column=="date_permanent_info" || $column=="date_india_manager_assigned" || $column=="date_hosting_submitted" || $column=="date_TeaminCharge" || $column=="date_salesnotes_submitted" || $column=="date_taxaccount_submitted" || $column=="date_client_changed")
            {
               if($row[$column]!="0000-00-00 00:00:00") {
                $vals = date('d-M-Y',strtotime($row[$column]));
                if($vals=="01-Jan-1970") { $vals = ""; }
               }
               else { $vals = ""; }
            }


        $vals = preg_replace("/[\n|\r]/"," ",$vals);
        $excel_cont .= " $vals \t ";
        }
      }
      $excel_cont .= " \r\n";

    }

    $_SESSION['tableHead'] = $pdf_header;
    $table_content = "<form name='inlineSave' method='post'>";
     $table_content .= "<table width='100%' cellpadding='5' class='fieldtable' align='center'><tr class='fieldheader'><th width='20'>Sno</th><th width='20'>Flag</th>$table_head<th colspan='2'>Actions</th></tr>";
    $sno=$page_limit;
   //====== Excel Report end================================


    while($row = @mysql_fetch_array($result))
    {
     // print_r($row);
      $sno++;
      $table_content .= "<tr><td>$sno</td>";

        $clicode = $row['cli_Code'];
        
      foreach($field_array as $column)
      {
          if($column != "cli_Marked" && $column != "cli_Flag" )
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
                if($column == "block")
                {
                    if($row[$column]=="1")
                    {
                        $vals = "InActive";
                    }
                    if($row[$column]=="0")
                    {
                        $vals = "Active";
                    }
                    $cliblock = "<input type='hidden' name='block[$clicode]' value='$row[$column]'>";
                    $vals = $vals.$cliblock;
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
            if($column=="date_contract_signed" || $column=="cli_DateReceived" || $column=="cli_DiscontinuedDate" || $column=="lead_to_notsuccessful_date" || $column=="cli_Lastdate" || $column=="cli_Lastmodifiedon" || $column=="cli_Createdon" || $column=="date_quotesheet_submitted" || $column=="date_permanent_info" || $column=="date_india_manager_assigned" || $column=="date_hosting_submitted" || $column=="date_TeaminCharge" || $column=="date_salesnotes_submitted" || $column=="date_taxaccount_submitted" || $column=="date_client_changed")
            {
               if($row[$column]!="0000-00-00 00:00:00") {
                $vals = date('d/m/Y',strtotime($row[$column]));
                if($vals=="01-01-1970") { $vals = ""; }
               }
               else { $vals = ""; }
            }
            if($column=="cli_FutureContactDate")
            {
                if($row[$column]!="0000-00-00") {
                $vals = date('d/m/Y',strtotime($row[$column]));
                if($vals=="01-01-1970") { $vals = ""; }
               }
               else { $vals = ""; }

            }
            if($column=="cty_Description")
            {
                $query = "select cty_Code, cty_Description from cty_clienttype";
                $result1 = mysql_query($query);
                $clitype = "";
                $clitype.="<select name='cli_Type[$clicode]'>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $tcode = $lp_row["cty_Code"];
                    $caption = $lp_row["cty_Description"];
                    if ($vals == $caption) {$selstr = " selected"; } else {$selstr = ""; }
                    $clitype .= "<option value='$tcode' $selstr >$caption</option>";
                    }
                $clitype.="</select>";
                $vals = $clitype;
            }
            if($column=="cli_Assignedto")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=17 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $indresult1 = mysql_query($query);
                $assignindia = "";
                $assignindia.="<select name='cli_Assignedto[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($indresult1)){
                    $indstfcode = $lp_row["stf_Code"];
                    $indiamanager = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $indstfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $assignindia .= "<option value='$indstfcode' $selstr >$indiamanager</option>";
                    }
                $assignindia.="</select>";
                $vals = $assignindia;
            }
            if($column=="cli_AssignAustralia")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=18 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $assignaus = "";
                $assignaus.="<select name='cli_AssignAustralia[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $ausmanager = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $assignaus .= "<option value='$stfcode' $selstr >$ausmanager</option>";
                    }
                $assignaus.="</select>";
                $vals = $assignaus;
            }
            if($column=="cli_TeaminCharge")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=16 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $assignteam = "";
                $assignteam.="<select name='cli_TeaminCharge[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $teamincharge = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $assignteam .= "<option value='$stfcode' $selstr >$teamincharge</option>";
                    }
                $assignteam.="</select>";
                $vals = $assignteam;
            }
            if($column=="cli_SeniorInCharge")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE c1.con_Designation=21 AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $assignsenior = "";
                $assignsenior.="<select name='cli_SeniorInCharge[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $seniorincharge = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $assignsenior .= "<option value='$stfcode' $selstr >$seniorincharge</option>";
                    }
                $assignsenior.="</select>";
                $vals = $assignsenior;
            }
            if($column=="cli_TeamMember")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE (c1.con_Designation=15 OR c1.con_Designation=20) AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $assignmember = "";
                $assignmember.="<select name='cli_TeamMember[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $teammember = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $assignmember .= "<option value='$stfcode' $selstr >$teammember</option>";
                    }
                $assignmember.="</select>";
                $vals = $assignmember;
            }
            if($column=="name") {
                $cmpname = "<input type='text' name='name[$clicode]' value='$vals'>";
                $vals = $cmpname;
            }
            if($column=="cli_Category") {
                $clicategory = "";
                if($vals=="1") $firstselect = "selected"; else $firstselect = "";
                if($vals=="2") $secondselect = "selected"; else $secondselect = "";
                if($vals=="3") $thirdselect = "selected"; else $thirdselect = "";
                $clicategory.="<select name='cli_Category[$clicode]'>
                <option value='0'>Select Category</option>
                <option value='1' $firstselect>1</option>
                <option value='2' $secondselect>2</option>
                <option value='3' $thirdselect>3</option>
                ";
                $clicategory.="</select>";
                $vals = $clicategory;
            }
            if($column=="cli_PostalAddress") {
                $address = "<textarea name='cli_PostalAddress[$clicode]' cols='30' rows='4'>$vals</textarea>";
                $vals = $address;
            }
            if($column=="cli_City") {
                $clicity = "<input type='text' name='cli_City[$clicode]' value='$vals'>";
                $vals = $clicity;
            }
            if($column=="State")
            {
                $query ="select `cst_Code`,`cst_Description` from `cli_state` ORDER BY cst_Description ASC";
                $result1 = mysql_query($query);
                $clistate = "";
                $clistate.="<select name='cli_State[$clicode]'><option value='0'>Select State</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["cst_Code"];
                    $statename = $lp_row["cst_Description"];
                    if ($vals == $statename) {$selstr = " selected"; } else {$selstr = ""; }
                    $clistate .= "<option value='$scode' $selstr >$statename</option>";
                    }
                $clistate.="</select>";
                $vals = $clistate;
            }
            if($column=="cli_Postcode") {
                $postcode = "<input type='text' name='cli_Postcode[$clicode]' value='$vals'>";
                $vals = $postcode;
            }
            if($column=="cli_Country") {
                $clicountry = "<input type='text' name='cli_Country[$clicode]' value='$vals'>";
                $vals = $clicountry;
            }
            if($column=="cli_Phone") {
                $cliphone = "<input type='text' name='cli_Phone[$clicode]' value='$vals'>";
                $vals = $cliphone;
            }
            if($column=="cli_Mobile") {
                $climobile = "<input type='text' name='cli_Mobile[$clicode]' value='$vals'>";
                $vals = $climobile;
            }
            if($column=="cli_Fax") {
                $clifax = "<input type='text' name='cli_Fax[$clicode]' value='$vals'>";
                $vals = $clifax;
            }
            if($column=="email") {
                $mailtext = "<input type='text' name='email[$clicode]' value='$vals'>";
                $vals = $mailtext;
            }
            if($column=="cli_Website") {
                $cliwebsite = "<input type='text' name='cli_Website[$clicode]' value='$vals'>";
                $vals = $cliwebsite;
            }
            if($column=="cli_DateReceived") {
                $clidatereceived = "<input type='text' name='cli_DateReceived[$clicode]' id='cli_DateReceived$sno' value='$vals'><a href=\"javascript:NewCal('cli_DateReceived$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $clidatereceived;
            }
            if($column=="ind_Description")
            {
                $query = "select * from `cli_industry` ORDER BY ind_Order ASC";
                $result1 = mysql_query($query);
                $cliindus = "";
                $cliindus.="<select name='cli_Industry[$clicode]'><option value='0'>Select Industry</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $icode = $lp_row["ind_Code"];
                    $indusname = $lp_row["ind_Description"];
                    if ($vals == $indusname) {$selstr = " selected"; } else {$selstr = ""; }
                    $cliindus .= "<option value='$icode' $selstr >$indusname</option>";
                    }
                $cliindus.="</select>";
                $vals = $cliindus;
            }
            if($column=="cli_Turnover") {
                $cliturnover = "<input type='text' name='cli_Turnover[$clicode]' value='$vals'>";
                $vals = $cliturnover;
            }
            if($column=="Service_Required")
            {
                   $ids = $row[$column];
                   $qrys = "SELECT A.svr_Description,A.svr_Code
                            FROM cli_servicerequired AS A, cli_allservicerequired AS B
                            WHERE B.cli_ServiceRequiredCode = A.svr_Code AND B.cli_ClientCode = '$ids' ";
                   $results = mysql_query($qrys);
                   $valss = array();
                   while($descs = mysql_fetch_array($results))
                   {
                     $valss[] = $descs['svr_Code'];
                   }
                $query = "select * from `cli_servicerequired` ORDER BY svr_Order ASC";
                $result1 = mysql_query($query);
                $cliservice = "";
                $cliservice.="<select name='cli_ServiceRequired[$clicode][]' multiple style='height:50px;'><option value='0'>Select Service</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["svr_Code"];
                    $servicename = $lp_row["svr_Description"];
                       if(in_array($scode,$valss)){$selstr = " selected"; } else {$selstr = ""; }
                    $cliservice .= "<option value='$scode' $selstr >$servicename</option>";
                    }
                $cliservice.="</select>";
                $vals = $cliservice;
            }
            if($column=="Stage")
            {
                $query = "select * from `cst_clientstatus` ORDER BY cst_Order ASC";
                $result1 = mysql_query($query);
                $clistage = "";
                $clistage.="<select name='cli_Stage[$clicode]'><option value='0'>Select Stage</option>";
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
                $formurl = "cli_client.php?a=lead_status&cid=".$clicode."&aid=".$_GET['aid']."&page=".$_GET['page']."&report=sales";
                $aid = $_GET['aid'];
                $clistatus.="<select name='cli_Status[$clicode]' id='cli_Status$clicode' onChange=\"leadstatusReason('$formurl','Worksheet','841','340','yes',this.value,'$vals','$clicode','$page','$aid')\"><option value='0'>Select Status</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["cls_Code"];
                    $statusname = $lp_row["cls_Description"];
                    if ($vals == $statusname) {$selstr = " selected"; } else {$selstr = ""; }
                    $clistatus .= "<option value='$scode' $selstr >$statusname</option>";
                    }
                $clistatus.="</select>";
                $clistatus.="<input type='hidden' name='cli_Statusold[$clicode]' id='cli_Statusold$clicode' value='$vals' />";
                $vals = $clistatus;
            }
            if($column=="src_Description")
            {
                $query = "select * from `src_source` ORDER BY src_Order ASC";
                $result1 = mysql_query($query);
                $clisource = "";
                $clisource.="<select name='cli_Source[$clicode]'><option value='0'>Select Source</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $scode = $lp_row["src_Code"];
                    $source = $lp_row["src_Description"];
                    if ($vals == $source) {$selstr = " selected"; } else {$selstr = ""; }
                    $clisource .= "<option value='$scode' $selstr >$source</option>";
                    }
                $clisource.="</select>";
                $vals = $clisource;
            }
            if($column=="moc_Description")
            {
                $query = "select * from `moc_methodofcontact` ORDER BY moc_Order ASC";
                $result1 = mysql_query($query);
                $climoc = "";
                $climoc.="<select name='cli_MOC[$clicode]'><option value='0'>Select</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $mcode = $lp_row["moc_Code"];
                    $moc = $lp_row["moc_Description"];
                    if ($vals == $moc) {$selstr = " selected"; } else {$selstr = ""; }
                    $climoc .= "<option value='$mcode' $selstr >$moc</option>";
                    }
                $climoc.="</select>";
                $vals = $climoc;
            }
            if($column=="cli_Salesperson")
            {
                $query="SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname FROM `stf_staff` t1 LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code WHERE (c1.con_Designation=14 || c1.con_Designation=19) AND t2.aty_Description LIKE '%Staff%' ORDER BY stf_Code";
                $result1 = mysql_query($query);
                $clisales = "";
                $clisales.="<select name='cli_Salesperson[$clicode]'><option value='0'>Select Users</option>";
                    while ($lp_row = mysql_fetch_assoc($result1)){
                    $stfcode = $lp_row["stf_Code"];
                    $salesperson = $lp_row["con_Firstname"]." ".$lp_row["con_Lastname"];
                    if ($vals == $stfcode) {$selstr = " selected"; } else {$selstr = ""; }
                    $clisales .= "<option value='$stfcode' $selstr >$salesperson</option>";
                    }
                $clisales.="</select>";
                $vals = $clisales;
            }
            if($column=="cli_Notes") {
                $clinotes = "<textarea name='cli_Notes[$clicode]' cols='30' rows='4'>$vals</textarea>";
                $vals = $clinotes;
            }
            if($column=="cli_PhysicalFileId") {
                $cliphysical = "<input type='text' name='cli_PhysicalFileId[$clicode]' value='$vals'>";
                $vals = $cliphysical;
            }
            if($column=="cli_MYOBSerialNo") {
                $myob = "<input type='text' name='cli_MYOBSerialNo[$clicode]' value='$vals'>";
                $vals = $myob;
            }
            if($column=="cli_DiscontinuedDate") {
                $clidiscondate = "<input type='text' name='cli_DiscontinuedDate[$clicode]' id='cli_DiscontinuedDate$sno' value='$vals'><a href=\"javascript:NewCal('cli_DiscontinuedDate$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $clidiscondate;
            }
            if($column=="lead_to_notsuccessful_date") {
                $clinotsuccessfuldate = "<input type='text' name='lead_to_notsuccessful_date[$clicode]' id='lead_to_notsuccessful_date$clicode' value='$vals'><a href=\"javascript:NewCal('lead_to_notsuccessful_date$clicode','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $clinotsuccessfuldate;
            }

            if($column=="cli_DiscontinuedReason") {
                $disconreason = "<textarea name='cli_DiscontinuedReason[$clicode]' cols='30' rows='4'>$vals</textarea>";
                $vals = $disconreason;
            }
            if($column=="lead_to_notsuccessful_reason") {
                $notsuccessreason = "<textarea name='lead_to_notsuccessful_reason[$clicode]' id='lead_to_notsuccessful_reason$clicode' cols='30' rows='4'>$vals</textarea>";
                $vals = $notsuccessreason;
            }

            if($column=="cli_LastReportsSent") {
                $lastreport = "<textarea name='cli_LastReportsSent[$clicode]' cols='30' rows='4'>$vals</textarea>";
                $vals = $lastreport;
            }
            if($column=="cli_Lastdate") {
                $lastdate = "<input type='text' name='cli_Lastdate[$clicode]' id='cli_Lastdate$sno' value='$vals'><a href=\"javascript:NewCal('cli_Lastdate$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $lastdate;
            }
            if($column=="cli_FutureContactDate") {
                $futuredate = "<input type='text' name='cli_FutureContactDate[$clicode]' id='cli_FutureContactDate$sno' value='$vals'><a href=\"javascript:NewCal('cli_FutureContactDate$sno','ddmmyyyy',false,24)\"><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
                $vals = $futuredate;
            }
            if($column=="cli_Createdon") {
                $createdon = "<input type='hidden' name='cli_Createdon[$clicode]' value='$vals'>";
                $vals = $vals.$createdon;
            }
        /*    if($column=="cli_Lastmodifiedon") {
                $modifiedon = "<input type='hidden' name='cli_Lastmodifiedon[$clicode]' value='$vals'>";
                $vals = $vals.$modifiedon;
            } */
            if($column=="cli_Createdby") {
                $clicreatedby = "<input type='hidden' name='cli_Createdby[$clicode]' value='$vals'>";
                $vals = $vals.$clicreatedby;
            }
            if($column=="cli_Lastmodifiedby") {
                $climodby = "<input type='hidden' name='cli_Lastmodifiedby[$clicode]' value='$vals'>";
                $vals = $vals.$climodby;
            }
            if($column=="date_contract_signed") {
                $clicontractdate = "<input type='hidden' name='date_contract_signed[$clicode]' value='$vals'>";
                $vals = $vals.$clicontractdate;
            }
            if($column=="date_quotesheet_submitted") {
                $cliquotesheetdate = "<input type='hidden' name='date_quotesheet_submitted[$clicode]' value='$vals'>";
                $vals = $vals.$cliquotesheetdate;
            }
            if($column=="date_permanent_info") {
                $cliperminfodate = "<input type='hidden' name='date_permanent_info[$clicode]' value='$vals'>";
                $vals = $vals.$cliperminfodate;
            }
            if($column=="date_india_manager_assigned") {
                $cliindmandate = "<input type='hidden' name='date_india_manager_assigned[$clicode]' value='$vals'>";
                $vals = $vals.$cliindmandate;
            }
            if($column=="date_salesnotes_submitted") {
                $clisalesnotedate = "<input type='hidden' name='date_salesnotes_submitted[$clicode]' value='$vals'>";
                $vals = $vals.$clisalesnotedate;
            }
            if($column=="date_taxaccount_submitted") {
                $clitaxaccountdate = "<input type='hidden' name='date_taxaccount_submitted[$clicode]' value='$vals'>";
                $vals = $vals.$clitaxaccountdate;
            }
            if($column=="date_client_changed") {
                $clidateclient = "<input type='hidden' name='date_client_changed[$clicode]' value='$vals'>";
                $vals = $vals.$clidateclient;
            }

            $table_content .= "<td>$vals</td>";
         }
         else if($column == "cli_Marked")
         {
            $vals = "yes";
            if($row[$column] == "Y" && $row['cli_Flag'] == "mark")
            {
              $vals =  "<img src='images/marked.gif' alt='Followup completed' title='Followup completed' />";
            }
            else if($row['cli_FutureContactDate'] != "0000-00-00" )
            {
              $current_date = strtotime(date("Y-m-d"));
              $future_date = strtotime($row['cli_FutureContactDate']);
              $date_difference = $future_date - $current_date;
              if($date_difference > 0)
              {
                $vals =  "<img src='images/orange_flag.png' alt='This week followup' title='This week followup' />";
              }
              else
              {
                $vals =  "<img src='images/red_flag.png' alt=\"Today's followup / Overdue followup\" title=\"Today's followup / Overdue followup\" />";
              }

            }
            else
            {
              $vals =  "<img src='images/white_flag.png' alt='Followup not set' title='Followup not set' />";
            }
            $table_content .= "<td>$vals</td>";
         }
      /*   else if($column == "cli_Assignedto" || $column == "cli_AssignAustralia" || $column  == "cli_Salesperson")
         {
             $get_vals = $commonUses->getFirstLastName($row[$column]);
             $vals = ($get_vals != "")?$get_vals:"-";
             $table_content .= "<td>$vals</td>";
         } */
         else
         {
            $table_content .= "";
         }
      }
      $aid = $_GET['aid'];
      $table_content .= "<td><img src='images/save.png' border='0'  alt='Save' name='Save' title='Save' align='middle' onClick=\"return customSave('$clicode','$page','$aid','save')\" /></td>";
      $table_content .= "<td><a href='cli_client.php?a=edit&cli_code=$clicode&b=report' target='blank'><img src='images/edit.png' border='0'  alt='Edit' name='Edit' title='Edit' align='middle' /></a></td>";
      $table_content .= "</tr>";
    $pdf_vas .= $vals.",";
    }
    $_SESSION['pdfVals'] = $pdf_vas;
    $table_content .= "</table>";
    $table_content .= "<div id='genId' style='display:none;'></div>";

    $table_content .= "</form>";
    if(file_exists("sales_report.xls"))
    {
      unlink("sales_report.xls");
    }
    $fp = fopen("sales_report.xls","a+");
    fwrite($fp,$excel_cont);
    fclose($fp);

    if($row_count >0 )
    {
      $startpage = $page_limit+1;
      $total_rec = "<b>Result :</b> $startpage - $sno records Out of $row_count";
      $extra_options = '<img border="0" align="middle" width="45" height="45" name="Print" alt="Print" style="margin-top: -5px;" src="images/excel1.jpg" onclick="window.location=\'excel_report.php?type=sales_report\';" />';
      //$extra_options = '<img border="0" align="middle" onclick="printpage();" name="Print" alt="Print" style="margin-top: -15px;" src="images/printButton.png">&nbsp;&nbsp;&nbsp;&nbsp;<img border="0" align="middle" width="45" height="45" name="Print" alt="Print" style="margin-top: -15px;" src="images/excel1.jpg" onclick="window.location=\'excel_report.php?type=sales_report\';" />';
          //  $extra_options = '<a href="sales_report_pdf.php"><img border="0" align="middle" alt="Pdf" style="margin-top: 0px; margin-left: 250px;" src="images/pdf_icon.gif"></a>';

    }
    else
    {
        $total_rec = "<b>Result</b> : No records found";
    }
}
?>

