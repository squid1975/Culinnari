<?php
require_once('../../../../private/initialize.php');
require_mgmt_login();
$id = $_GET['meal_type_id'] ?? '1';
$mealType = MealType::find_by_id($id);
if($mealType === false){
    $_SESSION['message'] = 'Meal type not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}

$meal_type_errors = [];

if(is_post_request()){
    $args = $_POST['meal_type'];
    $mealType->merge_attributes($args);
    $result = $mealType->save();

    if($result){
        $_SESSION['message'] = 'The meal type was updated successfully.';
        redirect_to(url_for('/admin/categories/meal_types/manage.php?meal_type_id=' . $mealType->id));
    }
    else {
        // Handle errors 
        $meal_type_errors = $mealType->errors;
    }
}