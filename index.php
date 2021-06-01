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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/card.css">
    <style>
      .container .gallery a img {
      float: left;
      width: 30%;
      height: auto;
      border: 2px solid #fff;
      -webkit-transition: -webkit-transform .15s ease;
      -moz-transition: -moz-transform .15s ease;
      -o-transition: -o-transform .15s ease;
      -ms-transition: -ms-transform .15s ease;
      transition: transform .15s ease;
      position: relative;
    }
    </style>
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
<?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $no_of_records_per_page = 5;
        $offset = ($page-1) * $no_of_records_per_page;
        $total_pages_sql = "SELECT COUNT(*) FROM hotels";
        $result = $connect->prepare($total_pages_sql);
        $result->execute();
        $total_rows = $result->fetchColumn();
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        $sql = "SELECT * FROM hotels LIMIT $offset, $no_of_records_per_page";
        $res_data = $connect->prepare($sql);
        $res_data->execute();
                if($res_data)
                {   
                    if(($res_data-> rowCount()) > 0 )
                    {
                        while (($row =$res_data->fetch()))
                        {
                            $stmt = $connect->prepare('SELECT u_foto FROM images WHERE img_id=:uids  LIMIT 1 ');
                            $stmt->bindParam(':uids',$row['h_id']);
                            $stmt->execute();
                            if($stmt->rowCount() > 0)
                            {
                                while($img_row=$stmt->fetch())
                                {
                                    extract($img_row);
                                    ?>
                                      <div class='row' style="width: 90%;  margin-left: 6%;">
                                        <div class="container">
                                          <section class="mx-auto my-5" style="max-width: 23rem;">
                                            <div class="card">
                                              <div class="card-body d-flex flex-row">
                                                <div>
                                                  <h5 class="card-title font-weight-bold mb-2"><?php echo $row['h_title']?></h5>
                                                  <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?php echo $row['h_address']?>,<?php echo $row['h_nomo']?></p>
                                                </div>
                                              </div>
                                              <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
                                                <img  src='images/<?php echo $img_row['u_foto']?>' class="img-fluid" id='Myimg<?php echo $row['h_id']?>'  />
                                                <a href="#!">
                                                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                                </a>
                                              </div>
                                                  <!-- Button trigger modal -->
                                                <button type="button" style="    background-color: #8ed68e; border-color:#8ed68e;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Read More
                                                </button>
                                              </div>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Description</h5>
                                                <div class="card-body d-flex flex-row">
                                                <div>
                                                  <p class="card-text"><i class="fas fa-tag"></i>  <?php echo $row['h_price']?></p>
                                                  <p class="card-text"><i class="fas fa-star"></i> <?php echo $row['h_stars']?></p>
                                                  <p class="card-text"><i class="fas fa-mobile-alt"></i>  <?php echo $row['h_phone']?></p>
                                                </div>
                                              </div>
                                 
                                              </div>
                                              <div style="text-align:justify;" class="modal-body">
                                              <?php echo $row['h_desc']?>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                            <div class="modal fade" id="Mymodal<?php echo $row['h_id']?>">
                                                <div class="modal-dialog"  style="top:20%; width: 80%; height: 60%;">
                                                    <div class="modal-content" style="width: 100%; height: 100%;" >
                                                        <div class="modal-header">
                                                        
                                                            <h4 class="modal-title">
                                                                Gallery
                                                            </h4>                                                             
                                                        </div> 
                                                        <div class="modal-body">
                                                            <div class='container'>
                                                                <div  class="gallery gallery<?php echo $row['h_id']?> " >
                                                                    <?php 
                                                                   
                                                                        $stmtimg = $connect->prepare('SELECT u_foto FROM images WHERE img_id=:uids ');
                                                                        $stmtimg->bindParam(':uids',$row['h_id']);
                                                                        $stmtimg->execute();
                                                                        if($stmtimg->rowCount() > 0)
                                                                            {
                                                                                while($img_row=$stmtimg->fetch())
                                                                                {
                                                                                    extract($img_row);
                                                                                    $imageThumbURL = 'images/'.$img_row["u_foto"];
                                                                                    $imageURL = 'images/'.$img_row["u_foto"];
                                                                                    ?>
                                                                                    <a href="<?php echo $imageURL; ?>" data-fancybox="gallery<?php echo $row['h_id']?>" " >
                                                                                        <img src="<?php echo $imageThumbURL; ?>" alt="" />
                                                                                    </a>
                                                                                    <?php 
                                                                                }
                                                                            } ?>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>             
                                                        </div>
                                                    </div>                                                                       
                                                </div>                                      
                                            </div>
                                        <script>
                                            $(document).ready(function(){
                                            $('#Myimg<?php echo $row['h_id']?>').click(function(){
                                                $('#Mymodal<?php echo $row['h_id']?>').modal('show')
                                            });
                                        });

                                        $(document).ready(function(){

                                        // Intialize gallery
                                        var gallery = $('.gallery<?php echo $row['h_id']?> a').simpleLightbox();

                                        });
                                        </script>
                                            
                                        
                                    
                                      <?php
                                }
                            }
                            else
                            {
                                ?>
                                <div class='row'>
                                        <div class="container">
                                          <section class="mx-auto my-5" style="max-width: 23rem;">
                                            <div class="card">
                                              <div class="card-body d-flex flex-row">
                                                <div>
                                                  <h5 class="card-title font-weight-bold mb-2"><?php echo $row['h_title']?></h5>
                                                  <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?php echo $row['h_address']?>,<?php echo $row['h_nomo']?></p>
                                                </div>
                                              </div>
                                              <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
                                                <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/full page/2.jpg"
                                                  alt="Card image cap" />
                                                <a href="#!">
                                                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                                </a>
                                              </div>
                                                  <!-- Button trigger modal -->
                                                <button type="button" style="    background-color: #8ed68e; border-color:#8ed68e;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Read More
                                                </button>
                                              </div>
                                            </div>
                                        </div>
                            
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Description</h5>
                                                <div class="card-body d-flex flex-row">
                                                <div>
                                                  <p class="card-text"><i class="fas fa-tag"></i>  <?php echo $row['h_price']?></p>
                                                  <p class="card-text"><i class="fas fa-star"></i> <?php echo $row['h_stars']?></p>
                                                  <p class="card-text"><i class="fas fa-mobile-alt"></i>  <?php echo $row['h_phone']?></p>
                                                </div>
                                              </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div style="text-align:justify;" class="modal-body">
                                              <?php echo $row['h_desc']?>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                            
                                        <?php
                                        
                                    
                                
                                    
                            }
                               
                        }
                    }
                    else
                    {
                        echo "NO Data Exist";
                    }
                }
                else
                {
                    echo "Cannot connect to server".$res_data;
                } 
    ?>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="node_modules/simple-lightbox/dist/simpleLightbox.min.css">
    <script src="node_modules/simple-lightbox/dist/simpleLightbox.min.js"></script>

<nav aria-label="..." style="    margin-left: 43%;">
  <ul class="pagination">
    <li class="page-item">
      <span class="page-link"><a href="?page=1">First</a></span>
    </li>
    <li class="page-item" class="<?php if($page <= 1){ echo 'disabled'; } ?>">
      <span class="page-link"><a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a></span>
    </li>
    <li class="page-item" class="<?php if($page >= $total_pages){ echo 'disabled'; } ?>">
      <span class="page-link"><a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a></span>
    </li>
    <li class="page-item">
      <span class="page-link"><a href="?page=<?php echo $total_pages; ?>">Last</a></span>
    </li>
  </ul>
</nav>
</body>
</html>
