/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//$(document).ready(function(){
//    checkCompAddress();
//});
//
//
//function checkCompAddress()
//{
//    if($('#selCompAddr').val() == 1)
//    {
//        $('#trOccpName').addClass('hide').removeClass('show');
//    }
//    else
//    {
//        $('#trOccpName').addClass('show').removeClass('hide');
//    }
//}


function addOfficers()
{
    //alert($('#selOfficers').val());
    for(var i = 1;i <= $('#selOfficers').val(); i++)
    {
        $('#dvOfficer').append('<div style="padding-bottom:20px;color: #F05729;font-size: 14px;">Officer '+i+'</div>');
    }
    
}