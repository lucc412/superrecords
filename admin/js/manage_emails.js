/*	
	Created Date: 01-Mar-13										
	Created By: Disha Goyal										
	Description: This is js file for page 'Manage Emails'
*/


/* This js fucntion passes the id on click of save button & set in hidden variable 'eventId' 
   Date Created -> 01-Mar-13 [Disha Goyal]
*/
function saveEmailEvent(selEventId){
	hidEventId = document.getElementById('eventId');
	hidEventId.value = selEventId;
	document.objForm.submit();
}