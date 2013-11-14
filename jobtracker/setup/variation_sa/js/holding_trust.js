$(document).ready(function() {
	
    // show hide corporate/individual section
    $('#lstType').change(function() {
        if($('#lstType').val() == '2') {
            $('#divCorporate').show();
        }
        else {
            $('#divCorporate').hide()
        }
    }); 
    
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
        
        if(!($('#lstType').val())) {
            lstType.className = "errclass";
            flagReturn = false;
        }
        else lstType.className = "";
        
        // validate corporate trustee part 
        if($('#lstType').val() == 2) {
            if(!($('#txtCompName').val())) {
                txtCompName.className = "errclass";
                flagReturn = false;
            }
            else txtCompName.className = "";

            if(!($('#txtAcn').val())) {
                txtAcn.className = "errclass";
                flagReturn = false;
            }
            else txtAcn.className = "";
            
            if(!($('#txtAdd').val())) {
                txtAdd.className = "errclass";
                flagReturn = false;
            }
            else txtAdd.className = "";
            
            if(!($('#dir0').val())) {
                dir0.className = "errclass";
                flagReturn = false;
            }
            else dir0.className = "";
        }
        
        return flagReturn;
    });
    
});