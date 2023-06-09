<?php

$pageTitle = 'Category Posts';
$cssFile = 'category-posts';
include './partials/header.php';

if (isset($_GET['id'])) {
  $id = $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  // check if the id exist in database
  $check_query = "SELECT * FROM categories WHERE id = $id";
  $check_query_result = mysqli_query($connection, $check_query);
  if (mysqli_num_rows($check_query_result) == 0) {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
  }

  // fetch categories from database
  $query = "SELECT * FROM categories";
  $categories = mysqli_query($connection, $query);
  $categories = mysqli_fetch_all($categories, MYSQLI_ASSOC);

  // fetch posts from database
  $posts_query = "SELECT posts.id as postId, 
                        posts.title, 
                        posts.body, 
                        posts.image, 
                        posts.date_time as 'time', 
                        categories.id as categoryID, 
                        categories.title as category, 
                        firstname, 
                        lastname, 
                        avatar  
                        FROM posts, categories, users 
                        WHERE posts.category = '$id'
                        AND categories.id = '$id'
                        AND users.id = author";
  $posts = mysqli_query($connection, $posts_query);
} else {
  header('Location: ' . ROOT_URL . 'blog.php');
  die();
}

?>

<header class="category__title">
  <?php foreach ($categories as $category): ?>
    <?php if ($category['id'] == $id): ?>
      <h2>
        <?= $category['title'] ?>
      </h2>
    <?php endif; ?>
  <?php endforeach; ?>
</header>

<section class="posts">
  <?php if (mysqli_num_rows($posts) > 0): ?>
    <div class="container posts__container">
      <?php while ($post = mysqli_fetch_assoc($posts)): ?>
        <div class="post">
          <div class="post__image">
            <img src="./images/<?= $post['image'] ?>">
          </div>
          <div class="post__info">
            <a href="<?= ROOT_URL . 'category-posts.php?id=' . $post['categoryID'] ?>"
                class="category__button"><?= $post['category'] ?></a>
            <h3 class="post__title">
              <a href="<?= ROOT_URL . 'post.php?id=' . $post['postId'] ?>">
                <?= $post['title'] ?>
              </a>
            </h3>
            <p class="post__body">
              <?= substr($post['body'], 0, 150) ?>...
            </p>
            <div class="post__author">
              <div class="avatar">
                <img src="./images/<?= $post['avatar'] ?>">
              </div>
              <div class="details">
                <h5>by:
                  <?= $post['firstname'] . ' ' . $post['lastname'] ?>
                </h5>
                <small>
                  <?= date('M d, Y - H:i', strtotime($post['time'])) ?>
                </small>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert__message failed">
      there is no posts in this category!
    </div>
  <?php endif; ?>
</section>

<section class="category__buttons">
  <div class="container category__buttons-container">
    <?php foreach ($categories as $category): ?>
      <a href="<?= ROOT_URL . 'category-posts.php?id=' . $category['id'] ?>"
          class="category__button"><?= $category['title'] ?></a>
    <?php endforeach; ?>
  </div>
</section>

<?php include './partials/footer.php'; ?>
