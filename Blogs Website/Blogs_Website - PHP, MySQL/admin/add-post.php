<?php

$pageTitle = 'Add Post';
$cssFiles = ['nav', 'general-forms', 'footer'];

include './partials/header.php';

// fetch categories from database
$query = "SELECT id,title FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);

$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;
$categoryId = $_SESSION['add-post-data']['category'] ?? null;
$isFeatured = $_SESSION['add-post-data']['isFeatured'] ?? null;

unset($_SESSION['add-post-data']);

?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>add Post</h2>
    <?php
    if (isset($_SESSION['add-post'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['add-post'];
          unset($_SESSION['add-post']);
          ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="post">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
      <select name="category">
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['id'] ?>" <?= $categoryId == $category['id'] ? 'selected' : '' ?>>
            <?= ucwords($category['title']) ?>
          </option>
        <?php endwhile; ?>
      </select>
      <textarea name="body" rows="4" placeholder="Body"><?= $body ?></textarea>
      <?php if (isset($_SESSION['user_is_admin'])) : ?>
        <div class="form__control inline">
          <input type="checkbox" name="isFeatured" <?= $isFeatured == 0 ?: 'checked' ?> value="1" id="is_featured">
          <label for="is_featured">Featured</label>
        </div>
      <?php endif; ?>
      <div class="form__control">
        <label for="post_image">Add Thumbnail</label>
        <input type="file" name="image" id="post_image">
      </div>
      <button type="submit" name="submit" class="btn">Add post</button>
    </form>
  </div>
</section>

<?php include '../partials/footer.php'; ?>