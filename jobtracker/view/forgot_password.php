<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>Password Recovery</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
		<link href="images_user/favicon.ico" rel="shortcut icon" />
		<script type="text/javascript" src="js/login_validation.js"></script>
        </head>
	<body class="pagebackground"><?
		
		// page header
		?><div align="center" style="margin-top:20px;padding-bottom:45px;"><a href="http://<?=$_SERVER['SERVER_NAME']?>/index.php"><img src="images_user/header-logo.png"></a></div>

		<form name="objForm" id="objForm" method="post" action="home.php" onsubmit="javascript:return userValidation();">
			<input type="hidden" name="flgFrgtPass" id="flgFrgtPass" value="forgot"/>
			<div align="center"><?

				// error message if login attempt fails
				if($flagError == 'Y') {
					?><div class="errorMsg" style="width:300px; margin-bottom:15px;">A user with this email address was not found.</div><?
				}

				// error message if login attempt fails
				if($flagSuccess == 'Y') {
					?><div class="errorMsg" style="width:550px; margin-bottom:15px;">Password was sent to your email. Please check your email for a message from Super Records.</div><?
				}

				?><div align="center" class="logindiv"><?

					// page header
					?><div class="loginheader">
						<span>Forgot Password</span>
					</div>

					<table cellpadding="10px" width="80%">
						<tr>
							<td class="logintd">Email Address</td>
							<td><input type="text" name="txtName" id="txtName">
							<span style="color:red">
							*
							</span>
							<br>
							<div name="val_username" id="val_username" style=" color:red; font-size:11px;padding-bottom:15px;"></div>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
					<div>
						<span style="margin-right:12px;"><button align="right" type="reset" value="Reset">Reset</button></span>
						<span><button align="right" type="submit"  value="Submit">Submit</button></span>
					</div>
               </div>
			</div>
		</form>
	</body>
</html>