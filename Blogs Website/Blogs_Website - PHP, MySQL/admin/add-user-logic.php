<?php

require '../config/database.php';

// get singup from data if add-user button was clicked
if (isset($_POST['submit'])) {
  $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $createPassword = filter_var($_POST['createPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $confirmPassword = filter_var($_POST['confirmPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userRole = filter_var($_POST['userRole'], FILTER_SANITIZE_NUMBER_INT);
  $avatar = $_FILES['avatar'];

  // validate data
  if (!$firstName) {
    $_SESSION['add-user'] = 'Please enter your first name.';
  } elseif (!$lastName) {
    $_SESSION['add-user'] = 'Please enter your last name.';
  } elseif (!$username) {
    $_SESSION['add-user'] = 'Please enter your username.';
  } elseif (!$email) {
    $_SESSION['add-user'] = 'Please enter a valid email.';
  } elseif (strlen($createPassword) < 8 || strlen($confirmPassword) < 8) {
    $_SESSION['add-user'] = 'Password should be 8+ chars.';
  } elseif (!$avatar['name']) {
    $_SESSION['add-user'] = 'Please add avatar.';
  } else {
    // check if password don't match
    if ($createPassword !== $confirmPassword) {
      $_SESSION['add-user'] = 'Passwords do not match.';
    } else {
      // hash password
      $hashedPassword = password_hash($createPassword, PASSWORD_DEFAULT);

      // check if username or email exist in database
      $user_check_query =
        "SELECT * FROM users 
        WHERE username = '$username'
        OR email = '$email'";

      $user_check_result = mysqli_query($connection, $user_check_query);
      if (mysqli_num_rows($user_check_result) > 0) {
        $_SESSION['add-user'] = 'Username or Email already exist.';
      } else { // Work on avatar
        $time = time();
        $avatar_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = '../images/' . $avatar_name;

        // make sure the file is image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
          // make sure the image size not to large (1mb+);
          if ($avatar['size'] < 1_000_000) {
            // upload avatar
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
            echo 'image added';
          } else {
            $_SESSION['add-user'] = 'File size to big, should be less then 1MB.';
          }
        } else {
          $_SESSION['add-user'] = 'file should be png, jpg or jpeg.';
        }
      }
    }
  }

  if (isset($_SESSION['add-user'])) { // redirect to add-user page if there was any problem
    $_SESSION['add-user-data'] = $_POST;
    header('location:' . ROOT_URL . 'admin/add-user.php');
    die();
  } else {
    // insert new user into users table
    $insert_user_query =
      "INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `admin`) 
    VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$avatar_name', $userRole) ";

    $insert_user_result = mysqli_query($connection, $insert_user_query);

    if (!mysqli_error($connection)) {
      // redirect to add-user page with success message
      $_SESSION['operation-success'] = "new user '$firstName $lastName' added successfully";
      header('location:' . ROOT_URL . 'admin/manage-user.php');
      die();
    }
  }
} else { // redirect to add-user page if submit button not checked.
  header('location:' . ROOT_URL . 'admin/manage-user.php');
  die();
}
