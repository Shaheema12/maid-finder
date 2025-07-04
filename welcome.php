<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
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

    h1 {
      margin-bottom: 30px;
      color: #ff69b4;
      font-weight: 600;
    }

    .buttons {
      margin-top: 30px;
    }

    button {
      padding: 12px 22px;
      margin: 10px;
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
      width: 200px;
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
    }

    button:hover::before {
      left: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to Maid Management System</h1>
    <div class="buttons">
      <button onclick="window.location.href='login.php'">Login</button>
      <button onclick="window.location.href='signup.php'">Sign Up</button>
    </div>
  </div>
</body>
</html>