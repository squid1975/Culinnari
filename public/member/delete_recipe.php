<?php
require_once('../../private/initialize.php'); 
require_login();
$username = $session->username;
$user = User::find_by_username($username);

if (!isset($_GET['recipe_id'])) {
    $_SESSION['message'] = 'Error. Please try again later.';
    redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
}

$id = $_GET['recipe_id'];
$recipe = Recipe::find_by_id($id);



if ($recipe == false) {
    $_SESSION['message'] = 'Recipe not found.';
    redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
}

if (is_post_request()) {
    $default_recipe_image = '/images/default_recipe_image.webp';
    $recipe_image = RecipeImage::find_image_by_recipe_id($id);

    if ($recipe_image && $recipe_image->recipe_image !== $default_recipe_image) {
        // This gives the full path to the image on disk
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $recipe_image->recipe_image;

        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $result = $recipe->delete();
    if($result === true){
        $_SESSION['message'] = 'The recipe was deleted successfully.';
        redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
    } else {
        $_SESSION['message'] = 'Unable to delete recipe. Try again later.';
        redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
    }
} else {
    //
}