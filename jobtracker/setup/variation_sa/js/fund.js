$(document).ready(function() {
    // on submit validation
    $('#frmFund').submit(function() {
        flagReturn = true;
        
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
        
        if(!($('#txtDtEstblshmnt').val())) {
            txtDtEstblshmnt.className = "errclass";
            flagReturn = false;
        }
        else txtDtEstblshmnt.className = "";
        
        if($('#txtDtVariation').val() == 0) {
            txtDtVariation.className = "errclass";
            flagReturn = false;
        }
        else txtDtVariation.className = "";
        
        if(!($('#txtVarCls').val())) {
            txtVarCls.className = "errclass";
            flagReturn = false;
        }
        else txtVarCls.className = "";
        
        return flagReturn;
    });
    
});