<?php
session_start();
require 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Maid Finder</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      background: #f5f5f5;
      color: #333;
    }

    .admin-header {
      background: linear-gradient(135deg, #ff1493, #ff69b4);
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .admin-header h1 {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .admin-nav {
      display: flex;
      gap: 1rem;
    }

    .admin-nav a {
      color: white;
      text-decoration: none;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .admin-nav a:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    .dashboard-container {
      display: flex;
      min-height: calc(100vh - 60px);
    }

    .sidebar {
      width: 250px;
      background: white;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
      padding: 1.5rem 0;
    }

    .sidebar-menu {
      list-style: none;
    }

    .sidebar-menu li a {
      display: block;
      padding: 0.8rem 1.5rem;
      color: #555;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .sidebar-menu li a:hover {
      background: #ff69b4;
      color: white;
    }

    .sidebar-menu li a.active {
      background: #ff1493;
      color: white;
    }

    .main-content {
      flex: 1;
      padding: 2rem;
      background: #f9f9f9;
    }

    .welcome-message {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
    }

    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      text-align: center;
    }

    .stat-card h3 {
      color: #ff69b4;
      margin-bottom: 0.5rem;
    }

    .stat-card p {
      font-size: 2rem;
      font-weight: 600;
      color: #333;
    }

    .recent-activity {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .recent-activity h2 {
      margin-bottom: 1rem;
      color: #ff69b4;
    }

    .activity-list {
      list-style: none;
    }

    .activity-list li {
      padding: 0.8rem 0;
      border-bottom: 1px solid #eee;
    }

    .activity-list li:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>
  <header class="admin-header">
    <h1>Maid Finder Admin Dashboard</h1>
    <nav class="admin-nav">
      <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="dashboard-container">
    <aside class="sidebar">
      <ul class="sidebar-menu">
        <li><a href="admin-home.php" class="active">Dashboard</a></li>
        <li><a href="manage-maids.php">Manage Maids</a></li>
        <li><a href="manage-users.php">Manage Users</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="settings.php">Settings</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <section class="welcome-message">
        <h2>Welcome to your Dashboard</h2>
        <p>Here you can manage all aspects of the Maid Finder system.</p>
      </section>

      <div class="stats-container">
        <div class="stat-card">
          <h3>Total Maids</h3>
          <p>127</p>
        </div>
        <div class="stat-card">
          <h3>Active Users</h3>
          <p>342</p>
        </div>
        <div class="stat-card">
          <h3>New Bookings</h3>
          <p>24</p>
        </div>
        <div class="stat-card">
          <h3>Revenue</h3>
          <p>$12,345</p>
        </div>
      </div>

      <section class="recent-activity">
        <h2>Recent Activity</h2>
        <ul class="activity-list">
          <li>New maid registration: Jane Doe</li>
          <li>User John Smith booked a maid</li>
          <li>Payment received from Sarah Johnson</li>
          <li>New review submitted by Michael Brown</li>
          <li>System update completed</li>
        </ul>
      </section>
    </main>
  </div>
</body>
</html>