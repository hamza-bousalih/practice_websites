<?php

require 'config/database.php';

// get singin from data if signup button was clicked
if (isset($_POST['submit'])) {
  $username_email = filter_var(
    $_POST['username_email'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS
  );

  $password = filter_var(
    $_POST['password'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS
  );

  if (!$username_email) { // username/email not passed
    $_SESSION['signin'] = 'Enter a username or email';
  } elseif (!$password) { // no password passed
    $_SESSION['signin'] = 'no password passed!';
  } else { // check the compte details (username/email, password)
    $fetch_user_query =
      "SELECT * FROM users 
      WHERE username = '$username_email'
      OR email = '$username_email'";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);

    if (mysqli_num_rows($fetch_user_result) == 1) { // user exists in database
      $user = mysqli_fetch_assoc($fetch_user_result);
      $db_password = $user['password'];
      if (password_verify($password, $db_password)) { // password is correct
        $_SESSION['userId'] = $user['id'];

        if ($user['admin'] == 1) { // for admins
          $_SESSION['user_is_admin'] = true;
        }

        // log user in
        header('Location:' . ROOT_URL . 'admin/');
        die();
      } else { // incorrect password
        $_SESSION['signin'] = 'check your password!';
      }
    } else { // user not exists 
      $_SESSION['signin'] = 'user not found!';
    }
  }

  if (isset($_SESSION['signin'])) { // back to signin page in case of a problem
    $_SESSION['signin-data'] = $_POST;
    header('Location:' . ROOT_URL . 'signin.php');
    die();
  }

} else { // redirect to signin page in case the submit button not clicked
  header('Location:' . ROOT_URL . 'signin.php');
}