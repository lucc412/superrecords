<?php
ob_start();
  include("dbclass/commonFunctions_class.php");

//admin send news letter drop email
if($_POST['submitbut']=="Select")
{
     $select_mail = $_POST['checkbox']; 
}
else {
     $select_mail = $_POST['allEmail']; 
}
 if(is_array($select_mail))
    $selected_mailids=implode(",",$select_mail);
 if($_POST['submitbut']=="Select" || $_POST['allEmailsend']=="Send to all")
 {
  echo "<script>
            var val = opener.document.adminForm.sendto.value;
            if(val!='') {
            var r = val+',';
            opener.document.adminForm.sendto.value = r+'".$selected_mailids."';
            }
               else { opener.document.adminForm.sendto.value = '".$selected_mailids."'; }
                    self.close()";
  echo "</script>";
 }

?>
<html>
<head>
<title>Send News Letter</title>
<script language="javascript">
    checked = false;
        function checkedAll () {
                if (checked == false){checked = true}else{checked = false}
                    var chk=document.getElementsByTagName('input');
                    for (var i=0,thisInput; thisInput=chk[i]; i++) {
                        if(thisInput.type=="checkbox")
                            thisInput.checked=checked;
                    }
       }
</script>
<style type="text/css">
    .newsbutton{
        background-color: #047ea7;
        padding: 5px 5px 5px 5px;
        color: white;
        font-weight: bold;
}
</style>
<meta name="generator" http-equiv="content-type" content="text/html">
<LINK href="css/Style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if($_SESSION['Viewall']=="N" && $_SESSION['usertype'] == "Staff")
   $restrict_flag = false;
else
   $restrict_flag = true;

//================== Build Input fields ============
$conn = new Database();
  $rep_qry = "Select id,field_name,display from lookup WHERE report='Sales' ";
  $rep_result = mysql_query($rep_qry);
  $cont = "";

  while(list($id,$fieldname,$display) = mysql_fetch_array($rep_result))
  {
        $selected = ($_POST['fields'] == $fieldname)?"selected":""; 
        if(!$restrict_flag && ($fieldname == "cli_Assignedto" || $fieldname == "cli_AssignAustralia" || $fieldname == "cli_Salesperson"))
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
                  if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_Salesperson")
                  {
                     if(count($date_format) == 3)
                     {
                        $where_condition .= " AND DATE(cli_client.$fields) $sql_condition_applied '$condition_value'";
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
                        if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_Salesperson")
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
                        if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_Salesperson")
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
                        if($fields != "cli_Assignedto" && $fields != "cli_AssignAustralia" && $fields != "cli_Salesperson")
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
                                      document.form1.condition$i.value='$condition';
                                      select_fields('$fields','$condition','$condition_value','$i');
                                      $between_script"; 
            }
     
     
    }
     $script_content .= "</script>";
    
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
   
    
          if($field != "cli_Assignedto" && $field != "cli_AssignAustralia" && $field != "cli_Salesperson")
          {
                //$field_qry .= ($lookup_table1 != "")?"$lookup_table1.$lookup_field1,":"cli_client.$field,";
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
              /*$field_qry .= "CONCAT_WS(' ',con_Firstname,con_Lastname),";
              if($qry_log == 0)
              {
              $cond_qry .= " LEFT OUTER JOIN stf_staff ON stf_staff.stf_Code = cli_client.$field 
                LEFT OUTER JOIN con_contact ON con_contact.con_Code = stf_staff.stf_CCode ";
                $qry_log=1;
              }*/
              $field_qry .= "jos_users.$field,";
              $field_array[] = $field;
          }
        
        if($lookup_table1 != "")
        {
            $cond_qry  .= " LEFT OUTER JOIN $lookup_table1 ON $lookup_table1.$condition_field1 = jos_users.$field ";
        }  
                 
        $table_head .= "<th>$display</th>";
        $excel_header .= "$display \t ";
  
       
    }
    
   // print_r($field_array);
  
    $field_qry = substr($field_qry,0,-1);
    //$cond_qry .= $person_qry;
  
    if(!$restrict_flag)
    {
      $where_condition .= " AND (jos_users.cli_Assignedto = '$_SESSION[staffcode]' || jos_users.cli_AssignAustralia = '$_SESSION[staffcode]' || jos_users.cli_Salesperson = '$_SESSION[staffcode]')";
    }
    
    $count_qry = "SELECT ".$field_qry." FROM jos_users $cond_qry $where_condition";
         
    $count_result = mysql_query($count_qry);
    //echo mysql_error();
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
               $page_cont .= "<div style='margin-left:290px;'><img src='images/pagination-far-left.png' > &nbsp; <img src='images/pagination-left.png' >  &nbsp; <a href='javascript:;' onclick='return pagination($next);'><img src='images/pagination-right.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($max_page);'><img src='images/pagination-far-right.png' > </a>&nbsp;</div>";
            
          }
          else if($page_no == $max_page )
          {
                 $prev = ($page_no-1 == 0)?1:$page_no-1;
                  $page_cont .= "<div style='margin-left:290px;'><a href='javascript:;' onclick='return pagination(1);'><img src='images/pagination-far-left.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($prev);'><img src='images/pagination-left.png' > </a>&nbsp; <img src='images/pagination-right.png' >  &nbsp; <img src='images/pagination-far-right.png' >  &nbsp;</div>";
            
          }
          else
          {
              $prev = ($page_no-1 == 0)?1:$page_no-1; 
              $next = ($page_no+1 > $max_page)?$max_page:$page_no+1;
              $page_cont .= "<div style='margin-left:290px;'><a href='javascript:;' onclick='return pagination(1);'><img src='images/pagination-far-left.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($prev);'><img src='images/pagination-left.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($next);'><img src='images/pagination-right.png' > </a>&nbsp;<a href='javascript:;' onclick='return pagination($max_page);'><img src='images/pagination-far-right.png' > </a>&nbsp;</div>";
          }
      }         
               
               
     $field_qry .= (!in_array("cli_FutureContactDate",$field_array))?",jos_users.cli_FutureContactDate":"";
     $field_qry .= ",jos_users.cli_Flag,jos_users.cli_Marked,jos_users.email ";
    $qry .= $field_qry." FROM jos_users $cond_qry $where_condition limit $page_limit,$row_per_page";
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
        if($column != "cli_Flag" && $column != "cli_Marked")
        {
         if($column != "cli_Assignedto" && $column != "cli_AssignAustralia" && $column != "cli_Salesperson")
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

            if($column=="date_contract_signed" || $column=="cli_DateReceived" || $column=="cli_DiscontinuedDate" || $column=="cli_Lastdate" || $column=="cli_Lastmodifiedon" || $column=="cli_FutureContactDate" || $column=="date_quotesheet_submitted" || $column=="date_permanent_info" || $column=="date_india_manager_assigned" || $column=="date_hosting_submitted" || $column=="date_TeaminCharge" || $column=="date_salesnotes_submitted" || $column=="date_taxaccount_submitted" || $column=="date_client_changed")
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
     $table_content = "<table width='100%' cellpadding='5' class='fieldtable' align='center'><tr class='fieldheader'><th width='20'>Sno</th><th width='20'><input type='checkbox' name='checkall' onclick='checkedAll();'></th><th width='20'>Flag</th>$table_head</tr>";
    $sno=$page_limit;
   //====== Excel Report end================================
   
    while($row = mysql_fetch_array($result))
    {
     // print_r($row);
      $sno++;
      $table_content .= "<tr><td>$sno</td>";
      $email = $row['email'];
    //  $table_content .= "<input type='hidden' name='allEmail[]' value='$email'>";
     $table_content .= "<td><input name='checkbox[]' type='checkbox' id='checkbox[]' value='$email' style='margin-left:9px;'></td>";
      foreach($field_array as $column)
      {
        
         if($column != "cli_Assignedto" && $column != "cli_AssignAustralia" && $column != "cli_Salesperson"  && $column != "cli_Marked" && $column != "cli_Flag" )
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
                 else if($column == "block")
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
            if($column=="date_contract_signed" || $column=="cli_DateReceived" || $column=="cli_DiscontinuedDate" || $column=="cli_Lastdate" || $column=="cli_Lastmodifiedon" || $column=="cli_FutureContactDate" || $column=="date_quotesheet_submitted" || $column=="date_permanent_info" || $column=="date_india_manager_assigned" || $column=="date_hosting_submitted" || $column=="date_TeaminCharge" || $column=="date_salesnotes_submitted" || $column=="date_taxaccount_submitted" || $column=="date_client_changed")
            {
               if($row[$column]!="0000-00-00 00:00:00") {
                $vals = date('d-M-Y',strtotime($row[$column]));
                if($vals=="01-Jan-1970") { $vals = ""; }
               }
               else { $vals = ""; }
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
         else if($column == "cli_Assignedto" || $column == "cli_AssignAustralia" || $column  == "cli_Salesperson")
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
    $table_content .= "<br/>";
     $email_qry = "SELECT email FROM jos_users $cond_qry $where_condition";
     $email_result = mysql_query($email_qry);
     while($email_name = mysql_fetch_array($email_result))
     {
        $allclientEmail = $email_name['email'];
        $table_content .= "<input type='hidden' name='allEmail[]' value='$allclientEmail'>";
     }
    $table_content .= "<input type='submit' name='submitbut' value='Select' class='newsbutton'  ><input type='submit' name='allEmailsend' value='Send to all' class='newsbutton'  ><input type='button' name='closebut' value='Cancel' class='newsbutton' onclick='javascript:window.close()'></div>";
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
    }
    else
    {
        $total_rec = "<b>Result</b> : No records found";
    }
}  

?>
<div id="notprint" align="left">
<form name="form1" method="post" >
 
<table cellpadding="10" width="90%"  align="left">
 <tr>
     <td><img src="images/logo.png" style="margin-left:20px;"></td>
 </tr>
 <tr>
    <td colspan="4" height="40" align="left">
        <br><br>
        <span class="frmheading">Send News Letter</span>
        <hr size="1" noshade  >
</td>
  </tr>
  <tr>
   
    <td valign="top"> 
        <b>Condition fields</b> <br>
         <select name="fields1" id="fields1" onchange="return select_fields(this.value,'','','1');">
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
         <select name="fields2" id="fields2" onchange="return select_fields(this.value,'','','2');">
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
      
         <select name="fields3" id="fields3" onchange="return select_fields(this.value,'','','3');">
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
      
         <select name="fields4" id="fields4" onchange="return select_fields(this.value,'','','4');">
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
       
         <select name="fields5" id="fields5" onchange="return select_fields(this.value,'','','5');">
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
    <td colspan="4" height="20" align="center"></td>
  </tr>
  <tr>
     <td colspan="4" height="50" align="center"><input type="button" name="view" value="Generate Report" onclick="return validation();" />&nbsp;&nbsp;<input type="button" name="view" value="Reset Filter" onclick="window.location='http://www.superrecords.com.au/admin/send_newsletter.php';" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  
  
</table>
<div id="mm"></div>
</form>
 </div>

<div style="clear:both;padding-top:30px;">
<table width="100%">
<tr>
  <td align="left" width="600">
  <label style="text-align:center;font-family:Arial,Tahoma,Verdana,Helvetica,sans-serif;font-size:12px;"><?php echo $total_rec; ?></label>
  </td>
  <td><?php echo $extra_options; ?></td>
  <td align="center">
  <?php echo $page_cont; ?>
  </td>
</tr>
</table>
<br>
<form action="send_newsletter.php" method="post">
<?php echo $table_content; ?>
    <input type="hidden" name="count" value="<?php echo $sno; ?>">
    </form>

</div>
<script language="JavaScript" src="js/datetimepicker.js"></script>
	<link type="text/css" rel="stylesheet" href="css/jquery-ui-1.7.2/themes/base/ui.all.css" />
	<link type="text/css" href="css/ui.multiselect.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="js/plugins/localisation/jquery.localisation-min.js"></script>
	<script type="text/javascript" src="js/plugins/scrollTo/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="js/ui.multiselect.js"></script>
 
  <style>
    .multiselect {
height:300px;
width:550px;
}
  </style>
 
<script>
  
  function validation()
  {
        var frm = document.form1;
        
        if(frm.fields1.value == "" && frm.fields2.value == "" && frm.fields3.value == "" && frm.fields4.value == "" && frm.fields5.value == "")
        {
          alert("Please select atleast one conditional field");
          return false;
        }
   
        if(frm.fields1.value != "")
        {
              if(frm.condition1.value == "")
              {
                 alert("Please enter your condition 1");
                 return false;
              }
              if(frm.condition1.value == "Between dates")
              {
                    if(frm.condition_value1_from.value == "")
                    {
                       alert("Please enter your from date");
                       frm.condition_value1_from.focus();
                       return false;
                    }
                    if(frm.condition_value1_to.value == "")
                    {
                       alert("Please enter your to date");
                       frm.condition_value1_to.focus();
                       return false;
                    }
              }
              else
              {
                if(frm.condition_value1.value == "")
                {
                   alert("Please enter your condition value 1");
                   return false;
                }
              }
              
        } 
        if(frm.fields2.value != "")
        {
              if(frm.condition2.value == "")
              {
                 alert("Please enter your condition 2");
                 return false;
              }
               if(frm.condition2.value == "Between dates")
              {
                    if(frm.condition_value2_from.value == "")
                    {
                       alert("Please enter your from date");
                       frm.condition_value2_from.focus();
                       return false;
                    }
                    if(frm.condition_value2_to.value == "")
                    {
                       alert("Please enter your to date");
                       frm.condition_value2_to.focus();
                       return false;
                    }
              }
              else
              {
                  if(frm.condition_value2.value == "")
                  {
                     alert("Please enter your condition value 2");
                     return false;
                  }
              }
              
        } 
        if(frm.fields3.value != "")
        {
              if(frm.condition3.value == "")
              {
                 alert("Please enter your condition 3");
                 return false;
              }
               if(frm.condition3.value == "Between dates")
              {
                    if(frm.condition_value3_from.value == "")
                    {
                       alert("Please enter your from date");
                       frm.condition_value3_from.focus();
                       return false;
                    }
                    if(frm.condition_value3_to.value == "")
                    {
                       alert("Please enter your to date");
                       frm.condition_value3_to.focus();
                       return false;
                    }
              }
              else
              {
                if(frm.condition_value3.value == "")
                {
                   alert("Please enter your condition value 3");
                   return false;
                }
              }
             
        } 
        if(frm.fields4.value != "")
        {
              if(frm.condition4.value == "")
              {
                 alert("Please enter your condition 4");
                 return false;
              }
               if(frm.condition4.value == "Between dates")
              {
                    if(frm.condition_value4_from.value == "")
                    {
                       alert("Please enter your from date");
                       frm.condition_value4_from.focus();
                       return false;
                    }
                    if(frm.condition_value4_to.value == "")
                    {
                       alert("Please enter your to date");
                       frm.condition_value4_to.focus();
                       return false;
                    }
              }
              else
              {
                if(frm.condition_value4.value == "")
                {
                   alert("Please enter your condition value 4");
                   return false;
                }
              }
             
        } 
        if(frm.fields5.value != "")
        {
              if(frm.condition5.value == "")
              {
                 alert("Please enter your condition 5");
                 return false;
              }
              if(frm.condition5.value == "Between dates")
              {
                    if(frm.condition_value5_from.value == "")
                    {
                       alert("Please enter your from date");
                       frm.condition_value5_from.focus();
                       return false;
                    }
                    if(frm.condition_value5_to.value == "")
                    {
                       alert("Please enter your to date");
                       frm.condition_value5_to.focus();
                       return false;
                    }
              }
              else
              {
                if(frm.condition_value5.value == "")
                {
                   alert("Please enter your condition value 5");
                   return false;
                }
              }
              
        }   
        
        var obj = document.getElementsByName("output_fields[]");
        if(frm.output_fields.value == "")
        {
            alert("Please select atleast one output field to display");
             return false;
        }
        
                                
        frm.action = "http://www.superrecords.com.au/admin/send_newsletter.php";
        frm.submit();
        return false;
  }
  function cond_fields(rep_val)
  {
        /*if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange=function()
        {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
            document.getElementById("mm").innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("POST","ajax.php",true);
      xmlhttp.send();
      */
      
      $(document).ready(function() {
            $.ajax({
                url: "ajax.php",
                type:"POST",
                cache: false,
                data:{process_type:"condition_fields",report:rep_val},
                success: function(msg){
                  //$("#report").text(html);
                  //document.getElementById("fields").innerHTML = msg;
                  $("#fields").html(msg);
                }
            });
      });
      
  }
  function select_fields(sel_val,cond,val,count)
  {
   
      var field_list=new Array();
      for(var i=1;i<6;i++)
      {
          if(i != count)
          {
              var vals = document.getElementById("fields"+i).value;
              if(vals != "")
                   field_list.push(vals);
          }
         
      }
      var current_value = document.getElementById("fields"+count).value;
      //alert(current_value);
      //alert(field_list);
      if(field_list.length > 0)
      {
        var res = array_check(field_list,current_value);
        if(!res)
        {
          alert("This field already selected.Please choose another one");
          document.getElementById("fields"+count).value = "";
          //document.getElementById("condition"+count).value = "";
          return false;
        }
      }
     
      $(document).ready(function() {
             $.ajax({
                url: "ajax.php",
                type:"POST",
                cache: false,
                data:{process_type:"select_fields",field:sel_val,condition:cond,condition_value:val,field_count:count},
                success: function(msg){
                   
                    var msg_split = msg.split("~~");
                    //document.getElementById("condition"+count).innerHTML = msg_split[0];
                    $("#condition"+count).html(msg_split[0]);
                    //$("div #condition_value"+count).remove();
                    $("#value_for_condition"+count+" *").remove();
                    $("#value_for_condition"+count).append(msg_split[1]);
                    
                    /*if($("#condition_value"+count).hasClass("datepicker"))
                    {
                      $(function() 
                      {
                    		$("#condition_value"+count).datepicker();     
                    	}); 
                                                    
                    } */
                    
                }
            });
      });
      
  }
 function printpage()
 {
  window.print();
 }
 
 function array_check(arr, obj) {
  var flag=true;
  for(var i=0; i<arr.length; i++) {
    if (arr[i] == obj) 
           flag = false;
  }
  return flag;
}
function select_conditions(obj,count,val1,val2)
{
          if(obj == "Pending")
          {
            $("#value_for_condition"+count+" *").remove();
            //$("#value_for_condition"+count+" img").remove();
            //$("#value_for_condition"+count+" input").remove();
            
            var element_name = "condition_value"+count;
            
            var fld = "<input type='text'  name='"+element_name+"' id='"+element_name+"' value='date is null'  readonly />";
            $("#value_for_condition"+count).append(fld);
            
          }
          else if(obj == "Between dates")
          {
            
                $(document).ready(function() {
                      $.ajax({
                          url: "ajax.php",
                          type:"POST",
                          cache: false,
                          data:{process_type:"between_dates",field_count:count},
                          success: function(msg){
                     //alert(msg);
                     //alert(val1);
                     //alert(val2);
                              $("#value_for_condition"+count+" *").remove();
                             // $("#value_for_condition"+count+" img").remove();
                             // $("#value_for_condition"+count+" input").remove();
                              $("#value_for_condition"+count).append(msg);
                              $("#condition_value"+count+"_from").val(val1);
                              $("#condition_value"+count+"_to").val(val2);
                                                            
                          }
                      });
                });
          }
          else if(obj == "On" || obj == "Before" || obj == "After" || obj == "Before or On" || obj == "After or On")
          {
             $("#value_for_condition"+count+" *").remove();
            //$("#value_for_condition"+count+" img").remove();
            //$("#value_for_condition"+count+" input").remove();
            
            var element_name = "condition_value"+count;
            
            var fld = "<input type='text'  name='"+element_name+"' id='"+element_name+"' /><a href=javascript:NewCal('"+element_name+"','ddmmyyyy',false,24) ><img src='images/cal.gif' width='16' height='16' border='0' alt='Click Here to Pick up the timestamp'></a>";
            $("#value_for_condition"+count).append(fld);
          }
 
      
}
function pagination(page)
{
  document.form1.action = "http://www.superrecords.com.au/admin/send_newsletter.php?page="+page;
  document.form1.submit();
  return false;
}

  
</script>
<?php echo $script_content; ?>
 <script type="text/javascript">
		$(function(){
			//$.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
			$(".multiselect").multiselect();
			//$('#switcher').themeswitcher();
		});
	</script>
</body>
</html>
