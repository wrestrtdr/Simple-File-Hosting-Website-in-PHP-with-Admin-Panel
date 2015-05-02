<?php
error_reporting(5);
	session_start();
	date_default_timezone_set('Asia/Kolkata');
if(isset($_GET['username']) && (isset($_GET['form_signup'])!=1))
{
		include("conn.php");
	$query_user_chk="select * from users_info where `u_id`='".$_GET['username']."';";
	if(mysql_num_rows(mysql_query($query_user_chk))<1)
	{
				echo "ok";
	}
	mysql_close();
}
	
else if(isset($_GET['captcha']) && (isset($_GET['form_signup'])!=1))
{
	if(($_GET['captcha'])==$_SESSION['captcha'])
	{
				echo "ok";
	}
}
	
else if((isset($_GET['form_signup'])==1))
{
	if($_GET['captcha']=='' || $_GET['confirm_pass']=='' || $_GET['pass']=='' || $_GET['username']=='' || $_GET['email']=='')
	{
		echo "All fields must be filled";
	}
	else
	{
		include("conn.php");
		if($_SESSION['msg']==0)
		{
			if($_SESSION["captcha"]==$_GET["captcha"])
			{
				if($_GET["pass"]!=$_GET["confirm_pass"])
				{					
					echo "Password and Confirm Password donot match";			
				}
				else  if($_GET['email_status']!='ok')
				{					
					echo "Invalid  address entered";	
				}
					
				else
				{
					
					$query_user_chk="select * from users_info where `u_id`='".$_GET['username']."'";
				
					if(mysql_num_rows(mysql_query($query_user_chk))<1)
					{
						$uip=$_SERVER['REMOTE_ADDR'];
						$query_signup="
						insert into users_info
						(`u_id`, `u_pass`, `u_email`, `u_ip`, `u_reg_date`, `u_reg_time`,  `u_status`) 
						 values 
						(
							'".$_GET['username']."',
							'".$_GET['pass']."',
							'".$_GET['email']."',
							'".$uip."',
							'".date("Y-m-d")."',
							'".date("H:i:s")."',
							'active'
						)
						";
						
						if(mysql_query($query_signup))
						{
							echo "Username ".$_GET['username']." registered successfully";					
						}
						else
						{
							echo "Error in adding user";
						}
												
						mysql_close();
					}
					else
					{
							echo "Username already exists";
						
					}
				}
			}
			else
			{
						echo "Captcha not matched";
			}
		}
	}
		
}
	
else if(isset($_GET['form_forgot_password'])==1)
{
	include("conn.php");
	$query_chk_user="SELECT * FROM users_info WHERE `u_id`='".$_GET['forgot_user']."' and `u_status`='active'";
	
	if($result_chk_user=mysql_query($query_chk_user))
	{
		if(mysql_num_rows($result_chk_user)>0)
		{
			$row_user=mysql_fetch_array($result_chk_user);
			
						$message="
						USERNAME: ".$row_user['u_id']."
						<br/>PASSWORD: ".$row_user['u_pass']
						;
						$to=$row_user['u_email'];
						$subject="Password Recovery";
						$from="balramverma@gmail.com";
						
						/*function spamcheck($field)
						  {
							  //filter_var() sanitizes the e-mail
							  //address using FILTER_SANITIZE_
							  $field=filter_var($field, FILTER_SANITIZE_);
							
							  //filter_var() validates the e-mail
							  //address using FILTER_VALIDATE_
							  if(filter_var($field, FILTER_VALIDATE_))
								{
									return TRUE;
								}
							  else
								{
									return FALSE;
								}
						  }
						  
						  //check if the  address is invalid
						  $mailcheck = spamcheck($to);
						  if ($mailcheck==FALSE)
							{
								echo "Invalid email input";
							}
						  else*/
							{
								//send 
								error_reporting(5);
								if(mail($to, "Subject: $subject",$message, "From: $from"))
									echo "Password sent to your email address";
								else
									echo "Error Sending eMail";
							}
				
		}
		else
			echo "User not found";
	}
	else
	{
		echo "Error accessing database";
	}
}

else if(isset($_GET['form_login'])==1)
{
	include("conn.php");
	
	if($_GET['login_user']=="" || $_GET['login_pass']=="")
	{
			echo "All fields must be filled";
	}
	else
	{
		$query_login_chk="Select * from users_info where `u_id`='".$_GET['login_user']."' AND (`u_status`='active' OR `u_status`='suspended')";
		if($sql_user=mysql_query($query_login_chk))
		{
			$result_user=mysql_fetch_array($sql_user);
			
			if(mysql_num_rows($sql_user)>0)
			{
				if($result_user['u_status']=="active")
				{	
					if(($_GET['login_pass']==$result_user['u_pass']))
					{
						$_SESSION['user']=$result_user;						
						echo "logged in";
					}
					else
					{	
						echo "Invalid password";
					}
				}
				else if($result_user['u_status']=="suspended")
				{
						echo "User blocked by Administrator";					
				}
				else
				{
					echo "User not found";
				}
			}
			else
			{
				echo "User not found";
			}
			
			mysql_close();
		}
		else
		{
			echo "Could not execute query";
		}
	}
	
}

else if(isset($_FILES['upload_file']['name'])!='')
{
	$target_path = "../uploads/";
		
	$file_id= uniqid();
	$delete_id=uniqid();
	if(isset($_SESSION['user']))
		$user=$_SESSION['user']['u_id'];
	else
		$user='guest';
		
	include("conn.php");
	$target_path = $target_path . $file_id; 
	
	$query_file_upload="
		insert into files_info
						(`file_code`, `file_name`, `file_delete_id`, `file_size`, `file_upload_date`, `file_upload_time`,  `file_upload_by`,  `file_upload_ip`,  `file_status`) 
						 values 
						(
							'".$file_id."',
							'".$_FILES['upload_file']['name']."',
							'".$delete_id."',
							'".$_FILES['upload_file']['size']."',
							'".date("Y-m-d")."',
							'".date("H:i:s")."',
							'".$user."',
							'".$_SERVER['REMOTE_ADDR']."',
							'active'
						)
		
		";
		
	if(mysql_query($query_file_upload) && move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_path) ) 
	{
			$_SESSION['uploaded_file']=$_FILES['upload_file'];
			$_SESSION['uploaded_file']['links']['download']=$file_id;
			$_SESSION['uploaded_file']['links']['delete']=$delete_id;
			header("LOCATION:../index.php");
	} 
	else
	{
    	header("LOCATION:../index.php?error=upload");
	}	
}
else if(isset($_GET['form_email'])==1)
{
				 if($_GET['email_status']=='ok')
				{		
					
						$message="
						File Name: ".$_SESSION['uploaded_file']['name']."
						<br/>File Size: ".round(($_SESSION['uploaded_file']['size']/1024),2)." KB
						<br/>Download URL: ".$_SESSION['temp_download_url']."
						<br/>Delete URL: ".$_SESSION['temp_delete_url'].""
						;
						
						$to=$_GET['email'];
						$subject="Details of file uploaded on sharing site";
						$from="balramverma@gmail.com";
						
						/*function spamcheck($field)
						  {
							  //filter_var() sanitizes the e-mail
							  //address using FILTER_SANITIZE_
							  $field=filter_var($field, FILTER_SANITIZE_);
							
							  //filter_var() validates the e-mail
							  //address using FILTER_VALIDATE_
							  if(filter_var($field, FILTER_VALIDATE_))
								{
									return TRUE;
								}
							  else
								{
									return FALSE;
								}
						  }
						  
						  //check if the  address is invalid
						  $mailcheck = spamcheck($to);
						  if ($mailcheck==FALSE)
							{
								echo "Invalid input";
							}
						  else*/
							{
								//send 
								error_reporting(5);
								if(mail($to, "Subject: $subject",$message, "From: $from"))
									echo " sent";
								else
									echo "Error Sending Mail";
							}
						
				}
				else
				{
					echo "Invalid  address entered";	
				}
}
else if(isset($_GET['deletefile'])!='')
{
		
	include("conn.php");
	unset($_SESSION['uploaded_file']);
	$sql_delete_file="
		UPDATE files_info SET `file_status` = 'suspended' WHERE `file_delete_id` = '".$_GET['deletefile']."' AND `file_status` = 'active'";
		
	$sql_remove_file="SELECT file_code from files_info WHERE `file_delete_id` = '".$_GET['deletefile']."' AND `file_status` = 'active'";
		
	if($file_remove=mysql_fetch_array(mysql_query($sql_remove_file)))
	{
		$file_remove='../uploads/'.$file_remove['file_code'];
		if((unlink($file_remove)) && (mysql_query($sql_delete_file)))
		{	
			mysql_close();	
			header("LOCATION:../index.php?delete_file=successful");
		}
		else	
		{
			mysql_close();
			header("LOCATION:../index.php?delete_file=fail");
		}
	}
	else
	{		
			mysql_close();
			header("LOCATION:../index.php?delete_file=fail");	
	}
		
}
else if(isset($_GET['upload'])=='new')
{
		unset($_SESSION['uploaded_file']);
		header("LOCATION:../index.php");
		
}
else if(isset($_GET['form_change_user_password'])=='1')
{
	include("conn.php");
	$current=$_GET['current_password'];
	$new=$_GET['new_password'];
	$confirm=$_GET['confirm_password'];
	if($current=='' || $new=='' || $confirm=='')
	{
		echo "All fields are must to be filled";
	}
	else
	{
		if($new == $confirm)
		{
			$chk_old_pass="SELECT `u_pass` from `users_info` WHERE `u_id` = '".$_SESSION['user']['u_id']."'";
			$rslt_old_pass=mysql_fetch_array(mysql_query($chk_old_pass));
			if($rslt_old_pass['u_pass']==$current)
			{
				$sql_change_pass="UPDATE `users_info` SET `u_pass` = '".$new."' WHERE `u_id` = '".$_SESSION['user']['u_id']."'";
				if(mysql_query($sql_change_pass))
					echo "Password changed successfully";
				else
					echo "Backend error in changing password";
				
			}
			else
			{
				echo "Invalid Current Password";
			}
		}
		else
		{
			echo 'New and Confirm Password donot match';
		}
	}
		
	mysql_close();
}
else if(isset($_GET['form_change_user_email'])=='1')
{
	include("conn.php");
	$current_pass=$_GET['current_password_email'];
	$new_email=$_GET['new_email'];
	$email_state=$_GET['email_state'];
	if($current_pass=='' || $new_email=='')
	{
		echo "All fields are must to be filled";
	}
	else
	{
		if($email_state=='ok')
		{
			$chk_old_pass="SELECT `u_pass` from `users_info` WHERE `u_id` = '".$_SESSION['user']['u_id']."'";
			$rslt_old_pass=mysql_fetch_array(mysql_query($chk_old_pass));
			if($rslt_old_pass['u_pass']==$current_pass)
			{
				$sql_change_pass="UPDATE `users_info` SET `u_email` = '".$new_email."' WHERE `u_id` = '".$_SESSION['user']['u_id']."'";
				if(mysql_query($sql_change_pass))
					echo "Email changed successfully";
				else
					echo "Backend error in changing password";
				
			}
			else
			{
				echo "Invalid password entered";
			}
		}
		else
		{
				echo "Invalid  address entered";
		}
	}
		
	mysql_close();
}

else if(isset($_GET['form_delete_account'])=='1')
{
	include("conn.php");
	$current_pass=$_GET['current_password_delete'];
	if($current_pass=='')
	{
		echo "All fields are must to be filled";
	}
	else
	{
		
			$chk_old_pass="SELECT `u_pass` from `users_info` WHERE `u_id` = '".$_SESSION['user']['u_id']."'";
			$rslt_old_pass=mysql_fetch_array(mysql_query($chk_old_pass));
			if($rslt_old_pass['u_pass']==$current_pass)
			{
				$sql_get_files="SELECT `file_code` from `files_info` WHERE `file_upload_by` = '".$_SESSION['user']['u_id']."' AND `file_status` = 'active' OR `file_status` = 'inactive'";
				$sql_delete_user="UPDATE `users_info` SET `u_status` = 'deleted' WHERE `u_id` = '".$_SESSION['user']['u_id']."'";
					
				if($result_get_files=mysql_query($sql_get_files))
				{
					while($file=mysql_fetch_array($result_get_files))
					{
						$file_remove='../uploads/'.$file['file_code'];
						unlink($file_remove); 
						
						$sql_delete_file="UPDATE `files_info` SET `file_status` = 'suspended' WHERE `file_code` = '".$file['file_code']."'";
						
						mysql_query($sql_delete_file);
						
						
					}
					
									
					if(mysql_query($sql_delete_user))
						echo "deleted";
					else
						echo "Error occurred. Your files are lost in the mid way.";
				}
				else
					echo "Backend error in changing password";
				
			}
			else
			{
				echo "Invalid password entered";
			}
	}	
}
else if(isset($_GET['admin_login'])==1)
{
	include("conn.php");
	$sql_admin_login="SELECT * from admin_info WHERE `admin_id`= '".$_GET['admin_user']."'";
	if($rslt_admin_info=mysql_query($sql_admin_login))
	{
		$admin_details=mysql_fetch_array($rslt_admin_info);
		if($admin_details['admin_pass']==($_GET['admin_pass']))	
		{
			$_SESSION['admin']=$admin_details;
			echo "logged in";
		}
		else
		{
			echo "error logging in";
		}
	}
	
	else
	{
			echo "error logging in";
	}
}
else
{
	echo 'Not accessible file';
}

?>