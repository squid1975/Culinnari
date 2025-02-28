<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Recipe: Recipe Name | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<main role="main" tabindex="-1"
<img src="<?php echo url_for('/images/default_recipe_image.webp'); ?>">
<h2>Recipe Name</h2>
<div id="recipePageDisplayWrapper">
        <div id="recipeDisplayDietIcons">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/dietIcons/glutenFree.svg'); ?>">
        </div>
        <div id="recipeDisplayRatingStars">
            <img src="<?php echo url_for('/images/icon/star.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/star.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/star.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/star.svg'); ?>">
            <img src="<?php echo url_for('/images/icon/star.svg'); ?>">
        </div>
        <div id="recipeDisplayprepCook">
            <p>Prep Time: 15 Minutes</p>
            <p>Cook Time: 3 Hours</p>
        </div>
        <p id="recipeDisplayrecipeDescription">This gluten-free no-bake Oreo cheesecake features a crunchy Oreo crust, a creamy, smooth cheesecake filling, and a topping of crushed Oreos. Quick to make and perfect for any occasion, it's a delicious treat for those avoiding gluten!</p>
        <div id="recipeDisplayOptions">
            <a href="about:blank" onclick="window.print(); return false;">
                <img src="<?php echo url_for('/images/icon/print.svg'); ?>" width="24" height="24" alt="Printer icon" title="Print recipe">
                Print Recipe
            </a>
            <a href="#" ">
                <img src="<?php echo url_for('/images/icon/addToCookbook.svg'); ?>" width="24" height="24" alt="Printer icon" title="Print recipe">
                Add to Cookbook
            </a>
            <a href="#" ">
                <img src="<?php echo url_for('/images/icon/star.svg'); ?>" width="24" height="24" alt="Printer icon" title="Print recipe">
                Add Rating
            </a>
        </div>

        <div id="recipeDisplayIngredientsSteps">

            <div id="recipeDisplayIngredients">
                <h3>Ingredients</h3>
                <div id="recipeDisplayTotalServings">
                    <h4>Total Servings: 8</h4>
                    <div id="recipeDisplayChangeServingAmt">
                        <button>1/2</button>
                        <button>1x</button>
                        <button>2x</button>
                        <button>3x</button>
                    </div>
                </div>
                <ul>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                    <li><span>20</span> Eggs</li>
                </ul>
            </div>

            <div id="recipeDisplaySteps">
                <h3>Steps</h3>
                <ol>
                  <li> Prepare the crust: Crush the gluten-free Oreo cookies into fine crumbs using a food processor or by placing them in a sealed bag and crushing them with a rolling pin.</li>
                  <li>Mix the crumbs with the melted butter until combined.</li>
                  <li>Press the mixture into the bottom of a pie dish or spring-form pan to form a firm crust.</li>
                  <li>Place the crust in the fridge for 30 minutes to chill while making the filling. </li>
                  <li>In a large mixing bowl, combine the softened cream cheese with powdered sugar and vanilla extract until smooth and creamy. </li>
                  <li>In a separate bowl, whip the heavy cream until stiff peaks form.</li>
                  <li>Gently fold the whipped cream into the cream cheese mixture until fully combined. </li>
                  <li>Slowly stir in crushed gluten-free Oreo’s for added texture and flavor.</li>
                  <li>Remove the chilled pie crust from the fridge.</li>
                  <li>Pour the cheesecake filling over the chilled crust and smooth the top with a spatula. </li>
                  <li>Sprinkle crushed Oreo’s on top to garnish. </li>
                  <li>Refrigerate the cheesecake for at least 3 hours or more to set.</li>
                  <li>After the cheesecake is set, slice and serve chilled. </li>
                </ol>
            </div>

        </div>

        <div id="recipeDisplayYouTubeVideo">
            <h3>Watch YouTube Video</h3>
            <iframe width="420" height="315"
                src="https://www.youtube.com/embed/tgbNymZ7vqY">
            </iframe>
        </div>

    </div>


<?php include(SHARED_PATH . '/public_footer.php'); ?>