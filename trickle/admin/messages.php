<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit();
}

require 'db.php';

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM messages WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM messages WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? ORDER BY created_at DESC");
    $like = "%$search%";
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Messages</title>
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

    .message {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    .message:last-child {
      border-bottom: none;
    }

    .sender {
      font-weight: bold;
      color: #34495e;
    }

    .email {
      font-size: 14px;
      color: #7f8c8d;
    }

    .subject {
      font-style: italic;
      color: #2c3e50;
    }

    .text {
      margin-top: 5px;
      line-height: 1.6;
    }

    form {
      margin-top: 10px;
    }

    button {
      padding: 6px 12px;
      background-color: #e74c3c;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #c0392b;
    }

    .search-bar {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
    }

    .search-bar input {
      flex: 1;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .search-bar button {
      background-color: #3498db;
    }

    .search-bar button:hover {
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
    <h2>Inbox</h2>

    <form method="GET" class="search-bar">
      <input type="text" name="search" placeholder="Search by name, email, or subject..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Search</button>
    </form>

    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="message">
        <p class="sender"><?= htmlspecialchars($row['name']) ?> <span class="email">(&lt;<?= htmlspecialchars($row['email']) ?>&gt;)</span></p>
        <?php if (!empty($row['subject'])): ?>
          <p class="subject">Subject: <?= htmlspecialchars($row['subject']) ?></p>
        <?php endif; ?>
        <p class="text"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

        <form method="POST">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button type="submit" name="delete">Delete</button>
        </form>
      </div>
    <?php } ?>
  </div>
</body>
</html>