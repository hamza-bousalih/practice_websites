<?php

$pageTitle = 'Manage Users';
$cssFiles = ['dashboard'];
$pageID = 'mu';

include './partials/header.php';

// fetch users from database but not current user
$userId = $_SESSION['userId'];
$query = "SELECT * FROM users WHERE NOT id = $userId";
$users = mysqli_query($connection, $query);

?>

<section class="dashboard">
  <?php include './partials/sidebar.php'; ?>
  <main>
    <h2>manage users</h2>
    <?php if (mysqli_num_rows($users) > 0) : ?>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>User Name</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Admin</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = mysqli_fetch_assoc($users)) : ?>
            <tr>
              <td><?= $user['firstname'] . ' ' . $user['lastname'] ?></td>
              <td><?= $user['username'] ?></td>
              <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn edit">Edit</a></td>
              <td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn danger">Delete</a></td>
              <td><?= $user['admin'] ? 'Yes' : 'No' ?></td>
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