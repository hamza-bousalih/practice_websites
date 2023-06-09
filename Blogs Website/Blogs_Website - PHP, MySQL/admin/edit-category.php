<?php

$pageTitle = 'Edit Category';
$cssFiles = ['nav', 'general-forms', 'footer'];

include './partials/header.php';

if (isset($_GET['id']) && !isset($_SESSION['edit-category-data'])) {
  $targetCategoryID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM categories WHERE id = $targetCategoryID";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) == 1) {
    $targetCategory = mysqli_fetch_assoc($result);
    $title = $targetCategory['title'];
    $description = $targetCategory['description'];
  }
} else if (isset($_SESSION['edit-category-data'])) {
  $targetCategoryID = $_SESSION['edit-category-data']['targetId'];
  $title = $_SESSION['edit-category-data']['title'];
  $description = $_SESSION['edit-category-data']['description'];

  unset($_SESSION['edit-category-data']);
} else {
  header('location: ' . ROOT_URL . 'admin/manage-category.php');
  die();
}

?>

<section class="form__section notFull">
  <div class="container form__section-container">
    <h2>edit category</h2>
    <?php if (isset($_SESSION['edit-category'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['edit-category'];
          unset($_SESSION['edit-category']);
          ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="post">
      <input type="hidden" name="targetId" value="<?= $targetCategoryID ?>">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
      <textarea name="description" rows="4" placeholder="Description"><?= $description ?></textarea>
      <button type="submit" name="submit" class="btn">Update category</button>
    </form>
  </div>
</section>

<?php include '../partials/footer.php'; ?>