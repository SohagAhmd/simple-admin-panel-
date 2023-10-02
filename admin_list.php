<?php
include '../config.php'; // Include your database connection code

// Check if the user is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('location: index.php'); // Redirect to the login page if not logged in
  exit();
}

// Function to remove an admin by ID
function removeAdmin($adminId)
{
  global $conn;
  $deleteQuery = "DELETE FROM admins WHERE id = ?";
  $stmt = mysqli_prepare($conn, $deleteQuery);
  mysqli_stmt_bind_param($stmt, 'i', $adminId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Function to update an admin's password by ID
function updatePassword($adminId, $newPassword)
{
  global $conn;
  $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  $updateQuery = "UPDATE admins SET password = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $updateQuery);
  mysqli_stmt_bind_param($stmt, 'si', $hashedPassword, $adminId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Fetch admin data from the database
$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['remove'])) {
    $adminIdToRemove = $_POST['remove'];
    removeAdmin($adminIdToRemove);
    header('location: admin_list.php'); // Refresh the page after removing an admin
    exit();
  }

  foreach ($_POST as $key => $value) {
    if (strpos($key, 'submit_update_') !== false) {
      $adminIdToUpdate = $_POST['update'];
      $newPassword = $_POST['new_password_' . $adminIdToUpdate];
      updatePassword($adminIdToUpdate, $newPassword);
      // Add a session variable to indicate password update success
      $_SESSION['password_updated'] = true;
      header('location: admin_list.php#password-updated'); // Redirect to the page with the modal anchor
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin List</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h1>Admin List</h1>
    <a href="projectsmanager.php" class="btn btn-primary mt-2 mb-2">Back</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['email'] . "</td>";
          echo '<td>
                  <input type="password" id="password_' . $row['id'] . '" value="********" readonly>
                  <button type="button" class="btn btn-primary btn-sm" onclick="showPassword(' . $row['id'] . ')">Show</button>
                </td>';
          echo '<td>
                  <form method="POST">
                    <input type="hidden" name="remove" value="' . $row['id'] . '">
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                  </form>
                  <form method="POST">
                    <input type="hidden" name="update" value="' . $row['id'] . '">
                    <input type="password" name="new_password_' . $row['id'] . '" placeholder="New Password" required>
                    <button type="submit" name="submit_update_' . $row['id'] . '" class="btn btn-primary btn-sm">Update Password</button>
                  </form>
                </td>';
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
    <!-- Modal for password update success -->
    <?php if (isset($_SESSION['password_updated']) && $_SESSION['password_updated'] === true) : ?>
      <div class="alert alert-success" role="alert">
        Password updated successfully.
      </div>
      <?php unset($_SESSION['password_updated']); ?>
    <?php endif; ?>
  </div>

  <!-- Include Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function showPassword(adminId) {
      var passwordField = document.getElementById('password_' + adminId);
      passwordField.type = 'text';
    }
  </script>
</body>

</html>