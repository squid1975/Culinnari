<?php require_once('../../../../private/initialize.php');
$title = 'Manage Meal Type | Culinnari';
include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

$id = $_GET['meal_type_id'] ?? '1';
$meal_type = MealType::find_by_id($id);
if($meal_type === false){
    $_SESSION['message'] = 'Meal Type not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}

$meal_type_errors = [];
if(is_post_request()){
    if(isset($_POST['update'])){
        $args = $_POST['meal_type'];
        $meal_type->merge_attributes($args);
        $result = $meal_type->save();
        if($result === true){
            $_SESSION['message'] = 'The meal type was updated successfully.';
            redirect_to(url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . $meal_type->id));
        } else {
            // show errors
            $meal_type_errors = $meal_type->errors;
        }
    }

    if(isset($_POST['delete'])){
        $result = $meal_type->delete();
        if($result === true){
            $_SESSION['message'] = 'The meal type was deleted successfully.';
            redirect_to(url_for('/admin/categories/index.php'));
        }
        else {
            // Handle error
            $_SESSION['message'] = 'Error deleting meal type';
            redirect_to(url_for('/admin/categories/styles/manage.php?meal_type_id=' . $meal_type->id));
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
            <h2>Manage Meal Type: <?php echo h($meal_type->meal_type_name); ?> </h2>
            <?php if (isset($meal_type_errors['meal_type_name'])): ?>
                <div class="error-messages">
                  <?php foreach ($meal_type_errors['meal_type_name'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            
            <div class="edit">
                <h3>Edit Meal Type</h3>
                <form action="<?php echo url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . $meal_type->id);?>" method="post">
                    <div class="formField">
                        <label for="meal_type_name">Meal Type Name:</label>
                        <input type="text" name="meal_type[meal_type_name]" id="meal_type_name" pattern="/^[A-Za-z\-']+$/" value="<?php echo h($meal_type->meal_type_name); ?>" required maxlength="50">
                    </div>
                    <div>
                        <input type="submit" name="update" value="Update" class="createUpdateButton">
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
                <form action="<?php echo url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . $meal_type->id);?>" method="post">
                    <input type="hidden" name="meal_type[id]" value="<?php echo $meal_type->id; ?>">
                    <div>
                        <input type="submit" name="delete" value="Delete" class="deleteButton">
                    </div>
                </form>
        </section>        
            </div>
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>