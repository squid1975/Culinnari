<?php
require_once('../../../../private/initialize.php');
require_mgmt_login();
$id = $_GET['style_id'] ?? '1';
$style = Style::find_by_id($id);
if($style === false){
    $_SESSION['message'] = 'Style not found.';
    redirect_to(url_for('/admin/categories/index.php'));
}


if(is_post_request()){
    $args = $_POST['style'] ?? [];
    $style->merge_attributes($args);
    $result = $style->save();

    if($result){
        $_SESSION['message'] = 'The style was updated successfully.';
    } else {
        $_SESSION['style_errors'] = $style->errors; // <-- store errors in session
    }

    // Redirect either way
    redirect_to(url_for('/admin/categories/styles/manage.php?style_id=' . $style->id));
}