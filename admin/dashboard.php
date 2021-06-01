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
 //---------------------------IMG--------------------------------//

 error_reporting( ~E_NOTICE ); // avoid notice


 if(isset($_POST['submit']))
 {
 
	 
	 
	 $imgFile = $_FILES['user_image']['name'];
	 $tmp_dir = $_FILES['user_image']['tmp_name'];
	 $imgSize = $_FILES['user_image']['size'];
	 
	 if(empty($imgFile)){
		 $errMSG = "Please Select Image File.";
	 }
	 else{
		 $upload_dir = '../images/'; // upload directory

		 $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		 
		 // valid image extensions
		 $valid_extensions = array('jpg'); // valid extensions
		 
		 // rename uploading image
		 $userpic = rand(1000,1000000).".".$imgExt;
		 
		 // allow valid image file formats
		 if(in_array($imgExt, $valid_extensions)){   
			 // Check file size '300kb'
			 if($imgSize < 350000) {
				 move_uploaded_file($tmp_dir,$upload_dir.$userpic);
			 }
			 else{
				 $errMSG = "Sorry, your file is too large. Check file size to be 300KB.";
			 }
		 }
		 else{
			 $errMSG = "Sorry, only JPG files are allowed.";  
		 }
	 }
	 
	 // if no error occured, continue ....
	 if(!isset($errMSG))
	 {
		 $stmt = $connect->prepare('INSERT INTO images(img_id,u_foto) VALUES( :uids, :upic)');
		 $stmt->bindParam(':uids',$user_id);
		 $stmt->bindParam(':upic',$userpic);
		 if($stmt->execute())
		 {
			 $successMSG = "new record succesfully inserted ...";
			 header("refresh:2;"); // redirects image view page after 2 seconds.
		 }else
		 {
			 $errMSG = "error while inserting....";
		 }
	 }
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
	<div id="booking" style="    height: 150vh;" class="section">
            <div class="section-center">
                <div class="container">
                    <div class="row">
                        <div class="booking-form">
                            <div class="form-header">
                                <h1>Menu</h1>
                            </div>
                            <form action="" enctype="multipart/form-data" method="post">
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
								<div class="row">
									<form action="" method="post" enctype="multipart/form-data" name="hotels">  
										<div class="col-md-6">
											<div class="form-group">
												<input name="user_image" class="form-control" id="upload-photo" style="  opacity: 0; position:absolute; z-index: -1; " type="file" accept="image/*">
												<label class="submit-btn" style="color:#8ed68e; background-color: rgba(255, 255, 255, 0.2);" for="upload-photo">Browse...</label>
												<span class="form-label">Profile Img.</span>

											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input name="submit" style="background-color: #8ed68e;" class="submit-btn" type="submit" ">
												<span class="form-label">Update image</span>
											</div>
										</div>
									</form>
                                </div>
					

					
								<!--/ ---------------------------IMG-------------------------------- /-->
								<?php
                require_once 'db/config.php';
                if(isset($_GET['delete_id']))
                {
                    // select image from db to delete
                    $stmt_select = $connect->prepare('SELECT u_foto FROM images WHERE u_foto =:uid');
                    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
                    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
                    unlink("../images/".$imgRow['u_foto']);
                    
                    // it will delete an actual record from db
                    $stmt_delete = $connect->prepare('DELETE FROM images WHERE u_foto =:uid');
                    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
                    $stmt_delete->execute();
      
                }
                ?>
                    <?php
                    
                    $stmt = $connect->prepare("SELECT u_foto FROM images WHERE img_id LIKE $user_id ");
                    $stmt->execute();
                    
                    if($stmt->rowCount() > 0)
                    {
                        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row);
                            ?>

                            <div class='row'>
                             
                                    <div class='col-md-6 well'>
                                        <img src="../images/<?php echo $row['u_foto']; ?>" class="img-rounded" width="30%"  /> 
                                        <a class="btn" style="color: #ffbb2b;" href="?delete_id=<?php echo $row['u_foto']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
                                    </div>    
                            </div>
							<br>   

                            <?php
                        }
                    }else
                    {
                        ?>
                            <div class='row'>
                            
                                    <div class='col-md-6 well'>
                                        <div class="alert alert-warning">
                                            <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Image Found ...
                                        </div>
                                    </div>    
                            </div> 
                        <?php
                    }
                    ?>
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