


function checkFeatures(chk) 
{
    var string = chk.split("|");
    
    //document.jobRights
}

function CheckAll_View(chk)
{
    var string = chk.split("|");

    if (document.jobRights.Check_ctr_view.checked == true)
    {
        for (i = 0; i < string.length; i++)
        {
            if (document.getElementById('stf_View[' + string[i] + "]"))
            {
                document.getElementById('stf_View[' + string[i] + "]").checked = true;
            }
        }
    }
    else
    {
        for (i = 0; i < string.length; i++)
        {
            if (document.getElementById('stf_View[' + string[i] + "]"))
            {
                document.getElementById('stf_View[' + string[i] + "]").checked = false;
            }
        }
    }
}

function ConfirmCancel()
{
    var r = confirm("Are you sure you want to cancel?");
    
    if (r == true)
    {
        window.location.href = "stf_staff.php?a=edit&recid="+document.jobRights.recid.value;
    }
    else
    {
        return false;
    }
}