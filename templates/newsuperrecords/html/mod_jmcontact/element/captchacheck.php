<?php
/*------------------------------------------------------------------------
# mod_jmcontact - JM contact Module
# ------------------------------------------------------------------------
# author    JM-Experts.com
# copyright Copyright (C) 2011 JM-Experts.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/
require_once(dirname(__FILE__).'/recaptchalib.php');

$resp = recaptcha_check_answer ($_GET["field3"],
                                        $_SERVER["REMOTE_ADDR"],
                                        $_GET["field1"],
                                        $_GET["field2"]);



                         if($resp->is_valid){
                         echo "true";
                                            }else {

                                           if($resp->error=="incorrect-captcha-sol")  echo "false";
                                             else echo "false2";
                                            }

?>
