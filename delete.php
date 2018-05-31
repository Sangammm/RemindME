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
$db = "Remindme";
mysql_connect($host,$uname,$pass)
	or die("Error connecting database ".mysql_error());
mysql_select_db($db)
	or die("Error selecting database ".mysql_error());
	
	$aid = $_SESSION['id']['uid'];
	if(isset($_POST['rid'])){
		$rid=$_POST['rid'];
		$q1 = "delete from reminders where rid =".$rid;
		$q2 = "delete from share where rid =".$rid;
		if(mysql_query($q1) && mysql_query($q2))
		{
			if(is_dir("../files/".$aid."/".$rid)){
				unlink("../files/".$aid."/".$rid);
			}
			echo "<script>alert('Deleted Sucessfully');window.location.replace('mysite.php');</script>";
		}
		else
		{
			echo "<script>alert('Not deleted plz try again');window.location.replace('mysite.php');</script>";
		}
	}
?>