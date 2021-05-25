<?php
	require 'db/config.php';

	if(isset($_POST['register'])) {
		$errMsg = '';

		// Get data from FROM
		$u_name = $_POST['u_name'];
		$u_email = $_POST['u_email'];
		$u_password = $_POST['u_password'];


		if($u_name == '')
			$errMsg = 'Enter your username';
		if($u_email == '')
			$errMsg = 'Enter your email';
		if($u_password == '')
			$errMsg = 'Enter password';

		if($errMsg == ''){
			$u_password = trim($_POST["u_password"]);
			$hashed = password_hash(hash('sha512', $u_password), PASSWORD_DEFAULT);
			try {
				$stmt = $connect->prepare('INSERT INTO user (u_name, u_email, u_password) VALUES (:u_name, :u_email, :u_password)');
				$stmt->execute(array(
					':u_name' => $u_name,
					':u_email' => $u_email,
					':u_password' => $hashed
					));
				header('Location: register.php?action=joined');
				exit;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'joined') {
		$errMsg = 'Registration successfull. Now you can <a href="login.php">login</a>';
	}
?>

<html>
<head><title>Register</title></head>
	<style>
	html, body {
		margin: 1px;
		border: 0;
	}
	</style>
<body>
	<div align="center">
		<div style=" border: solid 1px #006D9C; " align="left">
			<?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Register</b></div>
			<div style="margin: 15px">
				<form action="" method="post">
					<input type="text" name="u_name" placeholder="Username" value="<?php if(isset($_POST['u_name'])) echo $_POST['u_name'] ?>" autocomplete="off" class="box"/><br /><br />
					<input type="text" name="u_email" placeholder="Email" value="<?php if(isset($_POST['u_email'])) echo $_POST['u_email'] ?>" autocomplete="off" class="box"/><br /><br />
					<input type="password" name="u_password" placeholder="Password" value="<?php if(isset($_POST['u_password'])) echo $_POST['u_password'] ?>" class="box" /><br/><br />
					<input type="submit" name='register' value="Register" class='submit'/><br />
				</form>
			</div>
		</div>
	</div>
</body>
</html>
