<?php 
require_once('../private/initialize.php');
$pageTitle = "Recipes | Culinnari";
include(SHARED_PATH . '/public_header.php');

$recipes = Recipe::find_all(); // Get all recipes first
$results = []; // Default results as an empty array
$searchMessage = '';
$searchQuery = [];
$mealTypes = [];
$styles = [];
$diets = [];
$difficulties = [];
$prepCookTimeTotals = [];
if (is_get_request()){
    $searchQuery = $_GET['recipeQuery'] ?? '';
    $mealTypes = $_GET['mealTypes'] ?? [];
    $styles = $_GET['styles'] ?? [];
    $diets = $_GET['diets'] ?? [];
    $prepCookTimeTotals = $_GET['prepCookTimeTotal'] ?? [];
    $recipeDifficulty = $_GET['difficulty'] ?? [];
    var_dump($searchQuery);
    var_dump($mealTypes);
    var_dump($styles);
    var_dump($diets);
    var_dump($prepCookTimeTotals);
    var_dump($recipeDifficulty);
    var_dump($results);
    
    // $results = Recipe::search_recipes($searchQuery, $prepCookTimeTotals, $recipeDifficulty, $mealTypes, $styles, $diets);
    // if(!empty($results)){
    //     $searchMessage = "Results";
    // } else {
    //     $searchMessage = "No results found. Please try again.";
    // }
}
    

?>

<body>
<main role="main" tabindex="-1">
    <div id="searchPageWrapper">
    <section id="searchHero">
        <div id="heroText">
            <h2>Find your next feast.</h2>
        </div>
        <?php include SHARED_PATH .'/recipe_search.php' ?>
    </section>
    <section>
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
        <div id="searchPageResultsWrapper">        
            <div id="recipePagePosts">
                <?php if (!empty($results)): ?>
                    <h3 class="searchMessage"><?php echo $searchMessage; ?></h3>
                    <div id="allRecipes">
                    <?php foreach ($results as $result): ?>
                        <?php 
                            $recipe = $result;
                            include(SHARED_PATH . '/recipe_card.php'); 
                        ?>
                    <?php endforeach; ?>  <!-- ✅ Correctly closing the foreach loop -->
                    </div>
                <?php else: ?>
                    <h3 class="searchMessage"><?php echo $searchMessage; ?></h3>
                    <div id="allRecipes">
                        <?php foreach ($recipes as $recipe): ?>
                            <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
</body>