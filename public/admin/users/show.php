<?php require_once('../../../private/initialize.php'); 
$title = 'Management: View User | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
$id = $_GET['id'] ?? '1'; // PHP > 7.0
$user = User::find_by_id($id);
?>

<main role="main" tabindex="-1">
  <div class="adminHero">
    <h2>Management Area : View User</h2>
  </div>
  
  <div class="wrapper">
    <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to User Index</a>
    <div class="manageUserWrapper">
      
      <?php if (isset($_SESSION['message'])): ?>
        <div class="session-message">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); // Clear message after displaying ?>
      <?php endif; ?>
      
      <?php if (
          ($user->user_role === 'a' && $session->user_role === 's') || // Super Admin can edit/administer all users
          ($user->user_role === 'm' && ($session->user_role === 'a' || $session->user_role === 's')) // Admin can only edit/manage members
        ): ?>
        <div class="manageUserActions">
            <a href="<?php echo url_for('admin/users/edit.php?id=' . h(u($user->id))); ?>" class="secondaryButton">
              <img src="<?php echo url_for('/images/icon/pencil.svg'); ?>" width="20" height="20" alt="Pencil edit icon">Edit User
            </a>
            <a href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id))); ?>" class="deleteButton">Delete</a>
        </div>
      <?php endif; ?>
      
      <ul>
        <li>Username: <?php echo h($user->username);?></li>
        <li>Full Name: <?php echo h($user->user_first_name) . ' ' . h($user->user_last_name); ?></li>
        <li>Email Address: <?php echo h($user->user_email_address);?></li>
        <li>Create Account Date: <?php echo h(formatDate($user->user_create_account_date)); ?></li>
        
        <li>User Role: 
          <?php 
            switch ($user->user_role) {
              case 'm':
                echo 'Member';
                break;
              case 'a':
                echo 'Admin';
                break;
              case 's':
                echo 'Super Admin';
                break;
            }
          ?>
        </li>
        
        <li>Active: <?php echo $user->user_is_active == 1 ? 'yes' : 'no'; ?></li>
      </ul>
    </div>
  </div>
</main>


<?php include(SHARED_PATH . '/public_footer.php'); ?>