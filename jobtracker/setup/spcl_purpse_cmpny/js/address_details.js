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
        if(!$('#regAddBuild').val()) {
            regAddBuild.className = "errclass";
            flagReturn = false;
        }
        else regAddBuild.className = "";
        
        if(!$('#regAddStreet').val()) {
            regAddStreet.className = "errclass";
            flagReturn = false;
        }
        else regAddStreet.className = "";
        
        if(!$('#regAddSubrb').val()) {
            regAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else regAddSubrb.className = "";
        
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
        
        if($('#selCompAddr').val() == 0) {
            if(!$('#txtOccpName').val()) {
                txtOccpName.className = "errclass";
                flagReturn = false;
            }
            else txtOccpName.className = "";
        }
        
        // business Address
        if(!$('#busAddBuild').val()) {
            busAddBuild.className = "errclass";
            flagReturn = false;
        }
        else busAddBuild.className = "";
        
        if(!$('#busAddStreet').val()) {
            busAddStreet.className = "errclass";
            flagReturn = false;
        }
        else busAddStreet.className = "";
        
        if(!$('#busAddSubrb').val()) {
            busAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else busAddSubrb.className = "";
        
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
        if(!$('#metAddBuild').val()) {
            metAddBuild.className = "errclass";
            flagReturn = false;
        }
        else metAddBuild.className = "";
        
        if(!$('#metAddStreet').val()) {
            metAddStreet.className = "errclass";
            flagReturn = false;
        }
        else metAddStreet.className = "";
        
        if(!$('#metAddSubrb').val()) {
            metAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else metAddSubrb.className = "";
        
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


