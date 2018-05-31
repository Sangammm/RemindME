<html>
<?php
@session_start();

if(!isset($_SESSION['id'])) 
{
header("location:index.php");
}
?>
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
$host = "localhost";
$uname = "root";
$pass = "";
$db = "remindme";
mysql_connect($host,$uname,$pass)
	or die("Error connecting database ".mysql_error());
mysql_select_db($db)
	or die("Error selecting database ".mysql_error());
	
	if(isset($_POST['rid']))
	{
		
		$query1="select * from reminders where rid=".$_POST['rid'];
		$rid=$_POST['rid'];
		if($result=mysql_query($query1))
		{
			$data = mysql_fetch_assoc($result);
			$t = $data['time'];
			if($t[5]=="p")
			{
	
				$hour=($t[0]*10)+($t[1])+12;
				$minute=($t[3]*10)+($t[4]);
			}
			else
			{
				$hour=($t[0]*10)+($t[1]);
				$minute=($t[3]*10)+($t[4]);
			}
			if($hour<10)
			{
				$hour="0".$hour;
			}
			if($minute<10)
			{
				$minute = "0".$minute;
			}
			$time=$hour.":".$minute;
			echo "<fieldset>
			<form method=post action=editreminder2.php>
			Title:
			<br>
			<input type=text name=title required value=".$data['title'].">
			<br><br>
			Description:
			<br>
			<textarea name=description rows=8 cols=35>".$data['description']."</textarea>
			<br><br>
			</fieldset>
			<fieldset>
			Date:
			<br>
			<input type=date name=date required value=".$data['date']." ><br>
			<br>
			Time:
			<br>
			<input type=time name=time required value=".$time.">
			<input type=text name=rid value=" .$rid." hidden><br><br>
			<button type=submit>Edit</button>";
		}
		else
		{
			echo "php error";
		}
	}
?>
</body>
</html>