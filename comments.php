<?php
// Include your database connection code here
include '../config.php';

// Fetch project data from the database (assuming you have a projects table)
$query = "SELECT id, title FROM projects";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// Fetch reviews and their replies for a specific project
function getReviewsWithReplies($conn, $projectId)
{
  $reviewsQuery = "SELECT r.id AS review_id, r.client_name AS reviewer_name, r.review, r.time AS review_time,
                            rp.id AS reply_id, rp.client_name AS replier_name, rp.reply, rp.time AS reply_time
                    FROM reviews r
                    LEFT JOIN replies rp ON r.id = rp.review_id
                    WHERE r.project_id = $projectId
                    ORDER BY r.time DESC, rp.time ASC";
  $reviewsResult = mysqli_query($conn, $reviewsQuery);
  $reviews = [];

  while ($row = mysqli_fetch_assoc($reviewsResult)) {
    $reviewId = $row['review_id'];

    if (!isset($reviews[$reviewId])) {
      $reviews[$reviewId] = [
        'review_id' => $reviewId,
        'reviewer_name' => $row['reviewer_name'],
        'review' => $row['review'],
        'review_time' => $row['review_time'],
        'replies' => []
      ];
    }

    if (!empty($row['reply_id'])) {
      $reviews[$reviewId]['replies'][] = [
        'reply_id' => $row['reply_id'],
        'replier_name' => $row['replier_name'],
        'reply' => $row['reply'],
        'reply_time' => $row['reply_time']
      ];
    }
  }

  return $reviews;
}

// Check if a review or reply should be deleted
if (isset($_POST['delete_review'])) {
  $reviewId = $_POST['review_id'];

  // Check if there are any replies to this review
  $checkRepliesQuery = "SELECT COUNT(*) AS reply_count FROM replies WHERE review_id = ?";
  $stmt = mysqli_prepare($conn, $checkRepliesQuery);
  mysqli_stmt_bind_param($stmt, 'i', $reviewId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  $replyCount = $row['reply_count'];

  if ($replyCount > 0) {
    // Show a message if there are replies associated with the review
    echo "<script>alert('This review has associated replies. Please delete the replies first.')</script>";
  } else {
    // Delete the review if there are no associated replies
    $deleteReviewQuery = "DELETE FROM reviews WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteReviewQuery);
    mysqli_stmt_bind_param($stmt, 'i', $reviewId);

    if (mysqli_stmt_execute($stmt)) {
      // Review deleted successfully
      header('Location: index.php'); // Redirect back to the same page or any other appropriate page
      exit();
    } else {
      // Error occurred while deleting the review, you can handle it here.
      echo "Error: " . mysqli_error($conn);
    }
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
    <!-- Project list table -->
    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          $projectId = $row['id'];
          $reviewsWithReplies = getReviewsWithReplies($conn, $projectId);
        ?>
          <tr>
            <td><?php echo $projectId; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td>
              <!-- Button to update review -->
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateReviewModal<?php echo $projectId; ?>">
                Update Review
              </button>
              <!-- Button to delete review -->
              <form method="POST" class="d-inline">
                <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                <button type="submit" name="delete_review" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">
                  Delete Review
                </button>
              </form>
              <table class="table table-bordered mt-2">
                <thead>
                  <tr>
                    <th>Reviewer</th>
                    <th>Review</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($reviewsWithReplies as $review) {
                  ?>
                    <tr>
                      <td><?php echo $review['reviewer_name']; ?></td>
                      <td><?php echo $review['review']; ?></td>
                      <td>
                        <!-- Button to update reply -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateReplyModal<?php echo $review['reply_id']; ?>">
                          Update Reply
                        </button>
                        <!-- Button to delete reply -->
                        <form method="POST" class="d-inline">
                          <input type="hidden" name="reply_id" value="<?php echo $review['reply_id']; ?>">
                          <button type="submit" name="delete_reply" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reply?');">
                            Delete Reply
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Include Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>