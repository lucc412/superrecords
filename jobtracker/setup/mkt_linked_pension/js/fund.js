$(document).ready(function() 
{
    
    $('#frmFund').submit(function() {
        
        var flagReturn = true; 

        if(!($('#txtFund').val())) {
            txtFund.className = "errclass";
            flagReturn = false;
        }
        else txtFund.className = "";

        if(!($('#mtAdd').val())) {
            mtAdd.className = "errclass";
            flagReturn = false;
        }
        else mtAdd.className = "";

        return flagReturn;
    });
    
});