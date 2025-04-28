<?php
require_once('../../../../private/initialize.php');
require_mgmt_login();
$id = $_GET['diet_id'] ?? '1';
$diet = Diet::find_by_id($id);
if($diet === false){
    $_SESSION['message'] = 'Diet not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}

$diet_errors = [];

if(is_post_request()){
    $args = $_POST['diet'];
    $diet->merge_attributes($args);
    $result = $diet->save();

    if($result){
        $_SESSION['message'] = 'The diet was updated successfully.';
        redirect_to(url_for('/admin/categories/diets/manage.php?diet_id=' . $diet->id));
    }
    else {
        // Handle errors 
        $diet_errors = $diet->errors;
    }
}