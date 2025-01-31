<?php
include "config.php";

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Function to send OTP email
function sendOTPEmail($email, $otp, $name) {
  try {
      $mail = new PHPMailer(true); // true enables exceptions
      
      // Enable debug output
      $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
      
      // Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->Username = 'wweamal4@gmail.com';
      $mail->Password = 'rjpn hznn xrhn krxr';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      
      // Recipients
      $mail->setFrom('wweamal4@gmail.com', 'Amal K P');
      $mail->addAddress($email);
      
      // Content
      $mail->isHTML(true);
      $mail->WordWrap = 50;
      $mail->Subject = 'Verification code for Verify Your Email Address';
      $message_body = '
      <p>Hello ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ',</p>
      <p>For verify your email address, enter this verification code when prompted: <b>'.$otp.'</b>.</p>
      <p>Sincerely,</p>';
      $mail->Body = $message_body;
      
      // Attempt to send the email
      if(!$mail->send()) {
          error_log('Mailer Error: ' . $mail->ErrorInfo);
          return false;
      }
      
      return true;
  } catch (Exception $e) {
      error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
      error_log("Exception: " . $e->getMessage());
      return false;
  }
}

// Handle Login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['login_email']);
    
    // Check if user exists
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Generate new OTP and activation code
        $otp = substr(str_shuffle("0123456789"), 0, 5);
        $activation_code = str_shuffle("abcdefghijklmno" . rand(100000, 10000000));
        
        // Update user with new OTP and activation code
        $updateQuery = "UPDATE user SET otp = '$otp', activation_code = '$activation_code' WHERE email = '$email'";
        if (mysqli_query($conn, $updateQuery)) {
            if (sendOTPEmail($email, $otp, $user['name'])) {
                echo "<script>alert('Please check your email for verification code');</script>";
                echo "<script>window.location.href = 'email_verify.php?code=" . $activation_code . "';</script>";
                exit();
            } else {
                echo "<script>alert('Email sending failed. Please try again.');</script>";
            }
        }
    } else {
        echo "<script>alert('Email not found. Please sign up first.');</script>";
    }
}

// Handle Signup
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pan = mysqli_real_escape_string($conn, $_POST['pan']);
    
    // Generate OTP and activation code
    $otp = substr(str_shuffle("0123456789"), 0, 5);
    $activation_code = str_shuffle("abcdefghijklmno" . rand(100000, 10000000));

    // Check for existing email
    $selectDatabase = "SELECT * FROM user WHERE email = '$email'";
    $selectResult = mysqli_query($conn, $selectDatabase);
    
    if (mysqli_num_rows($selectResult) > 0) {
        $user = mysqli_fetch_assoc($selectResult);
        // Update existing user with new OTP and activation code
        $updateQuery = "UPDATE user SET 
            name = '$name',
            company = '$company',
            url = '$url',
            pan = '$pan',
            otp = '$otp',
            activation_code = '$activation_code'
            WHERE email = '$email'";
        
        if (!mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Update failed: " . mysqli_error($conn) . "');</script>";
            exit();
        }
    } else {
        // Insert new user
        $insertQuery = "INSERT INTO user (name, company, url, email, pan,signup_time, otp, activation_code, status) 
            VALUES ('$name', '$company', '$url', '$email', '$pan',NOW(), '$otp', '$activation_code', 'inactive')";
        
        if (!mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Registration failed: " . mysqli_error($conn) . "');</script>";
            exit();
        }
    }
    
    // Send verification email
    if (sendOTPEmail($email, $otp, $name)) {
        echo "<script>alert('Please check your email for verification code');</script>";
        echo "<script>window.location.href = 'email_verify.php?code=" . $activation_code . "';</script>";
        exit();
    } else {
        echo "<script>alert('Email sending failed. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Login and Registration </title>
    <link rel="stylesheet" href="style.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>   
    </div></header>
  <div class="container">
    <input type="checkbox" id="flip">
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
      <div class="back">
        <img class="backImg" src="images/backImg.jpg" alt="">
        <div class="text">
          <span class="text-1"><a href="index.html" style="color: white; text-decoration: none; transition: color 0.3s ease;" 
            onmouseover="this.style.color='#00efff'" onmouseout="this.style.color='white'">Omega<br>Complete miles of journey <br> with one step</a></span>
          <span class="text-2"><a href="index.html" style="color: white; text-decoration: none; transition: color 0.3s ease;" 
            onmouseover="this.style.color='#00efff'" onmouseout="this.style.color='white'">Let's get started</a></span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
          <form action="" method="post">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="login_email" placeholder="Enter your email " required>
              </div>
              
              <div class="text"><a href="#"></a></div>
              <div class="button input-box">
                <input type="submit" name="login" value="login">
              </div>
              <div class="text sign-up-text">Don't have an account? <label for="flip">Signup now</label></div>
            </div>
        </form>
      </div>
        <div class="signup-form">
          <div class="title">Signup</div>
          <form action="" method="POST">
            <input type="hidden" name="otp" value="<?php echo $otp; ?>">
            <input type="hidden" name="activation_code" value="<?php echo $activation_code; ?>">
                <div class="input-boxes">
                  <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Enter your name" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-landmark"></i>
                    <input type="text" name="company" placeholder="Enter your comapny name" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-globe"></i>
                    <input type="text" name="url" placeholder="Enter url" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="email" placeholder="Enter your email" required>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-address-card"></i>
                    <input type="text" name="pan" placeholder="Enter your PAN" required>
                  </div>
                  <div class="button input-box">
                    <input type="submit" name="register" value="Signup">
              </div>
              <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
            </div>
      </form>
    </div>
    </div>
    </div>
  </div>
</body>
</html>
