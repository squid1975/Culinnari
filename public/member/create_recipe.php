<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Create Recipe | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all(); 
require_login();


if (is_post_request()){
    $recipeData = [
        'recipe_name' => $_POST['recipe_name'],
        'recipe_description' => $_POST['recipe_description'],
        'recipe_total_servings' => $_POST['recipe_total_servings'],
        'recipe_prep_time_seconds' => $_POST['recipe_prep_time_seconds'],
        'recipe_cook_time_seconds' => $_POST['recipe_cook_time_seconds'],
        'recipe_difficulty' => $_POST['recipe_difficulty'],
        'user_id' => $_SESSION['user_id'] ?? null 
    ];

    $ingredients = $_POST['ingredients']; // Array from form
    $steps = $_POST['steps']; // Array from form
    $image = $_POST['recipe_image'];
    $video = $_POST['recipe_video_url'];

    $recipe = createRecipe($recipeData, $ingredients, $steps, $image, $video);

    if ($recipe) {
        echo "Recipe successfully created!";
        redirect_to(url_for('member/profile.php?id=' . $session->username));
    } else {
        echo "Something went wrong.";
    }

}
?>

<main role="main" tabindex="-1">

        <div class="recipeFormWrapper">
        <div class="recipeFormHeading">
            <h2>Recipe Information</h2>
            <p>Fill out the form below to create a new recipe.</p>
        </div>
        <form action="create_recipe.php" method="POST" enctype="multipart/form-data" ID="createRecipeForm">
            <label for="recipeName" class="recipePartName">Recipe Name:</label>
            <input type="text" id="recipeName" name="recipe[recipe_name]" maxlength="100" required>

            <label for="recipeDescription" class="recipePartName">Description:</label>
            <span>Description must be no more than 255 characters.</span>
            <textarea id="recipeDescription"  name="recipe[recipe_description]" maxlength="255" rows="4" cols="50"></textarea>

            <label class="recipePartName">Difficulty:</label>
            <div class="radio-group">
                <input type="radio" id="beginner" name="recipe[recipe_difficulty]" value="beginner" checked>
                <label for="beginner">Beginner</label>

                <input type="radio" id="intermediate" name="recipe[recipe_difficulty]" value="intermediate">
                <label for="intermediate">Intermediate</label>

                <input type="radio" id="advanced" name="recipe[recipe_difficulty]" value="advanced">
                <label for="advanced">Advanced</label>
            </div>
            
            <div id="checkboxes">
                <div class="checkboxContainer">
                    <label for="mealType[meal_type_name]" class="recipePartName">Meal Type:</label>
                    <?php foreach ($mealTypes as $mealType): ?>
                        <label>
                            <input type="checkbox" name="mealType[meal_type_name][]" value="<?php echo $mealType->meal_type_name; ?>">
                            <?php echo ucfirst($mealType->meal_type_name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="checkboxContainer">
                    <label for="style[style_name]" class="recipePartName">Style:</label>
                    <?php foreach ($styles as $style): ?>
                        <label>
                            <input type="checkbox" name="style[style_name][]" value="<?php echo $style->style_name; ?>">
                            <?php echo ucfirst($style->style_name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="checkboxContainer">
                    <label for="diet[diet_name]" class="recipePartName">Diet:</label>
                    <?php foreach ($diets as $diet): ?>
                        <label>
                            <input type="checkbox" name="diet[diet_name][]" value="<?php echo $diet->diet_name; ?>">
                            <?php echo ucfirst($diet->diet_name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="timeInput">
                <div id="prepTimeInput">
                    <label for="prep_time" class="recipePartName" >Prep Time:</label>
                    <div class="prep-time-container">
                        <input type="number" id="prep_time" name="prep_hours" min="0" step="1" placeholder="Hrs">
                        <span>:</span>
                        <input type="number" id="prep_time" name="prep_minutes" min="0" max="59" step="1" placeholder="Min">
                    </div>
                </div>

                <div id="cookTimeInput">
                    <label for="cook_time" class="recipePartName">Cook Time:</label>
                    <div class="prep-time-container">
                        <input type="number" id="cook_time" name="recipe[cook_hours]" min="0" step="1" placeholder="Hrs">
                        <span>:</span>
                        <input type="number" id="cook_time" name="recipe[cook_minutes]" min="0" max="59" step="1" placeholder="Min">
                    </div>
                </div>
            </div>
            <label for="totalServings" class="recipePartName">Total Servings:</label>
                <input type="number" id="totalServings" name="recipe[totalServings]" min="0" max="50" step="1">
            
            
            <label for="recipeIngredients" class="recipePartName">Ingredients</label>
            <span id="ingredientDirections">Type the measurement amount. Select a unit (if applicable). Then type the ingredient name, and any special instructions (packed, crushed, etc.) into the  text box. Click the 'plus' to add your ingredient.</span>
            <input type="text" name="measurementAmount" placeholder="1/2" id="measurementAmount" maxlength="4">
            <select id="ingredientUnit" name="ingredientUnit" id="ingredientUnit">
                <option value="n/a" selected>N/A</option>
                <option value="teaspoons">teaspoon(s)</option>
                <option value="tablespoon">tablespoon(s)</option>
                <option value="fluid ounce">fluid ounce(s)</option>
                <option value="cup">cup(s)</option>
                <option value="pint">pint(s)</option>
                <option value="quart">quart(s)</option>
                <option value="gallon">gallon(s)</option>
                <option value="milliter">milliter(s)</option>
                <option value="liter">liter(s)</option>
                <option value="ounce">ounce(s)</option>
                <option value="pound">pound(s)</option>
            </select>
            <input type="text" name="ingredientName" placeholder="Cookies (crushed)" required id="ingredientName">
            <button type="button" id="addIngredient">+</button>
            <ul id="ingredientsContainer"></ul>

            <label for="recipeSteps" class="recipePartName">Steps:</label>
            <span id="stepDirections">Enter a step to make your recipe. Click the 'plus' to add a step.</span>
            <input type="textarea" name="step" placeholder="Step 1" id="stepInput">
            <button type="button" id="addStep">+</button>
            <ul id="stepsContainer"></ul>

            
            <label for="recipeImage" class="recipePartName">Image Upload</label>
            <input type="file" id="recipeImage" name="recipe[recipe_image]">

            <label for="youtube_link" class="recipePartName">YouTube Video Link:</label>
            <input type="url" id="youtube_link" name="recipe[recipe_video_url]" placeholder="https://www.youtube.com/watch?v=...">
            <div class="submitClearRecipe">
                <input type="submit" value="Create Recipe" id="createRecipe">
                <input type="reset" value="Clear Form" id="clearRecipeForm">
            <div class="submitClearRecipe">

        </form>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>