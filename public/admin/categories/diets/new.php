<?php require_once('../../../../private/initialize.php');?>
<title>Create New Diet | Culinnari</title>
<?php include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

if(is_post_request()){
    $args = $_POST['diet'];
    $diet = new Diet($args);
    $result = $diet->save();

    if($result === true){
        $new_id = $diet->id;
        $_SESSION['message'] = 'The diet was created successfully.';
        redirect_to(url_for('/admin/categories/diets/manage.php?diet_id=' . $diet->id));
    } else {

    }
    
}
else {
    $diet = new diet;
}

?>

<main role="main"  tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : Diet</h2>
    </div>
    <div class="wrapper">
        <div class="manageCategoryCard">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/index.php');?>">Back to Management</a>
            </div>
            <h2>Create New diet</h2>
            <div class="new">
                <form action="" method="post">
                    <div class="formField">
                        <label for="diet_name">Diet Name:</label>
                        <input type="text" name="diet[diet_name]" value="<?php echo h($diet->diet_name); ?>">
                    </div>
                    <div>
                        <input type="submit" name="create" value="Create new diet">
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>