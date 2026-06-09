<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit();
}

require 'db.php';

// Update booking status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $newStatus = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->bind_param("si", $newStatus, $id);
    $stmt->execute();
}

// Reschedule booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reschedule'])) {
    $id = $_POST['id'];
    $newDate = $_POST['date'];
    $newTime = $_POST['time'];

    $stmt = $conn->prepare("UPDATE bookings SET date=?, time=?, status='reviewing' WHERE id=?");
    $stmt->bind_param("ssi", $newDate, $newTime, $id);
    $stmt->execute();
}

$result = $conn->query("SELECT b.*, s.name AS service_name FROM bookings b LEFT JOIN services s ON b.service_id = s.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bookings</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f8;
      color: #333;
    }

    header {
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    h2 {
      margin-bottom: 20px;
      font-size: 22px;
      color: #2c3e50;
    }

    .booking {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    .booking:last-child {
      border-bottom: none;
    }

    .status {
      font-weight: bold;
      color: #3498db;
    }

    form {
      margin-top: 10px;
      display: grid;
      gap: 10px;
    }

    input, select, button {
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      background-color: #3498db;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #2980b9;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #2c3e50;
      padding: 15px 30px;
      color: white;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .navbar-brand {
      font-size: 18px;
      font-weight: bold;
    }

    .navbar-menu {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    .navbar-menu li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar-menu li a:hover {
      color: #1abc9c;
    }

    @media (max-width: 600px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .navbar-menu {
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="navbar-brand">Welcome, <?= $_SESSION['email'] ?></div>
      <ul class="navbar-menu">
        <li><a href="products.php">Products</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="bookings.php">Bookings</a></li>
        <li><a href="messages.php">Messages</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <h2>Recent Bookings</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="booking">
        <p><strong><?= $row['name'] ?></strong> booked <strong><?= $row['service_name'] ?></strong></p>
        <p>Date: <?= $row['date'] ?> | Time: <?= $row['time'] ?></p>
        <p>Status: <span class="status"><?= $row['status'] ?></span></p>

        <!-- Status Update Form -->
        <form method="POST">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <select name="status" required>
            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= $row['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="cancelled" <?= $row['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            <option value="reviewing" <?= $row['status'] === 'reviewing' ? 'selected' : '' ?>>Reviewing</option>
          </select>
          <button type="submit" name="update_status">Update Status</button>
        </form>

        <!-- Reschedule Form -->
        <form method="POST">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="date" name="date" value="<?= $row['date'] ?>" required>
          <input type="time" name="time" value="<?= $row['time'] ?>" required>
          <button type="submit" name="reschedule">Reschedule</button>
        </form>
      </div>
    <?php } ?>
  </div>
</body>
</html>