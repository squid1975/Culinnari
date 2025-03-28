<title>Management: Show User | Culinnari</title>
<?php require_once('../../../private/initialize.php'); 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
$id = $_GET['user_id'] ?? '1'; // PHP > 7.0
$user = User::find_by_id($id);
?>

<main role="main" tabindex="-1">
  <div id="adminHero">
    <h2>Management Area : View User</h2>
  </div>
    <div id="wrapper">
      <div class="manageUserCard">

      <ul>
        <li>Username: <?php echo h($user->username);?></li>
        <li>Full Name: <?php echo h($user->user_first_name) . ' ' . h($user->user_last_name); ?></li>
        <li>Email Address: <?php echo h($user->user_email_address);?></li>
        <li>Create Account Date: <?php echo h($user->user_create_account_date); ?></li>
        <li>User Role:
          <?php if ($user->user_role === 'm'){ ?>
            Member
          <?php } elseif ($user->user_role === 'a'){ ?>
            Admin 
          <?php } elseif ($user->user_role === 's'){ ?>
            Super Admin
            <?php } ?>
        </li>
      </ul>
      
        <a href="<?php echo url_for('/edit.php?id=' . h(u($user->id))); ?>" >Edit</a>
        <a href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id))); ?>">Delete</a>
      
      </div>
    </div>
</main>



<?php include(SHARED_PATH . '/public_footer.php'); ?>