<?php
@session_start();
if(!isset($_SESSION['id'])) 
{
header("location:index.php");
}
?>
<html>
<head>
<style>
body{
	font-size:19px;
	background-color:powderblue;
}
</style>
</head>
<body>
<?php
require_once 'C:\xampp\htdocs\swiftmailer\swiftmailer\lib\swift_required.php';
$host = "localhost";
$uname = "root";
$pass = "";
$db = "remindme";
$conn=mysqli_connect($host,$uname,$pass,$db);
if(!$conn){
	die("Error connecting database ".mysql_error());
}
$aid = $_SESSION['id']['uid'];
if(isset($_POST['title']))
{
	$title=$_POST['title'];
	$description=$_POST['description'];
	$Adate=$_POST['date'];
	$Atime = $_POST['time'];
	//$share = $_POST['share'];
	$time = date('h:ia', strtotime($Atime));
		$q = "INSERT INTO `reminders` (`title`,`description`,`date`,`time`,`uid`,`rid`,`created`) VALUES ('".$title."','".$description."','".$Adate."','".$time."','".$aid."',DEFAULT,DEFAULT)";
		if(mysqli_query($conn,$q))
		{
			$last_id = mysqli_insert_id($conn);
			//echo "Reminderid=".$last_id;
		}
		else
		{
			echo "<script>Error into adding reminder</script>";
		}
		


	//new code added hear
	$host = "localhost";
	$uname = "root";
	$pass = "";
	$db = "remindme";
	mysql_connect($host,$uname,$pass)
		or die("Error connecting database ".mysql_error());
	mysql_select_db($db)
		or die("Error selecting database ".mysql_error());
	$rid = $last_id;
	
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
						echo "<br>".$array[$n]."Sucessfully shared";
					}
				}
				else
				{
					echo "<br>".$array[$n]." is not registered on our site plz cheak your mail address";
					echo '<script>alert('.$array[$n].'is not registered on our site plz cheak your mail address);</script>';
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
							echo "<br>".$array[$n]."Sucessfully shared";
						}
					}
					else
					{
						echo "<br>".$array[$n]." is not registered on our site plz cheak your number";
						echo '<script>alert('.$array[$n].' is not registered on our site plz cheak your number);</script>';
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
						echo "<br>".$array[$n]."Sucessfully shared";
					}
				}
				else
				{
					echo "<br>".$array[$n]." is not registered on our site plz cheak!!";
					echo "<script>alert(".$array[$n]." is not registered on our site plz cheak!!);window.location.replace('index.php?msg=Sign Up successful');</script>";
				}
			}
		}
	}
	$size = count(array_filter($_FILES['file']['name']));
	echo "<br>file is:".$size;
	//print_r($_FILES['file']['name']);
	for($i=0;$i<$size;$i++)
	{
		$file = $_FILES['file']['tmp_name'][$i];
		if(mime_content_type($file)=='application/x-dosexec')
		{
			echo "U can not upload exe file";
		}
		else
		{
			if(!is_dir("../files/".$aid))
			{
				mkdir("../files/".$aid);
				if(!is_dir("../files/".$aid."/".$rid))
				{
					mkdir("../files/".$aid."/".$rid);
					copy($_FILES['file']['tmp_name'][$i],"../files/".$aid."/".$rid."/".$_FILES['file']['name'][$i]);
				}
				else
				{
					copy($_FILES['file']['tmp_name'][$i],"../files/".$aid."/".$rid."/".$_FILES['file']['name'][$i]);
				}
			}
			else
			{
				if(!is_dir("../files/".$aid."/".$rid))
				{
					mkdir("../files/".$aid."/".$rid);
					copy($_FILES['file']['tmp_name'][$i],"../files/".$aid."/".$rid."/".$_FILES['file']['name'][$i]);
				}
				else
				{
					copy($_FILES['file']['tmp_name'][$i],"../files/".$aid."/".$rid."/".$_FILES['file']['name'][$i]);
				}
			}
		}
	}
	
	
}
?>



<fieldset>
<h1><center> Create Reminder</center></h1>
</fieldset>
<form method="post" action="reminder.php" enctype="multipart/form-data">
<fieldset>
Title:
<br>
<input type="text" name="title" required>
<br><br>
Description:
<br>
<textarea name="description" rows="8" cols="35"></textarea>
<br><br>
</fieldset>
<fieldset>
Date:
<br>
<input type="date" name="date" required><br>
<br>
Time:
<br>
<input type="time" name="time" required>
<br><br>
File:<br>
<input type="file" name="file[]" multiple="multiple" />
<br><br>

Share:<br>
<input type="text" name=info>
<br><br>

<button name="Create" type="submit">Create</button>

</form>
<br><br>
<a href="mysite.php">back</a>
</fieldset>
</body>
</html>