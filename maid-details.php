<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle maid details submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $age = $_POST['age'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    
    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            // Save to database
            $stmt = $pdo->prepare("UPDATE users SET age = ?, salary = ?, location = ?, photo = ? WHERE id = ?");
            $stmt->execute([$age, $salary, $location, $targetPath, $_SESSION['user_id']]);
            $success = "Details updated successfully!";
        } else {
            $error = "Error uploading photo!";
        }
    } else {
        // Update without photo
        $stmt = $pdo->prepare("UPDATE users SET age = ?, salary = ?, location = ? WHERE id = ?");
        $stmt->execute([$age, $salary, $location, $_SESSION['user_id']]);
        $success = "Details updated successfully!";
    }
}

// Get user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Maid Details</title>
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
      width: 350px;
      text-align: center;
      z-index: 10;
    }

    h2 {
      margin-bottom: 15px;
      color: #ff69b4;
      font-weight: 600;
    }

    .profile-info {
      margin-bottom: 20px;
    }

    .profile-photo {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #ff69b4;
      margin-bottom: 15px;
    }

    input, select {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 8px;
      color: #fff;
    }

    input::placeholder {
      color: #ccc;
    }

    input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.2);
    }

    .buttons {
      margin-top: 20px;
    }

    button {
      padding: 10px 20px;
      margin: 5px;
      cursor: pointer;
      background: linear-gradient(135deg, #ff1493, #ff69b4);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 0.95rem;
      box-shadow: 0 0 10px rgba(255, 105, 180, 0.5);
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
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

    .success {
      color: #4dff88;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }

    .error {
      color: #ff4d6d;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="profile-info">
      <?php if (!empty($user['photo'])): ?>
        <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile Photo" class="profile-photo">
      <?php else: ?>
        <div style="width: 100px; height: 100px; border-radius: 50%; background: #ff69b4; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
          <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
        </div>
      <?php endif; ?>
      <h2><?php echo htmlspecialchars($user['name']); ?></h2>
      <p><?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <?php if (isset($success)): ?>
      <p class="success"><?php echo $success; ?></p>
    <?php elseif (isset($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="maid-details.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="photo" accept="image/*"><br />
      <input type="number" name="age" placeholder="Age" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>" required><br />
      <input type="number" name="salary" placeholder="Expected Salary (INR)" value="<?php echo htmlspecialchars($user['salary'] ?? ''); ?>" required><br />
      <input type="text" name="location" placeholder="Location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>" required><br />
      <div class="buttons">
        <button type="submit">Save Details</button>
        <button type="button" onclick="window.location.href='logout.php'">Logout</button>
      </div>
    </form>
  </div>
</body>
</html>