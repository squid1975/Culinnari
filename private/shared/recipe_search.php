<?php
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all(); 
?>

<div id="searchWithFilters">
    <h2 class="visuallyHidden">Search</h2>
    <form action="<?php echo url_for('/recipes.php'); ?>" method="GET" id="searchForm">
        <div id="searchBox">
            <div>
                <label for="mainSearch" class="visuallyHidden">Search</label>
                <input type="search" id="mainSearch" name="recipeQuery" pattern="[A-Za-z\s]+" placeholder="SEARCH.." 
                    value="<?php echo isset($_GET['recipeQuery']) ? h($_GET['recipeQuery']) : ''; ?>">
            </div>
            <button type="submit" class="mainSearchButton" aria-label="Search">
                <img src="<?php echo url_for('/images/icon/search.svg'); ?>" width="25" height="25" alt="search icon" >
            </button>
        </div>
        <h3 id="filterHeading">FILTER BY:</h3>
        <input type="checkbox" id="filterToggle">
        <label for="filterToggle" id="filterToggleLabel">View filters</label>    
        <div class="filters">
            <!-- Meal Type Filter -->
            <div class="searchFilter">
                <fieldset>
                    <legend>Meal Type</legend>
                <div class="dropdown">
                    <button type="button" class="dropdown-button">ANY</button> 
                    <div class="dropdown-content">
                        <?php foreach ($mealTypes as $mealType): ?>
                            <label>
                                <input type="checkbox" name="mealTypes[]" id="mealType-<?php echo $mealType->id; ?>" value="<?php echo $mealType->id; ?>"
                                    <?php echo isset($_GET['mealTypes']) && in_array($mealType->id, $_GET['mealTypes']) ? 'checked' : ''; ?>>
                                <?php echo ucfirst($mealType->meal_type_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                </fieldset>
            </div>

            <!-- Style Filter -->
            <div class="searchFilter">
                <fieldset>
                    <legend>Style</legend>
                <div class="dropdown">
                    <button type="button" class="dropdown-button">ANY</button> 
                    <div class="dropdown-content">
                        <?php foreach ($styles as $style): ?>
                            <label>
                                <input type="checkbox" name="styles[]" id="style-<?php echo $style->id; ?>" value="<?php echo $style->id; ?>"
                                    <?php echo isset($_GET['styles']) && in_array($style->id, $_GET['styles']) ? 'checked' : ''; ?>>
                                <?php echo ucfirst($style->style_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                </fieldset>
            </div>

            <!-- Diet Filter -->
            <div class="searchFilter">
                <fieldset>
                    <legend>Diet</legend>
                <div class="dropdown">
                    <button type="button" class="dropdown-button">ANY</button> 
                    <div class="dropdown-content">
                        <?php foreach ($diets as $diet): ?>
                            <label>
                                <input type="checkbox" name="diets[]" id="diet-<?php echo $diet->id; ?>" value="<?php echo $diet->id; ?>"
                                    <?php echo isset($_GET['diets']) && in_array($diet->id, $_GET['diets']) ? 'checked' : ''; ?>>
                                <?php echo ucfirst($diet->diet_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                </fieldset>
            </div>

            <!-- Difficulty Filter -->
            <div class="searchFilter">
                <fieldset>
                    <legend>Difficulty</legend>
                <div class="dropdown">
                    <button type="button" class="dropdown-button">ANY</button> 
                    <div class="dropdown-content">
                        <label><input type="checkbox" id="difficultyBeginner" name="difficulty[]" value="beginner" 
                            <?php echo isset($_GET['difficulty']) && in_array('beginner', $_GET['difficulty']) ? 'checked' : ''; ?>>Beginner</label>
                        <label><input type="checkbox" id="difficultyIntermediate" name="difficulty[]" value="intermediate" 
                            <?php echo isset($_GET['difficulty']) && in_array('intermediate', $_GET['difficulty']) ? 'checked' : ''; ?>>Intermediate</label>
                        <label><input type="checkbox" id="difficultyAdvanced" name="difficulty[]" value="advanced" 
                            <?php echo isset($_GET['difficulty']) && in_array('advanced', $_GET['difficulty']) ? 'checked' : ''; ?>>Advanced</label>
                    </div>
                </div>
                </fieldset>
            </div>

            <!-- Total Time Filter -->
            <div class="searchFilter">
                <fieldset>
                    <legend>Total Time</legend>
                <div class="dropdown">
                    <button type="button" class="dropdown-button">ANY</button> 
                    <div class="dropdown-content">
                        <label><input type="checkbox" name="prepCookTimeTotal[]" value="900" 
                            <?php echo isset($_GET['prepCookTimeTotal']) && in_array('900', $_GET['prepCookTimeTotal']) ? 'checked' : ''; ?>>15 min or less</label>
                        <label><input type="checkbox" name="prepCookTimeTotal[]" value="1800" 
                            <?php echo isset($_GET['prepCookTimeTotal']) && in_array('1800', $_GET['prepCookTimeTotal']) ? 'checked' : ''; ?>>30 min or less</label>
                        <label><input type="checkbox" name="prepCookTimeTotal[]" value="2700" 
                            <?php echo isset($_GET['prepCookTimeTotal']) && in_array('2700', $_GET['prepCookTimeTotal']) ? 'checked' : ''; ?>>45 min or less</label>
                        <label><input type="checkbox" name="prepCookTimeTotal[]" value="3600-7200" 
                            <?php echo isset($_GET['prepCookTimeTotal']) && in_array('3600-7200', $_GET['prepCookTimeTotal']) ? 'checked' : ''; ?>>1-2 hours</label>
                        <label><input type="checkbox" name="prepCookTimeTotal[]" value="7200+" 
                            <?php echo isset($_GET['prepCookTimeTotal']) && in_array('7200+', $_GET['prepCookTimeTotal']) ? 'checked' : ''; ?>>2+ hours</label>
                    </div>
                </div>
                </fieldset>
            </div>

            <!-- Sort By Filter -->
            <div class="searchFilter">
                <fieldset>
                    <legend>Sort By</legend>
                <div class="dropdown">
                    <button type="button" id="sortByButton">Newest</button> 
                    <div class="dropdown-content">
                        <label><input type="radio" name="sortBy" value="recipe[recipe_post_date] DESC" 
                            <?php echo (!isset($_GET['sortBy']) || $_GET['sortBy'] == 'recipe[recipe_post_date] DESC') ? 'checked' : ''; ?>>Newest</label>
                        <label><input type="radio" name="sortBy" value="recipe[recipe_post_date] ASC" 
                            <?php echo isset($_GET['sortBy']) && $_GET['sortBy'] == 'recipe[recipe_post_date] ASC' ? 'checked' : ''; ?>>Oldest</label>
                        <label><input type="radio" name="sortBy" value="recipe[recipe_name] ASC" 
                            <?php echo isset($_GET['sortBy']) && $_GET['sortBy'] == 'recipe[recipe_name] ASC' ? 'checked' : ''; ?>>A-Z</label>
                        <label><input type="radio" name="sortBy" value="rating[rating_value] DESC" 
                            <?php echo isset($_GET['sortBy']) && $_GET['sortBy'] == 'rating[rating_value] DESC' ? 'checked' : ''; ?>>Rating: High to Low</label>
                        <label><input type="radio" name="sortBy" value="rating[rating_value] ASC" 
                            <?php echo isset($_GET['sortBy']) && $_GET['sortBy'] == 'rating[rating_value] ASC' ? 'checked' : ''; ?>>Rating: Low to High</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <button type="reset" class="searchReset">Reset</button>
        </div>
    </form>
</div>
