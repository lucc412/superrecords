<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>Practice Login</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
		<link href="images_user/favicon.ico" rel="shortcut icon" />
		<script type="text/javascript" src="js/login_validation.js"></script>
	</head>
	<body class="pagebackground"><?
		
		// page header
		?><div align="center" style="margin-top:20px;padding-bottom:45px;"><a href="http://<?=$_SERVER['SERVER_NAME']?>/index.php"><img src="images_user/header-logo.png"></a></div>

		<form name="objForm" id="objForm" method="post" action="home.php" onsubmit="javascript:return checkValidation();">
			<div align="center"><?

				// error message if login attempt fails
				if(!empty($_REQUEST['loginFail'])) {
					?><div class="errorMsg" style="width:300px; margin-bottom:15px;">Sorry, Your email address or password does not match.</div><?
				}

				?><div align="center" class="logindiv"><?

					// page header
					?><div class="loginheader">
						<span>Welcome to Practice Login</span>
					</div>

					<table cellpadding="10px" width="80%">
						<tr>
							<td class="logintd">User Name </td>
							<td><input type="text" name="txtName" id="txtName">
							<span style="color:red">
							*
							</span>
							<br>
							<div name="val_username" id="val_username" style=" color:red; font-size:11px;padding-bottom:15px;"></div>
							</td>
						</tr>
						<tr>
							<td class="logintd">Password</td>
							<td><input type="password" name="txtPassword" id="txtPassword" onblur="password()">
							<span style="color:red">
							*
							</span>
							<br>
							<span name="val_password" id="val_password" style=" color:red; font-size:11px;"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<span style="font-size:11px;">Forgot password?</span>
								<a style="text-decoration:none; color:#001590; font-size:12px; font-weight:bold;" onclick="window.open('forgot_password.php','subwindow','toolbar=no,location=no,directories=no,status=yes,scrollbars=yes,menubar=no,resizable=yes,height=500,width=800');return false" href="#">Click here</a>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
					<div>
						<span style="margin-right:12px;"><button align="right" type="reset" value="Reset">Reset</button></span>
						<span><button align="right" type="submit"  value="Login">Login</button></span>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>