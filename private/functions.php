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
 * @param string $string
 * @return string
 */
function u($string="") {
  return urlencode($string);
}

/**
 * Raw URL-encode a string (for path components).
 *
 * @param string $string
 * @return string
 */
function raw_u($string="") {
  return rawurlencode($string);
}

/**
 * Escape HTML characters in a string.
 *
 * @param string $string
 * @return string
 */
function h($string="") {
  return htmlspecialchars($string);
}

/**
 * Send a 404 Not Found header and terminate the script.
 *
 * @return void
 */
function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
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
 * @return bool
 */
function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Check if the current request is a GET request.
 *
 * @return bool
 */
function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

/**
 * Format a number into USD currency.
 *
 * @param string $format Ignored (for compatibility)
 * @param float $number Amount to format
 * @return string
 */
function money_format($format, $number) {
  return '$' . number_format($number, 2);
}

/**
 * Convert hours and minutes into total seconds.
 *
 * @param int $hours
 * @param int $minutes
 * @return int Total seconds
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
 * @param string $timestamp
 * @return string
 */
function formatDate($timestamp) {
  return date("m/d/Y", strtotime($timestamp));
}

/**
 * Convert a fraction or mixed number string to decimal.
 *
 * @param string $fraction
 * @return float|null
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
 * @param float|string $decimal
 * @return string
 */
function decimal_to_fraction($decimal) {
  if (!is_numeric($decimal)) return $decimal;

  $whole = floor($decimal);
  $fraction = $decimal - $whole;
  if ($fraction == 0) return (string) $whole;

  $denominator = 100;
  $numerator = round($fraction * $denominator);

  $gcd = gcd($numerator, $denominator);
  $numerator /= $gcd;
  $denominator /= $gcd;

  return $whole == 0 ? "$numerator/$denominator" : "$whole $numerator/$denominator";
}

/**
 * Calculate the greatest common divisor.
 *
 * @param int $a
 * @param int $b
 * @return int
 */
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
 * @param string $url
 * @return string|false Video ID or false if not found
 */
function extractYouTubeID($url) {
  preg_match('/(?:https?:\\/\\/)?(?:www\\.)?(?:youtube\\.com\\/(?:[^\\/\\n\\s]+\\/\\S+\\/|(?:v|e(?:mbed)?)\\/|\\S*?[?&]v=)|youtu\\.be\\/)([A-Za-z0-9_-]{11})/', $url, $matches);
  return isset($matches[1]) ? $matches[1] : false;
}

/**
 * Convert a YouTube video ID into an embed URL.
 *
 * @param string $videoID
 * @return string
 */
function convertToEmbedURL($videoID) {
  return "https://www.youtube.com/embed/$videoID";
}

/**
 * Convert a YouTube embed URL into a shareable watch link.
 *
 * @param string $embedUrl
 * @return string
 */
function embedToShareLink($embedUrl) {
  if (preg_match('/^https:\/\/www\.youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $embedUrl, $matches)) {
    return "https://www.youtube.com/watch?v=" . $matches[1];
  }
  return $embedUrl;
}
