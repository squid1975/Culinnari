
<div class="recipeCard">
    <a href="<?php echo url_for('/recipe.php'); ?>">
        <img class="recipeCardImage" src="<?php echo url_for('/images/uploads/recipe_image/food_placeholder.jpg');?>" width="250" height="250" alt="recipe" title="recipe ">
        <p>This is the name of the recipe</p>
        <div class="recipeCardDietIcons">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg');?>" width="20" height="20" alt="gluten free icon" title="Gluten free recipe icon">
            <img src="<?php echo url_for('/images/icon/dietIcons/keto.svg');?>" width="20" height="20" alt="keto icon" title="Keto recipe icon">
            <img src="<?php echo url_for('/images/icon/dietIcons/lowCarb.svg');?>" width="20" height="20" alt="Low carb icon" title="Low carb recipe icon">
        </div>
        <div class="rating">
            <img src="<?php echo url_for('/images/icon/star.svg');?>" width="20" height="20" alt="star icon" title="star icon">
        </div>
    </a>
</div>