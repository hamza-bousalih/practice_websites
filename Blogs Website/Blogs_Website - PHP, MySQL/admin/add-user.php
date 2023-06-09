<?php

$pageTitle = 'Add User';
$cssFiles = ['nav', 'general-forms', 'footer'];

include './partials/header.php';

$firstName = $_SESSION['add-user-data']['firstName'] ?? null;
$lastName = $_SESSION['add-user-data']['lastName'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;

unset($_SESSION['add-user-data']);

?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>add User</h2>
    <?php
    if (isset($_SESSION['add-user'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['add-user'];
          unset($_SESSION['add-user']);
          ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="post" enctype="multipart/form-data">
      <input type="text" name="firstName" value="<?= $firstName ?>" placeholder="Fris Name">
      <input type="text" name="lastName" value="<?= $lastName ?>" placeholder="Last Name">
      <input type="text" name="username" value="<?= $username ?>" placeholder="username">
      <input type="text" name="email" value="<?= $email ?>" placeholder="email">
      <input type="password" name="createPassword" placeholder="create password">
      <input type="password" name="confirmPassword" placeholder="config password">
      <select name="userRole">
        <option value="0" selected>Author</option>
        <option value="1">Admin</option>
      </select>
      <div class="form__control">
        <label for="avatar">User Avatar</label>
        <input type="file" name="avatar" id="avatar">
      </div>
      <button type="submit" name="submit" class="btn">Add User</button>
    </form>
  </div>
</section>

<?php include '../partials/footer.php'; ?>