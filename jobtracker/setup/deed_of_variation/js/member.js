/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var objCntry

$(document).ready(function(){
    
    $.getJSON('/jobtracker/setup/change_trustee/member.php',{ doAction: 'country' },function(result){
        objCntry = result;
    });
    
    // on submit validation
    $('#frmMember').submit(function() {
        flagReturn = true;
        
        // Registered Address
        if($('#selMembers').val() == 0) {
            selMembers.className = "errclass";
            flagReturn = false;
        }
        else selMembers.className = "";
        
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
        
        $('[id^=selCntryob]').each(function (){
            if($(this).val() == 0) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=txtResAdd]').each(function (){
            if(!$(this).val()) {
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
        
        return flagReturn;
    });
});

function addMembers()
{
    
    var child = $('#divMember').children().length;
    var offcrCnt = parseInt($('#selMembers').val());
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
                    $('#member_'+k).remove();
                }
                return
            }    
            else if(offcrCnt == child)
            {
                cntr = child++;
            }    
        }
    }   
    
    $.each( objCntry, function( key, val ) {
        country += '<option value="'+key+'">'+val+'</option>';
    });

    for(var i = cntr;i <= offcrCnt; i++)
    {
        
        $('#divMember').append('<div id="member_'+i+'"> <div style="padding:10px 0;color: #F05729;font-size: 14px;">Member '+i+':</div>\n\
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
                                    <tr><td>Country of birth </td>\n\
                                    <td><select id="selCntryob_'+i+'" name="selCntryob['+i+']" style="margin-bottom:5px; width:180px;" >\n\
                                        <option value="0">Select Country</option>'+country+'\n\
                                    </select><br>\n\
                                    </td></tr>\n\
                                    <tr><td>Residential Address </td>\n\
                                    <td><input type="text" id="txtResAdd_'+i+'" name="txtResAdd['+i+']" /></td></tr>\n\
                                    <tr><td>Tax File Number </td>\n\
                                    <td><input type="text" id="txtTFN_'+i+'" name="txtTFN['+i+']" /></td></tr>\n\
                                </table></div>\n\
                        ');
    }
    
}