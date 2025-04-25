<?php require_once('../../../private/initialize.php'); 
$title = 'Management Area| Users | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
?>


<main role="main" tabindex="-1">
        <div id="adminHero">
            <h2>Management Area - Users</h2>
        </div>
        <div class="wrapper">
            <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Management Index</a>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
        <div id="adminWrapper">
            <section id="users">
                <div class="mgmtTableHeading">
                    <img src="<?php echo url_for('/images/icon/users.svg'); ?>" width="32" height="36" alt="Users icon">
                    <h3>Users</h3>
                </div>
                <a class="adminAddNew" href="<?php echo url_for('/admin/users/new.php'); ?>">Create user</a>
                <table id="users">
                    <tr>
                        <th class="adminTableUsername">Username</th>
                        <th class="adminTableUserFullName">Name</th>
                        <th class="adminTableUserEmail">Email</th>
                        <th class="adminTableUserJoinDate">Join Date</th>
                        <th class="adminTableUserRole">Role</th>
                        <th class="adminTableUserActive">Active</th>
                    </tr>
                    <?php
                    $users = User::find_all();
                    foreach ($users as $user) {
                        ?>
                        <tr>
                            <td class="adminTableUsername"><?php echo h($user->username); ?></td>
                            <td class="adminTableUserFullName"><?php echo h($user->user_first_name); ?>
                                <?php echo h($user->user_last_name); ?>
                            </td>
                            <td class="adminTableUserEmail"><?php echo h($user->user_email_address); ?></td>
                            <td class="adminTableUserJoinDate"><?php echo h(formatDate($user->user_create_account_date)); ?>
                            </td>
                            <td class="adminTableUserRole"><?php echo h($user->user_role); ?></td>
                            <td class="adminTableUserActive">
                                <?php if ($user->user_is_active == 1) {
                                    echo 'yes';
                                } else {
                                    echo 'no';
                                } ?>
                            </td>
                            <td><a href="<?php echo url_for('/admin/users/show.php?id=' . h(u($user->id)));
                            ?>">Manage</a></td>

                        </tr>
                    <?php } ?>
                </table>
            </section>

        </div>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>

