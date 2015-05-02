<?php session_start(); 
		if((isset($_GET['download'])|| isset($_GET['delete'])))
			unset($_SESSION['uploaded_file']);
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
                    <li class="current"><a href="index.php">Home</a></li>
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
                    <li><a href="support.php">Support</a></li>
                </ul>
                
				<div id="tabs" style="background-position: 50% 40px;">
				
										
					<div id="main">
						<div class="center" id="main">
                        	<?php 
								
								if(isset($_GET['delete'])!='')
								{
									include('include/conn.php');
									$sql_delete_chk='
									SELECT *
										FROM `files_info`
										WHERE `file_delete_id` = "'.$_GET['delete'].'" AND `file_status` = "active";
									';
									if(mysql_num_rows(mysql_query($sql_delete_chk))==1)
									{
										$result_delete_file=mysql_fetch_array(mysql_query($sql_delete_chk));
										echo '<h3>Confirm delete file</h3>
										<i>File Name:</i> '.$result_delete_file['file_name'].'
										
										<br/> <br/><i>File Size:</i> '.round(($result_delete_file['file_size']/1024),2).' KB
										<br/>
									<input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Confirm Delete File"  onclick="window.location=\'include/signup.php?deletefile='.$_GET['delete'].'\'" />
										';									
									}
									else
									{
										echo '<error>Cannot find file to delete</error>';
									}
								}
								else if(isset($_GET['download'])!='')
								{
									include('include/conn.php');
									
									$sql_download_chk='
									select * from files_info where file_code="'.$_GET["download"].'" AND file_status="active";
									';
								
									if(mysql_num_rows(mysql_query($sql_download_chk))==1  && file_exists('uploads/'.$_GET["download"]))
									{
										$result_download_file=mysql_fetch_array(mysql_query($sql_download_chk));
										$_SESSION['download_link_temp']=$_GET['download'];
										echo '<h3>Download file</h3>
										<i>File Name:</i> '.$result_download_file['file_name'].'
										
										<br/> <br/><i>File Size:</i> '.round(($result_download_file['file_size']/1024),2).' KB
										<br/>
									<input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Download File"  onclick="window.location=\'download.php\'" />
										';									
									}
									else
									{
										echo '<error>No File Found</error>';
									}
								}
								else if(isset($_GET['delete_file']))
								{
									if($_GET['delete_file']=='successful')
										echo '<error>File deleted</error>';
									else if($_GET['delete_file']=='fail')
										echo '<error>Error deleting file</error>';
									else
										echo '<error>Invalid attempt</error>';
								}
								
								else if(isset($_SESSION['uploaded_file']['name'])!='')
								{
									echo '
										<h3>Uploaded File Details</h3>                     
							   
										<i>File Name:</i> '.$_SESSION['uploaded_file']['name'].'
										
										<br/> <br/><i>File Size:</i> '.round(($_SESSION['uploaded_file']['size']/1024),2).' KB';
										
									echo '
										<br/>
										<br/>
										<h3>Links for uploaded file</h3>                     
							   
										
										<i>Download URL: </i>'.$_SERVER['HTTP_REFERER'].'?download='.$_SESSION['uploaded_file']['links']['download'].'<br/><br/><i>Delete URL: </i>'.$_SERVER['HTTP_REFERER'].'?delete='.$_SESSION['uploaded_file']['links']['delete'] ;	
										
										$_SESSION['temp_download_url']=$_SERVER['HTTP_REFERER'].'?download='.$_SESSION['uploaded_file']['links']['download'];
										$_SESSION['temp_delete_url']=$_SERVER['HTTP_REFERER'].'?download='.$_SESSION['uploaded_file']['links']['delete'];
										
									echo '
									<div style="display:block; height:50px;"></div>
									<input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Upload Another File"  onclick="window.location=\'include/signup.php?upload=new\'" />
										';				
										
									echo '
									<div style="display:block; height:50px;"></div>
									<h3>Email me links</h3>
									<ul class="form floatleft">
										
                                <li><label class="desc"> Email ID: <font color="#FF0000">*</font></label> 
									<input size="43" id="email" name="email" type="text" class="text required ui-corner-all cform"  onkeyup="send_data(\'email_status\');" onblur=" send_data(\'email_details_status\');" />
								
                                <span class="status" id="email_status"></span>
										<input class="button ui-state-default ui-corner-all floatright" style="display:inline;" type="submit" id="btn_contact" value="Send Email" onclick="send_data(\'email_details_status\');"  />
										</li>										
											
									</ul>
							 		  <br/>
									   <span class="form_status" id="email_details_status"></span>';				
								}
								
								else
								{
									echo '
										<h3>Browse and upload file</h3>                     
							   
									   <form name="upload" action="include/signup.php" id="upload"  enctype="multipart/form-data" method="post"> 
											<input type="file" name="upload_file" id="upload_file" />
									   </form>					
									<input class="button ui-state-default ui-corner-all floatright" type="submit" id="btn_contact" value="Upload File" style=" float:center; " onclick="document.upload.submit();" />
										';
								}
							?>
                            
                            <?php
								if(isset($_GET['error'])=='upload')
								{
									echo "<error>Error uploading file</error>";
								}
							?>
							<div class="clearfix"></div>
                        
                       </div>
					</div>
					<!-- end main tab -->
                  
					
				
				</div>
				<!-- end tabs -->
				
			</div>
			<!-- end content -->
				
			<div class="clearfix"></div>
				
		</div>
		<!-- end wrapper -->
		
		
		
	</body>

</html>	