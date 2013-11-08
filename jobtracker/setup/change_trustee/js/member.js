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
        
        if(!($('#txtRate').val())) {
            txtRate.className = "errclass";
            flagReturn = false;
        }
        else txtRate.className = "";
        
        if(!($('#lstRateType').val())) {
            lstRateType.className = "errclass";
            flagReturn = false;
        }
        else lstRateType.className = "";
        
        if(!($('#lstLoanType').val())) {
            lstLoanType.className = "errclass";
            flagReturn = false;
        }
        else lstLoanType.className = "";
        
        return flagReturn;
    });
    
});