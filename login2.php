<?php
$host = "localhost";
$uname = "root";
$pass = "";
$db = "Remindme";
mysql_connect($host,$uname,$pass)
	or die("Error connecting database ".mysql_error());
mysql_select_db($db)
	or die("Error selecting database ".mysql_error());
	
$uname = $_POST['uname'];
$password = $_POST['pasword'];


$q = "SELECT password FROM users WHERE username = '".$_POST['uname']."' ";
$w = "SELECT uid FROM users WHERE username = '".$_POST['uname']."'";
$r = mysql_query($q);
$pwd = mysql_fetch_assoc($r);
$password2 = $pwd['password']; 
$e = mysql_query($w);
$id = mysql_fetch_assoc($e);
if($password == $password2)
{
	session_start();
	$_SESSION["id"]=$id;
    die(header("location:mysite.php")); 
}
else
{
    echo "<script>alert('Invalid Username/password');window.location.replace('index.php?msg=Login failed');</script>";
    }
?>