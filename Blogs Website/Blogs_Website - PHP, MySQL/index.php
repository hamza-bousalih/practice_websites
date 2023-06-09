<?php

$pageTitle = 'Blogs Website';
$cssFile = 'index';
include './partials/header.php';

// fetch categories from database
$categories_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $categories_query);

// fetch featured post from database
$featured_post_query = "SELECT posts.id as postId,
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
                                WHERE is_featured = 1 
                                AND categories.id = category 
                                AND users.id = author; ";
$featured_post = mysqli_query($connection, $featured_post_query);

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
                        WHERE categories.id = category 
                        AND users.id = author
                        LIMIT 9";
$posts = mysqli_query($connection, $posts_query);

?>
<?php if (mysqli_num_rows($featured_post) > 0): ?>
  <section class="featured">
    <div class="container featured__container">
      <?php while ($post = mysqli_fetch_assoc($featured_post)): ?>
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
            <?= substr($post['body'], 0, 300) ?>...
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
      <?php endwhile; ?>
    </div>
  </section>
<?php endif; ?>

<section class="posts <?= mysqli_num_rows($featured_post) == 0 ? 'section_extra-margin' : '' ?>">
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
