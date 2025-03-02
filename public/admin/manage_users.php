<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Manage Users | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>



<main role="main" tabindex="-1">
<div id="adminHero">
        <h2>Management Area: Users</h2>
    </div>
    <div class="actions">
      <a class="action" href="<?php echo url_for('/admin/users/new.php');
      ?>">Add user</a>
    </div>

    <table class="list" border=1>
      <tr>
        
        <th>Username</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

<?php

// Create a new user object that uses the find_all() method
$users = User::find_all();

foreach($users as $user) { 
  ?>
      <tr>
        <td><?php echo h($user->username); ?></td>
        <td><?php echo h($user->user_first_name); ?></td>
        <td><?php echo h($user->user_last_name); ?></td>
        <td><?php echo h($user->user_email_address); ?></td>
        <td><?php echo h($user->user_role); ?></td>
        <td><a class="action" href="<?php echo url_for('/admin/users/show_user.php?id=' . h(u($user->id)));
        ?>">View</a></td>
        <td><a class="action" href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user->id)));
        ?>">Edit</a></td>
        <td><a class="action" href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id)));
        ?>">Delete</a></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>