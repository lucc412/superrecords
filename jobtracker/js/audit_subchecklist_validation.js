$(document).ready(function() {
	
    /* SIMPLE ACCORDIAN STYLE MENU FUNCTION */	
    $('div.accordionButton').click(function() {
        if($(this).next().css('display') == 'none'){
                $('div.accordionContent').slideUp('normal');
                $(this).next().slideDown('normal');
        }else{
                $(this).next().slideUp('normal');
        }

        if($(this).hasClass('add'))
        {
            $(this).parent('div.checklist').children(this).each(function (item){
                if($(this).hasClass('minus'))
                {
                    $(this).addClass('add').removeClass('minus');
                }
            });

            $(this).addClass('minus').removeClass('add');
        }
        else {
            $(this).addClass('add').removeClass('minus');
        }
    }); 
    
});

// This function is used to perform validations for upload
function uploadValidate() {

	var flagReturn = true;
	var eleFileUpload = document.getElementById('fileUpload');
	var eleFileTitle = document.getElementById('fileTitle');

	if(eleFileTitle.value == "") {
		eleFileTitle.className = "errclass";
		flagReturn = false;
	}
	else if(eleFileUpload.value == 0) {
		eleFileUpload.className = "errclass";
		flagReturn = false;
	}

	return flagReturn;
}