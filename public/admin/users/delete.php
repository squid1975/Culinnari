<?php
require_once('../../../private/initialize.php');
$title = 'Management: Delete User | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login();

$id = $_GET['id'];
$user = User::find_by_id($id);
if($user == false) {
    $_SESSION['message'] = 'User not found.';
    redirect_to(url_for('/admin/users/index.php'));
}

if(is_post_request()) {
    $result = $user->delete();
    $_SESSION['message'] = 'The user was deleted successfully.';
    redirect_to(url_for('/admin/users/index.php'));
}


?>

<main role="main" tabindex="-1">
    <div class="adminHero">
        <h2>Management Area : User</h2>
    </div>
    <div class="wrapper">
        <div id="adminWrapper">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/users/show.php?id=' . h(u($user->id)));
                    ?>">Back to User Info</a>
            </div>
            <div class="manageUserWrapper">
                <section>
                <h2>Delete User: <?php echo h($user->username); ?> </h2>
                <div class="delete">
                    <p>This action will delete the users account and all recipes created by this user. To temporarily change user's active account status, go to Manage > Edit > Active Level. </p>
                    <p>Are you sure you want to delete this user? <strong>This cannot be undone.</strong></p>
                    <form action="<?php echo url_for('/admin/users/delete.php?' . $user->id);?>" method="post">
                        <div>
                            <input type="submit" name="delete" value="Delete User" class="deleteButton">
                        </div>
                    </form>
                </div>
                </section>
            </div>
        </div>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>