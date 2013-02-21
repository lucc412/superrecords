var win = null;
function NewWindow(mypage,myname,w,h,scroll){
 LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
 function ComfirmDelete(){
   var r=confirm("Are you sure you want to delete this repeat and all associated Worksheets?");
   if(r==true){
      document.wrk_delete.submit();

   }else{

      return false;
   }
}
function ComfirmCancel(){
   var r=confirm("Are you sure you want to cancel?");
   if(r==true){
            window.close();

   }else{

      return false;
   }
}
 checked = false;
      function checkedAll () {
         if (checked == false){checked = true}else{checked = false}
	for (var i = 0; i < document.getElementById('wrk_delete').elements.length; i++) {
	  document.getElementById('wrk_delete').elements[i].checked = checked;
	}
      }
