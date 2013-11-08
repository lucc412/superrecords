/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    // on submit validation
    $('#frmCompany').submit(function() {
        flagReturn = true;
        
        if(!$('#txtCompPref0').val()) {
            txtCompPref0.className = "errclass";
            flagReturn = false;
        }
        else txtCompPref0.className = "";
        
        return flagReturn;
    });
});