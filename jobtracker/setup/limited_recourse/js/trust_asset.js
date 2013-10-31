$(document).ready(function() {
	
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
        if(!($('#taAsset').val())) {
            taAsset.className = "errclass";
            flagReturn = false;
        }
        else taAsset.className = "";
        
        if(!($('#txtLoan').val())) {
            txtLoan.className = "errclass";
            flagReturn = false;
        }
        else txtLoan.className = "";
        
        if(!($('#txtYear').val())) {
            txtYear.className = "errclass";
            flagReturn = false;
        }
        else txtYear.className = "";
        
        return flagReturn;
    });
    
});