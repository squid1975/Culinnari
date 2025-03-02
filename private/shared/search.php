<!--  -->

<div id="searchWithFilters">
    <h2 class="visuallyHidden">Search</h2>
        <form action="recipes.php" method="GET" id="searchForm">
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
                                    <label><input type="checkbox" name="mealType[]" value="appetizer"> Appetizer</label>
                                    <label><input type="checkbox" name="mealType[]" value="breakfast"> Breakfast</label>
                                    <label><input type="checkbox" name="mealType[]" value="brunch"> Brunch</label>
                                    <label><input type="checkbox" name="mealType[]" value="dessert"> Dessert</label>
                                    <label><input type="checkbox" name="mealType[]" value="dinner"> Dinner</label>
                                    <label><input type="checkbox" name="mealType[]" value="lunch"> Lunch</label>
                                    <label><input type="checkbox" name="mealType[]" value="snack"> Snack</label>
                                </div>
                            </div>
                        </div>

                        <!-- Style Filter -->
                        <div class="searchFilter">
                            <label for="style">Style</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label><input type="checkbox" name="style[]" value="asian"> Asian</label>
                                    <label><input type="checkbox" name="style[]" value="caribbean"> Caribbean</label>
                                    <label><input type="checkbox" name="style[]" value="fusion"> Fusion</label>
                                    <label><input type="checkbox" name="style[]" value="italian"> Italian</label>
                                    <label><input type="checkbox" name="style[]" value="latinAmerican"> Latin American</label>
                                    <label><input type="checkbox" name="style[]" value="mediterranean"> Mediterranean</label>
                                    <label><input type="checkbox" name="style[]" value="thai"> Thai</label>
                                </div>
                            </div>
                        </div>

                        <!-- Diet Filter -->
                        <div class="searchFilter">
                            <label for="diet">Diet</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label><input type="checkbox" name="diet[]" value="glutenFree"> Gluten-Free</label>
                                    <label><input type="checkbox" name="diet[]" value="keto"> Keto</label>
                                    <label><input type="checkbox" name="diet[]" value="low-carb"> Low Carb</label>
                                    <label><input type="checkbox" name="diet[]" value="paleo"> Paleo</label>
                                    <label><input type="checkbox" name="diet[]" value="sugarFree"> Sugar-Free</label>
                                    <label><input type="checkbox" name="diet[]" value="vegan"> Vegan</label>
                                    <label><input type="checkbox" name="diet[]" value="vegetarian"> Vegetarian</label>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="searchFilter">
                            <label for="rating">Difficulty</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label><input type="checkbox" name="difficulty[]" value="beginner">Beginner</label>
                                    <label><input type="checkbox" name="rating[]" value="intermediate">Intermediate</label>
                                    <label><input type="checkbox" name="rating[]" value="advanced"> Advanced</label>
                                </div>
                            </div>
                        </div>

                        <!-- Video Filter -->
                        <div class="searchFilter">
                            <label for="video">Video</label>
                            <div class="dropdown">
                                <button type="button" class="dropdown-button">ANY</button> <!-- Button says ANY -->
                                <div class="dropdown-content">
                                    <label><input type="checkbox" name="video[]" value="hasVideo"> Has YouTube Video</label>
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
                                    <label><input type="checkbox" name="sortBy[]" value="default">Newest</label>
                                    <label><input type="checkbox" name="sortBy[]" value="newest">Oldest</label>
                                    <label><input type="checkbox" name="sortBy[]" value="oldest">A-Z</label>
                                    <label><input type="checkbox" name="soryBy[]" value="ratingdesc">Rating: High to Low</label>
                                    <label><input type="checkbox" name="soryBy[]" value="ratingasc">Rating: Low to High</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="reset" class="searchReset">Reset</button>
                </div>
                </form>
        </div>