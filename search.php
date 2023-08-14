<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    .search {
        min-height: 90vh;
    }
    </style>
    <title>iDiscuss - An example of forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
  
    <!-- search results -->
    <div class="container my-3 search">
        <h1 class="text-center">Search results for "<?php echo $_GET['search'];?>"</h1>
        <?php
        // $id = $_GET['threatid'];
        $query = $_GET["search"];
        $sql = "SELECT * FROM `threats` WHERE MATCH(threat_title, threat_description) against ('$query');";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $title = $row['threat_title'];
            $description = $row['threat_description'];
            $comm = $row['threat_user_id'];
            $threat_id = $row['threat_id'];
            $url = "threat.php?threatid=".$threat_id;
            //query the users table to find out the name of original poster
            // $sql1 = "select user_email from users where srno = $comm";
            //         $result1 = mysqli_query($conn, $sql1);
            //         $row1 = mysqli_fetch_assoc($result1);
            //         $postedby = $row1['user_email'];
            echo ' <div class="result">
            <h3><a href="'.$url.'" class="text-dark">'. $title .'</a></h3>
            <p>'. $description .' </p>
        </div>';
        }
        if($noResult){
            echo '<div class="container py-4"><div class="alert alert-info" role="alert">
            <p class="display-6">No Result Found.</p>
            <b>Did not match any document in the suggestions. Make sure your spelling is correct</b></div>
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