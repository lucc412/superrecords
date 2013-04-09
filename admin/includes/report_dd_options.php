<?
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
}
?>