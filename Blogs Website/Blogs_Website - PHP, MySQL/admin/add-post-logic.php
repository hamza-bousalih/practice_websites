<?php

require '../config/database.php';

if (isset($_POST['submit'])) {

  $authorId = $_SESSION['userId'];

  // get form data
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
  $image = $_FILES['image'];

  if (isset($_SESSION['user_is_admin'])) {
    $isFeatured = filter_var($_POST['isFeatured'], FILTER_SANITIZE_NUMBER_INT);
    // set isFeatured to 0 if unchecked
    $isFeatured = $isFeatured ? 1 : 0;
  }

  // validate form data
  if (!$title) {
    $_SESSION['add-post'] = 'Enter Post Title';
  } elseif (!$categoryId) {
    $_SESSION['add-post'] = 'Select Post category ';
  } elseif (!$body) {
    $_SESSION['add-post'] = 'Enter Post Body';
  } elseif (!$image['name']) {
    $_SESSION['add-post'] = 'Enter Post Image';
  } else {

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
        $_SESSION['add-post'] = 'File size too big, should be less then 2MB.';
      }
    } else {
      $_SESSION['add-post'] = "file should be 'png', 'jpg' or 'jpeg'.";
    }
  }

  // Redirect to add post page with form data if there was invalid input
  if (isset($_SESSION['add-post'])) {
    $_SESSION['add-post-data'] = $_POST;
    header('Location: ' . ROOT_URL . '/admin/add-post.php');
    die();
  } else {
    // set is_featured of all to 0 if is_featured for this post is one
    if ($isFeatured) {
      $featured_to_zero_forAll_query = "UPDATE posts SET is_featured = 0 WHERE is_featured = 1";
      $featured_to_zero_forAll_result = mysqli_query($connection, $featured_to_zero_forAll_query);
    }

    // insert post into database
    $query = "INSERT INTO posts (title, body, `image`, category, author,is_featured ) 
              VALUES ('$title','$body','$image_name',' $categoryId','$authorId','$isFeatured' )";
    $result = mysqli_query($connection, $query);

    if (!mysqli_errno($connection)) {
      $_SESSION['operation-success'] = 'new post added successfully';
      header('Location: ' . ROOT_URL . 'admin/');
      die();
    }
  }
} else {
  header('Location: ' . ROOT_URL . '/admin/add-post.php');
  die();
}
