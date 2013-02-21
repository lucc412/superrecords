  function validation()
  {
        var frm = document.form1;
        var aid = document.getElementById('maxid').value;
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


        frm.action = "custom_worksheet_report.php?aid="+aid;
        frm.submit();
        return false;
  }
  function saveCondition(scode,title)
{
     document.getElementById('fields1').value = "";
     document.getElementById('fields2').value = "";
     document.getElementById('fields3').value = "";
     document.getElementById('fields4').value = "";
     document.getElementById('fields5').value = "";
     $(document).ready(function() {
             document.getElementById('img_load').innerHTML = '<img src="images/loading.gif" />';
             $.ajax({
                url: "custom_worksheet_ajax.php",
                type:"POST",
                async:true,
                data:{stfcode:scode,subject:title},
                success: function(msg){
                     var msg_split = msg.split("~~")
                     var field = msg_split[0];
                     var cond = msg_split[1];
                     var outval = msg_split[2];
                     var outfield = msg_split[3];
                     var sub = msg_split[4];
                     var autoid = msg_split[5];
                     var msg_field = field.split("^");
                     var msg_cond = cond.split("^");
                     var msg_outval = outval.split("^");
                     var msg_outfield = outfield.split("^");
                     for(var j=1; j<(msg_field.length); j++) {
                        document.getElementById('fields'+j).value = msg_field[j];
                        if(msg_field[j]=="wrk_ClientCode") {
                            var cmp = msg_outval[j].split(",");
                            msg_outval[j] = cmp[0];
                            var cmpname = cmp[1];
                        }
                        select_fields(msg_field[j],msg_cond[j],msg_outval[j],j,cmpname);
                        if(msg_cond[j]=="Between dates") {
                            var msg_between = msg_outval[j].split(",");
                            var msg_outvalfrm = msg_between[0];
                            var msg_outvalto = msg_between[1];
                            select_conditions(msg_cond[j],j,msg_outvalfrm,msg_outvalto);
                        }
                     }
                     document.getElementById('cwr_Title').value = sub;
                     document.getElementById('saveid').value = autoid;
                     document.getElementById('butUpdate').style.display='block';
                     if(document.getElementById('sUpdate')) document.getElementById('sUpdate').style.display='none';
                     if(document.getElementById('butSave')) document.getElementById('butSave').style.display='none';
                     if(document.getElementById('saveAs')) document.getElementById('saveAs').style.display='none';
                     document.getElementById('saveAsreport').style.display='block';
                     document.getElementById('showgrid').style.display='none';
                var arr = msg_outfield;
                $(".remove-all").click();
                $('.connected-list li').each(function(){
                              if(in_array($(this).attr("title"),arr))
                              {
                                 $(this).children('a').click();
                              }
                          });
                          document.getElementById('img_load').innerHTML = '';
      }
            });
      });
}
function in_array(p_val,arr)
  {
    for(var i = 0, l = arr.length; i < l; i++) {
    if(arr[i] == p_val) {
       return true;
      }
     }
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
                url: "worksheet_ajax.php",
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
  function select_fields(sel_val,cond,val,count,cmp)
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
                url: "worksheet_ajax.php",
                type:"POST",
                cache: false,
				async:false,
                data:{process_type:"select_fields",field:sel_val,condition:cond,condition_value:val,field_count:count,compname:cmp},
                success: function(msg){
                    var msg_split = msg.split("~~");
                    //document.getElementById("condition"+count).innerHTML = msg_split[0];
                    $("#condition"+count).html(msg_split[0]);
                    //$("div #condition_value"+count).remove();
                    $("#value_for_condition"+count+" *").remove();
                    $("#value_for_condition"+count).append(msg_split[1]);
                    if(msg_split[2] == "auto")
                            callit(count);

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
                          url: "worksheet_ajax.php",
                          type:"POST",
                          cache: false,
                          data:{process_type:"between_dates",field_count:count},
                          success: function(msg){
                     //alert(msg);
                     //alert(val1);
                     //alert(val2);
                              //$("#value_for_condition"+count+" *").remove();
                             // $("#value_for_condition"+count+" img").remove();
                             // $("#value_for_condition"+count+" input").remove();
                              $("#value_for_condition"+count).html(msg);
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
function saveSubmit()
{
    document.getElementById('hiSave').value = "save";
    var sub = document.getElementById('cwr_Title').value;
    if(sub=="") {
        alert('Enter Report Name');
        document.getElementById('cwr_Title').focus();
        return false;
    }
    validation();return false;
}
function saveasSubmit()
{
    document.getElementById('hiSave').value = "save";
    var mid = document.getElementById('maxid').value;
    document.getElementById('saveid').value = mid;
    var sub = document.getElementById('cwr_Title').value;
    if(sub=="") {
        alert('Enter Report Name');
        document.getElementById('cwr_Title').focus();
        return false;
    }
    validation();return false;
}

function updateSubmit()
{
    document.getElementById('hiUpdate').value = "update";
    var sub = document.getElementById('cwr_Title').value;
    if(sub=="") {
        alert('Enter Report Name');
        document.getElementById('cwr_Title').focus();
        return false;
    }
    validation();return false;
}

function pagination(page,aid)
{
  document.form1.action = "custom_worksheet_report.php?aid="+aid+"&page="+page;
  document.form1.submit();
  return false;
}



function callit(count)
{
    var options = {
					script:"dbclass/wrk_client_db_class.php?json=true&limit=6&",
					varname:"input",
					json:true,
					shownoresults:false,
					maxresults:6,
					callback: function (obj) {document.getElementById('clientid').value = obj.id; }
					};
    					var as_json = new bsn.AutoSuggest('compname'+count, options);
}

		$(function(){
			//$.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
			$(".multiselect").multiselect();
			//$('#switcher').themeswitcher();
		});
