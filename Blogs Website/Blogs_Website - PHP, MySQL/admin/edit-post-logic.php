<?php

require '../config/database.php';

// make sure edit post button was clocked
if (isset($_POST['submit'])) {
  $postId = filter_var($_POST['postId'], FILTER_SANITIZE_NUMBER_INT);
  $previousImage = filter_var($_POST['previousImage'], FILTER_SANITIZE_SPECIAL_CHARS);
  $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
  $body = filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS);
  $image = $_FILES['image'];
  $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

  $isFeatured = 0;
  // set isFeatured to 1 if it was checked just if the user is admin
  if (isset($_SESSION['user_is_admin']) && isset($_POST['isFeatured'])) {
    $isFeatured = filter_var($_POST['isFeatured'], FILTER_SANITIZE_NUMBER_INT);
  }

  if (!$title) {
    $_SESSION['edit-post'] = 'Enter Post Title';
  } elseif (!$categoryId) {
    $_SESSION['edit-post'] = 'Select Post category ';
  } elseif (!$body) {
    $_SESSION['edit-post'] = 'Enter Post Body';
  } else {
    // delete existing post image if new image available
    if ($image['name']) {
      $previousImage_path = '../images/' . $previousImage;
      if ($previousImage_path) {
        unlink($previousImage_path);
      }

      // Work in new image
      $time = time();
      $image_name = $time . $image['name'];
      $image_tmp_name = $image['tmp_name'];
      $image_destination_path = "../images/" . $image_name;

      // make sure the file is image
      $allowed_files = ['png', 'jpg', 'jpeg'];
      $extension = explode('.', $image_name);
      $extension = end($extension);
      if (in_array($extension, $allowed_files)) {
        // make sure the image size not to large (2mb+);
        if ($image['size'] < 2_000_000) {
          // upload image
          move_uploaded_file($image_tmp_name, $image_destination_path);
        } else {
          $_SESSION['edit-post'] = 'File size too big, should be less then 2MB.';
        }
      } else {
        $_SESSION['edit-post'] = "file should be 'png', 'jpg' or 'jpeg'.";
      }
    }
  }

  // Redirect to edit post page with form data if there was invalid input
  if (isset($_SESSION['edit-post'])) {
    $_SESSION['edit-post-data'] = $_POST;
    header('Location: ' . ROOT_URL . '/admin/edit-post.php');
    die();
  } else {
    // set is_featured of all to 0 if is_featured for this post is one
    if ($isFeatured) {
      $featured_to_zero_forAll_query = "UPDATE posts SET is_featured = 0 WHERE is_featured = 1";
      $featured_to_zero_forAll_result = mysqli_query($connection, $featured_to_zero_forAll_query);
    }

    // set image name if a new was uploaded, else keep the old name
    $image_to_insert = $image_name ?? $previousImage;

    // insert post into database
    $query = "UPDATE posts 
              SET title='$title', 
                  body='$body',
                  `image`='$image_to_insert', 
                  category=' $categoryId',
                  is_featured='$isFeatured'
              WHERE id = '$postId'";
    $result = mysqli_query($connection, $query);

    if (!mysqli_errno($connection)) {
      $_SESSION['operation-success'] = 'the post has been updated successfully.';
    } else {
      $_SESSION['operation-failed'] = 'failed to update the post!';
    }
  }
}

header('Location: ' . ROOT_URL . 'admin/');
die();
