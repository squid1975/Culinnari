<?php require_once('../private/initialize.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Culinnari: Database Connection</title>
        <link href="css/styles.css" rel="stylesheet">
        <script src="js/script.js" defer></script>
    </head>

    <body>
      <h1>Database Connect Display</h1>
      <table border="1">
        <tr>
          <th>Username</th>
          <th>User First Name</th>
          <th>User Last Name</th>
          <th>Created Account Date</th>
          <th>User Role</th>
        </tr>
      <?php 
          $users = User::find_all();
          foreach($users as $user) {
              ?>
              <tr>
                  <td><?php echo(h($user->username));?> </td>
                  <td><?php echo(h($user->user_first_name));?> </td>
                  <td><?php echo(h($user->user_last_name));?> </td>
                  <td><?php echo(h($user->user_create_account_date));?> </td>
                  <td><?php echo(h($user->user_role));?> </td>
        <?php } ?>
        </table>
    </body>
</html>
