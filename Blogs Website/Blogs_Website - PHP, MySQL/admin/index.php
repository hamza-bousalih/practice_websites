<?php

$pageTitle = 'Dashboard';
$cssFiles = ['dashboard'];
$pageID = 'mp';

include './partials/header.php';

// fetch user posts from database
$userId = filter_var($_SESSION['userId'], FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT posts.id as id,
            posts.title as title,
            categories.title as category
          FROM posts
          JOIN categories
          ON category = categories.id
          WHERE posts.author = '$userId'
          ORDER BY title";
$posts = mysqli_query($connection, $query);

?>

<section class="dashboard">
  <?php include './partials/sidebar.php'; ?>
  <main>
    <h2>manage posts</h2>
    <?php if (mysqli_num_rows($posts) > 0) : ?>
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <tr>
              <td>
                <p><?= $post['title'] ?></p>
              </td>
              <td><?= $post['category'] ?></td>
              <td><a href="<?= ROOT_URL . 'admin/edit-post.php?id=' . $post['id'] ?>" class="btn edit">Edit</a></td>
              <td><a href="<?= ROOT_URL . 'admin/delete-post.php?id=' . $post['id'] ?>" class="btn danger">Delete</a></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert__message failed">
        You don't have any posts yet!
      </div>
    <?php endif; ?>
  </main>
  </div>
</section>

<?php include '../partials/footer.php'; ?>