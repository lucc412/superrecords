<?php
//*************************************************************************************************
//  Task          : ORDER List of Audit Checklists
//  Modified By   : Nishant Bhatt
//  Created on    : 7-Jan-2014
//  Last Modified : 7-Jan-2014
//************************************************************************************************
?>
<div class="frmheading">
	<h1>Audit <?=isset($_REQUEST['parent_id'])?"Sub":"";?>Checklist</h1>
</div>
<div class="savedclass">The order you set is saved !!!</div>
<div id="contentLeft">
	<ul>
	<?
		$countRow = 0;
		while($arrInfo = mysql_fetch_assoc($arrChecklist)) {?>
				<li class="ui-state-default" id="recordsArray_<?=$arrInfo["cid"];?>"><?=htmlspecialchars($arrInfo["name"])?></li>			
		<?
		$countRow++;
		}
	?>
	</ul>
</div>
	
<script>
	$(document).ready(function(){ 

	$(".savedclass").hide();	
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
	        $(".savedclass").hide(500);	
	        var order = $(this).sortable("serialize"); 
			$.post("../ajax/sort_data.php", order, function(theResponse){
				//$("#contentRight").html(theResponse);
	            $(".savedclass").show(500);	
	            $(".savedclass").fadeOut(2500);
			});														 
		}								  
		});	    

});		
</script>