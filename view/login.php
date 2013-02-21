<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Practice Login</title>
		<link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
		<link href="../images_user/favicon.ico" rel="shortcut icon" />
		<script type="text/javascript" src="../js/login_validation.js"></script>
	</head>
	<body class="pagebackground"><?
		
		// page header
		?><div align="center" style="margin-top:20px;padding-bottom:45px;"><a href="../index.php"><img src="../images_user/header-logo.png"></a></div>

		<form name="objForm" method="post" action="home.php" onsubmit="javascript:return checkValidation();">
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
							<td class="logintd">Email Address</td>
							<td><input type="text" name="txtName" id="txtName"></td>
						</tr>
						<tr>
							<td class="logintd">Password</td>
							<td><input type="password" name="txtPassword" id="txtPassword"></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>
					<div>
						<span style="margin-right:12px;"><button align="right" type="reset" value="Reset">Reset</button></span>
						<span><button align="right" type="submit" value="Login">Login</button></span>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>