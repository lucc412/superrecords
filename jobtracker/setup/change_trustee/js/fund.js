$(document).ready(function() {
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
        if(!($('#txtTrust').val())) {
            txtTrust.className = "errclass";
            flagReturn = false;
        }
        else txtTrust.className = "";
        
        return flagReturn;
    });
    
});