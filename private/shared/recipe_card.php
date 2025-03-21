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
            <?php $diet_icons = Recipe::get_diet_icons($recipe->id); ?>
            <?php if($diet_icons): ?>
                <?php foreach ($diet_icons as $diet_icon): ?>
                    <img src="<?php echo $diet_icon; ?>" alt="Diet Icon">
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="rating">
            
        </div>
    </a>
    </div>
<?php endif; ?>