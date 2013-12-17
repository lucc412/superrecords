<?php
error_reporting(0);
ob_start();
session_start();
//2 hours
$inactive = 7200;
if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        // header("Location:index.php");
    }
}
$_SESSION['timeout'] = time();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <link rel="stylesheet" type="text/css" href="css/tooltip.css"/>
        <link href="images/favicon.ico" rel="shortcut icon" />
        <!-- Google Webfont -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'/>
        <script type="text/javascript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
		<script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.9.1.js"></script><?
if (basename($_SERVER['PHP_SELF']) == 'job.php') {
    ?><title>Job List</title>
            <!--<script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.4.2.min.js"></script>-->
            <script type="text/javascript" src="<?php echo $javaScript; ?>job.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'lead.php') {
            ?><title>Manage Lead</title>
            <script type="text/javascript" src="<?php echo $javaScript; ?>lead_validate.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'lead_type.php') {
            ?><title>Lead Type</title><?
    } else if (basename($_SERVER['PHP_SELF']) == 'lead_industry.php') {
            ?><title>Lead Industry</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'lead_status.php') {
            ?><title>Lead Status</title><?
            } else if (basename($_SERVER['PHP_SELF']) == 'lead_stage.php') {
                ?><title>Lead Stage</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'lead_source.php') {
            ?><title>Lead Source</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'rf_referrer.php') {
            ?><title>Manage Referrer</title>
            <script type="text/javascript" src="<?php echo $javaScript; ?>rf_validate.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'rf_services.php') {
            ?><title>Referrer Services</title><?
    } else if (basename($_SERVER['PHP_SELF']) == 'rf_type.php') {
            ?><title>Referrer Type</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'jobs_rights.php') {
            ?><title>Job Rights</title>
                <script src="<?php echo $javaScript; ?>jobs_rights.js" type="text/javascript" ></script><?
            } else if (basename($_SERVER['PHP_SELF']) == 'rf_tasklist.php') {
                ?><title>Referrer Items List</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'pr_practice.php') {
            ?><title>Manage Practice</title>
            <script type="text/javascript" src="<?php echo $javaScript; ?>jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="<?php echo $javaScript; ?>pr_validate.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'pr_services.php') {
            ?><title>Practice Services</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'pr_tasklist.php') {
            ?><title>Practice Items List</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'pr_type.php') {
            ?><title>Practice Type</title><?
            } else if (basename($_SERVER['PHP_SELF']) == 'cli_client.php') {
                ?><title>Manage Client</title>
            <script type="text/javascript" src="<?php echo $javaScript; ?>cli_validate.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'cli_type.php') {
            ?><title>Entity Type</title><?
    } else if (basename($_SERVER['PHP_SELF']) == 'cli_stepsdone.php') {
            ?><title>Client Steps</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'tsk_task.php') {
            ?><title>Task</title>
            <script type="text/javascript" src="<?= $javaScript; ?>jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="<?= $javaScript; ?>tsk_task_validate.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'template.php') {
            ?><title>Template</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'tsk_status.php') {
            ?><title>Task Status</title>
            <LINK href="<?php echo $styleSheet; ?>tooltip.css" rel="stylesheet" type="text/css">
                <script type="text/javascript" src="<?= $javaScript; ?>jquery-1.4.2.min.js"></script>
                <script type="text/javascript" src="<?= $javaScript; ?>tsk_task_validate.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'prc_processcycle.php') {
            ?><title>Process Cycle</title><?
        } else if (basename($_SERVER['PHP_SELF']) == 'mas_masteractivity.php') {
            ?><title>Master Activity</title><?
            } else if (basename($_SERVER['PHP_SELF']) == 'sub_subactivity.php') {
                ?><title>Sub Activity</title><?
                } else if (basename($_SERVER['PHP_SELF']) == 'job_status.php') {
                    ?><title>Job Status</title><?
            } else if (basename($_SERVER['PHP_SELF']) == 'pri_priority.php') {
                ?><title>Priority</title><?
            } else if (basename($_SERVER['PHP_SELF']) == 'con_empcontact.php') {
                ?><title>Employee Contact</title>
                <link rel="stylesheet" href="as/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
                <script type="text/javascript" src="as/js/bsn.AutoSuggest_2.1.3.js" charset="utf-8"></script>
                <script type="text/javascript" src="<?php echo $javaScript; ?>empcontact.js"></script><?
        } else if (basename($_SERVER['PHP_SELF']) == 'stf_staff.php') {
            ?><title>Users</title>
                <script type="text/javascript" src="<?php echo $javaScript; ?>staff.js"></script> 
                <?
            } else if (basename($_SERVER['PHP_SELF']) == 'dsg_designation.php') {
                ?><title>Designations</title><?
            } else if (basename($_SERVER['PHP_SELF']) == 'stf_ipaddress.php') {
                ?><title>IP Address</title>
                <script type="text/javascript" src="<?php echo $javaScript; ?>ipaddress.js"></script><?
            } else if (basename($_SERVER['PHP_SELF']) == 'landing_page.php') {
                ?><title>Default Landing URL</title>
                <script type="text/javascript" src="<?= $javaScript; ?>landing_page_validate.js"></script><?
            } else if (basename($_SERVER['PHP_SELF']) == 'manage_emails.php') {
                ?><title>Manage Emails</title>
                <script type="text/javascript" src="<?= $javaScript; ?>manage_emails.js"></script>
                <script type="text/javascript" src="library/ckeditor/ckeditor.js"></script><?
            } else if ((basename($_SERVER['PHP_SELF']) == 'lead_report.php') || (basename($_SERVER['PHP_SELF']) == 'practice_report.php') || (basename($_SERVER['PHP_SELF']) == 'client_report.php') || (basename($_SERVER['PHP_SELF']) == 'job_report.php') || (basename($_SERVER['PHP_SELF']) == 'task_report.php')) {
                ?><script type="text/javascript" src="<?= $javaScript; ?>report_validation.js"></script><?
            }else if (basename($_SERVER['PHP_SELF']) == 'index2.php') {
                ?><title>Super Records</title><?
            }
            ?></head>

    <body><?
            
            if ($_SESSION['validUser']) {
                ?><br/>
            <div class="header">
                <div class="container">
                    <div id="logo">
                        <a href="index.php"><img border="0" src="images/header-logo.png"></a>
                    </div>

                    <div class="user">        	
                        <span style="color:#074263">Welcome,</span> <span><? echo strtoupper($_SESSION['user']); ?></span>
                    </div> <!--user-->

                    <div class="phone">
                        <a href="logout.php"><button style="width:94px" type="submit" value="Submit">Logout</button></a>
                    </div> <!--phone-->
                </div>
            </div><?
        if (strpos($_SERVER['PHP_SELF'], 'index2')) {
            ?><div id="dhtmlgoodies_menu" style="margin-left: 0px; *margin-top:-2px;*position:relative"><?
        } else {
            ?><div id="dhtmlgoodies_menu" style="margin-left: 0px; *margin-top:-2px;"><?
        }
        ?><div class="nav">
                        <div class="container">
                            <ul></ul>
                            <ul>
                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li><?
            // Lead Menu (check access by passing $_SESSION of staff code and form code)
            $formcode_sys = "78,79,80,81,82,83";
            $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

            if ($access_menu_level == "true") {
                ?><li class="dropdown"><a href="#">Lead</a>      
                                        <ul class="sub"><?
            // Manage Lead Submenu (Check access by passing $_SESSION of staff code and form code)
            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 78, 1);
            if (is_array($access_submenu_level) == 1) {
                if (in_array("Y", $access_submenu_level)) {
                        ?><li><a href="lead.php">Manage Lead</a></li><?
                                        }
                                    }

                                    // Lead Type Submenu (Check access by passing $_SESSION of staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 79, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="lead_type.php">Lead Type</a></li><?
                                                }
                                            }

                                            // Lead Industry Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 80, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="lead_industry.php">Lead Industry</a></li><?
                                                }
                                            }

                                            // Lead Status Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 81, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="lead_status.php">Lead Status</a></li><?
                                                    }
                                                }

                                                // Lead Stage Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 82, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="lead_stage.php">Lead Stage</a></li><?
                                                    }
                                                }

                                                // Lead Source Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 83, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="lead_source.php">Lead Source</a></li><?
                                                    }
                                                }
                                                ?></ul>
                                    </li><?
                                            }

                                            // Referrer Partner Menu (check access by passing $_SESSION of staff code and form code)
                                            $formcode_sys = "84,85,86,87";
                                            $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

                                            if ($access_menu_level == "true") {
                                                ?><li class="dropdown"><a href="#">Referrer Partner</a>      
                                        <ul class="sub"><?
                                                // Manage Referrer Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 84, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="rf_referrer.php">Manage Referrer</a></li><?
                                        }
                                    }

                                    // Referrer Type Submenu (Check access by passing $_SESSION of staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 85, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="rf_type.php">Referrer Type</a></li><?
                        }
                    }

                    // Referrer Services Submenu (Check access by passing $_SESSION of staff code and form code)
                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 86, 1);
                    if (is_array($access_submenu_level) == 1) {
                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="rf_services.php">Referrer Services</a></li><?
                                                }
                                            }

                                            // Referrer Items List Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 87, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="rf_tasklist.php">Referrer Items List</a></li><?
                                                    }
                                                }
                                                ?></ul>
                                    </li><?
                                            }

                                            // Practice Menu (check access by passing $_SESSION of staff code and form code)
                                            $formcode_sys = "88,89,90,91";
                                            $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

                                            if ($access_menu_level == "true") {
                                                ?><li class="dropdown"><a href="#">Practice</a>      
                                        <ul class="sub"><?
                                                // Manage Practice Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 88, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="pr_practice.php">Manage Practice</a></li><?
                                                    }
                                                }

                                                // Practice Type Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 89, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="pr_type.php">Practice Type</a></li><?
                                        }
                                    }

                                    // Practice Services Submenu (Check access by passing $_SESSION of staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 90, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="pr_services.php">Practice Services</a></li><?
                                                }
                                            }

                                            // Practice Items List Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 91, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="pr_tasklist.php">Practice Items List</a></li><?
                                                    }
                                                }
                                                ?></ul>
                                    </li><?
                                            }

                                            // Client Menu (check access by passing $_SESSION of staff code and form code)
                                            $formcode_sys = "92,93,94";
                                            $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

                                            if ($access_menu_level == "true") {
                                                ?><li class="dropdown"><a href="#">Client</a>      
                                        <ul class="sub"><?
                                                // Manage Client Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 92, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="cli_client.php">Manage Client</a></li><?
                                                    }
                                                }

                                                // Entity Type Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 93, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="cli_type.php?a=reset">Entity Type</a></li><?
                                        }
                                    }

                                    // Client Steps Submenu (Check access by passing $_SESSION of staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 94, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="cli_stepsdone.php?a=reset">Client Steps</a></li><?
                                                }
                                            }
                                            ?></ul>
                                    </li><?
                                        }

                                        // Job Menu (check access by passing $_SESSION of staff code and form code)
                                        $formcode_sys = "95,96,97,7,8,11,12,100,102";
                                        $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

                                        if ($access_menu_level == "true") {
                                            ?><li class="dropdown"><a href="#">Job</a>      
                                        <ul class="sub"><?
                                                // Job List Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 95, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="job.php">Job List</a></li><?
                                                    }
                                                }

                                                // Task Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 96, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="tsk_task.php?a=reset">Task</a></li><?
                                        }
                                    }

                                    // Templates Submenu (Check access by passing $_SESSION of staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 102, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="template.php?a=reset">Template</a></li><?
                                                }
                                            }

                                            // Task Status Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 97, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="task_status.php?a=reset">Task Status</a></li><?
                                                }
                                            }

                                            // Process Cycle Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 7, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="prc_processcycle.php?a=reset">Process Cycle</a></li><?
                                                    }
                                                }

                                                // Priority Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 8, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="pri_priority.php?a=reset">Priority</a></li><?
                                                    }
                                                }

                                                // Master Activity Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 11, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="mas_masteractivity.php?a=reset">Master Activity</a></li><?
                                                    }
                                                }

                                                // Sub Activity Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 12, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="sub_subactivity.php?a=reset">Sub Activity</a></li><?
                                                    }
                                                }

                                                // Job Status Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 100, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="job_status.php?a=reset">Job Status</a></li><?
                                                    }
                                                }
                                                ?></ul>
                                    </li><?
                                            }

                                            // Administration Menu (check access by passing staff code and form code)
                                            $formcode_sys = "21,50,4,57,98,99";
                                            $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

                                            if ($access_menu_level == "true") {
                                                ?><li class="dropdown"><a href="#">Administration</a>      
                                        <ul class="sub"><?
                                                // Users Submenu (Check access by passing staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 21, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="stf_staff.php?a=reset">Users</a></li><?
                                                    }
                                                }

                                                // Employees Submenu (Check access by passing staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 50, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="con_empcontact.php?a=reset">Employee Contact</a></li><?
                                        }
                                    }

                                    // Task Status Submenu (Check access by passing staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 4, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="dsg_designation.php?a=reset">Designations</a></li><?
                        }
                    }

                    // IP Address Submenu (Check access by passing staff code and form code)
                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 57, 1);
                    if (is_array($access_submenu_level) == 1) {
                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="stf_ipaddress.php?a=reset">IP Address</a></li><?
                                                }
                                            }

                                            // Landing URL Submenu (Check access by passing staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 98, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="landing_page.php">Default Landing URL</a></li><?
                                                    }
                                                }

                                                // Manage Emails Submenu
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 99, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="manage_emails.php">Manage Emails</a></li><?
                                                    }
                                                }
                                                ?></ul>
                                    </li><?
                                            }

                                            // Reports Menu (check access by passing $_SESSION of staff code and form code)
                                            $formcode_sys = "53,65,45,74,76";
                                            $access_menu_level = $commonUses->checkMenuAccess($_SESSION['staffcode'], $formcode_sys);

                                            if ($access_menu_level == "true") {
                                                ?><li class="dropdown"><a href="#">Reports</a>      
                                        <ul class="sub"><?
                                                // Lead Report Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 53, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="lead_report.php">Lead Report</a></li><?
                                                    }
                                                }

                                                // Practice Report Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 65, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="practice_report.php">Practice Report</a></li><?
                                                    }
                                                }

                                                // Client Report Submenu (Check access by passing $_SESSION of staff code and form code)
                                                $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 45, 1);
                                                if (is_array($access_submenu_level) == 1) {
                                                    if (in_array("Y", $access_submenu_level)) {
                                                        ?><li><a href="client_report.php">Client Report</a></li><?
                                        }
                                    }

                                    // Job Report Submenu (Check access by passing $_SESSION of staff code and form code)
                                    $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 74, 1);
                                    if (is_array($access_submenu_level) == 1) {
                                        if (in_array("Y", $access_submenu_level)) {
                                            ?><li><a href="job_report.php">Job Report</a></li><?
                                                }
                                            }

                                            // Task Report Submenu (Check access by passing $_SESSION of staff code and form code)
                                            $access_submenu_level = $commonUses->checkSubMenuAccess($_SESSION['staffcode'], 76, 1);
                                            if (is_array($access_submenu_level) == 1) {
                                                if (in_array("Y", $access_submenu_level)) {
                                                    ?><li><a href="task_report.php">Task Report</a></li><?
                                                    }
                                                }
                                                ?></ul>
                                    </li><?
                                            }

                                            if ($_SESSION['usertype'] == "Administrator" || $_SESSION['staffcode'] == "69") {
                                                ?><li><a href="../administrator/index.php">CMS Admin</a></li><?
                                            }
                                            ?></ul>
                        </div> 
                    </div> 
                </div>
                <div class="pagebackground">
                    <div class="container"><?
                                        } else {
                                            header("Location:index.php");
                                        }
                                        ?>