<?php

require './config/constants.php';

$firstName = $_SESSION['signup-data']['firstName'] ?? null;
$lastName = $_SESSION['signup-data']['lastName'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;

unset($_SESSION['signup-data']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Sing Up</title>

    <link rel="stylesheet"
        href="./libraries/font_awesome/main_files/all.min.css">
    <link rel="stylesheet"
        href="./CSS/general-forms.css">
  </head>
  <body>

    <section class="form__section">
      <div class="container form__section-container">
        <h2>sign up</h2>
        <?php
        if (isset($_SESSION['signup'])): ?>
          <div class="alert__message error">
            <p>
              <?php
              echo $_SESSION['signup'];
              unset($_SESSION['signup']);
              ?>
            </p>
          </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>signup-logic.php"
            method="post"
            enctype="multipart/form-data">
          <input type="text"
              name="firstName"
              value="<?= $firstName ?>"
              placeholder="First Name">
          <input type="text"
              name="lastName"
              value="<?= $lastName ?>"
              placeholder="Last Name">
          <input type="text"
              name="username"
              value="<?= $username ?>"
              placeholder="Username">
          <input type="text"
              name="email"
              value="<?= $email ?>"
              placeholder="Email">
          <input type="password"
              name="createPassword"
              placeholder="create password">
          <input type="password"
              name="confirmPassword"
              placeholder="config password">
          <div class="form__control">
            <label for="avatar">User Avatar</label>
            <input type="file"
                name="avatar"
                id="avatar">
          </div>
          <button type="submit"
              name="submit"
              class="btn">sign up</button>
          <small>Already have an account? <a href="signin.php">Sign In</a></small>
        </form>
      </div>
    </section>

    <script src="./libraries/font_awesome/main_files/all.min.js"></script>
  </body>
</html>
