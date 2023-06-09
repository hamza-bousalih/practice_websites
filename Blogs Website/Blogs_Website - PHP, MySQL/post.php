<?php

$pageTitle = 'Post';
$cssFile = 'post';
include './partials/header.php';

// fetch post from data base if id is set
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  // check if the id exist in database
  $check_query = "SELECT * FROM posts WHERE id = $id";
  $check_query_result = mysqli_query($connection, $check_query);
  if (mysqli_num_rows($check_query_result) == 0) {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
  }

  $post_query = "SELECT posts.title, 
                        posts.body, 
                        posts.image, 
                        posts.date_time as 'time', 
                        categories.id as categoryID, 
                        categories.title as category, 
                        firstname, 
                        lastname, 
                        avatar  
                        FROM posts, categories, users 
                        WHERE posts.id = '$id'
                        AND categories.id = category 
                        AND users.id = author";
  $post_query_result = mysqli_query($connection, $post_query);

  if (mysqli_num_rows($post_query_result) == 1) {
    $post = mysqli_fetch_assoc($post_query_result);
  } else {
    header('Location: ' . ROOT_URL . 'blog.php');
  }
} else {
  header('Location: ' . ROOT_URL . 'blog.php');
}

?>

<section class="singlePost">
  <div class="container singlePost__container">
    <h2 class="post__title">
      <?= $post['title'] ?>
    </h2>
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
    <div class="singlePost__image">
      <img src="./images/<?= $post['image'] ?>">
    </div>
    <P>
      <?= nl2br($post['body']) ?>
    </P>
  </div>
</section>

<?php include './partials/footer.php'; ?>
