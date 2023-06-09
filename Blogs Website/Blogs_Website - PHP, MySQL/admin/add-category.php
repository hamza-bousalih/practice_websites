<?php

$pageTitle = 'Add Category';
$cssFiles = ['nav', 'general-forms', 'footer'];

include './partials/header.php';

$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data']);

?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>add category</h2>
    <?php
    if (isset($_SESSION['add-category'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['add-category'];
          unset($_SESSION['add-category']);
          ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>/admin/add-category-logic.php" method="post">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
      <textarea name="description" rows="4" value="<?= $description ?>" placeholder="Description"></textarea>
      <button type="submit" name="submit" class="btn">Add category</button>
    </form>
  </div>
</section>

<?php include '../partials/footer.php'; ?>