<html>
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

	$aid = $_SESSION['id']['uid'];
if(isset($_POST['rid']))
{
	$rid=$_POST['rid'];
	$_SESSION['srid']=$rid;
}
echo $_SESSION['srid'];
?>

<body>
<a href="mysite.php">Home</a>
<form method="post" action="share3.php">
<input type="text" name="info" required />
<br>
<button type="submit">Share</button>
</form>
</body>
</html>