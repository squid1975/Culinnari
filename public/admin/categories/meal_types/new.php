<?php require_once('../../../../private/initialize.php');?>
<title>Create New Meal Type | Culinnari</title>
<?php include(SHARED_PATH . '/public_header.php');
require_mgmt_login();
$meal_type_errors = [];

if(is_post_request()){
    $args = $_POST['meal_type'];
    $mealType = new MealType($args);
    $result = $mealType->save();

    if($result === true){
        $new_id = $mealType->id;
        $_SESSION['message'] = 'The meal type was created successfully.';
        redirect_to(url_for('admin/categories/meal_types/manage.php?meal_type_id=' . $new_id));
    } else {
        $meal_type_errors = $mealType->errors;

    }
    
}
else {
    $mealType = new MealType;
}

?>

<main role="main"  tabindex="-1">
    <div class="adminHero">
        <h2>Management Area : Meal Type</h2>
    </div>
    <div class="wrapper">
        <div>
            &laquo;<a href="<?php echo url_for('/admin/categories/index.php');?>">Back to Categories Index</a>
        </div>
        <div class="manageCategoryWrapper">
            <h2>Create New Meal Type</h2>
            <div class="new">
            <?php if (isset($meal_type_errors['meal_type_name'])): ?>
                <div class="error-messages">
                  <?php foreach ($meal_type_errors['meal_type_name'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            
                <form action="<?php echo url_for('/admin/categories/meal_types/new.php'); ?>" method="post" id="createMealTypeForm">
                    <div class="formField">
                        <label for="mealTypeName">Meal Type Name:</label>
                        <input type="text" name="meal_type[meal_type_name]" id="mealTypeName" value="<?php echo h($mealType->meal_type_name); ?>" pattern="^[A-Za-z\-']+( [A-Za-z\-']+)*$" maxlength="50" required>
                    </div>
                    <div>
                        <input type="submit" name="create" value="Create" class="createUpdateButton">
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>
<script src="<?php echo url_for('/js/admin.js'); ?>" defer></script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>