$(document).ready(function() {
	
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
        if(!($('#taAsset').val())) {
            taAsset.className = "errclass";
            flagReturn = false;
        }
        else taAsset.className = "";
        
        return flagReturn;
    });
    
});