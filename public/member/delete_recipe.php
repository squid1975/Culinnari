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
    $default_recipe_image = url_for('/images/default_recipe_image.webp');
    $recipe_image = RecipeImage::find_image_by_recipe_id($id);
    if ($recipe_image_path !== $default_recipe_image) {
        // Convert URL path to absolute server file path
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $recipe_image_path;

        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    $result = $recipe->delete();
    $_SESSION['message'] = 'The recipe was deleted successfully.';
    redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
} else {
    $_SESSION['message'] = 'Something went wrong. Please try again later.';
}
