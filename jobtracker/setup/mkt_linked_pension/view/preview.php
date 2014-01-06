<?php
// include topbar file
include(TOPBAR);
include(ACCPENSNNAV);

// page header
?><div class="pageheader">
    <h1>Preview</h1>
    <span><b>Welcome to the Super Records preview page for Account Based Pension.</b><span>
</div><?

// content
echo $html;

?><div class="txtAboveButton">If you wish to submit the document please use the 'Submit' button below. If you click 'Save & Exit', you will be able to <br/>complete the document later.</div> 
<div class="pdT20">
    <form name="objForm" action="preview.php">
        <span class="pdR20"><button type="button" onclick="window.location='pension.php'" value="Back">Back</button></span>
        <span class="pdR20"><button type="button" onclick="window.location='../../jobs_saved.php'">Save & Exit</button></span>
        <span><button type="submit" id="submit" name="submit">Submit</button></span>
    </form>
</div><?

// include footer file
include(FOOTER);
?>