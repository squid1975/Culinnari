<?php require_once('../private/initialize.php'); 
 $pageTitle = "Recipes | Culinnari"; 
 include(SHARED_PATH . '/public_header.php'); 


 $filters=[];

 // Get all the values from the form (via the GET method)
 $filters = [
    'keyword' => $_GET['recipeQuery'] ?? null,
    'mealType' => $_GET['mealType'] ?? null,
    'style' => $_GET['style'] ?? null,
    'diet' => $_GET['diet'] ?? null,
    'difficulty' => $_GET['difficulty'] ?? null,
    'video' => $_GET['video'] ?? null,
    'prepCookTimeTotal' => $_GET['prepCookTimeTotal'] ?? null,
    'sortBy' => $_GET['sortBy'] ?? null
];


?>

<main role="main" tabindex="-1">
        <section id="searchHero">
            <div id="heroText">
                <h2>Find your next feast.</h2>
            </div> 
            <?php include SHARED_PATH .'/recipe_search.php' ?>
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
                

    <?php if (!empty($results)): ?>
    <div id="results">
        <h3>Results</h3>
        <?php foreach ($results as $result): ?>
            <?php include(SHARED_PATH . '/recipe_card.php'); ?>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <?php $allRecipes = DatabaseObject::find_by_sql("SELECT * FROM recipe"); ?>
    <div id="allRecipes">
        <h3>All Recipes</h3>
       
            <?php foreach ($allrecipes as $allrecipe): ?>
                <?php include(SHARED_PATH . '/recipe_card.php'); ?>
            <?php endforeach; ?>
       
    </div>
<?php endif; ?>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>