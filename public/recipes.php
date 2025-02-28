<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Home | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php
$mealTypes = $_GET['mealType'] ?? [];
$styles = $_GET['style'] ?? [];
$diets = $_GET['diet'] ?? [];
$ratings = $_GET['rating'] ?? [];
$prepCookTimes = $_GET['prepCookTimeTotal'] ?? [];
$sortBy = $_GET['sortBy'] ?? 'newest';

$sql = "SELECT * FROM recipe WHERE recipe_name LIKE ?";
$params = ["%$recipeQuery%"]; // Default search term for recipe_name

// Filters for Meal Type
if (!empty($mealType)) {
    $mealTypeConditions = [];
    foreach ($mealType as $type) {
        $mealTypeConditions[] = "meal_type = '$type'";
    }
    $sql .= " AND (" . implode(" OR ", $mealTypeConditions) . ")";
}

// Filters for Style
if (!empty($style)) {
    $styleConditions = [];
    foreach ($style as $st) {
        $styleConditions[] = "style = '$st'";
    }
    $sql .= " AND (" . implode(" OR ", $styleConditions) . ")";
}

// Filters for Diet
if (!empty($diet)) {
    $dietConditions = [];
    foreach ($diet as $d) {
        $dietConditions[] = "diet = '$d'";
    }
    $sql .= " AND (" . implode(" OR ", $dietConditions) . ")";
}

// Filters for Rating
if (!empty($rating)) {
    $ratingConditions = [];
    foreach ($rating as $r) {
        switch ($r) {
            case '5stars':
                $ratingConditions[] = "rating >= 4.5";
                break;
            case '4stars':
                $ratingConditions[] = "rating >= 3.5";
                break;
            case '3stars':
                $ratingConditions[] = "rating >= 2.5";
                break;
            case '2stars':
                $ratingConditions[] = "rating >= 1.5";
                break;
            case '1star':
                $ratingConditions[] = "rating >= 0.5";
                break;
        }
    }
    $sql .= " AND (" . implode(" OR ", $ratingConditions) . ")";
}

// Filters for Video
if (!empty($video) && in_array('hasVideo', $video)) {
    $sql .= " AND video_url IS NOT NULL";
}

// Filters for Total Time
if (!empty($prepCookTimeTotal)) {
    $timeConditions = [];
    foreach ($prepCookTimeTotal as $time) {
        switch ($time) {
            case 'max15Mins':
                $timeConditions[] = "(prep_time_seconds + cook_time_seconds) <= 900"; // 15 minutes
                break;
            case 'max30Mins':
                $timeConditions[] = "(prep_time_seconds + cook_time_seconds) <= 1800"; // 30 minutes
                break;
            case 'max45mins':
                $timeConditions[] = "(prep_time_seconds + cook_time_seconds) <= 2700"; // 45 minutes
                break;
            case 'oneTwoHours':
                $timeConditions[] = "(prep_time_seconds + cook_time_seconds) BETWEEN 3600 AND 7200"; // 1-2 hours
                break;
            case 'moreThanTwoHours':
                $timeConditions[] = "(prep_time_seconds + cook_time_seconds) > 7200"; // 2+ hours
                break;
        }
    }
    $sql .= " AND (" . implode(" OR ", $timeConditions) . ")";
}

// Sorting options
if (!empty($sortBy)) {
    switch ($sortBy[0]) {
        case 'newest':
            $sql .= " ORDER BY recipe_post_date DESC";
            break;
        case 'oldest':
            $sql .= " ORDER BY recipe_post_date ASC";
            break;
        case 'default':
        default:
            $sql .= " ORDER BY recipe_name";
            break;
    }
}
?>

<main role="main" tabindex="-1">
        <section id="searchHero">
            <div>
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