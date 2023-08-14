<?php
session_start();

echo ' <nav class="navbar navbar-expand-lg bg-body-tertiary " data-bs-theme="dark">
<div class="container-fluid">
  <a class="navbar-brand" href="forums.php">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="forums.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu">';
        $sql = "select category_name, category_id from categories limit 3";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          echo '<li><a class="dropdown-item" href="threat_list.php?catid='. $row['category_id'] . '">'. $row['category_name'] .'</a></li>';
        }  
        echo '</ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '<form class="d-flex" role="search" action="search.php" method="get">
              <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-success" type="submit">Search</button>
              <p class="text-light my-0 mx-2">Welcome '. $_SESSION['useremail'] .'</p>
              <a href="partials/_logout.php" class="btn btn-outline-success mx-3">Logout</a>
            </form>';
    }
    else{
      echo '<form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
    </form>
    <button class="btn btn-outline-success mx-3" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
    <button class="btn btn-outline-success me-2"  data-bs-toggle="modal" data-bs-target="#signupmodal">Signup</button>';
    }
  echo '</div>
</div>
</nav>';
include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
// include 'pa> You can now login.
//           <button type="button" clasrtials/_signupmodal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']  =="true"){
  echo '<div class="alert alert-info alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You can now login
  <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
  </button>
        </div>';
}
?>
