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
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM categories where category_id = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        $showAlert = false;
        // echo $method;
        if($method == "POST"){
            //insert threat into DB
            $th_title = $_POST['title'];
            $th_desc = $_POST['description'];

            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);

            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);

            $srno = $_POST['srno'];
            $sql = "INSERT INTO threats (threat_title, threat_description, threat_cat_id, threat_user_id, timestamp) VALUES ('$th_title', '$th_desc', $id, $srno, current_timestamp())";
            $result = mysqli_query($conn, $sql); 
            $showAlert = true;
        }
        if($showAlert){
            echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added please wait for community to responde.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>
    <!-- category start -->
    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h2 class="alert-heading">Welcome to <?php echo $catname ;?> Forums</h2>
            <p><?php echo $catdesc ;?></p>
            <hr>
            <p class="mb-0">This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not
                allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do
                not cross post questions.
                Remain respectful of other members at all times.</p>
           
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <form method="post" action="'. $_SERVER["REQUEST_URI"]. ' ">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as crisp and short as possible</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Elaborate your concern</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                <input type="hidden" name="srno" value="'. $_SESSION['srno']. '">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <p class="lead">You are not logged in. You have to log in to add the comment</p>
    </div>';
    }
    ?>
    
    <div class="container">
        <h1 class="py-2">Browse Questions</h1>
        <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM threats where threat_cat_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id =  $row['threat_id'];
        $title = $row['threat_title'];
        $desc = $row['threat_description'];
        $threat_time = $row['timestamp'];
        $threat_user_id = $row['threat_user_id'];
        $sql1 = "select user_email from users where srno = $threat_user_id";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
        
        echo '<div class="container mb-5">
        <div class="media mb-2">
            <img src="img/userdefault.jpg" width="54px">
            <div class ="media-body">
            
            <h5 class="mt-2"><a class="text-dark" href="threat.php?threatid='. $id . '">'. $title .'</a></h5>
            '. $desc .'
            </div>'. '<p class="my-0"><b>Asked by '. $row1['user_email'] .' at '. $threat_time .'</b></p>'.
        '</div>
        </div>';
    }
    if($noResult){
        echo '<div class="container py-4"><div class="alert alert-info" role="alert">
        <p class="display-6">No Threats found.</p>
        <b>Be the first person to ask the question.</b></div></div>';
    }
    ?>


    </div>


    <?php include 'partials/_footer.php';?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>