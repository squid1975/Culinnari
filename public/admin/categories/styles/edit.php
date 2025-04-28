<?php
require_once('../../../../private/initialize.php');
require_mgmt_login();
$id = $_GET['style_id'] ?? '1';
$style = Style::find_by_id($id);
if($style === false){
    $_SESSION['message'] = 'Style not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}

$style_errors = [];

if(is_post_request()){
    $args = $_POST['style'];
    $style->merge_attributes($args);
    $result = $style->save();

    if($result){
        $_SESSION['message'] = 'The style was updated successfully.';
        redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $style->id));
    }
    else {
        // Handle errors 
        $style_errors = $style->errors;
    }
}