/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    // on submit validation
    $('#frmCompany').submit(function() {
        flagReturn = true;
        $('[id^=txtCompPref]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        return flagReturn;
    });
});