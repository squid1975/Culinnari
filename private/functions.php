<?php

/**
 * Generate a URL relative to the website root.
 *
 * @param string $script_path Relative path to the script
 * @return string Full URL path
 */
function url_for($script_path) {
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

/**
 * URL-encode a string.
 *
 * @param string $string The string to encode
 * @return string Encoded string
 */
function u($string="") {
  return urlencode($string);
}

/**
 * Raw URL-encode a string (for path components).
 *
 * @param string $string The string to encode
 * @return string Encoded string
 */
function raw_u($string="") {
  return rawurlencode($string);
}

/**
 * Escape HTML characters in a string.
 *
 * @param string $string The string to escape
 * @return string Escaped string
 */
function h($string="") {
  return htmlspecialchars($string);
}

/**
 * Send a 404 Not Found header and terminate the script.
 *
 * @return void If the script is not found, this function sends a 404 header and exits
 */
function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  redirect_to(url_for('/404.php'));
  exit();
}

/**
 * Send a 500 Internal Server Error header and terminate the script.
 *
 * @return void
 */
function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

/**
 * Redirect the user to a new location.
 *
 * @param string $location URL to redirect to
 * @return void
 */
function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

/**
 * Check if the current request is a POST request.
 *
 * @return bool True if the request method is POST, false otherwise
 */
function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Check if the current request is a GET request.
 *
 * @return bool True if the request method is GET, false otherwise
 */
function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}


/**
 * Convert hours and minutes into total seconds.
 *
 * @param int $hours The number of hours 
 * @param int $minutes The number of minutes
 * @return int Hour plus minute value converted to seconds
 */
function timeToSeconds($hours, $minutes){
  return ($hours * 3600) + ($minutes * 60);
}

/**
 * Convert seconds into a human-readable hours and minutes string.
 *
 * @param int $seconds
 * @return string
 */
function convertSeconds($seconds) {
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds % 3600) / 60);
  return "{$hours} hours and {$minutes} minutes";
}

/**
 * Format a timestamp as MM/DD/YYYY.
 *
 * @param string $timestamp The timestamp to format 
 * @return string Formatted date string
 */
function formatDate($timestamp) {
  return date("m/d/Y", strtotime($timestamp));
}

/**
 * Convert a fraction or mixed number string to decimal.
 *
 * @param string $fraction The fraction or mixed number string to convert
 * @return float|null The decimal representation of the fraction 
 */
function fractionToDecimal($fraction) {
  $fraction = trim($fraction);
  if ($fraction === '') return null;
  if (is_numeric($fraction)) return round((float) $fraction, 2);

  if (preg_match('/^(\d+)\s+(\d+)\/(\d+)$/', $fraction, $matches)) {
    $wholeNumber = (int) $matches[1];
    $numerator = (int) $matches[2];
    $denominator = (int) $matches[3];
    if ($denominator == 0) return null;
    return round($wholeNumber + ($numerator / $denominator), 2);
  }

  if (preg_match('/^(\d+)\/(\d+)$/', $fraction, $matches)) {
    $numerator = (int) $matches[1];
    $denominator = (int) $matches[2];
    if ($denominator == 0) return null;
    return round($numerator / $denominator, 2);
  }

  return null;
}

/**
 * Convert a decimal number into a simplified fraction or mixed number.
 *
 * @param float|string $decimal The decimal number to convert
 * @return string The fraction or mixed number representation of the decimal
 */
function decimal_to_fraction($decimal) {
  if (!is_numeric($decimal)) return $decimal;

  $whole = floor($decimal);
  $fraction = $decimal - $whole;

  // Handle exact whole numbers
  if ($fraction == 0) return (string) $whole;

  // Snap to common kitchen fractions if close enough
  $common_fractions = [
    '0.125' => '1/8',
    '0.25'  => '1/4',
    '0.333' => '1/3',
    '0.5'   => '1/2',
    '0.666' => '2/3',
    '0.75'  => '3/4',
    '0.875' => '7/8'
  ];

  foreach ($common_fractions as $dec => $frac) {
    if (abs($fraction - (float)$dec) < 0.02) {
      return $whole == 0 ? $frac : "$whole $frac";
    }
  }

  // Fallback to actual GCD simplification
  $denominator = 100;
  $numerator = round($fraction * $denominator);

  $gcd = gcd($numerator, $denominator);
  $numerator = (int)($numerator / $gcd);
  $denominator = (int)($denominator / $gcd);

  return $whole == 0 ? "$numerator/$denominator" : "$whole $numerator/$denominator";
}

function gcd($a, $b) {
  while ($b != 0) {
    $temp = $b;
    $b = $a % $b;
    $a = $temp;
  }
  return $a;
}
/**
 * Extract the YouTube video ID from a given URL.
 *
 * @param string $url The YouTube URL to extract the ID from
 * @return string|false Video ID or false if not found
 */
function extractYouTubeID($url) {
  preg_match('/(?:https?:\\/\\/)?(?:www\\.)?(?:youtube\\.com\\/(?:[^\\/\\n\\s]+\\/\\S+\\/|(?:v|e(?:mbed)?)\\/|\\S*?[?&]v=)|youtu\\.be\\/)([A-Za-z0-9_-]{11})/', $url, $matches);
  return isset($matches[1]) ? $matches[1] : false;
}

/**
 * Convert a YouTube video ID into an embed URL.
 *
 * @param string $videoID The YouTube video ID to convert 
 * @return string The YouTube embed URL
 */
function convertToEmbedURL($videoID) {
  return "https://www.youtube.com/embed/$videoID";
}

/**
 * Convert a YouTube embed URL into a shareable watch link.
 *
 * @param string $embedUrl The YouTube embed URL
 * @return string The shareable watch link / original URL 
 */
function embedToShareLink($embedUrl) {
  if (preg_match('/^https:\/\/www\.youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $embedUrl, $matches)) {
    return "https://www.youtube.com/watch?v=" . $matches[1];
  }
  return $embedUrl;
}

/**
 * Sanitize and assign values from the search parameters in the query string.
 *
 * This function retrieves various search-related parameters from the URL's query string, sanitizes them to prevent security vulnerabilities (such as XSS or SQL injection), 
 * and returns them in a structured format. It ensures that array-type parameters (like `mealTypes[]`, `styles[]`, etc.) are properly sanitized and integers where necessary. 
 * The function also validates the `sortBy` parameter against a predefined list of valid sorting options.
 *
 * @return array An associative array containing the sanitized search parameters:
 * - 'searchQuery' (string): The sanitized recipe search query.
 * - 'mealTypes' (array of integers): The sanitized array of selected meal types.
 * - 'styles' (array of integers): The sanitized array of selected styles.
 * - 'diets' (array of integers): The sanitized array of selected diets.
 * - 'prepCookTimeTotals' (array of integers): The sanitized array of selected prep and cook time totals.
 * - 'recipeDifficulty' (array of strings): The sanitized array of selected difficulty levels.
 * - 'sortBy' (string): The sanitized and validated sort option.
 *
 * @example
 * $params = sanitize_search_params();
 * // Returns sanitized and validated parameters for search functionality
 */
function sanitize_search_params() {
  $searchQuery = isset($_GET['recipeQuery']) ? h($_GET['recipeQuery']) : '';
  $mealTypes = isset($_GET['mealTypes']) ? array_map('intval', $_GET['mealTypes']) : [];
  $styles = isset($_GET['styles']) ? array_map('intval', $_GET['styles']) : [];
  $diets = isset($_GET['diets']) ? array_map('intval', $_GET['diets']) : [];
  $prepCookTimeTotals = isset($_GET['prepCookTimeTotal']) ? array_map('intval', $_GET['prepCookTimeTotal']) : [];
  $recipeDifficulty = isset($_GET['difficulty']) ? array_map('htmlspecialchars', $_GET['difficulty']) : [];

  $validSortOptions = [
      'recipe[recipe_post_date] DESC',
      'recipe[recipe_post_date] ASC',
      'recipe[recipe_name] ASC',
      'rating[rating_value] DESC',
      'rating[rating_value] ASC',
  ];
  $sortBy = (isset($_GET['sortBy']) && in_array($_GET['sortBy'], $validSortOptions)) ? $_GET['sortBy'] : 'recipe[recipe_post_date] DESC';

  return compact('searchQuery', 'mealTypes', 'styles', 'diets', 'prepCookTimeTotals', 'recipeDifficulty', 'sortBy');
}

/**
 * Build a query string from an associative array of parameters.
 *
 * This function takes an associative array of parameters, sanitizes and encodes the values, 
 * and builds a query string that can be appended to a URL for use in a GET request.
 * It handles multiple array-type parameters (such as `mealTypes[]`), sanitizing each value 
 * to prevent XSS and URL-encoding them properly.
 * 
 * @param array $params The associative array containing the parameters to include in the query string.
 * The array can include:
 * - 'searchQuery' (string): The search query to filter recipes.
 * - 'mealTypes' (array of integers): An array of selected meal types.
 * - 'styles' (array of integers): An array of selected styles.
 * - 'diets' (array of integers): An array of selected diets.
 * - 'prepCookTimeTotals' (array of integers): An array of selected prep and cook time ranges.
 * - 'recipeDifficulty' (array of strings): An array of selected recipe difficulty levels.
 * - 'sortBy' (string): The sorting option for the query.
 * 
 * @return string A query string with properly encoded parameters, ready to be appended to a URL.
 * 
 * @example
 * $params = [
 *     'searchQuery' => 'chicken',
 *     'mealTypes' => [3, 4],
 *     'sortBy' => 'recipe[recipe_post_date] DESC'
 * ];
 * $query_string = build_query_string($params);
 * // Output: "recipeQuery=chicken&mealTypes[]=3&mealTypes[]=4&sortBy=recipe%5Brecipe_post_date%5D+DESC"
 */
function build_query_string($params) {
  $query_parts = [];

  if (!empty($params['searchQuery'])) {
      $query_parts[] = 'recipeQuery=' . h(u($params['searchQuery']));
  }

  foreach (['mealTypes', 'styles', 'diets', 'prepCookTimeTotals', 'recipeDifficulty'] as $arrayParam) {
      if (!empty($params[$arrayParam])) {
          foreach ($params[$arrayParam] as $value) {
              $paramName = $arrayParam === 'prepCookTimeTotals' ? 'prepCookTimeTotal' : $arrayParam;
              $query_parts[] = $paramName . '[]=' . h(u($value));
          }
      }
  }

  if (!empty($params['sortBy'])) {
      $query_parts[] = 'sortBy=' . h(u($params['sortBy']));
  }

  return implode('&', $query_parts);
}