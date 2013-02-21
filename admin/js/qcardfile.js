 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 32 || charCode > 57 ))
            return false;
            return true;
      }
function showClients(hasrelatedentries)
	{
 		var strURL="views/showallclients.php?hasrelated="+hasrelatedentries+"&cardfilecode="+document.qcardfile.cde_CardFileCode.value;
		var req = getXMLHTTP();
		if (req)
			 {
				req.onreadystatechange = function()
				{
					if (req.readyState == 4)
					{
						// only if "OK"
						if (req.status == 200)
						{
							   document.getElementById('allclients').innerHTML=req.responseText;
						}
					}
				}
				req.open("GET", strURL, true);
				req.send(null);
			}
	}
