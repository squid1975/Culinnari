<?php 
require_once('../private/initialize.php');
$title = 'Recipe Search | Culinnari';
include(SHARED_PATH . '/public_header.php');
// Setup
$current_page = $_GET['page'] ?? 1;
$per_page = 12;

// Default values for search filters 
$results = []; 
$searchMessage = '';
$searchQuery = [];
$mealTypes = [];
$styles = [];
$diets = [];
$difficulties = [];
$prepCookTimeTotals = [];

// Determine if a search is being made
if (!empty($_GET)) {
    $searchQuery = $_GET['recipeQuery'] ?? '';
    $mealTypes = array_map('intval', $_GET['mealTypes'] ?? []);
    $styles = array_map('intval', $_GET['styles'] ?? []);
    $diets = array_map('intval', $_GET['diets'] ?? []);
    $prepCookTimeTotals = $_GET['prepCookTimeTotal'] ?? [];
    $recipeDifficulty = $_GET['difficulty'] ?? [];
    $sortBy = $_GET['sortBy'] ?? 'recipe[recipe_post_date] DESC';

    $results = Recipe::search_recipes($searchQuery, $prepCookTimeTotals, $recipeDifficulty, $mealTypes, $styles, $diets, $sortBy);
    
    if (!empty($results)) {
        $searchMessage = 'Recipes (' . count($results) . ')';
    } else {
        $searchMessage = 'No recipes found.';
    }
} else {
    // Default query (no search)
    $sql = "SELECT * FROM recipe ";
    $allRecipes = Recipe::find_by_sql($sql); 
    $results = $allRecipes;
    $searchMessage = 'All Recipes';
}

// Set up pagination *after* $results is defined
$total_count = count($results);
$pagination = new Pagination($current_page, $per_page, $total_count);
$results = array_slice($results, $pagination->offset(), $per_page);
?>


<script src="<?php echo url_for('/js/search.js'); ?>" defer></script>
<main role="main" tabindex="-1">
    <div id="searchPageWrapper">

    <section id="searchHero">
        <div id="heroText">
            <h2>Find your next feast.</h2>
                <p>Filter by meal types, styles, dietary needs and more to uncover your perfect recipe match.</p>
        </div>
            <?php include SHARED_PATH . '/recipe_search.php' ?>
        </section>
        
    <section>
    <h2 class="visuallyHidden">Diet Key</h2>
    <div class="dietKey">
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/glutenFree.svg" width="20" height="20" alt="gluten free icon"
                <p>Gluten-Free</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/keto.svg" width="20" height="20" alt="keto icon"
                <p>Keto</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/lowCarb.svg" width="20" height="20" alt="Low carb icon"   
                <p>Low Carb</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/sugarFree.svg" width="20" height="20" alt="Sugar free icon" 
                <p>Sugar-Free</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/paleo.svg" width="20" height="20" alt="Paleo icon"
                <p>Paleo</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/vegan.svg" width="20" height="20" alt="Vegan icon"                      
                <p>Vegan</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/vegetarian.svg" width="20" height="20" alt="Vegetarian icon"
                <p>Vegetarian</p>
        </div>
    </div>
    </section>

    <section>
            <div id="searchPageResultsWrapper">
                <h3 class="searchMessage"><?php echo $searchMessage; ?></h3>
                <div id="recipePagePosts">

                    <?php foreach ($results as $result): ?>
                        <?php $recipe = $result; ?>
                        <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                    <?php endforeach; ?>

                    <?php if ($pagination->total_pages() > 1): ?>
                        <div class="pagination">
                            <?php echo $pagination->page_links(url_for('/recipes.php')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>