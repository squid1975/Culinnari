<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Recipes | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>


<main role="main" tabindex="-1">
        <section id="searchHero">
            <div id="heroText">
                <h2>Find your next feast.</h2>
            </div> 
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
    <?php include(SHARED_PATH . '/search.php');?>

    <div id="results">
        
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>