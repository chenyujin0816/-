<?php 

	$conn = @mysqli_connect("localhost","root","") or die("连接出错!");
	$selected = mysqli_select_db($conn,"regist");
?>