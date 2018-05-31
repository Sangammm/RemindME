<html>
<head>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<a href="mysite.php">Home</a>
<?php
@session_start();
if(!isset($_SESSION['id'])) 
{
header("location:index.php");
}
?>
<?php
$host = "localhost";
$uname = "root";
$pass = "";
$db = "remindme";
mysql_connect($host,$uname,$pass)
	or die("Error connecting database ".mysql_error());
mysql_select_db($db)
	or die("Error selecting database ".mysql_error());
	$rid = $_SESSION['srid'];
	$aid = $_SESSION['id']['uid'];
	if(isset($_POST['info']))
	{
		$info=$_POST['info'];
		$array = explode(";",$info);
		foreach($array as $key => $value)
		{
			$n = $key;
			if(strpos($array[$n],'@'))
			{
				$query = 'SELECT `uid` FROM `users` WHERE `email`="'.$array[$n].'"';
				$cheak = mysql_num_rows(mysql_query($query));
				if($cheak != 0)
				{
					$arrayid = mysql_fetch_assoc(mysql_query($query));
					$userid = $arrayid['uid'];
					$query2 = "INSERT INTO `share`(`uid`, `rid`) VALUES ('".$userid."','".$rid."')";
					if(mysql_query($query2))
					{
					}
				}
				else
				{
					echo "<br>".$array[$n]." is not registered on our site plz cheak your mail address";
					echo '<script type="text/javascript">alert("'.$array[$n].'" is not registered on our site plz cheak your mail address</script>';
				}
			}
			else if(is_numeric($array[$n]))
			{
				if(strlen($array[$n]) == 10)
				{
					$query = 'SELECT `uid` FROM `users` WHERE `number`="'.$array[$n].'"';
					$cheak = mysql_num_rows(mysql_query($query));
					echo $cheak;
					if($cheak != 0)
					{
						$arrayid = mysql_fetch_assoc(mysql_query($query));
						$userid = $arrayid['uid'];
						if(mysql_query("INSERT INTO `share`(`uid`, `rid`) VALUES ('".$userid."','".$rid."')"))
						{
						}
					}
					else
					{
						echo "<br>".$array[$n]." is not registered on our site plz cheak your number";
						echo '<script>alert('.$array[$n].' is not registered on our site plz cheak your number)</script>';
					}
				}
			}	
			else
			{
				$query = 'SELECT `uid` FROM `users` WHERE `username`="'.$array[$n].'"';
				$cheak = mysql_num_rows(mysql_query($query));
				if($cheak != 0)
				{
					$arrayid = mysql_fetch_assoc(mysql_query($query));
					$userid = $arrayid['uid'];
					if(mysql_query("INSERT INTO `share`(`uid`, `rid`) VALUES ('".$userid."','".$rid."')"))
					{
					}
					else
					{
					}
				}
				else
				{
					echo "<br>".$array[$n]." is not registered on our site plz cheak!!";
					echo "<script>alert(".$array[$n]." is not registered on our site plz cheak!!);window.location.replace('index.php?msg=Sign Up successful');</script>";
				}
			}
			//echo "<script>window.location.replace('mysite.php');</script>";
		}
	}
	unset($_SESSION['srid']);
?>
</body>
</html>