<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Create Recipe | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<?php
require_login();
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all(); 

if (is_post_request()) {
    if (isset($_FILES['recipeImage']) && $_FILES['recipeImage']['error'] === UPLOAD_ERR_OK) {
        // Get the file details
        $fileTmpPath = $_FILES['recipeImage']['tmp_name'];  // Temporary file location
        $fileName = $_FILES['recipeImage']['name'];  // Original file name
        $fileSize = $_FILES['recipeImage']['size'];  // File size
        $fileType = $_FILES['recipeImage']['type'];  // File MIME type
        
        // Specify allowed file types (image formats)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            // Generate a unique name for the file to avoid overwriting
            $newFileName = uniqid('recipe_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            
            // Define the directory where the file will be stored
            $uploadDir = 'public/images/uploads/recipe_image/';  // Ensure this folder exists and has proper permissions
            
            // Check if the directory exists, if not, create it
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);  // Create the directory with full permissions
            }
            
            // Create the full path for the new file
            $destPath = $uploadDir . $newFileName;

            // Move the uploaded file from temporary location to the desired location
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                echo "File uploaded successfully!";
                
                // Get the relative URL to store in the database
                $imageURL = '/images/uploads/recipe_image/' . $newFileName;

            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.";
            // Use placeholder image if file type is invalid
            $imageURL = '/images/default_recipe_image.webp'; // Replace with your actual placeholder image path
        }
    } else {
        // If no file was uploaded, use placeholder image
        $imageURL = '/images/default_recipe_image.webp'; // Replace with your actual placeholder image path
        $image = $imageURL;
    }
    $selectedMealTypes = isset($_POST['meal_types']) ? $_POST['meal_types'] : [];
    $selectedStyles = isset($_POST['styles']) ? $_POST['styles'] : [];
    $selectedDiets = isset($_POST['diets']) ? $_POST['diets'] : [];
    
    $prep_hours = isset($_POST["prep_hours"]) ? (int)$_POST["prep_hours"] : 0;
    $prep_minutes = isset($_POST["prep_minutes"]) ? (int)$_POST["prep_minutes"] : 0;
    $prep_time_seconds = timetoSeconds($prep_hours, $prep_minutes);

    // Convert Cook Time to Seconds
    $cook_hours = isset($_POST["cook_hours"]) ? (int)$_POST["cook_hours"] : 0;
    $cook_minutes = isset($_POST["cook_minutes"]) ? (int)$_POST["cook_minutes"] : 0;
    $cook_time_seconds = timetoSeconds($cook_hours, $cook_minutes);

    $recipeData = [
        'recipe_name' => $_POST['recipe_name'],
        'recipe_description' => $_POST['recipe_description'],
        'recipe_total_servings' => $_POST['recipe_total_servings'],
        'recipe_prep_time_seconds' => $prep_time_seconds,
        'recipe_cook_time_seconds' => $cook_time_seconds,
        'recipe_difficulty' => $_POST['recipe_difficulty'],
        'user_id' => $_SESSION['user_id'] ?? '1'
    ];

    $ingredients = json_decode($_POST['ingredients']);
    $steps = json_decode($_POST['steps']);
    $image = $imageURL;
    $video = $_POST['recipe_video_url'] ?? '';
    $recipe = Recipe::createRecipe($recipeData, $ingredients, $steps, $image, $video, $selectedDiets, $selectedStyles, $selectedMealTypes);

    if ($recipe) {
        echo "Recipe successfully created!";
        redirect_to(url_for('member/profile.php?id=' . $_SESSION['user_id']));
    } else {
        echo "Something went wrong.";
    }
}
?>
<noscript>
    <div id="js-disabled-modal" class="show">
        <p>JavaScript is required to use this page. Please enable Javascript, then click the link to reload the page.</p>
        <a href="<?php echo url_for('/create_recipe.php'); ?>">Click to reload the page.</a>
    </div>
</noscript>

<main role="main" tabindex="-1">

    <div class="recipeFormWrapper">
        <div class="recipeFormHeading">
            <h2>Recipe Information</h2>
            <p>Fill out the form below to create a new recipe.</p>
        </div>
        <form action="create_recipe.php" method="POST" enctype="multipart/form-data" id="createRecipeForm">
            <label for="recipeName" class="recipePartName">Recipe Name:</label>
            <input type="text" id="recipeName" name="recipe_name" maxlength="100" required>

            <label for="recipeDescription" class="recipePartName">Description:</label>
            <span>Description must be no more than 255 characters.</span>
            <textarea id="recipeDescription" name="recipe_description" maxlength="255" rows="4" cols="50"></textarea>

            <label class="recipePartName">Difficulty:</label>
            <div class="radio-group">
                <input type="radio" id="beginner" name="recipe_difficulty" value="beginner" checked>
                <label for="beginner">Beginner</label>

                <input type="radio" id="intermediate" name="recipe_difficulty" value="intermediate">
                <label for="intermediate">Intermediate</label>

                <input type="radio" id="advanced" name="recipe_difficulty" value="advanced">
                <label for="advanced">Advanced</label>
            </div>
            
            <div id="checkboxes">
                <div class="checkboxContainer">
                    <label for="mealType[meal_type_name]" class="recipePartName">Meal Type:</label>
                    <span>Select up to 3.</span>
                    <?php foreach ($mealTypes as $mealType): ?>
                        <label>
                            <input type="checkbox" name="meal_types[]" value="<?php echo $mealType->meal_type_name; ?>">
                            <?php echo ucfirst($mealType->meal_type_name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="checkboxContainer">
                    <label for="style[style_name]" class="recipePartName">Style:</label>
                    <span>Select up to 3.</span>
                    <?php foreach ($styles as $style): ?>
                        <label>
                            <input type="checkbox" name="styles[]" value="<?php echo $style->style_name; ?>">
                            <?php echo ucfirst($style->style_name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="checkboxContainer">
                    <label for="diet[diet_name]" class="recipePartName">Diet:</label>
                    <span>Select up to 3.</span>
                    <?php foreach ($diets as $diet): ?>
                        <label>
                            <input type="checkbox" name="diets[]" value="<?php echo $diet->diet_name; ?>">
                            <?php echo ucfirst($diet->diet_name); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="timeInput">
                <div id="prepTimeInput">
                    <fieldset>
                        <legend>Prep Time</legend>
                        <div class="prep-time-container">
                            <label for="prep_time_hours"><input type="number" id="prep_time_hours" name="prep_hours" min="0" step="1" placeholder="Hrs"></label>
                            <span>:</span>
                            <label for="prep_time_minutes"><input type="number" id="prep_time_mins" name="prep_minutes" min="0" max="59" step="1" placeholder="Min"></label>
                        </div>
                    </fieldset>
                </div>

                <div id="cookTimeInput">
                    <fieldset>
                        <legend>Cook Time</legend>
                        <div class="prep-time-container">
                            <label for="cook_time_hours"><input type="number" id="cook_time_hours" name="cook_hours" min="0" step="1" placeholder="Hrs"></label>
                            <span>:</span>
                            <label for="cook_time_minutes"><input type="number" id="cook_time_mins" name="cook_minutes" min="0" max="59" step="1" placeholder="Min"></label>
                        </div>
                    </fieldset>
                </div>
            </div>

            <label for="totalServings" class="recipePartName">Total Servings:</label>
            <input type="number" id="totalServings" name="recipe_total_servings" min="0" max="50" step="1">

            <input type="hidden" id="ingredientsInput" name="ingredients" value="">
            <label for="recipeIngredients" class="recipePartName">Ingredients</label>
            <span id="ingredientDirections">Type the measurement amount. Select a unit (if applicable). Then type the ingredient name, and any special instructions (packed, crushed, etc.) into the text box. Click the 'plus' to add your ingredient.</span>
            <input type="text" name="measurementAmount" placeholder="1/2" id="measurementAmount" maxlength="4">
            <select id="ingredientUnit" name="ingredientUnit">
                <option value="n/a" selected>N/A</option>
                <option value="teaspoons">teaspoon(s)</option>
                <option value="tablespoon">tablespoon(s)</option>
                <option value="fluid ounce">fluid ounce(s)</option>
                <option value="cup">cup(s)</option>
                <option value="pint">pint(s)</option>
                <option value="quart">quart(s)</option>
                <option value="gallon">gallon(s)</option>
                <option value="milliliter">milliliter(s)</option>
                <option value="liter">liter(s)</option>
                <option value="ounce">ounce(s)</option>
                <option value="pound">pound(s)</option>
            </select>
            <input type="text" name="ingredientName" placeholder="Cookies (crushed)" id="ingredientName">
            <button type="button" id="addIngredient">+</button>
            <ul id="ingredientsContainer"></ul>

            <label for="recipeSteps" class="recipePartName">Steps:</label>
            <span id="stepDirections">Enter a step to make your recipe. Click the 'plus' to add a step.</span>
            <textarea name="steps[]" placeholder="Describe the step in one or two short sentences." id="stepInput" rows="2" cols="25" maxlength="255"></textarea>
            <button type="button" id="addStep">+</button>
            <ol id="stepsContainer"></ol>
            <input type="hidden" id="stepsInput" name="steps" value="">

            <label for="recipeImage" class="recipePartName">Image Upload</label>
            <input type="file" id="recipeImage" name="recipeImage">
            <img id="imagePreview" src="#" alt="Image Preview" style="display:none; width: 300px; height: auto; margin-top: 10px;">

            <label for="youtube_link" class="recipePartName">YouTube Video Link:</label>
            <input type="url" id="youtube_link" name="recipe_video_url" placeholder="https://www.youtube.com/watch?v=...">

            <div class="submitClearRecipe">
                <input type="submit" value="Create Recipe" id="createRecipe">
                <input type="reset" value="Clear Form" id="clearRecipeForm">
            </div>
        </form>
    </div>
</main>

<script src="<?php echo url_for('js/script.js'); ?>" defer></script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
