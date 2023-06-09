<?php

$admin_url = ROOT_URL . 'admin/';

include 'operationMessages.php';

?>

<div class="container dashboard__container">
  <button class="sidebar__toggle">
    <i class="fa fa-angle-left"></i>
  </button>
  <aside>
    <ul>
      <li>
        <a href="<?php echo $admin_url ?>add-post.php">
          <i class="fa fa-pencil" aria-hidden="true"></i>
          <h5>add post</h5>
        </a>
      </li>
      <li>
        <a href="<?php echo $admin_url ?>" class="<?php echo $pageID == 'mp' ? 'active' : '' ?>">
          <i class="fa fa-paste" aria-hidden="true"></i>
          <h5>manage posts</h5>
        </a>
      </li>
      <?php if (isset($_SESSION['user_is_admin'])) : ?>
        <li>
          <a href="<?php echo $admin_url ?>add-user.php">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
            <h5>add user</h5>
          </a>
        </li>
        <li>
          <a href="<?php echo $admin_url ?>manage-user.php" class="<?php echo $pageID == 'mu' ? 'active' : '' ?>">
            <i class="fa fa-users-gear" aria-hidden="true"></i>
            <h5>manage users</h5>
          </a>
        </li>
        <li>
          <a href="<?php echo $admin_url ?>add-category.php">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <h5>add category</h5>
          </a>
        </li>
        <li>
          <a href="<?php echo $admin_url ?>manage-category.php" class="<?php echo $pageID == 'mc' ? 'active' : '' ?>">
            <i class="fa fa-list" aria-hidden="true"></i>
            <h5>manage categories</h5>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </aside>