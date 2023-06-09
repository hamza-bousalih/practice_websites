<?php

$pageTitle = 'Blogs';
$cssFile = 'blog';
include './partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// fetch all posts from database
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
                        AND users.id = author";
$posts = mysqli_query($connection, $posts_query);

?>
<section class="search__bar">
  <form action="<?= ROOT_URL ?>search.php"
      method="get"
      class="container search__bar-container">
    <div>
      <i class="fa fa-search"></i>
      <input type="search"
          name="search"
          placeholder="search here...">
    </div>
    <button type="submit"
        name="submit"
        class="btn">Go</button>
  </form>
</section>

<section class="posts">
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
