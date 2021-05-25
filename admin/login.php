<?php
	require 'db/config.php';

	if(isset($_POST['login'])) {
		$errMsg = '';

		// Get data from FORM
		$u_name = $_POST['u_name'];
		$u_password = $_POST['u_password'];

		if($u_name == '')
			$errMsg = 'Enter username';
		if($u_password == '')
			$errMsg = 'Enter password';

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT u_id, u_email, u_name, u_password FROM user WHERE u_name = :u_name');
				$stmt->execute(array(
					':u_name' => $u_name
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "User $u_name not found.";
				}
				else {

		
					if(password_verify(hash('sha512', $u_password), $data['u_password'])) {
						$_SESSION['u_id'] = $data['u_id'];
						$_SESSION['u_email'] = $data['u_email'];
						$_SESSION['u_name'] = $data['u_name'];
						$_SESSION['u_password'] = $data['u_password'];

						header('Location: dashboard.php');
						exit;
					}
					else
						$errMsg = 'Password not match.';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
</head>
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
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Login</b></div>
			<div style="margin: 15px">
				<form action="" method="post">
					<input type="text" name="u_name" value="<?php if(isset($_POST['u_name'])) echo $_POST['u_name'] ?>" autocomplete="on" class="box"/><br /><br />
					<input type="password" name="u_password" value="<?php if(isset($_POST['u_password'])) echo $_POST['u_password'] ?>" autocomplete="off" class="box" /><br/><br />
					<input type="submit" name='login' value="Login" class='submit'/><br />
				</form>
			</div>
		</div>
	</div>
</body>
</html>
