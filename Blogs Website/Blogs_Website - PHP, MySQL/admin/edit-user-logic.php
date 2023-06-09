<?php

require '../config/database.php';

if (isset($_POST['submit'])) {
  $targetId = filter_var($_POST['targetId'], FILTER_SANITIZE_NUMBER_INT);
  $firstname = filter_var($_POST['firstName'], FILTER_SANITIZE_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastName'], FILTER_SANITIZE_SPECIAL_CHARS);
  $is_admin = filter_var($_POST['userRole'], FILTER_SANITIZE_NUMBER_INT);

  // check for valid input
  if (!$firstname) {
    $_SESSION['edit-user'] = 'invalid first name!';
  } else if (!$lastname) {
    $_SESSION['edit-user'] = 'invalid last name!';
  } else {
    // update the user
    $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', admin = $is_admin WHERE id = $targetId LIMIT 1";
    $result = mysqli_query($connection, $query);
    if (mysqli_error($connection)) {
      $_SESSION['edit-user'] = 'failed to update user!';
    } else {
      $_SESSION['operation-success'] = "user '$firstname $lastname' updated successfully.";
    }
  }

  if (isset($_SESSION['edit-user'])) {
    $_SESSION['edit-user-data'] = $_POST;
    header('location: ' . ROOT_URL . 'admin/edit-user.php?id=' . $targetId);
    die();
  }
}

header('location: ' . ROOT_URL . 'admin/manage-user.php');
die();
