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
							echo '<li><a href="login.php">Login</a></li>
					             <li class="current"><a href="signup_form.php">Sign up</a></li>
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
				
				<div id="signup">
						<h2>Sign Up</h2>                        
						<div class="messages ui-corner-all" id="msg_contact"></div>
                            <ul class="form floatleft">
                                <li><label class="desc">Username: <font color="#FF0000">*</font></label> <input size="43" id="username" name="username" type="text" class="text required ui-corner-all cform" onkeyup="send_data('user_state');" onblur=" send_data('user_state');" />
                                <span class="status" id="user_state"></span>
                                </li>
                                <li><label class="desc">Password: <font color="#FF0000">*</font></label> <input size="43" id="pass" name="pass" type="password" class="text required ui-corner-all cform" / onkeyup="send_data('pass_status');" onblur=" send_data('pass_status');" >
                                <span class="status" id="pass_status"></span>
                                </li>
                                <li><label class="desc"> Confirm Password: <font color="#FF0000">*</font></label> <input size="43" name="confirm_pass" id="confirm_pass" type="password" class="text required ui-corner-all cform" onkeyup="send_data('confirm_pass_status');" onblur=" send_data('confirm_pass_status');" />
                                <span class="status" id="confirm_pass_status"></span>
                                </li>
                                <li><label class="desc"> Email ID: <font color="#FF0000">*</font></label> <input size="43" id="email" name="email" type="text" class="text required ui-corner-all cform"  onkeyup="send_data('email_status');" onblur=" send_data('email_status');" />
                                <span class="status" id="email_status"></span>
                                </li>
                                <li><label class="desc"> Captcha: <font color="#FF0000">*</font></label> 
                                <div><img src="include/captcha.php" alt="captcha image" style="margin-top:5px; margin-left:010px; float:left"/>
                                </div>
                                <input maxlength="6" id="captcha" name="captcha" type="text" class="text required ui-corner-all cform" style="width:100px; margin-left:10px;"  onkeyup="send_data('captcha_status');" onblur="send_data('captcha_status');" />
                                
                                <span class="status" id="captcha_status"></span>
                                </li>
                                                    
                          <li>
                            <input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Sign up" onclick="send_data('form_status');" />
                                <span class="form_status" id="form_status"></span>
                                    <div class="clearfix"></div>
                              </li>
                            </ul>
						<div class="clearfix"></div>
					</div>
					<!-- end signup tab -->
				
					
				
				</div>
				<!-- end tabs -->
				
			</div>
			<!-- end content -->
				
			<div class="clearfix"></div>
				
		</div>
		<!-- end wrapper -->
		
		
	</body>

</html>	