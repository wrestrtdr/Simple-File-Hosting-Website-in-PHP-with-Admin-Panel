<?php
error_reporting(5);
	$conn=mysql_connect("localhost","root","");
	if(!$conn)
		$_SESSION['msg']="1";
	else
		if(!mysql_select_db("filehost", $conn))
			$_SESSION['msg']="2";
	else
		$_SESSION['msg']=0;

?>