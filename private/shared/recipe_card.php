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
            <?php 
            $diets = $recipe->getDiets($recipe->id);
            if (!empty($diets)): 
            ?>
                <?php foreach ($diets as $diet): ?>
                    <img src="<?php echo u($diet->diet_icon_url); ?>" alt="Diet Icon">
                <?php endforeach; ?>
            <?php endif; ?>  
        </div>

        <div class="rating">
            <img src="<?php echo url_for('/images/icon/star.svg'); ?>" width="20" height="20" alt="star icon" title="star icon">
        </div>
    </a>
    </div>
<?php endif; ?>