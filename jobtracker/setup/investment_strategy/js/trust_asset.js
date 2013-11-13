$(document).ready(function() {
	
    // on submit validation
    $('#frmTrust').submit(function() {
        flagReturn = true;
            
        if($('#txtYear1').length == '0') {
            alert("Please add atleast one asset");
            flagReturn = false;
        }
        
        $('[id^=txtYear]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=taAsset]').each(function (){
            if(!$(this).val()) {
                $(this).addClass('errclass');
                flagReturn = false;
            }
            else {
                $(this).removeClass("errclass");
            }
        });
        
        $('[id^=txtAmt]').each(function (){
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
    
    // onclick of Add Asset button
    var assetCnt = $('#assetCnt').val();
    $('#btnAdd').click(function() {
        
        assetCnt++;
        $('#divAssets').append('<div id="member_'+assetCnt+'"> <div style="padding:10px 0;color: #F05729;font-size: 14px;">Asset '+assetCnt+':</div>\n\
                                <table class="fieldtable" width="60%" cellpadding="10px">\n\
                                    <tr><td>Financial Year </td>\n\
                                    <td><input type="text" id="txtYear'+assetCnt+'" name="txtYear'+assetCnt+'"  /></td></tr>\n\
                                    <tr><td>Asset </td>\n\
                                    <td><textarea id="taAsset'+assetCnt+'" name="taAsset'+assetCnt+'"  /></textarea></td></tr>\n\
                                    <tr><td>Asset Type </td>\n\
                                    <td><input type="text" id="txtType'+assetCnt+'" name="txtType'+assetCnt+'"  /></td></tr>\n\
                                    <tr><td>Amount </td>\n\
                                    <td><input type="text" id="txtAmt'+assetCnt+'" name="txtAmt'+assetCnt+'" /></td></tr>\n\
                                    <tr><td>Range (0-100%) </td>\n\
                                    <td><input type="text" id="txtRange'+assetCnt+'" name="txtRange'+assetCnt+'"  /></td></tr>\n\
                                    <tr><td>12 months target % </td>\n\
                                    <td><input type="text" id="txtTarget'+assetCnt+'" name="txtTarget'+assetCnt+'"  /></td></tr>\n\
                                </table></div>\n\
                        ');
    });
    
});