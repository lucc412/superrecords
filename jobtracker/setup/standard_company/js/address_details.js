/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    checkCompAddress();
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


