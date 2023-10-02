<?php
include '../config.php'; // Include your database connection code
// Check if the user is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('location: index.php'); // Redirect to the login page if not logged in
  exit();
}
// Fetch project data from the database
$query = "SELECT id, title, description, image1, image2, image3 FROM projects";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// Create an array to store all the project data
$projects = array();

while ($row = mysqli_fetch_assoc($result)) {
  $projects[] = $row;
}

// Check if the form for adding a project is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
  // Process the form data and insert the project into the database

  $title = $_POST['title'];
  $description = $_POST['description'];

  // Handle image uploads
  $imagename1 = $_FILES['image1']['name'];
  $imagename2 = $_FILES['image2']['name'];
  $imagename3 = $_FILES['image3']['name'];
  $temp1 = $_FILES['image1']['tmp_name'];
  $temp2 = $_FILES['image2']['tmp_name'];
  $temp3 = $_FILES['image3']['tmp_name'];
  $up_path = '../img/projects/';

  // Move uploaded images to the destination directory
  if (
    move_uploaded_file($temp1, $up_path . $imagename1) &&
    move_uploaded_file($temp2, $up_path . $imagename2) &&
    move_uploaded_file($temp3, $up_path . $imagename3)
  ) {

    // Insert the project details into the database
    $insertQuery = "INSERT INTO projects (title, description, image1, image2, image3) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'sssss', $title, $description, $imagename1, $imagename2, $imagename3);

    if (mysqli_stmt_execute($stmt)) {
      // Project added successfully, you can redirect or display a success message.
      header('Location: projectsmanager.php');
      exit();
    } else {
      // Error occurred while adding the project, you can handle it here.
      echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
  } else {
    // Handle errors if file uploads fail
    echo "Error uploading files.";
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Project List</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <h1>Project List</h1>
    <div class="btn-group mt-2 mb-2" role="group">
      <!-- Button to trigger "Add Project" modal -->
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProjectModal">Add Project</button>
      <a href="comments.php" class="btn btn-secondary">Comments</a>
      <a href="email.php" class="btn btn-secondary">Email</a>
      <a href="subscription.php" class="btn btn-secondary">Subscriptions</a>
      <a href="makeadmin.php" class="btn btn-secondary">Add Admin</a>
      <a href="admin_list.php" class="btn btn-secondary">Admin List</a>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <!-- Project list table (unchanged) -->
    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Image 1</th>
          <th>Image 2</th>
          <th>Image 3</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($projects as $row) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['title'] . "</td>";

          // Display description with "Read More" button
          $description = $row['description'];
          if (str_word_count($description) > 30) {
            $shortDesc = implode(' ', array_slice(str_word_count($description, 2), 0, 30));
            echo '<td>' . $shortDesc . '... <a href="#" data-toggle="modal" data-target="#descriptionModal' . $row['id'] . '">Read More</a></td>';

            // Create a modal for displaying the full description
            echo '<div class="modal fade" id="descriptionModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel' . $row['id'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog" role="document">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="descriptionModalLabel' . $row['id'] . '">Project Description</h5>';
            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<p>' . $description . '</p>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          } else {
            echo "<td>" . $description . "</td>";
          }

          // Display images with a fixed size of 200x100
          echo '<td><img src="../img/projects/' . $row['image1'] . '" alt="Image 1" class="img-thumbnail" style="width: 200px; height: 100px;"></td>';
          echo '<td><img src="../img/projects/' . $row['image2'] . '" alt="Image 2" class="img-thumbnail" style="width: 200px; height: 100px;"></td>';
          echo '<td><img src="../img/projects/' . $row['image3'] . '" alt="Image 3" class="img-thumbnail" style="width: 200px; height: 100px;"></td>';
          echo '<td>';
          // Add delete button with confirmation dialog
          echo '<a href="delete.php?deleteid=' . $row['id'] . '" class="btn btn-danger btn-sm mb-2 delete-project">Delete</a>';

          // Add update button
          echo '<a href="update.php?updateid=' . $row['id'] . '" class="btn btn-primary btn-sm">Update</a>';
          echo '</td>';
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- "Add Project" Modal -->
  <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form for adding a project -->
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
              <label for="image1">Image 1:</label>
              <input type="file" class="form-control-file" id="image1" name="image1" accept="image/*" required>
            </div>
            <div class="form-group">
              <label for="image2">Image 2:</label>
              <input type="file" class="form-control-file" id="image2" name="image2" accept="image/*" required>
            </div>
            <div class="form-group">
              <label for="image3">Image 3:</label>
              <input type="file" class="form-control-file" id="image3" name="image3" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_project">Add Project</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- "Delete Project" Modal -->
  <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteProjectModalLabel">Delete Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this project?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Include the external JavaScript file -->
  <script src="script.js"></script>

  <script>
    $(document).ready(function() {
      // Add a click event listener to all elements with the class "delete-project"
      $(".delete-project").click(function(e) {
        e.preventDefault(); // Prevent the default behavior of the link
        var deleteLink = $(this).attr("href"); // Get the delete link

        // Set the delete link as the "Delete" button's href
        $("#confirmDelete").attr("href", deleteLink);

        // Show the confirmation dialog
        $("#deleteProjectModal").modal("show");
      });
    });
  </script>
</body>

</html>