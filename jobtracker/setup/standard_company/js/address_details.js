/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    checkCompAddress();
    
    // on submit validation
    $('#frmAddress').submit(function() {
        flagReturn = true;
        
        // Registered Address
        if(!$('#regAddUnit').val()) {
            regAddUnit.className = "errclass";
            flagReturn = false;
        }
        else regAddUnit.className = "";
        
        if($('#regAddState').val() == 0) {
            regAddState.className = "errclass";
            flagReturn = false;
        }
        else regAddState.className = "";
        
        if(!$('#regAddPstCode').val()) {
            regAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else regAddPstCode.className = "";
        
        // business Address
        if(!$('#busAddUnit').val()) {
            busAddUnit.className = "errclass";
            flagReturn = false;
        }
        else busAddUnit.className = "";
        
        if($('#busAddState').val() == 0) {
            busAddState.className = "errclass";
            flagReturn = false;
        }
        else busAddState.className = "";
        
        if(!$('#busAddPstCode').val()) {
            busAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else busAddPstCode.className = "";
        
        // Meeting Address
        if(!$('#metAddUnit').val()) {
            metAddUnit.className = "errclass";
            flagReturn = false;
        }
        else metAddUnit.className = "";
        
        if($('#metAddState').val() == 0) {
            metAddState.className = "errclass";
            flagReturn = false;
        }
        else metAddState.className = "";
        
        if(!$('#metAddPstCode').val()) {
            metAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else metAddPstCode.className = "";
       
        return flagReturn;
    });
});


function checkCompAddress()
{
    if($('#selCompAddr').val() == 1)
    {
        $('#trOccpName').addClass('hide').removeClass('show');
    }
    else
    {
        $('#trOccpName').addClass('show').removeClass('hide');
    }
}


