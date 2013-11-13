$(document).ready(function() {
	
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
        
        if(!($('#txtObj').val())) {
            txtObj.className = "errclass";
            flagReturn = false;
        }
        else txtObj.className = "";
        
        flagChecked = false;
        $('[id^=insurance]').each(function (){
            if(this.checked) {
                flagChecked = true;
            }
        });
        
        if(!flagChecked) {
            alert('Please tick atleast one of the Insurance Details');
            flagReturn = false;
        }
        
        return flagReturn;
    });
    
});