$(document).ready(function() {
	
    // show hide corporate/individual section
    $('#lstType').change(function() {
        if($('#lstType').val() == '2') {
            $('#divCorporate').show();
            $('#divIndividual').hide();
        }
        else {
            $('#divIndividual').show();
            $('#divCorporate').hide()
        }
    }); 
    
    // show member details section
    $('#lstMember').change(function() {
        if(!($('#lstMember').val())) {
            alert('No of members is a compulsory field');
            lstMember.className = "errclass";
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
            var newSection = '<p style="padding-left:165px;" id="ele'+intCnt+'"><input type="text" name="txtTrusteeName'+intCnt+'" id="txtTrusteeName'+intCnt+'" placeholder="Name of Trustee"/><span class="pdL20"><input type="text" name="txtResAdd'+intCnt+'" id="txtResAdd'+intCnt+'" placeholder="Residential Address"/></span>';
            $('#memberbox').append(newSection);
            intCnt++;
        }
        
        if(newMemberCnt < oldMemberCnt)  {
             alert('Are you sure you want to delete existing members ?');
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
        if(!($('#txtFund').val())) {
            txtFund.className = "errclass";
            flagReturn = false;
        }
        else txtFund.className = "";
        
        if(!($('#lstType').val())) {
            lstType.className = "errclass";
            flagReturn = false;
        }
        else lstType.className = "";
        
        // validate corporate trustee part 
        if($('#lstType').val() == 2) {
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
            
            $('[id^=dir]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
        }
        
        // validate individual trustee part 
        if($('#lstType').val() == 1) {
            if(!($('#lstMember').val())) {
                lstMember.className = "errclass";
                flagReturn = false;
            }
            else lstMember.className = "";
            
            $('[id^=txtTrusteeName]').each(function (){
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
        
        return flagReturn;
    });
    
});