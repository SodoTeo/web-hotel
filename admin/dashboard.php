<?php
	require 'db/config.php';
	if(empty($_SESSION['u_name'])){
		header('Location: login.php');
	}
		
    $user_id = '';

    if(isset( $_SESSION["u_id"]))
    {
        $user_id = $_SESSION["u_id"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WebBooking</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/form.css" />
</head>
<body style="background-image: linear-gradient(to right, #7B1FA2, #E91E63);">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><h2  class="text-warning">Welcome <?php echo $_SESSION['u_name']; ?></h2></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mob-navbar" aria-label="Toggle">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mob-navbar">
                <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
                    <li class="nav-item">
                        <a class="nav-link"  href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                </ul>
                <form action="logout.php">
                    <button class="btn btn-danger" type="submit" <?php if (!isset($_SESSION["u_id"])){ echo 'style="display:none;"'; } ?>>Logout</button>
                </form>
            </div>
        </div>
    </nav>
	<div id="booking" class="section">
            <div class="section-center">
                <div class="container">
                    <div class="row">
                        <div class="booking-form">
                            <div class="form-header">
                                <h1>Menu</h1>
                            </div>
                            <form action="" method="post">
							<?php
                                    $result = $connect->query("SELECT * FROM hotels WHERE h_id LIKE $user_id ");
                                    if($result)
                                    {   
                                        if(($result-> rowCount()) > 0)
                                        {
                                            while($row= $result->fetch(PDO::FETCH_ASSOC))
                                            {        
                                                echo '<div class="form-btn">
														<button type="button" style="background-color: #8ed68e;" class="submit-btn">Already added</button>
													</div>';
                                            }       
                                        }
                                        else
                                        {
											echo '<div class="form-btn">
											<button type="button" onclick="location.href='?>'submission.php'<?php echo'" style="background-color: #8ed68e;" class="submit-btn">Add your Hotel</button>
										</div>';
                                        }
                                    }
                                    else
                                    {
                                        echo "Cannot connect to server".$result;
                                    }
                                    ?>
								
								<br><br>
								<div class="form-btn">
									<button type="button" onclick="location.href='update_info.php'" style="background-color: #8ed68e;" class="submit-btn">Update your hotel</button>
                                </div>
								<br><br>
								<div class="form-btn">
									<p style="color: #E91E63;">Here wil be image gallery+form ....</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

    <!-- Bootstrap JS -->
    <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
</body>
</html>