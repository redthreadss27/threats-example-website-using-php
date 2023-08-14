<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - An example of forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <!-- slider start -->
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider-1.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-2.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-3.jpeg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- category start -->
    <div class="container mt-5 text-center">
        <h2 class="text-center my-5">iDiscuss - Browse Categories</h2>
        <div class="row m-auto">
            <!-- use a for loop to iterate through categories -->
            <!-- fetch all the categories -->
            <?php 
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                // echo $row['category_id'];
                $cat = $row['category_name'];
                $catid = $row['category_id'];
                $desc = $row['category_description'];
                echo '<div class="col-md-4">
                        <div class="card my-2" style="width: 18rem;">
                            <img src="img/b'. $catid .'.jpeg" class="card-img-top" alt="...">
                            <div class="card-body">
                            <h5 class="card-title"><a href="threat_list.php?catid='. $catid .'">'. $cat .'</a></h5>
                            <p class="card-text">'. substr($desc, 0, 150) . '...</p>
                            <a href="threat_list.php?catid='. $catid .'" class="btn btn-primary">View Threads</a>
                            </div>
                        </div>
                     </div>';
            }
            ?>
        </div>
    </div>
    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>
</html>