<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Maid Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f0f5;
      margin: 0;
      padding: 20px;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    .maid-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 20px auto;
      display: flex;
      align-items: center;
      padding: 15px;
    }
    .maid-photo {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 20px;
    }
    .maid-info p {
      margin: 6px 0;
      color: #333;
    }
    .maid-info p strong {
      color: #555;
    }
  </style>
</head>
<body>

<h1>Maid Submissions</h1>

<?php
$file = 'maids.json';

if (file_exists($file)) {
    $maids = json_decode(file_get_contents($file), true);

    if (!empty($maids)) {
        foreach ($maids as $maid) {
            echo '<div class="maid-card">';
            echo '<img class="maid-photo" src="' . htmlspecialchars($maid['photo']) . '" alt="Maid Photo">';
            echo '<div class="maid-info">';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($maid['name']) . '</p>';
            echo '<p><strong>Age:</strong> ' . htmlspecialchars($maid['age']) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($maid['email']) . '</p>';
            echo '<p><strong>Salary:</strong> ₹' . htmlspecialchars($maid['salary']) . '</p>';
            echo '<p><strong>Location:</strong> ' . htmlspecialchars($maid['location']) . '</p>';
            echo '</div></div>';
        }
    } else {
        echo "<p style='text-align:center;'>No maid details available.</p>";
    }
} else {
    echo "<p style='text-align:center;'>No data submitted yet.</p>";
}
?>

</body>
</html>
