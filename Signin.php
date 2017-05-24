<?php
	session_start();
	if(isset($_SESSION['userSession'])!=""){
		header("Location: Home.php");
		exit;
	}
	else if(isset($_COOKIE['username']))
	{
		header("Location: Home.php");
	}
	if((isset($_COOKIE['user']) && $_COOKIE['user'] != '') || (isset($_SESSION['user']) && $_SESSION['user'] !='')){
	header("Location: http://domain.com/home.php");
	}
	require_once 'Dbconnect.php';
	
	if(isset($_POST['btn-signin'])){
		$email=strip_tags($_POST['email']);
		$password=strip_tags($_POST['password']);
		if(isset($_POST['remeber'])){	
			$remember=strip_tags($_POST['remember']);
		}
		$email = $DBcon->real_escape_string($email);
		$password = $DBcon->real_escape_string($password);
		
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$msg="Enter valid email";
		}
		else if(strlen($password)<6){
			$msg="Password alteast 6";
		}
		
		$query=$DBcon->query("select id,email,password from users where email='$email'");
		
		$count = $query->num_rows;
		$expiry = time() + (86400 * 30);

		$row=$query->fetch_array();

		if(password_verify($password,$row['password']) && $count==1){
			if($remember=='true'){
				setcookie ("member_login",$_POST["email"],time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("member_password",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));			}
			else{
				$_SESSION['userSession']=row['id'];
			}
			header("Location: Home.php");
			$msg="Success";
		}
		else{
			$msg="Error";
		}

		}
		$DBcon->close();
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
<h1>Sign in</h1> &nbsp;
	<form method="post">
		<?php
				if(isset($msg)){	
				?>
					<div class="alert alert-warning">
				<?php
					echo $msg;
				?>
					</div>
				<?php
				}
		?>
		<div class="form-group">
			<label>Email:</label> <input type="email" class="form-control" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" name="email" placeholder="Enter email" required>
		</div>
		<div class="form-group">
		<label>Password: </label><input type="password" class="form-control" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" name="password" required><br>
		<div class="checkbox">
		<label><input type="checkbox" name="remember" value="1">Remember Me</label>
		</div>
		<button type="submit" class="btn btn-default" name="btn-signin">Submit</button>
		<a href="Register.php" class="btn btn-default" style="float:right;">Sign Up </a>
	</form>
</div>
</body>
</html>