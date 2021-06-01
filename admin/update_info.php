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

$query=$connect->query("SELECT * FROM hotels WHERE h_id='$user_id'");
    $row = $query->fetch();

    error_reporting( ~E_NOTICE ); // avoid notice

if(isset($_REQUEST[ 'submit'])) 
{ 
    extract($_REQUEST); 

    $stmt=$connect->prepare("UPDATE hotels SET h_nomo='$h_nomo', h_price='$h_price', h_stars='$h_stars', h_address='$h_address', h_phone='$h_phone', h_id='$user_id', h_desc='$h_desc'  WHERE h_id='$user_id'");
    $stmt->execute() or die(print_r($stmt->errorInfo()."Record Failed", true));
    if($stmt)
    {
        $result="Updated Successfully!!";
            echo "<script type='text/javascript'>
                alert('".$result."');
            </script>";
    }
    else
    {
        $result="Sorry, Internel Error";
            echo "<script type='text/javascript'>
                alert('".$result."');
            </script>";
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
                                <h1>Update your Hotel</h1>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data" name="hotels">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="button" onclick="location.href='dashboard.php'" class="submit-btn">Dashboard</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <input class="form-control" name="h_title" type="text" value="<?php echo $row['h_title'] ?>" disabled>
                                        <span class="form-label">Hotel Name</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="h_nomo" class="form-control" required>
                                            <option value="" selected hidden>Region</option>
                                                <option>attiki</option>
                                                <option>larisa</option>
                                                <option>thessaloniki</option>
                                                <option>evros</option>
                                                <option>rodoph</option>
                                                <option>ksanthi</option>
                                                <option>ioannina</option>
                                                <option>thesprotia</option>
                                                <option>preveza</option>
                                                <option>arta</option>
                                                <option>trikala</option>
                                                <option>karditsa</option>
                                                <option>magnhsia</option>
                                                <option>ahaia</option>
                                                <option>korinthia</option>
                                                <option>argolida</option>
                                                <option>arkadia</option>
                                                <option>ileia</option>
                                                <option>messinia</option>
                                                <option>lakonia</option>
                                                <option>kerkura</option>
                                                <option>leukada</option>
                                                <option>kefallhnia</option>
                                                <option>zakinthos</option>
                                                <option>xania</option>
                                                <option>rethimno</option>
                                                <option>irakleio</option>
                                                <option>lasithi</option>
                                                <option>lesbos</option>
                                                <option>xios</option>
                                                <option>samos</option>
                                                <option>kiklades</option>
                                                <option>dodekanisa</option>
                                                <option>euvoia</option>
                                                <option>voiotia</option>
                                                <option>fokida</option>
                                                <option>aitoloakarnania</option>
                                                <option>fthiotida</option>
                                                <option>euritania</option>
                                                <option>drama</option>
                                                <option>kavala</option>
                                                <option>serres</option>
                                                <option>kilkis</option>
                                                <option>halkidiki</option>
                                                <option>pella</option>
                                                <option>imathia</option>
                                                <option>pieria</option>
                                                <option>florina</option>
                                                <option>kastoria</option>
                                                <option>kozani</option>
                                                <option>grevena</option>
                                            </select>
                                            <span class="select-arrow"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="h_price" class="form-control" required>
                                                <option value="<?php echo $row['h_price'] ?>"><?php echo $row['h_price'] ?></option>
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
                                                <option value="<?php echo $row['h_stars'] ?>"><?php echo $row['h_stars'] ?></option>
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
                                            <input name="h_address" class="form-control" type="text" placeholder="Address" value="<?php echo $row['h_address'] ?>">
                                            <span class="form-label">Address</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="h_phone" class="form-control" type="tel" value="<?php echo $row['h_phone'] ?>">
                                            <span class="form-label">Phone</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="h_desc" class="form-control" style="height: 120px;" type="text" value="<?php echo $row['h_desc'] ?>">
                                    <span class="form-label">Description</span>
                                </div>
                                <div class="form-btn">
                                    <button name="submit" type="submit" class="submit-btn">Update Record</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
</html>



