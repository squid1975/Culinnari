<?php
require_once('../../private/initialize.php'); 
require_login();
$username = $session->username;
$user = User::find_by_username($username);

if (!isset($_GET['cookbook_recipe_id'])) {
    $_SESSION['message'] = 'Error. Please try again later.';
    redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
}

$id = $_GET['cookbook_recipe_id'];
$cookbookRecipe = CookbookRecipe::find_by_id($id);

if ($cookbookRecipe == false) {
    $_SESSION['message'] = 'Cookbook recipe record not found.';
    redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
}

if (is_post_request()) {
   
    $result = $cookbookRecipe->delete();
    if($result) {
        $_SESSION['message'] = 'The recipe was removed from the cookbook.';
        redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
    } else {
        $_SESSION['message'] = 'Something went wrong while removing the recipe.';
        redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
    }
} else {
    // 
    
}