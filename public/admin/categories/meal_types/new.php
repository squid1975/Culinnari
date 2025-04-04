<?php require_once('../../../../private/initialize.php');?>
<title>Create New Meal Type | Culinnari</title>
<?php include(SHARED_PATH . '/public_header.php');
require_mgmt_login();

if(is_post_request()){
    $args = $_POST['meal_type'];
    $mealType = new MealType($args);
    $result = $mealType->save();

    if($result === true){
        $new_id = $mealType->id;
        $_SESSION['message'] = 'The meal type was created successfully.';
        redirect_to(url_for('/manage.php?mealType_id=' . $new->id));
    } else {

    }
    
}
else {
    $mealType = new MealType;
}

?>

<main role="main"  tabindex="-1">
    <div id="adminHero">
        <h2>Management Area : Meal Type</h2>
    </div>
    <div class="wrapper">
        <div class="manageCategoryCard">
            <div>
                &laquo;<a href="<?php echo url_for('/admin/index.php');?>">Back to Admin Management Index</a>
            </div>
            <h2>Create New Meal Type</h2>
            <div class="new">
                <form action="" method="post">
                    <div class="formField">
                        <label for="meal_type_name">Meal Type Name:</label>
                        <input type="text" name="meal_type[meal_type_name]" value="<?php echo h($mealType->meal_type_name); ?>" required>
                    </div>
                    <div>
                        <input type="submit" name="create" value="Create" class="primaryButton">
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>