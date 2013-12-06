/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
	
    // show hide corporate/individual section
    $('#selTrstyType').change(function() {
        if($('#selTrstyType').val() == '2') {
            $('#divCorporate').show();
            $('#divIndividual').hide();
        }
        else if($('#selTrstyType').val() == '1') {
            $('#divIndividual').show();
            $('#divCorporate').hide()
        }

    }); 
    
    // show member details section
    $('#selMember').change(function() {
        if(!($('#selMember').val())) {
            alert('No of individuals is a compulsory field');
            selMember.className = "errclass";
            return false;
        }
	$("#memberbox").html('');
        var oldMemberCnt = $('[id^=ele]').length;
        var newMemberCnt = $(this).val();
       
        // initialize intCnt for add case
        intCnt=0;        
        // initialize intCnt for edit case
        if(oldMemberCnt) intCnt = oldMemberCnt;
        
        while (intCnt < newMemberCnt) 
        { 
            var newSection = '<p style="padding-left:165px;" id="ele'+intCnt+'">\n\
                              <input style="width:170px" type="text" name="txtFName'+intCnt+'" id="txtFName'+intCnt+'" placeholder="First Name"/>\n\
                              <span class="pdL10"><input style="width:90px" type="text" name="txtMName'+intCnt+'" id="txtMName'+intCnt+'" placeholder="Middle Name"/></span>\n\
                              <span class="pdL10"><input style="width:170px" type="text" name="txtLName'+intCnt+'" id="txtLName'+intCnt+'" placeholder="Last Name"/></span>\n\
                              <span class="pdL10"><input style="width:170px" type="text" name="txtResAdd'+intCnt+'" id="txtResAdd'+intCnt+'" placeholder="Residential Address"/></span>\n\
                              </p>';
            $('#memberbox').append(newSection);
            intCnt++;
        }
        
        if(newMemberCnt < oldMemberCnt)  {
             //alert('Are you sure you want to delete existing individuals ?');
             eleCnt = 3;    
             while (newMemberCnt < oldMemberCnt) 
             { 
                 if($('#ele'+eleCnt).length > 0) {
                    $('#ele'+eleCnt).remove();
                    oldMemberCnt--;
                 }
                 eleCnt--;
             }
        }
    });
    
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
        
        if(!($('#selTrstyType').val())) {
            selTrstyType.className = "errclass";
            flagReturn = false;
        }
        else selTrstyType.className = "";
         
        
        // validate individual trustee part 
        if($('#selTrstyType').val() == 1) 
        {
            if(!($('#selMember').val())) {
                selMember.className = "errclass";
                flagReturn = false;
            }
            else selMember.className = "";
            
            $('[id^=txtFName]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
                        
            $('[id^=txtLName]').each(function (){
                if(!$(this).val()) {
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
        }
        
        
        // validate corporate trustee part 
        if($('#selTrstyType').val() == 2) {
            if(!($('#txtCompName').val())) {
                txtCompName.className = "errclass";
                flagReturn = false;
            }
            else txtCompName.className = "";

            if(!($('#txtAcn').val())) {
                txtAcn.className = "errclass";
                flagReturn = false;
            }
            else txtAcn.className = "";
            
            if(!($('#txtAdd').val())) {
                txtAdd.className = "errclass";
                flagReturn = false;
            }
            else txtAdd.className = "";
            
            if(!($('#dir0').val())) {
                dir0.className = "errclass";
                flagReturn = false;
            }
            else dir0.className = "";
        }
        
        return flagReturn;
    });
        
    
}); 
