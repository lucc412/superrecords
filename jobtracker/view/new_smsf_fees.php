<?php
include(TOPBAR);

?><form method="post" action="paypal/payment.php">
<div style="padding-top:20px;"><u><b>Fees Details</b></u></div>
<div>
	<div>At befreesuper we invoice based on each financial year. The compliance fee per financial year is $1,548 plus GST ($1,702.80 inclusive of GST). On an ongoing basis, these fees are paid monthly at $129 plus GST ($141.90 inclusive of GST) per month.</div></br>	
	<?if(isset($_SESSION['NEW_REFCODE'])){
		?><div>As you have been referred by one of our referral partners, you receive a discount of 10% on our SMSF compliance fees.</div><br/><?
	}?>	

<div>In order to set up your fund, we will require payment of your set up fee. In addition, we will invoice you on an ongoing basis for the annual fees.</div></br>


	<div>
		By proceeding you are agreeing to;
		<ul style="list-style-type: none;">
			<li>
				1. Have befreesuper set up your SMSF  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>$<?=$setupFee?> plus GST</b> to be paid now
				<input type="hidden" name="fees" value="<?=$setupFee?>">
			</li>
			
			<li>
				2. Have befreesuper handle ongoing compliance &nbsp;&nbsp;&nbsp;  <b>$1,548 plus GST</b> per year to be paid over time
			</li>
		</ul>
	</div>
	
	
	</br>
	
	<div>
		You also confirm the following;
		<ul style="list-style-type: none;">
			<li>
				1. All of the details in this application are correct and you are authorised to complete this application.
			</li>
			<li>
				2. You will abide by the <a href="#" onclick="javascript:popUp('docs/terms_conditions.html');">terms and conditions</a> of the service.
			</li>
			<li>
				3. You will be paying the set up fee now and implementing a recurring payment plan for the ongoing fees.
			</li>
		</ul>
	</div>
	
	<div>If you agree to all of the above, please make payment of the set up fee using the payment gateway below. Once completed, your application will be submitted.</div></br>

</div>
	<div style="padding-top:20px;">
		<span align="left"><input type="button" onclick="window.location.href='new_smsf_declarations.php'" value="BACK" /></span>
		<span align="right" style="padding-left:1000px;"><input type="submit" value="NEXT" /></span>
	</div>
</form><?

include(FOOTER);
?>