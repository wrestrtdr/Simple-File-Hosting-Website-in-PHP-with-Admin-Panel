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
				$chk_old_status="SELECT file_status from `files_info` WHERE `file_code`='".$value."'";
				$old_status=mysql_fetch_array(mysql_query($chk_old_status));
				if($old_status['file_status']!='suspended')
				{
					{
						$sql_change_status="UPDATE `files_info` SET `file_status`='".$_GET['new_status']."' WHERE `file_code`='".$value."'";
						mysql_query($sql_change_status);
					}
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
			else if($_GET['current_status']=='active')
				$new_status='inactive';
			else
				$new_status='suspended';
			$temp_id=$_GET['id'];	
			$sql_change_status="UPDATE `files_info` SET `file_status`='".$new_status."' WHERE `file_code`='".$temp_id."'";
			mysql_query($sql_change_status);
		}
	}
				
	$sortby='file_upload_date';
	$order='ASC';
	$from_user_id='%';
		
	if(isset($_GET['action'])!=='status_change')
	{
		switch($_GET['action'])
		{
			case 'sortbyname':
				$sortby='file_name';
				break;
			case 'sortbyuser':
				$sortby='file_upload_by';
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
	if(isset($_GET['from_user_id']))
	{		
		$from_user_id=$_GET['from_user_id'];
	}
	
	$sql_files="SELECT * from files_info WHERE `file_upload_by` LIKE '".$from_user_id."' ORDER BY `".$sortby."` ".$order."";
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
				<li class="current"><a href="index.php" title="" class="dashboard no-submenu">Manage files</a></li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
				<li>
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
						foreach($details_files as $value => $temp)
						{
								$count=$count+1;
						} 
						echo $count;
					?></strong> Total files under your site</p>
			</div>
			<div class="widget increase" id="new-visitors">
				<p align="center"><strong>
				<?php 
					$count=0; 
					foreach($details_files as $value => $temp)
					{
						if($temp['file_status']=='active')
							$count=$count+1;
					} 
					echo $count; 
					?></strong> Active files under your site</p>
			</div>
			<div class="widget decrease" id="new-visitors">
				<p align="center"><strong>
				<?php 
					$count=0; 
					foreach($details_files as $value => $temp)
					{
						if($temp['file_status']=='inactive')
							$count=$count+1;
					} 
					echo $count; 
					?></strong> Inactive files under your site</p>
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
                </strong> Total downloads of lifetime</p>
			</div>
			<!-- /Widget Box -->			
			
		</section>
		<!-- /Widget Container -->
		
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
		
			<!-- Article Header -->
			<header>
				<h2>File Manager</h2>
				<!-- Article Header Tab Navigation -->
			</header>
			<!-- /Article Header -->
			
			<!-- Article Content -->
			<section>
				<!-- Tab Content #tab1 --><!-- /Tab Content #tab1 -->
				
				<!-- Tab Content #tab2 with class. sidetabs for side tabs container -->
					<form class="table-form" name="files_selected" id="files_selected"  method="post">
							<table>
								<thead>
									<tr>
										<th>&nbsp;</th>
                                        <?php 
											if((isset($_GET['action'])=='sortbyname') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbyname&order=descending" title="Sort By Name Descending Order">File</a></th>';
											else
												echo '<th><a href="index.php?action=sortbyname&order=ascending" title="Sort By Name Ascending Order">File</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbyuser') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbyuser&order=descending" title="Sort By Username Descending Order">User</a></th>';
											else
												echo '<th><a href="index.php?action=sortbyuser&order=ascending" title="Sort By Username Ascending Order">User</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbysize') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbysize&order=descending" title="Sort By Size Descending Order">Size</a></th>';
											else
												echo '<th><a href="index.php?action=sortbysize&order=ascending" title="Sort By Size Ascending Order">Size</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbydate') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbydate&order=descending" title="Sort By Date Descending Order">Upload Date</a></th>';
											else
												echo '<th><a href="index.php?action=sortbydate&order=ascending" title="Sort By Date Ascending Order">Upload Date</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbytime') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbytime&order=descending" title="Sort By Time Descending Order">Upload TIme</a></th>';
											else
												echo '<th><a href="index.php?action=sortbytime&order=ascending" title="Sort By Time Ascending Order">Upload TIme</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbydownloads') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbydownloads&order=descending" title="Sort By Downloads Descending Order">Total Downloads</a></th>';
											else
												echo '<th><a href="index.php?action=sortbydownloads&order=ascending" title="Sort By Downloads Ascending Order">Total Downloads</a></th>';
										?>
                                        <?php 
											if((isset($_GET['action'])=='sortbystatus') && ($_GET['order'])=='ascending')
												echo '<th><a href="index.php?action=sortbystatus&order=descending" title="Sort By Status Descending Order">Status</a></th>';
											else
												echo '<th><a href="index.php?action=sortbystatus&order=ascending" title="Sort By Status Ascending Order">Status</a></th>';
										?>
										<th><a href="#">Action</a></th>
									</tr>
								</thead>
								<tbody>
                                	<?php
										if(mysql_num_rows($result_files)<1)
										{
											echo '<tr>
												<td colspan="9">No File</td>
											</tr>';
										}
										else				
										{
												foreach($details_files as $value => $temp)
												{
														echo '<tr>
														<td><input type="checkbox" name="selected['.$temp['file_code'].']"></td>
														<td><a href="../index.php?download='.$temp['file_code'].'" target="_New" title="Download File" >'.$temp['file_name'].'</a></td>
														<td><a href="index.php?from_user_id='.$temp['file_upload_by'].'" target="_self" title="Browse by user" >'.$temp['file_upload_by'].'</a></td>
														<td>'.round(($temp['file_size']/1024),2).' KB</td>
														<td>'.$temp['file_upload_date'].'</td>
														<td class="center">'.$temp['file_upload_time'].'</td>
														<td class="center">'.$temp['file_downloads_count'].'</td>
														<td class="center"><a title="Change File Status" href="index.php?action=status_change&id='.$temp['file_code'].'&current_status='.$temp['file_status'].'">'.$temp['file_status'].'</a></td>';
														if($temp['file_status']=='suspended')
															echo '<td>deleted</td>';
														else
															echo '<td><a href="../index.php?delete='.$temp['file_delete_id'].'" target="_New" title="Delete File" >delete</a></td>';
														echo '
														</tr>';
													
												}
										}
									?>
								</tbody>
							</table>
                            <br/>
							<button type="submit" onClick="document.files_selected.action='index.php?form_purpose=delete'">Delete</button>
							<button type="submit" onClick="document.files_selected.action='index.php?form_purpose=status&new_status=active'">Active</button>
							<button type="submit" onClick="document.files_selected.action='index.php?form_purpose=status&new_status=inactive'">Inactive</button>
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