<?
/*	
	Created By -> 09-Apr-13 [Disha Goyal]
	Last Modified By -> 09-Apr-13 [Disha Goyal]	
	Description: This is module file used to get all options for DD in Reports
*/

switch($selectedColumn) {

	case "lead_type":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("lead_type", "id", "description", "order");
	break;

	case "lead_status":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("lead_status", "id", "description", "order");
	break;

	case "lead_industry":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("lead_industry", "id", "description", "order");
	break;

	case "lead_stage":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("lead_stage", "id", "description", "order");
	break;

	case "lead_source":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("lead_source", "id", "description", "order");
	break;

	case "state":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("cli_state", "cst_Code", "cst_Description", "cst_Order");
	break;

	case "sr_manager":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetchEmployees($designationId=24);
	break;

	case "sales_person":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetchEmployees($designationId=14);
	break;
		
	case "india_manager":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetchEmployees($designationId=28);
	break;
	
	case "team_member":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetchEmployees($designationId=29);
	break;
	
	case "id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("pr_practice", "id", "name");
	break;

	case "client_id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("client", "client_id", "client_name");
	break;

	case "job_id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetchJobName();
	break;
	
	case "steps_done":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("cli_steps", "id", "description", "order");
	break;
	
	case "client_type_id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("ety_entitytype", "ety_Code", "ety_Description", "ety_Order");
	break;

	case "mas_Code":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("mas_masteractivity", "mas_Code", "mas_Description", "mas_Order");
	break;

	case "sub_Code":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("sub_subactivity", "sub_Code", "sub_Description", "sub_Order");
	break;

	case "task_status_id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("task_status", "id", "description", "order");
	break;

	case "priority_id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("pri_priority", "pri_Code", "pri_Description", "pri_Order");
	break;

	case "process_id":
		$arrDDOptions[$selectedColumn] = $objCallUsers->fetch_dd_options("prc_processcycle", "prc_Code", "prc_Description", "prc_Order");
	break;
}
?>