<?php
include '../config.php';
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['admin_id'])) {
  header('Location: index.php'); // Replace 'login.php' with your login page URL
  exit();
}

// Check if the delete button is clicked
if (isset($_GET['deleteid'])) {
  $deleteId = $_GET['deleteid'];

  // Perform the delete operation here
  $deleteSql = "DELETE FROM subscribe_email WHERE id = '$deleteId'";
  $deleteResult = mysqli_query($conn, $deleteSql);

  if ($deleteResult) {
    // Redirect to the subscription page after deleting
    header("Location: subscription.php");
    exit();
  } else {
    echo "Error: Unable to delete the record.";
  }
}

// Fetch subscription emails
$sql = "SELECT * FROM subscribe_email";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscription Emails</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <a href="projectsmanager.php" class="btn btn-primary mb-3">back</a>
    <h1 class="text-center">Subscription Emails</h1>
    <!-- Display subscription emails -->
    <table class="table mt-4 mr-5 table-striped table-bordered table-hover">
      <thead class="table-info">
        <tr>
          <th scope="col">Email ID</th>
          <th scope="col">Email</th>
          <th scope="col">Operations</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php
        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $email = $row['email'];

            echo '<tr>
                                <th scope="row">' . $id . '</th>
                                <td>' . $email . '</td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteRecord(' . $id . ')">Delete</button>
                                    <button class="btn btn-primary" onclick="sendEmail(\'' . $email . '\')">Send Email</button>
                                </td>
                            </tr>';
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Add Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // JavaScript function to handle delete operation
    function deleteRecord(recordId) {
      if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "subscription.php?deleteid=" + recordId;
      }
    }

    // JavaScript function to handle send email operation
    function sendEmail(email) {
      // Implement your email sending logic here
      alert("Send email to: " + email);
    }
  </script>
</body>

</html>