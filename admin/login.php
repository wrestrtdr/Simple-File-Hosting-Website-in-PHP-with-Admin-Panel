<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="UTF-8">
	<!--[if IE 8 ]><meta http-equiv="X-UA-Compatible" content="IE=7"><![endif]-->
	<title>Admin Panel for File Sharing Site</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
	<!-- CSS Styles -->
	<link rel="stylesheet" href="css/style.css">

	<script src="../js/ajax.js"></script>
</head>
<body class="login">
	<section role="main">
	
	
		<!-- Login box -->
		<article id="login-box">
			<img src="img/sample_logo.png"/> 
            <p style="display:inline; margin:5px; font-size:34px;">Admin Panel</p>
			<form >
			  <fieldset>
					<dl>
						<dt>
							<label>Login</label>
						</dt>
						<dd>
							<input type="text" class="large" name="admin_user" id="admin_user">
						</dd>
						<dt>
							<label>Password</label>
						</dt>
						<dd>
							<input type="password" class="large" name="admin_pass" id="admin_pass">
						</dd>
					</dl>
				</fieldset>
				<button type="button" class="right" = onClick="send_data('admin_login_status')">Log in</button>
			</form>
		
		</article>
		<!-- /Login box -->
	
		<!-- Notification -->
		<div class="notification error" id="admin_login_status" style="display:none">
			<p><strong>Error</strong> Cannot log into admin panel. Please look into the problem.</p>
		</div>
		<!-- /Notification -->
		
	</section>


</body>

</html>