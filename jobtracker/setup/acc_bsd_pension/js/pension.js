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

        if(!($('#txtPenAccBal').val()) || $('#txtPenAccBal').val() == 0) {
            txtPenAccBal.className = "errclass";
            flagReturn = false;
        }
        else txtPenAccBal.className = "";

        if(!($('#txtCurYrPay').val()) || $('#txtCurYrPay').val() == 0) {
            txtCurYrPay.className = "errclass";
            flagReturn = false;
        }
        else txtCurYrPay.className = "";
        
        if(!($('#txtTxFrePrcnt').val()) || $('#txtTxFrePrcnt').val() == 0) {
            txtTxFrePrcnt.className = "errclass";
            flagReturn = false;
        }
        else txtTxFrePrcnt.className = "";


//        if($('#metAddCntry').val() == 0) {
//            metAddCntry.className = "errclass";
//            flagReturn = false;
//        }
//        else metAddCntry.className = "";
        
        return flagReturn;
        
    });
    
});