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
	
	if(isset($_POST['title']))
	{
		$title=$_POST['title'];
		$description=$_POST['description'];
		$Adate=$_POST['date'];
		$Atime = $_POST['time'];
		$time = date('h:ia', strtotime($Atime));
		$q ="UPDATE `reminders` SET `title`='".$title."',`description`='".$description."',`date`='".$Adate."',`time`='".$time."' WHERE rid=".$_POST['rid']; 
		if(mysql_query($q))
		{
			echo "<script>alert('Edit Sucessfull');window.location.replace('mysite.php');</script>";
		}
		else
		{
			echo "<script>alert('Edit failed');window.location.replace('mysite.php');</script>";
		}
	}
?>