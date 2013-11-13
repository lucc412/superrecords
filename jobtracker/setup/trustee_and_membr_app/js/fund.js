$(document).ready(function() 
{
    
    $('#frmFund').submit(function() {
        
        var flagReturn = true; 

        if(!($('#txtFund').val())) {
            txtFund.className = "errclass";
            flagReturn = false;
        }
        else txtFund.className = "";

        if(!($('#txtNwDirctr').val())) {
            txtNwDirctr.className = "errclass";
            flagReturn = false;
        }
        else txtNwDirctr.className = "";

        if(!($('#resAddBuild').val())) {
            resAddBuild.className = "errclass";
            flagReturn = false;
        }
        else resAddBuild.className = "";

        if(!($('#resAddStreet').val())) {
            resAddStreet.className = "errclass";
            flagReturn = false;
        }
        else resAddStreet.className = "";

        if(!($('#resAddSubrb').val())) {
            resAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else resAddSubrb.className = "";

        if($('#resAddState').val() == 0) {
            resAddState.className = "errclass";
            flagReturn = false;
        }
        else resAddState.className = "";

        if(!($('#resAddPstCode').val())) {
            resAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else resAddPstCode.className = "";
        
        if(!($('#txtDob').val())) {
            txtDob.className = "errclass";
            flagReturn = false;
        }
        else txtDob.className = "";

        return flagReturn;
    });
    
});