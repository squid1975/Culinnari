<title>Home | Culinnari</title>

<?php require_once('../private/initialize.php'); 
include SHARED_PATH . '/public_header.php'; 
$newRecipes = Recipe::find_newest_recipes();
$recipes_to_display = array_slice($newRecipes, 0, 4);
$beginnerRecipes = Recipe::find_beginner_recipes();
$displayBeginnerRecipes = array_slice($beginnerRecipes, 0, 4);
$quickRecipes = Recipe::find_quick_recipes();
$displayQuickRecipes = array_slice($quickRecipes, 0, 4);

?>


<body>
    <main role="main" tabindex="-1">
        <div id="homePageWrapper">
            <div id="homeHero">
                <div id ="mainHeroText">
                    <h2>Cook. Share. Enjoy.</h2>
                    <p>With simple, easy-to-read recipes, our goal is to make cooking focused on food again. No fluff, just feasts.</p>
                </div>
            </div> 
            
            <div id="wrapper">
                    <?php include SHARED_PATH .'/recipe_search.php'; ?>
                    
                    <?php if(!$session->is_logged_in()): ?>
                    <section id="becomeMemberCTA">
                        <h2>Become a Culinnari Community Member!</h2>
                        <div>
                            <div>
                                <img src="<?php echo url_for('/images/icon/pencil.svg');?>" width="33" height="33" alt="A pencil icon for writing recipes">
                                <h3>Create recipes</h3>
                                <p>Post and share your recipes.</p>
                            </div>

                            <div>
                                <img src="<?php echo url_for('/images/icon/star.svg');?>" width="33" height="32" alt="A star icon meant for rating recipes">
                                <h3>Rate recipes</h3>
                                <p>Rate the recipes you make!</p>
                            </div>

                            <div>
                                <img src="<?php echo url_for('/images/icon/notebook.svg');?>" width="33" height="33" alt="A cookbook icon">
                                <h3>Build your cookbook</h3>
                                <p>Save recipes you love to your cookbook.</p>
                            </div>
                        </div>
                        <a class="primaryButton"href="<?php echo url_for('/login_signup.php');?>">Sign Up Today!</a>
                    </section>
                    <?php endif; ?>

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

                    <section class="suggestions">
                        <h2>Our Newest Treats</h2>
                        <div class="suggestionsContent">
                            <?php foreach($recipes_to_display as $recipe): ?>
                                <?php include SHARED_PATH. '/recipe_card.php'; ?>
                            <?php endforeach; ?>   
                        </div>
                    </section>

                <section class="suggestions">
                    <h2>Beginner-Friendly</h2>
                    <div class="suggestionsContent">
                        <?php foreach($displayBeginnerRecipes as $recipe): ?>
                            <?php include SHARED_PATH. '/recipe_card.php'; ?>
                        <?php endforeach; ?>   
                    </div>
                </section>          
            </div>
        </div>
    </main>
<?php include SHARED_PATH . '/public_footer.php'; ?>
</body>
</html>
