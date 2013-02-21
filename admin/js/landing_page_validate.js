function saveDefaultUrl(empId){
	hidEmployeeId = document.getElementById('employeeId');
	hidEmployeeUrl = document.getElementById('employeeUrl');

	txtUrl = document.getElementById('landingUrl'+empId).value;
	hidEmployeeId.value = empId;
	hidEmployeeUrl.value = txtUrl;
	document.objForm.submit();
}