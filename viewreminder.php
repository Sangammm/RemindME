<?php
@session_start();
if(!isset($_SESSION['id'])) 
{
header("location:index.php");
}
?>

<?php
//echo "at right page";
$aid = $_SESSION['id']['uid'];
if(isset($_POST['rid']))
{
	$rid=$_POST['rid'];
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
}

?> 
