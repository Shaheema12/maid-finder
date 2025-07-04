<?php
session_start();
require 'db.php'; // Include your database connection file

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields!";
    } else {
        // Check admin credentials
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            // Authentication successful
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_name'] = $admin['full_name'];
            header('Location: admin-home.php');
            exit;
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login - Maid Finder</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('https://images.unsplash.com/photo-1522199755839-a2bacb67c546?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
      background-size: cover;
      overflow: hidden;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 0;
    }

    body::after {
      content: '';
      position: absolute;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle at center, #ff69b4 0%, #000 80%);
      animation: bgPulse 10s infinite alternate;
      opacity: 0.1;
      z-index: 0;
    }

    @keyframes bgPulse {
      0% { transform: scale(1); }
      100% { transform: scale(1.2); }
    }

    .container {
      position: relative;
      background: rgba(255, 255, 255, 0.05);
      border: 2px solid rgba(255, 105, 180, 0.3);
      backdrop-filter: blur(12px);
      border-radius: 15px;
      padding: 40px 30px;
      width: 100%;
      max-width: 400px;
      text-align: center;
      color: #fff;
      box-shadow: 0 0 25px rgba(255, 105, 180, 0.3);
      animation: fadeIn 1s ease-in-out;
      z-index: 1;
    }

    h2 {
      font-weight: 600;
      margin-bottom: 25px;
      color: #ff69b4;
    }

    .error-message {
      color: #ff4d6d;
      margin-bottom: 15px;
      font-size: 0.9rem;
      min-height: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 1rem;
      transition: background 0.3s ease;
    }

    input::placeholder {
      color: #ccc;
    }

    input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.2);
    }

    .btn {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      color: #fff;
      background: linear-gradient(135deg, #ff1493, #ff69b4);
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(255, 105, 180, 0.6);
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      transform: skewX(-45deg);
      transition: 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(255, 105, 180, 0.9);
    }

    .back-btn {
      background: linear-gradient(135deg, #ff69b4, #ff1493);
      margin-top: 15px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-15px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Admin Login</h2>
    <form action="admin-login.php" method="POST">
      <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
      <input type="email" name="email" placeholder="Email Address" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn">Login</button>
    </form>
    <button class="btn back-btn" onclick="window.location.href='welcome.php'">Back</button>
  </div>
</body>
</html>