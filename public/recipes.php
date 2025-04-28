<?php 
require_once('../private/initialize.php');
$title = 'Recipe Search | Culinnari';
include(SHARED_PATH . '/public_header.php');
$current_page = $_GET['page'] ?? 1;
$per_page = 12;

// Default values
$results = []; 
$searchMessage = '';
$searchQuery = '';
$mealTypes = [];
$styles = [];
$diets = [];
$difficulties = [];
$prepCookTimeTotals = [];
// Check if user actually searched for something
$hasSearch = isset($_GET['recipeQuery']) || 
             isset($_GET['mealTypes']) || 
             isset($_GET['styles']) || 
             isset($_GET['diets']) || 
             isset($_GET['prepCookTimeTotal']) || 
             isset($_GET['difficulty']);

if ($hasSearch) {
    // Get sanitized parameters
    $params = sanitize_search_params();

    // Perform search
    $results = Recipe::search_recipes(
        $params['searchQuery'],
        $params['prepCookTimeTotals'],
        $params['recipeDifficulty'],
        $params['mealTypes'],
        $params['styles'],
        $params['diets'],
        $params['sortBy']
    );

    if (!empty($results)) {
        $total_count = count($results);
        $searchMessage = 'Recipes (' . $total_count . ')';
        $pagination = new Pagination($current_page, $per_page, $total_count);
        $results = array_slice($results, $pagination->offset(), $per_page);
    } else {
        $searchMessage = 'No recipes found.';
    }

    // Build the pagination URL with all search parameters
    $pagination_url = url_for('/recipes.php') . '?' . build_query_string($params);

} else {
    // Default query - show all recipes
    $sql = "SELECT * FROM recipe ORDER BY recipe_post_date DESC";
    $allRecipes = Recipe::find_by_sql($sql); 
    $results = $allRecipes;
    $total_count = count($results);
    $searchMessage = 'All Recipes (' . $total_count . ')';
    $pagination = new Pagination($current_page, $per_page, $total_count);
    $results = array_slice($results, $pagination->offset(), $per_page);

    $pagination_url = url_for('/recipes.php');
}
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
                <img src="images/icon/dietIcons/glutenFree.svg" width="20" height="20" alt="gluten free icon">
                <p>Gluten-Free</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/keto.svg" width="20" height="20" alt="keto icon">
                <p>Keto</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/lowCarb.svg" width="20" height="20" alt="Low carb icon">   
                <p>Low Carb</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/sugarFree.svg" width="20" height="20" alt="Sugar free icon">
                <p>Sugar-Free</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/paleo.svg" width="20" height="20" alt="Paleo icon">
                <p>Paleo</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/vegan.svg" width="20" height="20" alt="Vegan icon">                      
                <p>Vegan</p>
        </div>
        <div class="dietIconWithName">
                <img src="images/icon/dietIcons/vegetarian.svg" width="20" height="20" alt="Vegetarian icon">
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
                    </div>
                    <?php if (isset($pagination) && $pagination->total_pages() > 1): ?>
                        <div class="pagination">
                        <?php echo $pagination->page_links($pagination_url); ?>
                        </div>
                    <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>