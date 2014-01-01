/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    
    $('#frmPension').submit(function() {
        var flagReturn = true;
        
        if(!($('#txtMembrName').val())) {
            txtMembrName.className = "errclass";
            flagReturn = false;
        }
        else txtMembrName.className = "";
        
        if(!($('#txtDob').val())) {
            txtDob.className = "errclass";
            flagReturn = false;
        }
        else txtDob.className = "";

        if(!($('#txtComncDt').val())) {
            txtComncDt.className = "errclass";
            flagReturn = false;
        }
        else txtComncDt.className = "";
 
 		if(!($('#condition_release').val())) {
            condition_release.className = "errclass";
            flagReturn = false;
        }
        else condition_release.className = "";
		
		if(!($('#txtterm_of_pension').val())) {
            txtterm_of_pension.className = "errclass";
            flagReturn = false;
        }
        else txtterm_of_pension.className = "";
		
        if(!($('#txtPenAccBal').val()) || $('#txtPenAccBal').val() == 0) {
            txtPenAccBal.className = "errclass";
            flagReturn = false;
        }
        else txtPenAccBal.className = "";
        
        if(!($('#txtTxFrePrcnt').val()) || $('#txtTxFrePrcnt').val() == 0) {
            txtTxFrePrcnt.className = "errclass";
            flagReturn = false;
        }
        else txtTxFrePrcnt.className = "";

        return flagReturn;
        
    });
    
});