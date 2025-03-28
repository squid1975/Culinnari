<?php require_once('../../../../private/initialize.php');?>
<title>Manage Diet</title>
<?php include(SHARED_PATH . '/public_header.php');

$dietId = $_GET['id'] ?? '1';
$diet = Diet::find_by_id($dietId);
if($diet === false){
    redirect_to(url_for('/admin/index.php'));
}

?>
<main role="main"  tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : Diet</h2>
    </div>
    <div id="wrapper">
        <div class="manageCategoryCard">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/index.php');?>">Back to Admin Management Index</a>
            </div>
            <h2>Manage Meal Type: <?php echo h($diet->diet_name); ?> </h2>
            <div class="edit">
                <h3>Edit Diet</h3>
                <form action="" method="post">
                    <div>
                        <label for="meal_type_name">Diet Name:</label>
                        <input type="text" name="diet['diet_name']" value="<?php echo h($diet->diet_name); ?>">
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
            <div class="delete">
                <h3>Delete Diet</h3>
                <p>Are you sure you want to delete this diet?
                    <strong>This cannot be undone.</strong>
                </p>
                <form action="" method="post">
                    <div>
                        <input type="hidden" name="diet['id']" value=<?php echo $diet->id; ?>>
                        <input type="submit" name="delete" value="Delete">
                    </div>
                </form>
        </div>
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>