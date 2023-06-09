<?php

// fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

?>

<section class="category__buttons">
  <div class="container category__buttons-container">
    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
      <a href="<?= ROOT_URL . 'category-posts.php?id=' . $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
    <?php endwhile; ?>
  </div>
</section>