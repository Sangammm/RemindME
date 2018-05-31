<html>
<head>
<title>RemindME</title>
<style>
body{
	font-size:19px;
	background-color:powderblue;
}
table, th, td {
   border: 1px solid black;
   border-collapse:collapse;
   padding:5px;
}

</style>

<body>
<a href="reminder.php">Create reminder</a>
<br><br>
<a href="logout.php">Log out</a>

<?php
@session_start();
if(!isset($_SESSION['id'])) {
header("location:index.php");
}

$host = "localhost";
$uname = "root";
$pass = "";
$db = "remindme";
mysql_connect($host,$uname,$pass)
	or die("Error connecting database ".mysql_error());
mysql_select_db($db)
	or die("Error selecting database ".mysql_error());

$aid = $_SESSION['id']['uid']; 
//echo $aid;
$query = "select * from reminders where uid=$aid";
$result = mysql_query($query);
echo "<pre>"; 
while($row = mysql_fetch_assoc($result))
{
    echo "<fieldset><table><tr><td>" . "Title:" . $row["title"] . "</td>" . "<td>" . "Description:" . $row["description"] .  "</td></tr>" . "<tr><td>Date:" . $row["date"] ."</td><td>Time". $row["time"]  . "</tr>"  . "</table><br>";
	echo "<form action=share2.php method=post><input type=text name=rid value=" . $row["rid"] . " hidden>";
	echo "<button type=submit>Share</button></form>";
	
	echo "<form action=editreminder.php method=post><input type=text name=rid value=" . $row["rid"] . " hidden>";
	echo "<button type=submit>Edit</button></form>";
	
	echo "<form action=delete.php method=post><input type=text name=rid value=" . $row["rid"] . " hidden>";
	echo "<button type=submit>Delete</button></form>";
	//shows files shared with reminder
	$rid=$row['rid'];
	if(!is_dir("../files/".$aid."/".$rid))
	{
		echo "<script>error('NOt any file shared with this reminder');</script>";
	}
	else
	{	
		$dir = opendir("../files/".$aid."/".$rid);
		while (($file = readdir($dir)))
		{
			if(!($file=="." || $file==".."))
			{
			echo "<a href='../files/$aid/$rid/$file' > $file </a>" . "<br/>";
			}
		}
		closedir($dir);
	}
	echo"</fieldset>";
}
echo "</pre>";
?>

<?php
echo "Shared with you<br>";
$query1 = "select rid from share where uid=$aid";
$out1 = mysql_query($query1);

while($value = mysql_fetch_assoc($out1))
{
	echo "<fieldset>";
	//To get userid who is admin of that reminder.
	$queryusername = "select uid from reminders where rid=$value[rid]";
	$outuser = mysql_query($queryusername);
	$userid = mysql_fetch_assoc($outuser);
	//To extract username of that userid
	$querygetusername = "select username from users where uid=$userid[uid]";
	$outusername =  mysql_query($querygetusername);
	$user = mysql_fetch_assoc($outusername);
	echo "<br><h4>".$user['username'].":</h4>";
	$query = "select * from reminders where rid=$value[rid]";
	$result = mysql_query($query); 
	$row = mysql_fetch_assoc($result);
	echo "<table><tr><td>" . "Title:" . $row["title"] . "</td>" . "<td>" . "Description:" . $row["description"] .  "</td></tr>" . "<tr><td>Date:" . $row["date"] ."</td><td>Time". $row["time"]  . "</tr>"  . "</table><br>";
	//echo "<form action=share2.php method=post><input type=text name=rid value=" . $row["rid"] . " >";
	//echo "<button type=submit>Share</button></form>";
	$rid=$value["rid"];
	$aid=$userid['uid'];
	//echo "../files/".$aid."/".$rid;
	if(!is_dir("../files/".$aid."/".$rid))
	{
		echo '<script>error("NOt any file shared with this reminder");</script>';
		echo "No any file";
	}
	else
	{
		$dir = opendir("../files/".$aid."/".$rid);
		while (($file = readdir($dir)))
		{
			if(!($file=="." || $file==".."))
			{
			echo "<a href='../files/$aid/$rid/$file' > $file </a>" . "<br/>";
			}
		}
		closedir($dir);
	}
	echo"</fieldset>";
	echo "</fieldset>";
}

?>
</body>
</head>
</html>