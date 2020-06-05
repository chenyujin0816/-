<?php 
	error_reporting(0);
	session_start();
	include("conn.php");

	$postUsername = isset($_POST['username'])?$_POST['username']:'';
	$postPassword = isset($_POST['password'])?$_POST['password']:'';
	$postUsertype = isset($_POST['usertype'])?$_POST['usertype']:'';
	$postOrgname = isset($_POST['orgname'])?$_POST['orgname']:'';
	
	if (isset($_POST['login'])) 
	{
		if ($postUsertype==0) {
			$sql = "SELECT username,password,usertype FROM account WHERE username = '$postUsername'";
			$query = mysqli_query($conn,$sql);
			$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
			$username = $row["username"];
			$password = $row["password"];
			$usertype = $row["usertype"];
		}
		else{
			$sql = "SELECT org_name,password,usertype FROM account_org WHERE org_name = '$postOrgname'";
			$query = mysqli_query($conn,$sql);
			$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
			$orgname = $row["org_name"];
			$password = $row["password"];
			$usertype = $row["usertype"];
		}
		if($password != $postPassword)
			echo "<script>alert('用户名或密码错误');history.go(-1)</script>";
		else if($postUsertype != $usertype)
		{
			echo "<script>alert('用户类别错误');history.go(-1)</script>";
			
		}
		else if ($password == $postPassword && $postUsertype==$usertype) 
		{
			if($usertype==0)
			{
				$_SESSION['user']=$username;
				$_SESSION['is_org']=false;
			}
			else
			{
				$_SESSION['user']=$orgname;
				$_SESSION['is_org']=true;
			}
			$_SESSION['is_logged']=true;
			echo "<script>alert('登录成功');history.go(-1)</script>";
			header("location:index.php");
		}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>社团学生组织招新平台</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css" type="text/css">
	<link rel="stylesheet" href="../css/login.css" type="text/css">
</head>
<body>
<?php if(!$_SESSION['user']){ ?>
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
			<div class="login">
				<h3>登录</h3>
				<div class="choosetype">
					<span>用户类别</span>
					<input name=ut value="0" type=radio onclick="form1.style.display='';form2.style.display='none';" checked>普通学生
					<input name=ut value="1" type=radio onclick="form1.style.display='none';form2.style.display='';">社长/组织负责人
				</div>
				<div id="form1">
					<form action="login.php" method="post">
						<div class="type" style="display: none">
							<input type="radio" name="usertype" value="0" checked>
						</div>
						<div class="username">
							<span>学号</span>
							<input type="text" name="username" placeholder="学号">
						</div>
						<div class="password">
							<span>密码</span>
							<input type="password" name="password" placeholder="密码">
						</div>
						<span class="on"><a href="register.php">去注册</a></span>
						<br>
						<input type="submit" value="登录" name="login">
					</form>
				</div>
				<div id="form2" style="display:none">
					<form action="login.php" method="post">
						<div class="type" style="display: none">
							<input type="radio" name="usertype" value="1" checked>
						</div>
						<div class="name">
							<span>社团/组织名</span>
							<input type="text" name="orgname" placeholder="名称">
						</div>
						<div class="password">
							<span>密码</span>
							<input type="password" name="password" placeholder="密码">
						</div>
						<span class="on"><a href="register.php">去注册</a></span>
						<br>
						<input type="submit" value="登录" name="login">
					</form>
				</div>
			</div>
		</div>
	</div>
<?php }else{ ?>
	<h1><?php echo $_SESSION['user'].'已经登录'; ?></h1>
	<a href="logout.php">登出</a>
	<br>
	<a href="index.php">返回主页</a>
<?php } ?>
</body>
</html>
