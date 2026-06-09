<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit();
}

require 'db.php';

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO services (name, description, price, icon) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $_POST['name'], $_POST['description'], $_POST['price'], $_POST['icon']);
    $stmt->execute();
}

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $stmt = $conn->prepare("UPDATE services SET name=?, description=?, price=?, icon=? WHERE id=?");
    $stmt->bind_param("ssdsi", $_POST['name'], $_POST['description'], $_POST['price'], $_POST['icon'], $_POST['id']);
    $stmt->execute();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM services WHERE id = $id");
}

// Fetch services
$result = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Services</title>
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

    form {
      display: grid;
      gap: 10px;
      margin-bottom: 30px;
    }

    input, textarea, button {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      background-color: #3498db;
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2980b9;
    }

    .service {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    .service:last-child {
      border-bottom: none;
    }

    .service-icon {
      font-size: 20px;
      margin-right: 8px;
      color: #7f8c8d;
    }

    a {
      color: #e74c3c;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
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
    <h2>Add New Service</h2>
    <form method="POST">
      <input name="name" placeholder="Name" required>
      <input name="price" placeholder="Price" required>
      <input name="icon" placeholder="Icon (e.g. 💅, 🧴)">
      <textarea name="description" placeholder="Description"></textarea>
      <button type="submit" name="add">Add Service</button>
    </form>

    <h2>Service List</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="service">
        <form method="POST">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
          <input name="price" value="<?= $row['price'] ?>" required>
          <input name="icon" value="<?= htmlspecialchars($row['icon']) ?>">
          <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea>
          <button type="submit" name="edit">Update</button>
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this service?')">Delete</a>
        </form>
      </div>
    <?php } ?>
  </div>
</body>
</html>