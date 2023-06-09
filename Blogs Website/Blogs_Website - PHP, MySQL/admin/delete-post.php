<?php

require '../config/database.php';

if (isset($_GET['id'])) {
  // fetch targeted post from database
  $targetPostID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  $query = "SELECT `image` FROM posts WHERE id = $targetPostID";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) == 1) {
    // delete the post image if it is exist
    $image_name = mysqli_fetch_assoc($result)['image'];
    $imagePath = '../images/' . $image_name;
    if ($imagePath) {
      unlink($imagePath);

      // delete targeted post
      $query = "DELETE FROM posts WHERE id = $targetPostID LIMIT 1";
      $result = mysqli_query($connection, $query);
      if (!mysqli_errno($connection)) {
        $_SESSION['operation-success'] = "the post has been deleted successfully.";
      }
    } else {
      $_SESSION['operation-failed'] = "couldn't delete the post!";
    }
  }
}

header('Location: ' . ROOT_URL . 'admin/');
die();
