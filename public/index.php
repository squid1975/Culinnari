<?php require_once('../private/initialize.php');
$title = 'Home | Culinnari';
include SHARED_PATH . '/public_header.php';
// Suggestion sections 
$newRecipes = Recipe::find_newest_recipes();
$recipes_to_display = array_slice($newRecipes, 0, 4);
$beginnerRecipes = Recipe::find_beginner_recipes();
$displayBeginnerRecipes = array_slice($beginnerRecipes, 0, 4);
$highestRatedRecipes = Recipe::find_highest_rated_recipes();
$displayHighestRatedRecipes = array_slice($highestRatedRecipes, 0, 4);

?>

<main role="main" tabindex="-1">
    <div id="homePageWrapper">
        <section>
            <div id="homeHero">

                <div id="mainHeroText">
                    <h2>Search. Cook. Share. Enjoy.</h2>
                    <p>With simple, easy-to-read recipes, our goal is to make cooking focused on food again. No fluff,
                        just feasts.</p>
                    <a href="<?php echo url_for('/recipes.php'); ?>">
                        <img src="<?php echo url_for('/images/icon/search.svg'); ?>" width="20" height="20"
                            alt="Search icon">
                            Search All Recipes
                    </a>
                </div>
            </div>


            <div class="wrapper">

                <?php if (!$session->is_logged_in()): ?>
                    <section id="becomeMemberCTA">
                        <h2>Join the Culinnari Community!</h2>
                        <p>From secret family recipes to late-night snack hacks—this is your space to share, discover, and
                            save what you love.</p>
                        <div>
                            <div>
                                <img src="<?php echo url_for('/images/icon/pencil.svg'); ?>" width="33" height="33"
                                    alt="A pencil icon for writing recipes">
                                <h3>Create recipes</h3>
                                <p>Document your kitchen creations and inspire others by sharing your favorite recipes.</p>
                            </div>

                            <div>
                                <img src="<?php echo url_for('/images/icon/star.svg'); ?>" width="33" height="32"
                                    alt="A star icon meant for rating recipes">
                                <h3>Rate recipes</h3>
                                <p>Let others know what you think and help highlight the best recipes in the community.</p>
                            </div>

                            <div>
                                <img src="<?php echo url_for('/images/icon/notebook.svg'); ?>" width="33" height="33"
                                    alt="A cookbook icon">
                                <h3>Build your cookbook</h3>
                                <p>Save the recipes you love and create your own custom collection, always at your
                                    fingertips.</p>
                            </div>
                        </div>
                        <a class="primaryButton" href="<?php echo url_for('/login_signup.php'); ?>">Sign Up for FREE!</a>
                    </section>
                <?php endif; ?>

                <div class="dietKey">
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/glutenFree.svg" width="20" height="20" alt="gluten free icon"
                            title="Gluten free recipe icon">
                        <p>Gluten-Free</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/keto.svg" width="20" height="20" alt="keto icon"
                            title="Keto recipe icon">
                        <p>Keto</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/lowCarb.svg" width="20" height="20" alt="Low carb icon"
                            title="Low carb recipe icon">
                        <p>Low Carb</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/sugarFree.svg" width="20" height="20" alt="Sugar free icon"
                            title="Sugar free recipe icon">
                        <p>Sugar-Free</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/paleo.svg" width="20" height="20" alt="Paleo icon"
                            title="Paleo recipe icon">
                        <p>Paleo</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/vegan.svg" width="20" height="20" alt="Vegan icon"
                            title="Vegan recipe icon">
                        <p>Vegan</p>
                    </div>
                    <div class="dietIconWithName">
                        <img src="images/icon/dietIcons/vegetarian.svg" width="20" height="20" alt="Vegetarian icon"
                            title="Vegetarian recipe icon">
                        <p>Vegetarian</p>
                    </div>
                </div>

                <section class="suggestions">
                    <h2>Our Newest Treats</h2>
                    <div class="suggestionsContent">
                        <?php foreach ($recipes_to_display as $recipe): ?>
                            <?php include SHARED_PATH . '/recipe_card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="suggestions">
                    <h2>Highest Rated</h2>
                    <div class="suggestionsContent">
                        <?php foreach ($displayHighestRatedRecipes as $recipe): ?>
                            <?php include SHARED_PATH . '/recipe_card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="suggestions">
                    <h2>Beginner Friendly</h2>
                    <div class="suggestionsContent">
                        <?php foreach ($displayBeginnerRecipes as $recipe): ?>
                            <?php include SHARED_PATH . '/recipe_card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </section>


            </div>
    </div>
</main>
<?php include SHARED_PATH . '/public_footer.php'; ?>