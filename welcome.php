<!doctype html>
<html lang="en">
<head>
    <title>Teacher</title>
</head>
<style>

p {
  animation-duration: 3s;
  animation-name: slidein;
  margin-top:10%;
  font-size: 60PX;
  text-transform: uppercase;
  line-height: 1;
  font-weight: bold;

}

@keyframes slidein {
  from {
    margin-left: 100%;
    width: 300%;
  }

  to {
    margin-left: 0%;
    width: 100%;
  }
}
75% {
  font-size: 300%;
  margin-left: 25%;
  width: 150%;
}

.text {
  @supports (background-clip: text) or (-webkit-background-clip: text) {
    background-image: 
      url("data:image/svg+xml,%3Csvg width='2250' height='900' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg%3E%3Cpath fill='%23696687' d='M0 0h2255v899H0z'/%3E%3Ccircle cx='366' cy='207' r='366' fill='%23050607'/%3E%3Ccircle cx='1777.5' cy='318.5' r='477.5' fill='%232b2c2e'/%3E%3Ccircle cx='1215' cy='737' r='366' fill='%23a8adb1'/%3E%3C/g%3E%3C/svg%3E%0A");
      background-size: 110% auto;
    background-position: center;
    color: transparent;
    -webkit-background-clip: text;
    background-clip: text;
    margin-top:10%;
  }
}
img{
height:300PX;
margin-top:2%;

}

</style>
<body>


<?php include 'include/nav.php' ?>

<div class="container py-2">
<p class="text"> 
  <?php

    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    $conn = mysqli_connect("localhost", "root", "", "assia");
    $query = mysqli_query($conn, "SELECT * FROM teacher WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
       echo "Welcome Dr. " . $row['name'] . " ";
        
        $_SESSION['idT']=$row['idT'];

    }
?>
</p>
</div>
<img src="person.png" alt="">
<img src="person1.png" alt="">

</body>
</html>