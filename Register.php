<?php
session_start();
if(isset($_SESSION['userSession'])!=""){
	header("Location: Home.php");
	exit;
}
	require_once 'Dbconnect.php';
	if (isset($_POST['btn-signup'])){
		$Uname = strip_tags($_POST['uname']);
		$Email = strip_tags($_POST['email']);
		if (!filter_var($Email, FILTER_VALIDATE_EMAIL) === true) {
			$msg="invalid email";
		}
		$Pass = strip_tags($_POST['pass']);
		$Mobile = strip_tags($_POST['mobile']);
		
		$Uname = $DBcon->real_escape_string($Uname);
		$Email = $DBcon->real_escape_string($Email);
		$Pass = $DBcon->real_escape_string($Pass);
		$Mobile = $DBcon->real_escape_string($Mobile);
		
		$hashed_pwd = password_hash($Pass,PASSWORD_DEFAULT);
		
		$check_email = $DBcon->query("select * from users where email='$Email'");
		
		$count = $check_email->num_rows;
		if (!preg_match("/^[a-zA-Z ]*$/",$Uname)) {
			$msg = "Only letters and white space allowed"; 
		}
		if($count==0)
		{
			$query="INSERT INTO users (email,name,password,mobile) values('$Email','$Uname','$hashed_pwd','$Mobile')";
			
			if($DBcon->query($query)){
				$msg="Success";
			}
			else{
				$msg="Error";
			}
		
		}
		else{
			$msg="Mail already exists";
		}
		$DBcon->close();
	}
	
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
        <li><a href="Home.php">Home</a></li>
        <li><a href="Signin.php">Login</a></li>
        <li><a href="Register.php">Register</a></li>
      </ul>
    </div>
</nav>
<div class="container">
<h1>Register here</h1>
<form method="post">
	<?php
		if(isset($msg)){
			echo $msg;
		}
	?>
	<div class="form-group">
		<label>Name: </label> <input type="text" name="uname" class="form-control" required>
	</div>
	<div class="form-group">
		<label>Email:  </label> <input type="text" name="email" class="form-control" > <br>
	</div>
	<div class="form-group">
		<label>Password:  </label> <input type="password" name="pass" class="form-control" required><br>
	</div>
	<div class="form-group">
		<label>Mobile:  </label> <input type="tele" name="mobile" class="form-control" required><br>
	</div>
	<button type="submit" value="Submit" class="btn btn-default" name="btn-signup"> Submit</button>
	<a href="Signin.php" class="btn btn-default" style="float:right;">Sign In</a>
</form>
</div>
</body>
</html>