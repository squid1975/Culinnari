<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Create Recipe | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<h2>Create a Recipe</h2>
<form action="create_recipe.php" method="POST" enctype="multipart/form-data">
    <label for="recipeName">Name:</label>
    <input type="text" id="recipeName" name="recipeName">

    <label for="recipeDescription">Description:</label>
    <p>Description must be no more than 255 characters.</p>
    <textarea id="description"  name="description" maxlength="255" rows="4" cols="50"></textarea>
    <br>
    <label for="recipeMealType">Meal Type:</label>
    <label><input type="checkbox" name="mealType[]" value="appetizer"> Appetizer</label>
    <label><input type="checkbox" name="mealType[]" value="breakfast"> Breakfast</label>
    <label><input type="checkbox" name="mealType[]" value="brunch"> Brunch</label>
    <label><input type="checkbox" name="mealType[]" value="dessert"> Dessert</label>
    <label><input type="checkbox" name="mealType[]" value="dinner"> Dinner</label>
    <label><input type="checkbox" name="mealType[]" value="lunch"> Lunch</label>
    <label><input type="checkbox" name="mealType[]" value="snack"> Snack</label>
    <br>
    <label for="recipeStyle">Style:</label>
    <label><input type="checkbox" name="style[]" value="asian"> Asian</label>
    <label><input type="checkbox" name="style[]" value="caribbean"> Caribbean</label>
    <label><input type="checkbox" name="style[]" value="fusion"> Fusion</label>
    <label><input type="checkbox" name="style[]" value="italian"> Italian</label>
    <label><input type="checkbox" name="style[]" value="latinAmerican"> Latin American</label>
    <label><input type="checkbox" name="style[]" value="mediterranean"> Mediterranean</label>
    <label><input type="checkbox" name="style[]" value="thai"> Thai</label>
    <br>
    <label for="recipeDietType">Diet:</label>
    <label><input type="checkbox" name="diet[]" value="glutenFree"> Gluten-Free</label>
    <label><input type="checkbox" name="diet[]" value="keto"> Keto</label>
    <label><input type="checkbox" name="diet[]" value="low-carb"> Low Carb</label>
    <label><input type="checkbox" name="diet[]" value="paleo"> Paleo</label>
    <label><input type="checkbox" name="diet[]" value="sugarFree"> Sugar-Free</label>
    <label><input type="checkbox" name="diet[]" value="vegan"> Vegan</label>
    <label><input type="checkbox" name="diet[]" value="vegetarian"> Vegetarian</label>
    <br>
    <label for="prep_hours">Prep Time:</label>
    <div class="prep-time-container">
        <input type="number" id="prep_hours" name="prep_hours" min="0" step="1" placeholder="Hrs">
        <span>:</span>
        <input type="number" id="prep_minutes" name="prep_minutes" min="0" max="59" step="1" placeholder="Minutes">
    </div>
    <br>
    <label for="prep_hours">Cook Time:</label>
    <div class="prep-time-container">
        <input type="number" id="prep_hours" name="prep_hours" min="0" step="1" placeholder="Hrs">
        <span>:</span>
        <input type="number" id="prep_minutes" name="prep_minutes" min="0" max="59" step="1" placeholder="Min">
    </div>
    <br>
    <label for="totalServings">Total Servings:</label>
        <input type="number" id="totalServings" name="totalServings" min="0" max="50" step="1">
    
    <br>
    <label for="recipeIngredients">Ingredients</label>
    <span>Type the measurement amount. Select a unit if needed. Then type the ingredient name, and any special instructions (packed, crushed, etc.) into the  text box. Click the 'plus' to add your ingredient.</span>
    <input type="text" name="measurementAmount" placeholder="1/2">
    <select id="ingredientUnit" name="ingredientUnit">
        <option value="anyRating" selected>ANY</option>
        <option value="teaspoons">teaspoon(s)</option>
        <option value="tablespoon">tablespoon(s)</option>
        <option value="fluidOunce">fluid ounce(s)</option>
        <option value="cup">cup(s)</option>
        <option value="pint">pint(s)</option>
        <option value="quart">quart(s)</option>
        <option value="gallon">gallon(s)</option>
        <option value="milliter">pint(s)</option>
        <option value="liter">pint(s)</option>
        <option value="ounce">pint(s)</option>
        <option value="pound">pint(s)</option>
    </select>
    <input type="text" name="ingredientName" placeholder="Cookies (crushed)" required>

    <br>
    <label for="recipeImage">Image Upload</label>
    <input type="file" id="recipe_image" name="recipe_image">

    <label for="youtube_link">YouTube Video Link:</label>
    <input type="url" id="youtube_link" name="youtube_link" placeholder="https://www.youtube.com/watch?v=...">

</form>