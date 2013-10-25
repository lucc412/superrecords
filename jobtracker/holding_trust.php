<?php
// include common file
include("include/common.php");

include(MODEL . "holding_trust_class.php");
$objHoldingTrust = new Holding_Trust();

include(VIEW . "holding_trust.php");

?>