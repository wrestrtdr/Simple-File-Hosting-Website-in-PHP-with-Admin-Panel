<?php
session_start();
error_reporting(5);
if(!isset($_SESSION['admin']))
{
	header("LOCATION:login.php");
}
else
{
	include("../include/conn.php");
	
	
	if(isset($_GET['form_purpose']))
	{
		if($_GET['form_purpose']=='status')
		{
			foreach($_POST['selected'] as $value => $temp)
			{	
				$chk_old_status="SELECT u_status from `users_info` WHERE `u_id`='".$value."'";
				$old_status=mysql_fetch_array(mysql_query($chk_old_status));
				if($old_status['u_status']=='active')
				{
					{
						$sql_change_status="UPDATE `users_info` SET `u_status`='inactive' WHERE `u_id`='".$value."'";
						mysql_query($sql_change_status);
					}
				}
				else if($old_status['u_status']=='suspended')
				{
					{
						$sql_change_status="UPDATE `users_info` SET `u_status`='active' WHERE `u_id`='".$value."'";
						mysql_query($sql_change_status);
					}
				}
			}
		}
		if($_GET['form_purpose']=='delete')
		{
			foreach($_POST['selected'] as $value => $temp)
			{
				$sql_get_each_file="SELECT * from `files_info` WHERE `file_upload_by`='".$value."';";
				$rslt_each_file=mysql_query($sql_get_each_file);
				$each_file=mysql_fetch_array($rslt_each_file);
				foreach($each_files as $key => $file)
				{
					$sql_delete_file="
						UPDATE `files_info` SET `file_status` = 'suspended' WHERE `file_code` = '".$file['file_code']."'";									
						$file_remove='../uploads/'.$file['file_code'];
					
						unlink($file_remove);
						mysql_query($sql_delete_file);				
				}
				
				$sql_delete_usr="UPDATE users_info SET `u_status` = 'deleted' WHERE `u_id` = '".$value."'";					
				mysql_query($sql_delete_usr);
			}
		}
	}
	
	if($_GET['action']=='status_change')
	{			
		if(isset($_GET['id']))
		{
				
				if($_GET['current_status']=='active')
				{
					{
						$sql_change_status="UPDATE `users_info` SET `u_status`='suspended' WHERE `u_id`='".$_GET['id']."'";
						mysql_query($sql_change_status);
					}
				}
				else if($_GET['current_status']=='suspended')
				{
					{
						$sql_change_status="UPDATE `users_info` SET `u_status`='active' WHERE `u_id`='".$_GET['id']."'";
						mysql_query($sql_change_status);
					}
				}
		}
	}
				
	$sortby='u_index';
	$order='ASC';
	$from_user_id='%';
		
	if(isset($_GET['action']))
	{
		switch($_GET['action'])
		{
			case 'sortbyuser':
				$sortby='u_id';
				break;
			case 'sortbyemail':
				$sortby='u_email';
				break;
			case 'sortbydate':
				$sortby='u_reg_date';
				break;
			case 'sortbytime':
				$sortby='u_reg_time';
				break;
			case 'sortbystatus':
				$sortby='u_status';
				break;
			default:
				$sortby='u_id';
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
	if(isset($_GET['from_user_id']))
	{		
		$from_user_id=$_GET['from_user_id'];
	}
	
	$sql_users="SELECT * from `users_info` ORDER BY `".$sortby."` ".$order."";
	if($result_users=mysql_query($sql_users))
	{
		while($temp=mysql_fetch_array($result_users))
		{
			$sql_count_files="SELECT * from files_info Where file_upload_by='".$temp['u_id']."';";
			$rslt_count_files=mysql_query($sql_count_files);
			$total_files[$temp['u_id']]=mysql_num_rows($rslt_count_files);	
			$total_downloads[$temp['u_id']]=0;
			while($row=mysql_fetch_array($rslt_count_files))
			{
				$total_downloads[$temp['u_id']]=$total_downloads[$temp['u_id']]+$row['file_downloads_count'];
			}
					 
			$details_users[]=$temp;
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
	<title>Admin Dashboard</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
	<!-- CSS Styles -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery.tipsy.css">
	<link rel="stylesheet" href="css/jquery.wysiwyg.css">

	<script src="js/libs/modernizr-1.7.min.js"></script>
</head>
<body>
	<!-- Aside Block -->
	<section role="navigation">
		<!-- Header with logo and headline -->
		<header>
		  <h1>ADMIN cPANEL for FILE HOSTING SITE</h1>
		</header>
		
		<!-- User Info -->
		<section id="user-info">
			<img src="img/sample_user.png" alt="Sample User Avatar">
			<div>
				<a href="user.php" title="Username"><?php echo $_SESSION['admin']['admin_id'] ?></a>
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
				<li><a href="index.php" title="" class="dashboard no-submenu">Manage files</a></li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
				<li class="current">
					<a href="user.php" title="" class="projects">Manage Users</a>
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
						foreach($details_users as $value => $temp)
						{
								$count=$count+1;
						} 
						echo $count;
					?></strong> Total users under your site</p>
			</div>
			<div class="widget increase" id="new-visitors">
				<p align="center"><strong>
				<?php 
					$count=0; 
					foreach($details_users as $value => $temp)
					{
						if($temp['u_status']=='active')
							$count=$count+1;
					} 
					echo $count; 
					?></strong> Total active uers</p>
			</div>
			<div class="widget decrease" id="new-visitors">
				<p align="center"><strong>
				<?php 
					$count=0; 
					foreach($details_users as $value => $temp)
					{
						if($temp['u_status']=='suspended')
							$count=$count+1;
					} 
					echo $count; 
					?></strong> Total suspended uers</p>
			</div>
			<!-- /Widget Box -->			
			
		</section>
		<!-- /Widget Container -->
		
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
		
			<!-- Article Header -->
			<header>
				<h2>User Manager</h2>
				<!-- Article Header Tab Navigation -->
			</header>
			<!-- /Article Header -->
			
			<!-- Article Content -->
			<section>
				<!-- Tab Content #tab1 --><!-- /Tab Content #tab1 -->
				
				<!-- Tab Content #tab2 with class. sidetabs for side tabs container -->
					<form class="table-form" name="users_selected" id="users_selected"  method="post">
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
                                        <?php 
											if((isset($_GET['action'])=='sortbyuser') && ($_GET['order'])=='ascending')
												echo '<th><a href="user.php?action=sortbyuser&order=descending" title="Sort By Name Descending Order">User ID</a></th>';
											else
												echo '<th><a href="user.php?action=sortbyuser&order=ascending" title="Sort By Name Ascending Order">User ID</a></th>';
										?>
												<th><a href="#">Password</a></th>
                                        <?php 
											if((isset($_GET['action'])=='sortbyemail') && ($_GET['order'])=='ascending')
												echo '<th><a href="user.php?action=sortbyemail&order=descending" title="Sort By Size Descending Order">Email</a></th>';
											else
												echo '<th><a href="user.php?action=sortbyemail&order=ascending" title="Sort By Size Ascending Order">Email</a></th>';
										?>
												<th><a href="#" title="IP">Reg IP</a></th>
                                        <?php 
											if((isset($_GET['action'])=='sortbydate') && ($_GET['order'])=='ascending')
												echo '<th><a href="user.php?action=sortbydate&order=descending" title="Sort By Time Descending Order">Reg Date</a></th>';
											else
												echo '<th><a href="user.php?action=sortbydate&order=ascending" title="Sort By Time Ascending Order">Reg Date</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbytime') && ($_GET['order'])=='ascending')
												echo '<th><a href="user.php?action=sortbytime&order=descending" title="Sort By Downloads Descending Order">Reg Time</a></th>';
											else
												echo '<th><a href="user.php?action=sortbytime&order=ascending" title="Sort By Downloads Ascending Order">Reg Time</a></th>';
										?>
                                        
												<th><a href="#">Total Files</a></th>
                                                <th><a href="#">Total Downloads</th>
                                        <?php 
											if((isset($_GET['action'])=='sortbystatus') && ($_GET['order'])=='ascending')
												echo '<th><a href="user.php?action=sortbystatus&order=descending" title="Sort By Status Descending Order">Status</a></th>';
											else
												echo '<th><a href="user.php?action=sortbystatus&order=ascending" title="Sort By Status Ascending Order">Status</a></th>';
										?>
									</tr>
								</thead>
								<tbody>
                                	<?php
										if(mysql_num_rows($result_users)<1)
										{
											echo '<tr>
												<td colspan="10">No User</td>
											</tr>';
										}
										else				
										{
												foreach($details_users as $value => $temp)
												{
														echo '<tr>
														<td><input type="checkbox" name="selected['.$temp['u_id'].']"></td>
														<td>'.$temp['u_id'].'</td>
														<td>'.$temp['u_pass'].'</td>
														<td>'.$temp['u_email'].'</td>
														<td>'.$temp['u_ip'].'</td>
														<td>'.$temp['u_reg_date'].'</td>
														<td>'.$temp['u_reg_time'].'</td>
														<td class="center"><a href="index.php?from_user_id='.$temp['u_id'].'">'.$total_files[$temp["u_id"]].'</a></td>
														<td class="center">'.$total_downloads[$temp['u_id']].'</td>';
														if($temp['u_status']=='deleted')
															echo '<td>deleted</td>';
														else
															echo '
															<td class="center">
																<a title="Change User Status" href="user.php?action=status_change&id='.$temp['u_id'].'&current_status='.$temp['u_status'].'">'.$temp['u_status'].'</a>
															</td>';
															
													
												}
										}
									?>
								</tbody>
							</table>
                            <br/>
							<button type="submit" onClick="document.users_selected.action='user.php?form_purpose=delete'">Delete</button>
							<button type="submit" onClick="document.users_selected.action='user.php?form_purpose=status&new_status=active'">Active</button>
							<button type="submit" onClick="document.users_selected.action='user.php?form_purpose=status&new_status=suspended'">Suspend</button>
					</form>
					<!-- /Side Tab Content #sidetab2 -->
			
			</section>
			<!-- /Article Content -->
					
			
		</article>
		<!-- /Full Content Block -->
	
	</section>
	<section role="main" style="height:400px;" >
    </section>
	<!-- /Main Content -->

	<!-- JS Libs at the end for faster loading -->

</body>

</html>