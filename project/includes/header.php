<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travellers Diary Nepal</title>
    <style>
        html {
            margin: 0;
            background-color: #f5f5f5;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            padding-top: 80px;
            padding-bottom: 80px;
            min-height: 100vh;
            box-sizing: border-box;
            background-color: #f5f5f5;
        }

        .navbar {
            background-color: #d6eaff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            box-sizing: border-box;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar img {
            height: 40px;
        }

        .navbar a {
            color: #333;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <img src="logo.jpg" alt="Logo">
        </div>
        <div>
            <a href="index.php">HOME</a>
            <a href="about.php">ABOUT</a>
            <a href="posts.php">POSTS</a>
            <a href="contact.php">CONTACT</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>