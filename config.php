<?php
$conn = mysqli_connect("localhost","root","","otp_verification");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}