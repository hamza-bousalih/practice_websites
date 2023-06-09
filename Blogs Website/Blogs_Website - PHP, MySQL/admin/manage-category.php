<?php

$pageTitle = 'Manage Categories';
$cssFiles = ['dashboard'];
$pageID = 'mc';

include './partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);
?>

<section class="dashboard">
  <?php include './partials/sidebar.php'; ?>
  <main>
    <h2>manage categories</h2>
    <?php if (mysqli_num_rows($categories) > 0) : ?>
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
            <tr>
              <td><?= $category['title'] ?></td>
              <td><a href="<?= ROOT_URL . '/admin/edit-category.php?id=' . $category['id'] ?>" class="btn edit">Edit</a></td>
              <td><a href="<?= ROOT_URL . '/admin/delete-category.php?id=' . $category['id'] ?>" class="btn danger">Delete</a></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert__message failed">
        No User Found!
      </div>
    <?php endif; ?>
  </main>
  </div>
</section>

<?php include '../partials/footer.php'; ?>