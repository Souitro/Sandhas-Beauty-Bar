<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit();
}

require 'db.php';

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = "../components/img/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $desc, $price, $category, $imageName);
    $stmt->execute();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
}

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $imageName = $_POST['existing_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = "../components/img/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, image_url=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $desc, $price, $category, $imageName, $id);
    $stmt->execute();
}

// Handle Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM products";
if ($search) {
    $query .= " WHERE name LIKE '%$search%'";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products</title>
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

    input, select, textarea, button {
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

    .product {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    .product img {
      max-width: 100px;
      margin-bottom: 10px;
      border-radius: 4px;
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
    <h2>Add New Product</h2>
    <form method="POST" enctype="multipart/form-data">
      <input name="name" placeholder="Name" required>
      <input name="price" placeholder="Price" required>
      <select name="category">
        <option value="nails">Nails</option>
        <option value="perfumes">Perfumes</option>
      </select>
      <input type="file" name="image" accept="image/*">
      <textarea name="description" placeholder="Description"></textarea>
      <button type="submit" name="add">Add Product</button>
    </form>

    <h2>Search Products</h2>
    <form method="GET">
      <input name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Search</button>
    </form>

    <h2>Product List</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="product">
        <?php if ($row['image_url']) { ?>
          <img src="../components/img/<?= $row['image_url'] ?>" alt="Product Image">
        <?php } ?>
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="hidden" name="existing_image" value="<?= $row['image_url'] ?>">
          <input name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
          <input name="price" value="<?= $row['price'] ?>" required>
          <select name="category">
            <option value="nails" <?= $row['category'] === 'nails' ? 'selected' : '' ?>>Nails</option>
            <option value="perfumes" <?= $row['category'] === 'perfumes' ? 'selected' : '' ?>>Perfumes</option>
          </select>
          <input type="file" name="image" accept="image/*">
          <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea>
          <button type="submit" name="edit">Update</button>
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </form>
      </div>
    <?php } ?>
 