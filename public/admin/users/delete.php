<title>Delete User | Culinnari</title>
<?php
require_once('../../../private/initialize.php');
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login();

$user_id = $_GET['id'];
$user = User::find_by_id($user_id);
if($user == false) {
    redirect_to(url_for('/admin/index.php'));
}

if(is_post_request()) {
    $result = $user->delete();
    $_SESSION['message'] = 'The user was deleted successfully.';
    redirect_to(url_for('/admin/index.php'));
}
else {

}

?>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : User</h2>
    </div>
    <div class="wrapper">
        <div id="adminWrapper">
        <div class="manageUserCard">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/users/index.php');?>">Back to Management Index</a>
            </div>
            <h2>Delete User: <?php echo h($user->username); ?> </h2>
            <div class="delete">
                <h3>Delete User</h3>
                <p>Are you sure you want to delete this user?<strong>This cannot be undone.</strong></p>
                <form action="" method="post">
                    <div>
                        <input type="submit" name="delete" value="Delete User">
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>