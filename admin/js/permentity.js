                function entity_function(val,type)
                {
                  if(type == 'save' || type == 'delete')
                  {
                      if(document.getElementById('fname_'+val).value == '')
                      {
                        alert('Enter First Name');
                        return false;
                      }
                      if(document.getElementById('lname_'+val).value == '')
                      {
                        alert('Enter Last Name');
                        return false;
                      }
                      /*if(document.getElementById('date_'+val).value == '')
                      {
                        alert('Enter Date');
                        return false;
                      }
                      if(document.getElementById('tfn_'+val).value == '')
                      {
                        alert('Enter TFN');
                        return false;
                      } */
                  }
                  if(type == 'delete')
                  {
                        if(!confirm("Do you want to delete this record?"))
                        {
                          return false;
                        }
                  }
                   document.perminfoedit.action = 'dbclass/entity_db_class.php?sno='+val+'&type='+type;
                   document.perminfoedit.submit();
                   return false;
                }
