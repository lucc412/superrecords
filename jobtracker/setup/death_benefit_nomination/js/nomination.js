$(document).ready(function() {
	    
    // show director details section
    $('#beneficiaries').change(function() {
        if(!($('#beneficiaries').val())) {
            alert('No of directors is a compulsory field');
            beneficiaries.className = "errclass";
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
            var newSection = '<p style="" id="direle'+intCnt+'"><input type="text" style="width: 160px;" name="txtName'+intCnt+'" id="txtName'+intCnt+'" placeholder="Full Name">\n\
			<span><input type="text" name="txtDob'+intCnt+'" id="txtDob'+intCnt+'" style="width:70px;" placeholder="Dob" readonly><img src="../../images/calendar.png" id="calImgId" onclick="javascript:NewCssCal(\'txtDob'+intCnt+'\',\'ddMMyyyy\',\'dropdown\',false,24,false,\'past\')" align="middle" class="calendar"></span>\n\
			<span><input type="text" style="width: 160px" name="txtAdd'+intCnt+'" id="txtAdd'+intCnt+'" placeholder="Residential Address"></span>\n\
			<span><input type="text" style="width: 70px;" name="txtRelationship'+intCnt+'" id="txtRelationship'+intCnt+'" placeholder="Relationship"></span>\n\
			<span><input type="text" style="width: 160px;" name="txtportion'+intCnt+'" id="txtportion'+intCnt+'" placeholder="Portion (%) of Death Benefit"></span>\n\
			</p>';
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
    
    // on submit validation
    $('#frmBenef').submit(function() {
        flagReturn = true;
        if(!($('#txtName').val())) {
            txtName.className = "errclass";
            flagReturn = false;
        }
        else txtName.className = "";
        
		if(!($('#txtAdd').val())) {
            txtAdd.className = "errclass";
            flagReturn = false;
        }
        else txtAdd.className = "";
		
		if(!($('#txtDob').val())) {
            txtDob.className = "errclass";
            flagReturn = false;
        }
        else txtDob.className = "";
		
		if(!($('#beneficiaries').val())) {
            beneficiaries.className = "errclass";
            flagReturn = false;
        }
        else beneficiaries.className = "";
        
		$('[id^=txtName]').each(function (){
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
        $('[id^=txtAdd]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        $('[id^=txtRelationship]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        $('[id^=txtportion]').each(function (){
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