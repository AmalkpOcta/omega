<?php
session_start();

// Redirect if user is not verified
if (!isset($_SESSION['verified_user'])) {
    header("Location: signup.php");
    exit();
}

$user = $_SESSION['verified_user'];

// Set default URL if not provided
$default_url = 'http://65.0.75.28:5173';
$user['url'] = $default_url;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verified User Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .user-details {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            background-color: white;
        }
        .detail-item {
            margin: 15px 0;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            color: #333;
            width: 100px;
            display: inline-block;
        }
        .redirect-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4070f4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            width: 100%;
        }
        .redirect-link:hover {
            background-color: #2d5cf7;
        }
        .message {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            color: #666;
            text-align: center;
        }
        .title {
            text-align: center;
            margin-bottom: 30px;
            color: #4070f4;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-details">
            <div class="title">Account Verified Successfully!</div>
            
            <div class="detail-item">
                <span class="detail-label">Name:</span>
                <?php echo htmlspecialchars($user['name'] ?? ''); ?>
            </div>
            <div class="detail-item">
                <span class="detail-label">Company:</span>
                <?php echo htmlspecialchars($user['company'] ?? ''); ?>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email:</span>
                <?php echo htmlspecialchars($user['email'] ?? ''); ?>
            </div>
            <div class="detail-item">
                <span class="detail-label">PAN:</span>
                <?php echo htmlspecialchars($user['pan'] ?? ''); ?>
            </div>
            
            <?php if(!empty($user['guid'])): ?>
                <a href="<?php echo rtrim($default_url, '/') . '/?guid=' . htmlspecialchars($user['guid']); ?>" 
                   class="redirect-link">
                    <i class="fas fa-external-link-alt"></i> Continue to Your Website
                </a>
            <?php else: ?>
                <div class="message">
                    <p><i class="fas fa-info-circle"></i> Your GUID will be generated shortly. Please wait or contact support.</p>
                </div>
            <?php endif; ?>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.html" style="color: #4070f4; text-decoration: none;">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>