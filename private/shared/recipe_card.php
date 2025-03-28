<?php if (isset($recipe)): ?>
    <div class="recipeCard">
        <a href="<?php echo url_for('/view_recipe.php?recipe_id=' . $recipe->id); ?>">
            <div class="recipeCardImageContainer">
                <?php 
                $recipeImage = RecipeImage::find_image_by_recipe_id($recipe->id); 
                if ($recipeImage): ?>
                    <img class="recipeCardImage" src="<?php echo url_for($recipeImage->recipe_image); ?>" width="250" height="250" alt="recipe" title="recipe">
                <?php endif; ?>
            </div>

        <p><?php echo h($recipe->recipe_name); ?></p>
        <div class="recipeCardIconsRating">
            <div class="recipeCardDietIcons">
                <?php $diet_icons = Recipe::get_diet_icons($recipe->id); ?>
                <?php if($diet_icons): ?>
                    <?php foreach ($diet_icons as $diet_icon): ?>
                        <img src="<?php echo url_for($diet_icon); ?>" alt="Diet Icon">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="star-rating">
                <?php 
                $average_rating = Rating::get_average_rating($recipe->id);
                if ($average_rating != 0): ?>
                    <div>
                        <?php 
                        $full_stars = floor($average_rating);
                        $partial_star = $average_rating - $full_stars;
                        ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <svg viewBox="0 0 24 24" class="star" width="24" height="24">
                            <defs>
                                <clipPath id="star-clip-<?php echo $recipe->id . '-' . $i; ?>">
                                    <rect width="<?php echo ($i <= $full_stars) ? '100%' : (($i == $full_stars + 1) ? ($partial_star * 100) . '%' : '0%'); ?>" height="100%"></rect>
                                </clipPath>
                            </defs>
                            <!-- Empty Star Outline -->
                            <path d="M12 2L14.9 8.6L22 9.3L16.5 14L18 21L12 17.5L6 21L7.5 14L2 9.3L9.1 8.6L12 2Z" 
                                fill="none" stroke="gold" stroke-width="2"></path>
                            <!-- Filled Star (clipped) -->
                            <path d="M12 2L14.9 8.6L22 9.3L16.5 14L18 21L12 17.5L6 21L7.5 14L2 9.3L9.1 8.6L12 2Z" 
                                fill="gold" clip-path="url(#star-clip-<?php echo $recipe->id . '-' . $i; ?>)"></path>
                        </svg>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
            </div>

            </div>

            <div class="recipeCardUsername">
                <?php $username = Recipe::get_username_by_recipe_id($recipe->id);?>
                <span class="recipeCardUser"> <?php echo h($username); ?></span>
            </div>
    </a>
    </div>
<?php endif; ?>