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
    
    // show director details section
    $('#lstDirector').change(function() {
        if(!($('#lstDirector').val())) {
			alert('No of directors is a compulsory field');            
            lstDirector.className = "errclass";
            return false;
        }
	$("#directorbox").html('');
        var oldDirectorCnt = $('[id^=direle]').length;
        var newDirectorCnt = $(this).val();
       
        // initialize intCnt for add case
        intCnt=0;        
        // initialize intCnt for edit case
        if(oldDirectorCnt) intCnt = oldDirectorCnt;
        
        while (intCnt < newDirectorCnt) 
        { 
            var newSection = '<p style="padding-left:165px;" id="direle'+intCnt+'"><input type="text" name="txtDirName'+intCnt+'" id="txtDirName'+intCnt+'" placeholder="Name of Director"/>\n\
                                <span class="pdL20"><input type="text" name="txtDirAdd'+intCnt+'" id="txtDirAdd'+intCnt+'" placeholder="Residential Address"/></span></p>';
            $('#directorbox').append(newSection);
            intCnt++;
        }
        
        if(newDirectorCnt < oldDirectorCnt)  {
            // alert('Are you sure you want to delete existing trustees ?');
             eleCnt = 3;
             while (newDirectorCnt < oldDirectorCnt) 
             { 
                 if($('#direle'+eleCnt).length > 0) {
                    $('#direle'+eleCnt).remove();
                    oldDirectorCnt--;
                 }
                 eleCnt--;
             }
        }
    });
    
    // show member details section
    $('#lstMember').change(function() {
        if(!($('#lstMember').val())) {
            alert('No of trustees is a compulsory field');
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
            var newSection = '<p style="padding-left:165px;" id="ele'+intCnt+'"><input style="width:185px;" type="text" name="txtTrusteeFName'+intCnt+'" id="txtTrusteeFName'+intCnt+'" placeholder="First Name"/>\n\
			<input style="width:185px;" type="text" name="txtTrusteeMName'+intCnt+'" id="txtTrusteeMName'+intCnt+'" placeholder="Middle Name"/>\n\
			<input style="width:185px;" type="text" name="txtTrusteeLName'+intCnt+'" id="txtTrusteeLName'+intCnt+'" placeholder="Last Name"/>\n\
			<input style="width:185px;" type="text" name="txtResAdd'+intCnt+'" id="txtResAdd'+intCnt+'" placeholder="Residential Address"/></p>';
            $('#memberbox').append(newSection);
            intCnt++;
        }
        
        if(newMemberCnt < oldMemberCnt)  {
            // alert('Are you sure you want to delete existing trustees ?');
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
            
            if(!($('#txtAdd').val())) {
                txtAdd.className = "errclass";
                flagReturn = false;
            }
            else txtAdd.className = "";
        }
        
        // validate individual trustee part 
        if($('#lstType').val() == 1) {
            if(!($('#lstMember').val())) {
                lstMember.className = "errclass";
                flagReturn = false;
            }
            else lstMember.className = "";
            
            $('[id^=txtTrusteeFName]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
            
			/*$('[id^=txtTrusteeMName]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });*/
			$('[id^=txtTrusteeLName]').each(function (){
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
            
           /* $('[id^=txtDob]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });*/
        }
        else if($('#lstType').val() == 2) {
            if(!($('#lstDirector').val())) {
                lstDirector.className = "errclass";
                flagReturn = false;
            }
            else lstDirector.className = "";
            
            $('[id^=txtDirName]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
            
            $('[id^=txtDirAdd]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });
            
            /*$('[id^=txtDirDob]').each(function (){
                if(!$(this).val()) {
                    $(this).addClass('errclass');
                    flagReturn = false;
                }
                else {
                    $(this).removeClass("errclass");
                }
            });*/
        }
        
        return flagReturn;
    });
    
});