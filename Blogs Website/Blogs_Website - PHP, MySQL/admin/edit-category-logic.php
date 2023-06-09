<?php

require '../config/database.php';

if (isset($_POST['submit'])) {
  $targetId = filter_var($_POST['targetId'], FILTER_SANITIZE_NUMBER_INT);
  $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);

  // check for valid input
  if (!$title) {
    $_SESSION['edit-category'] = 'Enter Title!';
  } else if (!$description) {
    $_SESSION['edit-category'] = 'Enter Description!';
  } else {
    // update the category
    $query = "UPDATE categories SET title = '$title', `description` = '$description' WHERE id = $targetId LIMIT 1";
    $result = mysqli_query($connection, $query);
    if (mysqli_error($connection)) {
      $_SESSION['edit-category'] = 'failed to update category!';
    } else {
      $_SESSION['operation-success'] = "category '$title' updated successfully.";
    }
  }

  if (isset($_SESSION['edit-category'])) {
    $_SESSION['edit-category-data'] = $_POST;
    header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $targetId);
    die();
  }
}

header('location: ' . ROOT_URL . 'admin/manage-category.php');
die();
