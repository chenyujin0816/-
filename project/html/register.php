<?php 
	session_start();
	include("conn.php");
	$username = isset($_POST['username'])?$_POST['username']:'';
	$name = isset($_POST['name'])?$_POST['name']:'';
	$password1 = isset($_POST['password1'])?$_POST['password1']:'';
	$password2 = isset($_POST['password2'])?$_POST['password2']:'';
	$usertype =  isset($_POST['usertype'])?$_POST['usertype']:'';
	$orgname = isset($_POST['orgname'])?$_POST['orgname']:'';
	$mainpage = isset($_POST['mainpage'])?$_POST['mainpage']:'';
	if (isset($_POST['register'])) 
	{
		if($password1==$password2)
		{
			if($usertype==0)
			{
				$sql="INSERT INTO account(username,password,usertype,name) VALUES ('$username','$password2','$usertype','$name')";
			}
			else
			{
				$sql="INSERT INTO account_org(org_name,password,usertype,org_main_page) VALUES ('$orgname','$password2','$usertype','$mainpage')";
			}
			mysqli_query($conn,$sql);
			echo "<script>alert('注册成功');window.location='register.php';</script>";
		}
		else
			echo "<script>alert('两次密码不一致');window.location='register.php';</script>";
	}


 ?>


<!DOCTYPE html>
<html>
<head>
	<title>社团学生组织招新平台</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css" type="text/css">
	<link rel="stylesheet" href="../css/register.css" type="text/css">
</head>
<body>
	<div id="header">
		<div class="title">
			<p>社团学生组织招新平台</p>
		</div>
	</div>
	<div class="nav">
		<ul class="menubar">
			<li class="menu-value"><a href="index.php">首页</a></li>
			<li class="" ><a href="../html/info.php">浏览社团</a></li>
			<li class="" ><a href="../html/mypage.php">我的社团</a></li>
			<li class="" ><a href="../html/apply.php">申请</a></li>
		</ul>
	</div>
	<div class="window">
		<div class="content">
			<div class="register">
				<h3>注册</h3>
				<div class="choosetype">
					<span>用户类别</span>
					<input name=ut value="0" type=radio onclick="form1.style.display='';form2.style.display='none';" checked>普通学生
					<input name=ut value="1" type=radio onclick="form1.style.display='none';form2.style.display='';">社长/组织负责人
				</div>
				<div id="form1">
					<form action="register.php" method="post">
						<div class="type" style="display: none">
							<input type="radio" name="usertype" value="0" checked>
						</div>
						<div class="username">
							<span>学号</span>
							<input type="text" name="username" placeholder="学号">
						</div>
						<div class="name">
							<span>姓名</span>
							<input type="text" name="name" placeholder="姓名">
						</div>
						<div class="password">
							<span>设置密码</span>
							<input type="password" name="password1" placeholder="密码">
						</div>
						<div class="pwd">
							<span>确认密码</span>
							<input type="password" name="password2" placeholder="确认密码">
						</div>
						<span class="on"><a href="login.php">去登录</a></span>
						<br>
						<input type="submit" value="注册" name="register">
					</form>
				</div>
				<div id="form2" style="display:none">
					<form action="register.php" method="post">
						<div class="type" style="display: none">
							<input type="radio" name="usertype" value="1" checked>
						</div>
						<div class="name">
							<span>社团/组织名</span>
							<input type="text" name="orgname" placeholder="名称">
						</div>
						<div class="password">
							<span>设置密码</span>
							<input type="password" name="password1" placeholder="密码">
						</div>
						<div class="pwd">
							<span>确认密码</span>
							<input type="password" name="password2" placeholder="确认密码">
						</div>
						<div class="main_page">
							<span>社团/组织主页地址</span>
							<input type="text" name="mainpage" placeholder="主页地址">
						</div>
						<span class="on"><a href="login.php">去登录</a></span>
						<br>
						<input type="submit" value="注册" name="register">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>