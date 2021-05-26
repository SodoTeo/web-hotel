<?php
    include('admin/db/config.php');
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
</head>
<body style="background-image: linear-gradient(to right, #7B1FA2, #E91E63);">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><h2  class="text-warning">WebBooking</h2></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mob-navbar" aria-label="Toggle">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mob-navbar">
                <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/dashboard.php">Dashboard</a>
                    </li>
                </ul>
                <form class="d-flex" action="admin/login.php">
                    <button class="btn btn-warning" type="submit" <?php if (isset($_SESSION["u_id"])){ echo 'style="display:none;"'; } ?>>Login</button> &nbsp;&nbsp;
                </form>
                <form action="admin/register.php">
                    <button class="btn btn-danger" type="submit" <?php if (isset($_SESSION["u_id"])){ echo 'style="display:none;"'; } ?>>Register</button>
                </form>
                <form action="admin/logout.php">
                    <button class="btn btn-danger" type="submit" <?php if (!isset($_SESSION["u_id"])){ echo 'style="display:none;"'; } ?>>Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Bootstrap JS -->
    <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
</body>
</html>