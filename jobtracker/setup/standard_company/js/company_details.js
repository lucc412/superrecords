/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    checkExistingBusiness();
    
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
        
        if($('#selExtBusName').val() == 1 && $('#selRegBusns').val() == 0) {
            if($('#txtRegNo').val() == 0) {
                txtRegNo.className = "errclass";
                flagReturn = false;
            }
            else txtRegNo.className = "";
        }
        
        if($('#selExtBusName').val() == 1 && $('#selRegBusns').val() == 1) {
            if($('#txtABN').val() == 0) {
                txtABN.className = "errclass";
                flagReturn = false;
            }
            else txtABN.className = "";
        }
       
        return flagReturn;
    });
});

function checkExistingBusiness()
{
    if($('#selExtBusName').val() == 1)
    {
        $('#trRegBusns').addClass('show').removeClass('hide');
        checkBusnsReg()
    }
    else
    {
        $('#trRegBusns').addClass('hide').removeClass('show');
        checkBusnsReg()
        $('#trABN').addClass('hide').removeClass('show');
        $('#trState').addClass('hide').removeClass('show');
        $('#trRegNo').addClass('hide').removeClass('show');
    }
}

function checkBusnsReg()
{
    if($('#selRegBusns').val() == 1)
    {
        $('#trABN').addClass('show').removeClass('hide');
        $('#trState').addClass('hide').removeClass('show');
        $('#trRegNo').addClass('hide').removeClass('show');
    }
    else
    {
        $('#trABN').addClass('hide').removeClass('show');
        $('#trState').addClass('show').removeClass('hide');
        $('#trRegNo').addClass('show').removeClass('hide');
    }
}