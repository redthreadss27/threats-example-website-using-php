<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - An example of forum</title>
    <style>
        .container1{
            min-height:10px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php
    $id = $_GET['threatid'];
    $sql = "SELECT * FROM threats where threat_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $title = $row['threat_title'];
        $description = $row['threat_description'];
        $comm = $row['threat_user_id'];
        //query the users table to find out the name of original poster
        $sql1 = "select user_email from users where srno = $comm";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);
                $postedby = $row1['user_email'];
    }
    if($noResult){
        echo '<div class="container py-4"><div class="alert alert-info" role="alert">
                <p class="display-6">No Threats found.</p>
                <b>Be the first person to ask the question.</b></div>
              </div>';
    }
    ?>
    <?php
    $showAlert = false;
        if($_SERVER['REQUEST_METHOD'] == "POST"){
         $id = $_GET['threatid'];
            $content = $_POST['comment'];
            $content = str_replace("<", "&lt;", $content);
            $content = str_replace(">", "&gt;", $content);
            $srno = $_POST['srno'];
            $sql = "INSERT INTO comments (comment_content, threat_id, comment_by, comment_time) VALUES ('$content', $id, $srno, current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
        }
        if($showAlert){
            echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your comment has been added please wait for community to responde.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    ?>

    <!-- category start -->
    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h2 class="alert-heading"><?php echo $title ;?> Forums</h2>
            <p><?php echo $description ;?></p>
            <hr>
            <p class="mb-0">This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not
                allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post questions.
                Remain respectful of other members at all times.</p>
            <p class="mt-4">Posted by <b><?php echo $postedby; ?></b></p>
        </div>
    </div>
    <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo '<div class="container">
                        <h1 class="py-2">Post a Comment</h1>
                        <form method="post" action="'. $_SERVER['REQUEST_URI'] .'">
                            
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                <input type="hidden" name="srno" value="'. $_SESSION['srno']. '">
                            </div>
                            <button type="submit" class="btn btn-success">Post Comment</button>
                        </form>
                    </div>';
        }
        else{
            echo '<div class="container">
                        <h1 class="py-2">Post a Comment</h1>
                        <p class="lead">You are not logged in. You have to log in to post the comment</p>
                  </div>';
        }
    ?>    
    <div class="container">
        <h1 class="py-2">Discussion</h1>
        <?php
            $id = $_GET['threatid'];
            $sql = "SELECT * FROM comments where threat_id = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $content =  $row['comment_content'];
                $comment_time = $row['comment_time'];
                $id = $row['comment_id'];
                $threat_user_id = $row['comment_by'];
                $sql1 = "select user_email from users where srno = $threat_user_id";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);
                echo '<div class=" container1 my-3 mb-5">
                <div class="d-flex my-4">
                <div class="flex-shrink-0">
                    <img src="img/userdefault.jpg" width="54px">
                    </div>
                    <div class="flex-grow-1 ms-3">
                    <p class="my-0"><b>'. $row1['user_email'] .' at '. $comment_time .'</b></p>
                    '. $content .'</div>                    
                </div>
                </div>';
            }
            if($noResult){
                echo '<div class="container py-4"><div class="alert alert-info" role="alert">
                            <p class="display-6">No Comments found.</p>
                            <b>Be the first person to ask the question.</b></div>
                        </div>';
            }
        ?>
    </div>
    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>
</html>