<?php
	require 'db/config.php';
	if(empty($_SESSION['u_name']))
    {
        header('Location: login.php');
    }
		

$user_name = '';
$user_id = '';

if(isset($_SESSION["u_name"], $_SESSION["u_id"]))
{
	$user_name = $_SESSION["u_name"];
	$user_id = $_SESSION["u_id"];
}

if(isset($_REQUEST[ 'submit'])) 

{ 
    extract($_REQUEST); 

    $stmt=$connect->prepare("INSERT INTO hotels SET h_title='$h_title', h_nomo='$h_nomo', h_price='$h_price', h_stars='$h_stars', h_address='$h_address', h_phone='$h_phone', h_id='$user_id', h_desc='$h_desc'");
    $stmt->execute() or die(print_r($stmt->errorInfo()."Record Failed", true));
    if($stmt)
    {
        echo "<script type='text/javascript'>
              alert('Entry Added Succesfully');
              
         </script>";
    }
    else
    {
         echo $stmt;
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
        <script type='text/javascript'></script> 
        <title>Document</title>
    </head>
    <body>
        <div id="booking" class="section">
            <div class="section-center">
                <div class="container">
                    <div class="row">
                        <div class="booking-form">
                            <div class="form-header">
                                <h1>Add your Hotel</h1>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data" name="hotels">
                                <div class="form-group">
                                    <input class="form-control" name="h_title" type="text" placeholder="Hotel Name">
                                    <span class="form-label">Hotel Name</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="h_nomo" class="form-control" required>
                                                <option value="" selected hidden>Region</option>
                                                <option>athens</option>
                                                <option>larisa</option>
                                                <option>skg</option>
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="h_price" class="form-control" required>
                                                <option value="" selected hidden>Price</option>
                                                <option>&euro;</option>
                                                <option>&euro;&euro;</option>
                                                <option>&euro;&euro;&euro;</option>
                                                <option>&euro;&euro;&euro;&euro;</option>
                                                <option>&euro;&euro;&euro;&euro;&euro;</option>
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="h_stars" class="form-control" required>
                                                <option value="" selected hidden>Rating</option>
                                                <option>1 star</option>
                                                <option>2 star</option>
                                                <option>3 star</option>
                                                <option>4 star</option>
                                                <option>5 star</option>
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="h_address" class="form-control" type="text" placeholder="Address">
                                            <span class="form-label">Address</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="h_phone" class="form-control" type="tel" placeholder="Phone">
                                            <span class="form-label">Phone</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="h_desc" class="form-control" style="height: 120px;" type="text" placeholder="Description">
                                    <span class="form-label">Description</span>
                                </div>
                                <div class="form-btn">
                                    <button name="submit" type="submit" class="submit-btn">Add Record</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>
