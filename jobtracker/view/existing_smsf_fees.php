<?php
include(TOPBAR1);

?>
<form action="https://secure.ezidebit.com.au/webddr/RequestForm.aspx?a=0X313939393442464547454E&debits=4" method="post" >
<!--<form action="https://demo.ezidebit.com.au/webddr/RequestForm.aspx?b=16148&c=ezi&d=ddr" method="post" >-->
				
	<div style="padding-top:20px;">
		<div style="padding-bottom:20px;">
			At befreesuper we invoice based on each financial year. The compliance fee per financial year is $<?=$amt?> plus GST ($1,702.80 inclusive of GST). On an ongoing basis, these fees are paid monthly at $129 plus GST ($141.90 inclusive of GST) per month. 
		</div> 
		<?if(isset($_SESSION['EXST_REFCODE'])){
			?><div id="disc" style="padding-bottom:20px;">
			As you have been referred by one of our referral partners, you receive a discount of 10% on our SMSF compliance fees.
		</div><?	
		}?>
		 

		<div style="padding-bottom:20px;">
			By proceeding to complete this application you are agreeing to have befreesuper handle all of your ongoing SMSF compliance for your superfund.
		</div>

		<div style="padding-bottom:20px;">
			You also confirm the following:
			<ul>
				<li>1.	All of the details in this application are correct and you are authorised to complete this application.</li>
				<li>2.	You have read and will abide by the <a href="#" onclick="javascript:popUp('docs/terms_conditions.html');">terms and conditions</a> of the service.</li>
				<li>3.	You will be implementing a recurring payment plan for the ongoing fees out of your superfund bank account.</li>
			</ul>
		</div>

		<div style="padding-bottom:20px;">
			<b>If you agree to all of the above, please make payment of the set up fee using the payment gateway below. </b>Please ensure you use the bank account details of the superfund at this step. Once completed, your application will be submitted and one of our SMSF Specialists will be in contact to arrange the collection of your data.
		</div>
	</div>
<<<<<<< HEAD
	<input type="hidden" name="debits" value="4" />	
	<input type="hidden" name="callback" value="<? echo "http://".$_SERVER['HTTP_HOST']."/success.php";?>" />
=======
	<!--<input type="hidden" name="freq" value="4" />-->
	<input type="hidden" name="debits" value="1" />			
	<input type="hidden" name="oAmount" value="<?=$amt?>" />
	<input type="hidden" name="oDate" value="1" />
	<!--<input type="hidden" name="tamount" value="<?=$amt?>" />-->
	<!--<input type="hidden" name="rAmount" value="129.00" />-->
	<input type="hidden" name="callback" value="<?=SERVER?>/success.php" />
>>>>>>> 1284e9523ad22310ad67cf878b1df2a9b278b102
	<input type="hidden" name="cmethod" value="post" />
		
	<div style="padding-top:20px;">
		<span align="left">
		<input type="button" onclick="window.location.href='existing_smsf_fund.php'" value="BACK" /></span>
		<div style="float: right">
			<input  type="submit" value="NEXT" />
		</div>	
	</div>
</form><?php
include(FOOTER); 
?>