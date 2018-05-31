<html>
<head>
<title>Sign Up</title>

<link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet"> 

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:400,300,600,400italic);
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
  -moz-font-smoothing: antialiased;
  -o-font-smoothing: antialiased;
  font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
}

body {
  font-family: "Roboto", Helvetica, Arial, sans-serif;
  font-weight: 100;
  font-size: 12px;
  line-height: 30px;
  color: #777;
  background:powderblue;
}

.container {
  /*max-widthpx;*/
  width: 100%;
  margin: -15 auto;
  position: relative;
}

#contact input[type="text"],
#contact input[type="email"],
#contact input[type="password"],
#contact input[type="url"],
#contact textarea,
#contact button[type="submit"] {
  font: 400 12px/16px "Roboto", Helvetica, Arial, sans-serif;
}

#contact {
  background: #F9F9F9;
  padding: 25px;
  margin: 25px 0;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

#contact h3 {
  display: block;
  font-size: 30px;
  font-weight: 300;
  margin-bottom: 10px;
  margin-top: -10px;
}

#contact h4 {
  margin: 5px 0 15px;
  display: block;
  font-size: 13px;
  font-weight: 400;
}

a:hover   {
  /* Applies to links under the pointer */
  text-decoration:  none;
}

fieldset {
  border: medium none !important;
  margin: 0 0 10px;
  min-width: 100%;
  padding: 0;
  width: 100%;
}

#contact input[type="text"],
#contact input[type="email"],
#contact input[type="password"],
#contact input[type="url"],
#contact textarea {
  width: 100%;
  border: 1px solid #ccc;
  background: #FFF;
  margin: 0 0 5px;
  padding: 10px;
}

#contact input[type="text"]:hover,
#contact input[type="email"]:hover,
#contact input[type="password"]:hover,
#contact input[type="url"]:hover,
#contact textarea:hover {
  -webkit-transition: border-color 0.3s ease-in-out;
  -moz-transition: border-color 0.3s ease-in-out;
  transition: border-color 0.3s ease-in-out;
  border: 1px solid #aaa;
}

#contact textarea {
  height: 100px;
  max-width: 100%;
  resize: none;
}

#contact button[type="submit"] {
  cursor: pointer;
  width: 100%;
  border: none;
  background: powderblue;
  color: #FFF;
  margin: 0 0 5px;
  padding: 10px;
  font-size: 15px;
}

#contact button[type="submit"]:hover {
  background: #43A047;
  -webkit-transition: background 0.3s ease-in-out;
  -moz-transition: background 0.3s ease-in-out;
  transition: background-color 0.3s ease-in-out;
}

#contact button[type="submit"]:active {
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
}

.copyright {
  text-align: center;
}

#contact input:focus,
#contact textarea:focus {
  outline: 0;
  border: 1px solid #aaa;
}

::-webkit-input-placeholder {
  color: #888;
}

:-moz-placeholder {
  color: #888;
}

::-moz-placeholder {
  color: #888;
}

:-ms-input-placeholder {
  color: #888;
}
</style>
</head>

<body>

<!--php coding-->
<?php
require_once 'C:\xampp\htdocs\swiftmailer\swiftmailer\lib\swift_required.php';
$host = "localhost";
$uname = "root";
$pass = "";
$db = "remindme";
mysql_connect($host,$uname,$pass)
	or die("Error connecting database ".mysql_error());
mysql_select_db($db)
	or die("Error selecting database ".mysql_error());

if(isset($_POST['uname']))
{
    $uname = $_POST['uname'];
    $email = $_POST['emailid'];
    $number = $_POST['number'];
    $password = $_POST['pasword'];
	if(empty($number)){
		$msg = '<span class="error"> You cannot left it empty</span>';
		echo $msg;
	}
	else if(!is_numeric($number)){
		echo "<script>alert('Enter valid contact number');window.location.replace('index.php?msg=Sign Up failed');</script>";
		$r=0;
    }
	else if(strlen($number) != 10) {
		echo "<script>alert('Enter valid contact number');window.location.replace('index.php?msg=Sign Up failed');</script>";
		$r=0;
	}
	else if(strpos($uname,'@'))
	{
		echo "<script>alert('U can not use @ into username');window.location.replace('index.php?msg=Sign Up failed');";
	}
	else if(strlen($password) <= 7)
	{
		echo "<script>alert('Password must me more than 7 characters');";
	}
	else{
		$q = "INSERT INTO `users` (`username`,`email`,`number`,`password`,`uid`) VALUES ('".$uname."','".$email."','".$number."','".$password."',DEFAULT)";
		if(mysql_query($q))
		{
			echo "<script>alert('SignUp successful');window.location.replace('index.php?msg=Sign Up successful');</script>";
			$r = 1;
		}
		else
		{
			echo "<script>alert('Username Already Exists');window.location.replace('index.php?msg=Sign Up failed');</script>";
			$r = 0;
		}
		if($r == 1)
		{
			$message = Swift_Message::newInstance();
			$message->setSubject('RemindMe');
			$message->setFrom(array('ready2help@malgadi.com' => 'RemindMe Team'));
			$message->setTo($email);
			$message->setBody('You have successfully registered with RemindMe.
We will reach you soon.
-RemindMe Team');    

			$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl');
			$transport->setUsername('ready2help.remindme@gmail.com');
			$transport->setPassword('nirav@123');
	
			$mailer = Swift_Mailer::newInstance($transport);
	
			$result = $mailer->send($message);
			
			printf("Sent %d messages.", $result);
		}
	}
}
?>
<!--coding ends-->



<!--Header-->

<div>  
<a href="#"> <h1 style="font-family: 'Raleway', sans-serif; color: #F9F9F9; margin-left:25px"><img src="http://www2.emersonprocess.com/en-US/brands/deltav/alarm/PublishingImages/DeltaV_Alarm_final_194x195.png" height="50px" width="50px">
RemindMe</h1></a>

</div>

<!-- Form Starts-->
<div class="container"> 
<div class="row">


<div class="col-sm-1"></div>

<div class="col-sm-4">
  <form id="contact" method="post" action="login2.php">
    <h3>Login</h3>
    <h4>If you have already registered with us</h4>
    <fieldset>
        <input style="display:none" type="text" name="fakeusernameremembered"/>
    </fieldset>
    <fieldset>
        <input style="display:none" type="password" name="fakepasswordremembered"/>
    </fieldset>
    <fieldset>
      <input placeholder="User name" type="text" style="color: black" tabindex="1" name="uname" required autofocus>
    </fieldset>
      <input placeholder="Password" type="password" style="color: black" tabindex="2" name="pasword" required>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Login</button>
    </fieldset>
    <p class="copyright">&#169; copyright 2017 <a href="#"  title="RemindMe">RemindMe</a></p>
  </form>
</div>

<div class="col-sm-1"><br><br><br><br><br><br><h2 style="color:#F9F9F9;">OR</h2>
</div>

<div class="col-sm-5">
  <form id="contact" method="post" action="index.php">
    <h3>Sign Up</h3>
    <h4>register your account</h4>
    <fieldset>
        <input style="display:none" type="text" name="fakeusernameremembered"/>
    </fieldset>
    <fieldset>
        <input style="display:none" type="password" name="fakepasswordremembered"/>
    </fieldset>
    <fieldset>
      <input placeholder="User name" type="text" style="color: black" tabindex="1" name="uname" required autofocus>
    </fieldset>
    <fieldset>
      <input placeholder="Email" type="email" style="color: black" tabindex="2" name="emailid" required>
    </fieldset>
    <fieldset>
      <input placeholder="Password" type="password" style="color: black" tabindex="3" name="pasword" required>
    </fieldset>
    <fieldset>
      <input placeholder="Contact Number" type="text" style="color: black" tabindex="4" name="number" required>
    </fieldset>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Sign Up</button>
    </fieldset>
    <p class="copyright">&#169; copyright 2017 <a href="#"  title="RemindMe">RemindMe</a></p>
  </form>
</div>
<div class="col-sm-1"></div>
</div>
</div>
<!-- Form Ends-->
</body>
</html>