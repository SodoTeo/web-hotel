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
				header('Location: login.php');
				exit;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

?>


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
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                                    <input class="form-control" name="u_name" type="text" placeholder="Username"value="<?php if(isset($_POST['u_name'])) echo $_POST['u_name'] ?>">
                                    <span class="form-label">Username</span>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="u_email" placeholder="Email" value="<?php if(isset($_POST['u_email'])) echo $_POST['u_email'] ?>">
                                    <span class="form-label">Email</span>
                                </div>
								<div class="form-group">
                                    <input type="password" class="form-control" name="u_password"placeholder="Password" value="<?php if(isset($_POST['u_password'])) echo $_POST['u_password'] ?>">
                                    <span class="form-label">Password</span>
                                </div>
								<div class="form-group">
									<div style="    padding-left: 22%;" class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
								</div>
                                <div class="form-btn">
                                    <button type="submit" name='register' value="Register" class="submit-btn">Register</button>
                                </div>
								<br><br>
								<div class="form-btn">
									<button type="button" onclick="location.href='../index.php'" style="background-color: #8ed68e;" class="submit-btn">Back</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>