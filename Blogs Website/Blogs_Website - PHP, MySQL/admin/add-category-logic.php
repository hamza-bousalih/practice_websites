<?php

require '../config/database.php';

if (isset($_POST['submit'])) {
  // get form data
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if (!$title) {
    $_SESSION['add-category'] = 'Enter Title';
  } elseif (!$description) {
    $_SESSION['add-category'] = 'Enter Description';
  }

  // Redirect to add category page with form data if there was invalid input
  if (isset($_SESSION['add-category'])) {
    $_SESSION['add-category-data'] = $_POST;
    header('Location: ' . ROOT_URL . '/admin/add-category.php');
    die();
  } else {

    // check if the category exist in database
    $check_query = "SELECT * FROM categories WHERE title = '$title'";
    $check_result = mysqli_query($connection, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
      $_SESSION['operation-failed'] = "'$title' Category already exist!";
      header('Location: ' . ROOT_URL . '/admin/manage-category.php');
      die();
    }

    // insert category to database
    $query = "INSERT INTO `categories` (`title`,`description`) VALUES ('$title', '$description')";
    $result = mysqli_query($connection, $query);
    if (mysqli_errno($connection)) {
      $_SESSION['add-category'] = "couldn't add category";
      header('Location: ' . ROOT_URL . '/admin/add-category.php');
      die();
    } else {
      $_SESSION['operation-success'] = "category '$title' added successfully";
      header('Location: ' . ROOT_URL . '/admin/manage-category.php');
      die();
    }
  }
} else {
  header('Location: ' . ROOT_URL . '/admin/add-category.php');
  die();
}
