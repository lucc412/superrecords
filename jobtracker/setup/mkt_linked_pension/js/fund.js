$(document).ready(function() 
{
    
    $('#frmFund').submit(function() {
        
        var flagReturn = true; 

        if(!($('#txtFund').val())) {
            txtFund.className = "errclass";
            flagReturn = false;
        }
        else txtFund.className = "";

        
        if(!($('#metAddBuild').val())) {
            metAddBuild.className = "errclass";
            flagReturn = false;
        }
        else metAddBuild.className = "";
        
        if(!($('#metAddStreet').val())) {
            metAddStreet.className = "errclass";
            flagReturn = false;
        }
        else metAddStreet.className = "";
        
        if(!($('#metAddSubrb').val())) {
            metAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else metAddSubrb.className = "";
        
        if($('#metAddState').val() == 0) {
            metAddState.className = "errclass";
            flagReturn = false;
        }
        else metAddState.className = "";
        
        if(!($('#metAddPstCode').val())) {
            metAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else metAddPstCode.className = "";
        
        if($('#metAddCntry').val() == 0) {
            metAddCntry.className = "errclass";
            flagReturn = false;
        }
        else metAddCntry.className = "";

        return flagReturn;
    });
    
});