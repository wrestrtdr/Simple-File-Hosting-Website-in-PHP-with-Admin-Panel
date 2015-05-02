<?php
session_start();

if(isset($_SESSION['download_link_temp']))
{
	include('include/conn.php');
	$sql_file_name="select `file_name` from `files_info` WHERE `file_code`='".$_SESSION['download_link_temp']."';";	
	$new_filename=mysql_fetch_array(mysql_query($sql_file_name));
	
    $file='uploads/'.$_SESSION['download_link_temp'];
	
	$download_count="Select file_downloads_count from files_info WHERE file_code='".$_SESSION['download_link_temp']."'";
	$result_download_count=mysql_fetch_array(mysql_query($download_count));
	
	
	$update_count="UPDATE files_info set `file_downloads_count`='".($result_download_count['file_downloads_count']+1)."' WHERE `file_code`='".$_SESSION['download_link_temp']."';";
	mysql_query($update_count);
	mysql_close();
	
    header("Content-type: application/force-download");
    header("Content-Transfer-Encoding: Binary");
    header("Content-length: ".filesize($file));
    header("Content-disposition: attachment; filename=\"".$new_filename['file_name']."\"");
    readfile($file);	
	
}
?>