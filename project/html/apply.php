<?php 
	error_reporting(0);
	session_start(); 
	include("conn.php");
	if($_SESSION['is_org'])
	{
		$curorg=$_SESSION['user'];
	}
	else
	{
		$curuser=$_SESSION['user'];
	}
	$sql1 = "SELECT * FROM account WHERE username = '$curuser'";
	$sql2 = "SELECT * FROM account_org WHERE org_name = '$curorg'";
	$query1 = mysqli_query($conn,$sql1);
	$query2 = mysqli_query($conn,$sql2);
	$row1 = mysqli_fetch_array($query1,MYSQLI_ASSOC);
	$row2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
	$orgpage = $row2["org_main_page"];
	$myorg = $row1["org1"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>社团学生组织招新平台</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/main.css" type="text/css">
	<link rel="stylesheet" href="../css/apply.css" type="text/css">
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
		<div id="apply">
			<?php 
				if (!$_SESSION['is_logged']) {
				 	echo "<h2>请先登录！</h2>";
				} 
				elseif ($_SESSION['is_org']) 
				{	
					$applyno=1;
					$sql = "SELECT * FROM application WHERE target_org = '$curorg' AND status = 0 ";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) 
					{
					    while($row = $result->fetch_assoc()) 
					    {
					    	$applicant_no=$row["applicant_no"];
					        echo "申请编号".
					        	$applyno.
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;申请人学号：".
					        	$row["applicant_no"].
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;申请人姓名：".
					        	$row["applicant_name"].
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						        <form action='apply.php' method='post'>
						        	<div class='type' style='display: none'>
										<input type='radio' name='appno' value='$applicant_no' checked>
									</div>
						        	<input type='submit' name='agree' id='button' value='同意'>&nbsp;&nbsp;&nbsp;&nbsp;
						        	<input type='submit' name='reject' id='button' value='拒绝'>
						        </form>".
						        "<br><br>";
					        $applyno++;  
					    }
					} 
					else 
					{
					    echo "<h2>目前没有申请</h2>";
					}
					$curno=$_POST['appno'];
					if (isset($_POST['agree'])) 
					{
						$sql= "UPDATE application SET status=1 WHERE applicant_no='$curno' AND target_org='$curorg'";
						mysqli_query($conn,$sql);
						$sql3="UPDATE account SET org1='$orgpage' WHERE username='$curno'";
						mysqli_query($conn,$sql3);
						header("location:apply.php");
					}
					if (isset($_POST['reject']))
					{
						$sql= "UPDATE application SET status=2 WHERE applicant_no='$curno' AND target_org='$curorg'";
						mysqli_query($conn,$sql);
						header("location:apply.php");
					}
					
				}
				else
				{
					$curuser=$_SESSION['user'];
					$applyno=1;
					$sql="SELECT * FROM application WHERE applicant_no=$curuser;";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) 
					{
					    while($row = $result->fetch_assoc()) 
					    {
					    	$applicant_no=$row["applicant_no"];
					        echo "申请编号".
					        	$applyno.
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;申请人学号：".
					        	$row["applicant_no"].
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;申请人姓名：".
					        	$row["applicant_name"].
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;申请社团：".
					        	$row["target_org"].
					        	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					        if ($row['status']==0) {
					        	echo "待处理"."<br><br>";
					        }
					        elseif ($row['status']==1) {
					        	echo "申请已通过"."<br><br>";
					        }
					        else{
					        	echo "申请被拒绝"."<br><br>";
					        }
					        $applyno++;  
					    }
					} 
					else 
					{
					    echo "<h2>目前没有申请</h2>";
					}
				}
			?>
		</div>
	</div>
</body>
</html>