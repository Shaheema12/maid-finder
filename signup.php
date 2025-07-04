<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all fields!";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);
            
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            header('Location: maid-details.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Maid Signup</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      overflow: hidden;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      background: #000;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: url('https://images.unsplash.com/photo-1622559352039-3f2f2ec51a70?auto=format&fit=crop&w=1470&q=80') no-repeat center center;
      background-size: cover;
      filter: brightness(0.4);
      z-index: 0;
      animation: zoomPan 30s ease-in-out infinite;
    }

    body::after {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(255, 20, 147, 0.3);
      mix-blend-mode: multiply;
      z-index: 1;
      pointer-events: none;
    }

    @keyframes zoomPan {
      0% { transform: scale(1) translate(0, 0); }
      50% { transform: scale(1.1) translate(10px, 10px); }
      100% { transform: scale(1) translate(0, 0); }
    }

    .container {
      position: relative;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      padding: 30px 25px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(255, 20, 147, 0.6);
      width: 320px;
      text-align: center;
      z-index: 10;
    }

    h2 {
      margin-bottom: 25px;
      color: #ff69b4;
      font-weight: 600;
    }

    input {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      font-size: 15px;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 8px;
      color: #fff;
      transition: background 0.3s ease;
      position: relative;
      z-index: 11;
    }

    input::placeholder {
      color: #ccc;
    }

    input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.25);
    }

    .buttons {
      margin-top: 20px;
      position: relative;
      z-index: 11;
    }

    button {
      padding: 12px 22px;
      margin: 5px;
      cursor: pointer;
      background: linear-gradient(135deg, #ff1493, #ff69b4);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      box-shadow: 0 0 10px rgba(255, 105, 180, 0.5);
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
      z-index: 11;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(255, 105, 180, 0.8);
    }

    button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      transform: skewX(-45deg);
      transition: 0.5s;
      z-index: 12;
    }

    button:hover::before {
      left: 100%;
    }

    .error {
      color: #ff4d6d;
      font-size: 0.9rem;
      margin-top: -8px;
      margin-bottom: 10px;
      height: 18px;
      position: relative;
      z-index: 11;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Maid Signup</h2>
    <form id="loginForm" method="POST" action="signup.php">
      <input type="text" id="name" name="name" placeholder="Full Name" required /><br />
      <input type="email" id="email" name="email" placeholder="Email Address" required /><br />
      <input type="password" id="password" name="password" placeholder="Password (min 8 characters)" required /><br />
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required /><br />
      <p id="errorText" class="error"><?php echo htmlspecialchars($error); ?></p>
      <div class="buttons">
        <button type="submit">Sign Up</button>
        <button type="button" onclick="window.location.href='welcome.php'">Back</button>
      </div>
      <p style="margin-top: 15px; color: #ccc; font-size: 0.9rem;">
        Already have an account? <a href="login.php" style="color: #ff69b4;">Login</a>
      </p>
    </form>
  </div>
</body>
</html>