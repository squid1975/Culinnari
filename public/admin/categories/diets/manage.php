<?php require_once('../../../../private/initialize.php');?>
$title = 'Manage Diet | Culinnari';
<?php include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

$dietId = $_GET['diet_id'] ?? 1;
$diet = Diet::find_by_id($dietId);
if($diet === false){
    redirect_to(url_for('/admin/categories/index.php'));
}
if(is_post_request()){
    if(isset($_POST['update'])){
        $args = $_POST['diet'];
        $diet->merge_attributes($args);
        $result = $diet->save();
        if($result === true){
            $_SESSION['message'] = 'The diet was updated successfully.';
            redirect_to(url_for('/admin/categories/diets/manage.php?diet_id=' . $dietId));
        }
    }
    if(isset($_POST['delete'])){
        $result = $diet->delete();
        if($result === true){
            $_SESSION['message'] = 'The diet was deleted successfully.';
            redirect_to(url_for('/admin/categories/index.php'));
        }
        else {
            
        }
    }

}

?>
<main role="main"  tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : Diet</h2>
    </div>
    <div class="wrapper">
        <div class="manageCategoryWrapper">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/index.php');?>">Back to Admin Management Index</a>
            </div>
            <section>
            <h2>Manage Diet: <?php echo h($diet->diet_name); ?> </h2>
            <div class="edit">
                <h3>Edit Diet</h3>
                <form action="<?php echo (url_for('/admin/categories/diets/manage.php?diet_id=' . $dietId));?>" method="post">
                    <div>
                        <label for="meal_type_name">Diet Name:</label>
                        <input type="text" name="diet[diet_name]" value="<?php echo h($diet->diet_name); ?>" required>
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
            </section>
            <section>
            <div class="delete">
                <h2>Delete Diet</h2>
                <p>Are you sure you want to delete this diet?
                    <strong>This cannot be undone.</strong>
                </p>
                <form action="<?php echo(url_for('/admin/categories/diets/manage.php?diet_id=' . $dietId)); ?>" method="post">
                    <div>
                        <input type="hidden" name="diet[id]" value=<?php echo $diet->id; ?>>
                        <input type="submit" name="delete" value="Delete">
                    </div>
                </form>
                </div>
            </section>
        </div>
        
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>