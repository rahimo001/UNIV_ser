
<?php
    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    include 'connect.php';
    $msg = "";

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM teacher WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE teacher SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
            }
        } else {
            header("Location: index.php");
        }
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM teacher WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: welcome.php");
            } else {
                $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    }




// limit tentative password

include('connect.php');
if(isset($_REQUEST['submit']))
{
  $ip = getIpAddr();
  $login_time = time()-30;
  $login_attempts = mysqli_query($conn,"select count(*) as total_count from ip_details where ip='$ip' and login_time>'$login_time'");
  $res = mysqli_fetch_assoc($login_attempts);
  $count = $res['total_count'];
  if($count==3)
  {
    $msgg = "Your account has been blocked. Please try after 30 seconds.";
  }
  else
  {
  $email = $_REQUEST['email'];
  $pwd = md5($_REQUEST['password']);
  $select_query = mysqli_query($conn,"select * from teacher where email='$email' and password='$pwd'");
  $res = mysqli_num_rows($select_query);
  if($res>0)
  {
    $delete_query = mysqli_query($conn,"delete from ip_details where ip='$ip'");
    $fetch_data = mysqli_fetch_array($select_query);
    $name = $fetch_data['email'];
    $_SESSION['email'] = $email;
    header('location:welcome.php');
  }
  else
  {
    $count++;
    $remaining_attempts = 3-$count;
    if($remaining_attempts==0)
    {
      $msgg = "Your account has been blocked. Please try after 30 seconds.";
    }
    else
    {
      $msgg = "Please enter valid details. $remaining_attempts attempts remaining.";
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    $login_time = time();
    $insert_query = mysqli_query($conn,"insert into ip_details set ip='$ip', login_time='$login_time'");
    
  }
}

}
function getIpAddr(){
if (!empty($_SERVER['HTTP_CLIENT_IP'])){
$ipAddr=$_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
$ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
$ipAddr=$_SERVER['REMOTE_ADDR'];
}
return $ipAddr;
}
?>





<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/stylee.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="mem-form1" style="margin-top:5%;">

       
  <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">

                    <div class="mem_form align-self">
                        <div class="left_grid_info">
                            <center> <a href="../home/home.php"><img src="images/logg.avif" alt="" style=" width:50%;"></a></center>
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login Now</h2>
                        <p>To keep connected with us please login with your personal info</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                            <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                            <p class="error" style=" color:red;"><?php if(!empty($msgg)){ echo $msgg; } ?></p>

                        </form>
                        <div class="social-icons">
                            <p>Create Account! <a href="register.php">Register</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    

</body>

</html>