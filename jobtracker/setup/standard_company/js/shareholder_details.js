/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var objShrCls;
var objStates
$(document).ready(function(){
    
    $.getJSON('/jobtracker/setup/standard_company/shareholder_details.php',{ doAction: 'share_class' },function(result){
        objShrCls = result;
    });
    
    $.getJSON('/jobtracker/setup/standard_company/officer_details.php',{ doAction: 'state' },function(result){
        objStates = result;
    });
    
    
    $('#frmShrhldr').submit(function() 
    {
        var flag = true;
        

        if($('#selShrHldr').val() == 0)
        {
            selShrHldr.className = "errclass";
            flag = false;
        }
        else
            selShrHldr.className = "";
        
        
        $('[id^=selShrType_]').each(function ()
        {
            
            var id = this.id;
            var splitId = id.split('_');
            var cntr = splitId[1];
            
            if($(this).val() == 1) 
            {
                if($('#txtCmpName_'+cntr).val() == 0)
                {
                    $('#txtCmpName_'+cntr).addClass("errclass");
                    flag = false;
                }
                else
                    $('#txtCmpName_'+cntr).removeClass("errclass");

            }
            else if($(this).val() == 2) 
            {
                if($('#txtFname_'+cntr).val() == 0)
                {
                    $('#txtFname_'+cntr).addClass("errclass");
                    flag = false;
                }
                else
                    $('#txtFname_'+cntr).removeClass("errclass");
                
                if($('#txtLname_'+cntr).val() == 0)
                {
                    $('#txtLname_'+cntr).addClass("errclass");
                    flag = false;
                }
                else
                    $('#txtLname_'+cntr).removeClass("errclass");
                
                
            }
            
            $('[id^=selShrCls_]').each(function ()
            {
                if($(this).val() == 0) {
                    $(this).addClass('errclass');
                    flag = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
            
            $('[id^=txtNoShares_]').each(function ()
            {
                if((!$(this).val())) {
                    $(this).addClass('errclass');
                    flag = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
            
        });
        
        return flag;
    });
   
});

function addDirectors(element,cnt)
{
    var child = $('#crpNoDirtr_'+cnt).children().length;
    var dirtrCnt = parseInt($('#selNoDirtr_'+cnt).val());
    var cntr = 1;    
    
    if ((child + (dirtrCnt-child)) > 10)
    {
        alert("you cannot enter more than 10 Directors")
        return
    }
    else if ((child + (dirtrCnt-child)) <= 10)
    {
        if(child != 0)
        {
            if(dirtrCnt > child)
            {
                cntr = ++child;
                                
            }
            else if(dirtrCnt < child)
            {
                for(var k = child; k > dirtrCnt; k--)
                {
                    $('#dvDirtr_'+cnt+k).remove();
                }
                return
            }    
            else if(dirtrCnt == child)
            {
                cntr = child++;
            }    
        }
    } 
    
    for(var i = cntr;i <= dirtrCnt; i++)
    {
        $('#crpNoDirtr_'+cnt).append('<div id="dvDirtr_'+cnt+i+'" >\n\
                                        <table class="fieldtable">\n\
                                            <tr>\n\
                                                <td><input type="text" id="txtFulName_'+cnt+i+'" name="txtFulName['+cnt+']['+i+']" placeholder="Director Name '+i+'" /></td>\n\
                                            </tr>\n\
                                        </table>\n\
                                    </div>\n\
                                    ');
    }
}

function changeShrHldrType(element,cnt)
{
    if($(element).val() == 1)
    {
        $('#trCrpShrHldr_'+cnt).addClass('show').removeClass('hide');
        $('#crpNoDirtr_'+cnt).addClass('show').removeClass('hide');
        $('#trIndShrHldr_'+cnt).addClass('hide').removeClass('show');
    }
    else
    {
        $('#trCrpShrHldr_'+cnt).addClass('hide').removeClass('show');
        $('#crpNoDirtr_'+cnt).addClass('hide').removeClass('show');
        $('#trIndShrHldr_'+cnt).addClass('show').removeClass('hide');
    }
}

function changeShrOwnBhlf(element,cnt)
{
    if($(element).val() == 1)
        $('#trShrOwnBhlf_'+cnt).addClass('show').removeClass('hide');
    else
        $('#trShrOwnBhlf_'+cnt).addClass('hide').removeClass('show');        
}

function addShrHldr()
{
    
    var child = $('#dvShrHldr').children().length;
    var shrHldrCnt = parseInt($('#selShrHldr').val());
    var shrclass = '';
    var noDirtr = ''; 
    var states = '';
    var cntr = 1;    
    
    if ((child + (shrHldrCnt-child)) > 10)
    {
        alert("you cannot enter more than 10 Share holder")
        return
    }
    else if ((child + (shrHldrCnt-child)) <= 10)
    {
        if(child != 0)
        {
            if(shrHldrCnt > child)
            {
                cntr = ++child;                                
            }
            else if(shrHldrCnt < child)
            {
                for(var k = child; k > shrHldrCnt; k--)
                {
                    $('#shrHldr_'+k).remove();
                }
                return
            }    
            else if(shrHldrCnt == child)
            {
                cntr = child++;
            }    
        }
    } 
    //
    
    $.each( objShrCls, function( key, val ) {
        shrclass += '<option value="'+key+'">'+val+'</option>';
    });
    
    $.each( objStates, function( key, val ) {
        states += '<option value="'+key+'">'+val+'</option>';
    });
    
    for(var j = 1;j <= 10;j++) 
    {
        noDirtr += '<option value="'+j+'">'+j+'</option>';
    }
    
    //shrclass
    for(var i = cntr;i <= shrHldrCnt; i++)
    {
        $('#dvShrHldr').append('<div id="shrHldr_'+i+'"> \n\
                                <div style="padding:20px 0 10px 0;color: #F05729;font-size: 14px;height:30px;width:196px;float:left">Shareholder '+i+': </div><div style="padding:10px 0;font-size:13px;width:500px">Type <select id="selShrType_'+i+'" name="selShrType['+i+']" style="margin-bottom:5px; width:180px;" onchange="changeShrHldrType(this,'+i+')" >\n\
                                                                                                                                                                            <option value="1">Corporate</option>\n\
                                                                                                                                                                            <option value="2">Individual</option>\n\
                                                                                                                                                                        </select>\n\
                                <div style="clear:both"></div>\n\
                                <table id="trCrpShrHldr_'+i+'" class="fieldtable hide" style="width:700px">\n\
                                    <tr>\n\
                                        <td>Company Name</td>\n\
                                        <td><input type="text" id="txtCmpName_'+i+'" name="txtCmpName['+i+']" placeholder="Company Name" /></td>\n\
                                    </tr>\n\
                                    <tr>\n\
                                        <td>ACN </td>\n\
                                        <td><input type="text" id="txtACN_'+i+'" name="txtACN['+i+']" placeholder="ACN" /></td>\n\
                                    </tr>\n\
                                    <tr>\n\
                                        <td>Registered Address </td>\n\
                                        <td><input type="text" id="txtRegAddr_'+i+'" name="txtRegAddr['+i+']" placeholder="Registered Address" /></td>\n\
                                    </tr>\n\
                                    <tr>\n\
                                        <td>Number of Director</td>\n\
                                        <td><select id="selNoDirtr_'+i+'" name="selNoDirtr['+i+']" style="margin-bottom:5px; width:180px;" onchange="addDirectors($(\'#trCrpShrHldr_'+i+'\'),'+i+')" >\n\
                                            <option value="0">Select no of Director`s</option>'+noDirtr+'\n\
                                        </select></td>\n\
                                    </tr>\n\
                                </table>\n\
                                <div id="crpNoDirtr_'+i+'" class="hide" style="margin-left:228px;width:auto"></div>\n\
                                <table id="trIndShrHldr_'+i+'" class="fieldtable hide" style="width:1050px">\n\
                                    <tr><td>First name </td>\n\
                                    <td><input type="text" id="txtFname_'+i+'" name="txtFname['+i+']" placeholder="First Name" /></td></tr>\n\
                                    <tr><td>Middle name </td>\n\
                                    <td><input type="text" id="txtMname_'+i+'" name="txtMname['+i+']" placeholder="Middle Name" /></td></tr>\n\
                                    <tr><td>Last name </td>\n\
                                    <td><input type="text" id="txtLname_'+i+'" name="txtLname['+i+']" placeholder="Last Name" /></td></tr>\n\
                                    <tr><td>Residential Address </td>\n\
                                    <td><div>\n\
                                        <input type="text" id="resAddUnit_'+i+'" name="resAddUnit['+i+']" style="width:115px;" value="" placeholder="Unit number" />\n\
                                        <input type="text" id="resAddBuild_'+i+'" name="resAddBuild['+i+']" style="width:115px;" value="" placeholder="Building" />\n\
                                        <input type="text" id="resAddStreet_'+i+'" name="resAddStreet['+i+']" style="width:115px;" value="" placeholder="Street"/><br>\n\
                                        <input type="text" id="resAddSubrb_'+i+'" name="resAddSubrb['+i+']" style="width:115px;" value="" placeholder="Suburb"/>\n\
                                        <select id="resAddState_'+i+'" name="resAddState['+i+']" style="margin-bottom:5px; width:180px;" >\n\
                                            <option value="0">Select State</option>'+states+'\n\
                                        </select><br>\n\
                                        <input type="text" id="resAddPstCode_'+i+'" name="resAddPstCode['+i+']" value="" placeholder="Post Code"/>\n\
                                    </div>\n\
                                </td>\n\
                            </tr>\n\
                            </table>\n\
                            <table class="fieldtable" style="width:528px">\n\
                                <tr><td>Share Class </td>\n\
                                <td>\n\
                                    <select id="selShrCls_'+i+'" name="selShrCls['+i+']" style="margin-bottom:5px; width:180px;" >\n\
                                        <option value="0">Select Share class</option>'+shrclass+'\n\
                                    </select></td></tr>\n\
                                <tr><td>Are the shares owned on behalf </br>of another Company or Trust? </td>\n\
                                <td><select id="selShrBhlf_'+i+'" name="selShrBhlf['+i+']" style="margin-bottom:5px; width:180px;" onchange="changeShrOwnBhlf(this,'+i+')">\n\
                                        <option value="1">Yes</option>\n\
                                        <option value="0">No</option>\n\
                                    </select></td></tr>\n\
                                <tr id="trShrOwnBhlf_'+i+'" ><td>Shares are owned on behalf </td>\n\
                                <td><input type="text" id="txtShrOwnBhlf_'+i+'" name="txtShrOwnBhlf['+i+']"  /></td></tr>\n\
                                <tr><td>Number of shares </td>\n\
                                <td><input type="text" id="txtNoShares_'+i+'" name="txtNoShares['+i+']"  /></td></tr>\n\
                            </table></div>\n\
                            ');
    }
    
}



function checkValidation(shrHldrCnt)
{
    
    var flag = true;
    
//    if($('#selShrHldr').val() == 0)
//    {
//        alert('Please select number of shareholders')
//        flag = false;
//    }
//    
//    for(var i = 1; i <= shrHldrCnt; i++)
//    {
//        if($('#selShrType_'+i).val() == 1)
//        {
//            if($('#txtCmpName_'+i).val() == '')
//            {
//                alert('Please enter company name of shareholders')
//                flag = false;
//            }
//            else if($('#txtRegAddr_'+i).val() == '')
//            {
//                alert('Please enter registered address of shareholders')
//                flag = false;
//            }
//            else if($('#selNoDirtr_'+i).val() == 0)
//            {
//                alert('Please select number of directors')
//                flag = false;
//            }
//            else if($('#selNoDirtr_'+i).val() > 0)
//            {
//            
//                for(var k = 1; k <= parseInt($('#selNoDirtr_'+i).val()); k++)
//                {
//                    if($('#txtFulName_'+i+k).val() == '')
//                    {
//                        alert('Please enter full name of '+k+' director')
//                        flag = false;
//                    }    
//                }
//                
//            }
//            
//            
//        }
//        else if($('#selShrType_'+i).val() == 2)
//        {
//            if($('#txtFname_'+i).val() == '')
//            {
//                alert('Please enter full name of '+k+' director')
//                flag = false;
//            }    
//            if($('#txtLname_'+i).val() == '')
//            {
//                alert('Please enter full name of '+k+' director')
//                flag = false;
//            }
//        }
//    }
    
    return flag;
}
