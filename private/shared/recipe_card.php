<?php if (isset($recipe)): ?>
    <div class="recipeCard">
        <a href="<?php echo url_for('/view_recipe.php?recipe_id=' . $recipe->id); ?>">
        <?php 
        $recipeImage = RecipeImage::find_image_by_recipe_id($recipe->id); 
        if ($recipeImage):  // Ensure an image exists before displaying
        ?>
            <img class="recipeCardImage" src="<?php echo url_for($recipeImage->recipe_image); ?>" width="250" height="250" alt="recipe" title="recipe">
        <?php endif; ?>

        <p><?php echo h($recipe->recipe_name); ?></p>

        <div class="recipeCardDietIcons">
            <img src="<?php echo url_for('/images/icon/dietIcons/keto.svg'); ?>" width="20" height="20" alt="diet icon">
            <img src="<?php echo url_for('/images/icon/dietIcons/paleo.svg'); ?>" width="20" height="20" alt="diet icon"> 
            <img src="<?php echo url_for('/images/icon/dietIcons/sugarFree.svg'); ?>" width="20" height="20" alt="diet icon"> 
            <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">   
        </div>

        <div class="rating">
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
        </div>
    </a>
    </div>
<?php endif; ?>