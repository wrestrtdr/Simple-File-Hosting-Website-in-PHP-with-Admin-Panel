<?php
session_start();
error_reporting(5);
if(!isset($_SESSION['user']))
{
	header("LOCATION:../login.php");
}
else
{
	include("../include/conn.php");
	
	if(isset($_GET['form_purpose']))
	{
		if($_GET['form_purpose']=='passchange')
		{
			if($_GET['new_status']=='inactive')
			{
				foreach($_POST['selected'] as $value => $temp)
				{
					$sql_change_status="UPDATE `files_info` SET `file_status`='inactive' WHERE `file_code`='".$value."'";
					mysql_query($sql_change_status);
				}
			}
			else if($_GET['new_status']=='active')
			{
				foreach($_POST['selected'] as $value => $temp)
				{
					$sql_change_status="UPDATE `files_info` SET `file_status`='active' WHERE `file_code`='".$value."'";
					mysql_query($sql_change_status);
				}
			}
		}
		if($_GET['form_purpose']=='delete')
		{
			foreach($_POST['selected'] as $value => $temp)
			{
				$sql_delete_file="
					UPDATE files_info SET `file_status` = 'suspended' WHERE `file_code` = '".$value."'";
									
					$file_remove='../uploads/'.$value;
					
					unlink($file_remove);
					mysql_query($sql_delete_file);				
			}
		}
	}
	
	if($_GET['action']=='status_change')
	{			
		if(isset($_GET['id']))
		{
			if($_GET['current_status']=='inactive')
				$new_status='active';
			else
				$new_status='inactive';
			$temp_id=$_GET['id'];	
			$sql_change_status="UPDATE `files_info` SET `file_status`='".$new_status."' WHERE `file_code`='".$temp_id."'";
			mysql_query($sql_change_status);
		}
	}
				
	$sortby='file_upload_date';
	$order='ASC';
		
	if(isset($_GET['action']))
	{
		switch($_GET['action'])
		{
			case 'sortbyname':
				$sortby='file_name';
				break;
			case 'sortbysize':
				$sortby='file_size';
				break;
			case 'sortbydate':
				$sortby='file_upload_date';
				break;
			case 'sortbytime':
				$sortby='file_upload_time';
				break;
			case 'sortbydownloads':
				$sortby='file_downloads_count';
				break;
			case 'sortbystatus':
				$sortby='file_status';
				break;
			default:
				$sortby='file_upload_date';
				break;
		}
	}
	
	if(isset($_GET['order']))
	{
		switch($_GET['order'])
		{
			case 'descending':
				$order='DESC';
				break;
			default:
				$order='ASC';
				break;
		}
	}
	
	$sql_files="SELECT * from files_info WHERE `file_upload_by`='".$_SESSION['user']['u_id']."' AND `file_status`!='suspended' ORDER BY `".$sortby."` ".$order."";
	
	if($result_files=mysql_query($sql_files))
	{
		while($temp=mysql_fetch_array($result_files))
		{
			$details_files[]=$temp;
		}
	}
	else
	{
		echo "database error";
		die();
	}
}
?>
<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="UTF-8">
	<!--[if IE 8 ]><meta http-equiv="X-UA-Compatible" content="IE=7"><![endif]-->
	<title>User Dashboard</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
	<!-- CSS Styles -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery.tipsy.css">
	<link rel="stylesheet" href="css/jquery.wysiwyg.css">

	<script src="js/libs/modernizr-1.7.min.js"></script>
	<script src="../js/ajax.js"></script>
</head>
<body>
	<!-- Aside Block -->
	<section role="navigation">
		<!-- Header with logo and headline -->
		<header>
		  <h1>....Share with the world</h1>
		</header>
		
		<!-- User Info -->
		<section id="user-info">
			<img src="img/sample_user.png" alt="Sample User Avatar">
			<div>
				<a href="user.php" title="Username"><?php echo $_SESSION['user']['u_id'] ?></a>
				<ul>
					<li><a class="button-link" href="../index.php" title="Back to home" rel="tooltip">Back to home</a></li>
					<li><a class="button-link" href="../include/logout.php" title="Logout" rel="tooltip">logout</a></li>
				</ul>

			</div>
		</section>
		<!-- /User Info -->
		
		<!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
				<li ><a href="index.php" title="" class="dashboard no-submenu">File Manager</a></li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
				<li class="current">
					<a href="user.php" title="" class="projects">User Settings</a>
				</li>
				
		  </ul>
		</nav>
		<!-- /Main Navigation -->
	</section>
    
	<!-- /Aside Block -->
	
	<!-- Main Content -->
	<section role="main" >
	
		<!-- Widget Container -->
		<section id="widgets-container">
		
			<!-- Widget Box -->
			<div class="widget increase" id="new-visitors">
				<p align="center"><strong>
					<?php 					
						$count=0; 
						foreach($details_files as $value => $temp)
						{
							if(file_exists("../uploads/".$temp['file_code']))
								$count=$count+1;
						} 
						echo $count;
					?></strong> Total files under your account</p>
			</div>
			<div class="widget decrease" id="new-visitors">
				<p align="center"><strong>
				<?php 
					$count=0; 
					foreach($details_files as $value => $temp)
					{
							$count=$count+$temp['file_downloads_count'];
					} 
					echo $count; 
				?>
                </strong> Total downloads of your files</p>
			</div>
			<!-- /Widget Box -->			
			
		</section>
		<!-- /Widget Container -->
		
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
		
			<!-- Article Header -->
			<header>
				<h2>Account Settings</h2>
				<!-- Article Header Tab Navigation -->
			</header>
			<!-- /Article Header -->
			
			<!-- Article Content -->
			<section>
						<form>
							<!-- Inputs -->
							<!-- Use class .small, .medium or .large for predefined size -->
							<fieldset>
								<legend>Change Password</legend>
								<dl>
									<dt>
										<label>Current Password</label>
									</dt>
									<dd>
										<input type="password" class="medium" name="current_password" id="current_password">
									</dd>
									<dt>
										<label>New Password</label>
									</dt>
									<dd>
										<input type="password" class="medium" name="new_password" id="new_password">
									</dd>
									<dt>
										<label>Confirm Password</label>
									</dt>
									<dd>
										<input type="password" class="medium" name="confirm_password" id="confirm_password">
									</dd>
								</dl>
							</fieldset>
							<button type="button" onClick="send_data('change_pass_status')">Change Password</button>
					<!-- Notification -->
					<div class="notification attention" id="change_pass_status" style="display:none;">		</div>
					<!-- /Notification -->					
						</form>
                        
						
						<form>
							<!-- Inputs -->
							<!-- Use class .small, .medium or .large for predefined size -->
							<fieldset>
								<legend>Change Email</legend>
								<dl>
									<dt>
										<label>Current Password</label>
									</dt>
									<dd>
										<input type="password" class="medium" name="current_password_email" id="current_password_email">
									</dd>
									<dt>
										<label>New Email</label>
									</dt>
									<dd>
										<input type="text" class="medium" name="new_email" id="new_email">
									</dd>
								</dl>
							</fieldset>
							<button type="button" onClick="send_data('change_email_status')">Change Email</button>
					<!-- Notification -->
					<div class="notification attention" id="change_email_status" style="display:none;">		</div>
					<!-- /Notification -->					
						</form>
                    <br/> 
						
						<form>
							<!-- Inputs -->
							<!-- Use class .small, .medium or .large for predefined size -->
							<fieldset>
								<legend>Delete Account</legend>
								<dl>
									<dt>
										<label>Current Password</label>
									</dt>
									<dd>
										<input type="password" class="medium" name="current_password_delete" id="current_password_delete">
										<button type="button" onClick="send_data('account_delete_status')">DELETE ACCOUNT</button>
									</dd>
								</dl>
							</fieldset>
					<!-- /Notification -->					
						</form>
					<div class="notification attention" id="account_delete_status" style="display:none;">		</div>
				
					<!-- /Side Tab Content #sidetab2 -->
			
			</section>
			<!-- /Article Content -->
					
			
		</article>
		<!-- /Full Content Block -->
	
	</section>
	<!-- /Main Content -->

	<!-- JS Libs at the end for faster loading -->

</body>

</html>