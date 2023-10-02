<?php
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['admin_id'])) {
  header('Location: index.php'); // Replace 'login.php' with your login page URL
  exit();
}
include '../config.php';

// Check if the form is submitted to delete a record
if (isset($_GET['deleteid'])) {
  $deleteId = $_GET['deleteid'];
  $deleteQuery = "DELETE FROM client_email WHERE id = $deleteId";
  $deleteResult = mysqli_query($conn, $deleteQuery);
  if ($deleteResult) {
    // Redirect to the same page after successful deletion
    header("Location: email.php");
    exit();
  } else {
    echo "Error: Record could not be deleted.";
  }
}

// Query to fetch data from the client_email table
$sql = "SELECT id, name, email, message FROM client_email";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Emails</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center">Client Emails</h1>
    <!-- Add a button to redirect to the mail page -->
    <a href="projectsmanager.php" class="btn btn-primary mb-3">back</a>

    <!-- Display client emails -->
    <table class="table mt-4 mr-5 table-striped table-bordered table-hover">
      <thead class="table-info">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Email No</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Message</th>
          <th scope="col">Operations</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <?php
        $i = 1;
        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $message = $row['message'];

            echo '<tr>
                            <th scope="row">' . $i++ . '</th>
                            <td>' . $id . '</td>
                            <td>' . $name . '</td>
                            <td>' . $email . '</td>
                            <td>';

            // Check message length
            if (strlen($message) <= 20) {
              echo $message;
            } else {
              // If message length is greater than 20, display first 20 characters and a "Read More" button
              echo substr($message, 0, 20) . '... ';
              echo '<button class="btn btn-link" onclick="showFullMessage(\'' . $message . '\')">Read More</button>';
            }

            echo '</td>
                            <td>
                                <button class="btn btn-danger" onclick="deleteRecord(' . $id . ')">Delete</button>
                                <button class="btn btn-primary" onclick="replyEmail(\'' . $email . '\')">Reply</button>
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
        window.location.href = "email.php?deleteid=" + recordId;
      }
    }

    // JavaScript function to handle reply operation
    function replyEmail(email) {
      // Implement your reply logic here
      alert("Reply to: " + email);
    }

    // JavaScript function to show the full message
    function showFullMessage(message) {
      alert(message); // You can replace this with a modal or other UI for displaying the full message
    }
  </script>
</body>

</html>