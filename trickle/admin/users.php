<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit();
}

require 'db.php';

$message = '';

// Handle user creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $role     = $_POST['role'];
    $hash     = password_hash($password, PASSWORD_DEFAULT);

    // Check for duplicate email
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($check) {
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "<p style='color: orange;'>Email already exists!</p>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssss", $name, $email, $hash, $role);
                $stmt->execute();
                $message = "<p style='color: green;'>User added successfully!</p>";
            } else {
                $message = "<p style='color: red;'>Error preparing statement: " . $conn->error . "</p>";
            }
        }
    } else {
        $message = "<p style='color: red;'>Error checking email: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users</title>
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
      gap: 15px;
      margin-bottom: 30px;
    }

    input, select, button {
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

    .user {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    .user:last-child {
      border-bottom: none;
    }

    .user-name {
      font-weight: bold;
      color: #34495e;
    }

    .user-role {
      font-style: italic;
      color: #7f8c8d;
    }

    .user-email {
      color: #555;
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
    <h2>Add New User</h2>
    <?= $message ?>
    <form method="POST">
      <input name="name" placeholder="Name" required>
      <input name="email" placeholder="Email" type="email" required>
      <input name="password" placeholder="Password" type="password" required>
      <select name="role">
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
      </select>
      <button type="submit">Add User</button>
    </form>

    <h2>User List</h2>
    <?php
    $result = $conn->query("SELECT id, name, email, role FROM users ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<div class='user'>
                <p class='user-name'>{$row['name']}</p>
                <p class='user-role'>Role: {$row['role']}</p>
                <p class='user-email'>Email: {$row['email']}</p>
              </div>";
    }
    ?>
  </div>
</body>
</html>