<?php
	session_start();
	if(isset($_SESSION['userSession'])!=""){
		header("Location :Home.php");
	}
	require_once 'Dbconnect.php';
	
	if(isset($_POST['btn-signin'])){
		$email=strip_tags($_POST['email']);
		$password=strip_tags($_POST['password']);
		
		$email = $DBcon->real_escape_string($email);
		$password = $DBcon->real_escape_string($password);
		
		$hashed_pwd=password_hash($password,PASSWORD_DEFAULT);
		
		$query=$DBcon->query("select id,email,password from users where email='$email'");
		
		$count = $query->num_rows;
		
		$row=$query->fetch_array();

		if(password_verify($password,$row['password']) && $count==1){
			$_SESSION['userSession']=row['id'];
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
					echo $msg;
				}
		?>
		<div class="form-group">
			<label>Email:</label> <input type="email" class="form-control" name="email" placeholder="Enter email" required>
		</div>
		<div class="form-group">
		<label>Password: </label><input type="password" class="form-control" name="password" required><br>
		<div class="checkbox">
		<label><input type="checkbox">Remember Me</label>
		</div>
		<button type="submit" class="btn btn-default" name="btn-signin">Submit</button>
		<a href="Register.php" class="btn btn-default" style="float:right;">Sign Up </a>
	</form>
</div>
</body>
</html>