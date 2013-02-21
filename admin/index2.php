<?php 
ob_start();
session_start();

/* Condition added by Yogi */
if(isset($_SESSION['default_url']) && $_SESSION['default_url'] != '')
{
	header("Location:".$_SESSION['default_url']);
	exit;
}	

include("dbclass/commonFunctions_class.php");
include("common/varDeclare.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="<?php echo $styleSheet; ?>Style.css" rel="stylesheet" type="text/css">
<title>Super Records</title>
</head>

<body>
<div id="printheader"></div>
<?php 
if($_SESSION['validUser'])
{
include("includes/header.php");
?>

<br/><br/><br/>

<div class="paddingtopbtm" align="center">
	<p style="color:#888">Welcome to</p> <br />
	<h1 style="font-size:35px; letter-spacing:6px;"> SUPER RECORDS </h1>
</div>

<!--<table width="100%" cellspacing="3px" cellpadding="3px" style="border:1px solid #00699C; margin-left:1px;">
<tbody><tr>
<td width="50%" style="border-right:1px solid #00699C;">
<h3>System Setup Menu</h3>
System Setup helps to configure dropdown values that are used in main forms under Clients and Administration menu�s. This helps to standardize terminologies used. Adding/Updating values in System Setup Menu will reflect in the corresponding dropdown values in the forms used. Please note deleting any records in System Setup Menu will affect corresponding forms. Care should be take while deleting any record in System Setup Menu forms. 
<ul>
<li>Case status &ndash; Status dropdown values used in Case form under Administration to represent the status of cases. 
For ex: Assigned, In progress, Closed etc</li>
<li>Designations- Designation dropdown values used in Contact form to represent Client and Employee designations.</li>
<li>Entity Type &ndash; Entity type dropdown values used in Client - &gt; Quote sheet -&gt; Card File Info tab to represent the type of Entity of the client.</li>
<li>Leave Request status &ndash; Status dropdown values used in Administration - &gt; Leave Request form to represent the status of the leave request. For ex: Submitted, Approved, Declined etc</li>
<li>Process cycle &ndash; This represents processing cycle like Weekly, Monthly, Yearly etc which is used in Clients -&gt; Quote sheet -&gt; Tasks &amp; Budgeted Hours tab</li>
<li>Priority - This represents the priorities of Cases and Worksheet. For ex: High, Medium, On Hold etc</li>
<li>Timesheet status &ndash; Status dropdown values used in Timesheet form. For ex: Submitted, Approved, Billed etc.</li>
<li>Worksheet status- Status dropdown values used in Worksheet form. For ex: Submitted, Approved, Billed etc.</li>
</ul><br>
<h3>Work Flow Activities Menu</h3>
Work flow activities menu items are used to configure the activities/tasks that are carried out in super records. This helps to standardize terminologies used. Adding/Updating values in Work flow activities Menu will reflect in the corresponding dropdown values in the forms used. Please note deleting any records in Work flow activities will affect corresponding forms. 
<ul>
<li>Master Activity &ndash; This represents activities like Bookkeeping,  Tax returns with respect to accounting purpose or can be used to represent internal activities like computer issues,  meetings etc. This is used in Worksheet, Timesheet, Cases forms </li>
<li>Sub Activity &ndash; The sub activities under Master Activity. For ex: GST under Tax Returns etc</li>
<li>Tasks - Tasks are used in Clients page where each tab represents a Category (For ex: Card File Info, Hosting, Invoice tabs represent a Category of Task list). We have taken out the option to add new Categories because the tab will not be created automatically. If you need to add a new category/tab you need to let us know. Please note that the tasks work�s on auto-generated concept. Once we setup the tab/category, you can add new tasks and it will appear automatically in the Clients section. </li>
<li>Timesheet Task Templates &ndash; Timesheet task templates are used in Timesheet form. Users have an option to choose from the templates or write their own description. </li>
<ul>
</ul></ul></td>
<td width="50%" valign="top">
<h3>Clients Menu</h3>
<ul>
<li>Client status &ndash; This represents the status of the communication that is carried between client/lead and super records. For ex:  Appointment fixed, Waiting for confirmation etc</li>
<li>Manage Clients - Client contact details, Quotesheet information, Permanent Information are recorded in the client form.  </li>
Client Types can be &ndash; �Client�, �Lead� or �Discontinued�. Please note to add new types please inform us. 
A Lead record represents basic information like client company name, contact details, status etc. When a lead is confirmed and changed as Client type, additional fields/tabs will appear in the client record to input detailed information about the client, tasks that needs to carried out etc.  
<li>Contacts &ndash; Contact records can be 2 types �Client� and �Employee�. Client type contacts represents contact person details of Clients.  Employee type contact represents super records user.</li>
</ul>
<br>
<h3>Administration</h3>
Administration form�s helps to manage, monitor and report internal work flow activities that is been carried out in super records.
<ul>
<li>Users &ndash; User form represents the login and permissions information for the users of the Work Flow System.</li>
<li>Leave Request Form- Users can submit Leave Request Form to request leave from the administrator.</li>
<li>Timesheets &ndash; Users record daily timesheets to represent their work done for Client/Clients each day.</li>
<li>Worksheets- Team In Charges/ User create Worksheets based on the Quote sheet, Permanent Information tabs of the Client record.  Worksheet represents the tasks that need to be carried out for a Client. Repeats option is provided to repeat the same Worksheet weekly, quarterly, monthly or yearly.</li>
<li>Cases- Cases are created to represent issues or intermediate tasks that need to be executed to complete the Worksheet.</li>
</ul><br>
<h3>Reports</h3>
Reports help the Administrator to track/monitor worksheets and timesheets.
<ul>
<li>Timesheet Report &ndash; Advanced search filters are provided to search Timesheet records. Edit/Delete option is provide to correct the searched Timesheets.</li>
<li>Worksheet Report - Advanced search filters are provided to search Worksheet records. Edit/Delete option is provide to correct the searched Worksheets.</li>
</ul>
</td>
</tr>
</tbody></table>-->
<!--<table width="74%" cellpadding="0" cellspacing="0" class="moduletable"  >
					<tr>
					<th width="33%" valign="top">
					Work Flow Activities
					</th>
					<th width="32%" valign="top">
					Manage Clients
					</th>
					<th width="35%" valign="top">
					Manage Admin
					</th>
					</tr>
					<tr>
					<td valign="top">
					<ul>
						<li><a href="mas_masteractivity.php?a=reset">Master Activity</a></li>
						<li><a href="sub_subactivity.php?a=reset">Sub Activity</a></li>
						<li><a href="tsk_tasks.php?a=reset">Tasks</a></li>
						<li><a href="tst_tasktemplates.php?a=reset">Timesheet Task Templates</a></li>
					</ul>
					</td>
					<td valign="top">
					<ul>
						<li><a href="cst_clientstatus.php?a=reset">Client Status</a></li>
						<li><a href="cty_clienttype.php?a=reset">Client Types</a></li>
						<li><a href="cli_client.php?a=reset">Manage Clients</a></li>
						<li><a href="con_contact.php?a=reset">Contact</a></li>
					</ul>
					</td>
					<td valign="top">
					<ul>
						 <li><a href="stf_staff.php?a=reset">User</a></li>
						 <li><a href="lrf_leaverequestform.php?a=reset">Leave Request Form</a></li>
 						 <li><a href="tis_timesheet.php?a=reset">Timesheets</a></li>
						 <li><a href="wrk_worksheet.php?a=reset">Worksheet</a></li>
						  <li><a href="cas_cases.php?a=reset">Cases</a></li>
					</ul>
					</td>
					</tr>
</table>-->
<?php 
}  
else
{
header("Location:index.php?msg=timeout");
}
include("includes/footer.php");
?>