<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Home | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>


<body>
    <main role="main" tabindex="-1">
        <div id="homeHero">
            <section id="mainHero">
                <div id="heroText">
                    <h2>Cook. Share. Enjoy.</h2>
                    <p>With simple, easy-to-read recipes, our goal  is to make cooking focused on food again. No fluff, just feasts.</p>
                </div>
            </section>
        </div>  

        <?php include(SHARED_PATH . '/search.php');?>

        <div id="wrapper">
            <section>
                <h2>Find what works for your diet.</h2>
                <p>All of our recipes feature color-coded diet icons to help you quickly identify meals that fit your lifestyle. Whether you're looking for vegan, gluten-free, keto, or other dietary preferences, our easy-to-read key ensures you can make informed choices at a glance.</p>
                <div class="dietKey">
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/glutenFree.svg" width="20" height="20" alt="gluten free icon" title="Gluten free recipe icon">
                        <p>Gluten-Free</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/keto.svg" width="20" height="20" alt="keto icon" title="Keto recipe icon">
                        <p>Keto</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/lowCarb.svg" width="20" height="20" alt="Low carb icon" title="Low carb recipe icon">
                        <p>Low Carb</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/sugarFree.svg" width="20" height="20" alt="Sugar free icon" title="Sugar free recipe icon">
                        <p>Sugar-Free</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/paleo.svg" width="20" height="20" alt="Paleo icon" title="Paleo recipe icon">
                        <p>Paleo</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/vegan.svg" width="20" height="20"  alt="Vegan icon" title="Vegan recipe icon">
                        <p>Vegan</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/vegetarian.svg" width="20"  height="20" alt="Vegetarian icon" title="Vegetarian recipe icon">
                        <p>Vegetarian</p>
                    </div>
                </div>
            </section>

            <section class="bestRated">
                <h2>Rated best by our users</h2>
                <div class="recipeCardDisplay">
                    
                </div>


            </section>
            <div id="suggestionsContent">
                <section>
                    <h2>Prep right for your next meal.</h2>
                    <div id="homeMealTypeSuggestions">
                        <a href="#" class="homeSectionButton">Breakfast</a>
                        <a href="#" class="homeSectionButton">Lunch</a>
                        <a href="#" class="homeSectionButton">Dinner</a>
                        <a href="#" class="homeSectionButton">Desserts</a>
                    </div>
                </section>
                <div>
                <section id="ctaPublic">
                    <h2>Become a member today!</h2>
                        <ul>
                            <li><img src="images/icon/pencil.svg" width="20" height="20" alt="A pencil icon" title="Pencil for writing your own recipes">Post your own recipes</li>
                            <li><img src="images/icon/star.svg" width="20" height="20" alt="A star icon" title="Star rating for recipes">Rate others recipes</li>
                            <li><img src="images/icon/notebook.svg" width="20" height="20" alt="A cookbook notebook icon" title="Cookbook notebook for saving recipes">Create cookbooks</li>
                        </ul>
                        <a href="login_signup.php" class="primaryButton">SIGN UP FOR FREE!</a>
                </section>
            </div>
            </div>
        </div>
    </main>
    <?php include(SHARED_PATH . '/public_footer.php'); ?>
</body>
</html>
