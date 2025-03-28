<?php require_once('../../../../private/initialize.php');?>
<title>Manage Meal Type</title>
<?php include(SHARED_PATH . '/public_header.php');

$mealTypeId = $_GET['meal_type_id'] ?? '1';
$mealType = MealType::find_by_id($mealTypeId);
if($mealType === false){
    redirect_to(url_for('/admin/index.php'));
}

if(is_post_request()){
    if(isset($_POST['update'])){
        $args = $_POST['mealType'];
        $mealType->merge_attributes($args);
        $result = $mealType->save();
        if($result === true){
            $_SESSION['message'] = 'The meal type was updated successfully.';
            redirect_to(url_for('/admin/categories/mealTypes/manage.php?mealType_id=' . $mealTypeId));
        }
    }
    if(isset($_POST['delete'])){
        $result = $mealType->delete();
        if($result === true){
            $_SESSION['message'] = 'The meal type was deleted successfully.';
            redirect_to(url_for('/admin/index.php'));
        }
        else {
            
        }
    }

}

?>

<main role="main"  tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : Meal Type</h2>
    </div>
    <div id="wrapper">
        <div class="manageCategoryCard">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/index.php');?>">Back to Admin Management Index</a>
            </div>
            <h2>Manage Meal Type: <?php echo h($mealType->meal_type_name); ?> </h2>
            <div class="edit">
                <h3>Edit Meal Type</h3>
                <form action="" method="post">
                    <div class="formField">
                        <label for="meal_type_name">Meal Type Name:</label>
                        <input type="text" name="mealType['meal_type_name']" value="<?php echo h($mealType->meal_type_name); ?>">
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
            <div class="delete">
                <h3>Delete Meal Type</h3>
                <p>Are you sure you want to delete this Meal Type?
                    <strong>This cannot be undone.</strong>
                </p>
                <form action="" method="post">
                    <div>
                        <input type="submit" name="delete" value="Delete">
                    </div>
                </form>
        </div>
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>