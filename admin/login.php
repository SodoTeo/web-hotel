
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

				

</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' rel='stylesheet'>
        <link href='css/form.css' rel='stylesheet'>
        <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
        <script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'></script>
        <script type='text/javascript'></script> 
        <title>Sign in</title>
    </head>
    <body>
        <div id="booking" class="section">
            <div class="section-center">
                <div class="container">
                    <div class="row">
                        <div class="booking-form">
                            <div class="form-header">
                                <h1>Sign in</h1>
                            </div>
                            <form action="" method="post">
                                <div class="form-group">
                                    <input class="form-control" name="u_name" type="text" value="<?php if(isset($_POST['u_name'])) echo $_POST['u_name'] ?>">
                                    <span class="form-label">Username</span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="u_password" value="<?php if(isset($_POST['u_password'])) echo $_POST['u_password'] ?>">
                                    <span class="form-label">Password</span>
                                </div>
                                <div class="form-btn">
                                    <button type="submit" name='login' value="Login" class="submit-btn">Login</button>
                                </div>
								<br><br>
								<div class="form-btn">
									<button type="button" onclick="location.href='register.php'" style="background-color: #8ed68e;" class="submit-btn">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>
