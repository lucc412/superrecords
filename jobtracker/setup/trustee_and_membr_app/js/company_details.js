$(document).ready(function() 
{
    $('#frmCompDtls').submit(function() {
        
        var flagReturn = true; 

        if(!($('#txtCmpName').val())) {
            txtCmpName.className = "errclass";
            flagReturn = false;
        }
        else txtCmpName.className = "";

        if(!($('#txtACN').val())) {
            txtACN.className = "errclass";
            flagReturn = false;
        }
        else txtACN.className = "";

        if(!($('#txtRegAddr').val())) {
            txtRegAddr.className = "errclass";
            flagReturn = false;
        }
        else txtRegAddr.className = "";

        if($('#selNoDirtr').val() == 0) {
            selNoDirtr.className = "errclass";
            flagReturn = false;
        }
        else selNoDirtr.className = "";

        return flagReturn;
    });
    
});

function addDirectors()
{
    var child = $('#dvDirectors').children().length;
    var dirtrCnt = parseInt($('#selNoDirtr').val());
    var cntr = 1;    
    
    if ((child + (dirtrCnt-child)) > 4)
    {
        alert("you cannot enter more than 4 Directors")
        return
    }
    else if ((child + (dirtrCnt-child)) <= 4)
    {
        if(child != 0)
        {
            if(dirtrCnt > child)
            {
                cntr = ++child;
                                
            }
            else if(dirtrCnt < child)
            {
                for(var k = child; k > dirtrCnt; k--)
                {
                    $('#dvDirtr_'+k).remove();
                }
                return
            }    
            else if(dirtrCnt == child)
            {
                cntr = child++;
            }    
        }
    } 
    
    for(var i = cntr;i <= dirtrCnt; i++)
    {
        $('#dvDirectors').append('<div id="dvDirtr_'+i+'" >\n\
                                        <table class="fieldtable">\n\
                                            <tr>\n\
                                                <td><input type="text" id="txtDirctrName_'+i+'" name="txtDirctrName['+i+']" placeholder="Director Name '+i+'" /></td>\n\
                                            </tr>\n\
                                        </table>\n\
                                    </div>\n\
                                    ');
    }
}