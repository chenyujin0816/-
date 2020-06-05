<?php 
	error_reporting(0);
	session_start(); 
	include("conn.php");
	$target_org="CG艺术空间";
	
	if($_SESSION['is_org'])
	{
		$curorg=$_SESSION['user'];
		$applicant_no=$_SESSION['user'];
	}
	else
	{
		$curuser=$_SESSION['user'];
		$applicant_no=$_SESSION['user'];
	}
	$sql="SELECT * FROM account WHERE username='$applicant_no'";
	$sql1 = "SELECT * FROM account WHERE username = '$curuser'";
	$sql2 = "SELECT * FROM account_org WHERE org_name = '$curorg'";
	$query = mysqli_query($conn,$sql);
	$query1 = mysqli_query($conn,$sql1);
	$query2 = mysqli_query($conn,$sql2);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
	$row1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);
	$row2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
	$applicant_name = $row["name"];
	$orgpage = $row2["org_main_page"];
	$myorg=$row["org1"];
	if (isset($_POST['apply'])) 
	{
		$sql3="INSERT INTO application(applicant_no,applicant_name,target_org,status) VALUES ('$applicant_no','$applicant_name','$target_org',0)";
		mysqli_query($conn,$sql3);
		echo "<script>alert('申请已提交');history.go(-1)</script>";
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>社团学生组织招新平台</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css" type="text/css">
	<link rel="stylesheet" href="../css/cg_art_space.css" type="text/css">
</head>
<body>
	<div id="header">
		<div class="title">
			<p>社团学生组织招新平台</p>
		</div>
		<div class="search">
			<form action="search.php" method="post">
	            <input type="text" placeholder="请输入社团/学生组织名称..." name="searchContent" id="searchContent" />
	            <input type="submit" name="search" value="搜索" id="search">
            </form>
        </div>
        <div class="login">
        	<?php if($_SESSION['user'])
        	{ 
        		echo '你好，'.$_SESSION['user'];
        	?>
        	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
        	<a href="logout.php">登出</a>
        	<?php }else{ ?>
        	<a href="login.php">登录</a>
        	<a href="register.php">注册</a>
        	<?php } ?>
        </div>
	</div>
	<div class="nav">
		<ul class="menubar">
			<li class="menu-value"><a href="index.php">首页</a></li>
			<li class="" ><a href="info.php">浏览社团</a></li>
			<li class="" >
				<?php if($_SESSION['is_logged'] and $_SESSION['is_org']){ ?>
					<a href="<?php echo $orgpage ?>">我的社团</a>
				<?php }elseif($_SESSION['is_logged'] and !$_SESSION['is_org'] and isset($myorg)){ ?>
					<a href="<?php echo $myorg ?>">我的社团</a>
				<?php }else{ ?>
					<a href="mypage.php">我的社团</a>
				<?php } ?>
			</li>
			<li class="" ><a href="apply.php">申请</a></li>
		</ul>
	</div>
	<div id="content">
		<h1>CG艺术空间</h1>
		<div class="intro">
			<p>你从小可否有一个成为画家的梦？</p>
			<p>喜欢年少时的热爱漫画</p>
			<p>喜欢或热血，或浪漫的动漫</p>
			<p>喜欢绘本里的插图</p>
			<p>喜欢霓虹灯下吸引人眼球的海报</p>
			<p>.........</p>
			<p>而现在</p>
			<p>你们终于有时间 有精力 有机会 地方</p>
			<p>去追逐属于你们的梦了</p>
			<p>因为这里有CG艺术空间！</p>
		</div>
		<img src="../image/cg1.jpg">
		<img src="../image/cg2.jpg">
		<img src="../image/cg3.jpg">
		<?php  if($_SESSION['is_org']==false and !isset($myorg)) {?>
		<div id="apply">
			<form action="cg_art_space.php" method="post">
				<input type="submit" value="申请加入" name="apply">
			</form>
		</div>
		<?php } else{?>

		<?php } ?>
	</div>
</body>
</html>