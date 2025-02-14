<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Home | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>


<body>
    <main role="main" tabindex="-1">
        <section id="mainHero">
            <h2>Cook, Share, Enjoy</h2>
            <p>With simple, easy-to-read recipes, our goal  is to make cooking focused on food again. No fluff, just feasts.</p>
        </section>

        <section class="search">
            <h2>Search</h2>
            <form action="search_recipes.php" method="GET">
                <label for="search">Search:</label>
                <input type="text" id="search" name="recipeQuery" placeholder="Search.." required>

                <label for="mealType">Meal Type</label>
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle">Any</button>
                    <div class="dropdown-menu">
                        <label><input type="checkbox" name="mealType[]" value="appetizer"> Appetizer</label>
                        <label><input type="checkbox" name="mealType[]" value="breakfast"> Breakfast</label>
                        <label><input type="checkbox" name="mealType[]" value="brunch"> Brunch</label>
                        <label><input type="checkbox" name="mealType[]" value="dessert"> Dessert</label>
                        <label><input type="checkbox" name="mealType[]" value="dinner"> Dinner</label>
                        <label><input type="checkbox" name="mealType[]" value="lunch"> Lunch</label>
                        <label><input type="checkbox" name="mealType[]" value="snack"> Snack</label>
                    </div>
                </div>

                <label for="style">Style</label>
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle">Any</button>
                    <div class="dropdown-menu">
                        <label><input type="checkbox" name="style[]" value="asian"> Asian</label>
                        <label><input type="checkbox" name="style[]" value="caribbean"> Caribbean</label>
                        <label><input type="checkbox" name="style[]" value="fusion"> Fusion</label>
                        <label><input type="checkbox" name="style[]" value="italian"> Italian</label>
                        <label><input type="checkbox" name="style[]" value="latinAmerican"> Latin American</label>
                        <label><input type="checkbox" name="style[]" value="mediterranean"> Mediterranean</label>
                        <label><input type="checkbox" name="style[]" value="thai"> Thai</label>
                    </div>
                </div>

                <label for="diet">Diet</label>
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle">Any</button>
                    <div class="dropdown-menu">
                        <label><input type="checkbox" name="diet[]" value="glutenFree"> Gluten-Free</label>
                        <label><input type="checkbox" name="diet[]" value="keto"> Keto</label>
                        <label><input type="checkbox" name="diet[]" value="low-carb"> Low Carb</label>
                        <label><input type="checkbox" name="diet[]" value="paleo"> Paleo</label>
                        <label><input type="checkbox" name="diet[]" value="sugarFree"> Sugar-Free</label>
                        <label><input type="checkbox" name="diet[]" value="vegan"> Vegan</label>
                        <label><input type="checkbox" name="diet[]" value="vegetarian"> Vegetarian</label>
                    </div>
                </div>

                <label for="rating">Rating</label>
                <select id="rating" name="rating">
                    <option value="anyRating" selected>Any</option>
                    <option value="5stars">5 stars</option>
                    <option value="4stars">4 stars & up</option>
                    <option value="3stars">3 stars & up</option>
                    <option value="2stars">2 stars & up</option>
                    <option value="1star">1 star & up</option>
                </select>

                <label for="video">Video</label>
                <select id="video" name="video">
                    <option value="anyVideo" selected>Any</option>
                    <option value="hasVideo">Has YouTube Video</option>
                </select>

                <label for="prepCookTimeTotal">Total Time</label>
                <select id="prepCookTimeTotal" name="prepCookTimeTotal">
                    <option value="anyPrepCookTimeTotal" selected>Any</option>
                    <option value="max15Mins">15 minutes or less</option>
                    <option value="max30Mins">30 minutes or less</option>
                    <option value="max45mins">45 minutes or less</option>
                    <option value="oneTwoHours">1-2 hours</option>
                    <option value="moreThanTwoHours">More than 2 Hours</option>
                </select>

                <label for="sortBy">Sort By</label>
                <select id="sortBy" name="sortBy">
                    <option value="anySortBy" selected>Any</option>
                    <option value="date_desc">Newest</option>
                    <option value="date_asc">Oldest</option>
                    <option value="name_asc">Name Ascending (A-Z)</option>
                    <option value="name_desc">Name Descending (Z-A)</option>
                    <option value="rating_desc">Highest Rated</option>
                    <option value="rating_asc">Lowest Rated</option>
                </select>

                <button type="submit">Search</button>
            </form>
        </section>

        <section id="dietKey"
            <h2>Find what works for your diet.</h2>
            <div>
                <img src="#">
                <p>Gluten-Free</p>
            </div>
            <div>
                <img src="#">
                <p>Keto</p>
            </div>
            <div>
                <img src="#">
                <p>Low Carb</p>
            </div>
            <div>
                <img src="#">
                <p>Sugar-Free</p>
            </div>
            <div>
                <img src="#">
                <p>Paleo</p>
            </div>
            <div>
                <img src="#">
                <p>Vegan</p>
            </div>
            <div>
                <img src="#">
                <p>Vegetarian</p>
            </div>

        </section>

        <section class="bestRated">
            <div class="recipeCard">
                <img src="#">
                <h3>Recipe Name</h3>
                <div class="recipeDietTypes">
                    <img src="#">
                </div>
                <div class="recipeCardUserRating">
                    <a href="#">UserName</a>
                    <div class="rating-stars" data-rating="0">
                        ★★★★★
                    </div>
                </div>
            </div>

        </section>

        <section>
            <h2>Prep right for your next meal.</h2>
            <a href="#">Breakfast</a>
            <a href="#">Lunch</a>
            <a href="#">Dinner</a>
            <a href="#">Desserts</a>
        </section>
        <div>
            <section>
                <h2>Become a member today!</h2>
                <ul>
                    <li><img src="#"">Post your own recipes</li>
                    <li>Rate others recipes</li>
                    <li>Create cookbooks</li>
                </ul>
            </section>
        </div>
    </main>
</body>
</html>