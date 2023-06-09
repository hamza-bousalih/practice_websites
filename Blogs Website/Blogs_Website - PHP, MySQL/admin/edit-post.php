<?php

$pageTitle = 'Edit Post';
$cssFiles = ['nav', 'general-forms', 'footer'];

include './partials/header.php';

// fetch categories from database
$query = "SELECT id,title FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);

if (isset($_GET['id']) && !isset($_SESSION['edit-post-data'])) {

  $title = null;
  $body = null;
  $categoryId = null;
  $isFeatured = null;

  $targetPostID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  // fetch post details from database
  $fetch_post_query = "SELECT * FROM posts WHERE id = $targetPostID";
  $fetch_post_result = mysqli_query($connection, $fetch_post_query);
  if (!mysqli_errno($connection)) {
    $post = mysqli_fetch_assoc($fetch_post_result);

    $title = $post['title'];
    $body = $post['body'];
    $previousImage = $post['image'];
    $categoryId = $post['category'];
    $isFeatured = $post['is_Featured'];
  } else {
  }
} else if (isset($_SESSION['edit-post-data'])) {
  $title = $_SESSION['edit-post-data']['title'];
  $body = $_SESSION['edit-post-data']['body'];
  $previousImage = $_SESSION['previousImage'];
  $categoryId = $_SESSION['edit-post-data']['category'];
  $isFeatured = $_SESSION['edit-post-data']['isFeatured'] ?? null;

  unset($_SESSION['edit-post-data']);
} else {
  header('location: ' . ROOT_URL . 'admin/');
  die();
}

?>
<section class="form__section">
  <div class="container form__section-container">
    <h2>edit Post</h2>
    <?php
    if (isset($_SESSION['edit-post'])) : ?>
      <div class="alert__message error">
        <p>
          <?php
          echo $_SESSION['edit-post'];
          unset($_SESSION['edit-post']);
          ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="post">
      <input type="hidden" name="postId" value="<?= $targetPostID ?>">
      <input type="hidden" name="previousImage" value="<?= $previousImage ?>">
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
      <button type="submit" name="submit" class="btn">Edit post</button>
    </form>
  </div>
</section>


<?php include '../partials/footer.php'; ?>