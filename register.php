<?php
   
   
   //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'connect.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $Birth_Date = mysqli_real_escape_string($conn, $_POST['Birth_Date']);
        $mobile_numb = mysqli_real_escape_string($conn, $_POST['mobile_numb']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $sex = mysqli_real_escape_string($conn, $_POST['sex']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));
         $idD=$_POST['idD'];

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM teacher WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                
    
                $sql = "INSERT INTO teacher (name, username, Birth_Date, mobile_numb, grade, sex, email, password, code,idD) VALUES ('{$name}', '{$username}', '{$Birth_Date}', '{$mobile_numb}', '{$grade}', '{$sex}', '{$email}', '{$password}', '{$code}','{$idD}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'lamiahafsa567@gmail.com';              //SMTP username
                        $mail->Password   = 'ivuwjmdnxiormsir';                     //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('lamiahafsa567@gmail.com','Univ-Mascara');
                        $mail->addAddress($email,$name);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/memoire/login/?verification='.$code.'">http://localhost/memoire/login/?verification='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert alert-info'>We've send a verification link on your email address. </div>";
                    
                } else {
                    $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
<?php include 'include/nav.php' ?>

    <title>SignUp Form</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"
      type="text/css">

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="mem-form1">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="mem_form align-self">
                        <div class="left_grid_info">
                           <center><img src="images/picture.png" alt="" style=" width:70%;"></center> 
                        </div>
                    </div>
                    <?php include('message.php'); ?>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <p> Enter your personal details and start journey with us</p>
                        <?php echo $msg; 
                       ?>
                        <form action="" method="post" id="student-form" onclick="return signupValidation()">
                        <div class="input">
                          <div class="pad">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            </div>
                            <div class="pad">
                            <input type="text" class="username" name="username" placeholder="Enter Your UserName" required>
                            </div>
                            </div>
                            <div class="input">
                            <input type="date" id="Birth_Date" name="Birth_Date" placeholder="Enter Your Birth_Date" required>
                            <select name="sex" id="sex" class="select">
                            <option value="">Sex</option>  
                            <option value="Femme">Femme</option>
                            <option value="Homme">Homme</option>
                          </select>  
                          </div>
                          <div class="input">
                          
                            <span class="required error" id="mobile_numb-info"></span>   
                            <input type="text" id="mobile_numb" name="mobile_numb" placeholder="Enter Your mobile_numb">
                            <input type="text" id="grade" name="grade" placeholder="Enter your grade"required>
                            </div>
                        
                        <?php 
                            $conn=mysqli_connect("localhost","root","","assia");
                            $sql="SELECT * FROM faculty";
                            $result=mysqli_query($conn,$sql);?>
                            <select name="idF" id="idF" onchange="getidD(this.value)" class="select">
                            <option value="" disabled selected>choose your Faculty</option>
                            <?php while($row = mysqli_fetch_array($result)){?>
                            <option value="<?php echo $row [0]; ?>"><?php echo $row[1]; ?></option>
                            <?php } ?>
                            </select>
                            <p id="idD" class=""></p>
                            <div class="input">
                            
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            </div>
                            <div class="input">
                            <div class="pad">
                            <input type="password" class="password" id="password" name="password" placeholder="Enter Your Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <div class="pad">
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            </div></div>
                            <button name="submit" class="btn" type="submit">Register</button>                            
                             </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->












    <script src="js/jquery.min.js"></script>
    <script>
  document.getElementById('student-form').addEventListener('submit', function(event) {
    var dobInput = document.getElementById('Birth_Date');
    var dob = new Date(dobInput.value);
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();

    // Compare the age with the minimum required age (17)
    if (age < 23) {
      event.preventDefault(); // Prevent form submission
      alert('You must be at least 23 years old.');
    }
  });


//function_tests

function signupValidation() {
	var valid = true;
	$("#mobile_numb").removeClass("error-field");
	var mobile_numb =$("#mobile_numb").val();
	var mobile_numbRegex = /^0[6-7-5]{1}\d{8}$/;  
    $("#mobile_numb-info").html("").hide();

//test mobile_numb
if (mobile_numb == "") {
		$("#mobile_numb-info").html("").css("color", "#ee0000").show();
		$("#mobile_numb").addClass("error-field");
		valid = false;
}else if (!mobile_numbRegex.test(mobile_numb)) {
		$("#mobile_numb-info").html("Invalid mobile_numb.").css("color", "#ee0000")
				.show();
		$("#mobile_numb").addClass("error-field");
		valid = false;
	}




/**test password */


        var myInput = document.getElementById("psw");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        
        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
          document.getElementById("message").style.display = "block";
        }
        
        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
          document.getElementById("message").style.display = "none";
        }
        
        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {
          // Validate lowercase letters
          var lowerCaseLetters = /[a-z]/g;
          if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
          } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }
        
          // Validate capital letters
          var upperCaseLetters = /[A-Z]/g;
          if(myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
          } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
          }
        
          // Validate numbers
          var numbers = /[0-9]/g;
          if(myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
          } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
          }
        
          // Validate length
          if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
          } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
          }
        }
       
    }


</script>
<script>

	function getidD(val){
		$.ajax({
			type: "POST",
			url: 'getidD.php',
			data: {id : val},
			success:function(data){
				$("#idD").html(data);
			}
		});
	}
</script>
<script src="jss/jquery-3.6.1.min.js"></script>
</body>

</html>