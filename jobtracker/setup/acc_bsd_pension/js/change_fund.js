/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    
    $('#frmChngFnd').submit(function() {
        flagReturn = true;
        
        if(!($('#txtExtFund').val())) {
            txtExtFund.className = "errclass";
            flagReturn = false;
        }
        else txtExtFund.className = "";
        
        if(!($('#txtNewFund').val())) {
            txtNewFund.className = "errclass";
            flagReturn = false;
        }
        else txtNewFund.className = "";
        
        if(!($('#metAddBuild').val())) {
            metAddBuild.className = "errclass";
            flagReturn = false;
        }
        else metAddBuild.className = "";
        
        if(!($('#metAddStreet').val())) {
            metAddStreet.className = "errclass";
            flagReturn = false;
        }
        else metAddStreet.className = "";
        
        if(!($('#metAddSubrb').val())) {
            metAddSubrb.className = "errclass";
            flagReturn = false;
        }
        else metAddSubrb.className = "";
        
        if($('#metAddState').val() == 0) {
            metAddState.className = "errclass";
            flagReturn = false;
        }
        else metAddState.className = "";
        
        if(!($('#metAddPstCode').val())) {
            metAddPstCode.className = "errclass";
            flagReturn = false;
        }
        else metAddPstCode.className = "";
        
        if($('#metAddCntry').val() == 0) {
            metAddCntry.className = "errclass";
            flagReturn = false;
        }
        else metAddCntry.className = "";
        
        return flagReturn;
        
    });
    
});