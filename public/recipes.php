<?php 
require_once('../private/initialize.php');
$pageTitle = "Recipes | Culinnari";
include(SHARED_PATH . '/public_header.php');

$recipes = Recipe::find_all(); // Get all recipes first
$results = []; // Default results as an empty array

if (is_get_request()) {
    $searchQuery = isset($_GET['recipeQuery']) ? $_GET['recipeQuery'] : '';
    $mealTypes = isset($_GET['meal_types']) ? $_GET['meal_types'] : [];
    $styles = isset($_GET['styles']) ? $_GET['styles'] : [];
    $diets = isset($_GET['diets']) ? $_GET['diets'] : [];
    $difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : [];
    $prepCookTimeTotal = isset($_GET['prepCookTimeTotal']) ? $_GET['prepCookTimeTotal'] : [];
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'default';

    // Only run search if at least one filter is set
    if (!empty($searchQuery) || !empty($mealTypes) || !empty($styles) || !empty($diets) || !empty($difficulty)) {
        $query = "SELECT * FROM recipe WHERE 1";

        if (!empty($searchQuery)) {
            $query .= " AND (recipe_name LIKE '%" . $searchQuery . "%' OR recipe_description LIKE '%" . $searchQuery . "%')";
        }
        if (!empty($mealTypes)) {
            $query .= " AND recipe.id IN (SELECT recipe_id FROM recipe_meal_type WHERE meal_type_id IN (" . implode(",", $mealTypes) . "))";
        }
        if (!empty($styles)) {
            $query .= " AND recipe.id IN (SELECT recipe_id FROM recipe_style WHERE style_id IN (" . implode(",", $styles) . "))";
        }
        if (!empty($diets)) {
            $query .= " AND recipe.id IN (SELECT recipe_id FROM recipe_diet WHERE diet_id IN (" . implode(",", $diets) . "))";
        }
        if (!empty($difficulty)) {
            $query .= " AND recipe_difficulty IN ('" . implode("','", $difficulty) . "')";
        }

        switch ($sortBy) {
            case 'newest':
                $query .= " ORDER BY recipe_post_date DESC";
                break;
            case 'oldest':
                $query .= " ORDER BY recipe_post_date ASC";
                break;
            case 'ratingdesc':
                $query .= " ORDER BY rating DESC";
                break;
            case 'ratingasc':
                $query .= " ORDER BY rating ASC";
                break;
            default:
                $query .= " ORDER BY recipe_post_date DESC";
                break;
        }

        $results = Recipe::find_by_sql($query); // Only set results if a search is performed
    }
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
                        <?php foreach ($results as $result): ?>
                            <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                        <?php endforeach; ?>
                <?php else: ?>
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