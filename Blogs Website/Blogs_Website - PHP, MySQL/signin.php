<?php

require './config/constants.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Sing In</title>

    <link rel="stylesheet"
        href="./libraries/font_awesome/main_files/all.min.css">
    <link rel="stylesheet"
        href="./CSS/general-forms.css">
  </head>
  <body>

    <section class="form__section">
      <div class="container form__section-container">
        <h2>sign in</h2>
        <?php if (isset($_SESSION['signup-success'])): ?>
          <div class="alert__message success">
            <p>
              <?php
              echo $_SESSION['signup-success'];
              unset($_SESSION['signup-success']);
              ?>
            </p>
          </div>
        <?php elseif (isset($_SESSION['signin'])): ?>
          <div class="alert__message error">
            <p>
              <?php
              echo $_SESSION['signin'];
              unset($_SESSION['signin']);
              ?>
            </p>
          </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>signin-logic.php"
            method="post">
          <input type="text"
              name="username_email"
              value="<?= $username_email ?>"
              placeholder="username or email">
          <input type="password"
              name="password"
              value="<?= $password ?>"
              placeholder="Password">
          <button type="submit"
              name="submit"
              class="btn">sing in</button>
          <small>Don't have an account? <a href="<?= ROOT_URL ?>signup.php">Sing Up</a></small>
        </form>
      </div>
    </section>

    <script src="./libraries/font_awesome/main_files/all.min.js"></script>
  </body>
</html>
