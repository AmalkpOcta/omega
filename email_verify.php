<?php
include "config.php";
date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['verify'])) {
    if (isset($_GET['code'])) {
        $activation_code = $_GET['code'];
        $otp = $_POST['otp'];
        $sqlSelect = "SELECT * FROM user WHERE activation_code ='".$activation_code."'";
        $resultSelect = mysqli_query($conn, $sqlSelect);
        if (mysqli_num_rows($resultSelect) > 0) {

            $rowSelect = mysqli_fetch_assoc($resultSelect);
            $rowOtp = $rowSelect['otp'];
            $rowSignupTime = $rowSelect['signup_time'];
            $rowSignupTime = date('d-m-Y h:i:s', strtotime($rowSignupTime));
            $rowSignupTime = date_create($rowSignupTime);
            date_modify($rowSignupTime, "+5 minutes");
            $timeUp = date_format($rowSignupTime,'d-m-Y h:i:s');

            if ($rowOtp !== $otp) {
                echo "<script> alert('Please provide correct OTP..!')</script>";
                }
                else{
                    if (date ('d-m-Y h:i:s') >= $timeUp) {
                        echo "<script>alert('Your time is up..try it again..!')</script>";
                        header("Refresh:1; url=signup.php");
                        } 
                else{
                    $sqlUpdate = "UPDATE user SET status='active' WHERE otp = '".$otp."' AND activation_code = '".$activation_code."'";
                    $resultUpdate = mysqli_query($conn, $sqlUpdate);
                    if ($resultUpdate) {
                        echo "<script>alert('Your account is verified..!')</script>";
                        header("Refresh:1; url=signup.php");
                        }
                        else{
                            echo "<script>alert('Your account is not verified')</script>";
                            
                        }
                    }
                }
            }
            else{header("location: signup.php");}
        } 
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>   
    <div class="container">
      <div class="cover">
        <div class="front">
          <img src="images/frontImg.jpg" alt="">
          <div class="text">
            <span class="text-1"><a href="index.html" style="color: white; text-decoration: none; transition: color 0.3s ease;" 
              onmouseover="this.style.color='#00efff'" onmouseout="this.style.color='white'">Omega<br>Every new step is a <br> new adventure</a></span>
            <span class="text-2"><a href="index.html" style="color: white; text-decoration: none; transition: color 0.3s ease;" 
              onmouseover="this.style.color='#00efff'" onmouseout="this.style.color='white'">Let's get connected</a></span>
          </div>
        </div>
      </div>
      <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Email Verification</div>
            <form action="" method="POST">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-key"></i>
                  <input type="text" name="otp" placeholder="Enter verification code" required>
                </div>
                <div class="button input-box">
                  <input type="submit" name="verify" value="Verify Email">
                </div>
                <div class="text sign-up-text">
                  Check your email for the verification code
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>