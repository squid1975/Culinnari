<?php
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all(); 
?>

<div id="searchWithFilters">
    <h2 class="visuallyHidden">Search</h2>
        <form action=<?php echo url_for('/recipes.php'); ?> method="GET" id="searchForm">
            <div id="searchBox">
                <div>
                    <label for="mainSearch" class="visuallyHidden">Search</label>
                    <input type="search" id="mainSearch" name="recipeQuery" placeholder="SEARCH..">
                </div>
                <button type="submit" class="mainSearchButton" aria-label="Search">
                    <img src="images/icon/search.svg" alt="search icon">
                </button>
                </div>
                <h3 id="filterHeading">FILTER BY:</h3>
                <input type="checkbox" id="filterToggle">
                <label for="filterToggle" id="filterToggleLabel">View filters</label>    
                    <div class="filters">
                        <!-- Meal Type Filter -->
                        <div class="searchFilter">
                            <label for="mealType">Meal Type</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <?php foreach ($mealTypes as $mealType): ?>
                                        <label>
                                            <input type="checkbox" name="meal_types[]" id="mealType" value="<?php echo $mealType->id; ?>">
                                            <?php echo ucfirst($mealType->meal_type_name); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Style Filter -->
                        <div class="searchFilter">
                            <label for="style">Style</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                <?php foreach ($styles as $style): ?>
                                        <label>
                                            <input type="checkbox" name="styles[]" id="style" value="<?php echo $style->id; ?>">
                                            <?php echo ucfirst($style->style_name); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Diet Filter -->
                        <div class="searchFilter">
                            <label for="diet">Diet</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <?php foreach ($diets as $diet): ?>
                                        <label>
                                            <input type="checkbox" name="diets[]" id="diet" value="<?php echo $diet->id; ?>">
                                            <?php echo ucfirst($diet->diet_name); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Difficulty Filter -->
                        <div class="searchFilter">
                            <label for="difficulty">Difficulty</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label for="difficultyBeginner"><input type="checkbox" id="difficultyBeginner" name="difficulty[]" value="beginner">Beginner</label>
                                    <label for="difficultyIntermediate"><input type="checkbox" id="difficultyIntermediate" name="difficulty[]" value="intermediate">Intermediate</label>
                                    <label for="difficultyAdvanced"><input type="checkbox" id="difficultyAdvanced" name="difficulty[]" value="advanced"> Advanced</label>
                                </div>
                            </div>
                        </div>

                        

                        <!-- Total Time Filter -->
                        <div class="searchFilter">
                            <label for="prepCookTimeTotal">Total Time</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label><input type="checkbox" name="prepCookTimeTotal[]" value="max15Mins"> 15 mins or less</label>
                                    <label><input type="checkbox" name="prepCookTimeTotal[]" value="max30Mins"> 30 mins or less</label>
                                    <label><input type="checkbox" name="prepCookTimeTotal[]" value="max45mins"> 45 mins or less</label>
                                    <label><input type="checkbox" name="prepCookTimeTotal[]" value="oneTwoHours"> 1-2 hours</label>
                                    <label><input type="checkbox" name="prepCookTimeTotal[]" value="moreThanTwoHours">2+ hours</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sort By Filter -->
                        <div class="searchFilter">
                            <label for="sortBy">Sort By</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label><input type="radio" name="sortBy" value="default">Newest</label>
                                    <label><input type="radio" name="sortBy" value="newest">Oldest</label>
                                    <label><input type="radio" name="sortBy" value="oldest">A-Z</label>
                                    <label><input type="radio" name="sortBy" value="ratingdesc">Rating: High to Low</label>
                                    <label><input type="radio" name="sortBy" value="ratingasc">Rating: Low to High</label>
                                </div>
                            </div>
                        </div>
                    <button type="reset" class="searchReset">Reset</button>
                </div>
                </form>
        </div>