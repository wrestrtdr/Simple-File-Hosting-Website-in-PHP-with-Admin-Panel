

<?php session_start() 

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
                    <li class="current"><a href="support.php">Support</a></li>
                </ul>
               
				<div id="tabs" style="background-position: 50% 40px;">
				
					<div id="Support">
						<h2>Support</h2>
                        <ul>
                        	<li>
                     	       <p> For any type of help or feedback please contact @ <a href="mailto:balramverma@gmail.com">balramverma@gmail.com</a></p>
							</li>
                        </ul>
                    </div>
					<!-- end Support tab -->
				
					
				
				</div>
				<!-- end tabs -->
				
			</div>
			<!-- end content -->
				
			<div class="clearfix"></div>
				
		</div>
		<!-- end wrapper -->
		
		
	</body>

</html>	