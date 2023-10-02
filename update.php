<?php
include '../config.php';
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['admin_id'])) {
  header('Location: index.php'); // Replace 'login.php' with your login page URL
  exit();
}

if (isset($_GET['updateid'])) {
  $id = $_GET['updateid'];

  // Fetch existing project data from the database
  $sql = "SELECT * FROM `projects` WHERE id='$id'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $title = $row['title'];
    $description = $row['description'];
    $project_type = $row['project_type'];
    $image1 = $row['image1'];
    $image2 = $row['image2'];
    $image3 = $row['image3'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $title = $_POST["title"];
      $description = $_POST["description"];
      $project_type = $_POST["project_type"];

      // Check if new images were selected, otherwise, keep the existing images
      if (!empty($_FILES['image1']['name'])) {
        $image1 = $_FILES['image1']['name'];
        $tmp_name1 = $_FILES['image1']['tmp_name'];
        $uplocation1 = '../img/projects/' . $image1;
        move_uploaded_file($tmp_name1, $uplocation1);
      }

      if (!empty($_FILES['image2']['name'])) {
        $image2 = $_FILES['image2']['name'];
        $tmp_name2 = $_FILES['image2']['tmp_name'];
        $uplocation2 = '../img/projects/' . $image2;
        move_uploaded_file($tmp_name2, $uplocation2);
      }

      if (!empty($_FILES['image3']['name'])) {
        $image3 = $_FILES['image3']['name'];
        $tmp_name3 = $_FILES['image3']['tmp_name'];
        $uplocation3 = '../img/projects/' . $image3;
        move_uploaded_file($tmp_name3, $uplocation3);
      }

      $sql = "UPDATE `projects` SET title='$title', description='$description', image1='$image1', image2='$image2', image3='$image3', project_type='$project_type' WHERE id='$id'";
      $updateResult = mysqli_query($conn, $sql);

      if ($updateResult) {
        header("Location: projectsmanager.php");
        exit();
      } else {
        echo "Error: Project could not be updated.";
      }
    }
  } else {
    echo "Error: Project not found.";
  }
} else {
  echo "Error: 'updateid' not provided in the URL.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Project</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="text-center">Update Project</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?updateid=' . $id; ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
          </div>
          <div class="form-group">
            <label for="image1">Image 1:</label>
            <input type="file" class="form-control" id="image1" name="image1" accept=".jpg, .jpeg, .png">
          </div>
          <div class="form-group">
            <label for="image2">Image 2:</label>
            <input type="file" class="form-control" id="image2" name="image2" accept=".jpg, .jpeg, .png">
          </div>
          <div class="form-group">
            <label for="image3">Image 3:</label>
            <input type="file" class="form-control" id="image3" name="image3" accept=".jpg, .jpeg, .png">
          </div>
          <div class="form-group">
            <label for="project_type">Project Type:</label>
            <input type="text" class="form-control" id="project_type" name="project_type" value="<?php echo $project_type; ?>">
          </div>
          <button type="submit" class="btn btn-primary">Update Project</button>
          <a href="projectsmanager.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>