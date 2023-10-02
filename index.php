<?php
include '../config.php';

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Perform a SELECT query to check if the provided email exists in the 'admins' table
  $query = "SELECT * FROM admins WHERE email = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (!$result) {
    die("Query failed: " . mysqli_error($conn));
  }

  if (mysqli_num_rows($result) > 0) {
    // Admin with the provided email exists, fetch the data
    $admin_data = mysqli_fetch_assoc($result);

    // Verify the password
    if (password_verify($password, $admin_data['password'])) {
      // Password is correct, log in the admin
      session_start();
      $_SESSION['admin_id'] = $admin_data['id'];
      $_SESSION['admin_email'] = $admin_data['email'];

      // Redirect to the admin dashboard or another admin page
      header('location: projectsmanager.php');
      exit();
    } else {
      // Password is incorrect
      $error_message = "Invalid password.";
    }
  } else {
    // Admin with the provided email doesn't exist
    $error_message = "Admin with this email does not exist.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Include your custom CSS styles here -->
  <style>
    body {
      background-color: #f4f4f4;
    }

    .login-container {
      margin-top: 100px;
    }
  </style>
</head>

<body>
  <div class="container login-container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Admin Login</h3>
          </div>
          <div class="card-body">
            <?php
            if (isset($error_message)) {
              echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
            ?>
            <form method="POST">
              <div class="form-group">
                <label for="adminEmail">Email</label>
                <input type="email" name="email" class="form-control" id="adminEmail" placeholder="Enter email" required>
              </div>
              <div class="form-group">
                <label for="adminPassword">Password</label>
                <input type="password" name="password" class="form-control" id="adminPassword" placeholder="Enter password" required>
              </div>
              <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
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