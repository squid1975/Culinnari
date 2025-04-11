<?php
require_once('../../private/initialize.php'); 
require_login();
if(!isset($_GET['recipe_id'])) {
    redirect_to(url_for('/index.php'));
  }
$id = $_GET['recipe_id'];
$recipe = Recipe::find_by_id($id);
if($recipe == false){
    $_SESSION['message'] = 'Recipe not found.';
}

if(is_post_request()){
    $result = $recipe->delete();
    $_SESSION['message'] = 'The recipe was deleted successfully.';
    redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
} else {
    $_SESSION['message'] = 'Something went wrong. Please try again later.';
}
