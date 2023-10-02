<?php
include '../config.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_email'])) {
  // Redirect to the login page if not logged in
  header('location: index.php');
  exit();
}
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

  // Check if the email already exists in the 'admins' table
  $check_query = "SELECT * FROM admins WHERE email = ?";
  $stmt = mysqli_prepare($conn, $check_query);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $error_message = "Email already exists. Please choose a different email.";
  } else {
    // Insert the new admin data into the 'admins' table
    $insert_query = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
      // Registration successful, redirect to login page
      header('location: projectsmanager.php');
      exit();
    } else {
      $error_message = "Admin registration failed: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Include your custom CSS styles here -->
  <style>
    body {
      background-color: #f4f4f4;
    }

    .registration-container {
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <div class="container registration-container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Admin Registration</h3>
          </div>
          <div class="card-body">
            <?php
            if (isset($error_message)) {
              echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
            ?>
            <form method="POST">
              <div class="form-group">
                <label for="adminName">Name</label>
                <input type="text" name="name" class="form-control" id="adminName" placeholder="Enter your name" required>
              </div>
              <div class="form-group">
                <label for="adminEmail">Email</label>
                <input type="email" name="email" class="form-control" id="adminEmail" placeholder="Enter your email" required>
              </div>
              <div class="form-group">
                <label for="adminPassword">Password</label>
                <input type="password" name="password" class="form-control" id="adminPassword" placeholder="Enter your password" required>
              </div>
              <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>