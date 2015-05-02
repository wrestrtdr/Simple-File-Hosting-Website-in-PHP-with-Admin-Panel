<?php session_start() ;
		if(isset($_SESSION['user']['u_id'])!='')
						{
							header("LOCATION:index.php");
						}

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>File Host</title>
		<link href="menu.css" rel="stylesheet" type="text/css" />
		
		<link type="text/css" href="css/reset.css" rel="stylesheet" media="all" />
		<link type="text/css" href="css/base.css" rel="stylesheet" media="all" />
		<link type="text/css" href="css/red/style.css" rel="stylesheet" id="theme_stylesheet" />	
		<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>		
		
		<script type="text/javascript">
			$(document).ready( function(){
					
				$('.ui-state-default').hover( 
					function(){ 
						$(this).addClass('ui-state-hover'); 
					},
					function(){ 
						$(this).removeClass('ui-state-hover'); 
					}
				)
					
			});
			function forgot_form()
			{
				if(document.getElementById('forgot_pass_form').style.display=='none')
					document.getElementById('forgot_pass_form').style.display='block';
				else
					document.getElementById('forgot_pass_form').style.display='none';
			}
		</script>
	</head>
	<body>
		
		<div id="wrapper">
			
			<div id="header"><h1>&nbsp;</h1></div>
				
			<div id="content" class="ui-corner-all">
				<h1>Share your files with the world</h1>
				
			<div id="date"></div>
              <ul id="nav">
                    <li><a href="index.php">Home</a></li>
                    <?php
                    	if(isset($_SESSION['user']['u_id'])!='')
						{
							echo '
							   <li><a href="account">Dashboard</a></li>
							   <li><a href="include/logout.php">Logout</a></li>
							';
						}
						else
						{
							echo '<li class="current"><a href="login.php">Login</a></li>
					             <li><a href="signup_form.php">Sign up</a></li>
								';
						}
                    ?>
					<!--li><a href="#">Multi-Levels</a>
                        <ul>
                            <li><a href="#">Team</a>
                                <ul>
                                    <li><a href="#">Sub-Level Item</a></li>
                                    <li><a href="#">Sub-Level Item</a>
                                        <ul>
                                            <li><a href="#">Sub-Level Item</a></li>
                                            <li><a href="#">Sub-Level Item</a></li>
                                            <li><a href="#">Sub-Level Item</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="#">Sub-Level Item</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Sales</a></li>
                            <li><a href="#">Another Link</a></li>
                            <li><a href="#">Department</a>
                                <ul>
                                    <li><a href="#">Sub-Level Item</a></li>
                                    <li><a href="#">Sub-Level Item</a></li>
                                    <li><a href="#">Sub-Level Item</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li-->	
                    <li><a href="support.php">Support</a></li>
                </ul>
               	<div id="tabs" style="background-position: 50% 40px;">
				
				<div id="login">
						<h2>Login</h2>
						<ul class="form floatleft">
							<li><label class="desc">Username: </label> <input size="43" id="login_user" name="login_user" type="text" class="text required ui-corner-all cform" /></li>
							<li><label class="desc">Password: </label> <input size="43" id="login_pass" name="login_pass" type="password" class="text required ui-corner-all cform" /></li>
													
					  <li>
								<span id="contact_status"><a href="#" onclick="forgot_form()">Forgot password</a></span>
								<input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Login" onclick="send_data('login_status');"  />
								<div class="clearfix"></div>
							</li>
						</ul>
                       <br/>
                       <span class="form_status" id="login_status"></span>
                       
						<ul class="form floatleft">
                                <li><label class="desc">Username: </label> <input size="43" id="forgot_user" name="forgot_user" type="text" class="text required ui-corner-all cform" /></li>
                                                        
                             <li>
                                    <input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Send Password"  onclick="send_data('forgot_pass_status');"  />
                                </li>
                            </ul>
                       			<span class="form_status" id="forgot_pass_status"></span>
						<div class="clearfix"></div>
					</div>
                    
                   	<!-- end login tab -->
				
					
				
				</div>
				<!-- end tabs -->
				
			</div>
			<!-- end content -->
				
			<div class="clearfix"></div>
				
		</div>
		<!-- end wrapper -->
		
		
	</body>

</html>	