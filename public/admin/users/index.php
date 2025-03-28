<?php require_once('../../../private/initialize.php'); 
$pageTitle = "Management Area | Culinnari"; 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
$current_user_role = $session->user_role;?>

<body>
    <main role="main" tabindex="-1">
        <div id="adminHero">
            <h2>Management Area</h2>
        </div>
        <div id="wrapper">
            <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Management Index</a>
            <div  id="adminWrapper">
                <section id="users">
                <div class="mgmtTableHeading">
                    <img src="<?php echo url_for('/images/icon/users.svg');?>" width="32" height="36">
                    <h3>Users</h3>
                    <a class="adminAddNew" href="<?php echo url_for('/admin/users/new.php');?>">Add user</a>
                </div>
                <table id="users">
                <tr>    
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Join Date</th>
                    <th>Role</th>        
                </tr>
                <?php
                $users = User::find_all();
                foreach($users as $user) { 
                ?>
                <tr>
                    <td><?php echo h($user->username); ?></td>
                    <td><?php echo h($user->user_first_name); ?> <?php echo h($user->user_last_name); ?></td>
                    <td><?php echo h($user->user_email_address); ?></td>
                    <td><?php echo h(formatDate($user->user_create_account_date));?></td>
                    <td><?php echo h($user->user_role); ?></td>
                    <td><a  href="<?php echo url_for('/admin/users/show.php?id=' . h(u($user->id)));
                    ?>">View</a></td>
                    <?php 
                        if (
                            ($current_user_role == 's') || // Super admins can edit/delete anyone
                            ($current_user_role == 'a' && $user->user_role == 'm') // Admins can only edit/delete members
                        ) { 
                        ?>
                            <td><a href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user->id))); ?>">Edit</a></td>
                            <td><a href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($user->id))); ?>">Delete</a></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </table>
            </section>

            </div>
        </div>
    </main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>

</body>