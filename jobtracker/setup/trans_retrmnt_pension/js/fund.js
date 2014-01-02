$(document).ready(function() 
{
    
    $('#frmFund').submit(function() {
        
        var flagReturn = true; 

        if(!($('#txtFund').val())) {
            txtFund.className = "errclass";
            flagReturn = false;
        }
        else txtFund.className = "";

        if(!($('#mtAddBuild').val())) {
            mtAddBuild.className = "errclass";
            flagReturn = false;
        }
        else mtAddBuild.className = "";

        if(!($('#mtAddStreet').val())) {
            mtAddStreet.className = "errclass";
            flagReturn = false;
        }
        else mtAddStreet.className = "";

        if(!($('#mtAddSubrb').val())) {
            mtAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else mtAddSubrb.className = "";

        if($('#mtAddState').val() == 0) {
            mtAddState.className = "errclass";
            flagReturn = false;
        }
        else mtAddState.className = "";

        if(!($('#mtAddPstCode').val())) {
            mtAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else mtAddPstCode.className = "";

        return flagReturn;
    });
    
});