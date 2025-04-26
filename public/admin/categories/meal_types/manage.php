<?php require_once('../../../../private/initialize.php');?>
<title>Manage Meal Type</title>
<?php include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

$mealTypeId = $_GET['meal_type_id'] ?? '1';
$mealType = MealType::find_by_id($mealTypeId);
if($mealType === false){
    $_SESSION['message'] = 'Meal type not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}

if(is_post_request()){
    if(isset($_POST['update'])){
        $args = $_POST['mealType'];
        $mealType->merge_attributes($args);
        $result = $mealType->save();
        if($result === true){
            $_SESSION['message'] = 'The meal type was updated successfully.';
            redirect_to(url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . $mealTypeId));
        } else {
            // show errors
            $meal_type_errors = $mealType->errors;
        }
    }
    if(isset($_POST['delete'])){
        $result = $mealType->delete();
        if($result === true){
            $_SESSION['message'] = 'The meal type was deleted successfully.';
            redirect_to(url_for('/admin/categories/index.php'));
        }
       
    }

} else {
    // Display the form
    // No action needed here as we are already fetching the meal type details above
}

?>

<main role="main"  tabindex="-1">
    <div class="adminHero">
        <h2>Management Area : Meal Type</h2>
    </div>
    <div class="wrapper">
        <div class="manageCategoryWrapper">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/categories/index.php');?>">Back to Categories Index</a>
            </div>
            <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
        <section>
            <h2>Manage Meal Type: <?php echo h($mealType->meal_type_name); ?> </h2>
            <?php if(!empty($meal_type_errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach($meal_type_errors as $error): ?>
                        <li><?php echo h($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <div class="edit">
                <h3>Edit Meal Type</h3>
                <form action=""<?php echo url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . $mealType->id);?>"" method="post">
                    <div class="formField">
                        <label for="meal_type_name">Meal Type Name:</label>
                        <input type="text" name="mealType[meal_type_name]" id="meal_type_name" pattern="/^[A-Za-z\-']+$/" value="<?php echo h($mealType->meal_type_name); ?>" required maxlength="50">
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
        </section>
        <section>
            <div class="delete">
                <h3>Delete Meal Type</h3>
                <p>Are you sure you want to delete this Meal Type?
                    <strong>This cannot be undone.</strong>
                </p>
                <form action="<?php echo url_for('/admin/categories/meal_types/manage.php?meal_type_id' . $mealType->id); ?>" method="post">
                    <div>
                        <input type="hidden" name="mealType[id]" value=<?php echo $mealType->id; ?>>
                        <input type="submit" name="delete" value="Delete">
                    </div>
                </form>
        </section>        
            </div>
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>