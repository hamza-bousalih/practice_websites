<?php

require '../config/database.php';

if (isset($_GET['id'])) {
  // fetch targeted category from database
  $targetCategoryID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $targetCategoryName = filter_var($_GET['name'], FILTER_SANITIZE_NUMBER_INT);

  // fetch all posts of targeted category and and update their id to uncategorized category.
  $update_posts_query = "UPDATE posts 
                          SET category = (SELECT id FROM categories WHERE title = 'Uncategorized')
                          WHERE category = $targetCategoryID";
  $update_posts_query_result = mysqli_query($connection, $update_posts_query);

  // delete targeted category
  $query = "DELETE FROM categories WHERE id = $targetCategoryID LIMIT 1";
  $result = mysqli_query($connection, $query);
  if (mysqli_errno($connection)) {
    $_SESSION['operation-failed'] = "couldn't delete the category!";
  } else {
    $_SESSION['operation-success'] = "the category has been deleted successfully.";
  }
}

header('Location: ' . ROOT_URL . 'admin/manage-category.php');
die();
