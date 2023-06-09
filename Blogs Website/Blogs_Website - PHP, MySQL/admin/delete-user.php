<?php

require '../config/database.php';

if (isset($_GET['id'])) {
  // fetch targeted user avatar from database
  $targetUserID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT firstname, lastname, avatar FROM users WHERE id = $targetUserID";
  $result = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($result);

  if (mysqli_num_rows($result) == 1) {
    // delete the user avatar
    $avatar = $user['avatar'];
    $avatarPath = '../images/' . $avatar;
    // delete image if it is exist
    if ($avatarPath) {
      unlink($avatarPath);
    }
  }

  // fetch all images of user's posts and delete them.
  $fetch_images_query = "SELECT `image` FROM posts
                          WHERE author = $targetUserID";
  $fetch_images_query_result = mysqli_query($connection, $fetch_images_query);
  while ($image = mysqli_fetch_assoc($fetch_images_query_result)) {
    $imagePath = '../images/' . $image['image'];
    if ($imagePath) {
      unlink($imagePath);
    }
  }

  // delete user posts
  $delete_posts_query = "DELETE FROM posts
                          WHERE author = $targetUserID";
  $delete_posts_query_result = mysqli_query($connection, $delete_posts_query);


  // delete user from database
  $delete_query = "DELETE FROM users WHERE id = $targetUserID";
  $delete_result = mysqli_query($connection, $delete_query);
  if (mysqli_errno($connection)) {
    $_SESSION['operation-failed'] = "couldn't delete '{$user['firstname']} {$user['lastname']}'.";
  } else {
    $_SESSION['operation-success'] = "'{$user['firstname']} {$user['lastname']}' has been deleted successfully.";
  }
}

header('Location: ' . ROOT_URL . 'admin/manage-user.php');
die();
