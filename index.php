<?php
session_start();
include 'trickle/admin/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// If already logged in, redirect to dashboard
if (isset($_SESSION['email'])) {
    header("Location: trickle/admin/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $dbEmail, $dbHashedPass);
        $stmt->fetch();

        if (password_verify($password, $dbHashedPass)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $dbEmail;
            header("Location: trickle/admin/dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials.')</script>";
        }
    } else {
        echo "<script>alert('User not found.')</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In</title>
  <link rel='stylesheet' href='style.css'>
  
  <style>
	.button:disabled {
	  opacity: 0.6;
	  cursor: not-allowed;
	}
	
	 body{
		  background-image: url('img/background.png'); /* adjust path as needed */
		  background-size: cover;
		  background-repeat: no-repeat;
		  background-position: center center;
		  background-attachment: fixed;
		  margin: 0;
		  padding: 0;
	  }
  </style>
  
</head>
<body>

  <div class="signin-box">
    <h2>Sign In</h2>
    <form action="" method="POST" onclick>
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="email address" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="password" required />

      <button type="submit" class="button">Sign In</button>
      <a href="trickle/Sandha`s_Beauty_Bar.php">Customer Site!</a>
  </div>

</body>
</html>