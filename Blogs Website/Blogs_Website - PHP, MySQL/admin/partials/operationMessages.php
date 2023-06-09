<?php if (isset($_SESSION['operation-success'])) : ?>
  <div class="alert__message success">
    <p>
      <?php
      echo $_SESSION['operation-success'];
      unset($_SESSION['operation-success']);
      ?>
    </p>
  </div>
<?php endif; ?>
<?php if (isset($_SESSION['operation-failed'])) : ?>
  <div class="alert__message failed">
    <p>
      <?php
      echo $_SESSION['operation-failed'];
      unset($_SESSION['operation-failed']);
      ?>
    </p>
  </div>
<?php endif; ?>