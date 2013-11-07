/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var objStates
var objCntry

$(document).ready(function(){
    
    $.getJSON('/jobtracker/setup/standard_company/officer_details.php',{ doAction: 'state' },function(result){
        objStates = result;
    });
    
    $.getJSON('/jobtracker/setup/standard_company/officer_details.php',{ doAction: 'country' },function(result){
        objCntry = result;
    });
    
    // on submit validation
    $('#frmOfficer').submit(function() {
        flagReturn = true;
        
        // Registered Address
        if($('#selOfficers').val() == 0) {
            selOfficers.className = "errclass";
            flagReturn = false;
        }
        else selOfficers.className = "";
        
        $('[id^=txtFname]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=txtLname]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=txtDob]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=txtCob]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=selSob]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=selCntryob]').each(function (){
            if($(this).val() == 0) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=txtTFN]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=offAddBuild]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=offAddStreet]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=offAddSubrb]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=offAddState]').each(function (){
            if($(this).val() == 0) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=offAddPstCode]').each(function (){
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

function addOfficers()
{
    
    var child = $('#dvOfficer').children().length;
    var offcrCnt = parseInt($('#selOfficers').val());
    var states = '';
    var country = '';
    var cntr = 1;    
    
    if ((child + (offcrCnt-child)) > 10)
    {
        alert("you cannot enter more than 10 officer")
        return
    }
    else if ((child + (offcrCnt-child)) <= 10)
    {
        if(child != 0)
        {
            if(offcrCnt > child)
            {
                cntr = ++child;
                                
            }
            else if(offcrCnt < child)
            {
                for(var k = child; k > offcrCnt; k--)
                {
                    $('#officer_'+k).remove();
                }
                return
            }    
            else if(offcrCnt == child)
            {
                cntr = child++;
            }    
        }
    }   
    
    
    $.each( objStates, function( key, val ) {
        states += '<option value="'+key+'">'+val+'</option>';
    });
    
    $.each( objCntry, function( key, val ) {
        country += '<option value="'+key+'">'+val+'</option>';
    });

    for(var i = cntr;i <= offcrCnt; i++)
    {
        
        $('#dvOfficer').append('<div id="officer_'+i+'"> <div style="padding:10px 0;color: #F05729;font-size: 14px;">Officer '+i+':</div>\n\
                                <table class="fieldtable">\n\
                                    <tr><td>First name </td>\n\
                                    <td><input type="text" id="txtFname_'+i+'" name="txtFname['+i+']"  /></td></tr>\n\
                                    <tr><td>Middle name </td>\n\
                                    <td><input type="text" id="txtMname_'+i+'" name="txtMname['+i+']"  /></td></tr>\n\
                                    <tr><td>Last name </td>\n\
                                    <td><input type="text" id="txtLname_'+i+'" name="txtLname['+i+']"  /></td></tr>\n\
                                    <tr><td>Date of birth </td>\n\
                                    <td><input type="text" id="txtDob_'+i+'" name="txtDob['+i+']"  readonly /><img src="../../images/calendar.png" id="calImgId" onclick="javascript:NewCssCal(\'txtDob_'+i+'\',\'ddMMyyyy\',\'dropdown\',false,24,false,\'past\')" align="middle" class="calendar"/></td></tr>\n\
                                    <tr><td>City of birth </td>\n\
                                    <td><input type="text" id="txtCob_'+i+'" name="txtCob['+i+']"  /></td></tr>\n\
                                    <tr><td>State and Country of birth </td>\n\
                                    <td><input type="text" id="selSob_'+i+'" name="selSob['+i+']"  placeholder="State"/>\n\
                                    <select id="selCntryob_'+i+'" name="selCntryob['+i+']" style="margin-bottom:5px; width:180px;" >\n\
                                        <option value="0">Select Country</option>'+country+'\n\
                                    </select><br>\n\
                                    </td></tr>\n\
                                    <tr><td>Tax File Number </td>\n\
                                    <td><input type="text" id="txtTFN_'+i+'" name="txtTFN['+i+']" /></td></tr>\n\
                                    <tr><td>Residential Address </td>\n\
                                    <td><div>\n\
                                        <input type="text" id="offAddUnit_'+i+'" name="offAddUnit['+i+']" style="width:115px;" value="" placeholder="Unit number" />\n\
                                        <input type="text" id="offAddBuild_'+i+'" name="offAddBuild['+i+']" style="width:115px;" value="" placeholder="Building" />\n\
                                        <input type="text" id="offAddStreet_'+i+'" name="offAddStreet['+i+']" style="width:115px;" value="" placeholder="Street"/><br>\n\
                                        <input type="text" id="offAddSubrb_'+i+'" name="offAddSubrb['+i+']" style="width:115px;" value="" placeholder="Suburb"/>\n\
                                        <select id="offAddState_'+i+'" name="offAddState['+i+']" style="margin-bottom:5px; width:180px;" >\n\
                                            <option value="0">Select State</option>'+states+'\n\
                                        </select><br>\n\
                                        <input type="text" id="offAddPstCode_'+i+'" name="offAddPstCode['+i+']" value="" placeholder="Post Code"/>\n\
                                    </div>\n\
                                </td>\n\
                            </tr></table></div>\n\
                        ');
    }
    
}