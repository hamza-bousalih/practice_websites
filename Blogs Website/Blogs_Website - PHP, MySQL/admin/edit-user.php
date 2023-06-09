<?php

$pageTitle = 'Edit User';
$cssFiles = ['nav', 'general-forms', 'footer'];

include './partials/header.php';

if (isset($_GET['id']) && !isset($_SESSION['edit-user-data'])) {
  $targetUserID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT firstname, lastname, admin FROM users WHERE id = $targetUserID";
  $targetUser = mysqli_query($connection, $query);
  $targetUser = mysqli_fetch_assoc($targetUser);

  $firstname = $targetUser['firstname'];
  $lastname = $targetUser['lastname'];
  $is_admin = $targetUser['admin'];
} else if (isset($_SESSION['edit-user-data'])) {
  $targetUserID = $_SESSION['edit-user-data']['targetId'];
  $firstname = $_SESSION['edit-user-data']['firstName'];
  $lastname = $_SESSION['edit-user-data']['lastName'];
  $is_admin = $_SESSION['edit-user-data']['userRole'];

  unset($_SESSION['edit-user-data']);
} else {
  header('location: ' . ROOT_URL . 'admin/manage-user.php');
  die();
}

?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Edit User</h2>
    <?php if (isset($_SESSION['edit-user'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['edit-user'];
          unset($_SESSION['edit-user']);
          ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="post">
      <input type="hidden" name="targetId" value="<?= $targetUserID ?>">
      <input type="text" name="firstName" placeholder="Fris Name" value="<?= $firstname ?>">
      <input type="text" name="lastName" placeholder="Last Name" value="<?= $lastname ?>">
      <div class="form__control">
        <label for="user_role">User Role</label>
        <select name="userRole" id="user_role">
          <option value="0" <?= !$is_admin ? 'selected' : '' ?>>Author</option>
          <option value="1" <?= $is_admin ? 'selected' : '' ?>>Admin</option>
        </select>
      </div>
      <button type="submit" name="submit" class="btn">Update User</button>
    </form>
  </div>
</section>

<?php include '../partials/footer.php'; ?>