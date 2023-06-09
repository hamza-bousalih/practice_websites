<?php

require './config/database.php';

// fetch the user info from database
if (isset($_SESSION['userId'])) {
  $id = filter_var($_SESSION['userId'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT avatar FROM users WHERE id = '$id'";
  $result = mysqli_query($connection, $query);
  $avatar = mysqli_fetch_assoc($result)['avatar'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>
      <?= $pageTitle ?>
    </title>

    <link rel="stylesheet"
        href="./libraries/font_awesome/main_files/all.min.css">
    <link rel="stylesheet"
        href="./CSS/<?= $cssFile ?>.css">
  </head>
  <body>
    <nav>
      <div class="container nav__container">
        <a href="<?= ROOT_URL ?>"
            class="nav__logo"> BSH BLOGS </a>
        <ul class="nav__items">
          <li><a href="<?= ROOT_URL ?>blog.php">blog</a></li>
          <li><a href="<?= ROOT_URL ?>about.php">about</a></li>
          <li><a href="<?= ROOT_URL ?>services.php">services</a></li>
          <li><a href="<?= ROOT_URL ?>contact.php">contact</a></li>
          <?php if (isset($_SESSION['userId'])): ?>
            <li class="nav__profile">
              <div class="avatar">
                <img src="<?= ROOT_URL . 'images/' . $avatar ?>">
              </div>
              <ul>
                <li><a href="<?= ROOT_URL ?>admin/">dashboard</a></li>
                <li><a href="<?= ROOT_URL ?>logout.php">logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li><a href="<?= ROOT_URL ?>signin.php">sign In</a></li>
          <?php endif; ?>
        </ul>

        <div class="nav__btn">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>
