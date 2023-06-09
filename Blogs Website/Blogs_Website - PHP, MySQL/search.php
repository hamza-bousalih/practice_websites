<?php

$pageTitle = 'Blogs';
$cssFile = 'search-page';
include './partials/header.php';

if (isset($_GET['submit']) && isset($_GET['search']) && $_GET['search'] != '') {
  $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $search_query = "SELECT posts.id as postId, 
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
                        WHERE posts.title LIKE '%$search%'
                        AND categories.id = category
                        AND users.id = author
                        ORDER BY date_time DESC";
  $posts = mysqli_query($connection, $search_query);
} else {
  header('location: ' . ROOT_URL . 'blog.php');
}

// fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

?>

<section class="posts section_extra-margin">
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
      there is not post match your search
    </div>
  <?php endif; ?>
</section>

<section class="category__buttons">
  <div class="container category__buttons-container">
    <?php while ($category = mysqli_fetch_assoc($categories)): ?>
      <a href="<?= ROOT_URL . 'category-posts.php?id=' . $category['id'] ?>"
          class="category__button"><?= $category['title'] ?></a>
    <?php endwhile; ?>
  </div>
</section>

<?php include './partials/footer.php'; ?>
