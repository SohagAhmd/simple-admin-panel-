<?php
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['admin_id'])) {
  header('Location: index.php'); // Replace 'login.php' with your login page URL
  exit();
}
require '../config.php';
if (isset($_GET['deleteid'])) {
  $id = $_GET['deleteid'];
  $sql = 'delete from `projects` where id=' . $id . '';
  mysqli_query($conn, $sql);
  header('location:projectsmanager.php');
}
