<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "My Profile | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<main id="userProfile" role="main" tabindex="-1">
    <h2>My Culinnari Profile</h2>
    <h3>Hello, Username!</h3>

    <section>
        <div class="profileSectionHead">
            <h3>My Recipes</h3>
            <a href="create_recipe.php" class="secondaryButton">Create recipe</a>
        </div>
        <div class="profileCards">
        
    </section>

    <section>
        <div class="profileSectionHead">
            <h3>My Cookbook</h3>
            <a href="create_cookbook.php"  class="secondaryButton">Create cookbook</a>
    </section>
</main>